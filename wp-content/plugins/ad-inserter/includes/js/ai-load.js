/**
 * Based on yall - Yet Another Lazy loader
 * https://github.com/malchata/yall.js
 **/

const alLoad = function (element, env) {

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

  if (element.tagName === "DIV") {
    if (typeof element.dataset.code != 'undefined') {
      var ai_debug = typeof ai_debugging !== 'undefined'; // 1
//      var ai_debug = false;

      // Using jQuery to properly load AdSense
      jQuery (element).prepend (b64d (element.dataset.code));

      element.removeAttribute("data-code");

      var classes = '';
      var wrapper = element.closest ('.' + b64d (element.dataset.class));

      if (ai_debug) {
        console.log ('');

        if (wrapper != null) {
          classes = wrapper.className;
        }
        console.log ('AI LAZY LOADING', classes);
      }
      element.removeAttribute("data-class");
      element.removeAttribute("class");

      if (typeof ai_process_lists == 'function') {
        ai_process_lists        (jQuery("div.ai-list-data", element)); // Doesn't process rotations
      }
      if (typeof ai_process_ip_addresses == 'function') {
        ai_process_ip_addresses (jQuery("div.ai-ip-data",   element));
      }
      if (typeof ai_process_rotations_in_element == 'function') {
        ai_process_rotations_in_element (element);
      }

      if (typeof ai_process_impressions == 'function' && wrapper != null && ai_tracking_finished == true) {
//        ai_process_impressions (jQuery (wrapper));
        ai_process_impressions ();
      }

      if (typeof ai_install_click_trackers == 'function' && wrapper != null && ai_tracking_finished == true) {
//        ai_install_click_trackers (jQuery (wrapper));
        ai_install_click_trackers ();
      }
      if (typeof ai_install_close_buttons == 'function' && wrapper != null) {
        ai_install_close_buttons (wrapper);
      }
    }
  }
};

const aiLazyLoading = function (userOptions) {
  const env = {
    intersectionObserverSupport: "IntersectionObserver" in window && "IntersectionObserverEntry" in window && "intersectionRatio" in window.IntersectionObserverEntry.prototype,
    mutationObserverSupport: "MutationObserver" in window,
    idleCallbackSupport: "requestIdleCallback" in window,
    eventsToBind: [
      [document, "scroll"],
      [document, "touchmove"],
      [window, "resize"],
      [window, "orientationchange"]
    ]
  };

  const options = {
    lazyClass: "ai-lazy",
    lazyElement: null,
    throttleTime: 200,
    idlyLoad: false,
    idleLoadTimeout: 100,
    threshold: AI_FUNC_GET_LAZY_LOADING_OFFSET,
    observeChanges: false,
    observeRootSelector: "body",
    mutationObserverOptions: {
      childList: true
    },
    ...userOptions
  };
  const selectorString = `div.${options.lazyClass}`;
  const idleCallbackOptions = {
    timeout: options.idleLoadTimeout
  };

  if (options.lazyElement == null) {
    var lazyElements = [].slice.call(document.querySelectorAll(selectorString));
  } else {
      var lazyElements = [].push (options.lazyElement);
    }

  if (env.intersectionObserverSupport === true) {
    var intersectionListener = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        let element = entry.target;

        if (entry.isIntersecting === true) {
          if (options.idlyLoad === true && env.idleCallbackSupport === true) {
            requestIdleCallback(() => {
              alLoad(element, env);
            }, idleCallbackOptions);
          } else {
            alLoad(element, env);
          }

          element.classList.remove(options.lazyClass);
          observer.unobserve(element);

          lazyElements = lazyElements.filter((lazyElement) => {
            return lazyElement !== element;
          });
        }
      });
    }, {
      rootMargin: `${options.threshold}px 0%`
    });

    lazyElements.forEach((lazyElement) => intersectionListener.observe(lazyElement));
  } else {
    var lazyloadBack = () => {
      let active = false;

      if (active === false && lazyElements.length > 0) {
        active = true;

        setTimeout(() => {
          lazyElements.forEach((lazyElement) => {
            if (lazyElement.getBoundingClientRect().top <= (window.innerHeight + options.threshold) && lazyElement.getBoundingClientRect().bottom >= -(options.threshold) && getComputedStyle(lazyElement).display !== "none") {
              if (options.idlyLoad === true && env.idleCallbackSupport === true) {
                requestIdleCallback(() => {
                  alLoad(lazyElement, env);
                }, idleCallbackOptions);
              } else {
                alLoad(lazyElement, env);
              }

              lazyElement.classList.remove(options.lazyClass);

              lazyElements = lazyElements.filter((element) => {
                return element !== lazyElement;
              });
            }
          });

          active = false;

          if (lazyElements.length === 0 && options.observeChanges === false) {
            env.eventsToBind.forEach((eventPair) => eventPair[0].removeEventListener(eventPair[1], lazyloadBack));
          }
        }, options.throttleTime);
      }
    };

    env.eventsToBind.forEach((eventPair) => eventPair[0].addEventListener(eventPair[1], lazyloadBack));

    lazyloadBack();
  }

  if (env.mutationObserverSupport === true && options.observeChanges === true) {
    const mutationListener = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        [].slice.call(document.querySelectorAll(selectorString)).forEach((newElement) => {
          if (lazyElements.indexOf(newElement) === -1) {
            lazyElements.push(newElement);

            if (env.intersectionObserverSupport === true) {
              intersectionListener.observe(newElement);
            } else {
              lazyloadBack();
            }
          }
        });
      });
    });

    mutationListener.observe(document.querySelector(options.observeRootSelector), options.mutationObserverOptions);
  }
};

jQuery (function ($) {
  $(document).ready(function($) {
    setTimeout (function() {aiLazyLoading ({
      lazyClass: 'ai-lazy',
//      lazySelector: "div.ai-lazy",
      observeChanges: true,
      mutationObserverOptions: {
        childList: true,
        attributes: true,
        subtree: true
      }
    });}, 5);
  });
});
