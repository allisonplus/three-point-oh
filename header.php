<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package atarr
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php global $is_IE; if ( $is_IE ) : ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php endif; ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'starry' ); ?></a>

	<header class="site-header">
		<div class="wrap">

		<h1 class="site-title"><a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Allison Tarr', 'starry' ); ?></a></h1>

		<button class="sliding-panel-button mobile-menu-toggle" type="button">
			<span class="mobile-menu-bar line-1"></span>
			<span class="mobile-menu-bar line-2"></span>
			<span class="mobile-menu-bar line-3"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'starry' ); ?></span>
		</button>

		<div class="navigation-wrapper sliding-panel-content header-mobile">

			<nav id="site-navigation" class="main-navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'menu menu-horizontal main-menu',
					) );
				?>
			</nav><!-- #site-navigation -->
		</div>

		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
