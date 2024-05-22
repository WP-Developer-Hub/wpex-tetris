<?php
/**
 * Theme Customizer Settings and Controls
 * Registers settings and controls for theme customization.
 *
 * @link https://developer.wordpress.org/themes/customize-api/
 *
 * @package Universal Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
   return;
}

function universal_customizer_settings($wp_customize) {
    // Accent Color Setting and Control
    $wp_customize->add_setting('universal_accent_color', array(
        'default' => '#0073e6',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'universal_accent_color', array(
        'label' => __('Accent Color', 'tetris'),
        'section' => 'colors',
        'mode' => 'full',
    )));

    // Title & Tagline Visibility
    $wp_customize->add_setting('universal_title_tagline_visibility', array(
        'default' => "title_only",
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    $wp_customize->add_control('universal_title_tagline_visibility', array(
        'type' => 'select',
        'label' => __('Site Title & Tagline Visibility', 'tetris' ),
        'description' => __('Choose whether the site title and tagline should be displayed.', 'tetris'),
        'section' => 'title_tagline',
        'choices' => array(
            'none' => __('None', 'tetris'),
            'title_only' => __('Site Title Only', 'tetris'),
            'tagline_only' => __('Tagline Only', 'tetris'),
        ),
     ));

    // Theme Settings Panel
    $wp_customize->add_panel('universal_theme_settings_panel', array(
        'title' => __('Theme Settings', 'tetris'),
        'priority' => 30,
        'description' => __('This panel contains various settings for customizing the theme.', 'tetris'), // Added description
    ));

    // Post Page Settings Section
    $wp_customize->add_section('universal_post_page_settings_section', array(
        'title' => __('Post Page Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings related to single post pages.', 'tetris'), // Added description
    ));

    // Show Post Thumbnail
    $wp_customize->add_setting('universal_show_post_thumbnail', array(
        'default' => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('universal_show_post_thumbnail', array(
        'label' => __('Show Post Thumbnail', 'tetris'),
        'description'        => __('Enable this option to display the post thumbnail on single post pages.', 'tetris'),
        'section' => 'universal_post_page_settings_section',
        'type' => 'checkbox',
    ));

    // Footer Settings Section
    $wp_customize->add_section('universal_footer_settings_section', array(
        'title' => __('Footer Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings for customizing the footer.', 'tetris'),
    ));

    // Started Date
    $wp_customize->add_setting('universal_footer_started_date', array(
        'default' => date('Y-m-d'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_footer_started_date', array(
        'label' => __('Started Date', 'tetris'),
        'description' => __('Select the date you started.', 'tetris'),
        'section' => 'universal_footer_settings_section',
        'type' => 'date',
    ));

    // Copyright Layout
    $wp_customize->add_setting('universal_copyright_layout', array(
        'default' => '[copyright_symbol] [site_name], [started_date][dash][current_date].',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control('universal_copyright_layout', array(
        'label' => __('Copyright Message', 'tetris'),
        'description' => __('You can use placeholders like [site_name] [started_date], [current_date], [copyright_symbol], and [dash] to dynamically layout the copyright. P.S placeholders like [started_date], [current_date] will only show the year.', 'tetris'),
        'section' => 'universal_footer_settings_section',
        'type' => 'textarea',
    ));

    function universal_slug_sanitize_checkbox( $input ){
        return ( isset( $input ) ? true : false );
    }
}
add_action('customize_register', 'universal_customizer_settings');
?>
