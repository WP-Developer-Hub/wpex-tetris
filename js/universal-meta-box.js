jQuery(document).ready(function($) {
    // Function to open the media uploader and handle selection
    function openMediaUploader(mediaType, inputFieldId) {
        var mediaUploader = wp.media({
            button: {
                text: 'Use This ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1)
            },
            states: [
                new wp.media.controller.Library({
                    title: 'Upload ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1),
                    library: wp.media.query({
                        type: mediaType
                    }),
                    date: false,
                    priority: 20,
                    sortable: true,
                    multiple: 'add',
                    searchable: true,
                    autoSelect: true,
                    filterable: false,
                    syncSelection: true,
                    allowLocalEdits: true,
                    displaySettings: false,
                    displayUserSettings: true,
                }),
            ]
        });

        // Pre-select previously chosen attachments and handle reordering
        mediaUploader.on('open', function() {
            var attachments = mediaUploader.state().get('selection');
            var idsValue = $(inputFieldId).val();
            if (idsValue && idsValue.length > 0) {
                var ids = idsValue.split(',');

                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    attachments.add(attachment ? [attachment] : []);
                });
            }
        });

        // Handle the event when media items are selected or reordered
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var attachmentIds = [];

            // Extract IDs of selected attachments
            attachments.forEach(function(attachment) {
                attachmentIds.push(attachment.id);
            });

            // Store selected IDs in the input field
            $(inputFieldId).val(attachmentIds.join(','));

            // Store selected IDs in local storage
            localStorage.setItem('selected_' + mediaType + '_ids', attachmentIds.join(','));
        });

        mediaUploader.open();
    }

    // Handle click events for each media upload button with hard-coded mediaType
    $('#universal_local_media_upload_audio').click(function(e) {
        e.preventDefault();
        openMediaUploader('audio', '#universal_local_audio_attachment_ids');
    });

    $('#universal_local_media_upload_video').click(function(e) {
        e.preventDefault();
        openMediaUploader('video', '#universal_local_video_attachment_ids');
    });

    $('#universal_local_media_upload_image').click(function(e) {
        e.preventDefault();
        openMediaUploader('image', '#universal_local_image_attachment_ids');
    });
});
