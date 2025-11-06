<div id="error-message" class="container u-flex u-flex-col u-ai-c clearfix">
    <h1 id="error-message-title" class="u-fs-30">
        <?php _e('Oops, We\'re Sorry', 'tetris'); ?>
    </h1>
    <p id="error-message-text" class="u-fs-18 u-flex u-flex-col u-ai-c">
        <?php
            $error_message_text = '';
            switch (true) {
                case is_search():
                    $error_message_text = __('Unfortunately, nothing matched your search. Please try different keywords or adjust the post format filter.', 'tetris');
                    break;
                case is_author():
                    $error_message_text = __('Unfortunately, there are no posts by this author yet. Please check back later for updates.', 'tetris');
                    break;
                case is_archive():
                    $error_message_text = __('Unfortunately, there are no posts available in this archive at the moment. Please check back later.', 'tetris');
                    break;
                case is_category():
                    $error_message_text = __('Unfortunately, no posts were found for this category. Feel free to explore other categories.', 'tetris');
                    break;
                case is_tag():
                    $error_message_text = __('Unfortunately, no posts were found with this tag. Try using a different tag.', 'tetris');
                    break;
                case is_page():
                    $error_message_text = __('Unfortunately, there is no content available on this page. Please check back later or go to the homepage.', 'tetris');
                    break;
                default:
                    $error_message_text = __('Unfortunately, there are no posts available at the moment. Please check back later.', 'tetris');
                    break;
            }
            echo apply_filters('wpex_no_results_message', $error_message_text, true);
        ?>
    </p>
</div>
