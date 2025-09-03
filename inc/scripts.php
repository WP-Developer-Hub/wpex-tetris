<?php
/**
 * Loads CSS and JS scripts on the front-end
 *
 * @package   Tetris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    return;
}
 
if ( ! function_exists( 'wpex_load_scripts' ) ) {
     
    function wpex_load_scripts() {
         
        /*******
        *** CSS
        *******************/
        $dir = get_template_directory_uri().'/css';
 
        // Enqueue Dashicons only for users without plugin activation capability (non-admins)
        if (!current_user_can('activate_plugins')) {wp_enqueue_style('dashicons');}

        // Layout
        wp_enqueue_style( 'layout-ufg', $dir . '/ufg.css' );
 
        // Gallery
        wp_enqueue_style( 'gallery', $dir . '/gallery.css' );
 
        // Main
        wp_enqueue_style( 'style', get_stylesheet_uri() );
 
        // Form Elements
        wp_enqueue_style( 'form-elements', $dir . '/ufc.css' );
 
        // Plugin
        wp_enqueue_style( 'plugin', $dir . '/plugins.css' );
 
        // Responsive
        wp_enqueue_style( 'wpex-responsive', $dir . '/responsive.css' );
 
        // Google Fonts
        wp_enqueue_style( 'opensans', '//fonts.googleapis.com/css2?family=Open+Sans:400italic,600italic,700italic,400,300,600,700&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext&family=Major+Mono+Display', 'style' );
 
        // Comment replies
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {wp_enqueue_script( 'comment-reply' );}
    }
  
    add_action( 'wp_enqueue_scripts','wpex_load_scripts' );
}
 
if ( ! function_exists( 'wpex_enqueue_mediaelement_fix' ) ) {
    function wpex_enqueue_mediaelement_fix() {
        if ( wp_script_is( 'mediaelement', 'enqueued' ) ) {
            $dir = get_template_directory_uri();

            // Enqueue Universal player stylesheet
            wp_enqueue_style( 'universal-player', $dir . '/css/universal-player.css', array(
                'wp-mediaelement',
            ), '1.0');

            wp_enqueue_script( 'wp-mediaelement-fix', $dir . '/js/wp-mediaelement-fix.js', array(
                'wp-mediaelement'
            ), '1.0', true );
        }
    }
    add_action('wp_footer', 'wpex_enqueue_mediaelement_fix');
}
