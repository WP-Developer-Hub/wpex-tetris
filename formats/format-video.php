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
?>

<div id="post-media" class="u-media-16-9"><?php echo universal_display_media(get_the_ID()); ?></div>
<?php echo wpx_spacer('', '30'); ?>
