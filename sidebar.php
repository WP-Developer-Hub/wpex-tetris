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
    <?php if ( ! get_theme_mod( 'universal_hide_sidebar_search', false ) ) : ?>
        <section class="sidebar-box widget_search clearfix">
            <h4 class="screen-reader-text"><?php _e('Search', 'tetris'); ?></h4>
            <?php get_search_form(); ?>
        </section>
    <?php endif; ?>

    <div class="<?php echo esc_attr(get_theme_mod('universal_hide_sidebar_mobile', false) ? ' sidebar-widgets' : ''); ?> clearfix">
        <?php dynamic_sidebar( 'sidebar' ); ?>
    </div>
</aside><!-- #sidebar -->

