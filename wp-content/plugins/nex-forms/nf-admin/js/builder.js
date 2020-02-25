var strPos = 0;
var timer;
var help_text_timer;
var LS_MCE_l10n = 'test';
jQuery('div.updated').remove();
jQuery('.update-nag').remove();
jQuery('div.error').remove();


function render_radiochecks(field_container,group_name,target,radio_check_type, theme)
	{
	var set_options ='';
		field_container.find(target).each(
			function(i)
				{
				var label = jQuery(this).find('.input-label').text();
				var value = jQuery(this).find('input').val();
				
				var radio_layout = field_container.find('#the-radios').attr('data-layout');
				var set_layout = '';
				if(radio_layout=='1c')
					set_layout='display-block col-sm-12'; 
				if(radio_layout=='2c')
					set_layout='display-block col-sm-6';
				if(radio_layout=='3c')
					set_layout='display-block col-sm-4';
				if(radio_layout=='4c')
					set_layout='display-block col-sm-3';
				
				if(theme=='m_design')
					{
					if(radio_check_type=='radio')
						{
						field_container.removeClass('radio-group').removeClass('jq-radio-group').removeClass('classic-radio-group').addClass('md-radio-group');
						set_options += '<p class="radio_check_input '+ set_layout +'"><input class="with-gap the_input_element" type="radio" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'_'+ i +'_r" value="'+value+'"><label class="input-label" for="'+format_illegal_chars(label)+'_'+ i +'_r">'+ label +'</label></p>';
						}
					if(radio_check_type=='check')
						{
						field_container.removeClass('check-group').removeClass('jq-check-group').removeClass('classic-check-group').addClass('md-check-group');
						set_options += '<p class="radio_check_input  '+ set_layout +'"><input class=" the_input_element" type="checkbox" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'_'+ i +'_c" value="'+value+'"><label class="input-label" for="'+format_illegal_chars(label)+'_'+ i +'_c">'+ label +'</label></p>';
						}
					}
					
				if(theme=='bootstrap')
					{
					if(radio_check_type=='radio')
						{
						field_container.removeClass('md-radio-group').removeClass('jq-radio-group').removeClass('classic-radio-group').addClass('radio-group');
						set_options += '<label class="radio-inline  '+ set_layout +'" for="'+ format_illegal_chars(label) +'" ><span class="svg_ready"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'" value="'+value+'"><span class="input-label radio-label">'+label+'</span></span></label>';					
						}
					if(radio_check_type=='check')
						{
						field_container.removeClass('md-check-group').removeClass('jq-check-group').removeClass('classic-check-group').addClass('check-group');
						set_options += '<label class="checkbox-inline  '+ set_layout +'" for="'+ format_illegal_chars(label) +'" ><span class="svg_ready"><input class="check the_input_element" type="checkbox" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'" value="'+value+'"><span class="input-label check-label">'+label+'</span></span></label>';
						}
					}
					
				if(theme=='jq_ui')
					{
					if(radio_check_type=='radio')
						{
						field_container.removeClass('md-radio-group').removeClass('radio-group').removeClass('classic-radio-group').addClass('jq-radio-group');
						set_options += '<div class="jq_radio_check  '+ set_layout +'"><label class="input-label" for="'+ format_illegal_chars(label) +'_jq">'+label+'</label><input type="radio" name="'+ format_illegal_chars(group_name) +'" id="'+ format_illegal_chars(label) +'_jq" value="'+value+'"></div>';
						}
					if(radio_check_type=='check')
						{
						field_container.removeClass('md-check-group').removeClass('check-group').removeClass('classic-check-group').addClass('jq-check-group');
						set_options += '<div class="jq_radio_check  '+ set_layout +'"><label class="input-label" for="'+ format_illegal_chars(label) +'_jq">'+label+'</label><input type="checkbox" name="'+ format_illegal_chars(group_name) +'" id="'+ format_illegal_chars(label) +'_jq" value="'+value+'"></div>';	
						}
					}
				if(theme=='browser')
					{
					if(radio_check_type=='radio')
						{
						field_container.removeClass('md-radio-group').removeClass('jq-radio-group').addClass('radio-group').addClass('classic-radio-group');
						set_options += '<label class="radio-inline  '+ set_layout +'" for="'+ format_illegal_chars(label) +'" ><span class="svg_ready"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'" value="'+value+'"><span class="input-label radio-label">'+label+'</span></span></label>';					
						}
					if(radio_check_type=='check')
						{
						field_container.removeClass('md-check-group').removeClass('jq-check-group').addClass('check-group').addClass('classic-check-group');
						set_options += '<label class="checkbox-inline  '+ set_layout +'" for="'+ format_illegal_chars(label) +'" ><span class="svg_ready"><input class="check the_input_element" type="checkbox" name="'+ format_illegal_chars(group_name) +'" id="'+format_illegal_chars(label)+'" value="'+value+'"><span class="input-label check-label">'+label+'</span></span></label>';
						}
					}
				
				
				}
			);
		field_container.find('.input-inner').html(set_options);		
	}


function reset_field_theme(set_theme,field_container){
	
	var field_container = field_container;
	var group_name = field_container.find('input').attr('name');
	var radio_check_type = 'none';
	var target = '';
	
	if(field_container.hasClass('radio-group') || field_container.hasClass('md-radio-group') || field_container.hasClass('jq-radio-group') || field_container.hasClass('classic-radio-group'))
		radio_check_type = 'radio';
	if(field_container.hasClass('check-group') || field_container.hasClass('md-check-group') || field_container.hasClass('jq-check-group')  || field_container.hasClass('classic-check-group'))
		radio_check_type = 'check';
	
	if(field_container.hasClass('radio-group') || field_container.hasClass('check-group') || field_container.hasClass('classic-radio-group') || field_container.hasClass('classic-check-group'))
		target = '.input-inner label';
	if(field_container.hasClass('md-radio-group') || field_container.hasClass('md-check-group'))
		target = '.radio_check_input';
	if(field_container.hasClass('jq-radio-group') || field_container.hasClass('jq-check-group'))
		target = '.jq_radio_check';
	
	
	if(radio_check_type!='none')
		render_radiochecks(field_container,group_name,target,radio_check_type, set_theme);
	
	
//MATERIAL THEME				
	if(set_theme=='m_design')
		{
		
		
		if(field_container.hasClass('slider'))
				{
				field_container.removeClass('slider').addClass('md-slider');
				
					field_container.find( "#slider" ).slider('destroy');
					field_container.find( "#slider" ).addClass('noUi-target').addClass('noUi-ltr').addClass('noUi-horizontal');  
					setup_form_element(field_container);
					
				}
		
		
		if(field_container.hasClass('touch_spinner'))
			{
			
			field_container.find('#spinner').attr('data-verticalbuttons',false);
			//field_container.find('.bootstrap-touchspin-postfix').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn-vertical').remove();
			//field_container.find('#spinner').unwrap();
			
			field_container.find('.bootstrap-touchspin').prepend('<span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span>');
			field_container.find('.bootstrap-touchspin').append('<span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span>');

			
			field_container.addClass('md-spinner').removeClass('jq-spinner');
			
			setup_form_element(field_container);
			
			}
		
		
		field_container.find('#the-radios' ).removeClass('the-radios');	
		
		if(!field_container.hasClass('html_fields') || !field_container.hasClass('button_fields'))
			field_container.find('.the_input_element').addClass('form-control')
		
			field_container.find('.the_input_element').removeClass('ui-corner-all').removeClass('ui-widget');
			if(field_container.hasClass('preset_fields') || field_container.hasClass('text') || field_container.hasClass('autocomplete') || field_container.hasClass('date') || field_container.hasClass('time') || field_container.hasClass('jq-datepicker') || field_container.hasClass('jq-time-picker') || field_container.hasClass('textarea') || field_container.hasClass('select') || field_container.hasClass('multi-select') || field_container.hasClass('password') )
				{
				
				if(field_container.hasClass('submit-button') || field_container.hasClass('nex-button') || field_container.hasClass('prev-button'))
					return;
				
				field_container.addClass('material_field');
				field_container.find('.label_container').addClass('hidden');
				
				var set_style = field_container.find('.label_container').find('.the_label').attr('style');
				
				if(field_container.find('.input-group-addon.prefix').attr('class'))
					{
					field_container.find('.input_container .the_input_element').before('<i class="material-icons prefix '+  field_container.find('.input-group-addon.prefix span').attr('class') +'"></i>');
					}
					
				field_container.find('.input_container .the_input_element').after('<label id="md_label" style="' + set_style + '" for="' + field_container.find('.the_input_element').attr('name') + '" class="">'+ field_container.find('.the_label').html()  +'</label>');
				
				field_container.find('.input_container').attr('class', 's12 input-field  material_design_field col');
				field_container.find('.input-group').attr('class', 'input-group-md');
				field_container.find('.input-group-addon.prefix').attr('class','input-group-addon prefix2')
				field_container.find('.input-group-addon').addClass('hidden').removeClass('ui-button');
				
				if(field_container.hasClass('textarea') || (field_container.hasClass('Query') && field_container.hasClass('preset_fields')))
					{
					field_container.find('.textarea').addClass('materialize-textarea');;
					jQuery('textarea').trigger('autoresize');
					}
				if(field_container.hasClass('select') || field_container.hasClass('multi-select'))
					{
					if(field_container.find('select').hasClass('jq_select'))
						{
						field_container.find('select').selectmenu('destroy');
						field_container.find('select').removeClass('jq_select');
						}
					field_container.find('select').addClass('material_select').removeClass('form-control');
					field_container.find('select').material_select();
					}
			}
			if(field_container.hasClass('date'))
				{
				field_container.removeClass('date').addClass('md-datepicker');  
				setup_form_element(field_container);
				}
			if(field_container.hasClass('jq-datepicker'))
				{
				field_container.find('input').datepicker('destroy');
				field_container.removeClass('jq-datepicker').addClass('md-datepicker');
				setup_form_element(field_container);
				}
				
			if(field_container.hasClass('time'))
				{
				field_container.removeClass('time').addClass('md-time-picker');  
				setup_form_element(field_container);
				}
			if(field_container.hasClass('jq-time-picker'))
				{
				field_container.find('input').timepicker('destroy');
				field_container.removeClass('jq-time-picker').addClass('md-time-picker');
				setup_form_element(field_container);
				}
			
			
			
		}
	
//BOOTSTRAP THEME						
	else if(set_theme=='bootstrap' || set_theme=='browser')
		{
			if(set_theme=='bootstrap')
				{
				if(!field_container.hasClass('html_fields') || !field_container.hasClass('button_fields'))
					field_container.find('.the_input_element').addClass('form-control')
				
					field_container.find('.the_input_element').removeClass('ui-corner-all').removeClass('ui-widget').removeClass('default-browser-style');
				}
			if(set_theme=='browser' )
				{
				field_container.find('.the_input_element').removeClass('ui-corner-all').removeClass('ui-widget').removeClass('form-control').addClass('default-browser-style');
				}
		if(radio_check_type!='none' && set_theme!='browser')
			setTimeout(function(){field_container.find('#the-radios input').nexchecks()},10);
		
		
		if(field_container.hasClass('touch_spinner'))
			{
			field_container.find('#spinner').attr('data-verticalbuttons',false);
			//field_container.find('.bootstrap-touchspin-postfix').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn-vertical').remove();
			//field_container.find('#spinner').unwrap();
			
			field_container.find('.bootstrap-touchspin').prepend('<span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span>');
			field_container.find('.bootstrap-touchspin').append('<span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span>');

			field_container.removeClass('md-spinner').removeClass('jq-spinner');
			
			setup_form_element(field_container);
			}
		
		
		
		if(field_container.hasClass('md-slider'))
			{
			field_container.removeClass('md-slider').addClass('slider');
			field_container.find( "#slider" ).slider('destroy');
			field_container.find( "#slider" ).removeClass('noUi-target').removeClass('noUi-ltr').removeClass('noUi-horizontal');
			setup_form_element(field_container);
			}
		
			field_container.find('#the-radios' ).addClass('the-radios');	
			
			
			if(field_container.hasClass('preset_fields') || field_container.hasClass('text') || field_container.hasClass('autocomplete') || field_container.hasClass('md-datepicker') || field_container.hasClass('jq-datepicker') || field_container.hasClass('md-time-picker') || field_container.hasClass('jq-time-picker') || field_container.hasClass('textarea') || field_container.hasClass('select') || field_container.hasClass('multi-select') || field_container.hasClass('password') )
				{
				if(field_container.hasClass('submit-button') || field_container.hasClass('nex-button') || field_container.hasClass('prev-button'))
					return;
					
				field_container.removeClass('material_field');
				field_container.find('.label_container').removeClass('hidden');
				
				field_container.find('i.material-icons').remove();
				field_container.find('#md_label').remove();
				
				field_container.find('.input-field').attr('class', 'col-sm-12  input_container');
				field_container.find('.input-group-md').attr('class', 'input-group');
				field_container.find('.input-group-addon.prefix2').attr('class','input-group-addon prefix')
				field_container.find('.input-group-addon').removeClass('hidden').removeClass('ui-button');
				
				if(field_container.hasClass('textarea'))
					{
					field_container.find('.textarea').removeClass('materialize-textarea');;
					}
				if(field_container.hasClass('select') || field_container.hasClass('multi-select'))
					{
					if(field_container.find('select').hasClass('jq_select'))
						{
						field_container.find('select').selectmenu('destroy');
						field_container.find('select').removeClass('jq_select');
						}
					field_container.find('select').material_select('destroy');
					field_container.find('select').removeClass('material_select').removeClass('initialized').addClass('form-control');
					}
				
				if(field_container.hasClass('md-datepicker'))
					{
					field_container.find('input').bootstrapMaterialDatePicker('destroy');
					//field_container.find('input').pickadate('stop');
					field_container.find('input').attr('readonly',false);
					field_container.removeClass('md-datepicker').addClass('date');
					setup_form_element(field_container);
					}
				if(field_container.hasClass('jq-datepicker'))
					{
					field_container.find('input').datepicker('destroy');
					field_container.removeClass('jq-datepicker').addClass('date');
					setup_form_element(field_container);
					}
					
				
				if(field_container.hasClass('md-time-picker'))
					{
					field_container.find('input').bootstrapMaterialDatePicker('destroy');
					//field_container.find('input').pickadate('stop');
					field_container.find('input').attr('readonly',false);
					field_container.removeClass('md-time-picker').addClass('time');
					setup_form_element(field_container);
					}
				if(field_container.hasClass('jq-time-picker'))
					{
					field_container.find('input').timepicker('destroy');
					field_container.removeClass('jq-time-picker').addClass('time');
					setup_form_element(field_container);
					}
			}
			if(set_theme=='browser' )
				{
				jQuery('.ui-nex-forms-container .form-control').removeClass('form-control');
				}
		}	
	
	
//JQUERY UI THEME						
	else if(set_theme=='jq_ui')
		{
		
		if(radio_check_type!='none')
			field_container.find( "#the-radios input" ).checkboxradio();
		
		if(field_container.hasClass('touch_spinner'))
			{
			field_container.find('#spinner').attr('data-verticalbuttons',true);
			
			//field_container.find('.bootstrap-touchspin-postfix').remove();
			//field_container.find('.bootstrap-touchspin-prefix').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn').remove();
			field_container.find('.bootstrap-touchspin .input-group-btn-vertical').remove();
			//field_container.find('#spinner').unwrap();
			
			
			field_container.find('.bootstrap-touchspin').append('<span class="input-group-btn-vertical"><button class="btn btn-default bootstrap-touchspin-up" type="button"><i class="glyphicon glyphicon-chevron-up"></i></button><button class="btn btn-default bootstrap-touchspin-down" type="button"><i class="glyphicon glyphicon-chevron-down"></i></button></span>');
			
			field_container.removeClass('md-spinner').addClass('jq-spinner');
			
			setup_form_element(field_container);
			
			}
		if(field_container.hasClass('md-slider'))
			{
			field_container.removeClass('md-slider').addClass('slider');
			field_container.find( "#slider" ).slider('destroy');
			field_container.find( "#slider" ).removeClass('noUi-target').removeClass('noUi-ltr').removeClass('noUi-horizontal');
			setup_form_element(field_container);
			}
		
		field_container.find('#the-radios' ).removeClass('the-radios');	
		
		jQuery( ".md-radio-group #the-radios" ).removeClass('the-radios');	
		jQuery( ".md-check-group #the-radios" ).removeClass('the-radios');	

		
		field_container.find('.the_input_element').addClass('ui-corner-all').addClass('ui-widget').removeClass('form-control');
		
		field_container.find('.label_container').removeClass('hidden');
		field_container.find('i.material-icons').remove();
		field_container.find('#md_label').remove();
		
		field_container.find('.input-field').attr('class', 'col-sm-12  input_container');
		field_container.find('.input-group-md').attr('class', 'input-group');
		field_container.find('.input-group-addon.prefix2').attr('class','input-group-addon prefix')
		field_container.find('.input-group-addon').removeClass('hidden').addClass('ui-button');
		
		
		if(field_container.hasClass('select') || field_container.hasClass('multi-select'))
			{
			if(field_container.hasClass('material_field'))
				{
				field_container.find('select').material_select('destroy');
				field_container.find('select').removeClass('material_select').removeClass('initialized');
				}
			}
		if(field_container.hasClass('select'))
			{
			field_container.find('select').addClass('jq_select');
			field_container.find( "select.jq_select" ).selectmenu();
			}
		
		
		if(field_container.hasClass('date'))
			{
			field_container.removeClass('date').addClass('jq-datepicker');  
			setup_form_element(field_container);
			}
		if(field_container.hasClass('md-datepicker'))
			{
			field_container.find('input').bootstrapMaterialDatePicker('destroy');
			field_container.find('input').attr('readonly',false);
			field_container.removeClass('md-datepicker').addClass('jq-datepicker');
			setup_form_element(field_container);
			}
		
		
		if(field_container.hasClass('time'))
			{
			field_container.removeClass('time').addClass('jq-time-picker');  
			setup_form_element(field_container);
			}
		if(field_container.hasClass('md-time-picker'))
			{
			field_container.find('input').bootstrapMaterialDatePicker('destroy');
			field_container.find('input').attr('readonly',false);
			field_container.removeClass('md-time-picker').addClass('jq-time-picker');
			setup_form_element(field_container);
			}
		
		field_container.removeClass('material_field');
		
		
		jQuery('.ui-nex-forms-container select').removeClass('form-control');
		
		
		}	
		jQuery('.ui-nex-forms-container .html_fields .the_input_element, .ui-nex-forms-container .button_fields .the_input_element').removeClass('form-control');
}

function hide_step_back_next(obj){
	var btn_container_1 = obj.closest('.form_field');			
	var btn_container_2 = btn_container_1.closest('.form_field.grid-system');
	if(btn_container_2.hasClass('grid-system'))
		btn_container_2.removeClass('hidden');	
	else
		btn_container_1.removeClass('hidden')	
}
window.onbeforeunload = confirmExit;
  function confirmExit()
  {
	if(jQuery('.check_save').hasClass('not_saved'))
   	 return "You have attempted to leave this page.  If you have made any changes without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
jQuery(document).ready(
function()
	{
	
	
	
	/*var email_setup_tour = new Tour({
		  name: "email_setup_tour",
		  template: "<div class='popover tour'><div class='popover-arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default tour-step-back' data-role='prev'><span class='fa fa-arrow-left'></span> PREV </button><button class='btn btn-default tour-step-next' data-role='next'>NEXT <span class='fa fa-arrow-right'></span></button></div><button class='end-tour' data-role='end'><span class='fa fa-close'></span></button></div>",
		
		  steps: [
		  {
			element: ".admin_email_tab",
			title: "Admin Mails",
			content: "Setup your admin email notifications here",
			placement: 'bottom'
		  },
		  {
			element: ".user_email_tab",
			title: "User Mails",
			content: "Setup your user confirmation mails here",
			placement: 'bottom'
		  },
		]});
	
	var main_tour = new Tour({
		  name: "main-tour",
		  template: "<div class='popover tour'><div class='popover-arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default tour-step-back' data-role='prev'><span class='fa fa-arrow-left'></span> PREV </button><button class='btn btn-default tour-step-next' data-role='next'>NEXT <span class='fa fa-arrow-right'></span></button></div><button class='end-tour' data-role='end'><span class='fa fa-close'></span></button></div>",
		
		  steps: [
		  {
			element: ".create_new_form",
			title: "New Form",
			content: "Click here to start creating a new form",
			placement: 'bottom'
		  },
		  {
			element: "li a.email_setup",
			title: "Autoresponders",
			content: "Setup your admin notification and user confirmation emails here.<br> <a class='start-email-tour'>Email Setup</a>",
			placement: 'bottom'
		  },
		  {
			element: "li a.integration",
			title: "Intergrate with Add-ons",
			content: "Setup, PayPa, PDF's, Mailchimp, GetResponse and Form to post from here",
			placement: 'bottom'
		  },
		  {
			element: "select.set_form_theme",
			title: "Over Preset Form Themes",
			content: "Choose a colorscheme from here to instantly style your whole form (Requires Form Themes Add-on)",
			placement: 'bottom'
		  }
		]});
		
		
		// Initialize the tour
		main_tour.init();
		// Start the tour
		main_tour.start();
	
	jQuery(document).on('click','.start-tour',
		function()
			{
			main_tour.restart();
			}
		);
	
	jQuery(document).on('click','.start-email-tour',
		function()
			{
			main_tour.end();
			jQuery('a.email_setup').trigger('click');
			email_setup_tour.init();
			email_setup_tour.restart();
			email_setup_tour.goTo(0) 
			}
		);
	*/
	
	nf_count_multi_steps();
	jQuery(document).on('click','.resposive_tests i',
		function()
			{
			
			jQuery('.resposive_tests i').removeClass('active');
			
			jQuery(this).addClass('active');	
			if(jQuery(this).hasClass('desktop'))
				jQuery('#preview_popup').css('width','1300px');
			else if(jQuery(this).hasClass('laptop'))
				jQuery('#preview_popup').css('width','1028px');
			else if(jQuery(this).hasClass('tablet'))
				jQuery('#preview_popup').css('width','600px');
			else if(jQuery(this).hasClass('phone'))
				jQuery('#preview_popup').css('width','330px')
			
			}
		);
	
	/*jQuery( "button.ui-state-default" ).hover(
	  function() {
		jQuery(this).addClass('ui-state-active');
	  }, function() {
		jQuery(this).removeClass('ui-state-active');
	  }
	);*/
	
	
	jQuery('.canvas_background_tools .shade div').click(
		function()
			{
			alert('test');
			jQuery('select.md_theme_shade_selection option[value="light"]').trigger('click');
			jQuery('select.md_theme_shade_selection').trigger('change');
			}
		);
	
	
		
	var total_steps = jQuery('.nex-forms-container .form_field.step').size();
					
			if(total_steps!=0)
				{
				jQuery('#ms-css-settings').show();
				jQuery('.nf_step_breadcrumb').show();
				}

	
			jQuery('.nex-forms-container .step .nex-step').each(
				function()
					{
					hide_step_back_next(jQuery(this))
					}
				);
			jQuery('.nex-forms-container .step .prev-step').each(
				function()
					{
					hide_step_back_next(jQuery(this))
					}
				);
			jQuery('.nex-forms-container .step .nex-submit').each(
				function()
					{
					hide_step_back_next(jQuery(this))
					}
				);
			
		
		update_select('.set_form_theme');
		update_select('.choose_form_theme');
		
		jQuery('.set_form_theme').change(
			function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val())
				}
		);
		
		jQuery(document).on('click', ".date #datetimepicker input",
		function()
			{
			jQuery(this).parent().find('.input-group-addon').trigger('click');
			}
		);	
		jQuery(document).on('click', ".time #datetimepicker input",
		function()
			{
			jQuery(this).parent().find('.input-group-addon').trigger('click');
			}
		);	
		
		jQuery(document).on('change','select[name="set_form_theme"]',
			function()
				{
				
					
					
				jQuery('.field-settings-column.open_sidenav  #close-settings').trigger('click');	
				var set_theme = jQuery(this).val();
				if(set_theme=='m_design')
					{
					jQuery('.choose_form_theme').addClass('hidden');
					jQuery('.md_theme_selection').removeClass('hidden');
					jQuery('link.material_theme').attr('href',jQuery('.plugin_url').text()+ '/css/themes/'+ jQuery('.md_theme_selection').attr('data-selected') +'.css');
					jQuery('link.jquery_ui_theme').attr('href',"");
					jQuery('.ui-state-default').removeClass('ui-state-default');
					jQuery('.ui-state-active').removeClass('ui-state-active')
					jQuery('.ui-widget-content').removeClass('ui-widget-content');
					jQuery('.ui-widget-header, .panel-heading').removeClass('ui-widget-header')
					}
				else
					{
					jQuery('.choose_form_theme').removeClass('hidden');
					jQuery('.md_theme_selection').addClass('hidden');
					jQuery('link.material_theme').attr('href',jQuery('.plugin_url').text()+ '/css/themes/none.css');	
					}
				console.log(set_theme);
				
				jQuery('.ui-nex-forms-container').removeClass('bootstrap').removeClass('m_design').removeClass('jq_ui').removeClass('browser').addClass(set_theme);	
				jQuery('.ui-nex-forms-container').attr('data-form-theme',set_theme);
				
				jQuery('.ui-nex-forms-container .form_field').each( //
					function()
						{
						
						reset_field_theme(set_theme,jQuery(this));
						
						
						
						}
					);
					
					
					//setTimeout(function()
						//{
						jQuery('.ui-nex-forms-container .html_fields .the_input_element, .ui-nex-forms-container .input-group-addon .form-control, .ui-nex-forms-container .submit-button button, .ui-nex-forms-container .nex-step button, .ui-nex-forms-container .prev-step button').removeClass('form-control');
						jQuery('.ui-nex-forms-container .html_fields .the_input_element, .ui-nex-forms-container .submit-button button, .ui-nex-forms-container .nex-step button, .ui-nex-forms-container .prev-step button').removeClass('ui-corner-all').removeClass('ui-widget');
						//},200);
						
					Materialize.updateTextFields();
					
					jQuery('textarea').trigger('blur');
					
				}
			);	
		
	
	
		
		jQuery('textarea, input').blur(
			function()
				{
				if(!jQuery(this).val() && !jQuery(this).attr('placeholder'))
					jQuery(this).parent().find('#md_label').removeClass('active');
				}
			
		);
		
		
		
		jQuery('.tooltipped').tooltip(
			{
			delay: 50,
			position: 'top',
			html: true
			}
		);
		
		
		update_select('.md_theme_shade_selection');
		update_select('.md_theme_selection');
		
		
		
		
		jQuery(document).on('click','a.full-screen-btn',
			function()
				{
				if(jQuery(this).hasClass('fc'))
					{
					jQuery('.form-canvas-area').removeClass('fullscreen')
					jQuery(this).find('.material-icons').text('fullscreen');
					jQuery(this).removeClass('fc')
					}
				else
					{
					jQuery('.form-canvas-area').addClass('fullscreen')
					jQuery(this).addClass('fc');
					jQuery(this).find('.material-icons').text('fullscreen_exit');
					}
				}
			);	
		
		
		jQuery(document).on('change','select[name="md_theme_shade_selection"]',
			function()
				{
				jQuery('link.material_theme_shade').attr('href',jQuery('.plugin_url').text()+ '/css/themes/'+ jQuery(this).val() +'.css');
				}
			);	
		
		jQuery(document).on('change','select[name="md_theme_selection"]',
			function()
				{
				jQuery('link.material_theme').attr('href',jQuery('.plugin_url').text()+ '/css/themes/'+ jQuery(this).val() +'.css');
				}
			);	
		
		
		jQuery(document).on('click','.field_selection_dropdown_menu', function()
			{
			if(jQuery(this).hasClass('active'))
				{
				jQuery('.form_canvas').removeClass('fields_opened');
				jQuery(this).removeClass('active');
				jQuery('ul#fields_dropdown').slideUp('fast');
				jQuery(this).find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
				}
			else
				{
				jQuery('.form_canvas').addClass('fields_opened');	
				jQuery(this).addClass('active');
				jQuery('ul#fields_dropdown').slideDown('slow');
				jQuery(this).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
				}
			}
		);
		
		
		
		jQuery('input').trigger('autoresize');
		jQuery('textarea').trigger('autoresize');
		
		jQuery(document).on('click','.tabs_nf .tab', function()
			{
			jQuery('.mce-flight_shortcodes.is_opened').trigger('click');	
			}
		);
		
		jQuery('div.updated').remove();
		jQuery('.update-nag').remove();
		jQuery('div.error').remove();
		
		//REMOVE UNWANTED STYLESHEETS
			var link_id = '';
			var css_link = '';
			jQuery('head link').each(
				function()
					{
					css_link = jQuery(this);
					link_id = jQuery(this).attr('id');
					jQuery('.unwanted_css_array .unwanted_css').each(
						function()
							{
							if(link_id)
								{
								if(link_id.trim()==jQuery(this).text())
									css_link.attr('href','');
								}
							}
						);
					
					}
				)
		
		jQuery('ul.tabs_nf').tabs_nf();
		
		setTimeout(function(){
		jQuery('.builder_nav li.tab a.active').removeClass('active').trigger('click');
		
			/*if(!jQuery('#form_update_id').text())
				{
				jQuery('.field-selection-wrapper .form_field.submit-button .draggable_object').trigger('click');
				setTimeout(function(){ jQuery('.field-setting-categories #close-settings').trigger('click'); },500);
				}*/
		
		},500);
		
		
		jQuery('.builder_nav li.tab a.active').removeClass('active').trigger('click');
		
		
		jQuery(document).on('click','.builder_nav li.tab a.email_setup, .builder_nav li.tab a.integration', function()
				{
				jQuery('.tri-menu li.tab a.active').removeClass('active').trigger('click');
				setup_tags();
				}
			);
			
		jQuery(document).on('click','.builder_nav li.tab a.form_options', function()
				{
				setup_tags();
				}
			);
		
		
		
		nf_reset_multi_steps();
		nf_count_multi_steps();
		set_paypal_fields();
		//update_select('paypal_select');
		
		set_mc_field_map();
		set_gr_field_map();
		set_ftp_field_map();
		
		jQuery(document).on('change','select[name="mc_current_fields"]', function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val())	
				}
			);
			jQuery(document).on('change','select[name="mail_chimp_lists"]', function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val());
				
				var data =
					{
					action	 						: 'reload_mc_form_fields',
					reload_mc_list					: 'true',
					form_Id							: jQuery('#form_update_id').text(),
					mc_list_id						: jQuery(this).val(),
					};
				jQuery('.mc_field_map').html('<div class="loading">Loading <i class="fa fa-circle-o-notch fa-spin"></i></div>')		
				jQuery.post
					(
					ajaxurl, data, function(response)
						{
						jQuery('.mc_field_map').html(response);
						set_mc_field_map();
						}
					);
				
				}
			);
			
			
			jQuery(document).on('change','select[name="gr_current_fields"]', function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val())	
				}
			);
			jQuery(document).on('change','select[name="get_response_lists"]', function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val());
				
				var data =
					{
					action	 						: 'reload_gr_form_fields',
					reload_gr_list					: 'true',
					form_Id							: jQuery('#form_update_id').text(),
					gr_list_id						: jQuery(this).val(),
					};
				jQuery('.gr_field_map').html('<div class="loading">Loading <i class="fa fa-circle-o-notch fa-spin"></i></div>')		
				jQuery.post
					(
					ajaxurl, data, function(response)
						{
						jQuery('.gr_field_map').html(response);
						set_gr_field_map();
						}
					);
				
				}
			);
				
		
		setTimeout(function()
			{
			jQuery('.form_field.slider').each(
				function()
					{
					//console.log(jQuery(this).find('input.the_slider').val())
					jQuery(this).find('input.the_slider').trigger('change');
					}
				);
			},100);
		
		
		jQuery(document).on('change', 'select', function()
				{
				jQuery(this).attr('data-selected',jQuery(this).val());
				}
			);
		
		jQuery(document).on('click', '.builder_nav .tab a', function()
				{
				//jQuery('#close-settings').trigger('click');
				jQuery('.currently_editing').removeClass('currently_editing');
				if(jQuery(this).attr('class'))
					{
					jQuery('#builder_view').removeClass('styling_view').addClass(jQuery(this).attr('class'));
					}
				}
			);
		
		
		
		
		possible_email_fields();
		jQuery('a.user_email_tab').click(
			function()
				{
				possible_email_fields();
				update_select('.posible_email_fields');
				}
			);
	
		
		jQuery(document).on('click','.add_hidden_field',
				function()
					{
					var hf_clone = jQuery('.hidden_field_clone').clone();
					hf_clone.removeClass('hidden').removeClass('hidden_field_clone').addClass('hidden_field');
					
					jQuery('.hidden_fields_setup .hidden_fields').append(hf_clone);
					
					}
				);
				
			jQuery(document).on('click','.remove_hidden_field',
				function()
					{
					jQuery(this).closest('.hidden_field').remove();
					}
				);
			jQuery(document).on('change','select[name="set_hidden_field_value"]',
				function()
					{
					jQuery(this).closest('.input-group').find('.hidden_field_value').val(jQuery(this).val());
					jQuery(this).find('option').prop('selected',false);
					}
				);
		
		/*tinymce.init({
			  selector: '#admin_email_body_content',
			  plugins: 'code',
			  content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css'],
			  
			  setup: function(editor) {
				
				function toTimeHtml(date) {
				  return '<time datetime="' + date.toString() + '">' + date.toDateString() + '</time>';
				}
				
				function insertDate() {
				  var html = toTimeHtml(new Date());
				  editor.insertContent(html);
				}
			
				editor.addButton('currentdate', {
				  icon: 'insertdatetime',
				  //image: 'http://p.yusukekamiyamane.com/icons/search/fugue/icons/calendar-blue.png',
				  tooltip: "Insert Current Date",
				  onclick: insertDate
				});
			  }
			});
		
		*/
		
		
		
		
		
		
		jQuery('.hidden_onload').removeClass('hidden');
		
		jQuery('.modal').modal(
			{
			dismissible: true, // Modal can be dismissed by clicking outside of the modal
			opacity: .8, // Opacity of modal background
			inDuration: 300, // Transition in duration
			outDuration: 200, // Transition out duration (not for bottom modal)
			startingTop: '4%', // Starting top style attribute (not for bottom modal)
			endingTop: '10%', // Ending top style attribute (not for bottom modal)
			ready: function(modal, trigger)
				{ 	// Callback for Modal open. Modal and trigger parameters available.
					// console.log(modal, trigger);
				},
			complete: function() 
				{  
				} // Callback for Modal close
			}
		);
		
		
		jQuery(document).on('click','.create_new_form',
			function()
				{
				jQuery('#new_form_wizard').modal('open');
				}
			);
			
		jQuery(document).on('click','.form-preview',
			function()
				{
				
				nf_save_nex_form('','preview', jQuery(this));
				}
			);
		
		
		/*jQuery(document).on('mouseover','div.nex-forms-container .form_field',
			function()
				{
				if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target') && !jQuery(this).hasClass('step') && !jQuery(this).hasClass('grid'))
					{
					jQuery(this).find('.field_settings').first().show();
					jQuery(this).find('.btn-lg.move_field').first().show();
					}
				})
		jQuery(document).on('mouseover','div.nex-forms-container .form_field.grid',
			function()
				{
				if(!jQuery(this).hasClass('step'))
				jQuery(this).find('.field_settings').last().show();
				}
			);
			
		jQuery(document).on('mouseout','div.nex-forms-container .form_field',
			function()
				{
				jQuery(this).find('.field_settings').hide();
				}
			);*/
		jQuery(document).on('click','.field_settings .btn.delete',
			function()
				{
					var get_field = jQuery(this).closest('.form_field');
					
					if(get_field.attr('id')==jQuery('.field-settings-column .current_id').text())
						jQuery('#close-settings').trigger('click');
					
					get_field.remove();
					nf_form_modified('field delete');
					
				}
			);
		jQuery(document).on('click','.step .zero-clipboard .btn.delete',
			function()
				{
				var step_num = jQuery(this).closest('.step').attr('data-step-num');
				jQuery(this).closest('.step').fadeOut('fast',
				function()
					{
					jQuery(this).remove();	
					var total_steps = jQuery('.nex-forms-container .form_field.step').size();
					
					if(total_steps==0)
						{
						jQuery('#ms-css-settings').hide();
						jQuery('.nf_step_breadcrumb').hide();
						}
					nf_count_multi_steps();
					if(step_num==1)
						jQuery('li.all_steps a').trigger('click');//jQuery('.nf_step_breadcrumb ol li:eq(0) a').trigger('click');
					else
						jQuery('.nf_step_breadcrumb ol li:eq(' + (step_num-2) + ') a').trigger('click');
					}
				);
			}
		);
		
	jQuery(document).on('click','.duplicate_field',
		function()
			{
			
			var get_field = jQuery(this).closest('.form_field');
			var duplication = get_field.clone();
			jQuery(duplication).insertAfter(get_field);
			duplication.attr('id','_' + Math.round(Math.random()*99999));
			duplication.find('.form_field').each(
				function()
					{
					jQuery(this).attr('id','_' + Math.round(Math.random()*99999));
					}
				);
			jQuery(duplication).find('.edit').trigger('click');
			nf_form_modified('field duplicated');
			
			var panel = duplication.find('.panel-body');
			create_droppable(panel)
			
			//setTimeout(function(){ jQuery('.col2 .admin-panel .panel-heading .btn.glyphicon-hand-down').trigger('click');},300 );
			}
		);	
	
	
	
	jQuery(document).on('click','.nf_step_breadcrumb a',
		function()
			{
			jQuery('.nf_step_breadcrumb li').removeClass('current')
			jQuery(this).parent().addClass('current')
			
			jQuery('.nex-forms-container .form_field.step').removeClass('active_step')
			
			if(jQuery(this).parent().hasClass('new_step'))
				{
				jQuery('.multi-step-fields .form_field.step .draggable_object').first().trigger('click');
				return;
				}
			
			
			
			if(jQuery(this).attr('data-show-step')!='all')
				{
				jQuery('.nex-forms-container .step').hide()
				
				jQuery('.nex-forms-container .nf_multi_step_'+ jQuery(this).attr('data-show-step')).show();
				jQuery('.nex-forms-container .nf_multi_step_'+ jQuery(this).attr('data-show-step')).addClass('active_step')
				}
			else
				{
				jQuery('.nex-forms-container .step').show()
				}
			}
		);
	
	jQuery('select[name="skip_to_step"').change(
				function()
					{
					jQuery('.nex-forms-container .step').removeClass('active_step')
					if(jQuery(this).val()!=0)
						{
						jQuery('.nex-forms-container .step').hide()
						
						jQuery('.nex-forms-container .nf_multi_step_'+ jQuery(this).val()).show();
						jQuery('.nex-forms-container .nf_multi_step_'+ jQuery(this).val()).addClass('active_step')
						
						jQuery('.nf_step_breadcrumb ol li').removeClass('current');
						
						jQuery('.nf_step_breadcrumb ol li:eq('+ (jQuery(this).val()-1) +')').addClass('current');
						
						jQuery('li.all_steps').removeClass('current');
						
						}
					else
						{
						jQuery('.nex-forms-container .step').show()
						}
					}
				);
			
	
	
	jQuery(document).on('click', '.save_nex_form', 
		function()
			{
			nf_save_nex_form(0,1, jQuery(this));
			jQuery(this).addClass('saving').html('<span class="fa fa-spin fa-refresh"></span>');
			}
		);		
		
	
	
	jQuery(document).on('change', 'input[name="form_post_action"]', 
		function()
			{
			
			if(jQuery(this).val()=='ajax')
				{
				jQuery('.submit_custom_options').addClass('hidden');
				jQuery('.submit_ajax_options').removeClass('hidden');
				
				if(jQuery('input[name="on_form_submission"]:checked').val()=='message')
					{
					jQuery('.on_submit_redirect').addClass('hidden');
					jQuery('.on_submit_show_message').removeClass('hidden');
					}
				else
					{
					jQuery('.on_submit_redirect').removeClass('hidden');
					jQuery('.on_submit_show_message').addClass('hidden');
					}
					
				}
			else
				{
				jQuery('.on_submit_show_message').addClass('hidden');
				jQuery('.submit_custom_options').removeClass('hidden');
				jQuery('.submit_ajax_options').addClass('hidden');
				}
			}
		);		
		
		
		jQuery(document).on('change', 'input[name="on_form_submission"]', 
		function()
			{
			
			if(jQuery(this).val()=='message')
				{
				jQuery('.on_submit_redirect').addClass('hidden');
				jQuery('.on_submit_show_message').removeClass('hidden');
				}
			else
				{
				jQuery('.on_submit_redirect').removeClass('hidden');
				jQuery('.on_submit_show_message').addClass('hidden');
				}
			
			}
		);		
	
	
	
	
	
	
	
	
	/* PAYPAL  */
	jQuery(document).on('click', ".paypal_product .input-group-addon",
		function()
			{
					if(!jQuery(this).hasClass('is_label'))
							{
							jQuery(this).parent().find('.input-group-addon').removeClass('active');
							jQuery(this).addClass('active');
							
							if(jQuery(this).hasClass('static_value'))
								{
								if(jQuery(this).parent().hasClass('pp_product_quantity'))
									jQuery(this).parent().find('input[name="set_quantity"]').val('static');
								if(jQuery(this).parent().hasClass('pp_product_amount'))
									jQuery(this).parent().find('input[name="set_amount"]').val('static');
									
								
								jQuery(this).parent().find('input[type="text"]').removeClass('hidden')
								jQuery(this).parent().find('select').addClass('hidden')
								}
							else
								{
								if(jQuery(this).parent().hasClass('pp_product_quantity'))
									jQuery(this).parent().find('input[name="set_quantity"]').val('map');
								if(jQuery(this).parent().hasClass('pp_product_amount'))
									jQuery(this).parent().find('input[name="set_amount"]').val('map');
									
									
								jQuery(this).parent().find('select').removeClass('hidden')
								jQuery(this).parent().find('input[type="text"]').addClass('hidden')
								}
							}
					}
				)
	jQuery(document).on('click', '#add_paypal_product', function()
					{
					var pp_clone = jQuery('.paypal_product_clone').clone();
					pp_clone.removeClass('hidden').removeClass('paypal_product_clone').addClass('paypal_product');

					jQuery('.paypal_products').append(pp_clone);
					
					pp_clone.find('.product_number').text(jQuery('.paypal_products .paypal_product').size());
					
					jQuery(".paypal_products").animate(
							{
							scrollTop:(jQuery(".paypal_product").height()*jQuery('.paypal_products .paypal_product').size())+200
							},500
						);
					
			
					var set_current_fields_math_logic = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_math_logic += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_math_logic += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
					
						set_current_fields_math_logic += '<optgroup label="Hidden Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="hidden"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						
						
					pp_clone.find('select').html(set_current_fields_math_logic);
		
					
					
					}
				);
			jQuery(document).on('click', ".remove_paypal_product",
		function()
			{	
			
					jQuery('.remove_paypal_product').remove('btn-primary');
					jQuery(this).closest('.paypal_product').remove();
					jQuery('.paypal_products .paypal_product').each(
						function(index)
							{
							jQuery(this).find('.product_number').text(index+1);
							}
						);
					}
				);
	
	
	
	jQuery('.form_field.grid').each(
		function()
			{
			var panel = jQuery(this).find('.panel-body');
			create_droppable(panel)
			}
		);
	
	setTimeout(function()
		{
		jQuery('div.nex-forms-container .form_field').each(
			function(index)
				{
				setup_form_element(jQuery(this))
				}
			);
		},200);
	
	}
);


function nf_count_multi_steps(){
	var total_steps = jQuery('.nex-forms-container .form_field.step').size();
	var set_steps = '<option selected="selected" value="0">All steps (' +total_steps+ ')</option>';
	var set_breadcrumb = '';
	
	jQuery('.nex-forms-container .form_field.step').each(
		function(index, element)
			{
			jQuery(this).addClass('nf_multi_step_'+(index+1));
			set_steps += '<option selected="selected" value="'+ (index+1) +'">Step '+ (index+1) +' / ' + total_steps +  '</option>';
			
	  		
			if(!jQuery(this).attr('data-step-name'))
				jQuery(this).attr('data-step-name','Step '+ (index+1) );

			jQuery(this).attr('data-step-num', (index+1) );	
			
			
			set_breadcrumb += '<li><a data-show-step="'+ (index+1) +'">'+ jQuery(this).attr('data-step-name') +'</a></li>';
			
				
			if(!jQuery(this).find('.btn-clipboard .the_step_number').attr('class'))
				{
				jQuery(this).find('.btn-clipboard').html('<span class="badge the_step_number">Step '+ (index+1) +' / ' + total_steps +  '</span>&nbsp;<div class="btn btn-default btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>');
				}
			else
				{
				jQuery(this).find('.the_step_number').html('<input name="multi_step_name" type="text" class="form_control" value="'+ jQuery(this).attr('data-step-name') +'">' );
				jQuery(this).addClass('nf_multi_step_'+(index+1))
				}
			}
		);
		
	set_breadcrumb += '<li class="new_step"><a><span class="fa fa-plus"></span></a></li>';
	jQuery('select[name="skip_to_step"]').html(set_steps);
	jQuery('.nf_step_breadcrumb ol').html(set_breadcrumb);
	
	jQuery('.nf_step_breadcrumb ul.show_all_steps').remove();
	
	jQuery('.nf_step_breadcrumb ol').before('<ul class="show_all_steps"><li class="current all_steps"><a data-show-step="all">All ('+ total_steps +')</a></li></ul>');
	
	
}
function nf_reset_multi_steps(){
		for(var i=0;i<30;i++)
			jQuery('.nex-forms-container .form_field.step').removeClass('nf_multi_step_'+(i))
			
		/*jQuery('.nex-forms-container .form_field.step').each(function(index, element) {
		  jQuery(this).find('.the_step_number').html('Step '+ (index+1));
		  jQuery(this).addClass('nf_multi_step_'+(index+1))
        });*/
}

function nf_save_nex_form(form_id,form_status, clicked_obj)
	{
	var set_form_id = 0;
	clicked_obj.find('.waves-ripple').remove();
	
	if(jQuery('.ui-nex-forms-container .jq-datepicker').attr('class')!='')
		jQuery('.ui-nex-forms-container .jq-datepicker input').datepicker("destroy")
	
	if(jQuery('.ui-nex-forms-container .jq-radio-group').attr('class')!='')
		jQuery('.ui-nex-forms-container .jq-radio-group input').checkboxradio("destroy");
	if(jQuery('.ui-nex-forms-container .jq-check-group').attr('class')!='')
		jQuery('.ui-nex-forms-container .jq-check-group input').checkboxradio("destroy");
		
	if(jQuery('.ui-nex-forms-container .jq_select').attr('class')!='')
		jQuery('.ui-nex-forms-container select.jq_select').selectmenu('destroy');
	
	var text_before_save = clicked_obj.html();
	
	
	clicked_obj.addClass('saving_btn');
	
	clicked_obj.html('<span class="fa fa-spin fa-refresh"></span>');
	
	tinyMCE.triggerSave();	
		
	if(jQuery('#form_name').val()=='')
			{
			//jQuery('#form_name').popover('show');
			//setTimeout(function(){jQuery('#form_name').popover('hide'); jQuery('#form_name').popover('destroy');},2000)
			return;
			}
		
		jQuery('div.nex-forms-container .edit_mask').remove();
		
		jQuery('div.admin_html').html(jQuery('div.nex-forms-container').html())
		jQuery('div.clean_html').html(jQuery('div.nex-forms-container').html())
		
		clean_html = jQuery('div.clean_html');
		admin_html = jQuery('div.admin_html');
		
		
		
		
		//admin_html.find('.form_field').attr('style','');
		admin_html.find('.form_field').css('visibility','');
		admin_html.find('.form_field').css('display','');
		admin_html.find('.btn-lg.move_field').remove();
		admin_html.find('#slider').html('');
		
		admin_html.find('#slider').html('');
		
		admin_html.find('.the-thumb').removeClass('text-danger').removeClass('text-success').removeClass('checked');
		admin_html.find('.js-signature canvas').remove();
		admin_html.find('#star' ).html('');
		admin_html.find('.bootstrap-touchspin-postfix').remove();
		admin_html.find('.bootstrap-touchspin .input-group-btn').remove();
		admin_html.find('.bootstrap-touchspin .input-group-btn-vertical').remove();
		admin_html.find('.bootstrap-tagsinput').remove();
		admin_html.find('#spinner').unwrap();
		
		admin_html.find('.bootstrap-tagsinput').remove();
		admin_html.find('.popover').remove();
		admin_html.find('div.cd-dropdown').remove();
		admin_html.find('.form_field').removeClass('edit-field').removeClass('currently_editing');
		admin_html.find('.bootstrap-select').remove();
		admin_html.find('.popover').remove();
		admin_html.find('.step').removeClass('active_step');
		
		var hidden_fields = '';	
		jQuery('.hidden_fields_setup .hidden_fields .hidden_field').each(
			function()
				{
				hidden_fields += jQuery(this).find('input.field_name').val();
				hidden_fields += '[split]';
				hidden_fields += jQuery(this).find('input.field_value').val();
				hidden_fields += '[end]';
				}
			);
		
		var form_hidden_fields = []; 
		
		jQuery('.hidden_fields_setup .hidden_fields .hidden_field').each(
			function()
				{
				form_hidden_fields.push(
						{
						field_name: jQuery(this).find('input.field_name').val(),
						field_value: jQuery(this).find('input.field_value').val(),
						}
					);
				}
			);	
			
	
			
			
				
		
		var mc_field_map = '';	
		jQuery('.mc_field_map .mc-form-field').each(
			function()
				{
				mc_field_map += jQuery(this).attr('data-field-tag');
				mc_field_map += '[split]';
				mc_field_map += jQuery(this).find('select').attr('data-selected');
				mc_field_map += '[end]';
				}
			);
			
		var gr_field_map = '';	
		jQuery('.gr_field_map .gr-form-field').each(
			function()
				{
				gr_field_map += jQuery(this).attr('data-field-tag');
				gr_field_map += '[split]';
				gr_field_map += jQuery(this).find('select').attr('data-selected');
				gr_field_map += '[end]';
				}
			);
		
		var ftp_field_map = '';	
		
		jQuery('.ftp_reponse_setup .ftp-attr').each(
			function()
				{
				ftp_field_map += jQuery(this).attr('data-field-tag');
				ftp_field_map += '[split]';
				ftp_field_map += jQuery(this).find('select').attr('data-selected');
				ftp_field_map += '[end]';
				}
			);
		
		jQuery('.ftp_reponse_setup .ftp-form-field').each(
			function()
				{
				ftp_field_map += jQuery(this).attr('data-field-tag');
				ftp_field_map += '[split]';
				ftp_field_map += jQuery(this).find('select').attr('data-selected');
				ftp_field_map += '[end]';
				}
			);
		
		
		var cl_array = '';
								
								jQuery('.set_rules .new_rule').each(
									function(index)
										{
										
										cl_array += '[start_rule]';
											
											//OPERATOR
											cl_array += '[operator]';
												cl_array += jQuery(this).find('select[name="selector"]').val() + '##' + jQuery(this).find('select[name="reverse_actions"] option:selected').val();
											cl_array += '[end_operator]';
											
											//CONDITIONS
											cl_array += '[conditions]';
											jQuery(this).find('.get_rule_conditions .the_rule_conditions').each(
												function(index)
													{
													cl_array += '[new_condition]';
														cl_array += '[field]';
															cl_array += jQuery(this).find('.cl_field').val();
														cl_array += '[end_field]';
														cl_array += '[field_condition]';
															cl_array += jQuery(this).find('select[name="field_condition"]').val();
														cl_array += '[end_field_condition]';
														cl_array += '[value]';
															cl_array += jQuery(this).find('input[name="conditional_value"]').val();
														cl_array += '[end_value]';
													cl_array += '[end_new_condition]';
													}
												);
											cl_array += '[end_conditions]';
											
											//ACTIONS
											cl_array += '[actions]';
											jQuery(this).find('.get_rule_actions .the_rule_actions').each(
												function(index)
													{
													cl_array += '[new_action]';
														cl_array += '[the_action]';
															cl_array += jQuery(this).find('select[name="the_action"]').val();
														cl_array += '[end_the_action]';
														cl_array += '[field_to_action]';
															cl_array += jQuery(this).find('select[name="cla_field"]').val();
														cl_array += '[end_field_to_action]';
													cl_array += '[end_new_action]';
													}
												);
											cl_array += '[end_actions]';
											
									
											
																					
										cl_array += '[end_rule]';
										
										
										}
									);
									
		
		if(jQuery('.set_rules .new_rule').size()>0)
			var cl_rule_array = [];
		else
			var cl_rule_array = '';
		
		var cl_actions_array = [];
		var cl_conditions_array = [];
								
								jQuery('.set_rules .new_rule').each(
									function(index)
										{
										
										var cl_actions_array = [];
										var cl_conditions_array = [];
										
										jQuery(this).find('.get_rule_conditions .the_rule_conditions').each(
											function(index)
												{
												
												cl_conditions_array.push(
														{
														field_Id: jQuery(this).find('.cl_field option:selected').attr('data-field-id'),
														field_name: jQuery(this).find('.cl_field option:selected').attr('data-field-name'),
														field_type: jQuery(this).find('.cl_field option:selected').attr('data-field-type'),
														condition: jQuery(this).find('select[name="field_condition"]').val(),
														condition_value: jQuery(this).find('input[name="conditional_value"]').val(),
														selected_value: jQuery(this).find('.cl_field').val()
														}
													);
													
												
												/*cl_array += '[new_condition]';
													cl_array += '[field]';
														cl_array += jQuery(this).find('.cl_field').val();
													cl_array += '[end_field]';
													cl_array += '[field_condition]';
														cl_array += jQuery(this).find('select[name="field_condition"]').val();
													cl_array += '[end_field_condition]';
													cl_array += '[value]';
														cl_array += jQuery(this).find('input[name="conditional_value"]').val();
													cl_array += '[end_value]';
												cl_array += '[end_new_condition]';*/
												}
											);
											
											jQuery(this).find('.get_rule_actions .the_rule_actions').each(
												function(index)
													{
													
													if(jQuery(this).find('select[name="the_action"]').val()=='show')
														{
														clean_html.find('#'+ jQuery(this).find('select[name="cla_field"] option:selected').attr('data-field-id')).hide().addClass('hidden');
														//console.log(clean_html.find('#'+ jQuery(this).find('select[name="cla_field"] option:selected').attr('data-field-id')).attr('id'));
														}
													cl_actions_array.push(
														{
														target_field_Id: jQuery(this).find('select[name="cla_field"] option:selected').attr('data-field-id'),
														target_field_name: jQuery(this).find('select[name="cla_field"] option:selected').attr('data-field-name'),
														target_field_type: jQuery(this).find('select[name="cla_field"] option:selected').attr('data-field-type'),
														do_action: jQuery(this).find('select[name="the_action"]').val(),
														selected_value: jQuery(this).find('select[name="cla_field"]').val(),
														}
													);	
														
													/*cl_array += '[new_action]';
														cl_array += '[the_action]';
															cl_array += jQuery(this).find('select[name="the_action"]').val();
														cl_array += '[end_the_action]';
														cl_array += '[field_to_action]';
															cl_array += jQuery(this).find('select[name="cla_field"]').val();
														cl_array += '[end_field_to_action]';
													cl_array += '[end_new_action]';*/
													}
												);
											/*cl_array += '[end_actions]';
											
									
											
																					
										cl_array += '[end_rule]';*/
										
										
										cl_rule_array.push(
												{
												operator: jQuery(this).find('select[name="selector"]').val(),
												reverse_actions: jQuery(this).find('select[name="reverse_actions"] option:selected').val(),
												conditions: cl_conditions_array,
												actions: cl_actions_array
												}
											)
										
										}
									);
		
		
		
		
				
	var product_array = '';
								
								jQuery('.paypal_products .paypal_product').each(
									function(index)
										{
										
										product_array += '[start_product]';
										
											product_array += '[item_name]';
												product_array += jQuery(this).find('input[name="item_name"]').val();
											product_array += '[end_item_name]';
											
											product_array += '[item_qty]';
												product_array += jQuery(this).find('input[name="item_quantity"]').val();
											product_array += '[end_item_qty]';
											
											product_array += '[map_item_qty]';
												product_array += jQuery(this).find('select[name="map_item_quantity"]').val();
											product_array += '[end_map_item_qty]';
											
											product_array += '[set_quantity]';
												product_array += jQuery(this).find('input[name="set_quantity"]').val();
											product_array += '[end_set_quantity]';
											
											product_array += '[item_amount]';
												product_array += jQuery(this).find('input[name="item_amount"]').val();
											product_array += '[end_item_amount]';
											
											product_array += '[map_item_amount]';
												product_array += jQuery(this).find('select[name="map_item_amount"]').val();
											product_array += '[end_map_item_amount]';
											
											product_array += '[set_amount]';
												product_array += jQuery(this).find('input[name="set_amount"]').val();
											product_array += '[end_set_amount]';
																					
										product_array += '[end_product]';
										
										
										}
									);		
	//jQuery('.nex-forms-field-settings').removeClass('opened');
	//jQuery('.form_field').removeClass('currently_editing');
	jQuery('.current_id').text('');
	
	
	
	
	clean_html.find('.form_field').css('visibility','');
	clean_html.find('.form_field').css('display','');
	clean_html.find('.btn-lg.move_field').remove();
	clean_html.find('#star' ).raty('destroy');	
	clean_html.find('.the-thumb').removeClass('text-danger').removeClass('text-success').removeClass('checked');
	clean_html.find('.js-signature canvas').remove();	
	clean_html.find('.zero-clipboard, div.ui-nex-forms-container .field_settings').remove();
	clean_html.find('.grid').removeClass('grid-system')		
	clean_html.find('.editing-field-container').removeClass('.editing-field-container')
	clean_html.find('.bootstrap-touchspin-prefix').remove();
	//clean_html.find('.bootstrap-select').remove();
	clean_html.find('.bootstrap-touchspin-postfix').remove();
	clean_html.find('.bootstrap-touchspin .input-group-btn').remove();
	clean_html.find('.bootstrap-touchspin .input-group-btn-vertical').remove();
	clean_html.find('.bootstrap-tagsinput').remove();
	clean_html.find('#spinner').unwrap();
	
	//clean_html.find('div#the-radios input').prop('checked',false);
	//clean_html.find('div#the-radios a').attr('class','');
	clean_html.find('.editing-field').removeClass('editing-field')
	clean_html.find('.editing-field-container').removeClass('.editing-field-container')
	clean_html.find('div.trash-can').remove();
	clean_html.find('div.draggable_object').hide();
	clean_html.find('div.draggable_object').remove();
	clean_html.find('div.form_field').removeClass('field').removeClass('currently_editing');
	clean_html.find('.zero-clipboard').remove();
	clean_html.find('.tab-pane').removeClass('tab-pane');	
	clean_html.find('.help-block.hidden, .is_required.hidden').remove();
	clean_html.find('.has-pretty-child, .slider').removeClass('svg_ready')
	clean_html.find('.input-group').removeClass('date');
	clean_html.find('.popover').remove();
	
	/*clean_html.find('select.material_select').material_select('destroy');
	clean_html.find('select.material_select').removeClass('initialized');
	*/

	clean_html.find('.the_input_element, .row, .svg_ready, .radio-inline').each(
		function()
			{
			if(jQuery(this).parent().hasClass('input-inner') || jQuery(this).parent().hasClass('input_holder')){
				jQuery(this).unwrap();
				}	
			}
		);
	clean_html.find('.form_field').each(
		function()
			{
			obj = jQuery(this);
			clean_html.find('.customcon').each(
					function()
						{
						if(obj.attr('id')==jQuery(this).attr('data-target') && (jQuery(this).attr('data-action')=='show' || jQuery(this).attr('data-action')=='slideDown' || jQuery(this).attr('data-action')=='fadeIn'))
							clean_html.find('#'+obj.attr('id')).hide();
						}
					);
				}
			);
	clean_html.find('div').each(
		function()
			{
			if(jQuery(this).parent().hasClass('svg_ready') || jQuery(this).parent().hasClass('form_object') || jQuery(this).parent().hasClass('input-inner')){
				jQuery(this).unwrap();
				}
			}
		);
	clean_html.find('div.form_field').each(
		function()
			{
			if(jQuery(this).parent().parent().hasClass('panel-default') && !jQuery(this).parent().prev('div').hasClass('panel-heading')){
				jQuery(this).parent().unwrap();
				jQuery(this).unwrap();
				}
			}

		);
		
	clean_html.find('.help-block').each(
		function()
			{
			if(!jQuery(this).text())
				jQuery(this).remove()
			}
		);
	clean_html.find('.sub-text').each(
		function()
			{
			if(jQuery(this).text()=='')
				{
				jQuery(this).parent().find('br').remove()
				jQuery(this).remove();
				}
			}
		);
	clean_html.find('.label_container').each(
		function()
			{
			if(jQuery(this).css('display')=='none')
				{
				//jQuery(this).parent().find('.input_container').addClass('full_width');
				jQuery(this).remove()
				}
			}
		);
	clean_html.find('.ui-draggable').removeClass('ui-draggable');
	clean_html.find('.ui-draggable-handle').removeClass('ui-draggable-handle')
	clean_html.find('.dropped').removeClass('dropped')
	clean_html.find('.ui-sortable-handle').removeClass('ui-sortable-handle');
	clean_html.find('.ui-sortable').removeClass('ui-sortable-handle');
	clean_html.find('.ui-droppable').removeClass('ui-sortable-handle');
	clean_html.find('.over').removeClass('ui-sortable-handle');
	clean_html.find('.the_input_element.bs-tooltip').removeClass('bs-tooltip') 
	clean_html.find('.bs-tooltip.glyphicon').removeClass('glyphicon');
	clean_html.find('.grid-system.panel').removeClass('panel-body');
	clean_html.find('.grid-system.panel').removeClass('panel');
	clean_html.find('.form_field.grid').removeClass('grid').removeClass('form_field').addClass('is_grid');
	clean_html.find('.grid-system').removeClass('grid-system');
	clean_html.find('.move_field').remove();
	clean_html.find('.input-group-addon.btn-file span').attr('class','fa fa-cloud-upload');
	clean_html.find('.input-group-addon.fileinput-exists span').attr('class','fa fa-close');
	clean_html.find('.checkbox-inline').addClass('radio-inline');
	clean_html.find('.check-group').addClass('radio-group');
	clean_html.find('.submit-button br').remove();
	clean_html.find('.submit-button small.svg_ready').remove();
	clean_html.find('.radio-group a, .check-group a').addClass('ui-state-default')
	clean_html.find('.is_grid .panel-body').removeClass('ui-widget-content');
	clean_html.find('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	//clean_html.find('.bootstrap-select').removeClass('form-control').addClass('full_width');
	clean_html.find('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default');
	clean_html.find('.selectpicker').removeClass('dropdown-toggle')
	clean_html.find('.is_grid .panel-body').removeClass('ui-widget-content');
	clean_html.find('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	clean_html.find('.is_grid .panel-body').removeClass('ui-sortable').removeClass('ui-droppable').removeClass('ui-widget-content').removeClass('');
	clean_html.find('.step').hide()
	clean_html.find('.step').first().show();
	clean_html.find('.step').removeClass('active_step');
	
	clean_html.find('.is_grid').css('z-index','');	
	
	var get_multistep_html = jQuery('.nf_step_breadcrumb');
	
	var multistep_html = get_multistep_html.clone();
	
	if(clean_html.find('.step').size()<2)
		multistep_html.find('ol').addClass('hidden');
	
	multistep_html.find('ul.show_all_steps').remove(); 
	multistep_html.find('li.new_step').remove(); 
	multistep_html.find('.current').removeClass('current'); 
	multistep_html.find('li').first().addClass('current');
	
	var md_theme = []; 
	md_theme.push(
			{
			theme_name: jQuery('select[name="md_theme_selection"]').val(),
			theme_shade: jQuery('select[name="md_theme_shade_selection"]').val(),
			}
		);
	var multistep_settings = [];	
	multistep_settings.push(
			{
			breadcrumb_type:jQuery('.nf_step_breadcrumb ol').attr('data-breadcrumb-type'),
			text_pos: jQuery('.nf_step_breadcrumb ol').attr('data-text-pos'),
			data_theme: jQuery('.nf_step_breadcrumb ol').attr('data-theme'),
			show_front_end: jQuery('.nf_step_breadcrumb ol').attr('data-show-front-end'),
			show_inside: jQuery('.nf_step_breadcrumb ol').attr('data-show-inside'),
			}
		);

		var take_action = 'nf_insert_record';
		
		if(jQuery('#form_update_id').text() || form_id)
			take_action = 'nf_update_record'
		if(form_status == 'preview')
			take_action = 'preview_nex_form'
		if(form_status == 'draft')
			take_action = 'nf_update_draft'
	    var active_mail_subscriptions = '';
		
	if(jQuery('input[name="mc_integration"]:checked').val()=='1')
		active_mail_subscriptions += 'mc,';
	if(jQuery('input[name="gr_integration"]:checked').val()=='1')
		active_mail_subscriptions += 'gr,';
		
		
		
		
	 var pdf_attachements = '';
	if(jQuery('input[name="pdf_admin_attach"]:checked').val()=='1')
		pdf_attachements += 'admin,';
	if(jQuery('input[name="pdf_user_attach"]:checked').val()=='1')
		pdf_attachements += 'user,';
	jQuery( ".ui-nex-forms-container .jq-radio-group input" ).checkboxradio();
	jQuery( ".ui-nex-forms-container .jq-check-group input" ).checkboxradio();

	jQuery('.ui-nex-forms-container .jq-datepicker input').datepicker();
	
	jQuery('.ui-nex-forms-container select.jq_select').selectmenu();
		//clicked.html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Saving...')
			var data =
				{
				action	 							: take_action,
				table								: 'wap_nex_forms',
				edit_Id								: (form_id) ? form_id : jQuery('#form_update_id').text().trim(),
				plugin								: 'shared',
				title								: jQuery('#form_name').val(),
				form_fields							: admin_html.html(),
				clean_html							: clean_html.html(),
				is_form								: form_status,
				is_template							: '0',
				post_type							: jQuery('input[name="form_post_method"]:checked').val(),
				post_action							: jQuery('input[name="form_post_action"]:checked').val(),
				custom_url							: jQuery('#on_form_submission_custum_url').val(),
				mail_to								: jQuery('#nex_autoresponder_recipients').val(),
				from_address						: jQuery('#nex_autoresponder_from_address').val(),
				from_name							: jQuery('#nex_autoresponder_from_name').val(),
				on_screen_confirmation_message		: jQuery('#on_screen_message').val(),
				google_analytics_conversion_code	: jQuery('#google_analytics_conversion_code').val(),
				confirmation_page					: jQuery('#nex_autoresponder_confirmation_page').val(),
				user_email_field					: jQuery('#nex_autoresponder_user_email_field').attr('data-selected'),
				confirmation_mail_subject			: jQuery('#nex_autoresponder_confirmation_mail_subject').val(),
				user_confirmation_mail_subject		: jQuery('#nex_autoresponder_user_confirmation_mail_subject').val(),
				confirmation_mail_body				:  jQuery('#user_email_body_content').val(),
				on_form_submission					: jQuery('input[name="on_form_submission"]:checked').val(),
				form_hidden_fields					: form_hidden_fields,
				hidden_fields						: form_hidden_fields,
				conditional_logic					: cl_array,
				conditional_logic_array				: cl_rule_array,
				admin_email_body					: jQuery('#admin_email_body_content').val(),
				bcc									: jQuery('#nex_admin_bcc_recipients').val(),
				bcc_user_mail						: jQuery('#nex_autoresponder_bcc_recipients').val(),
				custom_css							: jQuery('#custom_css').val(),
				is_paypal							: jQuery('input[name="go_to_paypal"]:checked').val(),
				form_type							: jQuery('.form_attr .form_type').text(),
				draft_Id							: 0,
				products							: product_array,
				currency_code						: (jQuery('.paypal-column select[name="currency_code"]').val()) ? jQuery('.paypal-column select[name="currency_code"]').val() : 'USD',
				business							: jQuery('.paypal-column input[name="business"]').val(),
				cmd									: '_cart',
				return_url							: jQuery('.paypal-column input[name="return"]').val(),
				cancel_url							: jQuery('.paypal-column input[name="cancel_url"]').val(),
				lc									: (jQuery('.paypal-column select[name="paypal_language_selection"]').val()) ? jQuery('.paypal-column select[name="paypal_language_selection"]').val() : 'US',
				environment							: jQuery('input[name="paypal_environment"]:checked').val(),
				mc_field_map						: mc_field_map,
				mc_list_id							: jQuery('select[name="mail_chimp_lists"]').attr('data-selected'),
				gr_field_map						: gr_field_map,
				gr_list_id							: jQuery('select[name="get_response_lists"]').attr('data-selected'),
				email_subscription					: active_mail_subscriptions,
				//email_on_payment_success			: (jQuery('.slide_in_paypal_setup input[name="email_on_payment_success"]:checked').val()) ? jQuery('.slide_in_paypal_setup  input[name="email_on_payment_success"]:checked').val() : 'no'
				pdf_html							: jQuery('#pdf_html').val(),
				attach_pdf_to_email					: pdf_attachements,
				form_to_post_map					: ftp_field_map,
				is_form_to_post						: jQuery('.ftp_reponse_setup input[name="ftp_integration"]:checked').val(),
				md_theme							: md_theme,
				form_theme							: jQuery('.set_form_theme').attr('data-selected'),
				jq_theme							: jQuery('.choose_form_theme').attr('data-selected'),
				form_style							: jQuery('.nex-forms-container').attr('style'),
				multistep_settings					: multistep_settings,
				multistep_html						: multistep_html.html(),
				};
				
			if(clicked_obj.hasClass('is_template'))
				{
				data.is_form = '0';
				data.is_template = '1';
				data.action = 'nf_insert_record';
				
				if(jQuery('#form_type').text()=='template')
					{
					data.action = 'nf_update_record';	
					}
				
				var is_template = '1';
				}
			else
				{
				if(jQuery('#form_type').text()=='template')
					{
					data.action = 'nf_insert_record';	
					}
				
				data.is_template = '0';
				var is_template = '0';
				}
			
			jQuery('.form_preview_loader').show();
			jQuery('.show_form_preview').hide();
			
			if(form_status=='preview')
				jQuery('#preview_popup').modal('open');
			
			clicked_obj.html();
			clearTimeout(timer);				
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('.ns').remove();
					if(form_status=='preview')
						{
						jQuery('.show_form_preview').attr('src',jQuery('.site_url').text() + '/wp-admin/admin.php?page=nex-forms-preview&form_Id='+response);
						clicked_obj.html(text_before_save);				
				//var url = jQuery('.admin_url').text() + 'admin.php?page=nex-forms-preview&form_Id=' + jQuery('#form_update_id').text();
				//jQuery('.show_form_preview').attr('src',url);
						
						//jQuery('.form_update_id').text(response.trim())
						//loading_nex_forms_preview();
						setTimeout(
								function()
									{
									jQuery('.form_preview_loader').hide();
									jQuery('.show_form_preview').show();
									}
									,3000
								);
						jQuery('div.clean_html').html('');	
						}
					else
						{
						jQuery('div.clean_html').html('');
						jQuery('div.admin_html').html('');
						//setTimeout(function(){ clicked.html(current_button);},1500);
						
							if(is_template=='1')
								{
								popup_user_alert('Template Saved');
								jQuery('.save_nex_form.is_template').removeClass('saving').html('Update Template');
								}
							else
								{
								if(jQuery('#form_update_id').text())
									{
									if(jQuery('#form_type').text()=='template')
										{
										popup_user_alert('New Form Created');
										jQuery('.save_nex_form.is_template').removeClass('saving').html('Save as template');
										}
									else
										{
										//popup_user_alert('Form Saved');
										
										jQuery('.prime_save').removeClass('saving');
										jQuery('.prime_save').addClass('flip_btn');
										
										jQuery('.prime_save').html('<span class="fa fa-floppy-o"></span>&nbsp;&nbsp;SAVED!');
										
										setTimeout(function(){ jQuery('.prime_save').html('<span class="fa fa-floppy-o"></span>&nbsp;&nbsp;SAVE'); jQuery('.prime_save').removeClass('flip_btn'); },2000);
										
										}
									}
								else
									{
									popup_user_alert('New Form Created');
									jQuery('.prime_save').html('<span class="fa fa-floppy-o"></span>&nbsp;&nbsp;UPDATE');
									}
								}
							
							
						/*jQuery('.toolbar .form-entries').removeClass('disabled');
						jQuery('.toolbar .export-csv').removeClass('disabled');
						jQuery('.toolbar .export-pdf').removeClass('disabled');
						jQuery('.toolbar .form-embed').removeClass('disabled');
						jQuery('#export_current_form').removeClass('disabled');*/
						
						//clicked_obj.html(text_before_save);				
						if(response)
							{
							if(!is_template || is_template==0 || form_status!='draft')
								{
								jQuery('#form_update_id').text(response.trim())
								
								}
							jQuery('.check_save').removeClass('not_saved');
							
							/*jQuery('#export_current_form').attr('href',jQuery('.admin_url').text()+ 'admin.php?page=nex-forms-main&nex_forms_Id='+ response.trim() +'&export_form=true');
							jQuery('.toolbar .export-csv').attr('href',jQuery('.admin_url').text()+ 'admin.php?page=nex-forms-main&nex_forms_Id='+ response.trim() +'&export_csv=true');
							jQuery('form[name="do_csv_export"] input[name="nex_forms_Id"]').val(response.trim());*/
							}
						}
					}
				);	
			
	}


function popup_user_alert(msg){
	
	Materialize.toast(msg, 2000, 'toast-success');
}

function possible_email_fields(){
	var posible_email_fields = '<option value="">Dont send confirmation mail to user</option>';	
	var has_email_fields = false;
	jQuery('div.nex-forms-container div.form_field input.email').each(
			function()
				{
				has_email_fields = true;
				posible_email_fields += '<option value="'+  jQuery(this).attr('name') +'" '+ ((jQuery('.nex_form_attr .user_email_field').text()==jQuery(this).attr('name')) ? 'selected="selected"' : '') +' >'+ jQuery(this).closest('div.form_field').find('.the_label').text() +'</option>';
				}
			);
	jQuery('select[name="posible_email_fields"]').html(posible_email_fields);	
}

function update_select(the_class){
	jQuery('select'+ the_class +' option').each(
		function()
			{
			var get_selected = jQuery(this).closest('select');
			
			
			if(jQuery(this).val()==get_selected.attr('data-selected'))
				{
				jQuery(this).attr('selected','selected');
				jQuery(this).trigger('click');
				}
			}
		);	
}

function nf_apply_font(obj, selector){	

	  if(jQuery('select[name="'+ selector +'"]').val()=='')
	  	{
			obj.css('font-family','');
			return;
		}

	  var font = JSON.parse( jQuery('select[name="'+ selector +'"]').val() )
	  obj.css('font-family', font.family);
	  
	  if ( 'undefined' !== font.name ) {
			if(!jQuery('link[id="'+ format_illegal_chars(font.name) +'"]').length>0)
				jQuery( '<link id="'+format_illegal_chars(font.name)+'" type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family='+ font.name +'">').appendTo( '.nex-forms-container' );
		}
	  
}


function set_mc_field_map(){
	var set_current_fields_paypal = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_paypal += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_paypal += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						set_current_fields_paypal += '<optgroup label="Hidden Fields">';
							set_current_fields_paypal += jQuery('.hidden_form_fields').html()
						set_current_fields_paypal += '</optgroup>';
						
						
					jQuery('.mc_field_map').find('select').html(set_current_fields_paypal);
					
					jQuery('.mc_field_map').find('select option').each(
						function()
							{
							var get_selected = jQuery(this).closest('select');
							if(jQuery(this).val()==get_selected.attr('data-selected'))
								{
								jQuery(this).attr('selected','selected');
								}
							}
						);
}


function set_gr_field_map(){
	var set_current_fields_paypal = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_paypal += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_paypal += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						set_current_fields_paypal += '<optgroup label="Hidden Fields">';
							set_current_fields_paypal += jQuery('.hidden_form_fields').html()
						set_current_fields_paypal += '</optgroup>';
						
						
						
						
					jQuery('.gr_field_map').find('select').html(set_current_fields_paypal);
					
					jQuery('.gr_field_map').find('select option').each(
						function()
							{
							var get_selected = jQuery(this).closest('select');
							if(jQuery(this).val()==get_selected.attr('data-selected'))
								{
								jQuery(this).attr('selected','selected');
								}
							}
						);
}

function set_ftp_field_map(){
	var set_current_fields_paypal = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_paypal += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_paypal += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="File Uploaders">';
						jQuery('div.nex-forms-container div.form_field input[type="file"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						
						set_current_fields_paypal += '<optgroup label="Hidden Fields">';
							set_current_fields_paypal += jQuery('.hidden_form_fields').html()
						set_current_fields_paypal += '</optgroup>';
						
						
					jQuery('.ftp-form-field').find('select').html(set_current_fields_paypal);
					
					jQuery('.ftp-form-field').find('select option').each(
						function()
							{
							var get_selected = jQuery(this).closest('select');
							if(jQuery(this).val()==get_selected.attr('data-selected'))
								{
								jQuery(this).attr('selected','selected');
								}
							}
						);
}


function set_paypal_fields(){
	var set_current_fields_paypal = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_paypal += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_paypal += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
						
						set_current_fields_paypal += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += '</optgroup>';
					
						set_current_fields_paypal += '<optgroup label="Hidden Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="hidden"]').each(
							function()
								{
								set_current_fields_paypal += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_paypal += jQuery('.hidden_form_fields').html()
						set_current_fields_paypal += '</optgroup>';
						
						
						
					jQuery('.paypal_products').find('select').html(set_current_fields_paypal);
					
					jQuery('.paypal-column').find('select option').each(
						function()
							{
							var get_selected = jQuery(this).closest('select');
							if(jQuery(this).val()==get_selected.attr('data-selected'))
								{
								jQuery(this).attr('selected','selected');
								}
							}
						);
}



function setup_tags(){
	
	var tag_str = '';
	var old_radio = '';
	var new_radio = '';
	
	tag_str += '<li class="tiny_menu_head"><strong>Default tags</strong></li>';
	
	
	tag_str += '<li><a class="item" element="tag" code="nf_form_data" href="#">Form Data Table</a></li>';
	tag_str += '<li><a class="item" element="tag" code="nf_from_page" href="#">From Page</a></li>';
	tag_str += '<li><a class="item" element="tag" code="nf_form_title" href="#">Form Title</a></li>';
	tag_str += '<li><a class="item" element="tag" code="nf_user_name" href="#">Username</a></li>';
	tag_str += '<li><a class="item" element="tag" code="nf_user_ip" href="#">User IP</a></li>';
	
	
	tag_str += '<li class="tiny_menu_head"><strong>Field tags</strong></li>';
	
	jQuery('div.nex-forms-container div.form_field input.the_input_element').each(
		function()	
			{
			var input_name	 = 	jQuery(this).attr('name');	
			var input_type	 = 	jQuery(this).attr('type');	
			//tag_str += '<input class="tag_val  form-control" onClick="this.select();" value="{{' + input_name + '}}">';
			if(input_type=='radio' || input_type=='checkbox')
				{
				old_radio = jQuery(this).attr('name');
				if(old_radio != new_radio)
					tag_str += '<li><a class="item" element="tag" code="'+ input_name +'" href="#">'+ unformat_name(input_name) +'</a></li>';
				new_radio = old_radio;
				}
			else
				{
				tag_str += '<li><a class="item" element="tag" code="'+ input_name +'" href="#">'+ unformat_name(input_name) +'</a></li>';
				}
			}
		);
	
	jQuery('div.nex-forms-container div.form_field select.the_input_element').each(
		function()	
			{
			var input_name	 = 	jQuery(this).attr('name');	
			tag_str += '<li><a class="item" element="tag" code="'+ input_name +'" href="#">'+ unformat_name(input_name) +'</a></li>';
			}
		);
	
	jQuery('div.nex-forms-container div.form_field textarea.the_input_element').each(
		function()	
			{
			var input_name	 = 	jQuery(this).attr('name');	
			tag_str += '<li><a class="item" element="tag" code="'+ input_name +'" href="#">'+ unformat_name(input_name) +'</a></li>';
			}
		);
	
	
	jQuery('.tiny_button_tags_placeholders').html(	tag_str);	
}



function setup_tags2(){
		var set_email_tags = '';
						set_email_tags += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								
								}
							);	
						set_email_tags += '</optgroup>';
						
						set_email_tags += '<optgroup label="Radio Buttons">';
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_email_tags += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_email_tags += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								var check_name = jQuery(this).attr('name').replace('[]','')
									
								old_check = check_name;
								if(old_check != new_check)
									set_email_tags += '<option value="{{'+ format_illegal_chars(check_name)  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								new_check = old_check;
								}
							);	
						set_email_tags += '</optgroup>';
						
						set_email_tags += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								}
							);	
						set_email_tags += '</optgroup>';
						
						set_email_tags += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								}
							);	
						set_email_tags += '</optgroup>';
						
						
						set_email_tags += '<optgroup label="File Uploaders">';
						jQuery('div.nex-forms-container div.form_field input[type="file"]').each(
							function()
								{
								set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								}
							);	
						set_email_tags += '</optgroup>';
						
						set_email_tags += '<optgroup label="Hidden Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="hidden"]').each(
							function()
								{
								set_email_tags += '<option value="{{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}}">'+ unformat_name(jQuery(this).attr('name')) +'</option>';
								}
							);	
						set_email_tags += jQuery('.hidden_form_fields').html()
						set_email_tags += '</optgroup>';
						
						
						set_email_tags += '<optgroup label="More Tags">';
						set_email_tags += '<option value="{{nf_form_data}}">Form Data Table</option>';
						set_email_tags += '<option value="{{nf_user_ip}}">IP Address</option>';
						set_email_tags += '<option value="{{nf_from_page}}">Page Title</option>';
						set_email_tags += '<option value="{{nf_form_title}}">Form Title</option>';
						set_email_tags += '<option value="{{nf_user_name}}">User Name</option>';
						
					
						
						set_email_tags += '</optgroup>';
						
						
						
					jQuery('select[name="email_field_tags"], select[name="user_email_field_tags"]').html(set_email_tags);
						
	}