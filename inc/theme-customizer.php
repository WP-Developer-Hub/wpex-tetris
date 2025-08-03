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

require_once get_template_directory() . '/inc/class-wpx-customizer-controls/class-wpx-customizer-controls.php';

function universal_customizer_settings($wp_customize) {
    
    // Divider Setting
    $wp_customize->add_setting('universal_divider', array(
        'sanitize_callback' => '__return_true',
    ));

    // Accent Color Setting and Control
    $wp_customize->add_setting('universal_accent_color', array(
        'default' => array('#0073e6', '1', '1', '40', '-20'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WPX_Color_Picker_Control($wp_customize, 'universal_accent_color', array(
        'label' => __('Accent Color', 'tetris'),
        'section' => 'colors',
        'type' => 'text',
        'input_attrs' => array(
            'step' => 1,
            'min' => -50,
            'max' => 50,
        ),
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

    $wp_customize->add_section(new WPX_Link_Section($wp_customize, 'upsell_section',
        array(
            'title' => __('WP Developer Hub', 'tetris'),
            'url' => 'https://github.com/WP-Developer-Hub/',
            'priority' => 0,
            'panel' => 'universal_theme_settings_panel',
        )
    ));

    // General Settings Section
    $wp_customize->add_section('universal_general_settings_section', array(
        'title' => __('General Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains General settings.', 'tetris'),
    ));

    // Date Display Options
    $wp_customize->add_setting('universal_date_display_option', array(
        'default' => 'date',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_date_display_option', array(
        'label' => __('Choose Post Date Type', 'tetris'),
        'description' => __('Select which date to display.', 'tetris'),
        'section' => 'universal_general_settings_section',
        'type' => 'select',
        'choices' => array(
            'date' => __('Published Date', 'tetris'),
            'modified_date'=> __('Modified Date', 'tetris'),
        ),
    ));

    // Sidebar Settings Section
    $wp_customize->add_section('universal_sidebar_settings_section', array(
        'title' => __('Sidebar Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('Options for sidebar display and behavior.', 'tetris'),
    ));

    // Hide Search Box in Sidebar
    $wp_customize->add_setting('universal_hide_sidebar_search', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_hide_sidebar_search', array(
        'label' => __('Hide Search Box in Sidebar', 'tetris'),
        'description' => __('Toggle to remove the search box from the sidebar area.', 'tetris'),
        'section' => 'universal_sidebar_settings_section',
        'settings' => 'universal_hide_sidebar_search',
    )));

    // Hide Sidebar Widgets on Mobile Devices
    $wp_customize->add_setting('universal_hide_sidebar_mobile', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_hide_sidebar_mobile', array(
        'label' => __('Hide Widgets on Mobile', 'tetris'),
        'description' => __('Toggle to hide all sidebar widgets on screens 767px wide or less. Useful for a cleaner mobile layout.', 'tetris'),
        'section' => 'universal_sidebar_settings_section',
        'settings' => 'universal_hide_sidebar_mobile',
    )));


    // Grid Settings Section
    $wp_customize->add_section('universal_grid_item_settings_section', array(
        'title' => __('Grid Item Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings related to grid layout.', 'tetris'),
    ));

    // Aspect Ratio Setting
    $wp_customize->add_setting('universal_aspect_ratio', array(
        'default' => '1:1',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Ratio_Control($wp_customize, 'universal_aspect_ratio', array(
        'label' => __('Aspect Ratio', 'tetris'),
        'description' => __('Select the aspect ratio for grid item images. Choose "auto" for the default or "1:1" for a square aspect ratio.', 'tetris'),
        'section' => 'universal_grid_item_settings_section',
        'type' => 'radio',
    )));

    $wp_customize->add_control(new WPX_Divider($wp_customize, 'universal_aspect_ratio_divider', array(
        'section' => 'universal_grid_item_settings_section',
        'settings' => 'universal_divider',
    )));

    // Toggle Post Badge
    $wp_customize->add_setting('universal_toggle_post_badge', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_toggle_post_badge', array(
        'label' => __('Toggle Post Badge', 'tetris'),
        'description' => __('Enable or disable the badge displayed on post thumbnails in grid items. The badge appears at the bottom-right corner and can be used for labels such as "New", "Feature", or others.', 'tetris'),
       'section' => 'universal_grid_item_settings_section',
    )));

    // Recent Post Badge Age
    $wp_customize->add_setting('universal_recent_post_keep_badge_for', array(
        'default' => 7,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('universal_recent_post_keep_badge_for', array(
        'label' => __('Keep Badge For', 'tetris'),
        'description' => __('Specify the number of days the "New" post badge should be visable for the posts grid. Min 7 days, Max 28 days.', 'tetris'),
        'section' => 'universal_grid_item_settings_section',
        'type' => 'number',
        'input_attrs' => array(
            'step' => 1,
            'min' => 7,
            'max' => 28,
            'pattern' => '[0-9]*',
            'inputmode' => 'numeric',
        ),
    ));

    $wp_customize->add_control(new WPX_Divider($wp_customize, 'universal_recent_post_badge_divider', array(
        'section' => 'universal_grid_item_settings_section',
        'settings' => 'universal_divider',
    )));

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

    // Toggle Read More Link
    $wp_customize->add_setting('universal_toggle_read_more_link', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_toggle_read_more_link', array(
       'label' => __('Toggle Read More Link', 'tetris'),
       'description' => __('Enable or disable the read more link below the post excerpt on the grid item.', 'tetris'),
       'section' => 'universal_grid_item_settings_section',
    )));

    // Post Page Settings Section
    $wp_customize->add_section('universal_single_post_page_settings_section', array(
        'title' => __('Single Post Settings', 'tetris'),
        'priority' => 30,
        'panel' => 'universal_theme_settings_panel',
        'description' => __('This section contains settings related to single post pages.', 'tetris'),
    ));

    // Gallery Image Link Type Option (for lightbox behavior)
    $wp_customize->add_setting('universal_gallery_link_type', array(
        'default' => 'attachment',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('universal_gallery_link_type', array(
        'label' => __('Gallery Link Type', 'tetris'),
        'description' => __('Select whether gallery images should link to file (for lightbox), attachment page, or none.', 'tetris'),
        'section' => 'universal_single_post_page_settings_section',
        'type' => 'select',
        'choices' => array(
            'none' => __('None', 'tetris'),
            'file' => __('Media File', 'tetris'),
            'attachment' => __('Attachment Page', 'tetris'),
        ),
    ));

    $wp_customize->add_control(new WPX_Divider($wp_customize, 'universal_gallery_link_type_divider', array(
        'section' => 'universal_grid_item_settings_section',
        'settings' => 'universal_divider',
    )));

    // Toggle Post Thumbnail
    $wp_customize->add_setting('universal_toggle_post_thumbnail', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_toggle_post_thumbnail', array(
        'label' => __('Toggle Post Thumbnail', 'tetris'),
        'description' => __('Enable or disable the post thumbnail on single post pages.', 'tetris'),
        'section' => 'universal_single_post_page_settings_section',
    )));

    // Toggle Post Tags
    $wp_customize->add_setting('universal_toggle_post_tags', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_toggle_post_tags', array(
        'label' => __('Toggle Post Tags', 'tetris'),
        'description' => __('Enable or disable the post tags on single post pages.', 'tetris'),
        'section' => 'universal_single_post_page_settings_section',
    )));

    // Toggle Post Author Box
    $wp_customize->add_setting('universal_toggle_post_author_box', array(
        'default' => 'true',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WPX_Toggle_Switch_Control($wp_customize, 'universal_toggle_post_author_box', array(
        'label' => __('Toggle Post Author Box', 'tetris'),
        'description' => __('Enable or disable the author box on single post pages.', 'tetris'),
        'section' => 'universal_single_post_page_settings_section',
    )));

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
    $wp_customize->add_control(new WPX_Extended_Date_Time_Control($wp_customize, 'universal_footer_start_date', array(
        'label' => __('Start Date', 'tetris'),
        'description' => __('Select the date you started.', 'tetris'),
        'section' => 'universal_footer_settings_section',
        'max' => date('Y-m-d'),
    )));

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
