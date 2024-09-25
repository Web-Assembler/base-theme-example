<?php
/**
 * The template for displaying archive pages, used as a fallback when templates are not in the theme.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="archive-wrapper">

	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="container">
					<?php
					if ( have_posts() ) :
						webassembler_page_header();
						webassembler_archive_filters( array( 'category' ) );
						webassembler_archive_filters( array( 'post_tag' ) );
						?>
						<ul class="posts-container posts-container--three-columns">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part(
									'template-parts/cards/card',
									'news',
									array(
										'card_classes' => 'post-item card hover__style--card-zoom-in card__link--cover',
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
