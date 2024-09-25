<?php
/**
 * The template for displaying the author pages
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="author-wrapper">
	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="container">

					<?php
					webassembler_page_header();
					if ( have_posts() ) :
						?>
						<ul class="posts-container posts-container--three-columns">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part(
									'template-parts/cards/card',
									'author',
									array(
										'card_classes' => 'post-item card card--link--cover hover__style--card-zoom-in card__link--cover',
										'card_post'    => get_post(),
									)
								);
							endwhile;
							?>
						</ul>

						<div class="pagination-wrapper">
							<?php webassembler_custom_pagination(); ?>
						</div>
						<?php
					endif;
					?>
				</div>
			</article>
		</main>
	</div>
</div>

<?php
get_footer();
