<?php
/**
 * Render a single post
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="single-wrapper">
	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', 'single' );
			}
			?>
		</main>
	</div>
</div>

<?php
get_footer();
