<?php
/**
 * A range of custom functions that act independently of the theme templates.
 * These are hooked directly to add functionality thus are different to "theme-functions.php".
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * --------------------------------
 * Index
 * 1. BODY HOOKS
 * 2. HEAD HOOKS
 * 3. LOGO HOOKS
 * 4. ARCHIVE HOOKS
 * 5. SEARCH HOOKS
 * 6. TITLE HOOKS
 * 7. THEME HOOKS
 * 8. THIRD PARTY HOOKS
 * --------------------------------
 */

/**
 * --------------------------------
 * 1. BODY HOOKS
 * --------------------------------
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function webassembler_body_classes( $classes ) {
	$custom_classes = array();

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	/**
	 * If this is an archive page, add the classes manually as bother archive.php
	 * and category.php have hard-coded full height header blocks.
	 */
	if ( is_home() && ! is_front_page() || is_category() || is_page_template( 'tmpl-contact-us.php' ) ) {
		// $custom_classes[] = esc_html( 'first-block-bgcolor-example-dark' );
		// $custom_classes[] = esc_html( 'first-block-color-white' );

	} elseif ( is_singular( 'tribe_events' ) || is_post_type_archive( 'tribe_events' ) ) {

		$custom_classes[] = esc_html( 'first-block-bgcolor-example-dark' );
		$custom_classes[] = esc_html( 'first-block-color-white' );

	} else {

		// Add classes to the body based on the block being used.
		$post = get_post();
		if ( ! is_null( $post ) ) {
			if ( is_page_template( 'tmpl-programme.php' ) ) {
				$example_class    = webassembler_does_current_match_website_options( $post );
				$custom_classes[] = esc_html( 'first-block-bgcolor-' . $example_class );
			} else {

				// Add classes when blocks are in use.
				if ( has_blocks( $post->post_content ) ) {
					$blocks            = parse_blocks( $post->post_content );
					$first_block_attrs = $blocks[0]['attrs'];

					// Add a class name for the first block in use.
					if ( array_key_exists( 'name', $first_block_attrs ) ) {

						$applicable_blocks = array( 'weba-base/full-height-header' );

						if ( ! in_array( $first_block_attrs['name'], $applicable_blocks, true ) ) {

							// Force the default block backgroundColour to ensure the classname is set properly.
							// if ( 'weba-base/full-height-header' === $first_block_attrs['name'] && false === array_key_exists( 'backgroundColor', $first_block_attrs ) ) {
							// 	$first_block_attrs['backgroundColor'] = 'namespace-yellow-dark'; // This default is also set in block.json.
							// }

							// Force the default block textColor to ensure the classname is set properly.
							// if ( 'weba-base/full-height-header' === $first_block_attrs['name'] && false === array_key_exists( 'textColor', $first_block_attrs ) ) {
							// 	$first_block_attrs['textColor'] = 'white'; // This default is also set in block.json.
							// }

							$custom_classes_array = explode( ' ', $first_block_attrs['name'] );
							if ( ! empty( $custom_classes_array ) ) {
								foreach ( $custom_classes_array as $custom_classes_item ) {
									// Remove '/' from name e.g. "acf/my-block".
									$filtered         = strtolower( preg_replace( '/[\W\s\/]+/', '__', $custom_classes_item ) );
									$custom_classes[] = esc_html( 'first-block--' . $filtered );
								}
							}
						}
					}
				}
			}
		}
	}

	if ( ! empty( $custom_classes ) ) {
		return array_merge( $classes, $custom_classes );
	}

	return $classes;
}
add_filter( 'body_class', 'webassembler_body_classes' );


/**
 * Adds schema markup to the body element.
 *
 * @param array $atts An associative array of attributes.
 * @return array
 */
function webassembler_default_body_attributes( $atts ) {
	$atts['itemscope'] = '';
	$atts['itemtype']  = 'http://schema.org/WebSite';
	return $atts;
}
add_filter( 'webassembler_body_attributes', 'webassembler_default_body_attributes' );

/**
 * --------------------------------
 * 2. HEAD HOOKS
 * --------------------------------
 */

/**
 * Add a pingback url auto-discovery header for single posts of any post type.
 */
function webassembler_singular_pingback() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'webassembler_singular_pingback' );

/**
 * Add mobile-web-app meta.
 */
function webassembler_mobile_web_app_meta() {
	echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'webassembler_mobile_web_app_meta' );

/**
 * --------------------------------
 * 3. LOGO HOOKS
 * --------------------------------
 */
