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
if ( has_post_thumbnail() ) : ?>
    <?php if ( is_singular() ) : ?>
        <div id="post-thumbnail" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>'); background-size: cover; background-position: center center;">
            <?php the_post_thumbnail( 'wpex-post' ); ?>
        </div><!-- /blog-entry-thumbnail -->
        <span class="u-block u-spacer-h u-spacer-light" style="background: #eee; margin-top: 30px;"></span>
    <?php else : ?>
        <div class="blog-entry-thumbnail" >
            <?php the_post_thumbnail( 'wpex-entry' ); ?>
        </div><!-- /blog-entry-thumbnail -->
    <?php endif; ?>
<?php endif; ?>
