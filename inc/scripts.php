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

        if (!current_user_can('activate_plugins')) {
            wp_enqueue_style('dashicons');
        }
        // Layout
        wp_enqueue_style( 'layout-ufg', $dir . '/ufg.css' );

		// Main
		wp_enqueue_style( 'style', get_stylesheet_uri() );

        // Form Elements
        wp_enqueue_style( 'form-elements', $dir . '/ufc.css' );

        // Layout
        wp_enqueue_style( 'plugin-style', $dir . '/plugins.css' );

		// Responsive
		wp_enqueue_style( 'wpex-responsive', $dir . '/responsive.css' );

		// Google Fonts
		wp_enqueue_style( 'opensans', '//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,300,600,700&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext', 'style' );

		// Comment replies
		if ( is_single() || is_page()) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts','wpex_load_scripts' );

if ( ! function_exists( 'wp_load_player_scripts' ) ) {
    function wp_load_player_scripts() {
        // Enqueue Universal player stylesheet
        wp_enqueue_style( 'universal-player', get_template_directory_uri() . '/css/universal-player.css', array(
            'wp-mediaelement',
        ), '1.0' );
    }
}
add_action('wp_footer', 'wp_load_player_scripts');
