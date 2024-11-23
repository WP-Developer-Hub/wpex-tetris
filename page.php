<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package   Testris WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    return;
}

get_header();

if ( have_posts()) : while (have_posts() ) : the_post(); ?>
    <div id="single-page-content" class="container clearfix">
        <!-- Page wrapper with post_class() applied -->
        <article id="page" <?php post_class('entry clearfix'); ?>>
            <?php the_content(); ?>
        </article><!-- .entry -->
    </div><!-- #single-page-content -->

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
