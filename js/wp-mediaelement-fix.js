(function() {
    var settings = window._wpmejsSettings || {};
    settings.features = settings.features || mejs.MepDefaults.features;
    settings.features.push( 'exampleclass' );

    MediaElementPlayer.prototype.buildexampleclass = function( player ) {
        player.container.addClass( 'universal-mejs-container u-media-16-9' );
    };

    // Function to handle fullscreen changes
    function handleFullscreenChange() {
        if (document.fullscreenElement) {
            $('video').css('max-height', 'none');
        } else {
            $('video').css('max-height', '512px');
        }
    }

    // Attach event listener to fullscreen changes
    $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', handleFullscreenChange);

    // Initial setup to ensure the max-height is set correctly on load
    handleFullscreenChange();

    // Make sure all instances wp-video & wp-playlist in inner-post 512px.
    function wrapMediaElements() {
       $('.wp-video, .wp-playlist').each(function() {
           if (!$(this).closest('#post-media').length) {
               if (!$(this).closest('.post-media').length) {
                    if (!$(this).hasClass('wp-audio-playlist')) {
                        var $wrapper = $('<div class="post-media"></div>');
                        $(this).wrap($wrapper);
                    }
                    $(this).css('width', '100%');
               }
            }
       });
    }

    wrapMediaElements();
})();
