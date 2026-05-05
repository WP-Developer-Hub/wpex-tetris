(function ($) {
    var api = wp.customize;
    var control;
    var mediaUploader;
    api.controlConstructor['wpex-media'] = api.Control.extend({
        ready: function () {
            control = this;

            _.bindAll(control, 'open', 'removeFile', 'openFrame', 'select', 'setAttachmentDataAndRenderContent');

            control.container.on('click keydown', '.wpex-upload-button', control.openFrame);
            control.container.on('click keydown', '.wpex-remove-button', control.removeFile);

            control.setAttachmentDataAndRenderContent(control.setting());
            control.setting.bind(control.setAttachmentDataAndRenderContent);
        },

        setAttachmentDataAndRenderContent: function (value) {
            var control = this,
                hasAttachmentData = $.Deferred();

            value = parseInt(value, 10);

            if (_.isNaN(value) || value <= 0) {
                delete control.params.attachment;
                hasAttachmentData.resolve();
            } else if (control.params.attachment && control.params.attachment.id === value) {
                hasAttachmentData.resolve();
            } else {
                wp.media.attachment(value).fetch().done(function () {
                    control.params.attachment = this.attributes;
                    wp.customize.previewer.send(control.setting.id + '-attachment-data', this.attributes);
                    hasAttachmentData.resolve();
                });
            }

            hasAttachmentData.done(function () {
                control.renderContent();
            });
        },

        openFrame: function (event) {
            if (api.utils.isKeydownButNotEnterEvent(event)) {
                return;
            }

            event.preventDefault();

            if (!this.frame) {
                this.initFrame();
            }

            this.frame.open();
        },

        initFrame: function () {
            mediaUploader = this.frame = wp.media.frames.file_frame = wp.media({
                button: {
                    text: this.params.button_labels.frame_button
                },
                states: [
                    new wp.media.controller.Library({
                        title: this.params.button_labels.frame_title,
                        library: wp.media.query({ type: this.params.mime_type }),
                        multiple: this.params.multiple,
                        date: false
                    })
                ]
            });

            this.frame.on('open', this.open);
            this.frame.on('select', this.select);
        },

        open: function () {
            var idsValue = String(control.params.attachments || '');
            var selection = mediaUploader.state().get('selection');

            if (idsValue.length > 0) {
                idsValue.split(',').forEach(function (id) {
                    var attachment = wp.media.attachment(id.trim());
                    attachment.fetch();
                    selection.add(attachment);
                });
            }
        },

        select: function () {
            var selection = this.frame.state().get('selection');
            var attachmentIds = [];

            selection.each(function (attachment) {
                attachmentIds.push(attachment.toJSON().id);
            });

            this.params.attachments = attachmentIds.join(',');
            this.setting(attachmentIds.join(','));
        },

        removeFile: function (event) {
            if (api.utils.isKeydownButNotEnterEvent(event)) {
                return;
            }

            event.preventDefault();

            this.params.attachment = {};
            this.setting('');
            this.renderContent();
        }
    });
})(jQuery);
