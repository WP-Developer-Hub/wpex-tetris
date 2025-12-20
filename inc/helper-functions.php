<?php
/**
 * Helper Functions
 * Contains reusable helper functions for the theme.
 *
 * @link https://developer.wordpress.org/themes/theme-basics/theme-functions/
 *
 * @package Tetris WordPress Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
   return;
}

/**
 * Display attached media for the given post based on post format (audio, video, images/gallery).
 *
 * @param int $post_id The ID of the post.
 * @return string The HTML container for the media.
 */
if ( ! function_exists( 'universal_display_media' ) ) {
    function universal_display_media($post_id) {
        // Get post format (if supported)
        $post_format = get_post_format($post_id);

        // Determine the meta key part
        $meta_key_part = (($post_format === 'gallery') ? 'image' : $post_format);

        // Build the full meta key
        $meta_key = ('universal_local_' . $meta_key_part . '_attachment_ids');

        // Use a one-liner for the assignment
        $attachment_ids = (!empty($post_format) ? get_post_meta($post_id, $meta_key, true) : '');

        $container = '';
        if ( !post_password_required($post_id) ) {
            if (!empty($attachment_ids)) {
                $item_count = count(explode(',', $attachment_ids));

                if ($post_format === 'gallery' || $post_format === 'image') {
                    $container .= '<div id="post-gallery" class="u-media-16-9">';
                    $column_count = $post_format === 'image' ? 1 : (($item_count > 4) ? 4 : $item_count / 1.5);
                    $image_ids = $post_format === 'image' ? explode(',', $attachment_ids)[0] : $attachment_ids;

                    // Display a gallery of images no mater the count
                    $gallery_attr = array(
                        'order' => 'ASC',
                        'orderby' => 'post__in',
                        'size' => 'wpex-post',
                        'columns' => $column_count,
                        'ids' => $image_ids,
                        'link' => get_theme_mod('universal_gallery_link_type', 'attchments'),
                        'type' => 'slideshow',
                    );
        
                    $container .= gallery_shortcode($gallery_attr);
                } else {
                    $is_audio = ($post_format === 'audio');
                    $id = ($is_audio ? 'post-audio' : 'post-media');

                    $class_attr = ((!$is_audio && $item_count > 1) ? ' class="u-media-16-9"' : '');
                    $container .= ('<div id="' . $id . '"' . $class_attr . '>');

                    // Determine if tracklist should be displayed based on the count of attachment IDs
                    $display_tracklist = ($item_count > 1);

                    // Display playlist for audio or video post formats
                    $playlist_attr = array(
                        'type' => ($post_format === 'audio') ? 'audio' : 'video',
                        'order' => 'ASC',
                        'orderby' => 'post__in',
                        'ids' => $attachment_ids,
                        'style' => 'dark',
                        'tracklist' => $display_tracklist,
                        'tracknumbers' => true,
                        'images' => true,
                        'artists' => true,
                    );
        
                    $container .= wp_playlist_shortcode($playlist_attr);
                }
                $container .= '</div>';
                $container .= wpx_spacer('', '30');
            }
        } else {
            $container .= wpex_get_post_media_placeholder();
        }
        return $container;
    }
}

/**
 * Get the copyright information.
 *
 * @return string The copyright information.
 */
if ( ! function_exists( 'universal_get_copyright_info' ) ) {
    function universal_get_copyright_info() {
        // Get copyright layout
        $message = get_theme_mod('universal_copyright_layout', '[copyright_symbol] [site_name], [started_date][dash][current_date].');
    
        // Get the current date in the format YYYY
        $current_year = date('Y');
    
        // Get the started date if available
        $started_date = date('Y', strtotime(get_theme_mod('universal_footer_start_date', $current_year)));
    
        // Construct site name HTML
        $blog_url = home_url(); // Get the homepage URL
        $site_name = is_multisite()
            ? get_blog_details(get_current_blog_id())->blogname
            : get_bloginfo('name');

        // Make $site_name a link
        $site_name = '<a class="u-tt-all-caps" href="' . esc_url($blog_url) . '">' . esc_html($site_name) . '</a>';
    
        // Replace placeholders with dynamic content
        $message = str_replace('[copyright_symbol]', '&copy;', $message);
        $message = str_replace('[registered_symbol]', '&reg;', $message);
        $message = str_replace('[trademark_symbol]', '&trade;', $message);
        $message = str_replace('[site_name]', $site_name, $message);
        $message = str_replace('[started_date]', $started_date, $message);
    
        // Check if started date is not the same as current year and replace placeholders accordingly
        if ($started_date == $current_year) {
            $message = str_replace(['[dash]', '[current_date]'], ['', ''], $message);
        } else {
            $message = str_replace(['[dash]', '[current_date]'], ['-', $current_year], $message);
        }
      return rtrim($message);
    }
}

/**
 * Outputs a page indicator.
 *
 * @param int $paged Current page number.
 * @param int $pages Total number of pages.
 * @return string HTML output of the page indicator.
 */
if ( ! function_exists( 'wpx_page_indicator' ) ) {
    function wpx_page_indicator($paged, $pages) {
        return'<div class="page-of-page"> <span class="inner">' . esc_html($paged) . ' ' . esc_html__('of', 'tetris') . ' ' . esc_html($pages) . '</span> </div>';
    }
}

/**
 * Custom pagination for comments.
 *
 * Outputs a custom pagination structure for navigating through comments.
 *
 * @param int $range The number of pages before and after the current page to show.
 * Default is 4.
 * @return void
 */
if ( ! function_exists( 'universal_custom_paginate_comments_links' ) ) {
    function universal_custom_paginate_comments_links($id = 'default') {
        // Get comment count
        $total_pages = get_comment_pages_count();

        // Get total pages
        $current_page = max(1, get_query_var('cpage'));

        // Check if there are more than one page of comments
        if ( $total_pages > 1 && get_option( 'page_comments' ) ) {
            // Initialize pagination HTML structure
            $pagination_html = '<div id="comment-nav-' . esc_attr($id) . '" class="page-pagination site-navigation comment-navigation">';
            $pagination_html .= '<h4 class="screen-reader-text">' . __('Comment Navigation','tetris') . '</h4>';
            $pagination_html .= '<div class="page-pagination-inner clearfix">';

            // page indicator
            $pagination_html .= wpx_page_indicator($current_page, $total_pages);

            // Pagination links
            $pagination_html .= '<div class="pagination-links">';

            // Custom pagination links using paginate_comments_links
            $pagination_args = array(
                'echo' => false,
                'total' => $total_pages,
                'current' => $current_page,
                'prev_text' => '<span class="page-button inner dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text">' . esc_html__('Previous Page', 'tetris') . '</span>',
                'next_text' => '<span class="page-button inner dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text">' . esc_html__('Next Page', 'tetris') . '</span>',
            );

            // Get the pagination links
            $pagination_html .= paginate_comments_links($pagination_args);

            // Close pagination-links div
            $pagination_html .= '</div>';
            
            // Close page-pagination-inner div
            $pagination_html .= '</div>';
            
            // Close page-pagination div
            $pagination_html .= '</div>';
            
            return $pagination_html;
        }
    }
}

/**
 * Custom pagination for multi-page posts.
 *
 * Outputs a custom pagination structure for navigating through multi-page posts.
 *
 * @param array $args Optional. Arguments to customize the pagination output.
 * @return void
 */
if ( ! function_exists( 'wpx_custom_link_pages' ) ) {
    function wpx_custom_link_pages() {
        global $page, $numpages;

        // Get total pages
        $total_pages = $numpages ?: 1;

        // Get current page
        $current_page = max(1, get_query_var('page') ? get_query_var('page') : 1);

        // Set up args for wp_link_pages
        $args = array(
            'echo' => 0,
            'after' => '',
            'before' => '',
            'next_or_number' => 'next',
            'nextpagelink' => '<span class="page-button inner dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text">' . esc_html__('Next Page', 'tetris') . '</span>',
            'previouspagelink' => '<span class="page-button inner dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text">' . esc_html__('Previous Page', 'tetris') . '</span>',
        );

        // Initialize pagination HTML structure
        $pagination_html = '<div class="page-pagination">';
        $pagination_html .= '<div class="page-pagination-inner clearfix">';

        // Generate page indicator
        $pagination_html .= wpx_page_indicator($current_page, $total_pages);

        // Pagination links container
        $pagination_html .= '<div class="pagination-links ufc_dark u-grid">';

        // Generate pagination links
        $pagination_html .= wp_link_pages($args);

        // Page Select Box
        $pagination_html .= '<select onchange="location = this.value;">';
        for ( $i = 1; $i <= $total_pages; $i++ ) {
            $page_url = esc_url( get_permalink() . sprintf('/%d/', $i) );
            $selected = ($i === $current_page) ? ' selected="selected"' : '';
            $pagination_html .= '<option value="' . $page_url . '"' . $selected . '> Page ' . esc_html($i) . '</option>';
        }
        $pagination_html .= '</select>';

        // Close pagination-links div
        $pagination_html .= '</div>';
        
        // Close page-pagination-inner div
        $pagination_html .= '</div>';
        
        // Close page-pagination div
        $pagination_html .= '</div>';

        return $pagination_html; // Return the generated HTML
    }
}

/**
 * Generate dynamic CSS variables based on theme customizer settings.
 *
 * @return string The generated CSS string.
 */
if ( ! function_exists( 'universal_dynamic_css' ) ) {
    function universal_dynamic_css() {
        // Get accent color from theme customizer (default value if not set)
        $universal_accent_color = explode(',', get_theme_mod('universal_accent_color', '#0073e6, #fff, #0073e7, #fff, #0073e8, #fff'));
        $toggle_fixed_max_width = explode(',', get_theme_mod('universal_toggle_fixed_max_width', '960, 0'));

        // Check if the array has the expected number of elements
        if ( count($universal_accent_color) < 6 ) {
            // Ensure there are enough colors, filling with defaults if necessary
            $universal_accent_color = array_pad($universal_accent_color, 6, '#fff');
        }

        // Check if the array has the expected number of elements and pad if not
        if ( count($toggle_fixed_max_width) < 2 ) {
            $toggle_fixed_max_width = array_pad($toggle_fixed_max_width, 2, '960');
        }

        // Initialize the variables with fallbacks if empty
        $accent_color = !empty($universal_accent_color[0]) ? $universal_accent_color[0] : '#0073e6';
        $accent_color_text = !empty($universal_accent_color[1]) ? $universal_accent_color[1] : '#fff';

        $accent_color_light = !empty($universal_accent_color[4]) ? $universal_accent_color[4] : $accent_color;
        $accent_color_text_light = !empty($universal_accent_color[5]) ? $universal_accent_color[5] : $accent_color_text;

        $accent_color_dark = !empty($universal_accent_color[2]) ? $universal_accent_color[2] : $accent_color;
        $accent_color_text_dark = !empty($universal_accent_color[3]) ? $universal_accent_color[3] : $accent_color_text;

        $theme_width = ($toggle_fixed_max_width[1] ? $toggle_fixed_max_width[0] . 'px' : 'calc(100% - 200px)');

        // Generate dynamic CSS with root variables
        $css = ":root {
            caret-color: {$accent_color};
            --universal-accent-color: {$accent_color};
            --universal-accent-color-dark: {$accent_color_dark};
            --universal-accent-color-light: {$accent_color_light};
            --universal-accent-color-text: {$accent_color_text};
            --universal-accent-color-text-dark: {$accent_color_text_dark};
            --universal-accent-color-text-light: {$accent_color_text_light};
            --universal-theme-width: {$theme_width};
        }";

        // Return the generated CSS string
        return $css;
    }
}

/**
 * Get the title or tagline based on theme customizer settings.
 *
 * @return string The HTML for title or tagline.
 */
if ( ! function_exists( 'universal_get_title_tagline' ) ) {
    function universal_get_title_tagline() {
        // Get the theme modification for title and tagline visibility
        $visibility = get_theme_mod('universal_title_tagline_visibility', 'title_only');

        // Define default output for title and tagline
        $title = get_bloginfo('name');
        $tagline = get_bloginfo('description');

        // Define HTML start and end tags for the title and tagline
        $title_start_tag = '<h1 class="u-fs-50">';
        $tagline_start_tag = '<h1 class="u-fs-40">';
        $end_tag = '</h1>';

        // Initialize title and tagline output variables
        $tt_output = '';

        // Use a switch statement to adjust output based on visibility setting
        switch ($visibility) {
            case 'none':
                return '';
                break;
            case 'tagline_only':
                // Display tagline only
                return $tagline_start_tag . $tagline . $end_tag;
                break;
            default:
                // Display title only (default behavior)
                return $title_start_tag . $title . $end_tag;
                break;
        }

        // Return the combined HTML output
        return $tt_output;
    }
}

/**
 * Display the custom logo of the theme.
 */
if ( ! function_exists( 'universal_theme_custom_logo' ) ) {
    function universal_theme_custom_logo() {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

        if (has_custom_logo()) {
            echo '<a href="' . esc_url(home_url('/')) . '" rel="home" class="u-flex u-flex-row u-ai-c"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" title="' . get_bloginfo('name') . '" loading="lazy">';
            echo universal_get_title_tagline() . '</a>';
        } else {
            echo '<a href="' . esc_url(home_url('/')) . '">' . universal_get_title_tagline() . '</a>';
        }
    }
}

/**
 * Generate a CSS class string to indicate selection based on a passed string and the 'post_format' parameter.
 *
 * @param string|bool $passed_string The string to compare with the 'post_format' parameter. Defaults to false.
 */
if ( ! function_exists( 'universal_search_filter_item_class' ) ) {
    function universal_search_filter_item_class($passed_string = false) {
        $post_format = (isset($_GET['post_format']) ? $_GET['post_format'] : 'all');
        return (($passed_string == $post_format) ? ' u-link-button-selected' : '');
    }
}

/**
 * Retrieves the total count of published posts based on the current search query.
 *
 * This function performs a WP_Query to count the number of posts that are
 * published and match the current search query (if any). It returns the
 * total number of matching posts found.
 *
 * @return int The total number of published posts found for the current search query.
 */
if ( ! function_exists( 'wpx_get_post_count' ) ) {
    function wpx_get_post_count(){
        $total_post_count = new WP_Query("s=$s&posts_per_page=-1&post_status=publish");
        return $total_post_count->found_posts;
    }
}

/**
 * Customize the comment form fields.
 *
 * @param array $fields The default comment form fields.
 * @return array        The modified comment form fields.
 */
if ( ! function_exists( 'body_class_slugs' ) ) {
    function body_class_slugs($classes) {
        global $post;

        // Check if we are on a singular post or page
        if (is_singular()) {
            // Get the post or page ID
            $post_id = $post->ID;

            // Get the post or page name
            $post_name = $post->post_name;

            // Add post or page name as a class
            $classes[] = 'post-name-' . $post_name;

            // Check if the singular content is a page
            if (is_page()) {
                // Get the page title and sanitize it for use as a class
                $page_title = sanitize_title_with_dashes(get_the_title());

                // Add page title as a class
                $classes[] = 'page-name-' . $page_title;
            }
        }

        // Return the modified classes
        return $classes;
    }
    add_filter('body_class', 'body_class_slugs');
}

/**
 * Customize default settings for WordPress galleries.
 *
 * @param array $settings The default gallery settings.
 * @return array          The modified gallery settings.
 */
if ( ! function_exists( 'universal_gallery_defaults' ) ) {
    function universal_gallery_defaults( $settings ) {
        // Set default link type to 'file'
        $settings['galleryDefaults']['link'] = 'file';

        // Force the gallery type to be 'slideshow'
        $settings['galleryDefaults']['type'] = 'slideshow';

        return $settings;
    }
    add_filter( 'media_view_settings', 'universal_gallery_defaults' );
}

/**
 * Customize the display of comment links based on comment status and whether comments are open.
 *
 * @return void
 */
if ( !function_exists('wpx_comments_popup_link') ) {
    function wpx_comments_popup_link() {
        $no_comments_text = '';
        $one_comment_text = '';
        $multiple_comments_text = '';

        // Check if comments are closed and the post type supports comments
        if (post_type_supports(get_post_type(), 'comments')) {
            if (comments_open()) {
                // Comments are open
                $no_comments_text = __('0 Comments', 'tetris');
                $one_comment_text = __('1 Comment', 'tetris');
                $multiple_comments_text = __('% Comments', 'tetris');
            } else {
                if ('0' != get_comments_number()) {
                    // Comments are closed
                    $no_comments_text = __('Comments closed', 'tetris');
                    $one_comment_text = __('Comments closed', 'tetris');
                    $multiple_comments_text = __('Comments closed', 'tetris');
                }
            }

            if (comments_open() || (!comments_open() && '0' != get_comments_number())) {
                $class = is_single() ? 'single-post-meta-divider' : '';
                echo '<li' . ($class ? ' class="' . esc_attr($class) . '"' : '') . '>';
                echo '<strong>' . __('With', 'tetris') . ': </strong>';
                if ( post_password_required() ) {
                    echo comments_number($no_comments_text, $one_comment_text, $multiple_comments_text, 'comments-link', '');;
                } else {
                    echo comments_popup_link($no_comments_text, $one_comment_text, $multiple_comments_text, 'comments-link', '');
                }
                echo '</li>';
            }
        } else {
            echo '';
        }
    }
}

/**
 * Modify the CSS class of the edit comment link.
 *
 * @param string $output The original edit comment link HTML output.
 * @return string The modified edit comment link HTML output with the class changed.
 */
if ( ! function_exists('wpx_change_edit_comment_link_class') ) {
    function wpx_change_edit_comment_link_class($output) {
        return str_replace( 'comment-edit-link', 'comment-reply-link', $output );
    }
    add_filter( 'edit_comment_link', 'wpx_change_edit_comment_link_class' );
}

/**
 * Get the icon classes corresponding to the post format.
 *
 * @param string $post_format The post format.
 * @return string The icon classes.
 */
if ( ! function_exists('universal_get_post_format_icon_classes') ) {
    function universal_get_post_format_icon_classes($post_format) {
        switch ($post_format) {
            case 'aside':
                return 'posticons dashicons dashicons-format-aside';
            case 'gallery':
                return 'posticons dashicons dashicons-format-gallery';
            case 'link':
                return 'posticons dashicons dashicons-format-links';
            case 'image':
                return 'posticons dashicons dashicons-format-image';
            case 'quote':
                return 'posticons dashicons dashicons-format-quote';
            case 'status':
                return 'posticons dashicons dashicons-format-status';
            case 'video':
                return 'posticons dashicons dashicons-format-video';
            case 'audio':
                return 'posticons dashicons dashicons-format-audio';
            case 'chat':
                return 'posticons dashicons dashicons-format-chat';
            default:
                return 'posticons dashicons dashicons-format-standard';
        }
    }
}

/**
 * Display a "New" or "Sticky" badge for posts.
 *
 * This function checks if a post is considered "recent" (published within a configurable number of days, default 7).
 * If the post is recent, it displays a "New" badge. If not, but the post is sticky, it displays a "Sticky" badge.
 * If neither condition is met, no badge is shown.
 *
 * @param int    $id       The post ID to check.
 * @param string $pos      Badge position class suffix (default: "br").
 * @param bool   $is_wide  Whether to use the wide badge style.
 * @return string          The badge HTML if applicable, otherwise an empty string.
 */
if (!function_exists('wpx_post_badge')) {
    function wpx_post_badge($id, $pos = "br", $is_wide = false) {
        $post_date = get_the_date('U', $id);
        $current_date = current_time('timestamp');
        $number_of_days = get_theme_mod('universal_recent_post_keep_badge_for', 7);
        $classes = $is_wide ? 'u-block u-block-100 u-margin-0' : 'u-badge-' . $pos . ' u-pos-abs';

        $is_sticky = is_sticky($id);
        $is_recent = ($current_date - $post_date) < ($number_of_days * DAY_IN_SECONDS);

        if ($is_recent && $is_sticky) {
            $label = __('New & Featured', 'tetris');
        } elseif ($is_recent) {
            $label = __('New', 'tetris');
        } elseif ($is_sticky) {
            $label = __('Featured', 'tetris');
        } else {
            $label = '';
        }
        return !empty($label) ? ' <span class="u-badge ' . $classes . ' u-fs-14 u-ta-c">' . $label . '</span>' : '';
    }
}

/**
 * Generates a spacer element with customizable background and top margin.
 *
 * @param string $background Background color for the spacer.
 * @param string|int $margin_top Margin-top in pixels.
 * @return string HTML for the spacer element, or an empty string if not a single post.
 */
if ( ! function_exists( 'wpx_spacer' ) ) {
    function wpx_spacer($background = '#ddd', $margin_top = '10') {
        $margin_top = empty($margin_top) ? '10' : $margin_top;
        $background = empty($background) ? '#ddd' : $background;
        return '<span class="u-block u-spacer-h u-spacer-light" style="background: ' . esc_attr($background) . '; margin-top: ' . esc_attr($margin_top) . 'px;"></span>';
    }
}

/**
 * Removes or edits the 'Protected:' part from post titles
 */
if ( ! function_exists( 'wpex_remove_protected_text' ) ) {
    function wpex_remove_protected_text() {
        return '%s'; // No need for translation
    }
    add_filter( 'protected_title_format', 'wpex_remove_protected_text', PHP_INT_MAX);
}

/**
* Generates a placeholder for post media with dynamic styling and icons.
*
* This function outputs a `<div>` element styled as a media container.
* The container's aspect ratio is determined by the context (single post or not).
* Inside the container:
* - A lock icon is displayed for password-protected posts.
* - A format-specific icon is displayed for other posts.
*
* @return string The generated HTML for the media placeholder.
*/
if ( ! function_exists( 'wpex_get_post_media_placeholder' ) ) {
    function wpex_get_post_media_placeholder() {
        // Start the HTML output
        $output = '<div class="u-media-'. esc_attr(is_single() ? '16-9' : '1-1') .' u-media-missing-img u-flex u-ai-c u-jc-c" title="' . esc_attr(get_the_title()) . '">';

        if ( post_password_required() ) {
            $output .= '<span class="dashicons dashicons-lock"></span>';
            $output .= '<span class="screen-reader-text" aria-hidden="true">' . __( 'Password Protected', 'tetris' ) . '</span>';
        } else {
            $output .= '<span class="' . universal_get_post_format_icon_classes( get_post_format() ) . '"></span>';
        }

        // Close the div
        $output .= '</div>';

        // Return the generated HTML
        return $output;
    }
}

/**
 * Outputs the post date in a formatted HTML string.
 *
 * The function returns a strong tag with the text "Posted on:"
 * followed by a time tag containing the post date.
 * The time tag includes a datetime attribute for accessibility and SEO.
 *
 * @return string The generated HTML for the post date.
 */
if ( !function_exists('wpex_get_post_date') ) {
    function wpex_get_post_date() {
        $date_style = get_theme_mod('universal_date_display_option', 'date');
        $auto_ago_delay = get_theme_mod('universal_toggle_auto_ago_format_delay', 7);
        $auto_ago_format = get_theme_mod('universal_toggle_auto_ago_format', 'true');

        $post_date_label = __('Posted on', 'tetris');
        $post_modified_date_label = __('Edited on', 'tetris');
        $link_aria_prefix = __('View All Posts Made on', 'tetris'). ' ';

        $date_c = '';
        $post_time = '';
        $post_date = '';
        $show_modified_date = false;
        $is_edited = (get_the_date('Y-m-d') !== get_the_modified_date('Y-m-d'));

        $post_date_link = get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'));

        switch ($date_style) {
            case 'modified_date':
                $show_modified_date = true;
                $date_c = get_the_modified_date('c');
                $post_date = get_the_modified_date('');
                $post_timestamp = get_the_modified_date('U');
                break;
            case 'date':
            default:
                $date_c = get_the_date('c');
                $post_date = get_the_date('');
                $post_timestamp = get_the_date('U');
                break;
        }
        if ($auto_ago_format && ((current_time('timestamp') - $post_timestamp) > ($auto_ago_delay * DAY_IN_SECONDS))) {
            $post_date_label = __('Posted', 'tetris');
            $post_modified_date_label = __('Edited', 'tetris');
            $post_date = human_time_diff($post_timestamp, $now) . ' ' . __('ago', 'tetris');
        }

        $post_date_label = ($show_modified_date && $is_edited ? $post_modified_date_label : $post_date_label);

        $output = '<strong>' . esc_html($post_date_label) . ':</strong> ';
        $output .= '<a class="post-date-link u-text-medium" href="' . $post_date_link . '" rel="bookmark"';

        if ( is_single() ) {
            $output .= ' aria-label="' . esc_attr($link_aria_prefix . get_the_date('')) . '"';
        }

        $output .= '>';
        $output .= '<time datetime="' . esc_attr($date_c) . '">' . esc_html($post_date) . '</time>';
        $output .= '</a>';

        return $output;
    }
}

/**
 * Outputs the post author link in a formatted HTML string.
 *
 * The function returns a strong tag with the text "By:"
 * followed by the author's posts link.
 * Allows for easy translation and filter customization.
 *
 * @return string The generated HTML for the post author link.
 */
if ( !function_exists('wpex_get_post_author') ) {
    function wpex_get_post_author() {
        $html  = '<strong>' . esc_html__( 'By', 'tetris' ) . ':</strong> ';
        $html .= get_the_author_posts_link();
        return $html;
    }
}
