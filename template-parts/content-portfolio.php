<?php
/**
 * Template part for displaying single portfolio content (CPT).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title">', '</h2>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		// Featured image.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'large', [ 'class' => 'portfolio-featured' ] );
		}

			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'atarr' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			if ( get_field( 'url' ) ) : ?>
			<a class="button project-link" href="<?php esc_url( the_field( 'url' ) ); ?>"><?php esc_html_e( 'Project Link', 'atarr' ); ?></a>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		// Get gallery of images.
		$images = get_field( 'images' );

		if ( $images ) : ?>
			<ul class="image-gallery">
				<?php foreach ( $images as $image ) : ?>
				<li class="portfolio-gallery-single">
					<a href="<?php echo esc_url( $image['url'] ); ?>">
						<img src="<?php echo esc_url( $image['sizes']['featured-card'] ); ?>" alt="<?php echo esc_html( $image['alt'] ); ?>" />
					</a>
					<!-- <p><?php echo esc_html( $image['caption'] ); ?></p> -->
				</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atarr' ),
			'after'  => '</div>',
		) );
		?>
		<?php atarr_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
