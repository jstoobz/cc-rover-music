<?php

/**
 * Template Name: Sitemap Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="sitemap">
                <h1><?php the_field('page_title') ?></h1>
                <h2>Pages</h2>
                <?php echo do_shortcode( '[sitemap]' ); ?>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
