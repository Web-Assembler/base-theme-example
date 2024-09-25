<?php
/**
 * WebAssembler enqueue scripts.
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * --------------------------------
 * THEME ENQUEUES
 * --------------------------------
 */

/**
 * Load theme's JavaScript and CSS sources.
 */
function webassembler_load_scripts() {
	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/assets/dist/css/theme.min.css' );
	wp_enqueue_style( 'webassembler-styles', get_template_directory_uri() . '/assets/dist/css/theme.min.css', array(), $css_version );

	wp_enqueue_script( 'jquery' );
	$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/assets/dist/js/theme.min.js' );
	wp_enqueue_script( 'webassembler-scripts', get_template_directory_uri() . '/assets/dist/js/theme.min.js', array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Conditionally load files for specific blocks.
	if ( is_singular() ) {
		$block_id = get_the_ID();
		if ( has_block( 'webassembler/video-popup', $block_id ) ) {
			wp_enqueue_style(
				'video-popup-css',
				'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css',
				array( 'jquery' ),
				'1.1.0'
			);
			wp_enqueue_script(
				'video-popup',
				'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
				array( 'jquery' ),
				'1.1.0',
				true
			);
			wp_enqueue_script(
				'video-popup-script',
				get_template_directory_uri() . '/assets/js/vendor/video-popup-handler.js',
				array( 'video-popup', 'jquery' ),
				'1.1.0',
				true
			);
		}
		if ( has_block( 'webassembler/accordion', $block_id ) ) {
			wp_enqueue_script( 'jquery-ui-accordion' );
		}
		if ( has_block( 'webassembler/hero', $block_id ) ) {
			wp_enqueue_script(
				'vimeo-player',
				get_template_directory_uri() . '/assets/js/vendor/vimeo-player.min.js',
				array(),
				'2.19.0',
				true
			);
		}
	}

	// If is the blog page.
	if ( is_home() || is_category() || is_tag() || is_search() || is_author() ) {
		wp_enqueue_style( 'archive-news-style', get_template_directory_uri() . '/assets/dist/css/archive-news.min.css', array(), '111' );
		wp_enqueue_script( 'archive-news-script', get_template_directory_uri() . '/assets/dist/js/archive-news.min.js', array(), '111', true );
	}
}
add_action( 'wp_enqueue_scripts', 'webassembler_load_scripts' );

/**
 * Enqueue the minified editor styles for the block editor.
 */
function webassembler_block_editor_scripts() {
	wp_enqueue_style(
		'block-editor-style',
		get_template_directory_uri() . '/assets/dist/css/block-editor.min.css',
		array( 'wp-edit-blocks' ),
		'1.2'
	);

	// Override the Gutenberg editor scripts.
	wp_enqueue_script(
		'webassembler-editor',
		get_template_directory_uri() . '/assets/js/editor.js',
		array( 'wp-blocks', 'wp-dom' ),
		'1.2',
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'webassembler_block_editor_scripts' );


/**
 * Enqueue the minified admin-only styles for the admin pages.
 */
function webassembler_admin_editor_scripts() {
	wp_enqueue_style(
		'admin-styles',
		get_template_directory_uri() . '/assets/dist/css/admin.min.css',
		array(),
		'1.2'
	);
}
add_action( 'admin_enqueue_scripts', 'webassembler_admin_editor_scripts' );
