<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CC_Rover_Music
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="site" id="page">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ccrovermusic' ); ?></a>

	<header id="masthead" class="site-header">
		<!-- <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" role="navigation"> -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">

            <!-- Site title and branding in the menu -->
            <?php if ( ! has_custom_logo() ) { ?>
            	<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>
			<?php } else {
				the_custom_logo();
			} ?><!-- End site title and branding -->

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav" aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fa fa-navicon"></i></span>MENU
            </button>

            <?php wp_nav_menu(
            	array(
	                'theme_location'    => 'primary',
	                'depth'             => 2,
	                'container'         => 'div',
	                'container_class'   => 'collapse navbar-collapse',
	                'container_id'      => 'navbar-nav',
	                'menu_class'        => 'nav navbar-nav ml-auto',
	                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
	                'walker'            => new WP_Bootstrap_Navwalker(),
	            )
            ); ?>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
