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

    class WPX_Color_Picker_Control extends WPX_Customize_Control {
        public $type = 'text';

        public function enqueue() {
            $css_url = $this->get_wpx_resource_url() . 'css/wp-customizer-controls.css';
            $js_url = $this->get_wpx_resource_url() . 'js/wp-customizer-controls.js';

            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style('wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion);
            wp_enqueue_script('wpx-customize-controls-js', $js_url, array(), $this->wpxCustomControlsJsVersion);
        }

        public function render_content() {
            $min = isset($this->input_attrs['min']) ? $this->input_attrs['min'] : -100;
            $max = isset($this->input_attrs['max']) ? $this->input_attrs['max'] : 100;
            $step = isset($this->input_attrs['step']) ? $this->input_attrs['step'] : 1;

            $default = array_pad(!empty($this->setting->default) ? $this->setting->default : [], 5, '');

            // Ensure $value is a proper array
            $value = is_string($this->value()) ? explode(',', $this->value()) : [];
            $value = array_pad($value, 10, '');

            // Assign values safely
            $color = !empty($value[0]) ? $value[0] : $default[0];
            $swap_text_light = !empty($value[6]) ? (int) $value[6] : (int) $default[1];
            $swap_text_dark = !empty($value[7]) ? (int) $value[7] : (int) $default[2];
            $lightness_value = !empty($value[8]) ? $value[8] : $default[3];
            $darkness_value = !empty($value[9]) ? $value[9] : $default[4];
            ?>

            <div class="wpx-control wpx-color-picker-control" tabindex="<?php echo esc_attr($this->instance_number); ?>">
                <div class="wpx-control-info">
                    <?php if (!empty($this->label)) : ?>
                        <label for="<?php echo esc_attr($this->id); ?>" class="customize-control-title">
                            <?php echo esc_html($this->label); ?>
                        </label>
                    <?php endif; ?>

                    <?php if (!empty($this->description)) : ?>
                        <p id="_customize-description-<?php echo esc_attr($this->id); ?>" class="description customize-control-description">
                            <?php echo esc_html($this->description); ?>
                        </p>
                    <?php endif; ?>

                    <div class="wpx-color-picker-group">
                        <input
                            type="text"
                            data-default-color="<?php echo esc_attr($default[0]); ?>"
                            id="<?php echo esc_attr($this->id); ?>_color"
                            value="<?php echo esc_attr($color); ?>"
                            aria-describedby="_customize-description-<?php echo esc_attr($this->id); ?>"
                        />

                        <span class="wpx-range-group">
                            <label class="widefat wpx-swap-control">
                                <span class="wpx-color-picker-display" id="<?php echo esc_attr($this->id); ?>_light_value">
                                    <?php echo __('Accent Color Light', 'tetris'); ?>
                                </span>
                                <div class="wpx-toggle-control">
                                    <span class="screen-reader-text">
                                        <?php echo __('Swap Accent Color Light Text', 'tetris'); ?>
                                    </span>
                                    <input type="checkbox" id="<?php echo esc_attr($this->id); ?>_swap_text_light" value="1" <?php checked($swap_text_light, 1); ?> />
                                    <span class="wpx-toggle-switch"></span>
                                </div>
                            </label>
                            <input type="range"
                                id="<?php echo esc_attr($this->id); ?>_light_slider"
                                class="wpx-color-picker-input"
                                min="<?php echo esc_attr($min); ?>"
                                max="<?php echo esc_attr($max); ?>"
                                step="<?php echo esc_attr($step); ?>"
                                value="<?php echo esc_attr($lightness_value); ?>"
                                list="wpx_datalist_<?php echo esc_attr($this->id); ?>_light"
                                aria-labelledby="<?php echo esc_attr($this->id); ?>_light_value"
                            />
                            <datalist id="wpx_datalist_<?php echo esc_attr($this->id); ?>_light" class="wpx-range-value">
                                <option value="<?php echo esc_attr($min); ?>">Min</option>
                                <option value="0">0</option>
                                <option value="<?php echo esc_attr($max); ?>">Max</option>
                            </datalist>
                        </span>

                        <span class="wpx-range-group">
                            <label class="widefat wpx-swap-control">
                                <span class="wpx-color-picker-display" id="<?php echo esc_attr($this->id); ?>_dark_value">
                                    <?php echo __('Accent Color Dark', 'tetris'); ?>
                                </span>
                                <div class="wpx-toggle-control">
                                    <span class="screen-reader-text">
                                        <?php echo __('Swap Accent Color Dark Text', 'tetris'); ?>
                                    </span>
                                    <input type="checkbox" id="<?php echo esc_attr($this->id); ?>_swap_text_dark" value="1" <?php checked($swap_text_dark, 1); ?> />
                                    <span class="wpx-toggle-switch"></span>
                                </div>
                            </label>
                            <input type="range"
                                id="<?php echo esc_attr($this->id); ?>_dark_slider"
                                class="wpx-color-picker-input"
                                min="<?php echo esc_attr($min); ?>"
                                max="<?php echo esc_attr($max); ?>"
                                step="<?php echo esc_attr($step); ?>"
                                value="<?php echo esc_attr($darkness_value); ?>"
                                list="wpx_datalist_<?php echo esc_attr($this->id); ?>_dark"
                                aria-labelledby="<?php echo esc_attr($this->id); ?>_dark_value"
                            />
                            <datalist id="wpx_datalist_<?php echo esc_attr($this->id); ?>_dark" class="wpx-range-value">
                                <option value="<?php echo esc_attr($min); ?>">Min</option>
                                <option value="0">0</option>
                                <option value="<?php echo esc_attr($max); ?>">Max</option>
                            </datalist>
                        </span>
                    </div>

                    <input
                        <?php $this->link(); ?>
                        type="hidden"
                        id="<?php echo esc_attr($this->id); ?>"
                        value="<?php echo esc_attr(implode(',', $value)); ?>"
                        aria-describedby="_customize-description-<?php echo esc_attr($this->id); ?>"
                    />

                </div>
            </div>

            <script type="text/javascript">
                (function($) {
                    $(function() {
                        $("<?php echo esc_js('#' . $this->id); ?>").wpxAccentColorControls();
                    });
                })(jQuery);
            </script>

            <?php
        }
    }
}
