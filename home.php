<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>

				<?php
				endif; ?>

				<div class="flex-shell">

				<!-- /* Start the Loop */ -->
				<?php while ( have_posts() ) : the_post();

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
				</div><!--.flex-shell-->
			</main><!-- #main -->
		</div><!-- .primary -->

		<?php get_sidebar(); ?>

	</div><!-- .wrap -->

<?php get_footer(); ?>
