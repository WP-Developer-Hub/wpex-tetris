 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * The actual display of comments is handled by a callback to
 * wpex_comments_output() which is located at inc/comments.php
 *
 * @package   Testris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( ! have_comments() && ! comments_open() && !pings_open() ) ) {
	return;
}
?>
<div id="commentsbox" class="boxframe">
	<div id="comments" class="comments-area clearfix">
		<?php if ( have_comments() ) : ?>
			<h3 class="comments-title widget-title"><span><?php comments_popup_link(__('Leave a comment', 'tetris'), __('1 Comment', 'tetris'), __('% Comments', 'tetris'), 'comments-link', __('Comments closed', 'tetris')); ?></span></h3>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                /* coment-nav-above */
                echo universal_custom_paginate_comments_links('above');
			endif; ?>
			<ol id="commentlist" class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'wpex_comments_output' ) ); ?>
			</ol><!-- /commentlist -->
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                /* coment-nav-below */
                echo universal_custom_paginate_comments_links('below');
			endif; ?>
		<?php endif; ?>
		<?php comment_form( array(
			'title_reply' => '<span class="widget-title">'. __( 'Leave a Reply', 'tetris' ) .'</span>'
		) ); ?>
	</div><!-- #comments -->
</div><!-- #commentsbox -->
