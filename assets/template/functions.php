<?php
/**
 * CC Rover Music functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CC_Rover_Music
 */

if ( ! function_exists( 'ccrovermusic_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ccrovermusic_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CC Rover Music, use a find and replace
		 * to change 'ccrovermusic' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ccrovermusic', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'ccrovermusic' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ccrovermusic_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		// add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 150,
			'flex-width'  => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ccrovermusic_setup' );

/**
 * Register custom fonts.
 */
function ccrovermusic_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Quicksand, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$quicksand = _x( 'on', 'Quicksand font: on or off', 'ccrovermusic' );
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'ccrovermusic' );

	$font_families = array();

	if ( 'off' !== $quicksand ) {
		$font_families[] = 'Quicksand:500,700';
	}

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans:400,600';
	}

	if ( in_array( 'on', array($quicksand, $open_sans) ) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function ccrovermusic_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'ccrovermusic-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'ccrovermusic_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ccrovermusic_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ccrovermusic_content_width', 640 );
}
add_action( 'after_setup_theme', 'ccrovermusic_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ccrovermusic_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ccrovermusic' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ccrovermusic' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ccrovermusic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ccrovermusic_scripts() {
	wp_enqueue_style( 'ccrovermusic-fonts', ccrovermusic_fonts_url() );
	wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', 'https:////maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'ccrovermusic-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ccrovermusic-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20161201', true );
	wp_enqueue_script( 'ccrovermusic-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' );
	// wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js' );
	// wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' );
	// wp_enqueue_script( 'bundled_js', get_template_directory_uri() . '/js/bundle.min.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ccrovermusic_scripts' );

/**
 * Remove query strings from assets
 */
function _remove_script_version( $src ){
	$parts = explode( '?v', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

/**
 * Custom Post Type for Music
 */
function create_music_post_type() {
    register_post_type( 'Music',
        array(
            'labels' => array(
                'name' => __( 'Music' ),
                'singular_name' => __( 'Music' )
            ),
            'public' => true,
            'menu_icon' => 'dashicons-format-audio',
            'has_archive' => false,
            'rewrite' => array('slug' => 'music'),
        )
    );
}
add_action( 'init', 'create_music_post_type' );

/**
 * Extract Youtube ID
 */
function extractYoutubeID($url) {
    $youtube_array = explode('?v=', $url);
    return substr($youtube_array[1], 0, 11);
}

/**
 * Generate Sitemap Page
 */
function wp_sitemap_page(){
	return '<ul>'.wp_list_pages('title_li=&echo=0').'</ul>';
}
add_shortcode('sitemap', 'wp_sitemap_page');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Bootstrap4 navwalker class
 */
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Load SVG icon functions.
 */
require get_template_directory() . '/inc/icon-functions.php';
