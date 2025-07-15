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
                    <a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>">
                        <?php echo !empty(get_the_title()) ? get_the_title() : __('Untitled Post', 'tetris') . ' ' . get_the_ID(); ?>
                    </a>
                </h2>
            </header>
        <?php if(!post_password_required()):?>
            <?php if(!trim(str_replace('&nbsp;','',strip_tags(wpex_excerpt()))) == ''):
                echo wpex_excerpt(get_theme_mod('universal_excerpt_length', 20), get_theme_mod('universal_toggle_read_more_link', true));
            endif;?>
        <?php else : ?>
            <p><?php echo __( 'This content is protected. Log in or enter the password to view the full content.', 'tetris' ); ?></p>
        <?php endif;?>
        <ul class="entry-meta">
            <li><?php echo wpex_get_post_date(); ?></li>
            <li><?php echo wpex_get_post_author(); ?></li>
            <?php wpx_comments_popup_link(); ?>
        </ul><!-- /entry-meta -->
    </div><!-- /entry-text -->
</article><!-- /blog-entry -->
