<?php

/**
 * Template Name: Privacy Policy Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="sitemap">
                <h1><?php the_field('page_title') ?></h1>
                <?php the_field('privacy_policy') ?>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
