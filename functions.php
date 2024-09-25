<?php
/**
 * Webassembler functions and definitions
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$template_inc_dir = 'inc';

// Array of files to include.
$template_includes = array(
	'/setup.php',                        // Theme setup and custom theme supports.
	'/theme-functions.php',              // Theme setup and custom theme supports.
	'/theme-hooks.php',                  // Theme setup and custom theme supports.
	'/widgets.php',                      // Register widget area.
	'/enqueue.php',                      // Enqueue scripts and styles.
	'/shortcodes.php',                   // Load custom shortodes.
	'/pagination.php',                   // Custom pagination for this theme.
	'/customizer.php',                   // Customizer additions.
	'/custom-comments.php',              // Custom Comments file.
	'/class-webassembler-navwalker.php', // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/admin-editor.php',                 // Load functions for the editor/admin area.
	'/custom-post-types.php',            // Load custom post type definitions.
	'/gutenberg.php',                    // Load ACF Gutenberg blocks.
);

// Include files.
foreach ( $template_includes as $file ) {
	require_once get_theme_file_path( $template_inc_dir . $file );
}
