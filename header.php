<?php
/**
 * The theme header.
 *
 * Displays all of the <head>.
 *
 * Includes the opening tag for the page-container class which sets a max-width on the page content.
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php webassembler_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<header class="header" id="header-top" itemscope itemtype="https://schema.org/WebSite">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'webassembler-base' ); ?></a>

		<div class="container container--wide">
			<div class="header__container">

				<section class="site-branding">
					<a class="site-branding-link site-branding-link--header" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<!-- <p class="has-large-font-size site-branding-text">WEBASSEMBLER <strong class="has-normal-font-size">BASE</strong></p> -->
						<?php
						// Output an SVG Image.
						?>
						<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
						<img class="site-branding-logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/alogo.svg" width="208" height="55" />
					</a>
				</section>

				<section class="header__navigation">

					<button class="header__navigation__toggle-button"  id="js-open-nav" aria-label="<?php esc_attr_e( 'Open navigation menu', 'eta' ); ?>" aria-controls="nav-menu-container" aria-expanded="false">
						<span></span>
					</button>

					<nav role="navigation" aria-hidden="true" id="nav-menu-container" class="visually-hidden menu__animate--top">
						<span class="sr-only"><?php esc_html_e( 'Main Navigation', 'webassembler-base' ); ?></span>

						<?php
						$items_wrap = '<ul class="menu header__mainmenu--menu-list">%3$s</ul>';
						wp_nav_menu(
							array(
								'theme_location'  => 'primary',
								'container_class' => 'header__navigation--primary',
								'container_id'    => '',
								'fallback_cb'     => '',
								'menu_id'         => 'header__mainmenu--menu',
								'depth'           => 2,
								'items_wrap'      => $items_wrap,
								'walker'          => new Webassembler_Navwalker(),
							)
						);
						?>

					</nav>

				</section>

			</div>
		</div>
	</header>
