<?php
/**
 * The template for displaying search filter controls with numbered post formats and post counts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Universal Theme
 */
if (!defined('ABSPATH')) { return; }

// Fetch available post formats
$post_formats = get_theme_support('post-formats');

if ($post_formats && is_array($post_formats[0])) {
    $all_link_url = remove_query_arg('post_format');

    // Initialize variables for total count and format-specific counts
    $total_post_count = 0;
    $format_counts = array();

    // Loop through each post format
    foreach ($post_formats[0] as $post_format) {
        // Format the post format name (e.g., 'aside' to 'Aside')
        $formatted_post_format = ucfirst($post_format);
        
        // Escape and prepare the post format slug for use in URLs
        $post_format_slug = esc_attr($post_format);
        $current_url = esc_url(add_query_arg($_GET));

        $post_format_query_arg = add_query_arg('post_format', $post_format_slug, $current_url);

        // Get the number of posts with the current post format
        $args = array(
            's' => $s,
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-' . $post_format_slug),
                ),
            ),
            'post_status' => 'publish',
        );

        $post_count_query = new WP_Query($args);

        // Get the post count for the current post format
        $post_count = $post_count_query->found_posts;

        // Store format-specific post count
        $format_counts[$post_format_slug] = $post_count;

        // Reset post data after the query
        wp_reset_postdata();
    }

    // At this point, $format_counts contains post counts for each format, and $total_post_count is accurate.
    $total_post_count = new WP_Query("s=$s&posts_per_page=-1&post_status=publish");
    ?>

    <div class="u-margin-top-10 u-grid u-grid-col-s u-flex-gap-10 u-tt-all-uppercase ufc_search">
        <a href="<?php echo esc_url($all_link_url); ?>" class="u-link-button u-block-100 u-flex u-flex-row u-flex-nowrap u-ai-c u-jc-sb<?php echo universal_search_filter_item_class('all'); ?>">
            <span><?php echo __('All', 'tetris'); ?></span>
            &nbsp;<span>(<?php echo esc_html($total_post_count->found_posts); ?>)</span>
        </a>
        <?php
        // Loop through each post format to display links with counts
        foreach ($post_formats[0] as $post_format) {
            $post_format_slug = esc_attr($post_format);
            $post_format_url = add_query_arg('post_format', $post_format_slug, $all_link_url); ?>
            <a href="<?php echo esc_url($post_format_url); ?>" class="u-link-button u-block-100 u-flex u-flex-row u-flex-nowrap u-ai-c u-jc-sb<?php echo universal_search_filter_item_class($post_format_slug); ?>">
                <span><?php echo ucfirst(esc_html($post_format)); ?></span>
                &nbsp;<span>(<?php echo esc_html($format_counts[$post_format_slug]); ?>)</span>
            </a>
        <?php
        }
        ?>
    </div>
    <?php
}
?>
