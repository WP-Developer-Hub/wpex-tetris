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
<article <?php post_class('blog-entry clearfix'); ?>>
        <?php get_template_part('formats/format'); ?>
        <div class="entry-text clearfix u-grid u-grid-gap-10">
            <header class="u-wrap-text">
                <h2 class="u-text-bt-both">
                    <a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>">
                        <?php echo wpex_get_title(); ?>
                    </a>
                </h2>
            </header>
            <?php echo wpex_excerpt(get_theme_mod('universal_excerpt_length', 20), get_theme_mod('universal_toggle_read_more_link', true)); ?>
        <ul class="entry-meta">
            <li><?php echo wpex_get_post_date(); ?></li>
            <?php echo wpex_get_post_author(); ?>
            <?php wpx_comments_popup_link(); ?>
        </ul><!-- /entry-meta -->
    </div><!-- /entry-text -->
</article><!-- /blog-entry -->
