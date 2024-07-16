Object.defineProperty(String.prototype, 'universal_capitalize', {
    value: function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    },
    enumerable: false
});

jQuery(document).ready(function($) {
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

    function openMediaUploader(mediaType, cType, inputFieldId) {
        var idsValue = $(inputFieldId);

        function getMediaUploaderState(ids, type) {
            switch (type) {
                case 'video':
                    wp.media.view.l10n.createNewVideoPlaylist = "Arrange Videos File";
                    wp.media.view.l10n.insertVideoPlaylist = "Update Videos Playlist";
                    return ids.val() ? 'video-playlist-edit' : 'video-playlist-library';
                case 'audio':
                    wp.media.view.l10n.createNewPlaylist = "Arrange Audios File";
                    wp.media.view.l10n.insertPlaylist = "Update Audios Playlist";
                    return ids.val() ? 'playlist-edit' : 'playlist-library';
                case 'image':
                    wp.media.view.l10n.createNewGallery = "Arrange Images File";
                    wp.media.view.l10n.insertGallery = "Update Image Gallery";
                    return ids.val() ? 'gallery-edit' : 'gallery-library';
                default:
                    return 'library';
            }
        }

        var mediaUploader = wp.media.frames.file_frame = wp.media({
            button: {
                text: 'Add ' + mediaType.universal_capitalize() + ' To ' + cType.universal_capitalize()
            },
            frame: "post",
            state: getMediaUploaderState(idsValue, mediaType),
            library: {
                type: mediaType
            },
            multiple: true
        });

        mediaUploader.on('open', function() {
            var attachments = mediaUploader.state().get('library');
            if (idsValue.val() && idsValue.val().length > 0) {
                var ids = idsValue.val().split(',');
                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    attachments.add(attachment ? [attachment] : []);
                });
            }
        });

        mediaUploader.on('update', function() {
            var attachments = mediaUploader.state().get('library').toJSON();
            var attachmentIds = [];
            attachments.forEach(function(attachment) {
                attachmentIds.push(attachment.id);
            });
            idsValue.val(attachmentIds.join(','));
            localStorage.setItem('selected_' + mediaType + '_ids', attachmentIds.join(','));
            $('#universal_local_media_clear_all_' + mediaType).fadeIn();
        });

        mediaUploader.open();
    }

    function clearAllMedia(button, mediaType) {
        var confirmMessage = 'Do you want to clear all ' + mediaType + ' attachments?';
        if (confirm(confirmMessage)) {
            $('#universal_local_' + mediaType + '_attachment_ids').val('');
            localStorage.removeItem('selected_' + mediaType + '_ids');
            $(button).fadeOut();
        }
    }

    $('#universal_local_media_upload_video').click(function(e) {
        e.preventDefault();
        openMediaUploader('video', 'playlist', '#universal_local_video_attachment_ids');
    });

    $('#universal_local_media_upload_audio').click(function(e) {
        e.preventDefault();
        openMediaUploader('audio', 'playlist', '#universal_local_audio_attachment_ids');
    });

    $('#universal_local_media_upload_image').click(function(e) {
        e.preventDefault();
        openMediaUploader('image', 'gallery', '#universal_local_image_attachment_ids');
    });

    $('#universal_local_media_clear_all_video').click(function(e) {
        e.preventDefault();
        clearAllMedia(this, 'video');
    });

    $('#universal_local_media_clear_all_audio').click(function(e) {
        e.preventDefault();
        clearAllMedia(this, 'audio');
    });

    $('#universal_local_media_clear_all_image').click(function(e) {
        e.preventDefault();
        clearAllMedia(this, 'image');
    });
});
