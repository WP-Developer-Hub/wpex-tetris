jQuery(document).ready(function($) {
    // Hide clear all buttons initially if there are no media items selected
    function initializeClearButtons() {
        if ($('#universal_local_audio_attachment_ids').val()) {
            $('#universal_local_media_clear_all_audio').fadeIn();
        }
        if ($('#universal_local_video_attachment_ids').val()) {
            $('#universal_local_media_clear_all_video').fadeIn();
        }
        if ($('#universal_local_image_attachment_ids').val()) {
            $('#universal_local_media_clear_all_image').fadeIn();
        }
    }

    initializeClearButtons();

    // Function to open the media uploader and handle selection
    function openMediaUploader(mediaType, inputFieldId) {
        var mediaUploader = wp.media({
            button: {
                text: 'Use This ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1)
            },
            states: [
                new wp.media.controller.Library({
                    title: 'Upload ' + mediaType.charAt(0).toUpperCase() + mediaType.slice(1),
                    library: wp.media.query({ type: mediaType }),
                    date: true,
                    editable: true,
                    sortable: true,
                    multiple: 'add',
                    searchable: true,
                    autoSelect: true,
                    syncSelection: true,
                    filterable: false,
                    allowLocalEdits: true,
                    displaySettings: false,
                    contentUserSetting: true,
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
            
            // Show the clear button
            $('#universal_local_media_clear_all_' + mediaType).fadeIn();
        });

        // Handle the event when media items are selected or reordered
        mediaUploader.on('display', function() {
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
            
            // Show the clear button
            $('#universal_local_media_clear_all_' + mediaType).fadeIn();
        });

        mediaUploader.open();
    }

    function clearAllMedia(mediaType) {
        $('#universal_local_' + mediaType + '_attachment_ids').val('');
        localStorage.removeItem('selected_' + mediaType + '_ids');
    }

    // Handle click events for each media upload button
    $('#universal_local_media_upload_video').click(function(e) {
        e.preventDefault();
        openMediaUploader('video', '#universal_local_video_attachment_ids');
    });

    $('#universal_local_media_upload_audio').click(function(e) {
        e.preventDefault();
        openMediaUploader('audio', '#universal_local_audio_attachment_ids');
    });

    $('#universal_local_media_upload_image').click(function(e) {
        e.preventDefault();
        openMediaUploader('image', '#universal_local_image_attachment_ids');
    });

    // Handle click events for each clear button
    $('#universal_local_media_clear_all_video').click(function(e) {
        e.preventDefault();
        clearAllMedia('video');
        $(this).fadeOut();
    });

    $('#universal_local_media_clear_all_audio').click(function(e) {
        e.preventDefault();
        clearAllMedia('audio');
        $(this).fadeOut();
    });

    $('#universal_local_media_clear_all_image').click(function(e) {
        e.preventDefault();
        clearAllMedia('image');
        $(this).fadeOut();
    });
});
