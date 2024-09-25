<?php
/**
 * Page set as the home page
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="page-wrapper">
	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="container">
					<?php
					if ( have_posts() ) :
						webassembler_page_header();
						while ( have_posts() ) :
							the_post();
							the_content();
						endwhile;
					endif;
					?>
				</div>
			</article>
		</main>
	</div>
</div>

<?php
get_footer();
