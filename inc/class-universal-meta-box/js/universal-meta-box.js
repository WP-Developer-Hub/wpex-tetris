Object.defineProperty(String.prototype, 'universal_capitalize', {
    value: function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    },
    enumerable: false
});

jQuery(document).ready(function($) {
    var l10n = wp.media.view.l10n;

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
            const value = ids.val();
            switch (type) {
                case 'video':
                    l10n.insertVideoPlaylist = value ? l10n.updateVideoPlaylist : l10n.createNewVideoPlaylist;
                    return value ? 'video-playlist-edit' : 'video-playlist-library';
                case 'audio':
                    l10n.insertPlaylist = value ? l10n.updatePlaylist : l10n.createNewPlaylist;
                    return value ? 'playlist-edit' : 'playlist-library';
                case 'image':
                    l10n.insertGallery = value ? l10n.updateGallery : l10n.createNewGallery;
                    return value ? 'gallery-edit' : 'gallery-library';
                default:
                    return 'library';
            }
        }

        var mediaUploader = wp.media.frames.file_frame = wp.media({
            frame: "post",
            state: getMediaUploaderState(idsValue, mediaType),
            library: {
                type: mediaType
            },
            multiple: true,
            id: 'universal-media-uploader'
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

        mediaUploader.on('ready change content:render', function() {
            var attachments = mediaUploader.state().get('library');
            if (idsValue.val().length > 0 || attachments.length > 0) {
                if(mediaType == 'video'){
                    $('#universal-media-uploader #menu-item-' + mediaType + '-' + cType + '-edit').show();
                } else {
                    $('#universal-media-uploader #menu-item-' + cType + '-edit').show();
                }
            } else {
                if(mediaType == 'video'){
                    $('#universal-media-uploader #menu-item-' + mediaType + '-' + cType + '-edit').hide();
                } else {
                    $('#universal-media-uploader #menu-item-' + cType + '-edit').hide();
                }
            }
        });

        mediaUploader.open();
    }

    function clearAllMedia(mediaType) {
        var confirmMessage = 'Do you want to clear all ' + mediaType + ' attachments?';
        if (confirm(confirmMessage)) {
            $('#universal_local_' + mediaType + '_attachment_ids').val('');
            localStorage.removeItem('selected_' + mediaType + '_ids');
            $('#universal_local_media_clear_all_' + mediaType).fadeOut();
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
        clearAllMedia('video');
    });

    $('#universal_local_media_clear_all_audio').click(function(e) {
        e.preventDefault();
        clearAllMedia('audio');
    });

    $('#universal_local_media_clear_all_image').click(function(e) {
        e.preventDefault();
        clearAllMedia('image');
    });
});
