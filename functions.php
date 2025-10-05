<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Tetris WPExplorer Theme
 * @since Tetris 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Include files
 *
 * @since 1.0.0
 */
$dir = get_template_directory();

require_once $dir .'/inc/theme-customizer.php' ;
require_once $dir .'/inc/scripts.php' ;
require_once $dir .'/inc/widget-areas.php' ;
require_once $dir .'/inc/helper-functions.php' ;

if ( ! defined('WP_DEBUG') || ! WP_DEBUG ) {
    require_once $dir . '/inc/updates.php';
}

if (!is_admin()) {
    require_once $dir .'/inc/comments.php';
    require_once $dir .'/inc/universal-menu-walker-2-0.php';
} else {
    require_once $dir .'/inc/class-universal-meta-box/universal-meta-box.php';
}

/**
 * Theme setup
 *
 * @since 1.0.0
 */
function wpex_setup() {

    // Global content width var
    global $content_width;
    $content_width = 970;
    // Get accent color from theme customizer (default value if not set)
    $universal_accent_color = explode(',', get_theme_mod('universal_accent_color', '#0073e6, #fff, #0073e7, #fff, #0073e8, #fff'));

    // Check if the array has the expected number of elements
    if ( count($universal_accent_color) < 6 ) {
        // Ensure there are enough colors, filling with defaults if necessary
        $universal_accent_color = array_pad($universal_accent_color, 6, '#fff');
    }

    // Initialize the variables with fallbacks if empty
    $accent_color = !empty($universal_accent_color[0]) ? $universal_accent_color[0] : '#0073e6';
    $accent_color_light = !empty($universal_accent_color[4]) ? $universal_accent_color[4] : $accent_color;
    $accent_color_dark = !empty($universal_accent_color[2]) ? $universal_accent_color[2] : $accent_color;

    // Define an array of universal colors with names and corresponding colors
    $universal_colors = array(
        array(
            'name'  => __('Primary Color', 'tetris'),
            'slug'  => 'primary_color',
            'color' => get_theme_mod('bgcolor', '#d3d3d3'), // Use theme mod or default color
        ),
        array(
            'name'  => __('Accent Color', 'tetris'),
            'slug'  => 'accent_color',
            'color' => $accent_color, // Use theme mod or default color
        ),
        array(
            'name'  => __('Accent Color Light', 'tetris'),
            'slug'  => 'accent_color_light',
            'color' => $accent_color_light, // Use theme mod or default color
        ),
        array(
            'name'  => __('Accent Color Dark', 'tetris'),
            'slug'  => 'accent_color_dark',
            'color' => $accent_color_dark, // Use theme mod or default color
        ),
        array(
            'name'  => __('Black', 'tetris'),
            'slug'  => 'black',
            'color' => '#000000',
        ),
        array(
            'name'  => __('White', 'tetris'),
            'slug'  => 'white',
            'color' => '#FFFFFF',
        ),
        array(
            'name'  => __('Off White', 'tetris'),
            'slug'  => 'off_white',
            'color' => '#F9F9F9', // Off-white color
        ),
        array(
            'name'  => __('Dark Gray', 'tetris'),
            'slug'  => 'dark_gray',
            'color' => '#212121', // 13% gray
        ),
        array(
            'name'  => __('60% Gray', 'tetris'),
            'slug'  => '60_gray',
            'color' => '#999999', // 60% gray
        ),
        array(
            'name'  => __('40% Gray', 'tetris'),
            'slug'  => '40_gray',
            'color' => '#666666', // 40% gray
        ),
        array(
            'name'  => __('20% Gray', 'tetris'),
            'slug'  => '20_gray',
            'color' => '#333333', // 20% gray
        )
    );

    // Add support for post thumbnails (featured images)
    add_theme_support('post-thumbnails');

    // Add support for title tag in the <head>
    add_theme_support('title-tag');

    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script',
        'widgets',
        'navigation-widgets',
        'post-thumbnails',
        'custom-logo',
        'responsive-embeds',
        'custom-header',
        'custom-background',
        'title-tag',
        'align-wide',
        'align-full',
        'block-styles',
        'editor-styles',
        'html5-canvas'
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array('height' => false, 'width' => false, 'flex-width' => true, 'flex-height' => true));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'd3d3d3',
        'default-image' => '',
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_theme_support('dark-editor-style');

    // Add support for editor font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => __('small', 'tetris'),
            'shortName' => __('S', 'tetris'),
            'size' => 18,
            'slug' => 'small'
        ),
        array(
            'name' => __('normal', 'tetris'),
            'shortName' => __('M', 'tetris'),
            'size' => 20,
            'slug' => 'normal'
        ),
        array(
            'name' => __('large', 'tetris'),
            'shortName' => __('L', 'tetris'),
            'size' => 22,
            'slug' => 'large'
        ),
        array(
            'name' => __('larger', 'tetris'),
            'shortName' => __('XL', 'tetris'),
            'size' => 24,
            'slug' => 'larger'
        )
    ));

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for align wide
    add_theme_support('align-wide');

    // Add support for custom line height
    add_theme_support('custom-line-height');

    // Add support for custom units
    add_theme_support('custom-units', array('rem', 'em', 'px', '%', 'fr', 'vw', 'vh',));

    // Add support for disabling custom colors, font sizes, gradients, and layout styles
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-gradients');
    add_theme_support('disable-layout-styles');
    remove_theme_support('core-block-patterns');

    // Add support for editor color palette and gradient presets
    add_theme_support('editor-color-palette', $universal_colors);
    add_theme_support('editor-gradient-presets');

    // Add support for custom spacing
    add_theme_support('custom-spacing');

    // Add support for appearance tools
    add_theme_support('appearance-tools');

    // Add support for link color
    add_theme_support('link-color', array('color' => $accent_color, 'hover_color' => $accent_color_light));

    // Add support for border
    add_theme_support('border', $universal_colors);

    // Add support for featured content
    add_theme_support('featured-content');

    // Add support for starter content
    add_theme_support('starter-content', array(
        'widgets' => array(
            'footer-widget-2' => array(
               array(
                   'pages' => array(
                       'title' => 'Pages',
                   ),
               ),
            ),
            'footer-widget-1' => array(
               array(
                   'categories' => array(
                       'title' => 'Categories',
                   ),
               ),
            ),
            'main-sidebar' => array(
                'search' => array('search', array('title' => '')),
                'tag_cloud' => array('tag_cloud', array('title' => 'Custom Tags')),
                'archives' => array('archives', array('title' => 'Custom Archives')),
            ),
           'pages' => array(
                'About',
                'Blog',
                'Contact',
           ),
        ),
    ));

    // Add support for widgets block editor and WP block styles
    add_theme_support('widgets-block-editor');
    add_theme_support('wp-block-styles');

    // Add support for post formats (optional)
    add_theme_support('post-formats', array('gallery', 'audio', 'video', 'link',));

    // Add support for customize selective refresh widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for admin bar
    add_theme_support('admin-bar');

    // Add editor style
    add_editor_style('style.css');
    add_editor_style('css/ufg.css');
    add_editor_style('css/ufc.css');
    add_editor_style('css/plugin.css');
    add_editor_style('css/gallery.css');
    add_editor_style('css/responsive.css');
    add_editor_style('css/universal-player.css');

    // Example for register_block_style
    register_block_style(
        'your-custom-block-style', array(
            'name' => __('custom_block_style', 'tetris'),
            'label' => __('Custom Block Style', 'tetris'),
            'style_handle' => 'your-custom-block-style-css',
        )
    );

    // Register a custom block pattern for the Simple Basic Contact Form plugin
    register_block_pattern(
        'simple-basic-contact-form',
        array(
            'title' => __('Simple Basic Contact Form', 'tetris'),
            'description' => __('A block pattern with a single column for the Simple Basic Contact Form plugin shortcode. Requires the Simple Basic Contact Form plugin to be installed and activated.', 'tetris'),
            'content' => '<!-- wp:columns {"verticalAlignment":"center","isStackedOnMobile":false,"align":"full"} -->
                <div class="wp-block-columns alignfull are-vertically-aligned-center is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"center","width":"100%"} -->
                <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:100%"><!-- wp:shortcode -->
                [simple_contact_form]
                <!-- /wp:shortcode --></div>
                <!-- /wp:column --></div>
                <!-- /wp:columns -->',
            'categories'  => array('contact'),
        )
    );

    // Add image size
    add_image_size( 'wpex-entry', '370', '9999', false );
    add_image_size( 'wpex-post', '960', '9999', false );

    // Set the default post thumbnail size to match wpex-entry
    set_post_thumbnail_size(370, 9999, false);

    // Menu
    register_nav_menus ( array(
        'main_menu'    => __( 'Main', 'tetris' ),
    ) );

    // Add Post Formats Support
    add_theme_support( 'post-formats', array( 'video', 'audio', 'image', 'gallery' ) );

    //Localization support
    load_theme_textdomain( 'tetris', get_template_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'wpex_setup' );

/**
 * Returns post placeholder title
 *
 * @since 8.6.0
 */

function wpex_get_placeholder_title($post_ID) {
    return sprintf(__('Untitled Post %d', 'tetris'), $post_ID);
}

/**
 * Returns post title with placeholder if title is missing
 *
 * @since 8.6.0
 */

function wpex_get_title() {
    $post_title = get_the_title();
    return esc_html(!empty($post_title) ? $post_title : wpex_get_placeholder_title(get_the_ID()));
}

/**
 * Returns escaped post title with placeholder if title is missing
 *
 * @since 1.2.0
 */
function wpex_get_esc_title() {
    return esc_attr(!empty(get_the_title()) ? the_title_attribute('echo=0') : wpex_get_placeholder_title(get_the_ID()));
}

/**
 * Outputs escaped post title
 *
 * @since 1.2.0
 */
function wpex_esc_title() {
    echo wpex_get_esc_title();
}

/**
 * Kill dafault read more link
 *
 * @since 7.1.0
 */

add_filter('excerpt_more','__return_false', PHP_INT_MAX);
add_filter('the_content_more_link','__return_false', PHP_INT_MAX);

/**
 * Creates custom excerpts
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_excerpt' ) ) {
    function wpex_excerpt( $length = 20, $readmore = false ) {
        global $post;
        // Get excerpt or content
        $text = has_excerpt($post->ID) ? $post->post_excerpt : $post->post_content;
        $trimmed_text = trim(str_replace('&nbsp;', '', strip_tags(strip_shortcodes($text))));
        $spacer = wpx_spacer('#eee');

        $output = '<div class="u-wrap-text u-trim" style="--u-line-clamp: ' . intval($length) . '">';
        if ( ! post_password_required() && !empty( $trimmed_text ) ) {
            $output .= $spacer;
            $length = apply_filters('wpex_excerpt_length', intval($length * 10));
            $output .= wp_trim_words($trimmed_text, $length);
        } else {
            $output .= post_password_required() ?? $spacer;
            $output .= post_password_required() ? __( 'This content is protected. Log in or enter the password to view the full content.', 'tetris' ) : '';
        }
        $output .= '</div>';

        if ( ! post_password_required() && $trimmed_text !== '' && $readmore ) {
            $jump_point = strpos($post->post_content, '<!--more-->') !== false ? '#more-' . $post->ID : '#post-entry';
            $readmore_link = '<span class="wpex-readmore"><a href="' . get_permalink($post->ID) . $jump_point . '" title="'. __( 'Continue reading', 'tetris' ) .'" rel="bookmark" class="u-block u-block-100 u-ta-c u-link-button u-tt-all-caps u-fs-16">'. __( 'Read more', 'tetris' ) .'</a></span>';
            $output .= $readmore_link;
        }
        return $output;
    }
}

if ( ! function_exists( 'wpex_excerpt' ) ) {
    function wpex_excerpt_length( $length ) {
        return (get_theme_mod( 'universal_excerpt_length', 20 ) * 10);
    }
    add_filter( 'excerpt_length', 'wpex_excerpt_length', 10 );
}

/**
 * Default pagination
 *
 * @since 1.0.0
 */
function wpex_pagination() {
    global $paged, $wp_query;

    // Get current page if not set
    $current_page = empty($paged) ? 1 : $paged;

    // Get total pages
    $total_pages = $wp_query->max_num_pages ? $wp_query->max_num_pages : 1;

    if ($total_pages > 1) {
        // Initialize pagination HTML structure
        $pagination_html = '<div class="page-pagination">';
        $pagination_html .= '<div class="page-pagination-inner clearfix">';

        // Page indicator
        $pagination_html .= wpx_page_indicator($current_page, $total_pages);

        // Pagination links
        $pagination_html .= '<div class="pagination-links">';

        // Custom pagination links using get_the_posts_navigation
        $pagination_args = array(
            'prev_text' => '<span class="page-button inner dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text">' . esc_html__('Previous Page', 'tetris') . '</span>',
            'next_text' => '<span class="page-button inner dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text">' . esc_html__('Next Page', 'tetris') . '</span>',
        );

        // Append the navigation HTML to pagination_html
        $pagination_html .= paginate_links($pagination_args);

        // Close pagination-links div
        $pagination_html .= '</div>';
        
        // Close page-pagination-inner div
        $pagination_html .= '</div>';
        
        // Close page-pagination div
        $pagination_html .= '</div>';

        return $pagination_html;
    }
}

function ps_remove_avatar_srcset( $avatar, $id_or_email, $size, $default, $alt ) {
    return preg_replace('/(\ssrcset=)/', 'src=', $avatar);
}
add_filter('get_avatar', 'ps_remove_avatar_srcset', 10, 999999);

