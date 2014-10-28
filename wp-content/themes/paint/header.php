<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link href='http://fonts.googleapis.com/css?family=Patrick+Hand&subset=latin,vietnamese,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,vietnamese,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
    <script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.simplyscroll.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/jquery.simplyscroll.css" media="all" type="text/css">
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
        <div class="topheader"></div>
		<div class="header-main">
            <div id="bigheaderimg">
                <img src="<?php echo get_template_directory_uri(); ?>/images/header.png" />
            </div>
            <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"></a></div>
            <div class="roller"></div>
			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
		</div>
	</header><!-- #masthead -->

	<div id="main" class="site-main">
