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

        // $attachment_ids now contains the IDs based on the post format or condition
        $attachment_ids = '';

        // Check if $post_format is not empty
        if (!empty($post_format)) {
            // Get the attachment IDs from post meta
            $attachment_ids = get_post_meta($post_id, ('universal_local_' . ($post_format == "gallery" ? 'image' : $post_format) . '_attachment_ids'), true);
        }

        $container = '';

        if (!empty($attachment_ids)) {
            if ($post_format === 'gallery' || $post_format === 'image') {
                // Display a gallery of images
                $gallery_attr = array(
                    'order' => 'ASC',
                    'orderby' => 'post__in',
                    'size' => 'wpex-post',
                    'columns' => '3' ,
                    'ids' => $attachment_ids,
                    'link' => 'attachment',
                    'type' => 'slideshow',

                );
    
                $container .= gallery_shortcode($gallery_attr);
            } else {
                // Determine if tracklist should be displayed based on the count of attachment IDs
                $display_tracklist = (count(explode(',', $attachment_ids)) > 1);

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
    
            if (is_single()) {
                $container .= '<span class="u-block u-spacer-h u-spacer-light" style="background: #eee; margin-top: 30px;"></span>';
            }
    
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
        $started_date = date('Y', strtotime(get_theme_mod('universal_footer_started_date', $current_year)));
    
        // Construct site name HTML
        $site_name = '<span class="u-tt-all-uppercase">';
        $site_name .= is_multisite() ? get_blog_details(get_current_blog_id())->blogname : get_bloginfo('name');
        $site_name .= '</span>';
    
        // Replace placeholders with dynamic content
        $message = str_replace('[copyright_symbol]', '&copy;', $message);
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
 * Custom pagination for comments.
 *
 * Outputs a custom pagination structure for navigating through comments.
 *
 * @param int $range The number of pages before and after the current page to show.
 * Default is 4.
 * @return void
 */
if ( ! function_exists( 'universal_custom_paginate_comments_links' ) ) {
    function universal_custom_paginate_comments_links($range = 4) {
        $showitems = ($range * 2) + 1;
        $current_page = max(1, get_query_var('cpage'));

        if (get_comment_pages_count() > 1) {
            echo '<div class="page-pagination"><div class="page-pagination-inner clearfix">';
            echo '<div class="page-of-page"><span class="inner">' . $current_page . ' of ' . get_comment_pages_count() . '</span></div>';

            echo '<div class="pagination-links">';
            echo previous_comments_link('<span class="page-button inner dashicons dashicons-arrow-left-alt2"></span>');
            for ($i = 1; $i <= get_comment_pages_count(); $i++) {
                if (1 != get_comment_pages_count() && (
                    !($i >= $current_page + $range + 1 || $i <= $current_page - $range - 1) || get_comment_pages_count() <= $showitems
                )) {
                    $url = get_comments_pagenum_link($i);
                    echo ($current_page == $i) ? "<span class=\"current outer\"><span class=\"inner\">" . $i . "</span></span>" : "<a href='" . esc_url($url) . "' class=\"inactive\"><span class=\"inner\">" . $i . "</span></a>";
                }
            }
            echo next_comments_link('<span class="page-button inner dashicons dashicons-arrow-right-alt2"></span>');
            echo '</div>'; // .pagination-links

            echo "</div></div>\n";
        }
    }
}

/**
 * Convert hexadecimal color code to RGBA format.
 *
 * @param string $color The hexadecimal color code.
 * @param mixed $opacity Optional opacity value (default: false).
 * @return string The formatted RGBA color string.
 */
if ( ! function_exists( 'universal_hex2rgba' ) ) {
    function universal_hex2rgba($color, $opacity = false) {
        $default = 'rgb(0,0,0)'; // Default color if no color provided
    
        // Return default color if no color provided
        if(empty($color))
            return $default;
    
        // Sanitize $color by removing "#" if provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
    
        // Check if color has 6 or 3 characters and extract individual RGB values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }
    
        // Convert hexadecimal values to decimal
        $rgb =  array_map('hexdec', $hex);
    
        // Format color string based on opacity setting
        if($opacity){
            if($opacity== 1){
                $opacity = 1.0;
            }
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
    
        // Return formatted color string
        return $output;
    }
}

/**
 * Determine if a color is light or dark.
 *
 * @param string $color The color code.
 * @return string|false The color code for text color (black or white) or false if no color provided.
 */
if ( ! function_exists( 'universal_is_light_color' ) ) {
    function universal_is_light_color($color) {
        $default = 'rgb(0,0,0)'; // Default color if no color provided
    
        // Return false if no color provided
        if (empty($color))
            return false;
    
        // Sanitize $color by removing "#" if provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
    
        // Check if color has 6 or 3 characters and extract individual RGB values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return false;
        }
    
        // Convert hexadecimal values to decimal
        $rgb = array_map('hexdec', $hex);
    
        // Calculate perceived brightness
        $brightness = ($rgb[0] * 299 + $rgb[1] * 587 + $rgb[2] * 114) / 1000;
    
        // Determine text color based on brightness
        return $brightness > 128 ? "#000000" : "#FFFFFF";
    }
}

/**
 * Generate dynamic CSS variables based on theme customizer settings.
 *
 * @return string The generated CSS string.
 */
if ( ! function_exists( 'universal_dynamic_css' ) ) {
    function universal_dynamic_css() {
        // Get background color, accent color, accent color text color, and max width from theme customizer
        $universal_accent_color = get_theme_mod('universal_accent_color', '#0073e6');
        $universal_accent_color_alt = universal_hex2rgba($universal_accent_color, 0.75);
        $universal_accent_color_text_color = universal_is_light_color($universal_accent_color);

        // Generate dynamic CSS with root variables
        $css = ":root {
            --universal-accent-color: {$universal_accent_color};
            --universal-accent-color-alt: {$universal_accent_color_alt};
            --universal-accent-color-text-color: {$universal_accent_color_text_color};
        }";

        // Return generated CSS string
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
            echo '<a href="' . esc_url(home_url('/')) . '" rel="home" class="u-flex u-flex-row u-ai-c"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" title="' . get_bloginfo('name') . '">';
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

        if ($passed_string == $post_format) {
            echo ' u-link-button-selected';
        }
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
 * Customize the comment form fields.
 *
 * @param array $fields The default comment form fields.
 * @return array        The modified comment form fields.
 */
if ( ! function_exists( 'customize_comment_form' ) ) {
    function customize_comment_form($fields) {
        ob_start();
        wp_editor('', 'comment', array(
            'media_buttons' => false,
            'teeny' => true, // Enable teeny mode
            'textarea_rows' => 10,
            'quicktags' => true,
            'tinymce' => false,   // Enable TinyMCE
        ));
        $editor_contents = ob_get_clean();
        $fields['comment'] = $editor_contents;
        return $fields;
    }
    add_filter('comment_form_fields', 'customize_comment_form');
}

/**
 * Customize the quicktags settings for the comment editor.
 *
 * @param array $qtInit The default quicktags settings.
 * @return array        The modified quicktags settings.
 */
if ( ! function_exists( 'customize_comment_quicktags' ) ) {
    function customize_comment_quicktags($qtInit) {
        if(!is_admin()) {
            $qtInit['buttons'] = 'strong,em,spell,';
        }
        return $qtInit;
    }
    add_filter('quicktags_settings', 'customize_comment_quicktags');
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
                echo '<li class="comment-scroll single-post-meta-divider">';
                echo '<strong>' . __('With', 'tetris') . ': </strong>';
                echo comments_popup_link($no_comments_text, $one_comment_text, $multiple_comments_text, 'comments-link', '');
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
        // Replace 'comment-edit-link' with 'comment-reply-link bacause I'm to lazy to added to style.css'
        return str_replace( 'comment-edit-link', 'comment-reply-link', $output );
    }
    add_filter( 'edit_comment_link', 'wpx_change_edit_comment_link_class' );
}

/**
 * Customize the archive title based on the type of archive being viewed.
 *
 * This function modifies the archive title to include a static prefix "Posts Made"
 * and then adjusts the remainder of the title based on whether the archive is for a specific day, month, year,
 * taxonomy, or post type. It checks if the current archive date matches today's date, the current month, or the current year,
 * and adjusts the title accordingly.
 *
 * @param string $title The original archive title generated by WordPress.
 * @return string The modified archive title with a static prefix and dynamic content.
 */
if (!function_exists('wpx_format_archive_title')) {
    function wpx_format_archive_title($title) {
        $current_day   = current_time('F j, Y');
        $current_month = current_time('F Y');
        $current_year  = current_time('Y');

        // Static prefix for all archive types
        $prefix = __('Posts Made', 'tetris');

        if (is_day()) {
            $archive_day = get_the_date('F j, Y');
            $title = (($archive_day == $current_day)
                ? sprintf(__('%s Today', 'tetris'), $prefix)
                : sprintf(__('%s On: %s', 'tetris'), $prefix, $archive_day));
        } elseif (is_month()) {
            $archive_month = get_the_date('F Y');
            $title = (($archive_month == $current_month)
                ? sprintf(__('%s This Month', 'tetris'), $prefix)
                : sprintf(__('%s In: %s', 'tetris'), $prefix, $archive_month));
        } elseif (is_year()) {
            $archive_year = get_the_date('Y');
            $title = (($archive_year == $current_year)
                ? sprintf(__('%s This Year', 'tetris'), $prefix)
                : sprintf(__('%s In: %s', 'tetris'), $prefix, $archive_year));
        } elseif (is_tax()) { // for custom taxonomies
            $title = sprintf(__('%s', 'tetris'), single_term_title('', false));
        } elseif (is_post_type_archive()) {
            $title = sprintf(__('%s', 'tetris'), post_type_archive_title('', false));
        }

        return $title;
    }
    add_filter('get_the_archive_title', 'wpx_format_archive_title');
}

?>
