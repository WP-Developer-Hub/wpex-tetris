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
        <figure class="wp-caption clearfix">
            <?php echo wp_get_attachment_image( $post->ID, 'large' ); ?>

            <?php
            // Get the caption and description
            $caption = wp_get_attachment_caption( $post->ID );
            $description = get_post_field( 'post_content', $post->ID );

            // Check which one to display
            if ( !empty($caption) || !empty($description) ) { ?>
                <figcaption class="wp-caption-text u-fs-30" id="img-attch-page-<?php echo esc_attr($post->ID); ?>" style="line-height: 47px;">
                    <?php
                    // Display caption if available, otherwise display description
                    echo !empty($caption) ? esc_html($caption) : esc_html($description);
                    ?>
                </figcaption>
            <?php } ?>
        </figure><!-- #post -->
    </div><!-- #img-attch-page -->

<?php get_footer(); ?>
