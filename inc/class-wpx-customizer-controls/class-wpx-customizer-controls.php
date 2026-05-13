<?php
if (class_exists('WP_Customize_Control') && !class_exists('wpx-WPX_Customize_Control')) {
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

    class WPX_Customize_Section extends WP_Customize_Section {
        // Base class for extending WP_Customize_Control
        
        protected $wpxCustomSectionsCssVersion = '1.3';  // CSS version for custom controls
        protected $wpxCustomSectionsJsVersion = '1.2';   // JS version for custom controls
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

    class WPX_Customize_Color_Control extends wp_customize_color_control {
        // Base class for extending WP_Customize_Control
        
        protected $wpxCustomColorControlsCssVersion = '1.3';  // CSS version for custom controls
        protected $wpxCustomColorControlsJsVersion = '1.2';   // JS version for custom controls
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
            $css_url = $this->get_wpx_resource_url() . 'css/wpx-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }
        
        public function render_content() {
            ?>
            <label class="wpx-control" tabindex="<?php echo esc_attr( $this->instance_number ); ?>">
                <div class="wpx-toggle-control">
                    <div class="wpx-control-info">
                        <?php if ( $this->label ) : ?>
                            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <?php endif; ?>
                        <?php if ( $this->description ) : ?>
                            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
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
        public $type = 'wpx_ratio_control'; // Define the type of control

        // Enqueue styles for the custom control
        public function enqueue() {
            // Assuming the CSS file is in the 'class-wpx-customizer-controls' directory
            $css_url = $this->get_wpx_resource_url() . 'css/wpx-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url,[], $this->wpxCustomControlsCssVersion );
        }

        public function __construct($manager) {
            parent::__construct(
                $manager,
                'universal_aspect_ratio',
                array(
                    'label' => __('Aspect Ratio', 'tetris'),
                    'description' => __('Select the aspect ratio for grid item images. Choose "auto" for the default or "1:1" for a square aspect ratio.', 'tetris'),
                    'section' => 'universal_grid_item_settings_section',
                )
            );
        }

        public function render_content() {
            $value = $this->value();
            $value = !empty($value) ? $value : $this->setting->default;
            $instance_number = esc_attr($this->instance_number);
            ?>
            <div class="wpx-control">
              <div class="wpx-ratio-control">
                <div class="wpx-control-info">
                   <span class="customize-control-title"><?php echo __('Select Grid Thumbnail Aspect Ratio', 'tetris'); ?></span>
                   <span class="description customize-control-description"><?php echo __('Choose the aspect ratio for the post thumbnail on single post pages.', 'tetris'); ?></span>
                </div>

                <div class="wpx-ratio-group">

                  <!-- Square Ratio Option -->
                  <label for="<?php echo esc_attr($this->id); ?>-1-1">
                    <input type="radio"
                      id="<?php echo esc_attr($this->id); ?>-1-1"
                      name="<?php echo esc_attr($this->id); ?>"
                      <?php $this->link(); ?>
                      value="1:1"
                      <?php checked($value, '1:1'); ?> />
                    <span class="wpx-ratio-card"></span>
                    <span class="description wpx-ratio-title">1:1</span>
                  </label>

                  <!-- Rectangular Ratio Option -->
                  <label for="<?php echo esc_attr($this->id); ?>-none">
                    <input type="radio"
                      id="<?php echo esc_attr($this->id); ?>-none"
                      name="<?php echo esc_attr($this->id); ?>"
                      <?php $this->link(); ?>
                      value="9:16"
                      <?php checked($value, '9:16'); ?> />
                    <span class="wpx-ratio-card" style="height: 175px;"></span>
                    <span class="description wpx-ratio-title">9:16</span>
                  </label>

                </div>
              </div>
            </div>
            <?php
        }

    }

    class WPX_Extended_Date_Time_Control extends WPX_Customize_Control {
        public $type = 'date';
        public $min = '';
        public $max = '';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $this->min = isset( $args['min'] ) ? 'min="' . esc_attr($args['min']) . '"' : '';
            $this->max = isset( $args['max'] ) ? 'max="' . esc_attr($args['max']) . '"' : '';
        }

        public function enqueue() {
            $css_url = $this->get_wpx_resource_url() . 'css/wpx-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }

        public function render_content() {
            ?>
            <?php if (!empty($this->label)) : ?>
                <label id="_customize-label-<?php echo esc_attr($this->id); ?>" for="<?php echo esc_attr($this->id); ?>" class="customize-control-title"><?php echo esc_html($this->label); ?></label>
            <?php endif; ?>
            <?php if (!empty($this->description)) : ?>
                <span id="_customize-description-<?php echo esc_attr($this->id); ?>" class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>

            <?php
            switch ($this->type) {
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
            <input id="_customize-input-<?php echo esc_attr($this->id); ?>" type="<?php echo esc_attr($input_type); ?>" class="widefat wpx_date_input" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" <?php echo $this->min; ?> <?php echo $this->max; ?>/>
            <?php
        }
    }

    class WPX_Color_Picker_Control extends WPX_Customize_Color_Control {
        public $type = 'wpx_color_picker_control';

        public function enqueue() {
            $css_url = $this->get_wpx_resource_url() . 'css/wpx-customizer-controls.css';
            $js_url = $this->get_wpx_resource_url() . 'js/wpx-color-picker-customizer-control.js';

            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('customize-controls');

            wp_enqueue_style('wpx-customize-controls', $css_url, ['wp-color-picker'], $this->wpxCustomColorControlsCssVersion);
            wp_enqueue_script('wpx-color-picker-customizer-control', $js_url, ['jquery', 'customize-controls', 'wp-color-picker'], $this->wpxCustomColorControlsJsVersion);
        }

        public function __construct($manager) {
            parent::__construct(
                $manager,
                'universal_accent_color',
                array(
                    'label' => __('Accent Color', 'tetris'),
                    'section' => 'colors',
                    'input_attrs' => [
                        'step' => 1,
                        'min' => -50,
                        'max' => 50,
                    ],
                )
            );
        }

        public function to_json() {
            parent::to_json();

            $value = (is_string($this->value()) ? explode(',', $this->value()) : []);
            $value = array_pad($value, 10, '');

            $this->json['id'] = $this->id;
            $this->json['value'] = $value;
            $this->json['label'] = $this->label;
            $this->json['description'] = $this->description;
            $this->json['input_attrs'] = $this->input_attrs;
            $this->json['default'] = $this->setting->default;
        }

        public function render_content() {}

        public function content_template() {
        ?>
        <#
        var min = data.input_attrs?.min ?? -100;
        var max = data.input_attrs?.max ?? 100;
        var step = data.input_attrs?.step ?? 1;

        var defaultVal = data.default || [];

        var value = data.value;

        var color = value[0] || defaultVal[0];
        var swap_text_light = parseInt(value[6] || defaultVal[1] || 0);
        var swap_text_dark = parseInt(value[7] || defaultVal[2] || 0);
        var lightness_value = value[8] || defaultVal[3];
        var darkness_value = value[9] || defaultVal[4];
        #>

        <div class="wpx-control wpx-color-picker-control" tabindex="{{ data.instanceNumber }}">
            <div class="wpx-control-info">
                <# if ( data.label ) { #>
                    <label class="customize-control-title">{{ data.label }}</label>
                <# } #>

                <# if ( data.description ) { #>
                    <span class="description customize-control-description">
                        {{ data.description }}
                    </span>
                <# } #>

                <div class="wpx-color-picker-group">
                    <input type="text" id="{{ data.id }}_color" data-default-color="{{ defaultVal[0] }}" value="{{ color }}" />

                    <span class="wpx-range-group">
                        <label class="widefat wpx-swap-control">
                            <span id="{{ data.id }}_light_value" class="wpx-color-picker-display">
                                <?php echo __('Accent Color Light', 'tetris'); ?>
                            </span>

                            <div class="wpx-toggle-control">
                                <input type="checkbox"
                                       id="{{ data.id }}_swap_text_light"
                                       value="1"
                                       <# if ( swap_text_light ) { #> checked <# } #> />
                                <span class="wpx-toggle-switch"></span>
                            </div>
                        </label>

                        <input type="range" id="{{ data.id }}_light_slider" min="{{ min }}" max="{{ max }}" step="{{ step }}" value="{{ lightness_value }}" />
                    </span>

                    <span class="wpx-range-group">
                        <label class="widefat wpx-swap-control">
                            <span id="{{ data.id }}_dark_value" class="wpx-color-picker-display">
                                <?php echo __('Accent Color Dark', 'tetris'); ?>
                            </span>

                            <div class="wpx-toggle-control">
                                <input type="checkbox"
                                       id="{{ data.id }}_swap_text_dark"
                                       value="1"
                                       <# if ( swap_text_dark ) { #> checked <# } #> />
                                <span class="wpx-toggle-switch"></span>
                            </div>
                        </label>

                        <input type="range"
                               id="{{ data.id }}_dark_slider"
                               min="{{ min }}"
                               max="{{ max }}"
                               step="{{ step }}"
                               value="{{ darkness_value }}" />
                    </span>
                </div>
                <input type="hidden" id="{{ data.id }}" value="{{ value.join(',') }}" />
            </div>
        </div>
        <?php
        }
    }

    class WPX_Divider extends WPX_Customize_Control {
        public $type = 'info_box';

        public function render_content() {
        ?>
            <hr class="wpx-divider">
        <?php
        }
    }

    class WPX_Link_Section extends WPX_Customize_Section {
        /**
         * The type of control being rendered
         */
        public $type = 'wpex-link-section';
        /**
         * The Upsell URL
         */
        public $url = '';
        /**
         * The Dashicon
         */
        public $dashicon = 'dashicons-admin-links';
        /**
         * Enqueue our scripts and styles
         */
        public function enqueue() {
            $css_url = $this->get_wpx_resource_url() . 'css/wpx-customizer-controls.css';
            wp_enqueue_style( 'wpx-customize-controls', $css_url, array(), $this->wpxCustomControlsCssVersion );
        }
        /**
         * Render the section, and the controls that have been added to it.
         */
        protected function render() {
            ?>
            <li id="accordion-section-<?php echo esc_attr($this->id); ?>" class="wpex_link_section accordion-section control-section-<?php echo esc_attr($this->id); ?>">
                <a href="<?php echo esc_url($this->url); ?>" target="_blank" type="button" class="accordion-section-title" aria-expanded="false">
                    <h3 class="accordion-trigger">
                        <?php echo esc_html($this->title); ?>
                        <span class="dashicons <?php echo esc_attr($this->dashicon); ?>"></span>
                    </h3>
                </a>
            </li>
            <?php
        }
    }
}
