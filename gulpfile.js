const gulp = require('gulp'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins({
        pattern: ['gulp-*', 'gulp.*', 'autoprefixer', 'browser-sync', 'cssnano', 'css-mqpacker', 'del', 'postcss-assets', 'run-sequence']
    });

const themeName = 'ccrovermusic',
    themePackage = 'CC Rover Music',
    themeURL = 'ccrovermusic.local';

let env,
    dir,
    php,
    images,
    sass,
    sassStyle,
    js,
    readMe,
    languages,
    bsync,
    lineec;

env = process.env.NODE_ENV || 'development';

dir = {
    src: 'assets/',
    build: '../2.\ Development/' + themeName + '/wp-content/themes/' + themeName + '/',
    prod: '../1.\ Production/' + themePackage + '/' + themeName + '/',
    prodZip: '../1.\ Production/' + themePackage + '/'
};

php = {
    src:    dir.src + 'template/**/*.php',
    build:  dir.build,
    prod:   dir.prod
};

images = {
    src:    dir.src + 'images/**/*.{jpg,JPG,png}',
    build:  dir.build,
    prod:   dir.prod,
    imagesOpts: [
        plugins.imagemin.gifsicle({interlaced: true}),
        plugins.imagemin.jpegtran({progressive: true}),
        plugins.imagemin.optipng({optimizationLevel: 5}),
        plugins.imagemin.svgo({plugins:[{removeViewBox: true}]})
    ]
};

sass = {
    src:    dir.src + 'sass/style.scss',
    watch:  dir.src + 'sass/**/*',
    build:  dir.build,
    prod:   dir.prod,
    sassOpts: {
        outputStyle: sassStyle,
        imagePath: images.build,
        indentType: 'tab',
        indentWidth: '1',
        precision: 10,
        errLogToConsole: true
    },
    postcssOpts: [
        plugins.postcssAssets({
            loadPaths: [images.build],
            basePath: dir.build,
            baseUrl: '/wp-content/themes/' + themeName + '/'
        }),
        plugins.autoprefixer()
    ],
    rtl: {
        basename: 'rtl'
    }
};

js = {
    src:    dir.src + 'js/**/*.js',
    build:  dir.build + 'js',
    prod:   dir.prod + 'js',
    filename: 'bundle.js',
    suffix: {
        suffix: '.min'
    }
};

readMe = {
    src:    dir.src + 'README.md',
    build:   dir.build,
    prod:   dir.prod
};

bsync = {
    bsyncOpts: {
        proxy: 'http://' + themeURL + '/',
        host:  themeURL,
        files: dir.build + '**/*',
        open: 'external',
        notify: false,
        injectChanges: true,
        watchOptions: {
            debounceDelay: 2000
        },
        ui: {
            port: 8001
        },
        snippetOptions: {
            whitelist: ['/wp-admin/admin-ajax.php'],
            blacklist: ['wp-admin/**']
        }
    }
};

languages = {
    languagesOpts: {
        domain:         themeName,
        destFile:       themeName + '.pot',
        package:        themePackage,
        bugReport:      'https://jstoobz.com/contact/',
        lastTranslator: 'James Stephens <james@jstoobz.com>',
        team:           'James Stephens <james@jstoobz.com>'
    },
    src:    php.src,
    build:  dir.build + 'languages/',
    prod:   dir.prod + 'languages/'
};

lineec = {
    lineecOpts: {
        verbose: true,
        eolc: 'LF',
        encoding: 'utf8'
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

gulp.task('browser-sync', () => {
    plugins.browserSync.init(bsync.bsyncOpts)
});

gulp.task('watch', ['browser-sync'], () => {
    gulp.watch(php.src, ['php']);
    gulp.watch(images.src, ['images']);
    gulp.watch(sass.watch, ['sass']);
    gulp.watch(js.src, ['js']);
});

gulp.task('default', (cb) => {
    plugins.runSequence(
        'build',
        'watch',
        cb
    )
});

gulp.task('build', ['php', 'sass', 'js', 'readme']);

gulp.task('build:dev', (cb) => {
    plugins.runSequence(
        'clean:dev',
        'build',
        'translate',
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
        'translate',
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
