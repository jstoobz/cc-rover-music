const gulp = require('gulp');
const gulpLoadPlugins = require('gulp-load-plugins');
const plugins = gulpLoadPlugins({
    pattern: ['gulp-*', 'gulp.*', 'autoprefixer', 'browser-sync', 'cssnano', 'css-mqpacker', 'del', 'fs', 'postcss-assets', 'run-sequence']
});

const themeName = 'ccrovermusic';
const themePackage = 'CC Rover Music';
const themeURL = 'ccrovermusic.local';

let sassStyle;

const env = process.env.NODE_ENV || 'development';

const dir = {
    src: 'assets/',
    build: '../2.\ Development/' + themeName + '/wp-content/themes/' + themeName + '/',
    prod: '../1.\ Production/' + themePackage + '/' + themeName + '/',
    prodZip: '../1.\ Production/' + themePackage + '/',
};

const php = {
    src: dir.src + 'template/**/*.php',
    build: dir.build,
    prod: dir.prod,
};

const images = {
    src: dir.src + 'images/**/*.{jpg,JPG,png,svg}',
    build: dir.build,
    prod: dir.prod,
    imagesOpts: [
        plugins.imagemin.gifsicle({interlaced: true}),
        plugins.imagemin.jpegtran({progressive: true}),
        plugins.imagemin.optipng({optimizationLevel: 5}),
        plugins.imagemin.svgo({plugins:[{removeViewBox: true}]})
    ],
};

const sass = {
    src: dir.src + 'sass/style.scss',
    watch: dir.src + 'sass/**/*',
    build: dir.build,
    prod: dir.prod,
    sassOpts: {
        outputStyle: sassStyle,
        imagePath: images.build,
        indentType: 'tab',
        indentWidth: '1',
        precision: 10,
        errLogToConsole: true,
    },
    postcssOpts: [
        plugins.postcssAssets({
            loadPaths: [images.build],
            basePath: dir.build,
            baseUrl: '/wp-content/themes/' + themeName + '/',
        }),
        plugins.autoprefixer()
    ],
    rtl: {
        basename: 'rtl',
    }
};

const js = {
    src: dir.src + 'js/**/*.js',
    build: dir.build + 'js',
    prod: dir.prod + 'js',
    filename: 'bundle.js',
    suffix: {
        suffix: '.min',
    }
};

const readMe = {
    src: dir.src + 'README.md',
    build: dir.build,
    prod: dir.prod,
};

const languages = {
    src: php.src,
    build: dir.build + 'languages/',
    prod: dir.prod + 'languages/',
    languagesOpts: {
        domain: themeName,
        destFile: themeName + '.pot',
        package: themePackage,
        bugReport: 'https://jstoobz.com/contact/',
        lastTranslator: 'James Stephens <james@jstoobz.com>',
        team: 'James Stephens <james@jstoobz.com>',
    },
};

const favicon = {
    src: dir.src + 'favicon/favicon.png',
    build: dir.build + 'images/favicon/',
    prod: dir.prod + 'images/favicon/',
    FAVICON_DATA_FILE: dir.src + '/favicon/faviconData.json',
};

const bsync = {
    bsyncOpts: {
        proxy: 'http://' + themeURL + '/',
        host: themeURL,
        files: dir.build + '**/*',
        open: 'external',
        notify: false,
        injectChanges: true,
        watchOptions: {
            debounceDelay: 2000,
        },
        ui: {
            port: 8001,
        },
        snippetOptions: {
            whitelist: ['/wp-admin/admin-ajax.php'],
            blacklist: ['wp-admin/**'],
        }
    }
};

const lineec = {
    lineecOpts: {
        verbose: true,
        eolc: 'LF',
        encoding: 'utf8',
    }
};

if (env === 'development') {
    sassStyle = 'expanded';
} else {
    sassStyle = 'compressed';
    sass.postcssOpts.push(plugins.cssMqpacker);
    sass.postcssOpts.push(plugins.cssnano());
}

/****************************************************************************/

gulp.task('php', () => {
    const s = plugins.size();
    return gulp.src(php.src)
        .pipe(s)
        .pipe(plugins.if(env === 'development', plugins.newer(php.build)))
        .pipe(plugins.if(env === 'development', gulp.dest(php.build)))
        .pipe(plugins.if(env === 'production', gulp.dest(php.prod)))
        .pipe(plugins.browserSync.reload({stream: true}))
        .pipe(plugins.notify({onLast: true, message: () => `php compiled! ${s.prettySize}`}))
});

gulp.task('images', () => {
    const s = plugins.size();
    return gulp.src(images.src)
        .pipe(s)
        .pipe(plugins.if(env === 'development', plugins.newer(images.build)))
        .pipe(plugins.if(env === 'development', gulp.dest(images.build)))
        .pipe(plugins.if(env === 'production', plugins.newer(images.build))) // maybe remove?
        .pipe(plugins.if(env === 'production', plugins.imagemin(images.imagesOpts)))
        .pipe(plugins.if(env === 'production', gulp.dest(images.prod)))
        .pipe(plugins.browserSync.reload({stream: true}))
        .pipe(plugins.notify({onLast: true, message: () => `images compiled! ${s.prettySize}`}))
});

gulp.task('sass', ['images'], () => {
    const s = plugins.size()
    return gulp.src(sass.src)
        .pipe(s)
        .pipe(plugins.if(env === 'development', plugins.sourcemaps.init()))
        .pipe(plugins.sass(sass.sassOpts).on('error', plugins.sass.logError))
        .pipe(plugins.postcss(sass.postcssOpts))
        .pipe(plugins.if(env === 'development', plugins.sourcemaps.write()))
        .pipe(plugins.lineEndingCorrector(lineec.lineecOpts))
        .pipe(plugins.if(env === 'development', gulp.dest(sass.build)))
        .pipe(plugins.if(env === 'production', gulp.dest(sass.prod)))
        .pipe(plugins.rtlcss())
        .pipe(plugins.rename(sass.rtl))
        .pipe(plugins.lineEndingCorrector(lineec.lineecOpts))
        .pipe(plugins.if(env === 'development', gulp.dest(sass.build)))
        .pipe(plugins.if(env === 'production', gulp.dest(sass.prod)))
        .pipe(plugins.browserSync.reload({stream: true}))
        .pipe(plugins.notify({onLast: true, message: () => `sass compiled! ${s.prettySize}`}))
});

gulp.task('js', () => {
    const s = plugins.size();
    return gulp.src(js.src)
        .pipe(s)
        .pipe(plugins.if(env === 'development', plugins.sourcemaps.init()))
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))
        .pipe(plugins.babel({ presets: ['env'] }))
        .pipe(plugins.concat(js.filename))
        .pipe(plugins.if(env === 'production', plugins.rename(js.suffix)))
        .pipe(plugins.if(env === 'production', plugins.stripDebug()))
        .pipe(plugins.if(env === 'production', plugins.uglify()))
        .pipe(plugins.if(env === 'development', plugins.sourcemaps.write()))
        .pipe(plugins.lineEndingCorrector(lineec.lineecOpts))
        .pipe(plugins.if(env === 'development', gulp.dest(js.build)))
        .pipe(plugins.if(env === 'production', gulp.dest(js.prod)))
        .pipe(plugins.browserSync.reload({stream: true}))
        .pipe(plugins.notify({onLast: true, message: () => `js compiled! ${s.prettySize}`}))
});

gulp.task('readme', () => {
    const s = plugins.size();
    return gulp.src(readMe.src)
        .pipe(plugins.if(env === 'development', gulp.dest(readMe.build)))
        .pipe(plugins.if(env === 'production', gulp.dest(readMe.prod)))
        .pipe(plugins.notify({onLast: true, message: () => `readme compiled! ${s.prettySize}`}))
});

gulp.task('translate', () => {
    const s = plugins.size();
    return gulp.src(php.src)
        .pipe(s)
        .pipe(plugins.sort())
        .pipe(plugins.wpPot(languages.languagesOpts))
        .pipe(plugins.lineEndingCorrector(lineec.lineecOpts))
        .pipe(plugins.if(env === 'development', gulp.dest(languages.build + languages.languagesOpts.destFile)))
        .pipe(plugins.if(env === 'production', gulp.dest(languages.prod + languages.languagesOpts.destFile)))
        .pipe(plugins.notify({onLast: true, message: () => `wp pot translation compiled! ${s.prettySize}`}))
});

gulp.task('generate-favicon', (done) => {
    plugins.realFavicon.generateFavicon({
        masterPicture: favicon.src,
        dest: favicon.prod,
        iconsPath: favicon.prod,
        design: {
            ios: {
                pictureAspect: 'noChange',
                assets: {
                    ios6AndPriorIcons: false,
                    ios7AndLaterIcons: false,
                    precomposedIcons: false,
                    declareOnlyDefaultIcon: true
                }
            },
            desktopBrowser: {},
            windows: {
                pictureAspect: 'noChange',
                backgroundColor: '#000000',
                onConflict: 'override',
                assets: {
                    windows80Ie10Tile: false,
                    windows10Ie11EdgeTiles: {
                        small: false,
                        medium: true,
                        big: false,
                        rectangle: false
                    }
                }
            },
            androidChrome: {
                pictureAspect: 'backgroundAndMargin',
                margin: '17%',
                backgroundColor: '#000000',
                themeColor: '#000000',
                manifest: {
                    name: themePackage,
                    display: 'standalone',
                    orientation: 'notSet',
                    onConflict: 'override',
                    declared: true
                },
                assets: {
                    legacyIcon: false,
                    lowResolutionIcons: false
                }
            },
            safariPinnedTab: {
                pictureAspect: 'silhouette',
                themeColor: '#000000'
            }
        },
        settings: {
            scalingAlgorithm: 'Mitchell',
            errorOnImageTooSmall: false,
            readmeFile: false,
            htmlCodeFile: false,
            usePathAsIs: false
        },
        markupFile: favicon.FAVICON_DATA_FILE
    }, () => {
        done();
    });
});

gulp.task('check-for-favicon-update', (done) => {
    let currentVersion = JSON.parse(plugins.fs.readFileSync(favicon.FAVICON_DATA_FILE)).version;
    plugins.realFavicon.checkForUpdates(currentVersion, (err) => {
        if (err) throw err;
    });
});

gulp.task('browser-sync', () => {
    plugins.browserSync.init(bsync.bsyncOpts)
});

gulp.task('watch', ['browser-sync'], () => {
    gulp.watch(php.src, ['php']);
    gulp.watch(images.src, ['images']);
    gulp.watch(sass.watch, ['sass']);
    gulp.watch(js.src, ['js']);
    gulp.watch(favicon.src, ['generate-favicon']);
});

gulp.task('default', (cb) => {
    plugins.runSequence(
        'build',
        'watch',
        cb
    )
});

gulp.task('build', ['php', 'sass', 'js', 'readme', 'translate', 'generate-favicon']);

gulp.task('build:dev', (cb) => {
    plugins.runSequence(
        'clean:dev',
        'build',
        cb
    )
});

gulp.task('clean:dev', () => {
    return plugins.del.sync(dir.build + '**', {force: true})
});

gulp.task('build:prod', (cb) => {
    plugins.runSequence(
        'clean:prod',
        'build',
        cb
    )
});

gulp.task('clean:prod', () => {
    return plugins.del.sync(dir.prod + '../../' + themePackage, {force: true})
});

gulp.task('zip:prod', () => {
    gulp.src(dir.prod + '**')
        .pipe(plugins.zip(themeName + '.zip'))
        .pipe(gulp.dest(dir.prodZip))
});

gulp.task('clean:prodzip', () => {
    return plugins.del.sync([dir.prod + '**', '!' + dir.prod + '/' + themeName + '.zip'], {force: true})
});
