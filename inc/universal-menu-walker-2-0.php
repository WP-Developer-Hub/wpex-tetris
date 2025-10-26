<?php
/**
 * Custom Menu Walker Class
 * Defines a custom walker class for WordPress navigation menus.
 *
 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/
 *
 * @package Universal Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Universal_Menu_Walker_2_0')) {
    class Universal_Menu_Walker_2_0 extends Walker_Nav_Menu {
        // Override the start_lvl method to modify sub-menu (ul) output
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat( "\t", $depth );
    
            // Use a unique ID for each submenu
            $submenu_id = 'mobile-sub-menu-' . $depth;
    
            // Open the submenu container
            $output .= "$indent<ul class=\"sub-menu sub-menu-level-$depth\" id=\"$submenu_id\">\n";
        }
    
        // Override the start_el method to modify menu item (li) output
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
            // Get the menu item ID and classes
            $menu_item_id = 'mobile-menu-item-' . $item->ID;
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
            // Add necessary classes
            $classes[] = 'menu-item';
            if ( $args->walker->has_children ) {
                $classes[] = 'menu-item-has-children';
            }
    
            // Determine icon based on depth
    
            // Build the menu item output
            $output .= $indent . '<li id="' . esc_attr( $menu_item_id ) . '" class="' . implode( ' ', $classes ) . '">';
    
            // Prepare Class attribute
            $class_attr = 'class="u-flex"';
    
            // Prepare target attribute if set
            $target_attr = !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    
            // Prepare rel attribute if set
            $rel_attr = !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    
            // Build link once
            $a_tag = '<a href="' . esc_url($item->url) . '" name="' . esc_attr(sanitize_title($item->title)) . '" ' .
                     $target_attr . ' ' . $rel_attr . ' ' . $class_attr . '>' .
                     $item->title .
                     '</a>';
    
            // Add link and toggle if item has children
            if ( $args->walker->has_children ) {
                $output .= '<details class="menu-toggle u-cf">';
                $output .= '<summary class="u-flex u-ai-c" aria-expanded="false">';
                $output .= '<span aria-hidden="true" class="toggle-icon dashicons dashicons-arrow-right u-di-fix u-select-none u-focus-none"></span>';
                $output .= '<span class="menu-item-title">' . $a_tag . '</span>';
                $output .= '</summary>';
            } else {
                $output .= $a_tag;
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
}
