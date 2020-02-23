var eListOptions;
(function($){

	eListOptions = {
		init : function(){
			var rem, the_id, sidebars = $('div.widgets-sortables');

			$( '.et_widget-right .widget-top' ).live( 'click', function() {
				var css = {}, widget = $(this).closest('div.widget'), inside = widget.children('.widget-inside'), w = parseInt( widget.find('input.widget-width').val(), 10 );

				if ( inside.is(':hidden') ) {
					if ( w > 250 && inside.closest('div.widgets-sortables').length ) {
						css['width'] = w + 30 + 'px';
						if ( inside.closest('div.widget-liquid-right').length )
							css[margin] = 235 - w + 'px';
						widget.css(css);
					}

					widget.css( { 'width' : '', height: '' } );
					inside.slideDown('fast');
					widget.addClass( 'open' );
				} else {
					inside.slideUp('fast', function() {
						widget.css({'width':'', margin:''});
						widget.removeClass( 'open' );
					});
				}
				return false;
			});

			$('a.widget-control-close').live('click', function(){
				eListOptions.close( $(this).closest('div.widget') );
				return false;
			});

			$('input.widget-control-save').live('click', function(){
				eListOptions.save( $(this).closest('div.widget'), 0, 1, 0 );
				return false;
			});

			$('a.widget-control-remove').live('click', function(){
				eListOptions.save( $(this).closest('div.widget'), 1, 1, 0 );
				return false;
			});

			$('#widgets-right').children('.widgets-holder-wrap').children('.sidebar-name').click(function(){
				var c = $(this).siblings('.widgets-sortables'), p = $(this).parent();
				if ( !p.hasClass('closed') ) {
					c.sortable('disable');
					p.addClass('closed');
				} else {
					p.removeClass('closed');
					c.sortable('enable').sortable('refresh');
				}
			});

			$('#widget-list').children('.widget').draggable({
				connectToSortable: 'div.widgets-sortables',
				handle: '> .widget-top > .widget-title',
				distance: 2,
				helper: 'clone',
				zIndex: 5,
				containment: 'document',
				start: function(e,ui) {
					//wpWidgets.fixWebkit(1);
					ui.helper.find('div.widget-description').hide();
					the_id = this.id;
				},
				stop: function(e,ui) {
					//if ( rem )
					//	$(rem).hide();
					//rem = '';
					//wpWidgets.fixWebkit();
				}
			});

			sidebars.sortable({
				placeholder: 'widget-placeholder',
				items: '> .widget',
				handle: '> .widget-top > .widget-title',
				cursor: 'move',
				distance: 2,
				containment: 'document',
				start: function(e,ui) {
					//wpWidgets.fixWebkit(1);
					//ui.item.children('.widget-inside').hide();
					//ui.item.css({margin:'', 'width':''});
				},
				stop: function(e,ui) {
					var add = ui.item.find('input.add_new').val(),
						n = ui.item.find('input.multi_number').val(),
						id = the_id,
						sb = $(this).attr('id');

					the_id = '';

					if ( add ){
						if ( 'multi' == add ) {
							ui.item.html( ui.item.html().replace(/<[^<>]+>/g, function(m){ return m.replace(/__i__|%i%/g, n); }) );
							ui.item.attr( 'id', id.replace(/__i__|%i%/g, n) );
							n++;
							$('div#' + id).find('input.multi_number').val(n);
						}
						eListOptions.save( ui.item, 0, 0, 1 );
						ui.item.find('input.add_new').val('');
						ui.item.find('a.widget-action').click();
						return;
					}
					eListOptions.saveOrder(sb);
				},
				receive: function(e,ui) {
					//if ( !$(this).is(':visible') )
					//	$(this).sortable('cancel');
				}
			}).sortable('option', 'connectWith', 'div.widgets-sortables').parent().filter('.closed').children('.widgets-sortables').sortable('disable');
		},
		close : function(widget) {
			widget.children('.widget-inside').slideUp('fast', function(){
				widget.css({'width':'', margin:''});
			});
		},
		saveOrder : function(sb) {
			var $spinner = '';
			if ( sb ) {
				$spinner = $( '#' + sb ).closest( 'div.widgets-holder-wrap' ).find( '.sidebar-name .spinner' );
				$spinner.addClass( 'is-active' );
			}

			var a = {
				action: 'listings-options-order',
				save_listings_order: $('#_wpnonce_et_listings_options').val(),
				custom_options: []
			}

			$('div.widgets-sortables').each( function() {
				a['custom_options[' + $(this).attr('id') + ']'] = $(this).sortable('toArray').join(',');
			});

			$.post( ajaxurl, a, function() {
				if ( '' !== $spinner ) {
					$spinner.removeClass( 'is-active' );
				}
			});
		},
		save : function(widget, del, animate, order) {
			var sb = widget.closest('div.widgets-sortables').attr('id'),
				data = widget.find('form').serialize(),
				$spinner = widget.find( '.spinner' ),
				a;

			widget = $(widget);
			$spinner.addClass( 'is-active' );

			a = {
				action: 'listings-option-save',
				save_listings_option: $('#_wpnonce_et_listings_options').val(),
				sidebar: sb
			}

			if ( del )
				a['delete_widget'] = 1;

			data += '&' + $.param(a);

			$.post( ajaxurl, data, function(r){
				var id;

				if ( del ) {
					if ( !$('input.widget_number', widget).val() ) {
						id = $('input.widget-id', widget).val();
						$('#available-widgets').find('input.widget-id').each(function(){
							if ( $(this).val() == id )
								$(this).closest('div.widget').show();
						});
					}

					if ( animate ) {
						order = 0;
						widget.slideUp('fast', function(){
							$(this).remove();
							eListOptions.saveOrder();
						});
					} else {
						widget.remove();
					}
				} else {
					$spinner.removeClass( 'is-active' );
					if ( r && r.length > 2 ) {
						$('div.widget-content', widget).html(r);
					}
					eListOptions.appendTitle(widget);
				}
				if ( order )
					eListOptions.saveOrder();
			});
		},
		appendTitle : function(widget) {
			var title = $('input[id*="-title"]', widget);
			if ( title = title.val() ) {
				title = title.replace(/<[^<>]+>/g, '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				$(widget).children('.widget-top').children('.widget-title').children()
					.children('.in-widget-title').html(': ' + title);
			}
		}
	};

	$(document).ready(function($){ eListOptions.init(); });

})(jQuery);