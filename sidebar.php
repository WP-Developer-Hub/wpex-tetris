<?php
/**
 * Returns sidebar
 *
 * @package   Testris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */ ?>

<aside id="sidebar" class="clearfix">
    <section class="sidebar-box widget_search clearfix">
        <h4 class="screen-reader-text"><?php _e('Search', 'tetris'); ?></h4>
        <?php get_search_form(); ?>
    </section>
    <section class="sidebar-widgets clearfix">
        <?php dynamic_sidebar( 'sidebar' ); ?>
    </section>
</aside><!-- #sidebar -->

