(function ($) {
    wp.customize.controlConstructor['wpex-media'] = wp.customize.Control.extend({
        ready: function () {
            this.bindEvents();
            this.updateButtons(this.setting.get());
        },

        bindEvents: function () {
            var control = this;

            // Upload
            control.container.on('click', '.wpex-upload-button, .wpex-change-button', function (e) {
                e.preventDefault();

                var frame = wp.media.frames.file_frame = wp.media({
                    title: control.params.button_labels.frame_title,
                    button: {
                        text: control.params.button_labels.frame_button
                    },
                    library: {
                        type: control.params.mime_type || ''
                    },
                    multiple: control.params.multiple
                });

                frame.on('open', function() {
                    var attachments = frame.state().get('library');
                    var idsValue = control.setting.get();
                    if (!idsValue) return;
                    var ids = String(idsValue).split(',');
                    ids.forEach(function(id) {
                        var attachment = wp.media.attachment(id);
                        attachment.fetch();
                        attachments.add(attachment ? [attachment] : []);
                    });
                });

                frame.on('select', function() {
                    var attachments = frame.state().get('library').toJSON();
                    var attachmentIds = [];
                    attachments.forEach(function(attachment) {
                        attachmentIds.push(attachment.id);
                    });
                    control.setting.set(attachmentIds.join(','));
                });

                frame.open();
            });

            // Remove
            control.container.on('click', '.wpex-remove-button', function (e) {
                e.preventDefault();
                control.setting.set('');
            });

            // Default
            control.container.on('click', '.wpex-default-button', function (e) {
                e.preventDefault();
                control.setting.set(control.params.default || '');
            });

            // React to changes
            control.setting.bind(function () {
                control.updateButtons(control.setting.get());
            });
        },

        updateButtons: function (value) {
            var container = this.container;
            var hasValue = Array.isArray(value) ? value.length > 0 : !!value;

            if (hasValue) {
                container.find('.wpex-upload-button').hide();
                container.find('.wpex-change-button').show();
                container.find('.wpex-remove-button').show();
                container.find('.wpex-default-button').hide();
            } else {
                container.find('.wpex-upload-button').show();
                container.find('.wpex-change-button').hide();
                container.find('.wpex-remove-button').hide();
                container.find('.wpex-default-button').show();
            }
        }

    });
})(jQuery);
