<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package atarr
 */

?>

	</div><!-- #content -->

	<footer class="site-footer">
		<div class="wrap footer-shell">
			<div class="site-info">
				<?php echo atarr_do_copyright_text(); // WPCS: XSS OK. ?>
			</div>

			<?php echo atarr_get_social_links(); // WPCS: XSS OK. ?>
		</div><!-- .wrap -->
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
