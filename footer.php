<?php
/**
 * The template for displaying the footer and closing elements starting in header.php
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
} ?>

	<div class="clear"></div>

</div><!-- /main-content -->

	<div id="footer-wrap">
		<footer id="footer">
			<div id="footer-widgets" class="u-flex u-flex-wrap u-grid-gap" style="--u-post-item-min-width: 300px; --grid-gap: 40px;">
				<div class="footer-box u-col-1">
					<?php dynamic_sidebar('footer-one'); ?>
				</div><!-- /footer-box -->
				<div class="footer-box u-col-2">
					<?php dynamic_sidebar('footer-two'); ?>
				</div><!-- /footer-box -->
				<div class="footer-box u-col-3">
					<?php dynamic_sidebar('footer-three'); ?>
				</div><!-- /footer-box -->
			</div><!-- /footer-widgets -->
            <span class="u-block u-spacer-h u-spacer-light" style="background: #222; margin: 20px 0;"></span>
            <div id="copyright">
                <?php echo universal_get_copyright_info(); ?>
            </div>
		</footer><!-- /footer -->
	</div><!-- /footer-wrap -->
</div><!-- /wrap -->

<?php wp_footer(); // Footer hook, do not delete, ever ?>

</body>
</html>
