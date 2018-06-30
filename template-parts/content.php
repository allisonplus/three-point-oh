<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif ( ! is_front_page() ) {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php echo atarr_card_posted_on(); // WPCS: XSS OK. ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'starry' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'starry' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php atarr_entry_footer();

		$cta = get_field( 'cta_button' );
		if ( $cta ) : ?>
			<div class="hire-wrapper">
				<p><?php esc_html_e( 'Like what you read & want to benefit from my skills?', 'starry' ); ?></p>
				<a class="button hire" href="/contact"><?php esc_html_e( 'Hire me!', 'starry' ); ?></a>
			</div>
		<?php endif;
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
