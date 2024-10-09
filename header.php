<?php
/**
 * The Header for our theme.
 *
 * @package   Today WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    return;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <style>
        <?php echo universal_dynamic_css();?>
    </style>
    <meta name='theme-color' content='#212121'>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="wrap" class="u-fc">
 
    <div id="header-wrap" class="clearfix">
        <header id="header" class="u-flex u-ai-c u-jc-sb clearfix">
            <div id="logo" class="u-flex u-ai-c u-block-100 clearfix">
                <?php universal_theme_custom_logo(); ?>
            </div><!-- /logo -->
            <nav id="navigation" class="u-flex u-ai-c clearfix">
                <?php wp_nav_menu( array(
                    'container' => false,
                    'fallback_cb' => false,
                    'menu_class' => 'main-menu',
                    'sort_column' => 'menu_order',
                    'theme_location' => 'main_menu',
                )); ?>
            </nav><!-- #navigation -->
        </header><!-- #header -->
        <details id="mobile-navigation">
            <summary id="main-toggle" class="menu-toggle u-jc-sb"><span class="menu-summary-name u-tt-all-uppercase"><?php echo esc_html('Menu', 'tetris')?></span>  <span class="dashicons dashicons-menu"></span> </summary>
            <?php
                wp_nav_menu(array(
                    'container' => false,
                    'fallback_cb'=> false,
                    'sort_column' => 'menu_order',
                    'theme_location' => 'main_menu',
                    'walker' => new universal_menu_walker_2_0(),h
                ));
            ?>
        </details>
    </div><!-- #header-wrap -->
 
    <div id="main-content" class="ufc_light clearfix">
