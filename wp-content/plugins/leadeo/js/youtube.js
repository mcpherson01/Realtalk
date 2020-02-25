var player=null;
var player_width;
var global_player_type='youtube';

function make_player() {
	var tag = document.createElement('script');

	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];

	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		width: '640',
		height: '390',
		videoId: data_youtube_id,
		playerVars: {'controls': 0, 'wmode': 'opaque'},
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
}


var reached = false;
var interval;

function interval_loop () {
	//console.log('current: '+player.getCurrentTime()+', limit='+data_time_in_seconds+', reached='+reached);
	if (data_time_in_seconds==-1) return;
	if (player!=null && player.getCurrentTime() >= data_time_in_seconds && !reached) {
		clearInterval(interval);
		reached = true;
		call_controler();
	}
}

function restart_interval_loop(next_time) {
	reached=false;
	data_time_in_seconds=next_time;
	interval = setInterval(interval_loop, 300);
}

function onPlayerReady(event) {
	set_player_status('ready');

	set_player_height('youtube');

	event.target.playVideo();
	interval = setInterval(interval_loop, 300);
}

function onPlayerStateChange(event) {
	//console.log('onPlayerStateChange = '+event.data);
	if (event.data==0) set_player_status('ended');
	if (event.data==1) set_player_status('playing');
	if (event.data==2) set_player_status('paused');
}

function set_player_status(event) {
	current_player_status=event;
	if (event=='ended') {
		clearInterval(interval);
		reached = true;
		//stopVideo();
		call_controler('end');
	}
	//console.log('player event = '+event);
}

function stopVideo() {
	player.pauseVideo();
}

function playVideo() {
	player.playVideo();
}

function call_controler(status) {
	if (typeof status=='undefined') status='';
	leadeo_control.event_time_reached(status);
}
