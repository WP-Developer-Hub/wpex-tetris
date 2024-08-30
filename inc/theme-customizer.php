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
        'default' => 'title_only',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('universal_title_tagline_visibility', array(
        'label' => __('Site Title and Tagline Visibility', 'tetris'),
        'description' => __('Choose whether the site title and tagline should be displayed.', 'tetris'),
        'section' => 'title_tagline',
        'type' => 'select',
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
        'description' => __('This panel contains various settings for customizing the theme.', 'tetris'),
    ));

    // Grid Settings Section
    $wp_customize->add_section('universal_grid_item_settings_section', array(
        'title' => __('Grid Item Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings related to grid layout.', 'tetris'),
    ));

    // Toggle Read More Link
    $wp_customize->add_setting('universal_toggle_read_more_link', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_toggle_read_more_link', array(
        'label' => __('Toggle Read More Link', 'tetris'),
        'description' => __('Enable or disable the read more link below the post excerpt on the grid item.', 'tetris'),
        'section' => 'universal_grid_item_settings_section',
        'type' => 'select',
        'choices' => array(
            'true' => __('Enabled', 'tetris'),
            'false' => __('Disabled', 'tetris'),
        ),
    ));

    // Excerpt Length
    $wp_customize->add_setting('universal_excerpt_length', array(
        'default' => 20,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('universal_excerpt_length', array(
        'label' => __('Post Excerpt Length', 'tetris'),
        'description' => __('Adjust the length of the post excerpt on the grid item.', 'tetris'),
        'section' => 'universal_grid_item_settings_section',
        'type' => 'number',
        'input_attrs' => array(
            'step' => 1,
            'min' => 6,
            'max' => 55,
            'pattern' => '[0-9]*',
            'inputmode' => 'numeric',
        ),
    ));

    // Post Page Settings Section
    $wp_customize->add_section('universal_single_post_page_settings_section', array(
        'title' => __('Single Post Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings related to single post pages.', 'tetris'),
    ));

    // Toggle Post Thumbnail
    $wp_customize->add_setting('universal_toggle_post_thumbnail', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_toggle_post_thumbnail', array(
        'label' => __('Toggle Post Thumbnail', 'tetris'),
        'description' => __('Enable or disable the post thumbnail on single post pages.', 'tetris'),
        'section' => 'universal_single_post_page_settings_section',
        'type' => 'select',
        'choices' => array(
            'true' => __('Enabled', 'tetris'),
            'false' => __('Disabled', 'tetris'),
        ),
    ));

    // Footer Settings Section
    $wp_customize->add_section('universal_footer_settings_section', array(
        'title' => __('Footer Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings for customizing the footer.', 'tetris'),
    ));

    // Started Date
    $wp_customize->add_setting('universal_footer_start_date', array(
        'default' => date('Y-m-d'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_footer_start_date', array(
        'label' => __('Start Date', 'tetris'),
        'description' => __('Select the date you started.', 'tetris'),
        'section' => 'universal_footer_settings_section',
        'type' => 'date',
    ));

    // Copyright Layout
    $wp_customize->add_setting('universal_copyright_layout', array(
        'default' => '[copyright_symbol] [site_name], [started_date][dash][current_date].',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('universal_copyright_layout', array(
        'label' => __('Copyright Info Layout', 'tetris'),
        'description' => __('You can use placeholders like [site_name], [started_date], [current_date], [copyright_symbol], and [dash] to dynamically layout the copyright. P.S placeholders like [started_date], [current_date] will only toggle the year.', 'tetris'),
        'section' => 'universal_footer_settings_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'universal_customizer_settings');
?>
