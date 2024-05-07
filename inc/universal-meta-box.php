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
            'universal_meta_box', // Metabox ID.
            __('Universal Media', 'universal-theme'), // Metabox title.
            array($this, 'render_meta_box_content'), // Callback function to render the metabox content.
            'post', // Post type to display the metabox.
            'normal', // Metabox position (e.g., 'normal', 'side', 'advanced').
            'high' // Metabox priority (e.g., 'default', 'high', 'low').
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

        // Get the saved oEmbed URL value for the post.
        $oembed_url = get_post_meta($post->ID, 'universal_oembed_url', true);
        $local_media_ids = get_post_meta($post->ID, 'universal_local_media_attachment_ids', true);
        ?>
        <style>
            .universal_meta_table {
                all: unset !important;
            }
            .universal_media_button {
                text-align: left;
                padding: 10px !important;
            }
            .universal_media_button .dashicons {
                text-align: left;
                margin-right: 5px;
                vertical-align: middle;
            }
        </style>
        <table class="widefat universal_meta_table">
            <tbody>
                <tr>
                    <td>
                        <label for="universal_oembed_url" class="screen-reader-text"><?php _e('Embed Media URL:', 'universal-theme'); ?></label>
                        <input type="text" id="universal_oembed_url" name="universal_oembed_url" class="widefat" value="<?php echo esc_attr($oembed_url); ?>" placeholder="<?php _e('Enter embed media URL', 'universal-theme'); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="dashicons dashicons-admin-links" class="screen-reader-text"></span>
                        <?php _e('Use the link format to display embedded media above the theme.', 'universal-theme'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="universal_local_media_upload_video" class="screen-reader-text"><?php _e('Add Video:', 'universal-theme'); ?></label>
                        <button id="universal_local_media_upload_video" class="button universal_media_button widefat" data-editor="content">
                            <span class="dashicons dashicons-format-video"></span> <?php _e('Add Video', 'universal-theme'); ?>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="universal_local_media_upload_audio" class="screen-reader-text"><?php _e('Add Audio:', 'universal-theme'); ?></label>
                        <button id="universal_local_media_upload_audio" class="button universal_media_button widefat" data-editor="content">
                            <span class="dashicons dashicons-format-audio"></span> <?php _e('Add Audio', 'universal-theme'); ?>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="universal_local_media_upload_image" class="screen-reader-text"><?php _e('Add Images:', 'universal-theme'); ?></label>
                        <button id="universal_local_media_upload_image" class="button universal_media_button widefat" data-editor="content">
                            <span class="dashicons dashicons-format-image"></span> <?php _e('Add Images', 'universal-theme'); ?>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="dashicons dashicons-format-audio"></span>
                        <span class="dashicons dashicons-format-video"></span>
                        <span class="dashicons dashicons-format-gallery"></span>
                        <?php _e('Use the Audio, Video, or Gallery formats to embed media above the theme. Choose the appropriate dashicon based on how media is displayed (list or grid layout).', 'universal-theme'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" id="universal_local_media_attachment_ids" name="universal_local_media_attachment_ids" value="<?php echo esc_attr($local_media_ids); ?>">
        <?php
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
     * Saves meta box data when a post is saved or updated.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save_meta_box_data($post_id) {
        if (!isset($_POST['universal_meta_box_nonce']) || !wp_verify_nonce($_POST['universal_meta_box_nonce'], 'universal_meta_box_nonce')) {
            return;
        }

        if (isset($_POST['universal_oembed_url'])) {
            update_post_meta($post_id, 'universal_oembed_url', sanitize_text_field($_POST['universal_oembed_url']));
        }

        if (isset($_POST['universal_local_media_attachment_ids'])) {
            update_post_meta($post_id, 'universal_local_media_attachment_ids', sanitize_text_field($_POST['universal_local_media_attachment_ids']));
        } else {
            delete_post_meta($post_id, 'universal_local_media_attachment_ids');
        }
    }
}

// Instantiate the Universal_Meta_Box class.
new Universal_Meta_Box();

