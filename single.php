<?php
/**
 * The Template for displaying all single posts.
 *
 * @package   Tetris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header();

if ( have_posts()) : while ( have_posts()) : the_post(); ?>
	<div id="single-post-content" class="sidebar-bg container clearfix">
		<article id="post" <?php post_class('clearfix'); ?>>
            <!--  Display media -->
            <?php get_template_part( 'formats/format', get_post_format() ); ?>
			<!--  Show header on all post formats except quotes -->
            <header id="post-header">
                <h1><?php the_title(); ?></h1>
                <?php echo wpx_spacer(); ?>
                <ul class="single-post-meta clearfix">
                    <li class="single-post-meta-divider">
                        <strong><?php _e('Posted on', 'tetris'); ?>:</strong>
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                    </li>
                    <li class="single-post-meta-divider" ><strong><?php _e('By', 'tetris'); ?>:</strong> <?php the_author_posts_link(); ?></li>
                    <?php if (has_category()) : ?>
                        <li class="single-post-meta-divider">
                            <strong><?php _e('Under', 'tetris'); ?>:</strong>
                            <span class="u-wrap-text-all"> <?php the_category(', '); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php wpx_comments_popup_link(); ?>
                </ul><!-- .meta -->
            </header><!-- #post-header -->

            <?php if ( !empty( get_the_content() ) ) : ?>
            <?php echo wpx_spacer(); ?>
                <div class="entry">
                    <div id="inner-post" class="inner-post">
                        <?php the_content(); // This is your main post content output ?>
                    </div><!-- .inner-post -->
                </div><!-- .entry -->
            <?php endif; ?>

            <?php if (strpos($post->post_content, '<!--nextpage-->') !== false) : ?>
                <?php echo wpx_spacer(); ?>
                <?php echo wpx_custom_link_pages();?>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'universal_toggle_post_tags', true ) ) : ?>
                <?php if ( !empty( get_the_tags() ) ) : ?>
                    <?php echo wpx_spacer(); ?>
                    <?php the_tags( '<div id="post-tags" class="u-flex u-flex-wrap u-flex-gap-5">', '', '</div>' ); ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'universal_toggle_post_author_box', true ) ) : ?>
            <div id="single-author" >
                <h4 id="author-title" class="heading widget-title"><span><?php the_author_posts_link(); ?></span></h4>
                <div class="author-inner u-flex u-flex-gap-10">
                    <div id="author-image">
                       <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '150', '', 'Avatar', array( 'class' => '' ) ); ?></a>
                    </div><!-- #author-image -->
                    <div id="author-bio" class="u-block u-block-100">
                        <?php the_author_meta('description'); ?>
                    </div><!-- #author-bio -->
                </div>
            </div><!-- #single-author -->
            <?php endif; ?>

			<?php comments_template(); ?>

		</article><!-- post -->
		
		<?php get_sidebar(); ?>
		
	</div><!-- #single-post-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
