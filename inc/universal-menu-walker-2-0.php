<?php
/**
 * Custom Menu Walker Class
 * Defines a custom walker class for WordPress navigation menus.
 *
 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/
 *
 * @package Universal Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Universal_Menu_Walker_2_0 extends Walker_Nav_Menu {
    // Override the start_lvl method to modify sub-menu (ul) output
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );

        // Use a unique ID for each submenu
        $submenu_id = 'sub-menu-' . $depth;

        // Open the submenu container
        $output .= "$indent<ul class=\"sub-menu sub-menu-level-$depth\" id=\"$submenu_id\">\n";
    }

    // Override the start_el method to modify menu item (li) output
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        // Get the menu item ID and classes
        $menu_item_id = 'menu-item-' . ($item->ID + 1);
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // Add necessary classes
        $classes[] = 'menu-item';
        if ( $args->walker->has_children ) {
            $classes[] = 'menu-item-has-children';
        }

        // Determine icon based on depth

        // Build the menu item output
        $output .= $indent . '<li id="' . esc_attr( $menu_item_id ) . '" class="' . implode( ' ', $classes ) . '">';

        // Add link and toggle if item has children
        if ( $args->walker->has_children ) {
            $output .= '<details class="menu-toggle u-cf">';
            $output .= '<summary>';
            $output .= '<span class="toggle-icon dashicons dashicons-arrow-right"></span>';
            $output .= '<span class="menu-item-title"><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></span>';
            $output .= '</summary>';
        } else {
            $output .= '<a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
        }
    }

    // Override the end_el method to modify menu item (li) closing tag
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';

        // Close details tag if item has children
        if ( $args->walker->has_children ) {
            $output .= '</details>';
        }
    }

    // Override the end_lvl method to modify sub-menu (ul) closing tag
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }
}
