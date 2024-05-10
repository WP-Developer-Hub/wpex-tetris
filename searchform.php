<?php
/**
 * The template for displaying the search form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Universal Theme
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
} ?>

<form method="get" id="searchbar" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off" results="0">
    <label>
        <span class="screen-reader-text"><?php _e( 'Type and hit enter to search', 'tetris' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php _e( 'Type and hit enter to search', 'tetris' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'tetris' ); ?>" autocomplete="off" results='0' onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
    </label>
    <?php if ( is_search()) : ?>
        <?php get_template_part('addons/addon-search-filter-control'); ?>
    <?php endif; ?>
</form>
