<?php
/**
 * Image attachment page
 *
 * @package   Testris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    return;
}

get_header(); ?>

    <div class="page-heading">
        <h1><?php the_title(); ?></h1>
    </div><!-- /page-heading -->

    <div id="img-attch-page" class="container u-flex u-flex-col u-ai-c u-jc-c clearfix">
        <?php
            // Get the attachment ID
            $attachment_id = $post->ID; // Ensure this is the correct ID for the image

            // Get the caption and description
            $caption = wp_get_attachment_caption($attachment_id);
            $description = get_post_field('post_content', $attachment_id);
            $img_caption = !empty($caption) ? esc_html($caption) : esc_html($description);

            // Get the image HTML
            $image_html = wp_get_attachment_image($attachment_id, 'wpex-post');
            $metadata = wp_get_attachment_image_src($attachment_id, 'wpex-post');
            $image_width = $metadata['1'];

            // Output the captioned image
            echo img_caption_shortcode(
                array(
                    'id' => $attachment_id,
                    'align' => '',
                    'width' => $image_width,
                    'caption' => $img_caption,
                 ),
                $image_html
            );
        ?>
    </div><!-- #img-attch-page -->

<?php get_footer(); ?>
