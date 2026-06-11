(function ($) {
    var api = wp.customize;
    api.controlConstructor['wpex_medis_uoload_control'] = api.Control.extend({
        ready: function () {
            var control = this;

            _.bindAll(control, 'openMedia', 'removeMedia');

            control.container.on('click', '.wpex_add_media', control.openMedia);
            control.container.on('click', '.wpex_remove_media', control.removeMedia);

            function setAttachmentDataAndRenderContent(value) {
                var hasAttachmentData = $.Deferred();

                if (!value || value.length === 0) {
                    control.params.attachments = [];
                    hasAttachmentData.resolve();
                } else {
                    var requests = [];
                    var ids = value.split(',');
                    control.params.attachments = [];

                    ids.forEach(function (id) {
                        id = parseInt(id, 10);
                        if (_.isNaN(id) || id <= 0) {
                            return;
                        }

                        var attachment = wp.media.attachment(id);
                        var request = attachment.fetch().done(function () {
                            control.params.attachments.push(
                                attachment.attributes
                            );
                        });
                        requests.push(request);
                    });

                    $.when.apply($, requests).done(function () {
                        wp.customize.previewer.send(
                            control.setting.id + '-attachment_ids',
                            control.params.attachments
                        );
                        hasAttachmentData.resolve();
                    });
                }

                hasAttachmentData.done(function () {
                    control.renderContent();
                    var add = control.container.find('.wpex_add_media');
                    var remove = control.container.find('.wpex_remove_media');

                    if (control.params.attachments && control.params.attachments.length > 0) {
                        remove.removeAttr('disabled');
                        add.text(control.params.button_labels.change);
                    } else {
                        remove.attr('disabled', 'disabled');
                        add.text(control.params.button_labels.select);
                    }
                });
            }

            // INITIAL
            setAttachmentDataAndRenderContent(
                control.setting.get()
            );

            // UPDATE
            control.setting.bind(
                setAttachmentDataAndRenderContent
            );
        },

        openMedia: function () {
            var control = this;
            var input = $('#' + control.id + '-attachment_ids');
            var add = control.container.find('.wpex_add_media');

            var mediaUploader = wp.media({
                button: {
                    text: this.params.button_labels.frame_button
                },
                states: [
                    new wp.media.controller.Library({
                        date: false,
                        multiple: 'add',
                        title: this.params.button_labels.frame_title,
                        library: wp.media.query({ type: this.params.mime_type }),
                    })
                ]
            });

            mediaUploader.on('open', function () {
                var attachments = mediaUploader.state().get('selection');
                if (input.val() && input.val().length > 0) {
                    var ids = input.val().split(',');
                    ids.forEach(function(id) {
                        var attachment = wp.media.attachment(id);
                        attachment.fetch();
                        attachments.add(attachment ? [attachment] : []);
                    });
                }
            });

            mediaUploader.on('select', function () {
                var attachments = mediaUploader.state().get('selection').toJSON();
                var attachmentIds = [];
                
                attachments.forEach(function (attachment) {
                    attachmentIds.push(attachment.id);
                });

                input.val(attachmentIds.join(','));
                control.setting.set(attachmentIds.join(','));
            });
            mediaUploader.open();
        },

        removeMedia: function () {
            var control = this;
            control.setting.set('');
            $('#' + control.id + '-attachment_ids').val('');
        }
    });
})(jQuery);
