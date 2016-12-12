var YouTubeLoader = (function () {

    var jsLoaded = false;

    var apiReady = false;

    function loadYouTubeJs() {
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    return {

        init: function () {
            if (jsLoaded) return;
            loadYouTubeJs();
            jsLoaded = true;

        },

        isReady: function() {
            return apiReady;
        },

        __setReady: function() {
            apiReady = true;
        }

    };

})();

function onYouTubeIframeAPIReady() {
    YouTubeAPIFactory.__setReady();
};

var YouTubePlayer = (function () {

    var player;

    function createPlayer(videoId) {
        return new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: videoId,
          //events: {
          //  'onReady': onPlayerReady,
          //  'onStateChange': onPlayerStateChange
          //}
        });
    }

    return {

        loadVideo: function (videoId) {
            if (!player) {
                player = createPlayer(videoId);
                return;
            }
            player.loadVideoById(videoId);
        },

    };

})();
