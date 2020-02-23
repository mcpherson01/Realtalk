// Easing equation, borrowed from jQuery easing plugin
// http://gsgd.co.uk/sandbox/jquery/easing/
jQuery.easing.easeOutQuart = function (x, t, b, c, d) {
	return -c * ((t=t/d-1)*t*t*t - 1) + b;
};

jQuery(document).ready(function(){
	if (jQuery("#slider-nav").length != 0) {
		jQuery(function( $ ){
			if (!($("#wrapper2").length === 0)) {

				$('#wrapper2').serialScroll({
					target:'#sections',
					items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
					prev:'div.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
					next:'div.next',// Selector to the 'next' button (absolute too)
					axis:'xy',// The default is 'y' scroll on both ways
					navigation:'#slider-nav a',
					duration:300,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
					force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
					onBefore:function( e, elem, $pane, $items, pos ){
						e.preventDefault();
						if( this.blur )
							this.blur();
					},
					onAfter:function( elem ){
					}
				});

			};
		});
	};
});