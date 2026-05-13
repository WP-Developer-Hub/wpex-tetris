(function ($) {
    var api = wp.customize;

    api.controlConstructor['wpx_color_picker_control'] = api.Control.extend({
        ready: function () {
            var control = this;

            // root container
            var container = control.container;

            var colorPicker = container.find("#" + control.id + "_color");
            var swapLight = container.find("#" + control.id + "_swap_text_light");
            var lightValue = container.find("#" + control.id + "_light_value");
            var lightSlider = container.find("#" + control.id + "_light_slider");

            var swapDark = container.find("#" + control.id + "_swap_text_dark");
            var darkValue = container.find("#" + control.id + "_dark_value");
            var darkSlider = container.find("#" + control.id + "_dark_slider");

            var accent_color = colorPicker.val();

            function toBoolean(val) {
                return val.prop('checked') ? true : false;
            }

            function toInt(val) {
                return val.prop('checked') ? 1 : 0;
            }

            function isLightColor(color, inv) {
                const hex = color.replace('#', '');
                const c_r = parseInt(hex.substring(0, 2), 16);
                const c_g = parseInt(hex.substring(2, 4), 16);
                const c_b = parseInt(hex.substring(4, 6), 16);
                const brightness = ((c_r * 299) + (c_g * 587) + (c_b * 114)) / 1000;
                return brightness > 155 ? (inv ? "#000" : "#fff") : (inv ? "#fff" : "#000");
            }

            function adjust_brightness(hex, percent) {
                // Remove the leading `#` if present and trim any spaces
                hex = hex.replace(/^\s*#|\s*$/g, "");

                // Convert 3-character hex codes to 6-character format (e.g., `E0F` → `EE00FF`)
                if (hex.length === 3) {
                hex = hex.replace(/(.)/g, "$1$1");
                }

                // Ensure it's a valid hex code
                if (!/^([A-Fa-f0-9]{6})$/.test(hex)) {
                console.warn("Invalid hex color:", hex);
                return "#000000"; // Return black if invalid
                }

                // Convert hex to RGB values
                let r = parseInt(hex.substr(0, 2), 16);
                let g = parseInt(hex.substr(2, 2), 16);
                let b = parseInt(hex.substr(4, 2), 16);

                // Adjust brightness
                r = Math.round(r + ((255 - r) * percent) / 100);
                g = Math.round(g + ((255 - g) * percent) / 100);
                b = Math.round(b + ((255 - b) * percent) / 100);

                // Ensure RGB values are within bounds
                r = Math.min(255, Math.max(0, r));
                g = Math.min(255, Math.max(0, g));
                b = Math.min(255, Math.max(0, b));

                // Convert back to hex format and return
                return `#${r.toString(16).padStart(2, "0")}${g.toString(16).padStart(2, "0")}${b.toString(16).padStart(2, "0")}`;
            }

            function updateUI() {
                var lightColor = adjust_brightness(accent_color, Number(lightSlider.val()));
                var darkColor = adjust_brightness(accent_color, Number(darkSlider.val()));

                lightValue.css("background-color", lightColor);
                darkValue.css("background-color", darkColor);

                lightValue.css("color", isLightColor(lightColor, toBoolean(swapLight)));
                darkValue.css("color", isLightColor(darkColor, toBoolean(swapDark)));
            }

            function updateSetting() {
                var values = [
                    accent_color,
                    isLightColor(accent_color, true),
                    adjust_brightness(accent_color, darkSlider.val()),
                    isLightColor(adjust_brightness(accent_color, darkSlider.val()), toBoolean(swapDark)),
                    adjust_brightness(accent_color, lightSlider.val()),
                    isLightColor(adjust_brightness(accent_color, lightSlider.val()), toBoolean(swapLight)),
                    toInt(swapLight),
                    toInt(swapDark),
                    lightSlider.val(),
                    darkSlider.val(),
                ];

                control.setting.set(values.join(","));
            }

            // WP color picker
            colorPicker.wpColorPicker({ defaultColor: colorPicker.data("default-color"),
                change: function (event, ui) {
                  accent_color = ui.color.toString();
                  updateUI();
                  updateSetting();
                }
            });

            lightSlider.on("input", function () {
                updateUI();
                updateSetting();
            });

            darkSlider.on("input", function () {
                updateUI();
                updateSetting();
            });

            swapLight.on("change", function () {
                updateUI();
                updateSetting();
            });

            swapDark.on("change", function () {
                updateUI();
                updateSetting();
            });

          // init
            updateUI();
        }
    });
})(jQuery);
