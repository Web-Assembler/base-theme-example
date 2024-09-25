<?php
/**
 * Partial template for content in page.php
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="container">
		<?php webassembler_page_header(); ?>
		<?php the_content(); ?>
	</div>
</article>
