<?php
/**
 * CC Rover Music Theme Customizer
 *
 * @package CC_Rover_Music
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ccrovermusic_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ccrovermusic_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ccrovermusic_customize_partial_blogdescription',
		) );
	}

	// Add option to select index content
	$wp_customize->add_section( 'theme_options',
		array(
			'title'			=> __( 'Theme Options', 'ccrovermusic' ),
			'priority'		=> 95,
			'capability'	=> 'edit_theme_options',
			'description'	=> __( 'Change how much of a post is displayed on index and archive pages.', 'ccrovermusic' )
		)
	);

	// Create excerpt or full content settings
	$wp_customize->add_setting(	'length_setting',
		array(
			'default'			=> 'excerpt',
			'type'				=> 'theme_mod',
			'sanitize_callback' => 'ccrovermusic_sanitize_length', // Sanitization function appears further down
			'transport'			=> 'postMessage'
		)
	);

	// Add the controls
	$wp_customize->add_control(	'ccrovermusic_length_control',
		array(
			'type'		=> 'radio',
			'label'		=> __( 'Index/archive displays', 'ccrovermusic' ),
			'section'	=> 'theme_options',
			'choices'	=> array(
				'excerpt'		=> __( 'Excerpt (default)', 'ccrovermusic' ),
				'full-content'	=> __( 'Full content', 'ccrovermusic' )
			),
			'settings'	=> 'length_setting' // Matches setting ID from above
		)
	);
}
add_action( 'customize_register', 'ccrovermusic_customize_register' );

/**
 * Sanitize length options:
 * If something goes wrong and one of the two specified options are not used,
 * apply the default (excerpt).
 */
function ccrovermusic_sanitize_length( $value ) {
    if ( ! in_array( $value, array( 'excerpt', 'full-content' ) ) ) {
        $value = 'excerpt';
	}
    return $value;
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ccrovermusic_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ccrovermusic_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ccrovermusic_customize_preview_js() {
	wp_enqueue_script( 'ccrovermusic-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ccrovermusic_customize_preview_js' );
