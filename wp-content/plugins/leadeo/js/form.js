var leadeo_init_slider, leadeo_init_hidden_label;
(function($) {
	$(document).ready(function(){
		$(".imapper-checkbox-span").disableSelection();
		$(document).on('click','.imapper-checkbox-on',function(){
			if($(this).hasClass('my_disabled'))return;

			$(this).removeClass('inactive');
			$(this).siblings('.imapper-checkbox-off').addClass('inactive');
			$(this).siblings('[type=checkbox]').attr('checked','checked');
			var id=$(this).siblings('[type=checkbox]').attr('id');
			leadeo_checkbox_changed(id, 1);
		});

		$(document).on('click','.imapper-checkbox-off',function(){
			if($(this).hasClass('my_disabled'))return;

			$(this).removeClass('inactive');
			$(this).siblings('.imapper-checkbox-on').addClass('inactive');
			$(this).siblings('[type=checkbox]').removeAttr('checked');
			var id=$(this).siblings('[type=checkbox]').attr('id');
			leadeo_checkbox_changed(id, 0);
		});
		$(document).on('click','.wrap.imapper-admin-wrapper select',function(){
			//console.log($(this));
			// var select = $(this).parent();
			$(this).siblings('span').text($(this).children(":selected").text());
		});


		leadeo_init_hidden_label('');
		leadeo_init_slider('');
	});

	function check_input_field(obj, force_hidden) {
		if (typeof force_hidden=='undefined') force_hidden=false;
		var label=$(obj).attr('data-my-hidden-label');
		if (force_hidden) {$(label).css('visibility', 'hidden'); return;}
		if ($(obj).val()=='') $(label).css('visibility', 'visible');
		else $(label).css('visibility', 'hidden');

	}

	leadeo_init_hidden_label=function(sel) {
		$(sel+'.check-hidden-label').each(function(){
			check_input_field(this);
			$(this).on('focus', function(){
				check_input_field(this, true);
			});
			$(this).on('blur', function(){
				check_input_field(this);
			});
		});
	};

	leadeo_init_slider=function(sel) {
		$(sel+'.imapper-admin-slider').slider({range: "min", max:100, slide: function( event, ui ) {
			$(this).siblings('input').val(ui.value);
		}});

		$(sel+'.imapper-admin-slider').each(function(){
			$(this).slider( "value", $(this).siblings('input').val() );
		});
	};

})(jQuery);