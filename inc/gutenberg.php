<?php
/**
 * Handles all the definitions of gutenberg ACF blocks and related settings.
 *
 * @author Anthony Vickery-Hartnell <anthony@webassembler.co.uk>
 * @package webassembler-base
 * @since version 1.0
 */

// Remove all Gutenberg block patterns from showing up.
add_filter( 'should_load_remote_block_patterns', '__return_false' );

// Filters whether block styles should be loaded separately.
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Defines any Gutenberg related theme settings.
 */
function webassembler_gutenberg_setup() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'editor-gradient-presets', array() );

	// Remove block patterns (can't be removed in theme.json).
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'webassembler_gutenberg_setup' );

/**
 * Register a new block category to group custom blocks.
 *
 * @see https://gutenberghub.com/how-to-create-custom-block-category/
 * @param array $categories The default categories.
 * @return array
 */
function webassembler_add_block_category_group( $categories ) {
	$custom_categories = array(
		'slug'  => 'webassembler',
		'title' => 'Theme Blocks',
	);

	// Put custom categories before gutenerg one (at beginning of array).
	array_unshift( $categories, $custom_categories );
	return $categories;
}
add_filter( 'block_categories_all', 'webassembler_add_block_category_group' );

/**
 * Define Gutenberg blocks here.
 *
 * Central array of custom blocks to manage Gutenberg and ACF settings in one place.
 *
 * @return array
 */
function webassembler_get_custom_blocks() {
	return array(
		'accordion',
		'contact-map',
		'countdown-timer',
		'featured-heading',
		'form-redirect',
		'hero',
		'image-content',
		'image-gallery-preview',
		'image-slider',
		'latest-news',
		'logo-slider',
		'testimonial',
		'testimonial-slider',
		'timeline',
		'video',
		'video-popup',
	);
}

/**
 * Register custom blocks.
 *
 * @return void
 */
function webassembler_register_custom_blocks() {
	$block_path = trailingslashit( get_template_directory() . '/blocks' );
	foreach ( webassembler_get_custom_blocks() as $block ) {
		register_block_type( $block_path . $block );
	}
}
add_action( 'init', 'webassembler_register_custom_blocks', 5 );


/**
 * Set the custom load and save paths for ACF field groups, using a centralized list of blocks.
 *
 * @param array $paths The array of paths to modify.
 * @return array
 */
function webassembler_set_acf_json_paths( $paths ) {
	$block_path = trailingslashit( get_template_directory() . '/blocks' );
	foreach ( webassembler_get_custom_blocks() as $block ) {
		$paths[] = $block_path . $block . '/acf';
	}
	return $paths;
}
add_filter( 'acf/json/save_paths', 'webassembler_set_acf_json_paths', 10 );
add_filter( 'acf/settings/load_json', 'webassembler_set_acf_json_paths' );


/**
 * Disable selected Gutenberg blocks.
 *
 * @param array                   $allowed_block_types Existing blocks.
 * @param WP_Block_Editor_Context $editor_context What type of post object we're dealing with.
 * @return array
 */
function webassembler_allowed_block_types( $allowed_block_types, $editor_context ) {

	if ( ! empty( $editor_context->post ) ) {

		$gutenberg_allowed_block_types = array(
			// Third party.
			// 'formidable/simple-form',

			// Text Blocks.
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item',
			'core/table',

			// Media Blocks.
			// 'core/image',
			'core/media-text',

			// Design Blocks.
			'core/buttons',
			'core/button',
			// 'core/columns',
			// 'core/group',
			'core/spacer',

			// Widget Blocks.
			// 'core/shortcode',
			// 'core/page-list',
			// 'core/html',

			// Embed Blocks.
			// 'core/embed',
		);

		// foreach ( webassembler_get_custom_blocks() as $block ) {
		// 	$theme_allowed_block_types[] = 'webassembler/' . $block;
		// }

		if ( isset( $editor_context->name ) && 'core/media-text' === $editor_context->name ) {
			// Specify the blocks you want to allow in the Media & Text block.
			$allowed_block_types = array(
				'core/paragraph',
				'core/image',
				// Add any other blocks you want to allow here.
			);
		}

		// // On certain templates, these additional blocks can be selected.
		// if ( 'tmpl-my-template.php' === get_page_template_slug( $editor_context->post ) ) { // phpcs:ignore
		// 	/** $theme_allowed_block_types[] = 'weba-base/my-block'; */
		// }

		// // On the page set for the home page, these additional blocks can be selected.
		// $page_for_front_id = get_option( 'page_on_front' );
		// if ( intval( $page_for_front_id ) === $editor_context->post->ID // phpcs:ignore
		// 	|| 'tmpl-my-template.php' === get_page_template_slug( $editor_context->post )
		// ) {
		// 	/** $theme_allowed_block_types[] = 'weba-base/home-page-blocks'; */
		// }

		// Merge the default Gutenberg blocks with the allowed blocks.
		// $allowed_block_types = array_merge( $theme_allowed_block_types, $gutenberg_allowed_block_types );
	}
	return $allowed_block_types;
}
add_filter( 'allowed_block_types_all', 'webassembler_allowed_block_types', 10, 2 );

// function weba_filter_allowed_blocks_for_media_text( $allowed_block_types, $editor_context ) {
// 	if ( isset( $editor_context->name ) && 'core/media-text' === $editor_context->name ) {
// 		// Specify the blocks you want to allow in the Media & Text block.
// 		$allowed_block_types = array(
// 			'core/paragraph',
// 			'core/image',
// 			// Add any other blocks you want to allow here.
// 		);
// 	}

// 	return $allowed_block_types;
// }
// add_filter( 'allowed_block_types_all', 'weba_filter_allowed_blocks_for_media_text', 20, 2 );



