<?php
/**
 * Adds Customizer Settings
 *
 * @package   Today WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

function wpex_customizer_general($wp_customize) {

	// Theme Settings Section
	$wp_customize->add_section( 'wpex_general' , array(
		'title'		=> __( 'Theme Settings', 'tetris' ),
		'priority'	=> 200,
	) );

	// Enable/Disable Social
	$wp_customize->add_setting( 'wpex_header_aside', array(
		'type'		=> 'theme_mod',
		'default'	=> '1',
		'sanitize_callback' => 'esc_html'
	) );

	$wp_customize->add_control( 'wpex_header_aside', array(
		'label'		=> __('Social Links','tetris'),
		'section'	=> 'wpex_general',
		'settings'	=> 'wpex_header_aside',
		'type'		=> 'checkbox',
		'priority'	=> '4',
	) );

	// Copyright
	$wp_customize->add_setting( 'wpex_copyright', array(
		'type'		=> 'theme_mod',
		'default'	=> 'Powered by <a href=\"http://www.wordpress.org\" title="WordPress" target="_blank">WordPress</a> and <a href=\"http://themeforest.net/user/WPExplorer?ref=WPExplorer" target="_blank" title="WPExplorer" rel="nofollow">WPExplorer Themes</a>',
		'sanitize_callback' => 'wp_kses_post'
	) );

	$wp_customize->add_control( 'wpex_copyright', array(
		'label'		=> __( 'Custom Copyright', 'tetris' ),
		'section'	=> 'wpex_general',
		'settings'	=> 'wpex_copyright',
		'type'		=> 'textarea',
		'priority'	=> '8',
	) );

	// Theme Settings Section
	$wp_customize->add_section( 'wpex_social' , array(
		'title'		=> __( 'Social Options', 'tetris' ),
		'priority'	=> 201,
	) );

	// Social Options
	$social_options = wpex_social_links();
	$count=0;
	foreach ( $social_options as $social_option ) {
		$count++;
		$name = $social_option = str_replace('_', ' ', $social_option);
		$name = ucfirst( $name );
		$wp_customize->add_setting( 'wpex_social_'. $social_option, array(
			'type'		        => 'theme_mod',
			'default'	        => '',
			'sanitize_callback' => 'esc_url'
		) );
		$wp_customize->add_control( 'wpex_social_'. $social_option, array(
			'label'		=> $name,
			'section'	=> 'wpex_social',
			'settings'	=> 'wpex_social_'. $social_option,
			'type'		=> 'text',
			'priority'	=> $count,
		) );
	}
		
}

add_action( 'customize_register', 'wpex_customizer_general' );
