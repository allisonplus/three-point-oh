<?php
/**
 * Markup for ACF Fields.
 *
 * @package atarr
 */

// Hide ACF menu.
add_filter( 'acf/settings/show_admin', '__return_false' );

/**
 * 'How I Can Help' Section
 */
function atarr_get_help() {

	$helping_section = get_field( 'helping_section' );

	// Stop if there's nothing to display.
	if ( ! $helping_section ) {
		return false;
	}

	ob_start(); ?>

		<section class="i-can-help">

		<?php if ( have_rows( 'helping_section' ) ) :

			while ( have_rows( 'helping_section' ) ) : the_row(); ?>

				<?php if ( have_rows( 'help_list' ) ) : ?>

				<div class="help-shell">
					<?php while ( have_rows( 'help_list' ) ) : the_row(); ?>

							<div class="help-single">
								<?php echo esc_html( the_sub_field( 'icon' ) ); ?>
								<h3><?php echo esc_html( the_sub_field( 'title' ) ); ?></h3>
								<?php echo wp_kses_data( the_sub_field( 'content' ) ); ?>

								<?php if ( get_sub_field( 'cta_button' ) ) : ?>

								<a class="button button-cta" href="<?php echo esc_url( get_sub_field( 'cta_button' ) ); ?>"><?php echo esc_html( the_sub_field( 'button_text' ) ); ?></a>

								<?php endif; ?>
							</div><!--.help-single-->

					<?php endwhile; ?>
				</div><!--.help-shell-->
			</section><!--.section-->

				<?php endif; ?>

			<?php endwhile; ?>

		<?php endif; ?>

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
			<div class="testimonials-shell wrap">
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

					<div class="quote-container">
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
					</div><!--.quote-container-->
				</div><!--.testimonial-single-shell-->
			</figure><!--.testimonial-single-->

		<?php endwhile; ?>
			</div><!--.testimonial-shell-->

		</section><!--.section-->

	<?php
	return ob_get_clean();
}

/**
 * Single Portfolio Image(s)
 */
function atarr_get_portfolio_gallery() {
	ob_start(); ?>

	<?php

	// Get gallery of images.
	$images = get_field( 'images' );
	$size = 'portfolio';

	if ( $images ) : ?>

		<ul class="image-gallery">
			<?php foreach ( $images as $image ) : ?>
			<li class="portfolio-gallery-single">
				<?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php
	return ob_get_clean();
}

/**
 * Factoids Section (About Page)
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
						<h4><?php esc_html( the_sub_field( 'fact_title' ) ); ?></h4>
						<p><?php esc_html( the_sub_field( 'fact' ) ); ?></p>
					</div>
				</div> <!--/.factoid-->
			<?php endwhile; ?>
			</div>
		</section> <!--/.about-skills-->
	<?php endif; ?>

	<?php
	return ob_get_clean();
}

/**
 * Transferring ACF fields to js/secret-heroine.js file
 */
function atarr_identity_variables() {

	wp_localize_script( 'atarr-super-heroine', 'acf_vars', array(
			'list_parent' => get_field( 'heroine_secret_identity' ),
		)
	);
}
