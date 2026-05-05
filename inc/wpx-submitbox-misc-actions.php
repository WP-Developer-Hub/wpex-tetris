<?php
/**
 * Define widget areas
 *
 * @package   Tetris WordPress Theme
 * @author    DJABHipHop
 * @copyright Copyright (c) 20206, github.com/WP-Developer-Hub/
 * @link      http://github.com/WP-Developer-Hub/
 * @since     9.4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'WPX_Submitbox_Misc_Actions' ) ) {
    class WPX_Submitbox_Misc_Actions {
        public function __construct() {
            add_action('edit_attachment', array($this, 'save_attachment_misc_actions'), 10, 2);
            add_action('attachment_submitbox_misc_actions', array($this, 'render_attachment_misc_actions'), 12);
        }

        public function render_attachment_misc_actions($post) {
            $value = get_post_meta($post->ID, '_wpx_show_on_404', true);
            if (wp_attachment_is_image($post->ID)) {
            ?>
                <div class="misc-pub-section">
                    <label>
                        <input type="checkbox" name="wpx_show_on_404" value="1" <?php checked($value, '1'); ?> />
                        <?php _e('Show on 404 page','tetris'); ?>
                    </label>
                </div>
            <?php
            }
        }

        public function save_attachment_misc_actions($post_id) {
            if (!empty($_POST['wpx_show_on_404'])) {
                update_post_meta($post_id, '_wpx_show_on_404', '1');
            } else {
                delete_post_meta($post_id, '_wpx_show_on_404');
            }
        }
    }
    new WPX_Submitbox_Misc_Actions();
}
