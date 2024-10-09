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

	<?php if ( ! is_home() ) : ?>
		<header class="page-heading clearfix">
            <h1 id="archive-title"> <?php echo esc_html__( 'Posts By', 'tetris' ) . ': ' . esc_html( get_the_author() )?> </h1>
		</header>
	<?php endif; ?>

<?php if ( have_posts() ) : ?>

	<div id="blog-wrap" class="u-grid u-grid-col-auto u-grid-gap-10">
		<?php while ( have_posts() ) : the_post();
			get_template_part( 'content' );
		endwhile; ?>
	</div><!-- #blog-wrap -->

	<?php echo wpex_pagination(); ?>

<?php endif; ?>

<?php get_footer(); ?>
