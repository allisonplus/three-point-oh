<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="grid">

				<?php $featured_work = atarr_query_portfolio();

				if ( $featured_work->have_posts() ) :

					while ( $featured_work->have_posts() ) : $featured_work->the_post();

						get_template_part( 'template-parts/content-post-card' );

					endwhile; ?>

					<div class="nav-links">
						<div class="nav-previous">
							<h4 class="pre-title"><?php echo get_next_posts_link( 'Previous', $featured_work->max_num_pages ); // WPCS: XSS OK. ?> </h4>
						</div>
						<div class="nav-next">
							<h4 class="pre-title"><?php echo get_previous_posts_link( 'Next', $featured_work->max_num_pages ); // WPCS: XSS OK. ?></h4>
						</div>
					</div><!--.nav-links-->

					<?php wp_reset_postdata();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
			endif; ?>

				</div>

			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
