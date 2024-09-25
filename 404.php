<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();


$page_content       = "Sorry the page you're looking for can't be found. To get back on track please choose one of the options below.";
$error_page_content = get_field( 'error404_page_content', 'option' );
if ( ! empty( $error_page_content ) ) {
	$page_content  = $error_page_content['error404_page_content'];
	$primary_btn   = $error_page_content['error404_primary_button'];
	$secondary_btn = $error_page_content['error404_secondary_button'];
}

?>
<div class="wrapper">
	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<div class="container">
				<?php webassembler_page_header(); ?>

				<?php echo wp_kses_post( $page_content ); ?>
				<?php if ( isset( $primary_btn['url'] ) || isset( $secondary_btn['url'] ) ) : ?>
					<div class="button-wrapper">
						<?php if ( $primary_btn ) : ?>
							<div class="wp-block-button">
								<a href="<?php echo esc_url( $primary_btn['url'] ); ?>" class="wp-block-button__link button button--primary"><?php echo esc_html( $primary_btn['title'] ); ?></a>
							</div>
						<?php endif; ?>

						<?php if ( $secondary_btn ) : ?>
							<div class="wp-block-button">
								<a href="<?php echo esc_url( $secondary_btn['url'] ); ?>" class="wp-block-button__link button button--secondary"><?php echo esc_html( $secondary_btn['title'] ); ?></a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</main>
	</div>
</div>

<?php
get_footer();
