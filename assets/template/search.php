<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package CC_Rover_Music
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf( esc_html__( 'Search Results for: %s', 'ccrovermusic' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'search' );

			endwhile;

            the_posts_pagination( array(
                'prev_text' => ccrovermusic_get_svg( array( 'icon' => 'arrow-long-left', 'fallback' => true ) ) . __( 'Newer', 'ccrovermusic' ),
                'next_text' => __( 'Older', 'ccrovermusic' ) . ccrovermusic_get_svg( array( 'icon' => 'arrow-long-right' , 'fallback' => true ) ),
                'before_page_number' => '<span class="screen-reader-text">' . __( 'Page ', 'ccrovermusic' ) . '</span>',
            ));

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
