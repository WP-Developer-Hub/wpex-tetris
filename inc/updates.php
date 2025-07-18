<?php
/**
 * Provides automatic updates for the theme via GitHub releases
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Theme Data
$api_url = 'https://api.github.com/repos/WP-Developer-Hub/wpex-tetris/releases/latest';
$theme_slug = 'tetris';

if (!class_exists('WPEX_Theme_Auto_Updates')) {
    class WPEX_Theme_Auto_Updates {
        private $api_endpoint = null;
        private $theme_slug = null;

        public function __construct( $api_url = '', $theme_slug) {
            $this->api_endpoint = $api_url;
            $this->theme_slug = $theme_slug;
            add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));
        }

        private function get_local_version() {
            $theme_data = wp_get_theme();
            $version = $theme_data->Version;
            error_log('[Updater] Local theme version: ' . $version);
            return $version;
        }

        /**
         * Makes a call to the GitHub API
         *
         * @return object|bool The API response
         */
        private function call_api() {
            $args = array(
                'headers' => array(
                    'User-Agent' => 'WordPress/' . get_bloginfo('version'),
                ),
                'timeout' => 15,
            );
            $response = wp_remote_get($this->api_endpoint, $args);

            if (is_wp_error($response)) {
                error_log('[Updater] GitHub API error: ' . $response->get_error_message());
                return false;
            }
            $response_body = wp_remote_retrieve_body($response);
            error_log('[Updater] GitHub API response: ' . $response_body);
            return json_decode($response_body);
        }

        /**
         * Gets the latest release info from GitHub
         *
         * @return object|bool   The release data, or false if API call fails.
         */
        public function get_license_info() {
            $release = $this->call_api();
            if (!$release || empty($release->tag_name)) {
                error_log('[Updater] No release or tag_name found from GitHub API.');
                return false;
            }
            // Find the zip asset
            $package_url = '';
            if (!empty($release->assets) && is_array($release->assets)) {
                foreach ($release->assets as $asset) {
                    if (isset($asset->browser_download_url) && strpos($asset->browser_download_url, '.zip') !== false) {
                        $package_url = $asset->browser_download_url;
                        break;
                    }
                }
            }
            // Fallback to source zip
            if (empty($package_url) && isset($release->zipball_url)) {$package_url = $release->zipball_url;}
            error_log('[Updater] Latest GitHub version: ' . $release->tag_name . ' | Package: ' . $package_url);
            return (object) array(
                'version' => ltrim($release->tag_name, 'v'),
                'package' => $package_url,
                'url' => $release->html_url,
            );
        }

        private function is_api_error( $response ) {
            $is_error = ($response === false);
            if ($is_error) {error_log('[Updater] API response is error/false.');}
            return $is_error;
        }

        public function is_update_available() {
            $release_info = $this->get_license_info();
            if ($this->is_api_error($release_info)) {
                error_log('[Updater] No valid release info.');
                return false;
            }
            $local_version = $this->get_local_version();
            if ( version_compare($release_info->version, $local_version, '>')) {
                error_log('[Updater] Update available! Remote: ' . $release_info->version . ' Local: ' . $local_version);
                return $release_info;
            }
            error_log('[Updater] No update available. Remote: ' . $release_info->version . ' Local: ' . $local_version);
            return false;
        }

        public function check_for_update( $transient ) {
            error_log('[Updater] Running check_for_update...');
            if (empty($transient->checked)) {
                error_log('[Updater] No checked themes in transient.');
                return $transient;
            }
            $info = $this->is_update_available();
            if ($info !== false) {
                $theme_data = wp_get_theme();
                $theme_slug = $theme_data->get_template();
                $transient->response[$theme_slug] = array(
                    'new_version' => $info->version,
                    'package' => $info->package,
                    'url' => $info->url,
                );
                error_log('[Updater] Update array set in transient for ' . $theme_slug);
            } else {
                error_log('[Updater] No update set in transient.');
            }
            return $transient;
        }
    }
}

new WPEX_Theme_Auto_Updates($api_url, $theme_slug);
