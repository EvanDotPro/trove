function TvPlayer(videoJsPlayer) {
    this.videoJsPlayer = videoJsPlayer;
    this.channel;
    this.videoJsPlayer.on('ended', this.onVideoEnded.bind(this));
    this.videoJsPlayer.on('play', this.onVideoStarted.bind(this));
    //this.videJsPlayer.poster('/tv.png');
}

TvPlayer.prototype = {
    constructor: TvPlayer,
    setChannel: function(channel) {
        this.channel = channel;
    },
    playNextVideo: function() {
        $.getJSON( "/c/" + this.channel + "/next", function(data) {
            //$(this.ytPlayer.getIframe()).css('visibility','hidden');
            console.log('New video: ' + data.sourceId);
            History.replaceState(null, null, '/c/' + this.channel + '/' + data.sourceId);
            this.playSpecificVideo(data.sourceId);
            this.videoJsPlayer.play();
            //this.ytPlayer.loadVideoById(data, 0, "large");
        }.bind(this));
    },
    playSpecificVideo: function(videoId) {
        this.videoJsPlayer.src({
            type: "video/youtube",
            src: "https://www.youtube.com/watch?v=" + videoId,
            youtube: {
                iv_load_policy: 3,
                playsinline : 1
            }
        });
        this.videoJsPlayer.play();

    },
    play: function() {
        this.videoJsPlayer.play();
    },
    onVideoStarted: function() {
        console.log("Video playing...");
        if (this.videoJsPlayer.currentSrc().indexOf('8tPnX7OPo0Q') !== -1) {
            this.playNextVideo();
        }
    },

    onVideoEnded: function() {
        this.playNextVideo();
    }
};

var player;

//$(document).ready(function() {
//    videojs("video-player").ready(function(){
//        player = new TvPlayer(this);
//        player.setChannel('explore');
//    });
//    $('#skip').on('click', function() {
//        player.playNextVideo();
//        console.log('Skipping');
//    });
//
//    setTimeout(function() {
//        if (AUTOPLAY) {
//            $('#autoplay').text('TRUE');
//        } else {
//            $('#autoplay').text('FALSE');
//        }
//    }, 100);
//
//
//});


var _playerInitCallback;

//function initYtPlayer(callback) {
//    var tag = document.createElement('script');
//    tag.src = "https://www.youtube.com/iframe_api";
//    var firstScriptTag = document.getElementsByTagName('script')[0];
//    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//    console.log("YT PLAYER INITIALIZED");
//    _playerInitCallback = callback;
//}

//function onYouTubeIframeAPIReady() {
//    console.log("YT API READY");
//    ytPlayer = new YT.Player('ytplayer', {
//      width: '100%',
//      height: '600',
//      videoId: '9mdPbeK_qE4',
//      playerVars: { 'autoplay': 0, 'controls': 0, 'showinfo': 0, 'iv_load_policy': 3},
//      events: {
//        'onReady': onPlayerReady,
//        'onStateChange': onPlayerStateChange
//      }
//    });
//    player = new TvPlayer(ytPlayer);
//    _playerInitCallback(player);
//}


function onPlayerReady(event) {
//event.target.playVideo();
    //player.playNextVideo();
    //ytPlayer.loadVideoById("bHQqvYy5KYo", 5, "large");
}

//function onPlayerStateChange(event) {
//    if (event.data == YT.PlayerState.ENDED) {
//        player.playNextVideo();
//    }
//    if (event.data == YT.PlayerState.PLAYING) {
//        $(this.ytPlayer.getIframe()).css('visibility','visible');
//    }
//    //if (event.data == YT.PlayerState.PLAYING) {
//    //    $('#ytplayer').css('visibility','visible');
//    //}
//}
//  function stopVideo() {
//    player.stopVideo();
//  }







// Detect autoplay
// ---------------

// This script detects whether the current browser supports the
// autoplay feature for HTML5 Audio elements, and it sets the
// `AUTOPLAY` variable accordingly.

// Used in the Meteor app [PicDinner](http://picdinner.com)

var AUTOPLAY = false;

(function() {

    // Audio file data URIs from comments in
    // [this gist](https://gist.github.com/westonruter/253174)
    // via [mudcube](https://github.com/mudcube)
    var mp3 = 'data:audio/mpeg;base64,/+MYxAAAAANIAUAAAASEEB/jwOFM/0MM/90b/+RhST//w4NFwOjf///PZu////9lns5GFDv//l9GlUIEEIAAAgIg8Ir/JGq3/+MYxDsLIj5QMYcoAP0dv9HIjUcH//yYSg+CIbkGP//8w0bLVjUP///3Z0x5QCAv/yLjwtGKTEFNRTMuOTeqqqqqqqqqqqqq/+MYxEkNmdJkUYc4AKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq';

    var ogg = 'data:audio/ogg;base64,T2dnUwACAAAAAAAAAADqnjMlAAAAAOyyzPIBHgF2b3JiaXMAAAAAAUAfAABAHwAAQB8AAEAfAACZAU9nZ1MAAAAAAAAAAAAA6p4zJQEAAAANJGeqCj3//////////5ADdm9yYmlzLQAAAFhpcGguT3JnIGxpYlZvcmJpcyBJIDIwMTAxMTAxIChTY2hhdWZlbnVnZ2V0KQAAAAABBXZvcmJpcw9CQ1YBAAABAAxSFCElGVNKYwiVUlIpBR1jUFtHHWPUOUYhZBBTiEkZpXtPKpVYSsgRUlgpRR1TTFNJlVKWKUUdYxRTSCFT1jFloXMUS4ZJCSVsTa50FkvomWOWMUYdY85aSp1j1jFFHWNSUkmhcxg6ZiVkFDpGxehifDA6laJCKL7H3lLpLYWKW4q91xpT6y2EGEtpwQhhc+211dxKasUYY4wxxsXiUyiC0JBVAAABAABABAFCQ1YBAAoAAMJQDEVRgNCQVQBABgCAABRFcRTHcRxHkiTLAkJDVgEAQAAAAgAAKI7hKJIjSZJkWZZlWZameZaouaov+64u667t6roOhIasBACAAAAYRqF1TCqDEEPKQ4QUY9AzoxBDDEzGHGNONKQMMogzxZAyiFssLqgQBKEhKwKAKAAAwBjEGGIMOeekZFIi55iUTkoDnaPUUcoolRRLjBmlEluJMYLOUeooZZRCjKXFjFKJscRUAABAgAMAQICFUGjIigAgCgCAMAYphZRCjCnmFHOIMeUcgwwxxiBkzinoGJNOSuWck85JiRhjzjEHlXNOSuekctBJyaQTAAAQ4AAAEGAhFBqyIgCIEwAwSJKmWZomipamiaJniqrqiaKqWp5nmp5pqqpnmqpqqqrrmqrqypbnmaZnmqrqmaaqiqbquqaquq6nqrZsuqoum65q267s+rZru77uqapsm6or66bqyrrqyrbuurbtS56nqqKquq5nqq6ruq5uq65r25pqyq6purJtuq4tu7Js664s67pmqq5suqotm64s667s2rYqy7ovuq5uq7Ks+6os+75s67ru2rrwi65r66os674qy74x27bwy7ouHJMnqqqnqq7rmarrqq5r26rr2rqmmq5suq4tm6or26os67Yry7aumaosm64r26bryrIqy77vyrJui67r66Ys67oqy8Lu6roxzLat+6Lr6roqy7qvyrKuu7ru+7JuC7umqrpuyrKvm7Ks+7auC8us27oxuq7vq7It/KosC7+u+8Iy6z5jdF1fV21ZGFbZ9n3d95Vj1nVhWW1b+V1bZ7y+bgy7bvzKrQvLstq2scy6rSyvrxvDLux8W/iVmqratum6um7Ksq/Lui60dd1XRtf1fdW2fV+VZd+3hV9pG8OwjK6r+6os68Jry8ov67qw7MIvLKttK7+r68ow27qw3L6wLL/uC8uq277v6rrStXVluX2fsSu38QsAABhwAAAIMKEMFBqyIgCIEwBAEHIOKQahYgpCCKGkEEIqFWNSMuakZM5JKaWUFEpJrWJMSuaclMwxKaGUlkopqYRSWiqlxBRKaS2l1mJKqcVQSmulpNZKSa2llGJMrcUYMSYlc05K5pyUklJrJZXWMucoZQ5K6iCklEoqraTUYuacpA46Kx2E1EoqMZWUYgupxFZKaq2kFGMrMdXUWo4hpRhLSrGVlFptMdXWWqs1YkxK5pyUzDkqJaXWSiqtZc5J6iC01DkoqaTUYiopxco5SR2ElDLIqJSUWiupxBJSia20FGMpqcXUYq4pxRZDSS2WlFosqcTWYoy1tVRTJ6XFklKMJZUYW6y5ttZqDKXEVkqLsaSUW2sx1xZjjqGkFksrsZWUWmy15dhayzW1VGNKrdYWY40x5ZRrrT2n1mJNMdXaWqy51ZZbzLXnTkprpZQWS0oxttZijTHmHEppraQUWykpxtZara3FXEMpsZXSWiypxNhirLXFVmNqrcYWW62ltVprrb3GVlsurdXcYqw9tZRrrLXmWFNtBQAADDgAAASYUAYKDVkJAEQBAADGMMYYhEYpx5yT0ijlnHNSKucghJBS5hyEEFLKnINQSkuZcxBKSSmUklJqrYVSUmqttQIAAAocAAACbNCUWByg0JCVAEAqAIDBcTRNFFXVdX1fsSxRVFXXlW3jVyxNFFVVdm1b+DVRVFXXtW3bFn5NFFVVdmXZtoWiqrqybduybgvDqKqua9uybeuorqvbuq3bui9UXVmWbVu3dR3XtnXd9nVd+Bmzbeu2buu+8CMMR9/4IeTj+3RCCAAAT3AAACqwYXWEk6KxwEJDVgIAGQAAgDFKGYUYM0gxphhjTDHGmAAAgAEHAIAAE8pAoSErAoAoAADAOeecc84555xzzjnnnHPOOeecc44xxhhjjDHGGGOMMcYYY4wxxhhjjDHGGGOMMcYYY0wAwE6EA8BOhIVQaMhKACAcAABACCEpKaWUUkoRU85BSSmllFKqFIOMSkoppZRSpBR1lFJKKaWUIqWgpJJSSimllElJKaWUUkoppYw6SimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaVUSimllFJKKaWUUkoppRQAYPLgAACVYOMMK0lnhaPBhYasBAByAwAAhRiDEEJpraRUUkolVc5BKCWUlEpKKZWUUqqYgxBKKqmlklJKKbXSQSihlFBKKSWUUkooJYQQSgmhlFRCK6mEUkoHoYQSQimhhFRKKSWUzkEoIYUOQkmllNRCSB10VFIpIZVSSiklpZQ6CKGUklJLLZVSWkqpdBJSKamV1FJqqbWSUgmhpFZKSSWl0lpJJbUSSkklpZRSSymFVFJJJYSSUioltZZaSqm11lJIqZWUUkqppdRSSiWlkEpKqZSSUmollZRSaiGVlEpJKaTUSimlpFRCSamlUlpKLbWUSkmptFRSSaWUlEpJKaVSSksppRJKSqmllFpJKYWSUkoplZJSSyW1VEoKJaWUUkmptJRSSymVklIBAEAHDgAAAUZUWoidZlx5BI4oZJiAAgAAQABAgAkgMEBQMApBgDACAQAAAADAAAAfAABHARAR0ZzBAUKCwgJDg8MDAAAAAAAAAAAAAACAT2dnUwAEAAAAAAAAAADqnjMlAgAAADzQPmcBAQA=';

    try {
        var audio = new Audio();
        var src = audio.canPlayType('audio/ogg') ? ogg : mp3;
        audio.autoplay = true;
        audio.volume = 0;

        // this will only be triggered if autoplay works
        $(audio).on('play', function() {
            AUTOPLAY = true;
        });

        audio.src = src;
    } catch(e) {
        console.log('[AUTOPLAY-ERROR]', e);
    }
})();
