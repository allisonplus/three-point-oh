<?php
/**
 * Template part for displaying card (for blog / portfolio CPT).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

?>

<article <?php post_class( 'post-card' ); ?>>
	<header class="entry-header">
	<a tabindex="-1" aria-hidden="true" role="presentation" href="<?php echo esc_url( get_permalink() ); ?>"><?php atarr_do_card_image( 'featured-card' ); ?></a>
	</header><!-- .entry-header -->

		<div class="entry-content">
			<div class="card-shell">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<p class="card-excerpt"><?php echo atarr_get_the_excerpt( array( 'length' => 26 ) ) // WPCS: XSS OK. ?></p>
		</div><!-- .card-shell -->
		<?php echo atarr_continue_reading_link(); // WPCS: XSS OK.  ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
