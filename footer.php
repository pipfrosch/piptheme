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
				/* translators: %1$s = github link: PipTheme, %2$s = text link: Pipfrosch Press, URL: https://pipfrosch.com/ */
				__( 'Theme: %1$s by %2$s', 'piptheme' ),
                                '<a href="https://github.com/pipfrosch/piptheme" rel="designer nofollow">' . esc_attr__( 'PipTheme', 'piptheme' ) . '</a>', 
				'<a href="https://pipfrosch.com/" rel="designer nofollow">' . esc_attr__( 'Pipfrosch Press', 'piptheme' ) . '</a>' );
				// https://wordpress.stackexchange.com/questions/314371/how-can-i-get-the-privacy-policy-page
				$privacy_policy_page = get_option( 'wp_page_for_privacy_policy' );
				if( $privacy_policy_page ) {
				    printf( __( '<br/><a href="%1$s">Privacy Policy</a>', 'piptheme' ),
				        esc_url( get_permalink( $privacy_policy_page )));
				}?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
