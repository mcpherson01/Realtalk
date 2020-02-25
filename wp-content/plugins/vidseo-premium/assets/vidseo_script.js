jQuery(document).ready(function () {

    jQuery('.vidseo_collapse').on('click', '.vidseo_btn', function() { 
      jQuery(this).next('.vidseo_collapse_content').slideToggle();
    });
});

// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

//elemen = document.querySelectorAll('.vidseo_video').length;
/* var vidseo = document.getElementById("vidseo_data");

var player;
function onYouTubePlayerAPIReady() {
  player = new YT.Player('ytplayer', {
    height: vidseo.dataset .height,
    width: vidseo.dataset.width,
    videoId: vidseo.dataset.yt,
    playerVars: {
        //controls: 0,
        loop: vidseo.dataset.loop,
        playlist: vidseo.dataset.yt,
        rel: vidseo.dataset.rel,
        modestbranding: 1
    }
  });
} */