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
		wp_enqueue_style( 'opensans', '//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,300,600,700&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext', 'style' );

		// Comment replies
		if ( is_single() || is_page()) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
 
    add_action( 'wp_enqueue_scripts','wpex_load_scripts' );
}

if ( ! function_exists( 'wp_load_player_scripts' ) ) {
    function wp_load_player_scripts() {
        // Enqueue Universal player stylesheet
        wp_enqueue_style( 'universal-player', get_template_directory_uri() . '/css/universal-player.css', array(
            'wp-mediaelement',
        ), '1.0' );
    }
    add_action('wp_footer', 'wp_load_player_scripts');
}

if ( ! function_exists( 'universal_mejs_add_container_class' ) ) {
    function universal_mejs_add_container_class() {
        if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
            return;
        }
        ?>
        <script>
        (function() {
            var settings = window._wpmejsSettings || {};
            settings.features = settings.features || mejs.MepDefaults.features;
            settings.features.push( 'exampleclass' );
            MediaElementPlayer.prototype.buildexampleclass = function( player ) {
                player.container.addClass( 'universal-mejs-container u-media-16-9' );
            };
        })();
    
        // Function to handle fullscreen changes
        jQuery(document).ready(function($) {
            function handleFullscreenChange() {
                if (document.fullscreenElement) {
                    $('video').css('max-height', 'none');
                } else {
                    $('video').css('max-height', '512px');
                }
            }
    
            // Attach event listener to fullscreen changes
            $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', handleFullscreenChange);
    
            // Initial setup to ensure the max-height is set correctly on load
            handleFullscreenChange();
    
            // Make sure all instances wp-video & wp-playlist in inner-post 512px.
            function wrapMediaElements() {
               $('.inner-post .wp-video, .inner-post .wp-playlist').each(function() {
                   if (!$(this).closest('.post-media').length) {
                        if (!$(this).hasClass('wp-audio-playlist')) {
                            var $wrapper = $('<div class="post-media u-media-16-9 u-pos-rel"></div>');
                            $(this).wrap($wrapper);
                        }
                        $(this).css('width', '100%');
                   }
               });
               $('.inner-post .post-media, .inner-post .wp-playlist, .inner-post .wp-audio').css('margin-block', '0.5rem');
            }
    
            wrapMediaElements();
        });
        </script>
        <?php
    }
    add_action('wp_print_footer_scripts', 'universal_mejs_add_container_class');
}

if ( ! function_exists( 'wpx_add_reduced_motion_styles' ) ) {
    function wpx_add_reduced_motion_styles() {
        if ( !defined( 'WP_DEBUG' ) || !WP_DEBUG ) {
            echo "
                <style>
                    @media (prefers-reduced-motion: reduce) {
                        *, *::after, *::before {
                            /* Reduce durations significantly */
                            animation-duration: 100ms !important;
                            transition-duration: 0ms !important;

                            /* Use fades instead of more complex motion */
                            animation-timing-function: ease-in-out;
                            transition-timing-function: ease-in-out;
                        }
                    }
                </style>
            ";
        }
    }
    add_action( 'wp_head', 'wpx_add_reduced_motion_styles', PHP_INT_MAX );
}

