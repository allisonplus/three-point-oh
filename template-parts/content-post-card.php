<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

?>

<article <?php post_class( 'post-card' ); ?>>
	<header class="entry-header">

	<?php atarr_do_card_image( 'featured-card' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php atarr_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

		<?php
			the_excerpt( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'atarr' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			// echo atarr_get_the_excerpt( array( // WPCS: XSS OK.
			// 	'length' => 20,
			// ) );
		?>
	</div><!-- .entry-content -->

<!-- 	<footer class="entry-footer">
		<?php atarr_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
