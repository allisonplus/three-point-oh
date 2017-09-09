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


	<div class="portfolio-single-shell">
		<div class="portfolio-featured-wrapper">
			<?php echo atarr_get_portfolio_gallery(); // WPCS: XSS OK.  ?>

		<?php if ( get_field( 'url' ) ) : ?>
			<a class="button project-link" href="<?php esc_url( the_field( 'url' ) ); ?>"><?php esc_html_e( 'View Live', 'atarr' ); ?></a> -->
		</div>
		<?php endif ?>

		<div class="entry-content">
			<h3><?php esc_html_e( 'Project Details', 'atarr' ); ?></h3>
			<?php the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'atarr' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) ); ?>
		</div><!-- .entry-content -->
	</div>

	<footer class="entry-footer">

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atarr' ),
			'after'  => '</div>',
		) );
		?>

		<?php atarr_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
