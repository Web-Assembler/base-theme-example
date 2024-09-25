<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>


<footer class="site-footer" id="colophon">
	<div class="container container--wide">
		<div class="footer-top">

			<div class="footer-content">

				<?php // Site site-branding. ?>
				<span class="sr-only"><?php echo esc_html( get_bloginfo( 'title' ) ); ?></span>
				<div class="site-branding">
					<a class="site-branding-link" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
						<img class="site-branding-logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/alogo.svg" width="208" height="55" />
					</a>
				</div>

				<?php // Footer Columns. ?>
				<div class="footer-columns-top">
					<?php if ( is_active_sidebar( 'footer_column_1' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer_column_1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer_column_2' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer_column_2' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="footer-columns-bottom">
					<div class="footer-column">
						<?php echo do_shortcode( '[social_icons]' ); ?>
					</div>
				</div>

			</div>
		</div>

		<?php
		if ( is_active_sidebar( 'footer_copyright_left' ) || is_active_sidebar( 'footer_copyright_right' ) ) :
			?>
			<div class="footer-bottom">
				<div class="container">
					<div class="footer-bottom-content">
						<?php if ( is_active_sidebar( 'footer_copyright_left' ) ) : ?>
							<div class="footer-company-content">
								<?php dynamic_sidebar( 'footer_copyright_left' ); ?>
							</div>
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'footer_copyright_right' ) ) : ?>
							<div class="footer-copyright-content">
								<?php dynamic_sidebar( 'footer_copyright_right' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</div>

</footer><!-- #colophon -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>
</html>

