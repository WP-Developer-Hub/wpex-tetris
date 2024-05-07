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
    <!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script><![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <style>
        <?php echo universal_dynamic_css();?>
    </style>
    <?php wp_head(); ?>
</head>
 
<body <?php body_class(); ?>>
 
<div id="wrap" class="clearfix">
 
    <div id="header-wrap" class="clearfix">
        <header id="header" class="u-grid clearfix">
            <div id="header-upper" class="u-flex u-ai-c u-jc-sb clearfix">
                <div id="logo" class="u-flex u-ai-c u-block-100 clearfix">
                    <?php
                        // Show custom image logo if defined in the admin
                        if (has_custom_logo()) {
                            the_custom_logo();
                        ?>
                    <?php }
                        // No custom img logo - show text logo
                        else { ?>
                        <h2><a href="<?php echo home_url(); ?>/" title="<?php echo get_bloginfo( 'name' ); ?>" rel="home"><?php echo get_bloginfo( 'name' ); ?></a></h2>
                    <?php } ?>
                </div><!-- /logo -->
                <?php get_search_form(); ?>
            </div>
            <nav id="navigation" class="u-flex u-ai-c u-block-100 clearfix">
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
            <summary for="drop" id="main-toggle" class="menu-toggle u-jc-sb"><span class="menu-summary-name u-tt-all-uppercase"><?php echo esc_html('Menu', 'universal-theme')?></span>  <span class="dashicons dashicons-menu"></span> </summary>
            <?php
                wp_nav_menu(array(
                    'container' => false,
                    'fallback_cb'=> false,
                    'sort_column' => 'menu_order',
                    'theme_location' => 'main_menu',
                    'walker' => new universal_menu_walker_2_0(),
                ));
            ?>
        </details>
    </div><!-- #header-wrap -->
 
    <div id="main-content" class="light clearfix">
