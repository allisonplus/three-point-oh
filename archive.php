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

				<div class="flex-shell">

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content-post-card' );

				endwhile; ?>

				<div class="nav-links page-nav">
					<div class="nav-previous">
						<h4 class="pre-title"><?php echo get_next_posts_link( 'Previous' ); // WPCS: XSS OK. ?> </h4>
					</div>
					<div class="nav-next">
						<h4 class="pre-title"><?php echo get_previous_posts_link( 'Next' ); // WPCS: XSS OK. ?></h4>
					</div>
				</div><!--.nav-links-->

			<?php else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>
				</div><!-- .flex-shell -->
			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
