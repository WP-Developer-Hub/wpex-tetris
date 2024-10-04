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
<?php if ( is_singular() ) : ?>
    <?php if ( has_post_thumbnail() ) : ?>
        <?php if ( get_theme_mod('universal_toggle_post_thumbnail', false) ) : ?>
            <div id="post-thumbnail" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>'); background-size: cover; background-position: center center;">
                <?php the_post_thumbnail( 'wpex-post', array( 'alt' => the_title_attribute( array( 'echo' => false ) ), 'class' => 'u-media-16-9' ) ); ?>
            </div><!-- /blog-entry-thumbnail -->
            <span class="u-block u-spacer-h u-spacer-light" style="background: #eee; margin-top: 30px;"></span>
        <?php endif; ?>
    <?php endif; ?>
<?php else : ?>
    <div class="blog-entry-thumbnail" >
        <a href="<?php the_permalink(); ?>" class="u-link-img u-pos-rel">
            <?php if ( has_post_thumbnail() ) : ?>
            <?php
                $classes = get_theme_mod('universal_aspect_ratio', 'u-media-1-1') !== "none" ? 'u-media-1-1' : '';
                the_post_thumbnail('wpex-entry', array( 'alt' => the_title_attribute( array( 'echo' => false ) ), 'class' => $classes));
            ?>
            <?php else : ?>
                <div class="u-media-1-1 u-media-missing-img u-flex u-ai-center u-jc-center" title="<?php the_title(); ?>">
                    <span class="<?php echo universal_get_post_format_icon_classes(get_post_format()); ?>"></span>
                </div>
            <?php endif; ?>
            <?php if ( get_theme_mod('universal_toggle_recent_post_badge', 'true')) : echo wpx_recent_post_badge(get_theme_mod('universal_recent_post_keep_badge_for', 7), get_the_ID()); endif; ?>
        </a>
    </div>
<?php endif; ?>
