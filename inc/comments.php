<?php
/**
 * Custom Comment Display
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

function wpex_comments_output($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php echo esc_attr(get_comment_ID()) ?>">
        <article id="comment-<?php echo esc_attr(get_comment_ID()); ?>" class="comment-body clearfix<?php if ($comment->comment_approved == '0') echo esc_attr(' pending-comment'); ?>" aria-label="<?php echo sprintf(/* translators: %s: Comment author name */ esc_attr__('Comment by %s', 'tetris'), esc_html(get_comment_author()));?>">
            <div class="comment-details">
                <div class="comment-avatar">
                    <?php echo wpex_get_avatar($comment, '50', __('Comment Author\'s Avatar', 'tetris')); ?>
                </div><!-- /comment-avatar -->
                <div class="comment-author vcard u-grid u-grid-gap-0">
                <?php printf(/* translators: %s: Comment author name */ '<cite class="author u-wrap-text u-text-bt-both" title="%s">%s</cite>', esc_attr(get_comment_author()), get_comment_author_link()); ?>
                <a href="<?php echo esc_url(get_comment_link(intval($comment->comment_ID))); ?>" class="comment-date" rel="scroll" aria-label="<?php esc_attr_e('click here to scroll comment into view', 'tetris'); ?>"><time datetime="<?php echo esc_attr(get_comment_date( 'c' )); ?>" class="u-text-bt-both"><?php echo esc_html(get_comment_date()); ?></time></a>
                </div><!-- /comment-meta -->
                <div class="comment-content u-wrap-text u-text-bt-both">
                    <?php comment_text() ?>
                </div><!-- /comment-content -->
                <?php if (comments_open()) : ?>
                    <div class="comment-actions reply u-block-100 u-flex u-flex-row u-ai-c u-jc-fe">
                        <?php
                        // Display reply link
                        comment_reply_link(array_merge($args, array(
                            'reply_text' => __('Reply', 'tetris'),
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            '<span>',
                            '</span>'
                        )));

                        // Create nonce for security
                        $spam_nonce = wp_create_nonce("spam-comment_$comment->comment_ID");
                        $del_nonce = wp_create_nonce("delete-comment_$comment->comment_ID");

                        // Prepare URLs for actions
                        $urls = array(
                            'edit' => get_edit_comment_link($comment->comment_ID, "url"),
                            'spam' => admin_url("comment.php?c=$comment->comment_ID&action=spamcomment&_wpnonce=$spam_nonce#commentlist"),
                            'trash' => admin_url("comment.php?c=$comment->comment_ID&action=trashcomment&_wpnonce=$del_nonce#commentlist")
                        );

                        // Get current user ID and check if they are the post author
                        $current_user_id = get_current_user_id();
                        $post_author = ($current_user_id == get_post_field('post_author', intval(get_the_ID())) && current_user_can('edit_posts', intval(get_the_ID())));

                        // Initialize links variable
                        $links = '';

                        // Add/Edit Comment Actions
                        if (current_user_can('edit_comment', $comment->comment_ID)) {
                            // Add edit comment link for the comment poster
                            if ($comment->user_id == $current_user_id) {
                                $links .= wpex_add_comment_action_link($urls['edit'], __('Edit', 'tetris'), __('Edit this comment', 'tetris'), '');
                            }

                            // Add Spam action link
                            if ($comment->user_id != $current_user_id && $post_author) {
                                $links .= wpex_add_comment_action_link($urls['spam'], __('Spam', 'tetris'), __('Mark this comment as spam', 'tetris'), __('Are you sure you want to mark this comment as spam?', 'tetris'));
                            }

                            // Add Delete action link
                            if ($comment->user_id == $current_user_id || $post_author) {
                                $links .= wpex_add_comment_action_link($urls['trash'], __('Delete', 'tetris'), __('Delete this comment', 'tetris'), __('Are you sure you want to permanently delete this comment?', 'tetris'));
                            }
                        }

                        // Output links
                        echo $links;
                        ?>
                    </div>
                <?php endif; ?>
            </div><!-- /comment-details -->
        </article><!-- /comment -->
<?php
} //end wpex_comments_output()
?>
