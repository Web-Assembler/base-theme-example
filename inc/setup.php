<?php
/**
 * Theme basic setup
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function webassembler_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on webassembler, use a find and replace
		* to change 'webassembler-base' to the name of your theme in all the template files
		*/
	load_theme_textdomain( 'webassembler-base', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'webassembler-base' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
		* Adding Thumbnail basic support
		*/
	add_theme_support( 'post-thumbnails' );

	/*
		* Adding support for Widget edit icons in customizer
		*/
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
		* Enable support for Post Formats.
		* See http://codex.wordpress.org/Post_Formats
		*/
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'webassembler_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Set up the WordPress Theme logo feature.
	add_theme_support( 'custom-logo' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Check and setup theme default settings.
	webassembler_setup_theme_default_settings();

	// Register custom image sizes.
	add_image_size( 'card__vertical', 770, 430, false );  // Image for the card--vertical class.
	add_image_size( 'card__horizontal', 380, 285, false );  // Image for the card--horizontal class.
}
add_action( 'after_setup_theme', 'webassembler_theme_setup' );


/**
 * --------------------------------
 * POST HOOKS
 * --------------------------------
 */

/**
 * Removes the ... from the excerpt read more link
 *
 * @param string $more The excerpt.
 *
 * @return string
 */
function webassembler_custom_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		$more = '';
	}
	return $more;
}
add_filter( 'excerpt_more', 'webassembler_custom_excerpt_more' );

/**
 * Adds a custom read more link to all excerpts, manually or automatically generated
 *
 * @param string $post_excerpt Posts's excerpt.
 *
 * @return string
 */
function webassembler_all_excerpts_get_more_link( $post_excerpt ) {
	return $post_excerpt;
}
remove_filter( 'the_excerpt', 'wpautop' );
add_filter( 'wp_trim_excerpt', 'webassembler_all_excerpts_get_more_link' );

/**
 * Override the excerpt length.
 *
 * @param int $length The amount of words returned.
 * @return int
 */
function webassembler_custom_excerpt_length( $length ) {
	$length = 10;
	return $length;
}
add_filter( 'excerpt_length', 'webassembler_custom_excerpt_length', 999 );

/**
 * --------------------------------
 * CATEGORY HOOKS
 * --------------------------------
 */

/**
 * Flush out the transients used in webassembler_categorized_blog.
 */
function webassembler_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'webassembler_categories' );
}
add_action( 'edit_category', 'webassembler_category_transient_flusher' );
add_action( 'save_post', 'webassembler_category_transient_flusher' );
