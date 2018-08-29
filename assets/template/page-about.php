<?php

/**
 * Template Name: About Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="about">
                <h1><?php the_field('page_title') ?></h1>

                <div class="bio">
                    <div class="bio-img" style="background-image: url(<?php the_field('profile_picture'); ?>);">
                    </div>
                    <div class="bio-text">
                        <h2><?php the_field('name'); ?></h2>
                        <h3><?php the_field('title'); ?></h3>
                        <p><?php the_field('description'); ?></p>
                    </div>
                </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
