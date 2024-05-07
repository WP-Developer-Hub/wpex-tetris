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
 * @return string      The HTML container for the media.
 */
function universal_display_media($post_id) {
    $attachment_ids = get_post_meta($post_id, 'universal_local_media_attachment_ids', true);
    $container = '';

    if (!empty($attachment_ids)) {
        // Get post format (if supported)
        $post_format = get_post_format($post_id);

        if ($post_format === 'gallery') {
            // Display a gallery of images
            $gallery_attr = array(
                'ids' => $attachment_ids,
                'type' => 'carousel',
                'columns' => is_single() ? '3' : '6',
                'link' => is_single() ? 'file' : 'attachment',
                'size' => is_single() ? 'medium' : 'universal-small',
            );

            $container .= gallery_shortcode($gallery_attr);
        } else {
            // Determine if tracklist should be displayed based on the count of attachment IDs
            $display_tracklist = (count(explode(',', $attachment_ids)) > 1);

            // Display playlist for audio or video post formats
            $playlist_attr = array(
                'ids' => $attachment_ids,
                'style' => 'dark',
                'images' => true,
                'artists' => true,
                'tracklist' => $display_tracklist,
                'tracknumbers' => false,
                'type' => ($post_format === 'audio') ? 'audio' : 'video',
            );

            $container .= wp_playlist_shortcode($playlist_attr);
        }

        if (is_single()) {
            $container .= '<span class="u-block u-spacer-h u-spacer-light" style="background: #eee; margin-top: 30px;"></span>';
        }

    } else {
        $container = "No attachments found for this post.";
    }

    return $container;
}

/**
 * Check if the theme is displaying media in the gallery view.
 *
 * @return bool True if media display is enabled in the gallery view on large screens, false otherwise.
 */
function universal_display_embed_media($post_id) {
    // Get the universal oembed URL meta value for the current post
    $universal_oembed_url = get_post_meta($post_id, 'universal_oembed_url', true);

    // Check if the oembed URL is available
    if ($universal_oembed_url) {
        // Get oEmbed response for the URL
        $oembed_response = wp_oembed_get($universal_oembed_url);

        // Determine the opening tag based on post context
        if (is_single()) {
            $wrapper_start = '<div id="post-media" class="u-flex u-flex-wrap u-cf">';
        } else {
            $wrapper_start = '<div class="blog-entry-embed u-flex u-flex-wrap u-cf">';
        }

        // Output embedded video if oEmbed response exists
        if ($oembed_response) {
            $wrapper .= $wrapper_start . $oembed_response . '</div>';
        } else {
            // Fallback to displaying the URL if oEmbed response is empty
            $wrapper .= $wrapper_start . esc_url($universal_oembed_url) . '</div>';
        }

        if (is_single()) {
            $wrapper .= '<span class="u-block u-spacer-h u-spacer-light" style="background: #eee; margin-top: 30px;"></span>';
        }
    
        return $wrapper;
    }
}

/**
 * Check if the theme is displaying media in the gallery view.
 *
 * @return bool True if media display is enabled in the gallery view on large screens, false otherwise.
 */
function universal_is_displaying_media_gl() {
    return (get_theme_mod('universal_disable_media_on_lg', false) && !get_post_format() == "");
}

/**
 * Get the copyright information.
 *
 * @return string The copyright information.
 */
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

/**
 * Get the copyright information.
 *
 * @return string The copyright information.
 */
function universal_custom_paginate_comments_links($range = 4) {
    $showitems = ($range * 2) + 1;
    $current_page = max(1, get_query_var('cpage'));

    if (get_comment_pages_count() > 1) {
        echo '<div class="page-pagination"><div class="page-pagination-inner clearfix">';
        echo '<div class="page-of-page"><span class="inner">' . $current_page . ' of ' . get_comment_pages_count() . '</span></div>';

        echo '<div class="pagination-links">';
        for ($i = 1; $i <= get_comment_pages_count(); $i++) {
            if (1 != get_comment_pages_count() && (
                !($i >= $current_page + $range + 1 || $i <= $current_page - $range - 1) || get_comment_pages_count() <= $showitems
            )) {
                $url = get_comments_pagenum_link($i);
                echo ($current_page == $i) ? "<span class=\"current outer\"><span class=\"inner\">" . $i . "</span></span>" : "<a href='" . esc_url($url) . "' class=\"inactive\"><span class=\"inner\">" . $i . "</span></a>";
            }
        }
        echo '</div>'; // .pagination-links

        echo "</div></div>\n";
    }
}

/**
 * Convert hexadecimal color code to RGBA format.
 *
 * @param string $color   The hexadecimal color code.
 * @param mixed  $opacity Optional opacity value (default: false).
 * @return string         The formatted RGBA color string.
 */
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

/**
 * Determine if a color is light or dark.
 *
 * @param string $color The color code.
 * @return string|false The color code for text color (black or white) or false if no color provided.
 */
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

/**
 * Generate dynamic CSS variables based on theme customizer settings.
 *
 * @return string The generated CSS string.
 */
function universal_dynamic_css() {
    // Get background color, accent color & accent color text color from theme customizer
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

/**
 * Display the custom logo of the theme.
 */
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

?>
