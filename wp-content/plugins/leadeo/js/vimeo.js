var player=null;
var player_width;
var global_player_type='vimeo';

var iframe, make_player, onPlayerReady, on_play_progress, onPlayerStateChange, set_player_status, stopVideo, playVideo, call_controler;
var reached = false;

(function($) {
	make_player=function() {
		iframe = $('#player1')[0];
		player = $f(iframe);

		// When the player is ready, add listeners for pause, finish, and playProgress
		player.addEvent('ready', function() {
			onPlayerReady('ready');
		});
	};

	onPlayerReady=function(event) {
		set_player_status('ready');

		player.addEvent('pause', function(){onPlayerStateChange(2);});
		player.addEvent('play', function(){onPlayerStateChange(1);});
		player.addEvent('finish', function(){onPlayerStateChange(0);});
		player.addEvent('playProgress', on_play_progress);

		set_player_height('vimeo');
		playVideo();
	};

	on_play_progress=function (data, id) {
		if (data_time_in_seconds==-1) return;
		if (data.seconds >= data_time_in_seconds && !reached) {
			reached = true;
			call_controler();
		}
	};

	restart_interval_loop=function(next_time) {
		reached=false;
		data_time_in_seconds=next_time;
	};

	onPlayerStateChange=function (event) {
		//console.log('onPlayerStateChange = '+event.data);
		if (event==0) set_player_status('ended');
		if (event==1) set_player_status('playing');
		if (event==2) set_player_status('paused');
	};

	set_player_status=function (event) {
		current_player_status=event;
		if (event=='ended') {
			reached = true;
			//stopVideo();
			call_controler('end');
		}
		//console.log('player event = '+event);
	};

	stopVideo=function () {
		player.api('pause');
	};

	playVideo=function() {
		player.api('play');
	};

	call_controler=function (status) {
		if (typeof status=='undefined') status='';
		leadeo_control.event_time_reached(status);
	};

})(jQuery);