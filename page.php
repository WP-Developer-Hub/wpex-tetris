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
        <div id="page" <?php post_class('entry'); ?>>
            <h1 class="screen-reader-text">
                <?php echo sprintf( __( '%1$s page For %2$s', 'tetris' ), get_the_title(), get_bloginfo('name') ); ?>
            </h1>
            <h2 class="screen-reader-text"><?php the_title(); ?></h2>
            <div id="inner-page" class="u-pos-rel inner-post">
                <?php the_content(); ?>
            </div><!-- .inner-post -->
        </div><!-- .entry -->
    </div><!-- #single-page-content -->
<?php endwhile; else: ?>
    <?php get_template_part( 'addons/addon-error-message' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
