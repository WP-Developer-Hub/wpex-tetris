jQuery(document).ready(function($) {
    // Function to open the media uploader and handle selection
    function openMediaUploader(mediaType) {
        var inputFieldId = '#universal_local_media_attachment_ids';


        var uploader = wp.media({
            title: 'Upload ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1),
            button: {
                text: 'Use This ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1)
            },
            library: {
                type: mediaType,
            },
            multiple: true
        });

        // Pre-select previously chosen attachments
        uploader.on('open', function() {
            var attachments = uploader.state().get('selection');
            var idsValue = $(inputFieldId).val();
            if (idsValue.length > 0) {
                var ids = idsValue.split(',');

                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    attachments.add(attachment ? [attachment] : []);
                });
            }
        });

        uploader.on('select', function() {
            var attachments = uploader.state().get('selection').toJSON();
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

        uploader.open();
    }

    // Handle click events for each media upload button with hard-coded mediaType
    $('#universal_local_media_upload_audio').click(function(e) {
        e.preventDefault();
        openMediaUploader('audio');
    });

    $('#universal_local_media_upload_video').click(function(e) {
        e.preventDefault();
        openMediaUploader('video');
    });

    $('#universal_local_media_upload_image').click(function(e) {
        e.preventDefault();
        openMediaUploader('image');
    });
});
