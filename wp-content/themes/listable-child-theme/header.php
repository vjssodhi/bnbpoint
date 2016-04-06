<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listable
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-mapbox-token="<?php echo listable_get_option('mapbox_token', ''); ?>" data-mapbox-style="<?php echo listable_get_option('mapbox_style', ''); ?>">
<div id="page" class="hfeed site">
<?php
if (is_user_logged_in() && is_front_page() ) { 
    $current_user = wp_get_current_user();?>
    <div class="section-wrap">
	<div class="welcome">
	<p>Hello <?php echo $current_user->display_name;?>, Welcome to your local Irishcare.ie community. Feel Free To Contact Us Any Time You Need a Helping Hand!</p></div></div>
	
<?php }?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'listable' ); ?></a>

	<header id="masthead" class="site-header  <?php if( is_page_template( 'page-templates/front_page.php' ) && (listable_get_option( 'header_transparent', true ) == true) ) echo 'header--transparent'; ?>" role="banner">
		<?php
		if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) { // display the Site Logo if present ?>
			<div class="site-branding  site-branding--image">
				<?php jetpack_the_site_logo(); ?>
			</div>
		<?php } else { ?>
			<div class="site-branding">
				<h1 class="site-title  site-title--text"><a class="site-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</div><!-- .site-branding -->
		<?php } ?>

		<?php get_template_part( 'template-parts/header-fields' ); ?>

		<button class="menu-trigger  menu--open  js-menu-trigger">

			<?php get_template_part( 'assets/svg/menu-bars-svg' ); ?>

		</button>
		<nav id="site-navigation" class="menu-wrapper" role="navigation">
			<button class="menu-trigger  menu--close  js-menu-trigger">

				<?php get_template_part( 'assets/svg/close-icon-svg' ); ?>

			</button>

			<?php
			wp_nav_menu( array(
				'container' => false,
				'theme_location' => 'primary',
				'menu_class' => 'primary-menu',
				'walker' => new Listable_Walker_Nav_Menu(),
			) );
			wp_nav_menu( array(
				'container_class' => 'secondary-menu-wrapper',
				'theme_location' => 'secondary',
				'menu_class' => 'primary-menu secondary-menu',
				'fallback_cb' => false,
				'walker' => new Listable_Walker_Nav_Menu(),
			) ); ?>

		</nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
	<?php	
	if(get_the_id() == 68 || get_the_id() == 11041 || get_the_id() == 1167 || get_the_id() == 11113 || get_the_id() == 11115 || get_the_id() == 11119){
		wp_nav_menu( array('menu' => 'Secondary Menu','menu_class'=>'primary-menu')); 
	}
	?>		
