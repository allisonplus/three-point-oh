<?php
/**
 * Markup for ACF Fields.
 *
 * @package atarr
 */

/**
 * Testimonial Section
 */
function atarr_get_help() {

	ob_start(); ?>

		<section class="I-can-help">
			<h2><?php esc_html_e( 'How I Can Help', 'atarr' ); ?></h2>

		</section><!--.section-->

	<?php
	return ob_get_clean();
}

/**
 * Testimonial Section
 */
function atarr_get_testimonial_section() {

	ob_start(); ?>

		<?php $testimonials = atarr_query_testimonials(); ?>

		<section class="testimonials">
			<h2><?php esc_html_e( 'People Say Nice Things', 'atarr' ); ?></h2>

			<div class="testimonials-shell">
		<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

		<?php
			$url = get_post_meta( get_the_ID(), 'testimonial_url', true );
			$image = get_field( 'testimonial_photo' )['sizes']['thumbnail'];
			$alt = get_field( 'testimonial_photo' )['alt'];
			$source = get_post_meta( get_the_ID(), 'source', true );
		?>

			<figure class="testimonial-single">
				<div class="testimonial-single-shell">
					<?php if ( ! empty( $image ) ) : ?>
						<img class="testimonial-photo" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $alt ); ?>">
					<?php endif; ?>

					<div class="quote-content">
						<figcaption>
							<?php the_content(); ?>
						</figcaption>

						<?php if ( ! empty( $url ) ) : ?>
							<a class="testimonial-link" href="<?php echo esc_url( $url ); ?>"><?php the_title(); ?></a>
						<?php else : ?>
							<p class="testimonial-name"><?php the_title(); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $source ) ) : ?>
							<p class="testimonial-source"><?php echo esc_html( $source ); ?></p>
						<?php endif; ?>
					</div><!--.quote-content-->
				</div><!--.testimonial-single-shell-->
			</figure><!--.testimonial-single-->

		<?php endwhile; ?>
			</div><!--.testimonial-shell-->

		</section><!--.section-->

	<?php
	return ob_get_clean();
}

/**
 * Testimonial Section
 */
function atarr_get_factoids() {
	ob_start(); ?>

	<?php if ( has_sub_field( 'factoids' ) ) : ?>

		<section class="factoids">
			<h5><?php esc_html_e( 'Extras', 'atarr' ); ?></h5>

			<div class="factoid-shell">
			<?php while ( has_sub_field( 'factoids' ) ) : ?>

				<div class="factoid">
					<?php the_sub_field( 'icon' ); ?>

					<div class="fact-content">
						<h4><?php the_sub_field( 'fact_title' ); ?></h4>
						<p><?php the_sub_field( 'fact' ); ?></p>
					</div>
				</div> <!--/.factoid-->
			<?php endwhile; ?>
			</div>
		</section> <!--/.about-skills-->
	<?php endif; ?>

	<?php
	return ob_get_clean();
}
