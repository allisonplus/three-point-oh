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
				</div><!--.grid-->

					<?php if ( $featured_work->max_num_pages > 1 ) { ?>

					<div class="nav-links page-nav">
						<div class="nav-previous">
							<?php echo get_next_posts_link( '<h4 class="pre-title">' . esc_html( 'Previous', 'atarr' ) . '</h4>', $featured_work->max_num_pages ); // WPCS: XSS OK. ?>
						</div>
						<div class="nav-next">
							<?php echo get_previous_posts_link( '<h4 class="pre-title">' . esc_html( 'Next', 'atarr' ) . '</h4>', $featured_work->max_num_pages ); // WPCS: XSS OK. ?>
						</div>
					</div><!--.nav-links-->
					<?php } ?>

					<?php wp_reset_postdata();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
			endif; ?>

			</main><!-- #main -->
		</div><!-- .primary -->


	</div><!-- .wrap -->
<?php echo atarr_do_contact_cta(); // WPCS: XSS OK. ?>

<?php get_footer(); ?>
