<?php
/**
 * Template part for displaying orbs section.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package atarr
 */

?>

<section <?php post_class( 'heroine-wrapper' ); ?>>
	<?php

	echo atarr_do_p5(); // WPCS: XSS OK. ?>

	<?php
		the_content( sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'atarr' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );
	?>
</section><!-- #post-## -->
