<?php

/**
 * Template Name: News Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php query_posts('post_type=post&cat=4&post_status=publish&posts_per_page=5&paged='. get_query_var('paged')); ?>

        <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/content', get_post_format() );

            endwhile;

            the_posts_pagination( array(
                'prev_text' => ccrovermusic_get_svg( array( 'icon' => 'arrow-long-left', 'fallback' => true ) ) . __( 'Newer', 'ccrovermusic' ),
                'next_text' => __( 'Older', 'ccrovermusic' ) . ccrovermusic_get_svg( array( 'icon' => 'arrow-long-right' , 'fallback' => true ) ),
                'before_page_number' => '<span class="screen-reader-text">' . __( 'Page ', 'ccrovermusic' ) . '</span>',
            ));
        ?>

        <?php wp_reset_query(); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
