var change_size_of_iframe, resize_iframe, bind_submit, bind_close, send_callback, bind_fields_change;
var log_resize=0;
var form_submitted=0;
var leadeo_send_data;
var validated=0;
var parent_url_location, parent_title;

var current_player_status='init';
var current_form_status='init';
var global_temporary_showed=0;

var show_form, hide_form, set_form_position_for_start, set_all_form_position_for_start, check_if_forms_are_visible, check_if_form_needs_reposition, on_iframe_resize, get_form_height, get_real_form_height, get_message_textarea_height, set_message_textarea_height, set_leadeo_lite_label;
var active_form=0;

var global_iframe_height=0;
var global_iframe_width=0;
var global_player_height=0;
var global_current_form_height=0;
var global_iframe_height_when_forms_repositioned=0;

function validateEmail(email) {
	var re = /\S+@\S+\.\S+/;
	return re.test(email);
}
function miniwin(url,w,h)
{
	window.open(url,"","height="+h+",width="+w+",status=no,toolbar=no,menubar=no,location=no",true);
}
function fb_share(url_to_share) {
	if (typeof url_to_share=='undefined') url_to_share=parent_url_location;
	var encoded_url=encodeURIComponent(url_to_share);
	var url="http://www.facebook.com/sharer.php?u="+encoded_url+"&t=Share";
	miniwin(url,600,400);
}
function tw_share(url_to_share, text, hashtags) {
	var url="https://twitter.com/intent/tweet?";
	var encoded_url;
	if (typeof url_to_share=='undefined') url_to_share=parent_url_location;
	if (url_to_share!="") {
		encoded_url=encodeURIComponent(url_to_share);
		url+="url="+encoded_url+"&";
	}
	if (typeof text == 'undefined') text=parent_title;
	url+='text='+encodeURIComponent(text)+'&';
	if (typeof hashtags != 'undefined') url+='hashtags=='+encodeURIComponent(hashtags);
	miniwin(url,600,255);
}

function id_share(url_to_share, title) {
	if (typeof url_to_share=='undefined') url_to_share=parent_url_location;
	var encoded_url=encodeURIComponent(url_to_share);
	var url="http://www.linkedin.com/shareArticle?mini=true&url="+encoded_url;
	if (typeof title == 'undefined') title=parent_title;
	url+='&title='+encodeURIComponent(title);
	miniwin(url,600,500);
}

(function($) {

	$(document).ready(function(){
		//if (log_resize) console.log('--- ready ---');
		if (typeof make_player!='undefined') make_player();

		var iframe=$('#leadeo_iframe_'+data_id, window.parent.document);
		if (iframe.length) {
			global_iframe_height = iframe.height();
			global_iframe_width = iframe.width();
		} else {
			global_iframe_height = $(window).height();
			global_iframe_width = $(window).width();
		}

		bind_close();

		set_all_form_position_for_start();

		parent_url_location = window.parent.location.href;
		parent_title = window.parent.document.title;

		$('.fa-facebook-square').on('click', function() {
			fb_share();
			leadeo_control.continue_playing();
		});
		$('.fa-twitter-square').on('click', function() {
			var type=timeline[active_form].type;
			if (type==4) {
				var text=$('.content', '#base_'+active_form).text();
				tw_share('', text);
			} else {
				tw_share();
			}
			leadeo_control.continue_playing();
		});
		$('.fa-linkedin-square').on('click', function() {
			id_share();
			leadeo_control.continue_playing();
		});
	});


	$(window).resize(function(){
		on_iframe_resize();
	});

	// ---------------- function for validation and submit -------------------

	bind_fields_change=function () {
		$(':text', '#base_'+active_form).on('change keyup', function(){fields_changed();});
		$('#base_'+active_form+'_leadeo_textarea').on('change keyup', function(){fields_changed();});
	}

	function fields_changed() {
		if (validated==0) return;
		check_validation();
	}

	function set_field_border_error(obj) {
		$(obj).css('border', '2px solid red');
	}
	function set_field_placeholder_error(obj) {
		var ph=$(obj).attr('placeholder');
		ph=ph.replace(' (please fill)', '');
		ph=ph+' (please fill)';
		$(obj).attr('placeholder', ph);
	}

	function clear_field_border_error(obj) {
		$(obj).css('border', '0');
	}
	function clear_field_placeholder_error(obj) {
		var ph=$(obj).attr('placeholder');
		ph=ph.replace(' (please fill)', '');
		$(obj).attr('placeholder', ph);
	}

	function check_validation() {
		validated=1;
		var ok=1;
		var val;
		$(':text', '#base_'+active_form).each(function(){
			val=$(this).val();
			if (val=='') {
				ok=0;
				set_field_border_error(this);
				set_field_placeholder_error(this);
			} else {
				clear_field_border_error(this);
				clear_field_placeholder_error(this);
			}
		});
		var obj=$('#base_'+active_form+'_leadeo_textarea');
		var obj2=$('#base_'+active_form+'_leadeo_message');
		if ( obj.length ) {
			val = obj.val();
			if (val=='') {
				ok=0;
				set_field_border_error(obj2);
				set_field_placeholder_error(obj);
			} else {
				clear_field_border_error(obj2);
				clear_field_placeholder_error(obj);
			}
		}
		var email_el=$("input[name='email']", '#base_'+active_form);
		if (email_el.length) {
			var email = email_el.val();
			if (!validateEmail(email)) {
				ok=0;
				set_field_border_error(email_el);
			} else {
				clear_field_border_error(email_el);
			}
		}
		return ok;
	}

	bind_submit=function() {
		$( '#base_'+active_form+'_data_form' ).submit(function( event ) {
			event.preventDefault();
			leadeo_send_data();
		});
	}
	leadeo_send_data = function() {
		if (form_submitted==1) return;
		var no_validation=$('#base_'+active_form).attr('data-no-validation');
		if (typeof no_validation=='undefined' || (typeof no_validation=='string' && no_validation=='')) no_validation=0;
		else no_validation=parseInt(no_validation, 10);
		//alert(no_validation);
		if (no_validation==0) if (check_validation()==0) return;
		form_submitted=1;
		var postForm = $('#base_'+active_form+'_data_form').serialize();
		var form_id=$('#base_'+active_form).attr('data-real-base-number');
		//alert(postForm);
		leadeo_send_ajax('leadeo_submit', postForm+'&is_preview='+is_preview+'&form_id='+form_id, send_callback, 'text');
	}
	send_callback=function(response, dataType, status) {
		//if (status == 0) return;
		//console.log (response); return;
		leadeo_control.continue_playing();
	}
	bind_close=function() {
		$(".close_id").click(function (event) {
			global_temporary_showed=0;
			leadeo_control.continue_playing();
		});
	}

})(jQuery);

// ---------------- control object (decide when to show forms) -------------------

leadeo_control_prot = function() {
	this.reached_intervals=0;
};

leadeo_control_prot.prototype = {
	event_time_reached: function (status) {
		if (typeof status=='undefined') status='';
		if (status=='end') {
			var len=timeline.length;
			if (this.reached_intervals>=len) {
				//console.log('This is the end my friend.');
				return;
			}
		}
		if (global_temporary_showed==1) {
			global_temporary_showed=0;
			this.continue_playing(true);
			return;
		}
		active_form=this.reached_intervals;
		this.reached_intervals++;

		data_animation=timeline[active_form].animation;

		var should_stop=true;
		if (timeline[active_form].type==3 || timeline[active_form].type==4) should_stop=false;
		if (status=='end') should_stop=false;
		//should_stop=true;
		if (should_stop) stopVideo();
		else {
			global_temporary_showed=1;
			var next_time=timeline[active_form].time+timeline[active_form].seconds_to_stay_visible;
			restart_interval_loop(next_time);
		}

		validated=0;
		form_submitted=0;
		show_form(data_animation);
		var no_submit_binding=$('#base_'+active_form).attr('data-no-submit-binding');
		if (typeof no_submit_binding=='undefined' || (typeof no_submit_binding=='string' && no_submit_binding=='')) no_submit_binding=0;
		else no_submit_binding=parseInt(no_submit_binding, 10);
		if (no_submit_binding==0) bind_submit();

		var no_validation=$('#base_'+active_form).attr('data-no-validation');
		if (typeof no_validation=='undefined' || (typeof no_validation=='string' && no_validation=='')) no_validation=0;
		else no_validation=parseInt(no_validation, 10);
		if (no_validation==0) bind_fields_change();
	},
	continue_playing: function(skip_play) {
		if (typeof skip_play=='undefined') skip_play=false;
		hide_form();
		if (skip_play==false) playVideo();

		if (this.reached_intervals<timeline.length) {
			var next_time=timeline[this.reached_intervals].time;
			restart_interval_loop(next_time);
		}
	},
	iframe_should_resize: function(caller, height, just_query, force) {
		if (typeof just_query=='undefined') just_query=false;
		if (typeof force=='undefined') force=false;
		//height=parseInt(height, 10); global_player_height=parseInt(global_player_height, 10);
		if (log_resize) console.log('caller = '+caller+', height = '+height+', global_player_height = '+global_player_height+', just_query = '+just_query);
		if (!force) {
			if (global_player_height != 0 && global_player_height > height) return false;
		}
		if (data_auto_height==0) {
			if (data_height_unit!='px') return false;
			if (height<data_height_int) return false;
		}

		if (just_query) return true;
		change_size_of_iframe(height);
	}
};

var leadeo_control = new leadeo_control_prot();