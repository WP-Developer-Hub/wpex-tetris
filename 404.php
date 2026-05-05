<?php
/**
 * The template for the 404 not found page.
 *
 * @package   Tetris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    return;
}

get_header(); ?>

<div id="error-page" class="container u-flex u-flex-col u-grid-gap-10 u-ai-c u-jc-c clearfix">
    <h1 id="error-page-title" class="u-text-bt-both u-tbe-ca">404</h1>
    <p id="error-page-text">
    <?php _e('Unfortunately, the content you tried accessing could not be retrieved. Please visit the','tetris'); ?> <a href="<?php home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php _e('homepage','tetris'); ?></a>.
    </p>
    <?php echo wpx_get_404_image_html(); ?>
</div><!-- #error-page -->
<?php get_footer(); ?>
