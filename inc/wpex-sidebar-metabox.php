<?php
/**
 * This template includes a metabox that allows you to control sidebar visibility
 * on a per-page basis, overriding the global sidebar setting from the Customizer.
 *
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site may use a different template.
 *
 * @package   Testris WordPress Theme
 * @author    DJABHipHoph
 * @copyright Copyright (c) 2025, https://github.com/WP-Developer-Hub
 * @link      https://github.com/WP-Developer-Hub
 * @since     8.2.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    return;
}

if (!class_exists('WPEX_Sidebar_Metabox')) {
    class WPEX_Sidebar_Metabox {
        public function __construct() {
            add_action('save_post', [$this, 'save_sidebar_meta']);
            add_action('page_attributes_misc_attributes', [$this, 'register_sidebar_setting']);
        }

        public function register_sidebar_setting($post) {
            if (!get_post_type_object($post->post_type)->public) {
                return;
            }

            wp_nonce_field('wpex_sidebar_nonce', 'wpex_sidebar_nonce');
            
            $value = get_post_meta($post->ID, 'wpex_toggle_sidebar', true);
            // Fallback to global if no post meta
            if (empty($value)) {
                $value = 'default';
            }
            ?>
            <div class="main">
                <p class="post-attributes-label-wrapper">
                    <label for="wpex_toggle_sidebar">
                        <strong><?php _e('Sidebar Visibility Settings', 'tetris'); ?></strong>
                    </label>
                </p>
                <select name="wpex_toggle_sidebar" id="wpex_toggle_sidebar" class="widefat">
                    <option value="default" <?php selected($value, 'default'); ?>>
                        <?php _e('Default (Global)', 'tetris'); ?>
                    </option>
                    <option value="always_on" <?php selected($value, 'always_on'); ?>>
                        <?php _e('Always Visible', 'tetris'); ?>
                    </option>
                    <option value="always_off" <?php selected($value, 'always_off'); ?>>
                        <?php _e('Always Hidden', 'tetris'); ?>
                    </option>
                </select>
            </div>
            <?php
        }

        public function save_sidebar_meta($post_id) {
            // Verify nonce
            if (!isset($_POST['wpex_sidebar_nonce']) || !wp_verify_nonce($_POST['wpex_sidebar_nonce'], 'wpex_sidebar_nonce')) {
                return;
            }

            // Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

            // Check permissions
            if (!current_user_can('edit_page', $post_id)) return;

            // Delete autosave/post revisions
            if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;

            // Save actual SELECTED VALUE
            if (isset($_POST['wpex_toggle_sidebar'])) {
                $selected_value = sanitize_text_field($_POST['wpex_toggle_sidebar']);
                update_post_meta($post_id, 'wpex_toggle_sidebar', $selected_value);
            } else {
                delete_post_meta($post_id, 'wpex_toggle_sidebar');
            }
        }
    }
    new WPEX_Sidebar_Metabox();
}
