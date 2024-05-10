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
        <?php if (universal_is_displaying_media_gl()) : ?>
            <?php get_template_part('formats/format', get_post_format()); ?>
        <?php else: ?>
            <?php get_template_part('formats/format'); ?>
        <?php endif; ?>
        <div class="entry-text clearfix">
            <header class="u-wrap-text">
                <h2>
                <?php if (universal_is_displaying_media_gl()) : ?>
                    <?php the_title(); ?>
                <?php else: ?>
                    <a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_title(); ?></a>
                <?php endif; ?>
                </h2>
            </header>
        <div class="u-wrap-text u-trim" style="--u-line-clamp: 6">
            <?php wpex_excerpt(); ?>
        </div>
        <ul class="entry-meta">
            <li><strong>Posted on:</strong> <?php echo get_the_date(); ?></li>
            <li><strong>By:</strong> <?php the_author_posts_link(); ?></li>
            <?php if(comments_open()) { ?><li class="comment-scroll"><strong>With:</strong> <?php comments_popup_link(__('0 Comments', 'tetris'), __('1 Comment', 'tetris'), __('% Comments', 'tetris'), 'comments-link' ); ?></li><?php } ?>
        </ul><!-- /entry-meta -->
    </div><!-- /entry-text -->
</article><!-- /blog-entry -->
