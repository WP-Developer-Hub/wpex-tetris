<div id="error-message" class="container u-flex u-flex-col u-ai-c clearfix">
    <h1 id="error-message-title" class="u-fs-30">
        <?php _e('Oops, We\'re Sorry', 'tetris'); ?>
    </h1>
    <p id="error-message-text" class="u-fs-18 u-flex u-flex-col u-ai-c">
        <?php
        if (is_search()) :
            _e('Unfortunately, nothing matched your search. Please try different keywords or adjust the post format filter.', 'tetris');
        elseif (is_author()) :
            _e('Unfortunately, there are no posts by this author yet. Please check back later for updates.', 'tetris');
        elseif (is_archive()) :
            _e('Unfortunately, there are no posts available in this archive at the moment. Please check back later.', 'tetris');
        elseif (is_category()) :
            _e('Unfortunately, no posts were found for this category. Feel free to explore other categories.', 'tetris');
        elseif (is_tag()) :
            _e('Unfortunately, no posts were found with this tag. Try using a different tag.', 'tetris');
        elseif (is_page()) :
            _e('Unfortunately, there is no content available on this page. Please check back later or go to the homepage.', 'tetris');
        else:
            _e('Unfortunately, there are no posts available at the moment. Please check back later.', 'tetris');
        endif;
        ?>
    </p>
</div>
