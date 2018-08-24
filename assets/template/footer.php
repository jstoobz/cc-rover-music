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
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
		<div class="social-menu">
            <ul>
                <li><a href="" title="Facebook" alt="Facebook" target="_blank"><i class="fa fa-facebook-square fa-lg" id="facebook"></i></a></li>
                <li><a href="" title="Instagram" alt="Instagram" target="_blank"><i class="fa fa-instagram fa-lg" id="instagram"></i></a></li>
                <li><a href="" title="Twitter" alt="Twitter" target="_blank"><i class="fa fa-twitter-square fa-lg" id="twitter"></i></a></li>
                <li><a href="" title="Youtube" alt="Youtube" target="_blank"><i class="fa fa-youtube-square fa-lg" id="youtube"></i></a></li>
                <li><a href="" title="Spotify" alt="Spotify" target="_blank"><i class="fa fa-spotify fa-lg" id="spotify"></i></a></li>
                <li><a href="" title="Sound Cloud" alt="Sound Cloud" target="_blank"><i class="fa fa-soundcloud fa-lg" id="sound-cloud"></i></a></li>
            </ul>
		</div>
		<div class="copyright">
			Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>.<br class="copyright-mobile-break"/> All Rights Reserved.
		</div>
		<div class="developer">
			Site developed by: <a href="https://jstoobz.com" target="_blank">jstoobz</a>
		</div>
		<div class="extras">
			<ul>
				<li><a href="">Privacy Policy</a></li>
				<li><a href="">Terms &amp; Conditions</a></li>
			</ul>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
