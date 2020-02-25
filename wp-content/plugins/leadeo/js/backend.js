var leadeo_last_form_id;
var leadeo_form_style_apply;
(function($) {
	$(document).ready(function(){

		$(document).on('click', '.leadeo_remove_form', function(){
			var r=confirm("Are you sure you want delete this form?");
			if (!r) return;

			var label=$(this).parent().parent();
			var form=label.next();

			label.fadeOut(function() {
				label.remove();
			});
			form.fadeOut(function() {
				form.remove();
			});
		});
		$('#save_leadeo').on('click', function(e){
			e.preventDefault();
			leadeo_save();
		});

		$('#preview_leadeo').on('click', function(e){
			e.preventDefault();
			leadeo_save(true);
		});
		$('#br0v_openModal').on('click', function(){
			//forms_modal_close();
		});
		$('.br0v_modal_close').on('click', function(){
			forms_modal_close();
		});
		$('#leadeo_add_contact_form').on('click', function(){
			leadeo_add_form(1);
		});
		$('#leadeo_add_opt_form').on('click', function(){
			leadeo_add_form(2);
		});
		$('#leadeo_add_open_link_form').on('click', function(){
			leadeo_add_form(3);
		});
		$('#leadeo_add_share_a_quote_form').on('click', function(){
			leadeo_add_form(4);
		});
		$('#leadeo_add_share_to_watch_form').on('click', function(){
			leadeo_add_form(5);
		});
		$('#leadeo_add_thank_you_for_watching_form').on('click', function(){
			leadeo_add_form(6);
		});


		/*

		var form_type=$('#form_type').val();
		var form_style=$('#form_style').val();
		form_type=parseInt(form_type, 10);
		form_style=parseInt(form_style, 10);
		leadeo_form_type=form_type;
		leadeo_form_style=form_style;
		show_selected_type_of_form(form_type, true);
		style_propagation_hide_show_blocks(true);
		style_propagation_set_colors(true);

		$('#form_type').change(function(){
			form_type=$('#form_type').val();
			form_type=parseInt(form_type, 10);
			leadeo_form_type=form_type;
			if (form_type>2 || leadeo_data.LEADEO_LITE=='1') {
				$(this).val('2');
				form_type=2;
			}
			show_selected_type_of_form(form_type, false);
			form_style=$('#form_style').val();
			form_style=parseInt(form_style, 10);
			leadeo_form_style=form_style;
			style_propagation_hide_show_blocks(false);
			style_propagation_set_colors(false);
		});*/
		leadeo_form_style_apply=function (started, id) {
			if (typeof id=='undefined') id=-1;
			var form_style=$('#form_style').val();
			form_style=parseInt(form_style, 10);
			style_propagation_hide_show_blocks(id, form_style, started);
			style_propagation_set_colors(id, form_style, started);
		}
		leadeo_form_style_apply(true);
		$('.leadeo_form_style').change(function(){
			leadeo_form_style_apply(false);
		});

		// --------

		$('#font_name').change(function(){
			var val=$('#font_name').val();
			leadeo_send_ajax('leadeo_get_font_listboxes', 'font='+val, font_callback, 'json');
		});
		$('.imapper-delete-button').on('click', function(e) {
			e.preventDefault();
			var url=$(this).attr('href');
			var r=confirm("Are you sure you want delete this item?");
			if (r==true) {
				window.location=url;
			}
		});
		if ($('#auto_width').attr('checked')=='checked') leadeo_checkbox_changed('auto_width', 1);
		else leadeo_checkbox_changed('auto_width', 0);
		if ($('#auto_height').attr('checked')=='checked') leadeo_checkbox_changed('auto_height', 1);
		else leadeo_checkbox_changed('auto_height', 0);

		$('#show_only_data').on('click', function(){
			$('.non_data').hide();
		});

		bind_mailchimp_button('');

		$('.mailchimp_api').each(function(){
			var id=$(this).parents('.leadeo_base').attr('data-base');
			id=parseInt(id, 10);
			get_mailchimp_lists(id);
		});

		$('.leadeo_base').each(function(){
			var id=$(this).attr('data-base');
			id=parseInt(id, 10);
			if ($('#leadeo_base_'+id+'_auto_width').attr('checked')=='checked') leadeo_checkbox_changed('leadeo_base_'+id+'_auto_width', 1);
			else leadeo_checkbox_changed('leadeo_base_'+id+'_auto_width', 0);
			if ($('#leadeo_base_'+id+'_auto_height').attr('checked')=='checked') leadeo_checkbox_changed('leadeo_base_'+id+'_auto_height', 1);
			else leadeo_checkbox_changed('leadeo_base_'+id+'_auto_height', 0);
		});

		});

	function bind_mailchimp_button(base) {
		$(base+'.mailchimp_api_button').on('click', function(e){
			var id=$(this).parents('.leadeo_base').attr('data-base');
			id=parseInt(id, 10);
			e.preventDefault();
			get_mailchimp_lists(id);
		});
		$(base+'.mailchimp_api').on('change keyup', function(e){
			var id=$(this).parents('.leadeo_base').attr('data-base');
			id=parseInt(id, 10);
			var apikey=$('#leadeo_base_'+id+'_mailchimp_api').val();
			if (apikey=='') $('#leadeo_base_'+id+'_mailchimp_lists').html('');
		});
	}

	function get_mailchimp_lists(form_id) {
		var apikey=$('#leadeo_base_'+form_id+'_mailchimp_api').val();
		var leadeo_id=$('#leadeo_id').val();
		leadeo_last_form_id=form_id;
		//alert('leadeo_last_form_id='+leadeo_last_form_id);
		if (apikey!='') leadeo_send_ajax('leadeo_get_mailchimp_lists', 'leadeo_id='+leadeo_id+'&apikey='+apikey+'&form_id='+form_id, mailchimp_lists_received, 'html');
		else $('#leadeo_base_'+form_id+'_mailchimp_lists').html('');
	}

	function mailchimp_list_clicked(obj) {
		var value=$(obj).val();
		var form_id=$(obj).parents('.leadeo_base').attr('data-base');
		form_id=parseInt(form_id, 10);
		var searching_for='leadeo_base_'+form_id+'_mailchimp_list_'+value;
		//console.log('searching_for='+searching_for);
		$('.leadeo_mailchimp_field_1, .leadeo_mailchimp_field_2', '#leadeo_base_'+form_id).each(function(){
			var name=$(this).attr('name');
			if (name.indexOf(searching_for)==0) {
				//console.log('name=' + name);
				if ($(this).attr('type')!=='radio') $(this).attr('checked', 'checked');
				else {
					$("input[name='"+name+"']:first").attr('checked', 'checked');
				}
			} else {
				$(this).removeAttr('checked');
			}
		});

	}

	function mailchimp_lists_received(response, dataType, status) {
		var form_id=leadeo_last_form_id;
		//alert('form_id='+form_id);
		$('#leadeo_base_'+form_id+'_mailchimp_lists').html(response);
		$('.leadeo_mailchimp_field_0', '#leadeo_base_'+form_id).on('click', function(){
			mailchimp_list_clicked(this);
		});
		$('.leadeo_mailchimp_field_1, .leadeo_mailchimp_field_2', '#leadeo_base_'+form_id).on('click', function(){
			var name=$(this).attr('name');
			var temp='leadeo_base_'+form_id+'_mailchimp_list_';
			//alert('temp='+temp);
			var len=temp.length;
			//alert('len='+len);
			var lid=name.substring(len);
			var delimiter=lid.indexOf('_');
			lid=lid.substring(0, delimiter);
			//console.log('lid='+lid);
			$("input[value='"+lid+"']").each(function(){
				//console.log('found');
				if (!$(this).is(":checked")) {
					$('.leadeo_mailchimp_field_0').removeAttr('checked');
					$(this).attr('checked', 'checked');
					mailchimp_list_clicked(this);
				}
			});
			//alert(lid);
		});
		$('.leadeo_mailchimp_field_1', '#leadeo_base_'+form_id).on('click', function(){
			var searching_for=$(this).attr('name');
			if ($(this).is(":checked")) {
				$('.leadeo_mailchimp_field_2', '#leadeo_base_'+form_id).each(function(){
					var name=$(this).attr('name');
					if (name.indexOf(searching_for)==0) {
						if ($(this).attr('type')!=='radio') $(this).attr('checked', 'checked');
						else {
							$("input[name='"+name+"']:first").attr('checked', 'checked');
						}
					}
				});
			} else {
				$('.leadeo_mailchimp_field_2', '#leadeo_base_'+form_id).each(function() {
					var name = $(this).attr('name');
					if (name.indexOf(searching_for) == 0) {
						$(this).removeAttr('checked');
					}
				});
			}
		});
	}

	leadeo_checkbox_changed=function(id, val) {
		base=-1;
		if (id.indexOf('_base_')>0) {
			var base=$('#'+id).parents('.leadeo_base').attr('data-base');
			base=parseInt(base, 10);
		}
		//console.log('checkbox: base = '+base+', id = '+id+', val = '+val);
		if (id.indexOf('auto_width')>-1) auto_width_changed(val, base);
		if (id.indexOf('auto_height')>-1) auto_height_changed(val, base);
	};

	function auto_width_changed(val, base) {
		if (typeof base=='undefined') base=-1;
		//console.log('width: base='+base+', val='+val);
		if (base==-1) {
			if (val == 0) $('#leadeo_width_div').show();
			else $('#leadeo_width_div').hide();
		} else {
			if (val == 0) $('#leadeo_base_'+base+'_width_div').show();
			else $('#leadeo_base_'+base+'_width_div').hide();
		}
	}
	function auto_height_changed(val, base) {
		if (typeof base=='undefined') base=-1;
		//console.log('height: base='+base+', val='+val);
		if (base==-1) {
			if (val==0) $('#leadeo_height_div').show();
			else $('#leadeo_height_div').hide();
		} else {
			if (val==0) $('#leadeo_base_'+base+'_height_div').show();
			else $('#leadeo_base_'+base+'_height_div').hide();
		}
	}

	/*function show_selected_type_of_form(id, form_type, started) {
		if (leadeo_data.LEADEO_LITE=='1') form_type=2;

		if (form_type == 1) {
			$('#leadeo_base_'+id+'_contact_form_type').show();
			$('#leadeo_base_'+id+'_opt_in_mailchimp_type').hide();
		}

		if (form_type==2) {
			$('#leadeo_base_'+id+'_contact_form_type').hide();
			$('#leadeo_base_'+id+'_opt_in_mailchimp_type_'+id).show();
			get_mailchimp_lists(id);
		}
	}*/

	function style_propagation_hide_show_blocks(id, form_style, started) {
		var base, id2, type;

		$('.leadeo_base').each(function() {
			id2=$(this).attr('data-base');
			id2=parseInt(id2, 10);
			base='#leadeo_base_'+id2;

			if (id>-1 && id!=id2) return true;

			type=$(base+'_form_type').val();
			type=parseInt(type, 10);

			if (type==1 || type==2) {
				if (form_style == 1) {
					$(base + '_div_title_background_color').show();
					$(base + '_div_form_background_color').show();
					//$(base + '_div_font_button_color').show();
					$(base + '_div_button_color').show();
					$(base + '_div_border_color').hide();
					$('.leadeo_separate_input_colors', base).show();
				}
				if (form_style == 2) {
					$(base + '_div_title_background_color').hide();
					$(base + '_div_form_background_color').hide();
					//$(base + '_div_font_button_color').hide();
					$(base + '_div_button_color').hide();
					$(base + '_div_border_color').show();
					$('.leadeo_separate_input_colors', base).hide();
				}
			}
		});
	}
	function style_propagation_set_colors(id, form_style, started) {

		if (form_style==1) {
			$('.leadeo_color_input_background_color_label').html('Input field background');
		}
		if (form_style==2) {
			$('.leadeo_color_input_background_color_label').html('Input field border');
		}
		if (started) return false;
		var base, id2, type;
		$('.leadeo_base').each(function() {
			id2=$(this).attr('data-base');
			id2=parseInt(id2, 10);
			base='#leadeo_base_'+id2;

			if (id>-1 && id!=id2) return true;

			type=$(base+'_form_type').val();
			type=parseInt(type, 10);

			if (type==1 || type==2) {
				if (form_style == 1) {
					$(base + '_iris_font_color').iris('color', '#ffffff');
					$(base + '_iris_font_button_color').iris('color', '#000000');
					$(base + '_iris_input_font_color').iris('color', '#606060');
					$(base + '_iris_input_background_color').iris('color', '#ffffff');
					$(base + '_iris_overlay_color').iris('color', '#E43834');
					$(base + '_slider_overlay_transparency').slider("value", 60);
					$(base + '_overlay_transparency').val('60');
				}
				if (form_style == 2) {
					$(base + '_iris_font_color').iris('color', '#ffffff');
					$(base + '_iris_font_button_color').iris('color', '#ffffff');
					$(base + '_iris_input_font_color').iris('color', '#ffffff');
					$(base + '_iris_input_background_color').iris('color', '#ffffff');
					$(base + '_iris_overlay_color').iris('color', '#000000');
					$(base + '_slider_overlay_transparency').slider("value", 44);
					$(base + '_overlay_transparency').val('44');
				}
			}
			if (type==3 || type==4 || type==5 || type==6) {
				$(base + '_iris_form_background_color').iris('color', '#ffffff');
				$(base + '_iris_font_color').iris('color', '#000000');
				$(base + '_iris_font_button_color').iris('color', '#ffffff');
				$(base + '_iris_button_color').iris('color', '#58b957');
			}
		});
	}

	function leadeo_add_form(type) {
		if (type>2 && leadeo_data.LEADEO_LITE=='1') {
			alert ('Available only in pro version!');
			window.location.href = 'http://codecanyon.net/item/leadeo-wordpress-plugin-for-video-marketing/13478892?utm_source=LeadeoLite2ProUpgrade&utm_medium=wporg&utm_campaign=leadeo';
			return;
		}
		if (type>0) {
			var id = get_last_base() + 1;
			leadeo_send_ajax('leadeo_get_form', 'type=' + type + '&id=' + id, leadeo_insert_form, 'json');
		}
	}

	function get_last_base() {
		var max=-1;
		$('.leadeo_base').each(function(){
			id=$(this).attr('data-base');
			id=parseInt(id, 10);
			if (id>max) max=id;
		});
		return max;
	}

	function leadeo_insert_form(response, dataType, status) {
		if (status == 0) return;
		//alert(response.content);
		$('#leadeo_forms_container').append(response.content);
		var id=get_last_base();
		$('#leadeo_base_'+id).hide();
		$('#leadeo_base_'+id+'_label').hide();
		$('#leadeo_base_'+id).fadeIn('slow');
		$('#leadeo_base_'+id+'_label').fadeIn('slow');
		wpMySoGridAdmin_ins.my_init_color_picker("#leadeo_base_"+id+" .my_color_picker_title");
		leadeo_init_slider('#leadeo_base_'+id+' ');
		if ($('#leadeo_base_'+id+'_auto_width').attr('checked')=='checked') leadeo_checkbox_changed('leadeo_base_'+id+'_auto_width', 1);
		else leadeo_checkbox_changed('leadeo_base_'+id+'_auto_width', 0);
		if ($('#leadeo_base_'+id+'_auto_height').attr('checked')=='checked') leadeo_checkbox_changed('leadeo_base_'+id+'_auto_height', 1);
		else leadeo_checkbox_changed('leadeo_base_'+id+'_auto_height', 0);
		leadeo_init_hidden_label('#leadeo_base_'+id+' ');
		leadeo_form_style_apply(false, id);
		bind_mailchimp_button('#leadeo_base_'+id+' ');
		//get_mailchimp_lists(form_id);
	}

	// -------------------------------------

	function leadeo_save(preview) {
		if (typeof preview=='undefined') preview=false;
		var postForm = $('#leadeo_form').serialize();
		postForm=postForm.replace(/\&/g, '[odvoji]');
		//var data='leadeo_data=' + postForm;
		if (!preview) leadeo_send_ajax('leadeo_save', 'leadeo_data='+postForm, save_callback, 'json');
		else leadeo_send_ajax('leadeo_save', 'leadeo_preview=1&leadeo_data='+postForm, preview_callback, 'json');
	}

	function save_callback(response, dataType, status) {
		if (status == 0) return;
		if (response.mode=='insert') $('#leadeo_id').val(response.id);
		//alert('Saved as leadeo: '+response.id);
		$('.leadeo_saved').fadeIn('slow', function(){
			setTimeout(function() {
				$('.leadeo_saved').fadeOut('slow');
			}, 3000);
		});
	}

	function preview_callback (response, dataType, status) {
		if (status == 0) return;
		//console.log ('id: '+response.id); console.log ('mode: '+response.mode);
		forms_fill();
		forms_modal_open();
		//alert('Preview: '+response.id);
	}

	function font_callback (response, dataType, status) {
		if (status == 0) return;
		//console.log (response);
		$('#font_variant').replaceWith(response.variant_list);
		$('#font_variant_span').html(response.variant);
		$('#font_subset').replaceWith(response.subset_list);
		$('#font_subset_span').html(response.subset);
	}

	function forms_fill() {
		var auto_width;
		if ($('#auto_width').attr('checked')=='checked') auto_width=1;
		else auto_width=0;
		var auto_height;
		if ($('#auto_height').attr('checked')=='checked') auto_height=1;
		else auto_height=0;
		var width=$('#leadeo_width').val();
		var height=$('#leadeo_height').val();
		//console.log('auto_width = '+auto_width); console.log('width = '+width); console.log('auto_height = '+auto_height); console.log('height = '+height);
		var style="";
		if (auto_width) style+='width: 100%; ';
		else style+='width: '+width+'; ';
		//if (auto_height) style+='height: 694px;'; else style+='height: '+height+';';
		if (!auto_height) style+='height: '+height+';';
		forms_modal_set_content('<iframe id="leadeo_iframe_1" class="leadeo_iframe" src="'+leadeo_data.preview_url+'" style="'+style+'" allowtransparency="true" frameborder="0" scrolling="no" data-resized="0"></iframe>', auto_height);
	}

	function forms_modal_set_content(content, auto_height) {
		if (typeof auto_height=='undefined') auto_height=0;
		$('.br0v_modal_content').html(content);
		if (auto_height) {
			var video=$('#video_url').val();
			var is_youtube=0;
			var is_vimeo=0;
			var ratio=1.641;
			if (video.indexOf('youtube')>-1) is_youtube=1;
			if (video.indexOf('vimeo')>-1) is_vimeo=1;
			if (is_vimeo) ratio=1.779;
			var leadeo_width=document.getElementById("leadeo_iframe_1").offsetWidth;
			var leadeo_height=Math.round(leadeo_width/ratio);
			document.getElementById("leadeo_iframe_1").style.height=leadeo_height+"px";
		}
	}
	function forms_modal_open() {
		$('#br0v_openModal').css({'opacity': 1, 'pointer-events': 'auto'});
	}
	function forms_modal_close() {
		$('#br0v_openModal').css({'opacity': 0, 'pointer-events': 'none'});
		$('.br0v_modal_content').html('');
	}
})(jQuery);