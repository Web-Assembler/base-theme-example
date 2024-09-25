<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package webassembler-base
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="wrapper" id="index-wrapper">
	<div id="content" tabindex="-1">
		<main class="site-main" id="main">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="container">
					<?php
					if ( have_posts() ) :
						if ( is_home() && ! is_front_page() ) :
							$page_for_posts_id = get_option( 'page_for_posts' );
							$blog_page         = get_post( $page_for_posts_id );

							if ( ! webassembler_is_first_block( array( 'webassembler/hero' ), $blog_page ) ) {
								webassembler_page_header( $blog_page );
							}
							echo wp_kses_post( apply_filters( 'the_content', $blog_page->post_content ) );

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
					endif;
					?>
				</div>
			</article>
		</main>
	</div>
</div>

<?php
get_footer();
