<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package atarr
 */

get_header(); ?>

	<div class="wrap">
		<div class="primary content-area">
			<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-portfolio' );

				the_post_navigation( array(
					'prev_text' => '<h4 class="pre-title">' . __( 'Previous', 'starry' ) . '<span class="title">%title</span></h4>',
					'next_text' => '<h4 class="pre-title">' . __( 'Next', 'starry' ) . '<span class="title">%title</span></h4>',
				) );

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
