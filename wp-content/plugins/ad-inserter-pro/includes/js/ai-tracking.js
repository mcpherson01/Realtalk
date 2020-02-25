(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(["jquery"], function (a0) {
      return (factory(a0));
    });
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require("jquery"));
  } else {
    factory(root["jQuery"]);
  }
}(this, function (jQuery) {

/*!
 * jQuery iframe click tracking plugin
 *
 * @author Vincent Pare
 * @copyright  2013-2018 Vincent Pare
 * @license http://opensource.org/licenses/Apache-2.0
 * @version 2.0.0
 */
(function($) {
  // Tracking handler manager
  $.fn.iframeTracker = function(handler) {
    // Building handler object from handler function
    if (typeof handler == "function") {
      handler = {
        blurCallback: handler
      };
    }

    var target = this.get();
    if (handler === null || handler === false) {
      $.iframeTracker.untrack(target);
    } else if (typeof handler == "object") {
      $.iframeTracker.track(target, handler);
    } else {
      throw new Error("Wrong handler type (must be an object, or null|false to untrack)");
    }
    return this;
  };

  // Iframe tracker common object
  $.iframeTracker = {
    // State
    focusRetriever: null,  // Element used for restoring focus on window (element)
    focusRetrieved: false, // Says if the focus was retrieved on the current page (bool)
    handlersList: [],      // Store a list of every trakers (created by calling $(selector).iframeTracker...)
    isIE8AndOlder: false,  // true for Internet Explorer 8 and older

    // Init (called once on document ready)
    init: function() {
      // Determine browser version (IE8-) ($.browser.msie is deprecated since jQuery 1.9)
      try {
        if ($.browser.msie === true && $.browser.version < 9) {
          this.isIE8AndOlder = true;
        }
      } catch (ex) {
        try {
          var matches = navigator.userAgent.match(/(msie) ([\w.]+)/i);
          if (matches[2] < 9) {
            this.isIE8AndOlder = true;
          }
        } catch (ex2) {}
      }

      // Listening window blur
      $(window).focus();
      $(window).blur(function(e) {
        $.iframeTracker.windowLoseFocus(e);
      });

      // Focus retriever (get the focus back to the page, on mouse move)
      $("body").append('<div style="position:fixed; top:0; left:0; overflow:hidden;"><input style="position:absolute; left:-300px;" type="text" value="" id="focus_retriever" readonly="true" /></div>');
      this.focusRetriever = $("#focus_retriever");
      this.focusRetrieved = false;

      // ### AI
      var instance = this;
      // ### /AI

      $(document).mousemove(function(e) {
        if (document.activeElement && document.activeElement.tagName === "IFRAME") {
        // ### AI
        // Do not process disqus iframe
          if (!document.activeElement.hasAttribute ('id') || $(document.activeElement).attr ('id').indexOf ('dsq-') !== 0) {
        // ### /AI
            $.iframeTracker.focusRetriever.focus();
            $.iframeTracker.focusRetrieved = true;
        // ### AI
          }
        // ### /AI
        }

        // ### AI
        if (document.activeElement && document.activeElement.tagName == "A") {
          for (var i in instance.handlersList) {
            try {instance.handlersList[i].focusCallback(document.activeElement);} catch(ex) {}
          }
        }
        // ### /AI

      });

      // Special processing to make it work with my old friend IE8 (and older) ;)
      if (this.isIE8AndOlder) {
        // Blur doesn't works correctly on IE8-, so we need to trigger it manually
        this.focusRetriever.blur(function(e) {
          e.stopPropagation();
          e.preventDefault();
          $.iframeTracker.windowLoseFocus(e);
        });

        // Keep focus on window (fix bug IE8-, focusable elements)
        $("body").click(function(e) {
          $(window).focus();
        });
        $("form").click(function(e) {
          e.stopPropagation();
        });

        // Same thing for "post-DOMready" created forms (issue #6)
        try {
          $("body").on("click", "form", function(e) {
            e.stopPropagation();
          });
        } catch (ex) {
          console.log("[iframeTracker] Please update jQuery to 1.7 or newer. (exception: " + ex.message + ")");
        }
      }
    },

    // Add tracker to target using handler (bind boundary listener + register handler)
    // target: Array of target elements (native DOM elements)
    // handler: User handler object
    track: function(target, handler) {
      // Adding target elements references into handler
      handler.target = target;

      // Storing the new handler into handler list
      $.iframeTracker.handlersList.push(handler);

      // Binding boundary listener
      $(target)
        .bind("mouseover", { handler: handler }, $.iframeTracker.mouseoverListener)
        .bind("mouseout",  { handler: handler }, $.iframeTracker.mouseoutListener);
    },

    // Remove tracking on target elements
    // target: Array of target elements (native DOM elements)
    untrack: function(target) {
      if (typeof Array.prototype.filter != "function") {
        console.log("Your browser doesn't support Array filter, untrack disabled");
        return;
      }

      // Unbinding boundary listener
      $(target).each(function(index) {
        $(this)
          .unbind("mouseover", $.iframeTracker.mouseoverListener)
          .unbind("mouseout", $.iframeTracker.mouseoutListener);
      });

      // Handler garbage collector
      var nullFilter = function(value) {
        return value === null ? false : true;
      };
      for (var i in this.handlersList) {
        // Prune target
        for (var j in this.handlersList[i].target) {
          if ($.inArray(this.handlersList[i].target[j], target) !== -1) {
            this.handlersList[i].target[j] = null;
          }
        }
        this.handlersList[i].target = this.handlersList[i].target.filter(nullFilter);

        // Delete handler if unused
        if (this.handlersList[i].target.length === 0) {
          this.handlersList[i] = null;
        }
      }
      this.handlersList = this.handlersList.filter(nullFilter);
    },

    // Target mouseover event listener
    mouseoverListener: function(e) {
      e.data.handler.over = true;
      try {
        e.data.handler.overCallback(this, e);
      } catch (ex) {}
    },

    // Target mouseout event listener
    mouseoutListener: function(e) {
      e.data.handler.over = false;
      $.iframeTracker.focusRetriever.focus();
      try {
        e.data.handler.outCallback(this, e);
      } catch (ex) {}
    },

    // Calls blurCallback for every handler with over=true on window blur
    windowLoseFocus: function(e) {
      for (var i in this.handlersList) {
        if (this.handlersList[i].over === true) {
          try {
            this.handlersList[i].blurCallback(e);
          } catch (ex) {}
        }
      }
    }
  };

  // Init the iframeTracker on document ready
  $(document).ready(function() {
    $.iframeTracker.init();
  });
})(jQuery);

}));

ai_tracking_finished = false;

jQuery(document).ready(function($) {

  function b64e (str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa (encodeURIComponent (str).replace (/%([0-9A-F]{2})/g,
      function toSolidBytes (match, p1) {
        return String.fromCharCode ('0x' + p1);
    }));
  }

  function b64d (str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent (atob (str).split ('').map (function(c) {
      return '%' + ('00' + c.charCodeAt (0).toString (16)).slice (-2);
    }).join (''));
  }

  var ai_internal_tracking = AI_INTERNAL_TRACKING;
  var ai_external_tracking = AI_EXTERNAL_TRACKING;

  var ai_external_tracking_category = "AI_EXT_CATEGORY";
  var ai_external_tracking_action   = "AI_EXT_ACTION";
  var ai_external_tracking_label    = "AI_EXT_LABEL";

  var ai_track_pageviews = AI_TRACK_PAGEVIEWS;
  var ai_advanced_click_detection = AI_ADVANCED_CLICK_DETECTION;
  var ai_viewports = AI_VIEWPORTS;
  var ai_viewport_names = JSON.parse (b64d ("AI_VIEWPORT_NAMES"));
  var ai_data_id = "AI_NONCE";
  var ajax_url = "AI_SITE_URL/wp-admin/admin-ajax.php";

  Number.isInteger = Number.isInteger || function (value) {
    return typeof value === "number" &&
           isFinite (value) &&
           Math.floor (value) === value;
  };

  function replace_tags (text, event, block, block_name, version, version_name) {
    text = text.replace ('[EVENT]',                 event);
    text = text.replace ('[BLOCK_NUMBER]',          block);
    text = text.replace ('[BLOCK_NAME]',            block_name);
    text = text.replace ('[VERSION_NUMBER]',        version);
    text = text.replace ('[VERSION_NAME]',          version_name);
    text = text.replace ('[BLOCK_VERSION_NUMBER]',  block + (version == 0 ? '' : ' - ' + version));
    text = text.replace ('[BLOCK_VERSION_NAME]',    block_name + (version_name == '' ? '' : ' - ' + version_name));

    return (text);
  }

  function external_tracking (event, block, block_name, version, version_name, non_interaction) {

    var category = replace_tags (ai_external_tracking_category, event, block, block_name, version, version_name);
    var action   = replace_tags (ai_external_tracking_action,   event, block, block_name, version, version_name);
    var label    = replace_tags (ai_external_tracking_label,    event, block, block_name, version, version_name);

    var ai_debug = typeof ai_debugging !== 'undefined'; // 1
//    var ai_debug = false;

    if (ai_debug) console.log ("AI TRACKING EXTERNAL", event, block, '["' + category + '", "' + action + '", "' + label + "]");

//        Google Analytics
    if (typeof window.gtag == 'function') {
      gtag ('event', 'impression', {
        'event_category': category,
        'event_action': action,
        'event_label': label,
        'non_interaction': non_interaction
      });

      if (ai_debug) console.log ("AI TRACKING Global Site Tag:", non_interaction);
    } else

    if (typeof window.ga == 'function') {
      ga ('send', 'event', {
        eventCategory: category,
        eventAction: action,
        eventLabel: label,
        nonInteraction: non_interaction
      });

      if (ai_debug) console.log ("AI TRACKING Google Universal Analytics:", non_interaction);
    } else

    if (typeof window.__gaTracker == 'function') {
      __gaTracker ('send', 'event', {
        eventCategory: category,
        eventAction: action,
        eventLabel: label,
        nonInteraction: non_interaction
      });

      if (ai_debug) console.log ("AI TRACKING Google Universal Analytics by MonsterInsights:", non_interaction);
    } else

    if (typeof _gaq == 'object') {
//      _gaq.push (['_trackEvent', category, action, label]);
      _gaq.push (['_trackEvent', category, action, label, undefined, non_interaction]);

      if (ai_debug) console.log ("AI TRACKING Google Legacy Analytics:", non_interaction);
    }

//        Matomo (Piwik)
    if (typeof _paq == 'object') {
      _paq.push (['trackEvent', category, action, label]);

      if (ai_debug) console.log ("AI TRACKING Matomo");
    }
  }

  function ai_click (data, click_type) {

    var ai_debug = typeof ai_debugging !== 'undefined'; //2
//    var ai_debug = false;

    var block         = data [0];
    var code_version  = data [1];

    if (Number.isInteger (code_version)) {

      if (typeof ai_check_data == 'undefined' && typeof ai_check_data_timeout == 'undefined') {
        if (ai_debug) console.log ('AI CHECK CLICK - DATA NOT SET YET');

        ai_check_data_timeout = true;
        setTimeout (function() {if (ai_debug) console.log (''); if (ai_debug) console.log ('AI CHECK CLICK TIMEOUT'); ai_click (data, click_type);}, 2500);
        return;
      }

      if (ai_debug) console.log ('AI CHECK CLICK block', block);
      if (ai_debug) console.log ('AI CHECK CLICK data', ai_check_data);

      ai_cookie = ai_load_cookie ();

      for (var cookie_block in ai_cookie) {

        if (parseInt (block) != parseInt (cookie_block)) continue;

        for (var cookie_block_property in ai_cookie [cookie_block]) {
          if (cookie_block_property == 'c') {
            if (ai_debug) console.log ('AI CHECK CLICKS block:', cookie_block);

            var clicks = ai_cookie [cookie_block][cookie_block_property];
            if (clicks > 0) {
              if (ai_debug) console.log ('AI CLICK, block', cookie_block, 'remaining', clicks - 1, 'clicks');

              ai_set_cookie (cookie_block, 'c', clicks - 1);

              if (clicks == 1) {
                if (ai_debug) console.log ('AI CLICKS, closing block', block, '- no more clicks');

                var cfp_time = $('span[data-ai-block=' + block + ']').data ('ai-cfp-time');
                var date = new Date();
                var timestamp = Math.round (date.getTime() / 1000);
                var closed_until = timestamp + 7 * 24 * 3600;
                ai_set_cookie (cookie_block, 'c', - closed_until);

                $('span[data-ai-block=' + block + ']').closest ("div[data-ai]").remove ();

                if (typeof cfp_time != 'undefined') {
                  if (ai_debug) console.log ('AI CLICKS CFP, closing block', block, 'for', cfp_time, 'days');

                  var closed_until = timestamp + cfp_time * 24 * 3600;

                  ai_set_cookie (block, 'x', closed_until);

                  $('span.ai-cfp').each (function (index) {
                    var cfp_block = $(this).data ('ai-block');
                    if (ai_debug) console.log ('AI CLICKS CFP, closing block', cfp_block, 'for', cfp_time, 'days');

                    $(this).closest ("div[data-ai]").remove ();
                    ai_set_cookie (cfp_block, 'x', closed_until);
                  });
                }
              } else ai_set_cookie (cookie_block, 'c', clicks - 1);
            }
          } else

          if (cookie_block_property == 'cpt') {
            if (ai_debug) console.log ('AI CHECK CLICKS PER TIME PERIOD block:', cookie_block);

            var clicks = ai_cookie [cookie_block][cookie_block_property];
            if (clicks > 0) {
              if (ai_debug) console.log ('AI CLICKS, block', cookie_block, 'remaining', clicks - 1, 'clicks per time period');

              ai_set_cookie (cookie_block, 'cpt', clicks - 1);

              if (clicks == 1) {
                if (ai_debug) console.log ('AI CLICKS, closing block', block, '- no more clicks per time period');

                var cfp_time = $('span[data-ai-block=' + block + ']').data ('ai-cfp-time');
                var date = new Date();
                var timestamp = Math.round (date.getTime() / 1000);
                var closed_until = timestamp + cfp_time * 24 * 3600;

                $('span[data-ai-block=' + block + ']').closest ("div[data-ai]").remove ();

                if (typeof cfp_time != 'undefined') {
                  if (ai_debug) console.log ('AI CLICKS CFP, closing block', block, 'for', cfp_time, 'days');

                  ai_set_cookie (block, 'x', closed_until);

                  $('span.ai-cfp').each (function (index) {
                    var cfp_block = $(this).data ('ai-block');
                    if (ai_debug) console.log ('AI CLICKS CFP, closing block', cfp_block, 'for', cfp_time, 'days');

                    $(this).closest ("div[data-ai]").remove ();
                    ai_set_cookie (cfp_block, 'x', closed_until);
                  });
                }
              }
            } else {
                if (ai_check_data.hasOwnProperty (cookie_block) && ai_check_data [cookie_block].hasOwnProperty ('cpt') && ai_check_data [cookie_block].hasOwnProperty ('ct')) {
                  if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('ct')) {
                    var date = new Date();
                    var closed_for = ai_cookie [cookie_block]['ct'] - Math.round (date.getTime() / 1000);
                    if (closed_for <= 0) {
                      if (ai_debug) console.log ('AI CLICKS, block', cookie_block, 'set max clicks period (', ai_check_data [cookie_block]['ct'], 'days =', ai_check_data [cookie_block]['ct'] * 24 * 3600, 's)');

                      var timestamp = Math.round (date.getTime() / 1000);

                      ai_set_cookie (cookie_block, 'cpt', ai_check_data [cookie_block]['cpt'] - 1);
                      ai_set_cookie (cookie_block, 'ct', Math.round (timestamp + ai_check_data [cookie_block]['ct'] * 24 * 3600));
                    }
                  }
                } else {
                    if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('cpt')) {
                      if (ai_debug) console.log ('AI CLICKS, block', cookie_block, 'removing cpt');

                      ai_set_cookie (cookie_block, 'cpt', '');
                    }
                    if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('ct')) {
                      if (ai_debug) console.log ('AI CLICKS, block', cookie_block, 'removing ct');

                      ai_set_cookie (cookie_block, 'ct', '');
                    }
                  }
              }
          }
        }
      }

      if (ai_debug) console.log ("AI CLICK: ", data, click_type);

      if (ai_internal_tracking) {
        $.ajax ({
            url: ajax_url,
            type: "post",
            data: {
              action: "ai_ajax",
              ai_check: ai_data_id,
              click: block,
              version: code_version,
              type: click_type,
            },
            async: true
        }).done (function (data) {
            if (ai_debug) {
              data = data.trim ();
              if (data != "") {
                var db_records = JSON.parse (data);

                if (ai_debug) {
                  console.log ("AI DB RECORDS: ", db_records);
                }

                if (typeof db_records ['#'] != 'undefined' && db_records ['#'] == block) {
                  $('span[data-ai-block=' + block + ']').closest ("div[data-ai]").remove ();

                  var date = new Date();
                  var closed_until = Math.round (date.getTime() / 1000) + 12 * 3600;

                  if (ai_debug) console.log ("AI SERVERSIDE LIMITED BLOCK:", block);

                  if (!ai_cookie.hasOwnProperty (block) || !ai_cookie [block].hasOwnProperty ('x')) {
                    if (ai_debug) console.log ("AI SERVERSIDE LIMITED BLOCK:", block, ' cookie set');

                    ai_set_cookie (block, 'x', closed_until);
                  }
                }

                var db_record = db_records ['='];
                if (typeof db_record == "string")
                  console.log ("AI CLICK " + block, code_version == 0 ? "" : "[" + code_version + "]", "(" + db_record + ")"); else
                    console.log ("AI CLICK " + block, code_version == 0 ? "" : "[" + code_version + "]", "(Views: " + db_record [4] + ", Clicks: " + db_record [5] + (click_type == "" ? "" : ", " + click_type) + ")");
              } else console.log ("AI CLICK " + block, code_version == 0 ? "" : "[" + code_version + "]", "(NO DATA" + (click_type == "" ? "" : ", " + click_type) + ")");

              console.log ('');
            }
        });
      }

      if (ai_external_tracking) {
        var block_name         = data [2];
        var code_version_name  = data [3];

        external_tracking ("click", block, block_name, code_version, code_version_name, false);
      }
    }
  }

  ai_install_standard_click_trackers = function (block_wrapper) {
    var ai_debug = typeof ai_debugging !== 'undefined'; // 3
//    var ai_debug = false;

    if (typeof block_wrapper == 'undefined') {
      var elements = $("div.ai-track[data-ai]:visible a");

      var filtered_elements = $();
      elements.each (function () {
        var ai_lazy_loading = $(this).find ('div.ai-lazy');
        if (ai_lazy_loading.length == 0) filtered_elements = filtered_elements.add ($(this));
      });

      elements = filtered_elements;

      // Mark as tracked
      elements.removeClass ('ai-track');
    } else {
        var elements = [];
        if (typeof $(block_wrapper).attr ("data-ai") != "undefined" && $(block_wrapper).hasClass ('ai-track') && $(block_wrapper).is (':visible') && $(block_wrapper).find ('div.ai-lazy').length == 0) {
          var elements = $("a", block_wrapper);
          // Mark as tracked
          $(block_wrapper).removeClass ('ai-track');
        }
      }

    if (elements.length != 0) {
      if (ai_advanced_click_detection) {
        elements.click (function () {
          var wraper = $(this).closest ("div[data-ai]");
          if (typeof wraper.attr ("data-ai") != "undefined") {
            var data = JSON.parse (b64d (wraper.attr ("data-ai")));
            if (typeof data !== "undefined" && data.constructor === Array) {
              if (Number.isInteger (data [1])) {
                if (!wraper.hasClass ("clicked")) {
                  wraper.addClass ("clicked");
                  ai_click (data, "a.click");
                }
              }
            }
          }
        });

        if (ai_debug) {
          elements.each (function (){
            var wraper = $(this).closest ("div[data-ai]");
            if (typeof wraper.attr ("data-ai") != "undefined") {
              var data = JSON.parse (b64d (wraper.data ("ai")));
              if (typeof data !== "undefined" && data.constructor === Array) {
                if (Number.isInteger (data [1])) {
                  if (!wraper.hasClass ("clicked")) {
                    console.log ("AI STANDARD CLICK TRACKER for link installed on block", data [0]);
                  } else console.log ("AI STANDARD CLICK TRACKER for link NOT installed on block", data [0], "- has class clicked");
                } else console.log ("AI STANDARD CLICK TRACKER for link NOT installed on block", data [0], "- version not set");

              }
            }
          });
        }
      } else {
          elements.click (function () {
            if (typeof $(this).closest ("div[data-ai]").attr ("data-ai") != "undefined") {
              var data = JSON.parse (b64d ($(this).closest ("div[data-ai]").attr ("data-ai")));
              if (typeof data !== "undefined" && data.constructor === Array) {
                if (Number.isInteger (data [1])) {
                  ai_click (data, "a.click");
                }
              }
            }
          });

          if (ai_debug) {
            elements.each (function (){
              var wraper = $(this).closest ("div[data-ai]");
              if (typeof wraper.attr ("data-ai") != "undefined") {
                var data = JSON.parse (b64d (wraper.attr ("data-ai")));
                if (typeof data !== "undefined" && data.constructor === Array) {
                  if (Number.isInteger (data [1])) {
                    console.log ("AI STANDARD CLICK TRACKER installed on block", data [0]);
                  } else console.log ("AI STANDARD CLICK TRACKER NOT installed on block", data [0], "- version not set");

                }
              }
            });
          }
        }
    }
  }

  ai_install_click_trackers = function (block_wrapper) {

    var ai_debug = typeof ai_debugging !== 'undefined'; // 4
//    var ai_debug = false;

    if (ai_advanced_click_detection) {

      if (typeof block_wrapper == 'undefined') {
        var elements = $("div.ai-track[data-ai]:visible");

        var filtered_elements = $();
        elements.each (function () {
          var ai_lazy_loading = $(this).find ('div.ai-lazy');
          if (ai_lazy_loading.length == 0) filtered_elements = filtered_elements.add ($(this));
        });

        elements = filtered_elements;
        elements.removeClass ('ai-track');
      } else {
          var elements = [];
          if (typeof $(block_wrapper).attr ("data-ai") != "undefined" && $(block_wrapper).hasClass ('ai-track') && $(block_wrapper).is (':visible') && $(block_wrapper).find ('div.ai-lazy').length == 0) {
            var elements = block_wrapper;
            elements.removeClass ('ai-track');
          }
        }

      if (elements.length != 0) {
        elements.iframeTracker ({
          blurCallback: function(){
            if (this.ai_data != null && wraper != null) {
              if (ai_debug) console.log ("AI blurCallback for block: " + this.ai_data [0]);
              if (!wraper.hasClass ("clicked")) {
                wraper.addClass ("clicked");
                ai_click (this.ai_data, "blurCallback");
              }
            }
          },
          overCallback: function(element){
            var closest = $(element).closest ("div[data-ai]");
            if (typeof closest.attr ("data-ai") != "undefined") {
              var data = JSON.parse (b64d (closest.attr ("data-ai")));
              if (typeof data !== "undefined" && data.constructor === Array && Number.isInteger (data [1])) {
                wraper = closest;
                this.ai_data = data;
                if (ai_debug) console.log ("AI overCallback for block: " + this.ai_data [0]);
              } else {
                  if (wraper != null) wraper.removeClass ("clicked");
                  wraper        = null;
                  this.ai_data  = null;
                }
            }
          },
          outCallback: function (element){
            if (ai_debug && this.ai_data != null) console.log ("AI outCallback for block: " + this.ai_data [0]);
            if (wraper != null) wraper.removeClass ("clicked");
            wraper = null;
            this.ai_data = null;
          },
          focusCallback: function(element){
            if (this.ai_data != null && wraper != null) {
              if (ai_debug) console.log ("AI focusCallback for block: " + this.ai_data [0]);
              if (!wraper.hasClass ("clicked")) {
                wraper.addClass ("clicked");
                ai_click (this.ai_data, "focusCallback");
              }
            }
          },
          wraper:  null,
          ai_data: null,
          block:   null,
          version: null
        });

        if (ai_debug) {
          elements.each (function (){
            var closest = $(this).closest ("div[data-ai]");
            if (typeof closest.attr ("data-ai") != "undefined") {
              var data = JSON.parse (b64d (closest.attr ("data-ai")));
              if (typeof data !== "undefined" && data.constructor === Array) {
  //              if (Number.isInteger (data [1])) {
                  console.log ("AI ADVANCED CLICK TRACKER installed on block", data [0]);
  //              } else console.log ("AI ADVANCED CLICK TRACKER NOT installed on block", data [0], "- version not set");
              }
            }
          });
        }
      }
    }

    ai_install_standard_click_trackers (block_wrapper);
  }

  ai_process_impressions = function (block_wrapper) {

    var ai_debug = typeof ai_debugging !== 'undefined'; // 5
//    var ai_debug = false;

    var blocks = [];
    var versions = [];
    var block_names = [];
    var version_names = [];

    if (typeof block_wrapper == 'undefined') {
      var blocks_for_tracking = $("div.ai-track[data-ai]:visible");
    } else {
        var blocks_for_tracking = [];
        if (typeof $(block_wrapper).attr ("data-ai") != "undefined" && $(block_wrapper).hasClass ('ai-track') && $(block_wrapper).is (':visible')) {
          blocks_for_tracking.push (block_wrapper);
        }
      }

    if (blocks_for_tracking.length != 0) {
      if (ai_debug) console.log ("");

      $(blocks_for_tracking).each (function (){

        if (typeof $(this).attr ("data-ai") != "undefined") {
          var data = JSON.parse (b64d ($(this).attr ("data-ai")));


          if (typeof data !== "undefined" && data.constructor === Array) {
            if (ai_debug) console.log ("AI TRACKING DATA:", data);

            var timed_rotation_count = 0;
            var ai_rotation_info = $(this).find ('div.ai-rotate[data-info]');
            if (ai_rotation_info.length == 1) {
              var block_rotation_info = JSON.parse (b64d (ai_rotation_info.data ('info')));

              if (ai_debug) console.log ("AI TIMED ROTATION DATA:", block_rotation_info);

              timed_rotation_count = block_rotation_info [1];
            }

            if (Number.isInteger (data [0]) && data [0] != 0) {
              if (Number.isInteger (data [1])) {

                var adb_flag = 0;
                // Deprecated
                var no_tracking = $(this).hasClass ('ai-no-tracking');

                if (typeof ai_adb === "boolean") {
                  var outer_height = $(this).outerHeight ();

                  var ai_attributes = $(this).find ('.ai-attributes');
                  if (ai_attributes.length) {
                    ai_attributes.each (function (){
                      if (outer_height >= $(this).outerHeight ()) {
                        outer_height -= $(this).outerHeight ();
                      }
                    });
                  }

                  var ai_code = $(this).find ('.ai-code');
                  if (ai_code.length) {
                    outer_height = 0;
                    ai_code.each (function (){
                      outer_height += $(this).outerHeight ();
                    });
                  }

  //                no_tracking = $(this).hasClass ('ai-no-tracking');
                  if (ai_debug) console.log ('AI ad blocking:', ai_adb, " outerHeight:", outer_height, 'no tracking:', no_tracking);
                  if (ai_adb && outer_height === 0) {
                    adb_flag = 0x80;
                  }
                }

                var ai_lazy_loading = $(this).find ('div.ai-lazy');
                if (ai_lazy_loading.length != 0) {
                  no_tracking = true;

                  if (ai_debug) console.log ("AI TRACKING block", data [0], "is set for lazy loading");
                }

                if (!no_tracking) {
                  if (timed_rotation_count == 0) {
                    blocks.push (data [0]);
                    versions.push (data [1] | adb_flag);
                    block_names.push (data [2]);
                    version_names.push (data [3]);
                  } else {
                      // Timed rotation
                      for (var option = 1; option <= timed_rotation_count; option ++) {
                        blocks.push (data [0]);
                        versions.push (option | adb_flag);
                        block_names.push (data [2]);
                        version_names.push (data [3]);
                      }
                    }

                } else if (ai_debug) console.log ("AI TRACKING block", data [0], "DISABLED");

              } else if (ai_debug) console.log ("AI TRACKING block", data [0], "- version not set", $(this).find ('div.ai-lazy').length != 0 ? 'LAZY LOADING' : '');
            } else if (ai_debug) console.log ("AI TRACKING DISABLED");
          }
        }
      });
    }

    if (ai_debug) console.log ('AI CHECK IMPRESSIONS blocks', blocks);
    if (ai_debug) console.log ('AI CHECK IMPRESSIONS data', ai_check_data);

    ai_cookie = ai_load_cookie ();

    for (var cookie_block in ai_cookie) {

      if (!blocks.includes (parseInt (cookie_block))) continue;

      for (var cookie_block_property in ai_cookie [cookie_block]) {
        if (cookie_block_property == 'i') {
          if (ai_debug) console.log ('AI CHECK IMPRESSIONS block:', cookie_block);

          var impressions = ai_cookie [cookie_block][cookie_block_property];
          if (impressions > 0) {
            if (ai_debug) console.log ('AI IMPRESSION, block', cookie_block, 'remaining', impressions - 1, 'impressions');

            if (impressions == 1) {
              var date = new Date();
                var closed_until = Math.round (date.getTime() / 1000) + 7 * 24 * 3600;
//              // TEST
//              var closed_until = Math.round (date.getTime() / 1000) + 36;
              ai_set_cookie (cookie_block, 'i', - closed_until);
            } else ai_set_cookie (cookie_block, 'i', impressions - 1);
          }
        } else

        if (cookie_block_property == 'ipt') {
          if (ai_debug) console.log ('AI CHECK IMPRESSIONS PER TIME PERIOD block:', cookie_block);

          var impressions = ai_cookie [cookie_block][cookie_block_property];
          if (impressions > 0) {
            if (ai_debug) console.log ('AI IMPRESSIONS, block', cookie_block, 'remaining', impressions - 1, 'impressions per time period');

            ai_set_cookie (cookie_block, 'ipt', impressions - 1);
          } else {
              if (ai_check_data.hasOwnProperty (cookie_block) && ai_check_data [cookie_block].hasOwnProperty ('ipt') && ai_check_data [cookie_block].hasOwnProperty ('it')) {
                if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('it')) {
                  var date = new Date();
                  var closed_for = ai_cookie [cookie_block]['it'] - Math.round (date.getTime() / 1000);
                  if (closed_for <= 0) {
                    if (ai_debug) console.log ('AI IMPRESSIONS, block', cookie_block, 'set max impressions period (' + ai_check_data [cookie_block]['it'], 'days =', ai_check_data [cookie_block]['it'] * 24 * 3600, 's)');

                    var timestamp = Math.round (date.getTime() / 1000);

                    ai_set_cookie (cookie_block, 'ipt', ai_check_data [cookie_block]['ipt']);
                    ai_set_cookie (cookie_block, 'it', Math.round (timestamp + ai_check_data [cookie_block]['it'] * 24 * 3600));
                  }
                }
              } else {
                  if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('ipt')) {
                    if (ai_debug) console.log ('AI IMPRESSIONS, block', cookie_block, 'removing ipt');

                    ai_set_cookie (cookie_block, 'ipt', '');
                  }
                  if (ai_cookie.hasOwnProperty (cookie_block) && ai_cookie [cookie_block].hasOwnProperty ('it')) {
                    if (ai_debug) console.log ('AI IMPRESSIONS, block', cookie_block, 'removing it');

                    ai_set_cookie (cookie_block, 'it', '');
                  }
                }
            }
        }
      }
    }

    if (blocks.length) {
      if (ai_debug) {
        console.log ("AI IMPRESSION blocks:", blocks);
        console.log ("            versions:", versions);
      }

      if (ai_internal_tracking) {
        $.ajax ({
            url: ajax_url,
            type: "post",
            data: {
              action: "ai_ajax",
              ai_check: ai_data_id,
              views: blocks,
              versions: versions,
            },
            async: true
        }).done (function (data) {
            data = data.trim ();
            if (data != "") {
              var db_records = JSON.parse (data);

              if (ai_debug) {
                console.log ("AI DB RECORDS: ", db_records);
              }

              if (typeof db_records ['#'] != 'undefined') {
                var date = new Date();
                var closed_until = Math.round (date.getTime() / 1000) + 12 * 3600;

                for (var limited_block in db_records ['#']) {
                  if (ai_debug) console.log ("AI SERVERSIDE LIMITED BLOCK:", db_records ['#'][limited_block]);

                  if (!ai_cookie.hasOwnProperty (db_records ['#'][limited_block]) || !ai_cookie [db_records ['#'][limited_block]].hasOwnProperty ('x')) {
                    if (ai_debug) console.log ("AI SERVERSIDE LIMITED BLOCK:", db_records ['#'][limited_block], ' cookie set');

                    ai_set_cookie (db_records ['#'][limited_block], 'x', closed_until);
                  }
                }
              }

              if (ai_debug) console.log ('');
            }

        });
      }

      if (ai_external_tracking) {
        for (var i = 0; i < blocks.length; i++) {
          external_tracking ("impression", blocks [i],  block_names [i], versions [i], version_names [i], true);
        }
      }
    }
  }

  function ai_process_pageview_checks () {

    var ai_debug = typeof ai_debugging !== 'undefined'; // 6
//    var ai_debug = false;

    ai_check_data = {};

    if (typeof ai_iframe != 'undefined') return;

    if (ai_debug) console.log ('AI PROCESS PAGEVIEW CHECKS');

    ai_cookie = ai_load_cookie ();

    $('.ai-check-block').each (function () {

      var block = $(this).data ('ai-block');
      var delay_pv = $(this).data ('ai-delay-pv');
      var every_pv = $(this).data ('ai-every-pv');

      var code_hash             = $(this).data ('ai-hash');
      var max_imp               = $(this).data ('ai-max-imp');
      var limit_imp_per_time    = $(this).data ('ai-limit-imp-per-time');
      var limit_imp_time        = $(this).data ('ai-limit-imp-time');
      var max_clicks            = $(this).data ('ai-max-clicks');
      var limit_clicks_per_time = $(this).data ('ai-limit-clicks-per-time');
      var limit_clicks_time     = $(this).data ('ai-limit-clicks-time');

      if (ai_debug) console.log ('AI CHECK INITIAL DATA, block:', block);

      if (typeof delay_pv != 'undefined' && delay_pv > 0) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }
        ai_check_data [block]['d'] = delay_pv;

        var cookie_delay_pv = '';
        if (ai_cookie.hasOwnProperty (block)) {
          if (ai_cookie [block].hasOwnProperty ('d')) {
            cookie_delay_pv = ai_cookie [block]['d'];
          }
        }

        if (cookie_delay_pv === '') {
          if (ai_debug) console.log ('AI CHECK PAGEVIEWS, block:', block, 'delay:', delay_pv);

          ai_set_cookie (block, 'd', delay_pv - 1);
        }
      }

      if (typeof every_pv != 'undefined' && every_pv >= 2) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }

        if (typeof ai_delay_showing_pageviews === 'undefined' && (!ai_cookie.hasOwnProperty (block) || !ai_cookie [block].hasOwnProperty ('d'))) {
          // Set d to process e
          if (!ai_cookie.hasOwnProperty (block)) {
            ai_cookie [block] = {};
          }
          ai_cookie [block]['d'] = 0;
        }

        ai_check_data [block]['e'] = every_pv;
      }

      if (typeof max_imp != 'undefined' && max_imp > 0) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }
        ai_check_data [block]['i'] = max_imp;
        ai_check_data [block]['h'] = code_hash;

        var cookie_code_hash = '';
        var cookie_max_imp = '';
        if (ai_cookie.hasOwnProperty (block)) {
          if (ai_cookie [block].hasOwnProperty ('i')) {
            cookie_max_imp = ai_cookie [block]['i'];
          }
          if (ai_cookie [block].hasOwnProperty ('h')) {
            cookie_code_hash = ai_cookie [block]['h'];
          }
        }

        if (cookie_max_imp === '' || cookie_code_hash != code_hash) {
          if (ai_debug) console.log ('AI CHECK IMPRESSIONS, block:', block, 'max', max_imp, 'impressions', 'hash', code_hash);

          ai_set_cookie (block, 'i', max_imp);
          ai_set_cookie (block, 'h', code_hash);
        }
      } else {
          if (ai_cookie.hasOwnProperty (block) && ai_cookie [block].hasOwnProperty ('i')) {
            if (ai_debug) console.log ('AI IMPRESSIONS, block', block, 'removing i');

            ai_set_cookie (block, 'i', '');
            if (!ai_cookie [block].hasOwnProperty ('c') && !ai_cookie [block].hasOwnProperty ('x')) {
              ai_set_cookie (block, 'h', '');
            }
          }
        }

      if (typeof limit_imp_per_time != 'undefined' && limit_imp_per_time > 0 && typeof limit_imp_time != 'undefined' && limit_imp_time > 0) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }
        ai_check_data [block]['ipt'] = limit_imp_per_time;
        ai_check_data [block]['it']  = limit_imp_time;

        var cookie_limit_imp_per_time = '';
        var cookie_limit_imp_time = '';
        if (ai_cookie.hasOwnProperty (block)) {
          if (ai_cookie [block].hasOwnProperty ('ipt')) {
            cookie_limit_imp_per_time = ai_cookie [block]['ipt'];
          }
          if (ai_cookie [block].hasOwnProperty ('it')) {
            cookie_limit_imp_time = ai_cookie [block]['it'];
          }
        }

        if (cookie_limit_imp_per_time === '' || cookie_limit_imp_time === '') {
          if (ai_debug) console.log ('AI CHECK IMPRESSIONS, block:', block, 'max', limit_imp_per_time, 'impresssions per', limit_imp_time, 'days (' + (limit_imp_time * 24 * 3600), 's)');

          ai_set_cookie (block, 'ipt', limit_imp_per_time);

          var date = new Date();
          var timestamp = Math.round (date.getTime() / 1000);

          ai_set_cookie (block, 'it', Math.round (timestamp + limit_imp_time * 24 * 3600));
        }
        if (cookie_limit_imp_time > 0) {
          var date = new Date();
          var timestamp = Math.round (date.getTime() / 1000);

          if (cookie_limit_imp_time <= timestamp) {
            if (ai_debug) console.log ('AI CHECK IMPRESSIONS, block:', block, 'reset max', limit_imp_per_time, 'impresssions per', limit_imp_time, 'days (' + (limit_imp_time * 24 * 3600), 's)');

            ai_set_cookie (block, 'ipt', limit_imp_per_time);
            ai_set_cookie (block, 'it', Math.round (timestamp + limit_imp_time * 24 * 3600));
          }
        }
      } else {
          if (ai_cookie.hasOwnProperty (block)) {
            if (ai_cookie [block].hasOwnProperty ('ipt')) ai_set_cookie (block, 'ipt', '');
            if (ai_cookie [block].hasOwnProperty ('it'))  ai_set_cookie (block, 'it',  '');
          }
        }

      if (typeof max_clicks != 'undefined' && max_clicks > 0) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }
        ai_check_data [block]['c'] = max_clicks;
        ai_check_data [block]['h'] = code_hash;

        var cookie_code_hash = '';
        var cookie_max_clicks = '';
        if (ai_cookie.hasOwnProperty (block)) {
          if (ai_cookie [block].hasOwnProperty ('c')) {
            cookie_max_clicks = ai_cookie [block]['c'];
          }
          if (ai_cookie [block].hasOwnProperty ('h')) {
            cookie_code_hash = ai_cookie [block]['h'];
          }
        }

        if (cookie_max_clicks === '' || cookie_code_hash != code_hash) {
          if (ai_debug) console.log ('AI CHECK CLICKS, block:', block, 'max', max_clicks, 'clicks', 'hash', code_hash);

          ai_set_cookie (block, 'c', max_clicks);
          ai_set_cookie (block, 'h', code_hash);
        }
      } else {
          if (ai_cookie.hasOwnProperty (block) && ai_cookie [block].hasOwnProperty ('c')) {
            if (ai_debug) console.log ('AI CLICKS, block', block, 'removing c');

            ai_set_cookie (block, 'c', '');
            if (!ai_cookie [block].hasOwnProperty ('i') && !ai_cookie [block].hasOwnProperty ('x')) {
              ai_set_cookie (block, 'h', '');
            }
          }
        }

      if (typeof limit_clicks_per_time != 'undefined' && limit_clicks_per_time > 0 && typeof limit_clicks_time != 'undefined' && limit_clicks_time > 0) {
        if (!ai_check_data.hasOwnProperty (block)) {
          ai_check_data [block] = {};
        }
        ai_check_data [block]['cpt'] = limit_clicks_per_time;
        ai_check_data [block]['ct']  = limit_clicks_time;

        var cookie_limit_clicks_per_time = '';
        var cookie_limit_clicks_time = '';
        if (ai_cookie.hasOwnProperty (block)) {
          if (ai_cookie [block].hasOwnProperty ('cpt')) {
            cookie_limit_clicks_per_time = ai_cookie [block]['cpt'];
          }
          if (ai_cookie [block].hasOwnProperty ('ct')) {
            cookie_limit_clicks_time = ai_cookie [block]['ct'];
          }
        }

        if (cookie_limit_clicks_per_time === '' || cookie_limit_clicks_time === '') {
          if (ai_debug) console.log ('AI CHECK CLICKS, block:', block, 'max', limit_clicks_per_time, 'clicks per', limit_clicks_time, 'days (' + (limit_clicks_time * 24 * 3600), 's)');

          ai_set_cookie (block, 'cpt', limit_clicks_per_time);

          var date = new Date();
          var timestamp = Math.round (date.getTime() / 1000);

          ai_set_cookie (block, 'ct', Math.round (timestamp + limit_clicks_time * 24 * 3600));
        }
        if (cookie_limit_clicks_time > 0) {
          var date = new Date();
          var timestamp = Math.round (date.getTime() / 1000);

          if (cookie_limit_clicks_time <= timestamp) {
            if (ai_debug) console.log ('AI CHECK CLICKS, block:', block, 'reset max', limit_clicks_per_time, 'clicks per', limit_clicks_time, 'days (' + (limit_clicks_time * 24 * 3600), 's)');

            ai_set_cookie (block, 'cpt', limit_clicks_per_time);
            ai_set_cookie (block, 'ct', Math.round (timestamp + limit_clicks_time * 24 * 3600));
          }
        }
      } else {
          if (ai_cookie.hasOwnProperty (block)) {
            if (ai_cookie [block].hasOwnProperty ('cpt')) ai_set_cookie (block, 'cpt', '');
            if (ai_cookie [block].hasOwnProperty ('ct'))  ai_set_cookie (block, 'ct', '');
          }
        }
    });

    if (ai_debug) console.log ('');
    if (ai_debug) console.log ('AI PROCESS CHECKS', ai_check_data);


    if (ai_debug) console.log ('AI CHECK PAGEVIEWS');

    for (var cookie_block in ai_cookie) {
      for (var cookie_block_property in ai_cookie [cookie_block]) {
        if (cookie_block_property == 'd') {
          if (ai_debug) console.log ('AI CHECK PAGEVIEWS block:', cookie_block);

          var delay = ai_cookie [cookie_block][cookie_block_property];
          if (delay > 0) {
            if (ai_debug) console.log ('AI PAGEVIEW, block', cookie_block, 'delayed for', delay - 1, 'pageviews');

            ai_set_cookie (cookie_block, 'd', delay - 1);
          } else {
              if (ai_check_data.hasOwnProperty (cookie_block) && ai_check_data [cookie_block].hasOwnProperty ('e')) {
                if (ai_debug) console.log ('AI PAGEVIEW, block', cookie_block, 'show every', ai_check_data [cookie_block]['e'], 'pageviews, delayed for', ai_check_data [cookie_block]['e'] - 1, 'pageviews');

                ai_set_cookie (cookie_block, 'd', ai_check_data [cookie_block]['e'] - 1);
              } else {
                  if (!ai_check_data.hasOwnProperty (cookie_block) || !ai_check_data [cookie_block].hasOwnProperty ('d')) {
                    if (ai_debug) console.log ('AI PAGEVIEW, block', cookie_block, 'removing d');

                    ai_set_cookie (cookie_block, 'd', '');
                  }
                }
            }
        }
      }
    }
  }

  function ai_log_impressions () {

    var ai_debug = typeof ai_debugging !== 'undefined'; // 7
//    var ai_debug = false;

    if (ai_track_pageviews) {
      var client_width = document.documentElement.clientWidth, inner_width =  window.innerWidth;
      var viewport_width = client_width < inner_width ? inner_width : client_width;

      var version = 0;
      $.each (ai_viewports, function (index, width) {
        if (viewport_width >= width) {
          version = index + 1;
          return (false);
        }
      });

      if (ai_debug) console.log ('AI TRACKING PAGEVIEW, viewport width:', viewport_width, '=>', ai_viewport_names [version - 1]);

      if (typeof ai_adb === "boolean" && ai_adb) {
        if (ai_external_tracking) {
          external_tracking ("ad blocking", 0, ai_viewport_names [version - 1], 0, '', true);
        }
        version |= 0x80;
      }

      if (ai_internal_tracking) {
        $.ajax ({
            url: ajax_url,
            type: "post",
            data: {
              action: "ai_ajax",
              ai_check: ai_data_id,
              views: [0],
              versions: [version],
            },
            async: true
        }).done (function (data) {
            if (ai_debug) {
              data = data.trim ();
              if (data != "") {
                var db_records = JSON.parse (data);
                console.log ("AI DB RECORDS: ", db_records);
              }
            }
        });
      }
    }
    ai_process_pageview_checks ();

    ai_tracking_finished = true;
    ai_process_impressions ();
  }

  jQuery (window).on ('load', function () {
    setTimeout (ai_log_impressions, 1200);
    setTimeout (ai_install_click_trackers, 1300);
  });
});

