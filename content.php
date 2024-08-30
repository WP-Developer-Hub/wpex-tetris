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
        <div class="entry-text clearfix">
            <header class="u-wrap-text">
                <h2>
                    <a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_title(); ?></a>
                </h2>
            </header>
        <?php if(!trim(str_replace('&nbsp;','',strip_tags(wpex_excerpt()))) == ''):?>
            <?php echo wpex_excerpt(get_theme_mod('universal_excerpt_length', 20), get_theme_mod('universal_toggle_read_more_link', 'true')); ?>
        <?php endif;?>
        <ul class="entry-meta">
            <li><strong><?php _e('Posted on', 'tetris'); ?>:</strong> <?php echo get_the_date(); ?></li>
            <li><strong><?php _e('By', 'tetris'); ?>:</strong> <?php the_author_posts_link(); ?></li>
            <?php wpx_comments_popup_link(); ?>
        </ul><!-- /entry-meta -->
    </div><!-- /entry-text -->
</article><!-- /blog-entry -->
