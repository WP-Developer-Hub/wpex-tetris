<header class="page-heading clearfix">
    <h1>
        <?php
            if (is_category()) {
                echo esc_html(single_cat_title('', false));
            } elseif (is_home() && get_the_title(get_option('page_on_front'))) {
                echo esc_html(get_bloginfo('description'));
            } elseif (is_tag()) {
                printf(
                    /* translators: %s: tag name */
                    esc_html__("Posts For: \"%s\"", "tetris"),
                    esc_html(single_tag_title('', false))
               );
            } elseif (is_search()) {
                printf(
                    /* translators: %s: search query */
                    esc_html__("Search Results For: \"%s\"", "tetris"),
                    esc_html(get_search_query())
               );
            } elseif (is_author()) {
                printf(
                    /* translators: %s: author name */
                    esc_html__("Posts By: %s", "tetris"),
                    esc_html(get_the_author())
               );
            } else {
                the_archive_title('', false);
            }
        ?>
    </h1>
</header>
