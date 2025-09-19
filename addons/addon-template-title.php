<?php
/**
 * The template for displaying template titles.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPEX Tetris
 */
if (!defined('ABSPATH')) { return; }
?>

<header class="page-heading clearfix">
    <h1>
        <?php
        $prefix = __('Posts Made', 'tetris');
        $current_year = current_time('Y');
        $current_month = current_time('F Y');
        $current_day = current_time('F j, Y');

        switch (true) {
            case is_day():
                $archive_day = get_the_date('F j, Y');
                $archive_day_datetime = get_the_date('c');
                echo ($archive_day === $current_day)
                    ? sprintf(__('%s Today', 'tetris'), $prefix)
                    : sprintf(__('%s On: <time datetime="%s">%s</time>', 'tetris'), $prefix, esc_attr($archive_day_datetime), esc_html($archive_day));
                break;
            case is_month():
                $archive_month = get_the_date('F Y');
                $archive_month_datetime = get_the_date('Y-m');
                echo ($archive_month === $current_month)
                    ? sprintf(__('%s This Month', 'tetris'), $prefix)
                    : sprintf(__('%s In: <time datetime="%s">%s</time>', 'tetris'), $prefix, esc_attr($archive_month_datetime), esc_html($archive_month));
                break;
            case is_year():
                $archive_year = get_the_date('Y');
                $archive_year_datetime = get_the_date('Y');
                echo ($archive_year === $current_year)
                    ? sprintf(__('%s This Year', 'tetris'), $prefix)
                    : sprintf(__('%s In: <time datetime="%s">%s</time>', 'tetris'), $prefix, esc_attr($archive_year_datetime), esc_html($archive_year));
                break;
            case is_tax():
                echo esc_html(single_term_title('', false));
                break;
            case is_post_type_archive():
                echo esc_html(post_type_archive_title('', false));
                break;
            case is_category():
                echo esc_html(single_cat_title('', false));
                break;
            case is_home() && get_the_title(get_option('page_on_front')):
                echo esc_html(get_bloginfo('description'));
                break;
            case is_tag():
                echo sprintf(esc_html__("Posts For: \"%s\"", "tetris"), esc_html(single_tag_title('', false)));
                break;
            case is_search():
                echo sprintf(esc_html__("Search Results For: \"%s\"", "tetris"), esc_html(get_search_query()));
                break;
            case is_author():
                echo sprintf(esc_html__("Posts By: %s", "tetris"), esc_html(get_the_author()));
                break;
            default:
                echo get_the_archive_title();
                break;
        }
        ?>
    </h1>
</header>
