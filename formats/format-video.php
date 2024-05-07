<?php
/**
 * Video Format
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

if ( is_singular() ) { ?>
    <div id="post-media"><?php echo universal_display_media(get_the_ID()); ?></div>
<?php } else { ?>
    <div class="blog-entry-media">
        <?php echo universal_display_media(get_the_ID()); ?>
    </div><!-- .blog-entry-thumbnail -->
<?php } ?>
