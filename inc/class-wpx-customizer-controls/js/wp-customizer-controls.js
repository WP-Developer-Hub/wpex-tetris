(function ($) {
  $(function () {
    $.fn.wpxAccentColorControls = function () {
      const control = $(this);
      const colorPicker = $("#" + control.attr("id") + "_color");
      const swapLight = $("#" + control.attr("id") + "_swap_text_light");
      const lightValue = $("#" + control.attr("id") + "_light_value");
      const lightSlider = $("#" + control.attr("id") + "_light_slider");
      const swapDark = $("#" + control.attr("id") + "_swap_text_dark");
      const darkValue = $("#" + control.attr("id") + "_dark_value");
      const darkSlider = $("#" + control.attr("id") + "_dark_slider");

      let accent_color = colorPicker.val();

      function updateHiddenField() {
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
        control.val(values.join(",")).trigger("change");
      }

      colorPicker.wpColorPicker({
        defaultColor: colorPicker.data("default-color"),
        change: function (event, ui) {
          accent_color = ui.color.toString();
          lightValue.css("background-color", adjust_brightness(accent_color, lightSlider.val()));
          darkValue.css("background-color", adjust_brightness(accent_color, darkSlider.val()));
          lightValue.css("color", isLightColor(adjust_brightness(accent_color, lightSlider.val()), toBoolean(swapLight)));
          darkValue.css("color", isLightColor(adjust_brightness(accent_color, darkSlider.val()), toBoolean(swapDark)));
          updateHiddenField();
        },
      });

      lightSlider.on("input", function () {
        lightValue.css("background-color", adjust_brightness(accent_color, lightSlider.val()));
        lightValue.css("color", isLightColor(adjust_brightness(accent_color, lightSlider.val()), toBoolean(swapLight)));
        updateHiddenField();
      });

      darkSlider.on("input", function () {
        darkValue.css("background-color", adjust_brightness(accent_color, darkSlider.val()));
        darkValue.css("color", isLightColor(adjust_brightness(accent_color, darkSlider.val()), toBoolean(swapDark)));
        updateHiddenField();
      });

      swapLight.on("change", function () {
        lightValue.css("color", isLightColor(adjust_brightness(accent_color, lightSlider.val()), toBoolean(swapLight)));
        updateHiddenField();
      });

      swapDark.on("change", function () {
        darkValue.css("color", isLightColor(adjust_brightness(accent_color, darkSlider.val()), toBoolean(swapDark)));
        updateHiddenField();
      });

      function toBoolean(val){
        return val.prop('checked') ? true : false;
      }

      function toInt(val){
        return val.prop('checked') ? 1 : 0;
      }

      function isLightColor(color, inv) {
        const hex = color.replace('#', '');
        const c_r = parseInt(hex.substring(0, 0 + 2), 16);
        const c_g = parseInt(hex.substring(2, 2 + 2), 16);
        const c_b = parseInt(hex.substring(4, 4 + 2), 16);
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

      // Initialize the color value display
      updateHiddenField();
      lightValue.css("background-color", adjust_brightness(accent_color, lightSlider.val()));
      darkValue.css("background-color", adjust_brightness(accent_color, darkSlider.val()));
      lightValue.css("color", isLightColor(adjust_brightness(accent_color, lightSlider.val()), toBoolean(swapLight)));
      darkValue.css("color", isLightColor(adjust_brightness(accent_color, darkSlider.val()), toBoolean(swapDark)));
    }
  });
})(jQuery);
