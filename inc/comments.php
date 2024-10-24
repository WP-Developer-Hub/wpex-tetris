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
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body <?php if ($comment->comment_approved == '0') echo 'pending-comment'; ?> clearfix">
                <div class="comment-details">
                    <div class="comment-avatar">
                        <?php echo get_avatar($comment, $size = '45'); ?>
                    </div><!-- /comment-avatar -->
                    <div class="comment-author vcard">
                        <?php printf(__('<cite class="author">%s</cite>', 'tetris'), get_comment_author_link()) ?>
                        <time datetime="<?php echo get_comment_date( 'c' ); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"  class="comment-date"> &middot; <?php echo get_comment_date(); ?></a></<time>
                        <span class="reply">
                            <?php
                            // Display reply link
                            comment_reply_link(array_merge($args, array(
                                'reply_text' => __('Reply', 'tetris'),
                                'depth' => $depth,
                                'max_depth' => $args['max_depth']
                            )));

                            // Create nonce for security
                            $del_nonce = wp_create_nonce("delete-comment_$comment->comment_ID");

                            // Prepare URLs for actions
                            $urls = array(
                                'spam' => admin_url("comment.php?c=$comment->comment_ID&action=spamcomment&_wpnonce=$del_nonce#commentlist"),
                                'trash' => admin_url("comment.php?c=$comment->comment_ID&action=trashcomment&_wpnonce=$del_nonce#commentlist")
                            );

                            // Initialize links variable
                            $links = '';

                            // Get current user ID and check if they are the post author
                            $current_user_id = get_current_user_id();
                            $post_author = ($current_user_id == get_post_field('post_author', get_the_ID()) && current_user_can('edit_posts', get_the_ID()));

                            // Add/Edit Comment Actions
                            if (current_user_can('edit_comment', $comment->comment_ID)) {
                                // Add edit comment link for the comment poster
                                if ($comment->user_id == $current_user_id) {
                                    $links .= edit_comment_link(__('Edit', 'tetris'), '', '');
                                }

                                // Add Spam action link
                                if ($comment->user_id != $current_user_id && $post_author) {
                                    $links .= '<a href="' . esc_url($urls['spam']) . '" class="comment-reply-link" onclick="return confirm(\'' . esc_js(__('Are you sure you want to mark this comment as spam?', 'tetris')) . '\');">' . __('Spam', 'tetris') . '</a>';
                                }

                                // Add Delete action link
                                if ($comment->user_id == $current_user_id || $post_author) {
                                    $links .= '<a href="' . esc_url($urls['trash']) . '" class="comment-reply-link" onclick="return confirm(\'' . esc_js(__('Are you sure you want to permanently delete this comment?', 'tetris')) . '\');">' . __('Delete', 'tetris') . '</a>';
                                }
                            }

                            // Output links
                            echo $links;
                            ?>
                        </span>
                    </div><!-- /comment-meta -->
                    <div class="comment-content">
                        <div class="comment-text u-wrap-text">
                            <?php comment_text() ?>
                        </div><!-- /comment-text -->
                    </div><!-- /comment-content -->
                </div><!-- /comment-details -->
        </div><!-- /comment -->
<?php
} //end wpex_comments_output()
?>
