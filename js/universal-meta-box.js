jQuery(document).ready(function($) {
    // Function to open the media uploader and handle selection
    function openMediaUploader(mediaType) {
        var inputFieldId = '#universal_local_media_attachment_ids';

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
                    describe: mediaType == 'image' ? true : false,
                }),
            ]
        });

        // Pre-select previously chosen attachments and handle reordering
        mediaUploader.on('open', function() {
            var attachments = mediaUploader.state().get('selection');
            var idsValue = $(inputFieldId).val();
            if (idsValue.length > 0) {
                var ids = idsValue.split(',');

                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    attachments.add(attachment ? [attachment] : []);
                });

                // Initiate sortable after attachments are added
                setTimeout(function() {
                    handleMediaSorting(mediaType);
                }, 500); // Delay to ensure elements are rendered
            }
        });

        // Handle the event when media items are selected or reordered
        mediaUploader.on('select update', function() {
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

    // Function to handle media item sorting
    function handleMediaSorting(mediaType) {
        var mediaFrame = $('.media-frame-content');
        var sortableContainer = mediaFrame.find('.attachments');

        sortableContainer.sortable({
            items: '.attachment',
            cursor: 'move',
            placeholder: 'sortable-placeholder',
            update: function(event, ui) {
                var sortedIds = [];
                sortableContainer.find('.attachment').each(function() {
                    sortedIds.push($(this).data('id'));
                });

                var inputFieldId = '#universal_local_media_attachment_ids';
                $(inputFieldId).val(sortedIds.join(','));

                // Store sorted IDs in local storage
                localStorage.setItem('selected_' + mediaType + '_ids', sortedIds.join(','));
            }
        });
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
