<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package PipTheme
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
            <?php get_sidebar( 'footer' ); ?>
		<div class="site-info">
			<?php do_action( 'piptheme_credits' ); ?>
			<?php
			printf(
				/* translators: %s = text link: WordPress, URL: http://wordpress.org/ */
				__( 'Begrudgingly powered by %s', 'piptheme' ),
				'<a href="http://wordpress.org/" rel="generator">' . esc_attr__( 'WordPress', 'piptheme' ) . '</a>'
				); ?>
			<span class="sep"> | </span>
			<?php
			printf(
				/* translators: %1$s = text link: PipTheme, %2$s = text link: Pipfrosch Press, URL: https://pipfrosch.com/ */
				__( 'Theme: %1$s by %2$s', 'piptheme' ),
                                esc_attr( 'PipTheme', 'piptheme' ),
				'<a href="https://pipfrosch.com/" rel="designer nofollow">' . esc_attr__( 'Pipfrosch Press', 'piptheme' ) . '</a>' ); ?>
		    <br/><a href="/privacy-policy/">Privacy Policy</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>