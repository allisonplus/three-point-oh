<?php
/**
 * Markup for ACF Fields.
 *
 * @package atarr
 */

/**
 * Testimonial Section
 */
function atarr_get_testimonial_section() {

	ob_start(); ?>

		<?php $testimonials = atarr_query_testimonials(); ?>

		<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

		<?php
			$url = get_post_meta( get_the_ID(), 'testimonial_url', true );
			$image = get_field( 'testimonial_photo' )['sizes']['thumbnail'];
			$source = get_post_meta( get_the_ID(), 'source', true );
		?>

		<section class="testimonials">
			<div class="testimonial-single">
					<img src="<?php echo esc_url( $image ); ?>" alt="">
					<?php the_content(); ?>
					<a href="<?php echo esc_url( $url ); ?>"><?php the_title(); ?></a>
					<p><?php echo esc_html( $source); ?></p>
			</div><!--.testimonial-single-->
		</section><!--.section-->

		<?php endwhile; ?>

	<?php
	return ob_get_clean();
}
