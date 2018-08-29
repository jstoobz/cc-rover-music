<?php

/**
 * Template Name: Contact Page
 *
 * @package CC_Rover_Music
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="contact">
                <h1><?php the_field('page_title') ?></h1>

                <div class="container">
                    <div class="contact-text col-lg-7">
                        <h2><?php the_field('contact_title') ?></h2>
                        <p><?php the_field('contact_description') ?></p>
                        <h3>Contact Details:</h3>
                        <div class="contact-name">
                            <i class="fa fa-user fa-md"></i>
                            <?php the_field('contact_name') ?>
                        </div>
                        <div class="contact-email">
                            <i class="fa fa-envelope-o fa-md"></i>
                            <a href="mailto:<?php the_field('contact_email') ?>"><?php the_field('contact_email') ?></a>
                        </div>
                    </div>
                    <div class="contact-form col-lg-5">
                        <?php echo do_shortcode( '[contact-form-7 id="38" title="Contact Form - Contact Page"]' ); ?>
                    </div>
                </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
