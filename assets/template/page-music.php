<?php

/**
 * Template Name: Music Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="music">
                <h1><?php the_field('page_title') ?></h1>

                <?php query_posts('post_type=music'); ?>

                <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content', 'music' );

                endwhile;
                ?>

                <?php wp_reset_query(); ?>

            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
