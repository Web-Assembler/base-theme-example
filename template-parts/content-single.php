<?php
/**
 * Single post partial template
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="container">
		<?php webassembler_page_header(); ?>
		<div class="featured-image">
			<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
		</div>
		<div class="post-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
		</div>
	</div>
</article>
