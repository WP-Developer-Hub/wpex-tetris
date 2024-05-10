<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

get_header(); ?>
    <header id="page-heading" class="clearfix">
        <h1 id="archive-title"><?php _e( 'Search Results For', 'tetris' ); ?>: &quot;<?php the_search_query(); ?>&quot;</h1>
    </header>
    <header id="page-heading" class="search-heading clearfix">
        <?php get_search_form(); ?>
    </header>

<?php if ( have_posts() ) : ?>

	<div id="blog-wrap" class="u-grid u-grid-col-auto u-grid-gap-10">
		<?php while ( have_posts() ) : the_post();
			get_template_part( 'content' );
		endwhile; ?>
	</div><!-- #blog-wrap -->

	<?php wpex_pagination(); ?>

<?php endif; ?>

<?php get_footer(); ?>
