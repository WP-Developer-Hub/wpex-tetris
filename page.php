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

$hide_sidebar = get_post_meta(get_the_ID(), 'wpex_enable_sidebar', true);
$show_sidebar = (get_theme_mod('universal_toggle_page_sidebar', true) !== $hide_sidebar);

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="single-page-content" class="container clearfix<?php echo ( $show_sidebar ? ' has-sidebar-bg' : '' ); ?>">
        <!-- Page wrapper with post_class() applied -->
        <article id="page" <?php post_class( 'entry' . ( $show_sidebar ? ' has-sidebar' : '' ) . ' clearfix' ); ?>>
            <h1 class="screen-reader-text">
                <?php echo sprintf( __( '%1$s page For %2$s', 'tetris' ), get_the_title(), get_bloginfo('name') ); ?>
            </h2>
            <div id="inner-page" class="u-pos-rel inner-post">
                <?php the_content(); ?>
            </div><!-- .inner-post -->
        </article><!-- #page -->

        <?php if ( $show_sidebar ) { get_sidebar(); } ?>

    </div><!-- #single-page-content -->
<?php endwhile; else: ?>
    <?php get_template_part( 'addons/addon-error-message' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
