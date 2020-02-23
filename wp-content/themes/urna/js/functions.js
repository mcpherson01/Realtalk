'use strict';

/**
 * @preserve
 * Project: Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Version: v2.2.1
 * Contributors: Mattia Larentis
 * Dependencies: Bootstrap's Dropdown plugin, jQuery
 * Description: A simple plugin to enable Bootstrap dropdowns to active on hover and provide a nice user experience.
 * License: MIT
 * Homepage: http://cameronspear.com/blog/bootstrap-dropdown-on-hover-plugin/
 */
(function ($, window, undefined$1) {
    var $allDropdowns = $();
    $.fn.dropdownHover = function (options) {
        if('ontouchstart' in document) return this;
        $allDropdowns = $allDropdowns.add(this.parent());
        return this.each(function () {
            var $this = $(this),
                $parent = $this.parent(),
                defaults = {
                    delay: 500,
                    hoverDelay: 0,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    hoverDelay: $(this).data('hover-delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                showEvent   = 'show.bs.dropdown',
                hideEvent   = 'hide.bs.dropdown',
                settings = $.extend(true, {}, defaults, options, data),
                timeout, timeoutHover;
            $parent.hover(function (event) {
                if(!$parent.hasClass('open') && !$this.is(event.target)) {
                    return true;
                }
                openDropdown(event);
            }, function () {
                window.clearTimeout(timeoutHover);
                timeout = window.setTimeout(function () {
                    $this.attr('aria-expanded', 'false');
                    $parent.removeClass('open');
                    $this.trigger(hideEvent);
                }, settings.delay);
            });
            $this.hover(function (event) {
                if(!$parent.hasClass('open') && !$parent.is(event.target)) {
                    return true;
                }
                openDropdown(event);
            });
            $parent.find('.dropdown-submenu').each(function (){
                var $this = $(this);
                var subTimeout;
                $this.hover(function () {
                    window.clearTimeout(subTimeout);
                    $this.children('.dropdown-menu').show();
                    $this.siblings().children('.dropdown-menu').hide();
                }, function () {
                    var $submenu = $this.children('.dropdown-menu');
                    subTimeout = window.setTimeout(function () {
                        $submenu.hide();
                    }, settings.delay);
                });
            });
            function openDropdown(event) {
                if($this.parents(".navbar").find(".navbar-toggle").is(":visible")) {
                    return;
                }
                window.clearTimeout(timeout);
                window.clearTimeout(timeoutHover);
                timeoutHover = window.setTimeout(function () {
                    $allDropdowns.find(':focus').blur();
                    if(settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');
                    window.clearTimeout(timeoutHover);
                    $this.attr('aria-expanded', 'true');
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                }, settings.hoverDelay);
            }
        });
    };
    $(document).ready(function () {
        $('[data-hover="dropdown"]').dropdownHover();
    });
})(jQuery, window);

class StickyHeader {
  constructor() {
    this.$tbayHeader = $('#tbay-header');
    this.$tbayHeaderMain = $('#tbay-header .header-main');

    if (this.$tbayHeader.hasClass('main-sticky-header') && this.$tbayHeaderMain.length > 0) {
      this._initStickyHeader();
    }

    $('.search-min-wrapper .btn-search-min').click(this._onClickSeachMin);
    $('.tbay-search-form .overlay-box').click(this._onClickOverLayBox);
    this._intSearchOffcanvas;
  }

  _initStickyHeader() {
    var _this = this;

    var tbay_width = $(window).width();

    var header_height = _this.$tbayHeader.outerHeight();

    var headerMain_height = _this.$tbayHeaderMain.outerHeight();

    var admin_height = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0;

    var sticky = _this.$tbayHeaderMain.offset().top;

    if (tbay_width >= 1024) {
      if (sticky == 0 || sticky == admin_height) {
        if (_this.$tbayHeader.hasClass('sticky-header')) return;

        _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);

        _this.$tbayHeaderMain.addClass('sticky-1');

        $(window).scroll(function () {
          if ($(this).scrollTop() > header_height) {
            _this.$tbayHeaderMain.addClass('sticky-box');
          } else {
            _this.$tbayHeaderMain.removeClass('sticky-box');
          }
        });
      } else {
        $(window).scroll(function () {
          if (!_this.$tbayHeader.hasClass('main-sticky-header')) return;

          if ($(this).scrollTop() > sticky - admin_height) {
            if (_this.$tbayHeader.hasClass('sticky-header')) return;

            _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);
          } else {
            _this.$tbayHeaderMain.css("top", 0).css("position", "relative").removeClass('sticky-header').parent().css('padding-top', 0);

            _this.$tbayHeaderMain.prev().css('margin-bottom', 0);
          }
        });
      }
    }
  }

  _stickyHeaderOnDesktop(headerMain_height, sticky, admin_height) {
    this.$tbayHeaderMain.addClass('sticky-header').css("top", admin_height).css("position", "fixed");

    if (sticky == 0 || sticky == admin_height) {
      this.$tbayHeaderMain.parent().css('padding-top', headerMain_height);
    } else {
      this.$tbayHeaderMain.prev().css('margin-bottom', headerMain_height);
    }
  }

  _onClickSeachMin() {
    $('.tbay-search-form.tbay-search-min form').toggleClass('show');
    $(this).toggleClass('active');
  }

  _onClickOverLayBox() {
    $('.search-min-wrapper .btn-search-min').removeClass('active');
    $('.tbay-search-form.tbay-search-min form').removeClass('show');
  }

  _intSearchOffcanvas() {
    $('[data-toggle="offcanvas-main-search"]').on('click', function () {
      $('#wrapper-container').toggleClass('show');
      $('#tbay-offcanvas-main').toggleClass('show');
    });
    var $box_totop = $('#tbay-offcanvas-main, .search');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('#wrapper-container').removeClass('show');
        $('#tbay-offcanvas-main').removeClass('show');
      }
    });
  }

}

const TREE_VIEW_OPTION_MEGA_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  persist: "location"
};
const TREE_VIEW_OPTION_MOBILE_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  hover: false
};
const DEVICE = {
  ANDROID: /Android/i,
  BLACK_BERRY: /BlackBerry/i,
  IOS: /iPhone|iPad|iPod/i,
  OPERA: /Opera Mini/i,
  WINDOW: /IEMobile/i,
  ANY: /Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i
};

(function ($) {
  $.extend($.fn, {
    swapClass: function (c1, c2) {
      var c1Elements = this.filter('.' + c1);
      this.filter('.' + c2).removeClass(c2).addClass(c1);
      c1Elements.removeClass(c1).addClass(c2);
      return this;
    },
    replaceClass: function (c1, c2) {
      return this.filter('.' + c1).removeClass(c1).addClass(c2).end();
    },
    hoverClass: function (className) {
      className = className || "hover";
      return this.hover(function () {
        $(this).addClass(className);
      }, function () {
        $(this).removeClass(className);
      });
    },
    heightToggle: function (animated, callback) {
      animated ? this.animate({
        height: "toggle"
      }, animated, callback) : this.each(function () {
        jQuery(this)[jQuery(this).is(":hidden") ? "show" : "hide"]();
        if (callback) callback.apply(this, arguments);
      });
    },
    heightHide: function (animated, callback) {
      if (animated) {
        this.animate({
          height: "hide"
        }, animated, callback);
      } else {
        this.hide();
        if (callback) this.each(callback);
      }
    },
    prepareBranches: function (settings) {
      if (!settings.prerendered) {
        this.filter(":last-child:not(ul)").addClass(CLASSES.last);
        this.filter((settings.collapsed ? "" : "." + CLASSES.closed) + ":not(." + CLASSES.open + ")").find(">ul").hide();
      }

      return this.filter(":has(>ul),:has(>.dropdown-menu)");
    },
    applyClasses: function (settings, toggler) {
      this.filter(":has(>ul):not(:has(>a))").find(">span").click(function (event) {
        toggler.apply($(this).next());
      }).add($("a", this)).hoverClass();

      if (!settings.prerendered) {
        this.filter(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.expandable).replaceClass(CLASSES.last, CLASSES.lastExpandable);
        this.not(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.collapsable).replaceClass(CLASSES.last, CLASSES.lastCollapsable);
        this.prepend("<div class=\"" + CLASSES.hitarea + "\"/>").find("div." + CLASSES.hitarea).each(function () {
          var classes = "";
          $.each($(this).parent().attr("class").split(" "), function () {
            classes += this + "-hitarea ";
          });
          $(this).addClass(classes);
        });
      }

      this.find("div." + CLASSES.hitarea).click(toggler);
    },
    treeview: function (settings) {
      settings = $.extend({
        cookieId: "treeview"
      }, settings);

      if (settings.add) {
        return this.trigger("add", [settings.add]);
      }

      if (settings.toggle) {
        var callback = settings.toggle;

        settings.toggle = function () {
          return callback.apply($(this).parent()[0], arguments);
        };
      }

      function treeController(tree, control) {
        function handler(filter) {
          return function () {
            toggler.apply($("div." + CLASSES.hitarea, tree).filter(function () {
              return filter ? $(this).parent("." + filter).length : true;
            }));
            return false;
          };
        }

        $("a:eq(0)", control).click(handler(CLASSES.collapsable));
        $("a:eq(1)", control).click(handler(CLASSES.expandable));
        $("a:eq(2)", control).click(handler());
      }

      function toggler() {
        $(this).parent().find(">.hitarea").swapClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).swapClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().swapClass(CLASSES.collapsable, CLASSES.expandable).swapClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightToggle(settings.animated, settings.toggle);

        if (settings.unique) {
          $(this).parent().siblings().find(">.hitarea").replaceClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).replaceClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().replaceClass(CLASSES.collapsable, CLASSES.expandable).replaceClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightHide(settings.animated, settings.toggle);
        }
      }

      function serialize() {

        var data = [];
        branches.each(function (i, e) {
          data[i] = $(e).is(":has(>ul:visible)") ? 1 : 0;
        });
        $.cookie(settings.cookieId, data.join(""));
      }

      function deserialize() {
        var stored = $.cookie(settings.cookieId);

        if (stored) {
          var data = stored.split("");
          branches.each(function (i, e) {
            $(e).find(">ul")[parseInt(data[i]) ? "show" : "hide"]();
          });
        }
      }

      this.addClass("treeview");
      var branches = this.find("li").prepareBranches(settings);

      switch (settings.persist) {
        case "cookie":
          var toggleCallback = settings.toggle;

          settings.toggle = function () {
            serialize();

            if (toggleCallback) {
              toggleCallback.apply(this, arguments);
            }
          };

          deserialize();
          break;

        case "location":
          var current = this.find("a").filter(function () {
            return this.href.toLowerCase() == location.href.toLowerCase();
          });

          if (current.length) {
            current.addClass("selected").parents("ul, li").add(current.next()).show();
          }

          break;
      }

      branches.applyClasses(settings, toggler);

      if (settings.control) {
        treeController(this, settings.control);
        $(settings.control).show();
      }

      return this.bind("add", function (event, branches) {
        $(branches).prev().removeClass(CLASSES.last).removeClass(CLASSES.lastCollapsable).removeClass(CLASSES.lastExpandable).find(">.hitarea").removeClass(CLASSES.lastCollapsableHitarea).removeClass(CLASSES.lastExpandableHitarea);
        $(branches).find("li").andSelf().prepareBranches(settings).applyClasses(settings, toggler);
      });
    }
  });
  var CLASSES = $.fn.treeview.classes = {
    open: "open",
    closed: "closed",
    expandable: "expandable",
    expandableHitarea: "expandable-hitarea",
    lastExpandableHitarea: "lastExpandable-hitarea",
    collapsable: "collapsable",
    collapsableHitarea: "collapsable-hitarea",
    lastCollapsableHitarea: "lastCollapsable-hitarea",
    lastCollapsable: "lastCollapsable",
    lastExpandable: "lastExpandable",
    last: "last",
    hitarea: "hitarea"
  };
  $.fn.Treeview = $.fn.treeview;
})(jQuery);

let setCookie = (cname, cvalue, exdays) => {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";
};
let getCookie = cname => {
  var name = cname + '=';
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');

  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];

    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }

    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }

  return '';
};
let isDevice = device => {
  navigator.userAgent.match(device);
};

class Mobile {
  constructor() {
    this._topBarDevice();

    this._fixVCAnimation();

    this._mobileMenu();

    this._SidebarShopMobile();

    this._SearchFocusActive();

    this._SearchOnClickSearchHeader();

    this._PopupLoginMobile();

    this._Select_change_form();

    $(window).scroll(() => {
      this._topBarDevice();

      this._fixVCAnimation();
    });
  }

  _topBarDevice() {
    var scroll = $(window).scrollTop();
    var objectSelect = $(".topbar-device-mobile").height();
    var scrollmobile = $(window).scrollTop();
    $(".topbar-device-mobile").toggleClass("active", scroll <= objectSelect);
    $("#tbay-mobile-menu").toggleClass("offsetop", scrollmobile == 0);
  }

  _fixVCAnimation() {
    if ($(".wpb_animate_when_almost_visible").length > 0 && !$(".wpb_animate_when_almost_visible").hasClass('wpb_start_animation')) {
      let animate_height = $(window).height();
      let wpb_not_animation_element = $(".wpb_animate_when_almost_visible:not(.wpb_start_animation)");
      var next_scroll = wpb_not_animation_element.offset().top - $(window).scrollTop();

      if (isDevice(DEVICE.ANY)) {
        wpb_not_animation_element.removeClass('wpb_animate_when_almost_visible');
      } else if (next_scroll < animate_height - 50) {
        wpb_not_animation_element.addClass("wpb_start_animation animated");
      }
    }
  }

  _mobileMenu() {
    $('[data-toggle="offcanvas"], .btn-offcanvas').click(function () {
      $('#wrapper-container').toggleClass('active');
      $('#tbay-mobile-menu').toggleClass('active');
    });
    $("#main-mobile-menu .caret").click(function () {
      $("#main-mobile-menu .dropdown").removeClass('open');
      $(event.target).parent().addClass('open');
    });
  }

  _SidebarShopMobile() {
    let btn_filter = $(".button-filter-mobile"),
        btn_close = $(".filter-mobile .close");
    btn_filter.on("click", function (e) {
      $('.filter-mobile').addClass('active');
      $("body").addClass('filter-mobile-active');
    });
    btn_close.on("click", function (e) {
      $('.filter-mobile').removeClass('active');
      $("body").removeClass('filter-mobile-active');
    });
    let win_canvas = $(window);
    let box_canvas = $('.filter-mobile .content, .button-filter-mobile, .filter-mobile .close');
    win_canvas.on("click.Bst,click touchstart tap", event => {
      if (!$('.filter-mobile').hasClass('active')) return;

      if (box_canvas.has(event.target).length == 0 && !box_canvas.is(event.target)) {
        $('.filter-mobile').removeClass('active');
        $("body").removeClass('filter-mobile-active');
      }
    });
  }

  _SearchFocusActive() {
    let search_mobile = $('.tbay-search-mobile .tbay-search');
    let search_cancel = $('.tbay-search-mobile .button-search-cancel');
    search_mobile.focusin(function () {
      $(search_mobile.parents('#tbay-mobile-menu-navbar')).addClass('search-mobile-focus');
      search_mobile.parent().find('.button-search-cancel').addClass('cancel-active');
    });
    search_cancel.on("click", function () {
      $(search_cancel.parents('#tbay-mobile-menu-navbar')).removeClass('search-mobile-focus');
      search_cancel.removeClass('cancel-active');
    });
  }

  _SearchOnClickSearchHeader() {
    let search_mobile = $('.search-device .search-icon');
    let search_cancel = $('.search-device .button-search-cancel');
    search_mobile.on("click", function () {
      $(search_mobile.parent()).addClass('active-search-mobile');
    });
    search_cancel.on("click", function () {
      $(search_cancel.parents('.search-device')).removeClass('active-search-mobile');
      search_cancel.removeClass('cancel-active');
    });
  }

  _PopupLoginMobile() {
    let popup_login_mobile = $('.mmenu-account .popup-login a, .footer-device-mobile > .device-account > a.popup-login');
    popup_login_mobile.on("click", function () {
      let api = $("#tbay-mobile-menu-navbar").data("mmenu");
      $('#custom-login-wrapper').modal('show');
      $(popup_login_mobile.parents('#tbay-mobile-menu-navbar')).removeClass('mm-menu_opened');
      api.close();
    });
  }

  _Select_change_form() {
    $('.topbar-device-mobile > form select').on('change', function () {
      this.form.submit();
    });
  }

}

class AccountMenu {
  constructor() {
    this._slideToggleAccountMenu(".tbay-login");

    this._slideToggleAccountMenu(".topbar-mobile");

    this._urnaClickNotMyAccountMenu();
  }

  _urnaClickNotMyAccountMenu() {
    var $win_my_account = $(window);
    var $box_my_account = $('.tbay-login .dropdown .account-menu,.topbar-mobile .dropdown .account-menu,.tbay-login .dropdown .account-button,.topbar-mobile .dropdown .account-button');
    $win_my_account.on("click.Bst", function (event) {
      if ($box_my_account.has(event.target).length == 0 && !$box_my_account.is(event.target)) {
        $(".tbay-login .dropdown .account-menu").slideUp(500);
        $(".topbar-mobile .dropdown .account-menu").slideUp(500);
      }
    });
  }

  _slideToggleAccountMenu(parentSelector) {
    $(parentSelector).find(".dropdown .account-button").click(function () {
      $(parentSelector).find(".dropdown .account-menu").slideToggle(500);
    });
  }

}

class BackToTop {
  constructor() {
    this._init();
  }

  _init() {
    $(window).scroll(function () {
      var isActive = $(this).scrollTop() > 400;
      $('.tbay-to-top').toggleClass('active', isActive);
      $('.tbay-category-fixed').toggleClass('active', isActive);
    });
    $('#back-to-top-mobile, #back-to-top').click(this._onClickBackToTop);
  }

  _onClickBackToTop() {
    $('html, body').animate({
      scrollTop: '0px'
    }, 800);
  }

}

class CanvasMenu {
  constructor() {
    this._init();

    this._remove_click_Outside();

    this._initCanvasMenuSidebar();
  }

  _init() {
    $("#tbay-offcanvas-main .btn-toggle-canvas").on("click", function () {
      $('#wrapper-container').removeClass('active');
    });
    $("#main-menu-offcanvas .caret").click(function () {
      $("#main-menu-offcanvas .dropdown").removeClass('open');
      $(this).parent().addClass('open');
      return false;
    });
    $('[data-toggle="offcanvas-main"]').on('click', function () {
      $('#wrapper-container').toggleClass('active');
      $('#tbay-offcanvas-main').toggleClass('active');
    });
  }

  _remove_click_Outside() {
    let win = $(window);
    win.on("click.Bst,click touchstart tap", function (event) {
      let box_popup = $('#tbay-offcanvas-main, .btn-toggle-canvas');

      if (box_popup.has(event.target).length == 0 && !box_popup.is(event.target)) {
        $('#wrapper-container').removeClass('active');
        return;
      }
    });
  }

  _initCanvasMenuSidebar() {
    $(document).on('click', '.canvas-menu-sidebar .btn-canvas-menu', function () {
      $('body').toggleClass('canvas-menu-active');
    });
    $(document).on('click', '.close-canvas-menu, .bg-close-canvas-menu', function () {
      $('body').removeClass('canvas-menu-active');
    });
  }

}

class FuncCommon {
  constructor() {
    this._progressAnimation();

    this._createWrapStart();

    $('.mod-heading .widget-title > span').wrapStart();

    this._urnaActiveAdminBar();

    this._urnaResizeMegamenu();

    this._urnaTooltip();

    this._initHeaderCoverBG();

    this._initCanvasSearch();

    this._initTreeviewMenu();

    this._categoryMenu();

    this._initContentMinHeight();

    $(window).scroll(() => {
      this._urnaActiveAdminBar();
    });
    $(window).on("resize", () => {
      this._urnaResizeMegamenu();
    });

    this._addAccordionLoginandCoupon();
  }

  _urnaActiveAdminBar() {
    var objectSelect = $("#wpadminbar");

    if (objectSelect.length > 0) {
      $("body").addClass("active-admin-bar");
    }
  }

  _urnaTooltip() {
    $('[data-toggle="tooltip"]').tooltip();
  }

  _createWrapStart() {
    $.fn.wrapStart = function () {
      return this.each(function () {
        var $this = $(this);
        var node = $this.contents().filter(function () {
          return this.nodeType == 3;
        }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
        if (!node.length) return;
        node[0].nodeValue = text.slice(first.length);
        node.before('<b>' + first + '</b>');
      });
    };
  }

  _progressAnimation() {
    $("[data-progress-animation]").each(function () {
      var $this = $(this);
      $this.appear(function () {
        var delay = $this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1;
        if (delay > 1) $this.css("animation-delay", delay + "ms");
        setTimeout(function () {
          $this.animate({
            width: $this.attr("data-progress-animation")
          }, 800);
        }, delay);
      }, {
        accX: 0,
        accY: -50
      });
    });
  }

  _urnaResizeMegamenu() {
    var window_size = $('body').innerWidth();

    if ($('.tbay_custom_menu').length > 0 && $('.tbay_custom_menu').hasClass('tbay-vertical-menu')) {
      if (window_size > 767) {
        this._resizeMegaMenuOnDesktop();
      } else {
        this._initTreeViewForMegaMenuOnMobile();
      }
    }

    if ($('.tbay-megamenu').length > 0 && $('.tbay-megamenu,.tbay-offcanvas-main').hasClass('verticle-menu') && window_size > 767) {
      this._resizeMegaMenuVertical();
    }
  }

  _resizeMegaMenuVertical() {
    var full_width = parseInt($('#main-container.container').innerWidth());
    var menu_width = parseInt($('.verticle-menu').innerWidth());
    var w = full_width - menu_width;
    $('.verticle-menu').find('.aligned-fullwidth').children('.dropdown-menu').css({
      "max-width": w,
      "width": full_width - 30
    });
  }

  _resizeMegaMenuOnDesktop() {
    let maxWidth = $('#main-container.container').innerWidth() - $('.tbay-vertical-menu').innerWidth();
    let width = $('#main-container.container').innerWidth() - 30;
    $('.tbay-vertical-menu').find('.aligned-fullwidth').children('.dropdown-menu').css({
      'max-width': maxWidth,
      "width": width
    });
  }

  _initTreeViewForMegaMenuOnMobile() {
    $(".tbay-vertical-menu > .widget_nav_menu >.nav > ul").treeview(TREE_VIEW_OPTION_MEGA_MENU);
  }

  _addAccordionLoginandCoupon() {
    $('.showlogin, .showcoupon').click(function (event) {
      $(event.currentTarget).toggleClass('active');
    });
  }

  _initHeaderCoverBG() {
    let menu = $('.navbar-nav.megamenu > li, #tbay-header .recent-view .urna-recent-viewed-products'),
        search = $('.tbay-search-form .tbay-search'),
        btn_category = $('.category-inside .category-inside-title'),
        cart_click = $('.cart-popup');
    menu.mouseenter(function () {
      if ($(this).children('.dropdown-menu, ul, .content-view').length == 0) return;
      $('#tbay-header').addClass('nav-cover-active-1');
    }).mouseleave(function () {
      $('#tbay-header').removeClass('nav-cover-active-1');
    });
    search.focusin(function () {
      if (search.parents('.sidebar-canvas-search').length > 0) return;
      $('#tbay-header').addClass('nav-cover-active-2');
    }).focusout(function () {
      $('#tbay-header').removeClass('nav-cover-active-2');
    });
    cart_click.on('shown.bs.dropdown', function (event) {
      $(event.target).closest('#tbay-header').addClass('nav-cover-active-3');
    }).on('hidden.bs.dropdown', function (event) {
      $(event.target).closest('#tbay-header').removeClass('nav-cover-active-3');
    });

    if (btn_category.parents('#tbay-header')) {
      $(document.body).on('urna_category_inside_open', () => {
        $('#tbay-header').addClass('nav-cover-active-4');
      });
      $(document.body).on('urna_category_inside_close', () => {
        $('#tbay-header').removeClass('nav-cover-active-4');
      });
    }
  }

  _initCanvasSearch() {
    let input_search = $('#tbay-search-form-canvas .sidebar-canvas-search .sidebar-content .tbay-search');
    input_search.focusin(function () {
      input_search.parent().addClass('search_cv_active');
    }).focusout(function () {
      input_search.parent().removeClass('search_cv_active');
    });
  }

  _initTreeviewMenu() {
    $("#category-menu").addClass('treeview');
    jQuery(".treeview-menu .menu, #category-menu").treeview(TREE_VIEW_OPTION_MEGA_MENU);
    jQuery("#main-mobile-menu, #main-mobile-menu-xlg").treeview(TREE_VIEW_OPTION_MOBILE_MENU);
  }

  _categoryMenu() {
    $(".category-inside .category-inside-title").click(function () {
      $(event.target).parents('.category-inside').toggleClass("open");

      if ($(event.target).parents('.category-inside').hasClass('open')) {
        $(document.body).trigger('urna_category_inside_open');
      } else {
        $(document.body).trigger('urna_category_inside_close');
      }
    });
    let $win = $(window);
    $win.on("click.Bst,click touchstart tap", function (event) {
      if (urna_settings.category_open === 'open') return;
      let $box = $('.category-inside .category-inside-title, .category-inside-content');
      if (!$('.category-inside').hasClass('open') && !$('#tbay-header').hasClass('nav-cover-active-4')) return;

      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        $('.category-inside').removeClass('open');
        $('#tbay-header').removeClass('nav-cover-active-4');
      }
    });
  }

  _initContentMinHeight() {
    let window_size = $('body').innerWidth(),
        $screen = $(window).height(),
        $header = $('#tbay-header').outerHeight(),
        $content = $('#tbay-main-content').outerHeight();

    if ($content < $screen && window_size > 1200) {
      $('#tbay-main-content').css('min-height', $screen - $header);
    }
  }

}

class NewsLetter {
  constructor() {
    this._init();
  }

  _init() {
    $('#popupNewsletterModal').on('hidden.bs.modal', function () {
      setCookie('hiddenmodal', 1, 0.1);
    });
    setTimeout(function () {
      var hiddenmodal = getCookie('hiddenmodal');

      if (hiddenmodal == "") {
        $('#popupNewsletterModal').modal('show');
      }
    }, 3000);
  }

}

class Banner {
  constructor() {
    this._init();
  }

  _init() {
    let btnRemove = $('#banner-remove');
    btnRemove.on('click', function (event) {
      $(event.target).parents('.widget_urna_banner_image').slideUp("slow");
      setCookie('banner_remove', 1, 0.1);
    });
  }

}

class Search {
  constructor() {
    this._init();
  }

  _init() {
    this._urnaSearchMobile();

    this._searchToTop();

    this._searchCanvasForm();

    this._searchCanvasFormV3();

    $('.button-show-search').click(() => $('.tbay-search-form').addClass('active'));
    $('.button-hidden-search').click(() => $('.tbay-search-form').removeClass('active'));
  }

  _urnaSearchMobile() {
    $(".topbar-mobile .search-popup, .search-device-mobile").each(function () {
      $(this).find(".show-search").click(event => {
        $(this).find(".tbay-search-form").slideToggle(500);
        $(this).find(".tbay-search-form .input-group .tbay-search").focus();
        $(event.currentTarget).toggleClass('active');
      });
    });
    $(window).on("click.Bst,click touchstart tap", function (event) {
      var $box = $('.footer-device-mobile > div i, .topbar-device-mobile .search-device-mobile i ,.search-device-mobile .tbay-search-form form');
      if (!$(".search-device-mobile .show-search").hasClass('active')) return;

      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        $(".search-device-mobile .tbay-search-form").slideUp(500);
        $(".search-device-mobile .show-search").removeClass('active');
        $("body").removeClass('mobile-search-active');
      }
    });
    $('.topbar-mobile .dropdown-menu').click(function (e) {
      e.stopPropagation();
    });
  }

  _searchToTop() {
    $('.search-totop-wrapper .btn-search-totop').click(function () {
      $('.search-totop-content').toggleClass('active');
      $(this).toggleClass('active');
    });
    var $box_totop = $('.search-totop-wrapper .btn-search-totop, .search-totop-content');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('.search-totop-wrapper .btn-search-totop').removeClass('active');
        $('.search-totop-content').removeClass('active');
      }
    });
  }

  _searchCanvasForm() {
    let searchform = $('#tbay-search-form-canvas');
    searchform.find('button.search-open').click(function () {
      $(event.target).parents('#tbay-search-form-canvas').toggleClass("open");
      $('body').toggleClass("active-search-canvas");
    });
    let window_searchcanvas = $(window);
    let forcussidebar = $('#tbay-search-form-canvas .search-open, #tbay-search-form-canvas .sidebar-content');
    window_searchcanvas.on("click.Bst", function (event) {
      if (!searchform.hasClass('open')) return;

      if (forcussidebar.has(event.target).length == 0 && !forcussidebar.is(event.target)) {
        searchform.removeClass("open");
        $('body').removeClass("active-search-canvas");
      }
    });
    searchform.find('button.btn-search-close').click(function () {
      if (!searchform.hasClass('open')) return;
      searchform.removeClass("open");
      $('body').removeClass("active-search-canvas");
    });
  }

  _searchCanvasFormV3() {
    let searchform = $('#tbay-search-form-canvas-v3');
    searchform.find('button.search-open').click(function () {
      $(event.target).parents('#tbay-search-form-canvas-v3').toggleClass("open");
      $('body').toggleClass("active-search-canvas");
    });
    let window_searchcanvas = $(window);
    let forcussidebar = $('#tbay-search-form-canvas-v3 .search-open, #tbay-search-form-canvas-v3 .sidebar-content');
    window_searchcanvas.on("click.Bst", function (event) {
      if (!searchform.hasClass('open')) return;

      if (forcussidebar.has(event.target).length == 0 && !forcussidebar.is(event.target)) {
        searchform.removeClass("open");
        $('body').removeClass("active-search-canvas");
      }
    });
    searchform.find('button.btn-search-close').click(function () {
      if (!searchform.hasClass('open')) return;
      searchform.removeClass("open");
      $('body').removeClass("active-search-canvas");
    });
  }

}

class Preload {
  constructor() {
    this._init();
  }

  _init() {
    if ($.fn.jpreLoader) {
      var $preloader = $('.js-preloader');
      $preloader.jpreLoader({}, function () {
        $preloader.addClass('preloader-done');
        $('body').trigger('preloader-done');
        $(window).trigger('resize');
      });
    }

    $('.tbay-page-loader').delay(100).fadeOut(400, function () {
      $('body').removeClass('tbay-body-loading');
      $(this).remove();
    });

    if ($(document.body).hasClass('tbay-body-loader')) {
      setTimeout(function () {
        $(document.body).removeClass('tbay-body-loader');
        $('.tbay-page-loader').fadeOut(250);
      }, 300);
    }
  }

}

(function ($) {
  $.fn.unveil = function (threshold, callback) {
    var $w = $(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina ? "data-src-retina" : "data-src",
        images = this,
        loaded;
    this.one("unveil", function () {
      var source = this.getAttribute(attrib);
      source = source || this.getAttribute("data-src");

      if (source) {
        this.setAttribute("src", source);
        if (typeof callback === "function") callback.call(this);
      }
    });

    function unveil() {
      var inview = images.filter(function () {
        var $e = $(this),
            wt = $w.scrollTop() - 30,
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();
        return eb >= wt - th && et <= wb + th;
      });
      loaded = inview.trigger("unveil");
      images = images.not(loaded);
    }

    $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);
    unveil();
    return this;
  };
})(window.jQuery || window.Zepto);

class layzyLoadImage {
  constructor() {
    $(window).off('scroll.unveil resize.unveil lookup.unveil');

    this._intImageLoad('.tbay-image-loaded:not(.image-loaded) .unveil-image', '.tbay-image-loaded');

    this._initImageProduct();
  }

  _initImageProduct() {
    var $images = $('.product-image:not(.image-loaded) .unveil-image, .tbay-gallery-varible:not(.image-loaded) .unveil-image');

    if ($images.length) {
      $images.unveil(1, function () {
        $(this).load(function () {
          $(this).parents('.product-image, .tbay-gallery-varible').first().addClass('image-loaded');
          $(this).removeAttr('data-src');
          $(this).removeAttr('data-srcset');
          $(this).removeAttr('data-sizes');
          $(this).css('opacity', '1');
        });
      });
    }
  }

  _intImageLoad(childClass, parentClass) {
    var $images = $(childClass);

    if ($images.length) {
      $images.unveil(1, function () {
        $(this).load(function () {
          $(this).parents(parentClass).first().addClass('image-loaded');
          $(this).removeAttr('data-src');
          $(this).removeAttr('data-srcset');
          $(this).removeAttr('data-sizes');
          $(this).css('opacity', '1');
        });
      });
    }
  }

}

class Tabs {
  constructor() {
    $('ul.nav-tabs li a').on('show.bs.tab', event => {
      $(document.body).trigger('urna_lazyload_image');
    });
    $('.wc-tabs li a').on('click', event => {
      $(document.body).trigger('urna_lazyload_image');
    });
  }

}

(function ($, sr) {
  var debounce = function (func, threshold, execAsap) {
    var timeout;
    return function debounced() {
      var obj = this,
          args = arguments;

      function delayed() {
        if (!execAsap) func.apply(obj, args);
        timeout = null;
      }
      if (timeout) clearTimeout(timeout);else if (execAsap) func.apply(obj, args);
      timeout = setTimeout(delayed, threshold || 100);
    };
  };

  jQuery.fn[sr] = function (fn) {
    return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
  };
})(jQuery, 'smartresize');

window.$ = window.jQuery;
$(document).ready(() => {
  setTimeout(function () {
    new layzyLoadImage();
  }, 200);
  new Tabs(), new StickyHeader(), new AccountMenu(), new BackToTop(), new CanvasMenu(), new FuncCommon(), new NewsLetter(), new Banner(), new Preload(), new Search();

  if (urna_settings.mobile || $(window).width() < 1025) {
    new Mobile();
  }
});
$(window).smartresize(function () {
  if ($(window).width() < 1025) {
    try {
      new Mobile();
    } catch (err) {}
  }
});
$(document.body).on('urna_lazyload_image', () => {
  setTimeout(function () {
    new layzyLoadImage();
  }, 200);
});
