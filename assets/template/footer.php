<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CC_Rover_Music
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="footer-brand">
            <!-- <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png"></a> -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
		<div class="social-menu">
            <!-- <a href="" title="Facebook" alt="Facebook" target="_blank" class="facebook"><i class="fa fa-facebook-square fa-lg" id="facebook"></i></a> -->
            <a href="https://www.instagram.com/cc_rover/" title="Instagram" alt="Instagram" target="_blank" class="instagram"><i class="fa fa-instagram fa-lg" id="instagram"></i></a>
            <a href="https://twitter.com/cc_rover_music" title="Twitter" alt="Twitter" target="_blank" class="twitter"><i class="fa fa-twitter-square fa-lg" id="twitter"></i></a>
            <a href="https://www.youtube.com/channel/UCDDyamuDYMR3M_swqdo6lTg" title="Youtube" alt="Youtube" target="_blank" class="youtube"><i class="fa fa-youtube-square fa-lg" id="youtube"></i></a>
            <a href="https://itunes.apple.com/us/artist/cc-rover/1409781438" title="Apple" alt="Apple" target="_blank" class="apple"><i class="fa fa-apple fa-lg" id="apple"></i></a>
            <a href="https://open.spotify.com/artist/6UDvKZZr1QcTFEotCXV4TI" title="Spotify" alt="Spotify" target="_blank" class="spotify"><i class="fa fa-spotify fa-lg" id="spotify"></i></a>
            <!-- <a href="" title="Sound Cloud" alt="Sound Cloud" target="_blank" class="sound-cloud"><i class="fa fa-soundcloud fa-lg" id="sound-cloud"></i></a> -->
		</div>
		<div class="copyright">
			Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>.<br class="copyright-mobile-break"/> All Rights Reserved.
		</div>
		<div class="developer">
			Site developed by: <a href="http://jstoobz.com" target="_blank">jstoobz</a>
		</div>
		<div class="extras">
            <a href="/privacy-policy">Privacy Policy</a>
            <a href="/terms-and-conditions">Terms &amp; Conditions</a>
            <a href="/sitemap">Sitemap</a>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
