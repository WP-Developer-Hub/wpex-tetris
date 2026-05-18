jQuery(document).ready(function($) {
    var settings = window._wpmejsSettings || {};
    settings.features = settings.features || mejs.MepDefaults.features;
    settings.features.push('exampleclass');

    MediaElementPlayer.prototype.buildexampleclass = function(player) {
        player.container.addClass('universal-mejs-container u-media-16-9');
    };
});
