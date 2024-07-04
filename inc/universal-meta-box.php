<?php
/**
 * Universal_Meta_Box
 *
 * Implements a custom meta box for handling oEmbed and local media settings.
 *
 * @package Universal_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Universal_Meta_Box {
    /**
     * Constructor.
     * Hooks into necessary actions upon class instantiation.
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save_meta_box_data'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Adds the custom meta box to the post editor screen.
     */
    public function add_meta_box() {
        add_meta_box(
            'universal_meta_box',
            __('Universal Media', 'tetris'),
            array($this, 'render_meta_box_content'),
            'post',
            'normal',
            'high'
        );
    }

    /**
     * Renders the content of the custom meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function render_meta_box_content($post) {
        // Add a nonce field for security.
        wp_nonce_field('universal_meta_box_nonce', 'universal_meta_box_nonce');

        ?>
        <style>
            .universal_meta_table {
                all: unset !important;
            }
            .universal_meta_table .square {
                min-width: 40px;
                text-align: center;
                vertical-align: middle;
            }
            .universal_meta_table .button-link-delete {
                border-color: #d63638 !important;
            }
            .universal_group {
                display: flex;
            }
            .universal_group .universal_media_button {
                border-radius: 0;
                margin-right: -1px;
            }
            .universal_group .widefat {
                transition: all 1s ease-in-out 0s;
            }
            .universal_media_button {
                text-align: left;
                padding: 10px !important;
            }
            .universal_media_button .dashicons {
                vertical-align: middle;
            }
            .universal_media_button .universal_media_button_icon {
                margin-right: 5px;
            }
        </style>
        <table class="widefat universal_meta_table">
            <tbody>
                <?php
                    echo $this->add_media_library_control('video', 'Video', 'format-video', $post);
                    echo $this->add_media_library_control('audio', 'Audio', 'format-audio', $post);
                    echo $this->add_media_library_control('image', 'Images', 'format-image', $post);
                ?>
                <tr>
                    <td>
                        <span class="dashicons dashicons-format-audio"></span>
                        <span class="dashicons dashicons-format-video"></span>
                        <span class="dashicons dashicons-format-gallery"></span>
                        <?php _e('Use the Audio, Video, or Gallery formats to display the appropriate local media above the theme. Choosing Standard post will display the post thumbnail above the theme is the option to show post thumbnail in single.php is enabled.', 'tetris'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    /**
     * Adds media library control for a specified media type.
     *
     * @param string $type The media type (e.g., 'audio', 'video', 'image').
     * @param string $label The label for the media type.
     * @param string $icon The Dashicon class for the media type.
     * @param WP_Post $post The current post object.
     * @return string The HTML output for the media library control.
     */
    private function add_media_library_control($type, $label, $icon, $post) {
        $local_ids = get_post_meta($post->ID, 'universal_local_' . $type . '_attachment_ids', true);

        ob_start();
        ?>
        <tr>
            <td>
                <div class="universal_group">
                    <label for="universal_local_media_upload_<?php echo $type; ?>" class="screen-reader-text"><?php _e('Add ' . $label, 'tetris'); ?></label>
                    <button type="button" id="universal_local_media_upload_<?php echo $type; ?>" class="button universal_media_button widefat" data-editor="content">
                        <span class="universal_media_button_icon dashicons dashicons-<?php echo $icon; ?>"></span> <?php _e('Add ' . $label, 'tetris'); ?>
                    </button>
                    <label for="universal_local_media_clear_all_<?php echo $type; ?>" class="screen-reader-text"><?php _e('Clear All ' . $label, 'tetris'); ?></label>
                    <button type="button" id="universal_local_media_clear_all_<?php echo $type; ?>" class="button button-link-delete universal_media_button square" style="display: none;" data-editor="content">
                        <span class="dashicons dashicons-remove"></span>
                    </button>
                </div>
                <input type="hidden" id="universal_local_<?php echo $type; ?>_attachment_ids" name="universal_local_<?php echo $type; ?>_attachment_ids" value="<?php echo esc_attr($local_ids); ?>">
            </td>
        </tr>
        <?php
        return ob_get_clean();
    }

    /**
     * Saves the media library setting for a specified media type.
     *
     * @param int $post_id The ID of the post being saved.
     * @param string $type The media type (e.g., 'audio', 'video', 'image').
     */
    private function save_media_library_meta($post_id, $type) {
        // Save/update 'universal_local_audio_attachment_ids'
        if (isset($_POST['universal_local_' . $type . '_attachment_ids'])) {
            update_post_meta($post_id, 'universal_local_' . $type . '_attachment_ids', sanitize_text_field($_POST['universal_local_' . $type . '_attachment_ids']));
        } else {
            delete_post_meta($post_id, 'universal_local_' . $type . '_attachment_ids');
        }
    }

    /**
     * Enqueues necessary scripts and styles for the meta box.
     *
     * @param string $hook The current admin page hook.
     */
    public function enqueue_scripts($hook) {
        if ('post.php' !== $hook && 'post-new.php' !== $hook) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_script('universal-meta-box', get_template_directory_uri() . '/js/universal-meta-box.js', array('jquery'), '1.0', true);
    }

    /**
     * Saves meta box data for the post.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save_meta_box_data($post_id) {
        // Verify nonce
        if (!isset($_POST['universal_meta_box_nonce']) || !wp_verify_nonce($_POST['universal_meta_box_nonce'], 'universal_meta_box_nonce')) {
            return;
        }

        // Save/update 'universal_local_video_attachment_ids'
        $this->save_media_library_meta($post_id, 'video');

        // Save/update 'universal_local_audio_attachment_ids'
        $this->save_media_library_meta($post_id, 'audio');

        // Save/update 'universal_local_image_attachment_ids'
        $this->save_media_library_meta($post_id, 'image');
    }
}

// Instantiate the Universal_Meta_Box class.
new Universal_Meta_Box();

