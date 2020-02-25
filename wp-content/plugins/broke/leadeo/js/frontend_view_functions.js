/*
 Running when player become ready.
 */
function set_player_height(player_type) {
	if (typeof player_type=='undefined') player_type=global_player_type;

	player_width=document.getElementById('player').clientWidth;
	var ratio=1.641;
	if (player_type=='vimeo') ratio=1.779;

	global_player_height=Math.round(player_width/ratio);

	document.getElementById('player').style.height=global_player_height+'px';

	leadeo_control.iframe_should_resize('set_player_height', global_player_height);
}

(function($) {


	on_iframe_resize=function() {
		if (data_auto_height==0) return;
		if (log_resize) console.log('on_iframe_resize()');

		var iframe=$('#leadeo_iframe_'+data_id, window.parent.document);

		if (iframe.length==0) {
			if (log_resize) console.log('skipping, length=0');
			return;
		}
		var iframe_height=iframe.height();
		var iframe_width=iframe.width();

		if (global_iframe_width==iframe_width) {
			if (log_resize) console.log('skipping, global_iframe_width==iframe_width');
			iframe.attr('data-resized', '0');
			return;
		}

		global_iframe_width=iframe_width;

		set_player_height();
		get_form_height();

		var desired_height;
		if (check_if_forms_are_visible()) {
			if (global_current_form_height>global_player_height) desired_height=global_current_form_height;
			else desired_height=global_player_height;
		}
		else desired_height=global_player_height;

		if (leadeo_control.iframe_should_resize('on_iframe_resize', desired_height, true)==false) {
			if (log_resize) console.log('skipping, controler denied');
			iframe.attr('data-resized', '0');
			return;
		}

		check_if_form_needs_reposition(desired_height);

		var attr=iframe.attr('data-resized');
		if (attr != "0") {
			if (log_resize) console.log('skipping, data-resized=1');
			iframe.attr('data-resized', '0');
			return;
		}
		if (log_resize) console.log('data-resized = 1');
		leadeo_control.iframe_should_resize('on_iframe_resize', desired_height, false, true);
	};

	change_size_of_iframe=function(height) {
		if (global_iframe_height==height) return false;
		if (log_resize) console.log('change_size_of_iframe('+height+')');
		var iframe=$('#leadeo_iframe_'+data_id, window.parent.document);
		iframe.css('height', height+'px');
		global_iframe_height=height;
		return true;
	};

	check_if_forms_are_visible = function() {
		var visible=false;
		$('.base').each(function() {
			if ($(this).is(":visible")) {visible=true; return false;}
		});
		return visible;
	};


	get_form_height = function() {
		var type=timeline[active_form].type;
		if (type<3) global_current_form_height=$('#base_'+active_form+'_my_form').height();
		else global_current_form_height=$('.dialog-container', '#base_'+active_form).height();
		if (log_resize) console.log('form_height = '+global_current_form_height);
		return global_current_form_height;
	};
	get_real_form_height = function() {
		var height=$('.my_section', '#base_'+active_form).height();
		if (log_resize) console.log('real_form_height = '+height);
		return height;
	};
	get_message_textarea_height = function() {
		var height=$("textarea[name='message']", '#base_'+active_form).height();
		if (log_resize) console.log('message_textarea_height = '+height);
		return height;
	};
	set_message_textarea_height = function(height) {
		if (log_resize) console.log('set_message_textarea_height('+height+')');
		if (data_style==1) {
			if (height<30) height=30;
		}
		if (data_style==2) {
			if (height<60) height=60;
		}
		if (data_style==1) $("textarea[name='message']", '#base_'+active_form).css('height', height+'px');
		if (data_style==2) {
			$("textarea[name='message']", '#base_' + active_form).each(function () {
				this.style.setProperty('height', height + 'px', 'important');
			});
		}

		if (data_style==1) $('.input.message-part', '#base_'+active_form).css('height', (height+12)+'px');
		if (data_style==2) $('.textarea_h', '#base_'+active_form).css('height', (height-2)+'px');
	};
	set_leadeo_lite_label = function() {
		var lite_label_top_position=2;
		var made_with_leadeo_top=0;
		if (data_style==2 && type==1) lite_label_top_position=1;
		if (lite_label_top_position==1) made_with_leadeo_top=10;
		if (lite_label_top_position==2) {
			made_with_leadeo_top=$(window).height()-25;
		}
		$('.made_with_leadeo_id', '#base_'+active_form).css('top',made_with_leadeo_top+'px');
	}

	/*
		this function will be called on resize_iframe() event
	 */
	check_if_form_needs_reposition=function(new_height) {
		if (typeof new_height=='undefined') new_height=global_iframe_height;
		if (global_iframe_height_when_forms_repositioned!=new_height) {
			if (current_form_status=='ready' || current_form_status=='init' || current_form_status=='showed' || current_form_status=='hidden') set_all_form_position_for_start(new_height);
		}
	};

	set_form_position_for_start = function(animation, base, new_height) {
		if (typeof animation=='undefined') animation=data_animation;
		if (typeof base=='undefined') base=active_form;
		if (typeof new_height=='undefined') new_height=global_iframe_height;

		var type=timeline[base].type;

		var arr;
		var modified = 0;

		if (animation=='fadein_top') {
			arr = {'top': '-'+new_height+'px'};
			modified = 1;
		}
		if (animation=='fadein_left') {
			arr = {'left': '-100%'};
			modified = 1;
		}
		if (animation=='fadein_right') {
			arr = {'left': '110%'};
			modified = 1;
		}
		if (animation=='fadein_bottom') {
			arr = {'top': new_height + 'px'};
			modified = 1;
		}
		if (modified) {
			/*if (type<3) {
				$('#base_' + base + '_my_form').css(arr);
				$('#base_' + base + '_my_overlay').css(arr);
			} else {*/
				$('#base_' + base).css(arr);
			//}
		}
		current_form_status='ready';
	};

	/*
	 this function will be called on document.ready() event, and eventually on iframe_resize() event
	 */
	set_all_form_position_for_start = function(new_height) {
		var len=timeline.length;
		var animation;
		if (typeof new_height=='undefined') new_height=global_iframe_height;
		global_iframe_height_when_forms_repositioned=global_iframe_height;
		var form_showed=check_if_forms_are_visible();
		for (i=0; i<len; i++) {
			if (form_showed && active_form==i) continue;
			animation=timeline[i].animation;
			set_form_position_for_start(animation, i, new_height);
		}

	};

	show_form=function(animation) {
		if (typeof animation=='undefined') animation=data_animation;

		current_form_status='animation_begin_started';
		var arr;
		var modified=0;
		var type=timeline[active_form].type;

		$('.made_with_leadeo_id', '#base_'+active_form).fadeIn('slow');

		$('#base_'+active_form).show();
		get_form_height();
		if ($('.made_with_leadeo_id', '#base_'+active_form).length) {
			set_leadeo_lite_label();
		}
		if (timeline[active_form].auto_height==0 && timeline[active_form].type==1) {
			//alert(timeline[active_form].height_int);
			var real_height=get_real_form_height();
			var minus=global_current_form_height-real_height;
			if (minus<0) {
				var message_textarea_height = get_message_textarea_height();
				var new_height=message_textarea_height+minus;
				set_message_textarea_height(new_height);
			}
		}
		leadeo_control.iframe_should_resize('show_form', global_current_form_height);

		if (animation=='fadein_right' || animation=='fadein_left') {
			arr = {'left': '0%'};
			modified = 1;
		}
		if (animation=='fadein_top' || animation=='fadein_bottom') {
			arr = {'top': '0'};
			modified = 1;
		}
		if (modified) {
			//console.log('#base_'+active_form+'_my_form.length='+$('#base_'+active_form+'_my_form').length);
			/*if (type<3) {
				$('#base_' + active_form + '_my_form').animate(arr, 'slow', 'swing', function () {
					current_form_status = 'showed';
				});
				$('#base_' + active_form + '_my_overlay').animate(arr, 'slow', 'swing');
			} else {*/
				$('#base_' + active_form).animate(arr, 'slow', 'swing', function () {
					current_form_status = 'showed';
				});
			//}
		}
	};

	hide_form=function(animation) {
		if (typeof animation=='undefined') animation=data_animation;
		var type=timeline[active_form].type;
		current_form_status='animation_end_started';
		var arr;
		var modified=0;
		$('.made_with_leadeo_id', '#base_'+active_form).fadeOut('slow');
		if (animation=='fadein_left') {
			arr={'left': '110%'};
			modified = 1;
		}
		if (animation=='fadein_right') {
			arr={'left': '-110%'};
			modified = 1;
		}
		if (animation=='fadein_top') {
			arr = {'top': (global_iframe_height+10)+'px'};
			modified = 1;
		}
		if (animation=='fadein_bottom') {
			arr = {'top': '-'+(global_iframe_height+10)+'px'};
			modified = 1;
		}
		if (modified) {
			/*if (type<3) {
				$('#base_' + active_form + '_my_form').animate(arr, 'slow', 'swing', function () {
					$('#base_' + active_form).hide();
					current_form_status = 'hidden';
					leadeo_control.iframe_should_resize('hide_form', global_player_height);
					//set_form_position_for_start();
				});
				$('#base_' + active_form + '_my_overlay').animate(arr, 'slow', 'swing');
			} else {*/
				$('#base_' + active_form).animate(arr, 'slow', 'swing', function () {
					$('#base_' + active_form).hide();
					current_form_status = 'hidden';
					leadeo_control.iframe_should_resize('hide_form', global_player_height);
					//set_form_position_for_start();
				});
			//}
		}
	};

})(jQuery);
