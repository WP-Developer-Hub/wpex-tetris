<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
    class WPX_Customize_Control extends WP_Customize_Control {
        // Base class for extending WP_Customize_Control
        
        protected $wpxCustomControlsCssVersion = '1.3';  // CSS version for custom controls
        protected $wpxCustomControlsJsVersion = '1.2';   // JS version for custom controls
        protected static $tabindex_counter = 1;  // Static counter for tabindex

        /**
         * Get the resource URL.
         *
         * @return string The URL to the resource.
         */
        protected function get_wpx_resource_url() {
            // Get the filesystem path of the current directory
            $current_dir_path = wp_normalize_path(dirname(__FILE__));
            
            // Normalize the path of ABSPATH and the current directory
            $root_path = wp_normalize_path(untrailingslashit(ABSPATH));
            
            // Replace the root path with the site URL
            $url = str_replace(
                $root_path,
                home_url(),
                $current_dir_path
            );

            // Append './' to the URL if it's not already included
            $url = trailingslashit($url) . './';

            // Return the URL, ensuring it's properly escaped
            return esc_url_raw($url);
        }
    }

    class WPX_Toggle_Switch_Control extends WPX_Customize_Control {
        public $type = 'checkbox'; // Define the type of control

        public function enqueue() {
            // Assuming the CSS file is in the 'class-wpx-customizer-controls' directory
            $css_url = $this->get_wpx_resource_url() . 'css/wp-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }
        
        public function render_content() {
            ?>
            <label class="wpx-control" tabindex="<?php echo esc_attr( $this->instance_number ); ?>">
                <div class="wpx-toggle-control">
                    <div class="wpx-control-info">
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <?php if ( $this->description ) : ?>
                            <p class="description"><?php echo esc_html( $this->description ); ?></p>
                        <?php endif; ?>
                    </div>
                    <input type="checkbox" <?php $this->link(); ?> value="1" <?php checked( $this->value(), 1 ); ?> />
                    <span class="wpx-toggle-switch"></span>
                </div>
            </label>
            <?php
        }
    }
    
    class WPX_Ratio_Control extends WPX_Customize_Control {
        public $type = 'radio'; // Define the type of control

        // Enqueue styles for the custom control
        public function enqueue() {
            // Assuming the CSS file is in the 'class-wpx-customizer-controls' directory
            $css_url = $this->get_wpx_resource_url() . 'css/wp-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }

        public function render_content() {
            $instance_number = esc_attr($this->instance_number);
            ?>
            <div class="wpx-control">
              <div class="wpx-ratio-control">
                <div class="wpx-control-info">
                  <span class="customize-control-title">Select Grid Thumbnail Aspect Ratio</span>
                  <p class="description">Choose the aspect ratio for the post thumbnail on single post pages.</p>
                </div>
                <div class="wpx-ratio-group">
                  <!-- Square Ratio Option -->
                  <label for="<?php echo esc_attr($this->id); ?>-1-1">
                    <input type="radio" id="<?php echo esc_attr($this->id); ?>-1-1" name="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> value="1-1" <?php checked($this->value(), '1:1'); ?> />
                    <span class="wpx-ratio-card"></span>
                    <span class="description wpx-ratio-title">1:1</span>
                  </label>
                  <!-- Rectangular Ratio Option -->
                  <label for="<?php echo esc_attr($this->id); ?>-none">
                    <input type="radio" id="<?php echo esc_attr($this->id); ?>-none" name="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> value="none" <?php checked($this->value(), 'none'); ?> />
                    <span class="wpx-ratio-card" style="height: 175px;"></span>
                    <span class="description wpx-ratio-title">9:16</span>
                  </label>
                </div>
              </div>
            </div>
        <?php
        }

    }

    class WPX_Wide_Fat_Control extends WPX_Customize_Control {
        public $type = 'text'; // Default type, can be overridden

        // Enqueue styles for the custom control
        public function enqueue() {
            // Assuming the CSS file is in the 'class-wpx-customizer-controls' directory
            $css_url = $this->get_wpx_resource_url() . 'css/wp-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }

        // Render the control's content
        public function render_content() {
            ?>
            <?php if (!empty($this->label)) : ?>
                <label id="_customize-label-<?php echo esc_attr($this->id); ?>" for="<?php echo esc_attr($this->id); ?>" class="customize-control-title"><?php echo esc_html($this->label); ?></label>
            <?php endif; ?>
            <?php if (!empty($this->description)) : ?>
                <p id="_customize-description-<?php echo esc_attr($this->id); ?>" class="description customize-control-description"><?php echo esc_html($this->description); ?></p>
            <?php endif; ?>
                <?php
                // Determine the input type
                switch ($this->type) {
                    case 'date':
                        $input_type = 'date';
                        break;
                    case 'time':
                        $input_type = 'time';
                        break;
                    case 'datetime-local':
                        $input_type = 'datetime-local';
                        break;
                    case 'month':
                        $input_type = 'month';
                        break;
                    case 'week':
                        $input_type = 'week';
                        break;
                    default:
                        $input_type = 'date';
                        break;
                }
                ?>
                <input id="_customize-input-<?php echo esc_attr($this->id); ?>" type="<?php echo esc_attr($input_type); ?>" class="widefat wpx_date_input" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>"/>
            <?php
        }
    }
}
