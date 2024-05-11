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
require_once $dir .'/inc/universal-meta-box.php' ;
require_once $dir .'/inc/scripts.php' ;
require_once $dir .'/inc/widget-areas.php' ;
require_once $dir .'/inc/helper-functions.php' ;
if ( !is_admin() ) {
    require_once $dir .'/inc/comments.php' ;
    require_once $dir .'/inc/universal-menu-walker-2-0.php' ;
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
            'color' => get_theme_mod('universal_accent_color', '#0073e6'), // Use theme mod or default color
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
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));

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
    add_theme_support('link-color', array(
        'color' => get_theme_mod('universal_accent_color', '#0073e6'),
        'hover_color' => get_theme_mod('universal_accent_color', '#0073e6'),
    ));

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
    add_editor_style('css/ufg.css');
    add_editor_style('css/ufc.css');
    add_editor_style('css/plugin.css');
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
    
    // Menu
    register_nav_menus ( array(
        'main_menu'    => __( 'Main', 'tetris' ),
    ) );

    // Add Post Formats Support
    add_theme_support( 'post-formats', array( 'video', 'link', 'audio', 'image', 'gallery' ) );

    //Localization support
    load_theme_textdomain( 'tetris', get_template_directory() .'/languages' );

}
add_action( 'after_setup_theme', 'wpex_setup' );

/**
 * Returns escaped post title
 *
 * @since 1.2.0
 */
function wpex_get_esc_title() {
    return esc_attr( the_title_attribute( 'echo=0' ) );
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
 * Move comment form fields
 *
 * @since 1.2.0
 */
function wpex_move_comment_form_fields( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
add_filter( 'comment_form_fields', 'wpex_move_comment_form_fields' );

/**
 * Replace Soliloquy affiliate
 *
 * @since 1.0.0
 */
function wpex_affiliate_url() {
    return 'http://www.wpexplorer.com/soliloquy-wordpress-plugin';
}
add_filter( 'tgmsp_affiliate_url', 'wpex_affiliate_url' );

/**
 * Change default read more
 *
 * @since 1.0.0
 */
function wpex_new_excerpt_more($more) {
    global $post;
    return '...';
}
add_filter( 'excerpt_more', 'wpex_new_excerpt_more' );

/**
 * Creates custom excerpts
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_excerpt' ) ) {
    function wpex_excerpt( $length = '20', $readmore = false ) {
        global $post;
        $id = $post->ID;
        $length = apply_filters( 'wpex_excerpt_length', $length );
        if ( has_excerpt( $id ) ) {
            $output = $post->post_excerpt;
        } else {
            $output = wp_trim_words( strip_shortcodes( get_the_content( $id ) ), $length);
            if ( $readmore == true ) {
                $readmore_link = '<span class="wpex-readmore"><a href="'. get_permalink( $id ) .'" title="'. __( 'continue reading', 'tetris' ) .'" rel="bookmark">'. __( 'Read more', 'tetris' ) .' &rarr;</a></span>';
                $output .= apply_filters( 'wpex_readmore_link', $readmore_link );
            }
        }
        echo $output;
    }
}

/**
 * Default pagination
 *
 * @since 1.0.0
 */
function wpex_pagination( $pages = '', $range = 4 ) {
     $showitems = ($range * 2)+1;
     global $paged;
     if ( empty( $paged ) ) $paged = 1;
     if ( $pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if ( !$pages ) {
             $pages = 1;
         }
     }
    echo "<div class=\"page-pagination\"><div class=\"page-pagination-inner clearfix\">";
     if ( 1 != $pages) {
         echo "<div class=\"page-of-page\"><span class=\"inner\">".$paged." of ".$pages."</span></div>";
         echo previous_posts_link('<span class="page-button inner dashicons dashicons-arrow-left-alt2"></span>');
         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current outer\"><span class=\"inner\">".$i."</span></span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\"><span class=\"inner\">".$i."</span></a>";
             }
         }
         echo next_posts_link('<span class="page-button inner dashicons dashicons-arrow-right-alt2"></span>');
         echo "</div>";
     }
    echo "</div>\n";
}

function ps_remove_avatar_srcset( $avatar, $id_or_email, $size, $default, $alt ) {
    return preg_replace('/(\ssrcset=)/', 'src=', $avatar);
}
add_filter('get_avatar', 'ps_remove_avatar_srcset', 10, 999999);

function ps_limit_comment_length($comment) {
    $max_length = 280;

    if (strlen($comment['comment_content']) > $max_length) {
        wp_die('<strong>Warning:</strong> Please keep your comment under ' . $max_length . ' characters.', 'Comment Length Warning', array('response' => 500, 'back_link' => true));
    }
    return $comment;
}
add_filter('preprocess_comment', 'ps_limit_comment_length');

function tu_filter_comment_fields( $fields ) {
    $commenter = wp_get_current_commenter();

    $consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

    $fields['cookies'] = '<p class="comment-form-cookies-consent"><label for="wp-comment-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' . 'Save my name, email in this browser for the next time I comment.</label></p>';

    return $fields;
}
add_filter( 'comment_form_default_fields', 'tu_filter_comment_fields', 20 );

remove_filter('comment_text', 'make_clickable', 9);

/**
 * Remove the 'type="text/css"' attribute from stylesheet link tags.
 *
 * @param string $tag The complete HTML tag for the stylesheet.
 * @param string $handle The name of the stylesheet.
 * @param string $src The URL of the stylesheet file.
 * @return string The modified HTML tag for the stylesheet.
 */
function preload_css($tag, $handle, $src){
    return str_replace('type="text/css"', "", $tag);
}
add_filter('style_loader_tag', 'preload_css', 10, 3);

/**
 * Remove the 'type="text/javascript"' attribute from script link tags.
 *
 * @param string $tag The complete HTML tag for the script.
 * @param string $handle The name of the script.
 * @param string $src The URL of the script file.
 * @return string The modified HTML tag for the script.
 */
function preload_script($tag, $handle, $src){
    return str_replace('type="text/javascript"', "", $tag);
}
add_filter('script_loader_tag', 'preload_script', 10, 3);

/**
 * Remove query strings from script and style URLs.
 *
 * @param string $src The URL of the script or style.
 * @return string The URL without query strings.
 */
function wpcode_snippet_remove_query_strings_split($src) {
    $output = preg_split( "/(&ver|\\?ver)/", $src ); // Split the URL by '&ver' or '?ver'

    return $output ? $output[0] : ''; // Return the URL without query strings
}
add_filter('script_loader_src', 'wpcode_snippet_remove_query_strings_split', 15);
add_filter('style_loader_src', 'wpcode_snippet_remove_query_strings_split', 15);

/**
 * Modify term name to title case (capitalize each word)
 *
 * @param WP_Term $term    The term object being retrieved.
 * @param string  $taxonomy The taxonomy associated with the term.
 * @return WP_Term         The modified term object.
 */
function ucfletter_tags($term, $taxonomy) {
    // Check if term object and name are valid
    if (isset($term->name) && is_string($term->name)) {
        // Transform term name to title case
        $term->name = ucfirst($term->name);
    }
    return $term;
}
add_filter('get_term', 'ucfletter_tags', 10, 2);
