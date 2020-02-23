/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */
var S = jQuery.noConflict();
;(function(S){
	S.fn.superfish = function(op){

		var sf = S.fn.superfish,
			c = sf.c,
			Sarrow = S(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),
			over = function(){
				var SS = S(this), menu = getMenu(SS);
				clearTimeout(menu.sfTimer);
				SS.showSuperfishUl().siblings().hideSuperfishUl();
			},
			out = function(){
				var SS = S(this), menu = getMenu(SS), o = sf.op;
				clearTimeout(menu.sfTimer);
				menu.sfTimer=setTimeout(function(){
					o.retainPath=(S.inArray(SS[0],o.Spath)>-1);
					SS.hideSuperfishUl();
					if (o.Spath.length && SS.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.Spath);}
				},o.delay);
			},
			getMenu = function(Smenu){
				var menu = Smenu.parents(['ul.',c.menuClass,':first'].join(''))[0];
				sf.op = sf.o[menu.serial];
				return menu;
			},
			addArrow = function(Sa){ Sa.addClass(c.anchorClass).append(Sarrow.clone()); };

		return this.each(function() {
			var s = this.serial = sf.o.length;
			var o = S.extend({},sf.defaults,op);
			o.Spath = S('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){
				S(this).addClass([o.hoverClass,c.bcClass].join(' '))
					.filter('li:has(ul)').removeClass(o.pathClass);
			});
			sf.o[s] = sf.op = o;

			S('li:has(ul)',this)[(S.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over,out).each(function() {
				if (o.autoArrows) addArrow( S('>a:first-child',this) );
			})
			.not('.'+c.bcClass)
				.hideSuperfishUl();

			var Sa = S('a',this);
			Sa.each(function(i){
				var Sli = Sa.eq(i).parents('li');
				Sa.eq(i).focus(function(){over.call(Sli);}).blur(function(){out.call(Sli);});
			});
			o.onInit.call(this);

		}).each(function() {
			menuClasses = [c.menuClass];
			if (sf.op.dropShadows  && !(S.browser.msie && S.browser.version < 7)) menuClasses.push(c.shadowClass);
			S(this).addClass(menuClasses.join(' '));
		});
	};

	var sf = S.fn.superfish;
	sf.o = [];
	sf.op = {};
	sf.IE7fix = function(){
		var o = sf.op;
		if (S.browser.msie && S.browser.version > 6 && o.dropShadows && o.animation.opacity!=undefined)
			this.toggleClass(sf.c.shadowClass+'-off');
		};
	sf.c = {
		bcClass     : 'sf-breadcrumb',
		menuClass   : 'sf-js-enabled',
		anchorClass : 'sf-with-ul',
		arrowClass  : 'sf-sub-indicator',
		shadowClass : 'sf-shadow'
	};
	sf.defaults = {
		hoverClass	: 'sfHover',
		pathClass	: 'overideThisToUse',
		pathLevels	: 1,
		delay		: 0,
		animation	: {opacity:'show'},
		speed		: 'normal',
		autoArrows	: true,
		dropShadows : true,
		disableHI	: false,		// true disables hoverIntent detection
		onInit		: function(){}, // callback functions
		onBeforeShow: function(){},
		onShow		: function(){},
		onHide		: function(){}
	};
	S.fn.extend({
		hideSuperfishUl : function(){
			var o = sf.op,
				not = (o.retainPath===true) ? o.Spath : '';
			o.retainPath = false;
			var Sul = S(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass)
					.find('>ul').hide().css('visibility','hidden');
			o.onHide.call(Sul);
			return this;
		},
		showSuperfishUl : function(){
			var o = sf.op,
				sh = sf.c.shadowClass+'-off',
				Sul = this.addClass(o.hoverClass)
					.find('>ul:hidden').css('visibility','visible');
			sf.IE7fix.call(Sul);
			o.onBeforeShow.call(Sul);
			Sul.animate(o.animation,o.speed,function(){ sf.IE7fix.call(Sul); o.onShow.call(Sul); });
			return this;
		}
	});

})(jQuery);