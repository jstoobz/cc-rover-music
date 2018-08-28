<?php

/**
 * Template Name: Blog Page
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php query_posts('post_type=post&cat=3&post_status=publish&posts_per_page=2&paged='. get_query_var('paged')); ?>


        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                // the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <?php
            /* Start the Loop */
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;

            the_posts_navigation();

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

    <?php wp_reset_query(); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
