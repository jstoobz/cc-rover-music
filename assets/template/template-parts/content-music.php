<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CC_Rover_Music
 */

?>

<div class="col-lg-6 music-post">
    <h2><?php the_field('post_title') ?></h2>
    <div class="embed-responsive embed-responsive-16by9">
        <iframe src="https://www.youtube.com/embed/<?php echo extractYoutubeID(get_field('video_link')); ?>" frameborder="0" allowfullscreen></iframe>
    </div>
</div>
