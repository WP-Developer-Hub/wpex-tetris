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

<div id="error-page" class="container clearfix">	
    <div style="height:95px"></div>
	<h1 id="error-page-title">404</h1>
	<p id="error-page-text">
	<?php _e('Unfortunately, the page you tried accessing could not be retrieved. Please visit the','tetris'); ?> <a href="<?php home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php _e('homepage','tetris'); ?></a>.
    </p>
    <div id="error-page-widget" class="u-flex u-jc-c u-block-100">
        <div id="error-widget-box" class="u-block-100 clearfix">
            <?php
                dynamic_sidebar( 'error-widget' );
            ?>
        </div>
    </div>
    <div style="height:95px"></div>
</div><!-- #error-page -->

<?php get_footer(); ?>
