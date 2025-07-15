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
            add_action('add_meta_boxes', [$this, 'register_sidebar_metabox']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_metabox_styles']);
            add_action( 'after_setup_theme', function() {
                if (!defined('WPEX_DEFAULT_SIDEBAR_BEHAVIOR')) {
                    define('WPEX_DEFAULT_SIDEBAR_BEHAVIOR', get_theme_mod( 'universal_toggle_page_sidebar', true));
                }
            });

        }

        public function enqueue_metabox_styles($hook) {
            if ($hook === 'post.php' || $hook === 'post-new.php') {
                wp_enqueue_style('wpex-metabox-styles', get_template_directory_uri() . '/inc/class-wpx-customizer-controls/css/wp-customizer-controls.css', [], null
                );
            }
        }

        /**
         * Register the metabox.
         */
        public function register_sidebar_metabox() {
            add_meta_box(
                'wpex_sidebar_metabox',
                'Sidebar Settings',
                [$this, 'render_metabox'],
                'page',
                'side',
                'default'
            );
        }

        /**
         * Render metabox content.
         */
        public function render_metabox( $post ) {
            wp_nonce_field( basename(__FILE__), 'wpex_sidebar_nonce' );

            $saved_value = WPEX_DEFAULT_SIDEBAR_BEHAVIOR ? '0' : '1';
            $value = get_post_meta($post->ID, 'wpex_enable_sidebar', true);

            ?>
            <label for="wpex_enable_sidebar" class="wpx-control">
                <div class="wpx-toggle-control">
                    <div class="wpx-control-info">
                        <?php echo esc_html__('Toggle Sidebar on this Page', 'tetris'); ?>
                    </div>
                    <input type="checkbox" name="wpex_enable_sidebar" id="wpex_enable_sidebar" value="<?php echo esc_attr($saved_value); ?>" <?php checked($value, $saved_value); ?>
                    />
                    <span class="wpx-toggle-switch"></span>
                </div>
            </label>
            <?php
        }

        /**
         * Save metabox data.
         */
        public function save_sidebar_meta($post_id) {

            // Verify nonce
            if (!isset($_POST['wpex_sidebar_nonce']) || !wp_verify_nonce($_POST['wpex_sidebar_nonce'], basename(__FILE__))) {
                return;
            }

            // Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            // Check permissions
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }

            // Update meta
            if (isset($_POST['wpex_enable_sidebar'])) {
                update_post_meta($post_id, 'wpex_enable_sidebar', "0");
            } else {
                update_post_meta($post_id, 'wpex_enable_sidebar', WPEX_DEFAULT_SIDEBAR_BEHAVIOR);
            }
        }
    }

    new WPEX_Sidebar_Metabox();
}

