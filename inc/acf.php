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

		<section class="testimonials">

		<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

		<?php
			$url = get_post_meta( get_the_ID(), 'testimonial_url', true );
			$image = get_field( 'testimonial_photo' )['sizes']['thumbnail'];
			$alt = get_field( 'testimonial_photo' )['alt'];
			$source = get_post_meta( get_the_ID(), 'source', true );
		?>

			<div class="testimonial-single">
				<div class="content-shell">
					<?php if ( ! empty( $image ) ) : ?>
						<img class="testimonial-photo" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $alt ); ?>">
					<?php endif; ?>

					<?php the_content(); ?>

					<?php if ( ! empty( $url ) ) : ?>
						<a class="testimonial-link" href="<?php echo esc_url( $url ); ?>"><?php the_title(); ?></a>
					<?php else : ?>
						<p><?php the_title(); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $source ) ) : ?>
						<p class="testimonial-source"><?php echo esc_html( $source ); ?></p>
					<?php endif; ?>
				</div><!--.content-shell-->
			</div><!--.testimonial-single-->

		<?php endwhile; ?>

		</section><!--.section-->

	<?php
	return ob_get_clean();
}
