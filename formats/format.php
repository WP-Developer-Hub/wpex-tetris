<?php
/**
 * Standard Format
 *
 * @package   Tetris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    return;
}
?>
<?php if (is_singular()) : ?>
    <?php if (get_theme_mod('universal_toggle_post_thumbnail', false)) : ?>
        <?php if (has_post_thumbnail() && !post_password_required()) : ?>
                <div id="post-thumbnail" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>'); background-size: cover; background-position: center center;">
                    <?php the_post_thumbnail('wpex-post', array('alt' => the_title_attribute(array('echo' => false)), 'class' => 'u-media-16-9')); ?>
                </div><!-- /blog-entry-thumbnail -->
                <?php echo wpx_spacer('', '30'); ?>
        <?php else : ?>
            <?php
                echo wpex_get_post_media_placeholder();
                echo wpx_spacer('', '30');
            ?>
        <?php endif; ?>
    <?php endif; ?>
<?php else : ?>
    <div class="blog-entry-thumbnail" >
        <a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="u-link-img u-pos-rel">
            <?php
            if ( has_post_thumbnail() && !post_password_required() ) {
                $classes = get_theme_mod('universal_aspect_ratio', 'u-media-1-1') !== "none" ? 'u-media-1-1' : '';
                the_post_thumbnail('wpex-entry', ['alt'=> the_title_attribute(['echo' => false]), 'class' => $classes]);
            } else {
                echo wpx_get_post_media_placeholder();
            }

            if ( get_theme_mod('universal_toggle_recent_post_badge', 'true') ) {
                echo wpx_recent_post_badge(get_the_ID(), get_theme_mod('universal_recent_post_keep_badge_for', 7));
            }
            ?>
        </a>
    </div>
<?php endif; ?>
