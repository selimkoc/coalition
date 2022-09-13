<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CT_Custom
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ct-custom' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="upper-header">
			<div class="upper-header-canvas">
				<div class="upper-header-left">
<?php $options=get_option( 'my_option_name' );?>

<span class="callusnow">
	<a href="tel:<?php echo $options['phone_number']; ?>">Call Us Now!</a>
</span>
<span class="white">
<a href="tel:<?php echo $options['phone_number']; ?>"><?php echo $options['phone_number']; ?></a>
</span></div>
<div class="upper-header-right">
	<a class="login" href="/wp-login.php">Login</><a class="white" href="#">Sign Up</a>
</div>
</div></div>
		<div class="lower-header-canvas">
		<div class="lower-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			?>
		</div><!-- .site-branding -->
<div class="top-navigation">
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ct-custom' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</div></div></div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
