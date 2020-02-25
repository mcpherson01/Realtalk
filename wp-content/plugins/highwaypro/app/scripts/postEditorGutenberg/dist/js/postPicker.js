(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("React"));
	else if(typeof define === 'function' && define.amd)
		define(["React"], factory);
	else if(typeof exports === 'object')
		exports["NelioBlocks"] = factory(require("React"));
	else
		root["NelioBlocks"] = factory(root["React"]);
})(typeof self !== 'undefined' ? self : this, function(__WEBPACK_EXTERNAL_MODULE_5__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return HighWayPro; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__events__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__metabox_UrlPostMetaBoxManager__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__HighWayProApp__ = __webpack_require__(16);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }





var ClassicAddShortUrlButton = __webpack_require__(11).default;

var GutenbergAddShortUrlButton = __WEBPACK_IMPORTED_MODULE_2__HighWayProApp__["a" /* HighWayProApp */].gutenbergIsEnabled() ? __webpack_require__(6).default : {};

var _window = window,
    ReactDOM = _window.ReactDOM;


var HighWayPro = function () {
    function HighWayPro() {
        _classCallCheck(this, HighWayPro);

        this.state = {
            urlPickerReceiver: null
        };

        jQuery(document).ready(this.initialize.bind(this));
    }

    _createClass(HighWayPro, [{
        key: 'initialize',
        value: function initialize() {
            HighWayPro.instance = this;

            if (window.tinymce) {
                ClassicAddShortUrlButton.register();
            }

            if (__WEBPACK_IMPORTED_MODULE_2__HighWayProApp__["a" /* HighWayProApp */].gutenbergIsEnabled()) {
                GutenbergAddShortUrlButton.register();
            }

            new __WEBPACK_IMPORTED_MODULE_1__metabox_UrlPostMetaBoxManager__["a" /* UrlPostMetaBoxManager */]();
        }
    }, {
        key: 'changeState',
        value: function changeState(newState) {
            var propertiesChanged = [];

            for (var name in newState) {
                propertiesChanged.push(name);
                this.state[name] = newState[name];
            }

            this.callChangeEvents(propertiesChanged);
        }
    }, {
        key: 'callChangeEvents',
        value: function callChangeEvents(propertiesChanged) {
            var event = {
                newState: this.state,
                propertiesChanged: propertiesChanged
            };

            var _iteratorNormalCompletion = true;
            var _didIteratorError = false;
            var _iteratorError = undefined;

            try {
                for (var _iterator = propertiesChanged[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                    var property = _step.value;

                    var eventName = HighWayPro.EVENTS.CHANGE[property.toUpperCase()];

                    eventName && __WEBPACK_IMPORTED_MODULE_0__events__["a" /* Events */].call(eventName, event);
                }
            } catch (err) {
                _didIteratorError = true;
                _iteratorError = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion && _iterator.return) {
                        _iterator.return();
                    }
                } finally {
                    if (_didIteratorError) {
                        throw _iteratorError;
                    }
                }
            }

            __WEBPACK_IMPORTED_MODULE_0__events__["a" /* Events */].call(HighWayPro.STATE_CHANGE_EVENT, event);
        }
    }]);

    return HighWayPro;
}();
HighWayPro.EVENTS = {
    CHANGE: {
        URLPICKERRECEIVER: 'HighWayPro.state.change.urlPickerReceiver'
    }
};

/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UrlPicker; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_classnames__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_classnames___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_classnames__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__HighWayProApp__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__domain_urlPicker_UrlPickerReceiver__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utilities_delay__ = __webpack_require__(13);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__images_delete_svg__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__images_delete_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__images_delete_svg__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var _window = window,
    wp = _window.wp;

var Component = __WEBPACK_IMPORTED_MODULE_1__HighWayProApp__["a" /* HighWayProApp */].getComponent();
var $ = jQuery;

var createElement = __WEBPACK_IMPORTED_MODULE_1__HighWayProApp__["a" /* HighWayProApp */].getCreateElement();

var UrlPicker = function (_Component) {
    _inherits(UrlPicker, _Component);

    function UrlPicker() {
        var _ref;

        var _temp, _this, _ret;

        _classCallCheck(this, UrlPicker);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = UrlPicker.__proto__ || Object.getPrototypeOf(UrlPicker)).call.apply(_ref, [this].concat(args))), _this), _this.cache = {
            urls: [
                /*{
                    name: 'HostGator Promo Link',
                    finalUrl: 'neblabs.com/go/hostgator-promo',
                    id: 1
                },
                {
                    name: 'Corebox - Premium Modern WordPress Magazine/Blog/News Theme | Best of 2018',
                    finalUrl: 'neblabs.com/p/98765986',
                    id: 2
                },
                {
                    name: 'HostGator Promo Link',
                    finalUrl: 'neblabs.com/go/hostgator-promo',
                    id: 3
                }*/
            ]
        }, _this.initialState = {
            urls: [],
            isLoading: false,
            currentNavigationUrlIndex: null,
            assignedUrl: null,

            fetchingUrl: false,
            isFetchingSearchedUrls: false,
            searchText: '',

            isOpened: false,
            isOpening: false,
            isClosed: true,
            isClosing: false
        }, _this.state = Object.assign({}, _this.initialState), _this.classes = {
            withUrls: '--hwpro-with-results',
            urlPicker: 'hwpro-url-picker'
        }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(UrlPicker, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            document.addEventListener('click', this.handleOutsideClick.bind(this));
        }
    }, {
        key: 'componentDidUpdate',
        value: function componentDidUpdate() {
            if (this.props.isOpen) {
                if (this.props.urlPickerReceiver != this.state.lastUrlPickerReceiver) {
                    this.reset({
                        isClosed: false,
                        isOpened: true
                    });
                }
                this.open();
                this.setUrlIfItHasOne();
            } else if (!this.props.isOpen) {
                this.close();
            }
        }
    }, {
        key: 'render',
        value: function render() {
            return createElement(
                'div',
                {
                    className: this.classes.urlPicker + ' ' + __WEBPACK_IMPORTED_MODULE_0_classnames___default()({
                        'hwpro--isOpened': this.state.isOpened,
                        'hwpro--isOpening': this.props.isOpen,
                        'hwpro--isClosing': !this.props.isOpen,
                        'hwpro--isClosed': this.state.isClosed,
                        'hwpro--Left': this.props.position === 'left'
                    }),
                    onTransitionEnd: this.handleTransitionEnd.bind(this),
                    style: this.props.coordinates
                },
                this.state.fetchingUrl ? createElement(
                    'div',
                    { className: 'hwpro-searching' },
                    createElement(
                        'div',
                        { className: 'lds-ring' },
                        createElement('div', null),
                        createElement('div', null),
                        createElement('div', null),
                        createElement('div', null)
                    )
                ) : createElement(
                    React.Fragment,
                    null,
                    createElement('input', { type: 'search', className: 'hwpro-search', placeholder: window.HighWayProPostEditor.text.urlPicker.enterUrlToSearch, value: this.state.searchText, onChange: this.handleSearchInput.bind(this), onKeyDown: this.handleNavigation.bind(this) }),
                    createElement(
                        'ul',
                        { className: 'hwpro-url-picker-results ' + (this.hasUrls() ? this.classes.withUrls : '') },
                        this.getAssignedUrlItem(),
                        this.getItems()
                    )
                )
            );
        }
    }, {
        key: 'getItems',
        value: function getItems() {
            var _this2 = this;

            if (this.state.isFetchingSearchedUrls) {
                return createElement(
                    'div',
                    { className: 'hwpro-searching' },
                    createElement(
                        'div',
                        { className: 'lds-ring' },
                        createElement('div', null),
                        createElement('div', null),
                        createElement('div', null),
                        createElement('div', null)
                    )
                );
            }

            if (this.hasUrls()) {
                return this.state.urls.map(function (url) {
                    return _this2.getUrlItem(url);
                });
            }

            // finally, no assigned url and no url items to show...
            if (!this.hasAssignedUrl()) {
                return createElement(
                    'div',
                    { className: 'hwpro-no-items' },
                    createElement(
                        'h1',
                        null,
                        window.HighWayProPostEditor.text.urlPicker.noUrls.title
                    ),
                    createElement(
                        'p',
                        null,
                        window.HighWayProPostEditor.text.urlPicker.noUrls.message
                    )
                );
            }
        }
    }, {
        key: 'getUrlItem',
        value: function getUrlItem(url, options) {
            options = options || {};
            var assigned = options.assigned;

            return createElement(
                'li',
                {
                    key: url.id,
                    'data-id': url.id,
                    className: 'hwpro-list-url ' + __WEBPACK_IMPORTED_MODULE_0_classnames___default()({
                        '--hwpro-assigned-url': assigned,
                        '--hwpro-active': this.state.activeUrl && this.state.activeUrl.id === url.id
                    }),
                    onClick:
                    //ignore click on assigned urls, the click event is handled down below
                    assigned ? function () {} : this.handleClick(url)
                },
                createElement(
                    'div',
                    { className: 'hwpro-list-url-item' },
                    createElement(
                        'div',
                        { className: 'hwpro-list-url--name' },
                        url.name
                    ),
                    createElement(
                        'div',
                        { className: 'hwpro-list-url--url' },
                        url.finalUrl
                    )
                ),
                assigned && createElement(
                    'div',
                    { className: 'hwpro-delete', onClick: this.handleClick(null) },
                    createElement(__WEBPACK_IMPORTED_MODULE_4__images_delete_svg___default.a, null)
                )
            );
        }

        /**
         * THIS METHOD IS ALSO USED BY THE DELETE ICON WHEN CLICKED
         * TO REMOVE THE URL
         */

    }, {
        key: 'handleClick',
        value: function handleClick(url) {
            var _this3 = this;

            return function () {
                return _this3.setState({
                    activeUrl: url
                }, _this3.handleDesiredUrlHasBeenSelected.bind(_this3));
            };
        }
    }, {
        key: 'handleSearchInput',
        value: function handleSearchInput(event) {
            this.setState({
                searchText: event.target.value
            }, Object(__WEBPACK_IMPORTED_MODULE_3__utilities_delay__["a" /* delay */])(this.fetchSearchedForUrls.bind(this), 250));
        }
    }, {
        key: 'fetchSearchedForUrls',
        value: function fetchSearchedForUrls() {
            var _this4 = this;

            $.ajax({
                method: 'GET',
                url: window.HighWayProPostEditor.postUrl,
                data: {
                    action: 'highwaypro_post',
                    path: 'urls',
                    data: JSON.stringify({
                        filters: {
                            url: {
                                name: this.state.searchText
                            },
                            limit: 3
                        }
                    })
                },
                dataType: 'json',
                beforeSend: function beforeSend() {
                    return _this4.setState({ isFetchingSearchedUrls: true });
                },
                success: this.handleReceivedUrls.bind(this),
                error: function error() {
                    console.log('an error');
                }
            });
        }
    }, {
        key: 'handleReceivedUrls',
        value: function handleReceivedUrls(response) {
            this.setState({
                isFetchingSearchedUrls: false,
                urls: response.urls
            });
        }
    }, {
        key: 'handleNavigation',
        value: function handleNavigation(event) {
            var _this5 = this;

            if (UrlPicker.NAVIGATION_KEYS.includes(event.key)) {
                event.preventDefault();

                var newNavigationIndex = this.state.currentNavigationUrlIndex;

                switch (event.key) {
                    case 'ArrowDown':
                        if (this.state.currentNavigationUrlIndex < this.state.urls.length - 1) {
                            ++newNavigationIndex;
                        }
                        break;
                    case 'ArrowUp':
                        if (this.state.currentNavigationUrlIndex > 0) {
                            --newNavigationIndex;
                        }
                        break;
                }

                this.setState(function (state) {
                    return {
                        currentNavigationUrlIndex: newNavigationIndex,
                        activeUrl: _this5.state.urls[newNavigationIndex]
                    };
                });
            } else if (event.key === 'Enter') {
                this.handleDesiredUrlHasBeenSelected();
            }
        }
    }, {
        key: 'handleDesiredUrlHasBeenSelected',
        value: function handleDesiredUrlHasBeenSelected() {
            var activeUrl = this.state.activeUrl;

            this.props.urlPickerReceiver.setId(activeUrl ? activeUrl.id : null, this);

            // re-render
            this.close();
        }
    }, {
        key: 'handleOutsideClick',
        value: function handleOutsideClick(event) {
            var target = $(event.target);
            var customAllowableClicableElement = this.props.customAllowableClicableElement ? this.props.customAllowableClicableElement(target) : true;

            var wasClickedOutsidePickerWindow = !target.closest('.' + this.classes.urlPicker).length && !target.closest(this.props.allowedClickableElement).length && customAllowableClicableElement;
            if (this.props.isOpen && wasClickedOutsidePickerWindow) {
                this.props.closeInactive();
            }
        }
    }, {
        key: 'close',
        value: function close() {
            if (this.props.isOpen) {
                this.reset();
                this.props.close();
            }
        }
    }, {
        key: 'reset',
        value: function reset(extra) {
            extra = extra || {};
            this.setState(Object.assign(this.initialState, extra, {
                lastUrlPickerReceiver: this.props.urlPickerReceiver
            }));
        }
    }, {
        key: 'open',
        value: function open() {
            var _this6 = this;

            if (this.state.isOpening || this.state.isOpened) {
                return;
            }

            var then = void 0;

            this.setState({
                isClosing: false,
                isClosed: false,
                isOpened: false,
                isOpening: true
            }, then = function then() {
                // after the display block has been applied...
                // wait for the engine not to apply the classes too early
                window.setTimeout(function () {
                    _this6.setState({
                        isClosing: false,
                        isClosed: false,
                        isOpened: true,
                        isOpening: false
                    });
                }, 50);
            });
        }
    }, {
        key: 'setUrlIfItHasOne',
        value: function setUrlIfItHasOne() {
            var linkId = parseInt(this.props.urlPickerReceiver.getId());

            if (this.state.assignedUrl) {
                return;
            }

            if (linkId) {
                var cachedUrl = this.cache.urls.find(function (url) {
                    return url.id == linkId;
                });

                if (cachedUrl) {
                    this.setAssignedUrl(cachedUrl);
                } else {
                    this.fetchUrl(linkId);
                }
            } else {
                this.setAssignedUrl(null);
            }
        }
    }, {
        key: 'fetchUrl',
        value: function fetchUrl(linkId) {
            var _this7 = this;

            if (!this.state.fetchingUrl) {
                $.ajax({
                    method: 'GET',
                    url: window.HighWayProPostEditor.postUrl,
                    data: {
                        action: 'highwaypro_post',
                        path: 'url',
                        data: JSON.stringify({
                            'id': linkId
                        })
                    },
                    dataType: 'json',
                    beforeSend: function beforeSend() {
                        return _this7.setState({ fetchingUrl: true });
                    },
                    success: this.handleReceivedUrl.bind(this),
                    error: function error() {
                        console.log('an error');
                    }
                });
            }
        }
    }, {
        key: 'handleReceivedUrl',
        value: function handleReceivedUrl(response) {
            this.setAssignedUrl(response.url);
            this.setState({ fetchingUrl: false });
        }
    }, {
        key: 'setAssignedUrl',
        value: function setAssignedUrl(url) {
            if (this.state.assignedUrl != url) {
                this.setState({
                    assignedUrl: url
                });
            }
        }
    }, {
        key: 'hasAssignedUrl',
        value: function hasAssignedUrl() {
            return this.state.assignedUrl;
        }
    }, {
        key: 'handleTransitionEnd',
        value: function handleTransitionEnd() {
            if (this.state.isClosing) {
                this.setState({
                    isClosing: false,
                    isClosed: true,
                    isOpening: false,
                    isOpened: false
                });
            } else if (this.state.isOpening) {
                this.setState({
                    isClosing: false,
                    isClosed: false,
                    isOpening: false,
                    isOpened: true
                });
            } else {
                this.forceUpdate();
            }
        }
    }, {
        key: 'getAssignedUrlItem',
        value: function getAssignedUrlItem() {
            if (this.state.assignedUrl) {
                return createElement(
                    'div',
                    { className: 'hwpro-assigned-url-container' },
                    this.getUrlItem(this.state.assignedUrl, { assigned: true })
                );
            }
        }
    }, {
        key: 'hasUrls',
        value: function hasUrls() {
            return this.state.urls.length;
        }
    }]);

    return UrlPicker;
}(Component);

UrlPicker.NAVIGATION_KEYS = ['ArrowDown', 'ArrowUp'];

UrlPicker.WIDTH = 282;

/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddShortUrlButtonCentral; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UrlPicker__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var $ = jQuery;

var AddShortUrlButtonCentral = function () {
    function AddShortUrlButtonCentral() {
        _classCallCheck(this, AddShortUrlButtonCentral);
    }

    _createClass(AddShortUrlButtonCentral, null, [{
        key: 'getCurrentCoordinates',
        value: function getCurrentCoordinates() {
            var selection = window.getSelection();
            var coordinates = void 0;

            if (selection.type.toLowerCase() === 'none') {
                coordinates = {
                    top: '50%',
                    left: '50%'
                };
            } else {
                var range = selection.getRangeAt(0).getBoundingClientRect();
                var left = range.left + window.scrollX - 282 / 2 + range.width / 2;

                left = AddShortUrlButtonCentral.calculateViewableLeftCoordinates(left);

                coordinates = {
                    top: range.top + window.scrollY + (range.height + 10),
                    left: left
                };
            }

            return coordinates;
        }
    }, {
        key: 'calculateViewableLeftCoordinates',
        value: function calculateViewableLeftCoordinates(left) {
            var windowWidth = $(window).width();
            var elementGetsOutOfTheviewPortRight = function elementGetsOutOfTheviewPortRight() {
                return left + __WEBPACK_IMPORTED_MODULE_0__UrlPicker__["a" /* UrlPicker */].WIDTH > windowWidth;
            };
            var elementGetsOutOfTheviewPortLeft = function elementGetsOutOfTheviewPortLeft() {
                return left < 0;
            };

            if (elementGetsOutOfTheviewPortLeft()) {
                left = 10;
            } else if (elementGetsOutOfTheviewPortRight()) {
                while (elementGetsOutOfTheviewPortRight()) {
                    left -= 10;
                }
            }

            return left;
        }
    }]);

    return AddShortUrlButtonCentral;
}();
AddShortUrlButtonCentral.TAG_NAME = 'hwprourl';
AddShortUrlButtonCentral.TITLE = 'HighWayPro Short Url';
AddShortUrlButtonCentral.CLASSES = 'highwaypro-url';
AddShortUrlButtonCentral.ATTRIBUTES = {
    id: 'data-id'
};

/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UrlPickerReceiver; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__HighWayPro__ = __webpack_require__(0);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var UrlPickerReceiver = function () {
    function UrlPickerReceiver() {
        _classCallCheck(this, UrlPickerReceiver);
    }

    _createClass(UrlPickerReceiver, [{
        key: 'getId',
        value: function getId() {
            throw new Error('Method getId() must be extended');
        }
    }, {
        key: 'setId',
        value: function setId(id, urlPicker) {
            this.handleNewId(id);
        }
    }]);

    return UrlPickerReceiver;
}();

/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Events; });
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Events = function () {
    function Events() {
        _classCallCheck(this, Events);
    }

    _createClass(Events, null, [{
        key: "register",
        value: function register(event) {
            Events.events.push(event);
        }
    }, {
        key: "call",
        value: function call(eventName, data) {
            Events.events.filter(function (event) {
                return event.name === eventName;
            }).forEach(function (event) {
                event.handler(data, eventName);
            });
        }
    }]);

    return Events;
}();

Events.events = [];

/***/ }),
/* 5 */
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_5__;

/***/ }),
/* 6 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__domain_urlPicker_GutenbergTextBlockUrlPickerReceiver__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__HighWayPro__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__HighWayProApp__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__UrlPicker__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__images_logo_svg__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__images_logo_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__images_logo_svg__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var _window = window,
    wp = _window.wp;
var _wp$element = wp.element,
    Fragment = _wp$element.Fragment,
    Component = _wp$element.Component;
var _wp$richText = wp.richText,
    registerFormatType = _wp$richText.registerFormatType,
    unregisterFormatType = _wp$richText.unregisterFormatType;
var RichTextToolbarButton = wp.editor.RichTextToolbarButton;

var $ = jQuery;

var createElement = __WEBPACK_IMPORTED_MODULE_3__HighWayProApp__["a" /* HighWayProApp */].getCreateElement();

var AddShortUrlButton = function (_Component) {
    _inherits(AddShortUrlButton, _Component);

    function AddShortUrlButton() {
        var _ref;

        var _temp, _this, _ret;

        _classCallCheck(this, AddShortUrlButton);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = AddShortUrlButton.__proto__ || Object.getPrototypeOf(AddShortUrlButton)).call.apply(_ref, [this].concat(args))), _this), _this.state = {
            urlPickerReceiver: null,
            isOpen: false,
            addUrl: false
        }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(AddShortUrlButton, [{
        key: 'componentDidUpdate',
        value: function componentDidUpdate() {
            if (this.props.isActive && !this.state.isOpen) {
                this.open({
                    origin: 'fromExistingFormat'
                });
            } else {
                if (!this.props.isActive && this.state.openOrigin === 'fromExistingFormat') {
                    this.close();
                }
            }
        }
    }, {
        key: 'render',
        value: function render() {
            return createElement(
                Fragment,
                null,
                createElement(RichTextToolbarButton, {
                    icon: createElement(__WEBPACK_IMPORTED_MODULE_5__images_logo_svg___default.a, null),
                    title: 'HighWayPro Short Url',
                    onClick: this.open.bind(this, {
                        origin: 'fromClick'
                    })
                }),
                createElement(__WEBPACK_IMPORTED_MODULE_4__UrlPicker__["a" /* UrlPicker */], {
                    isOpen: this.state.isOpen,
                    urlPickerReceiver: new __WEBPACK_IMPORTED_MODULE_1__domain_urlPicker_GutenbergTextBlockUrlPickerReceiver__["a" /* GutenbergTextBlockUrlPickerReceiver */](this),
                    coordinates: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].getCurrentCoordinates(),
                    allowedClickableElement: '.components-button',
                    close: this.close.bind(this),
                    closeInactive: this.closeInactive.bind(this)
                })
            );
        }
    }, {
        key: 'open',
        value: function open(openOrigin) {
            this.setState({
                isOpen: true,
                openOrigin: openOrigin.origin
            });
        }
    }, {
        key: 'explicitelyOpen',
        value: function explicitelyOpen() {
            this.setState({
                isOpen: true,
                openFromClick: true
            });
        }
    }, {
        key: 'close',
        value: function close() {
            if (this.state.isOpen) {
                this.setState({
                    isOpen: false,
                    addUrl: false,
                    urlPickerReceiver: null
                });
            }
        }
    }, {
        key: 'closeInactive',
        value: function closeInactive() {
            if (!this.props.isActive) {
                this.close();
            }
        }
    }, {
        key: 'handleNewIdReceived',
        value: function handleNewIdReceived(id) {
            // converted to string which it seems breaks with any other data type
            id = id ? '' + id : '';

            var action = id ? wp.richText.applyFormat : wp.richText.toggleFormat;

            this.props.onChange(action(this.props.value, {
                type: AddShortUrlButton.NAME,
                attributes: {
                    'data-id': id
                }
            }));
        }
    }], [{
        key: 'register',
        value: function register() {
            document.createElement(AddShortUrlButton.TAG_NAME);

            registerFormatType(AddShortUrlButton.NAME, {
                title: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].TITLE,
                tagName: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].TAG_NAME,
                className: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].CLASSES,
                attributes: _defineProperty({}, __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].ATTRIBUTES.id, __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].ATTRIBUTES.id),
                edit: AddShortUrlButton
            });
        }
    }]);

    return AddShortUrlButton;
}(Component);

AddShortUrlButton.NAME = 'highwaypro/add-short-url';
/* harmony default export */ __webpack_exports__["default"] = (AddShortUrlButton);

/***/ }),
/* 7 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return GutenbergTextBlockUrlPickerReceiver; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_gutenberg_AddShortUrlButton__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UrlPickerReceiver__ = __webpack_require__(3);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var GutenbergTextBlockUrlPickerReceiver = function (_UrlPickerReceiver) {
    _inherits(GutenbergTextBlockUrlPickerReceiver, _UrlPickerReceiver);

    function GutenbergTextBlockUrlPickerReceiver(addShortUrlButton) {
        _classCallCheck(this, GutenbergTextBlockUrlPickerReceiver);

        var _this = _possibleConstructorReturn(this, (GutenbergTextBlockUrlPickerReceiver.__proto__ || Object.getPrototypeOf(GutenbergTextBlockUrlPickerReceiver)).call(this, addShortUrlButton));

        _this.addShortUrlButton = addShortUrlButton;
        return _this;
    }

    _createClass(GutenbergTextBlockUrlPickerReceiver, [{
        key: 'getId',
        value: function getId() {
            return this.addShortUrlButton.props.activeAttributes['data-id'];
        }
    }, {
        key: 'handleNewId',
        value: function handleNewId(id) {
            this.addShortUrlButton.handleNewIdReceived(id);
        }
    }]);

    return GutenbergTextBlockUrlPickerReceiver;
}(__WEBPACK_IMPORTED_MODULE_1__UrlPickerReceiver__["a" /* UrlPickerReceiver */]);

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(9);


/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__HighWayPro__ = __webpack_require__(0);


// load it once...
if (!window.HighWayPro) {
    window.HighWayPro = new __WEBPACK_IMPORTED_MODULE_0__HighWayPro__["a" /* HighWayPro */]();
}

/***/ }),
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UrlPostMetaBoxManager; });
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var $ = jQuery;

var UrlPostMetaBoxManager = function () {
    function UrlPostMetaBoxManager() {
        _classCallCheck(this, UrlPostMetaBoxManager);

        this.classes = {
            main: 'hwpro-url-meta-box',
            url: {
                pathField: 'hwpro-url-path',
                finalUrl: 'hwpro-url-path-final',
                finalUrlPath: 'hwpro-url-path-final--path'
            },
            stats: {
                number: 'hwpro-stats--number'
            }
        };
        this.elements = {};

        this.elements.main = $('.' + this.classes.main);
        this.elements.pathField = $('#' + this.classes.url.pathField);

        if (this.elements.pathField.length) {
            this.elements.finalUrl = $('.' + this.classes.url.finalUrl);

            this.elements.pathField.get(0) && this.elements.pathField.get(0).addEventListener('input', this.updatePath.bind(this));

            this.elements.statsNumber = $('.' + this.classes.stats.number);
            this.performStatsRequest();
        }
    }

    _createClass(UrlPostMetaBoxManager, [{
        key: 'updatePath',
        value: function updatePath(_ref) {
            var target = _ref.target;

            var fixedPath = target.value.replace(' ', '-').replace(/[^a-z0-9-]/gi, '');

            this.elements.pathField.val(fixedPath);
            this.updateFinalUrl(fixedPath);
        }
    }, {
        key: 'updateFinalUrl',
        value: function updateFinalUrl(path) {
            this.elements.finalUrl.children('.' + this.classes.url.finalUrlPath).text(path);
        }
    }, {
        key: 'performStatsRequest',
        value: function performStatsRequest() {
            var _this = this;

            if (this.getUrlId() < 1) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: window.HighWayProPostEditor.postUrl,
                data: {
                    action: 'highwaypro_post',
                    path: 'url/statistics',
                    data: JSON.stringify({
                        url: {
                            id: this.getUrlId()
                        }
                    })
                },
                dataType: 'json',
                beforeSend: function beforeSend() {
                    return _this.setClicksValue('Loading');
                },
                success: this.handleSuccessfulStatsResponse.bind(this),
                error: function error() {
                    return _this.setClicksValue('Failed to load');
                }
            });
        }
    }, {
        key: 'getUrlId',
        value: function getUrlId() {
            return this.elements.main.attr('data-url-id');
        }
    }, {
        key: 'handleSuccessfulStatsResponse',
        value: function handleSuccessfulStatsResponse(response) {
            this.setClicksValue(response.statistics.count.allTime);
        }
    }, {
        key: 'setClicksValue',
        value: function setClicksValue(value) {
            this.elements.statsNumber.text(value);
        }
    }]);

    return UrlPostMetaBoxManager;
}();

/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__domain_urlPicker_ClassicTextBlockUrlPickerReceiver__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__HighWayProApp__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__UrlPicker__ = __webpack_require__(1);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }






var _window = window,
    wp = _window.wp;


var Component = void 0;

if (wp && wp.element) {
    Component = wp.element.Component;
} else {
    Component = window.React.Component;
}

var createElement = __WEBPACK_IMPORTED_MODULE_2__HighWayProApp__["a" /* HighWayProApp */].getCreateElement();

var $ = jQuery;

var AddShortUrlButton = function (_Component) {
    _inherits(AddShortUrlButton, _Component);

    function AddShortUrlButton() {
        var _ref;

        var _temp, _this, _ret;

        _classCallCheck(this, AddShortUrlButton);

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = AddShortUrlButton.__proto__ || Object.getPrototypeOf(AddShortUrlButton)).call.apply(_ref, [this].concat(args))), _this), _this.state = {
            isOpen: false

        }, _temp), _possibleConstructorReturn(_this, _ret);
    }

    _createClass(AddShortUrlButton, [{
        key: 'componentDidMount',
        value: function componentDidMount() {
            AddShortUrlButton.instance = this;

            this.props.editor.on('click', this.handleEditorWasClicked.bind(this));
        }
    }, {
        key: 'render',
        value: function render() {
            return createElement(__WEBPACK_IMPORTED_MODULE_3__UrlPicker__["a" /* UrlPicker */], {
                isOpen: this.state.isOpen,
                urlPickerReceiver: new __WEBPACK_IMPORTED_MODULE_1__domain_urlPicker_ClassicTextBlockUrlPickerReceiver__["a" /* ClassicTextBlockUrlPickerReceiver */](this),
                coordinates: this.getCurrentCoordinates(),
                allowedClickableElement: '.mce-btn',
                customAllowableClicableElement: this.isCustomAllowableClicableElement.bind(this),
                close: this.close.bind(this),
                closeInactive: this.closeInactive.bind(this),
                position: 'left'
            });
        }
    }, {
        key: 'open',
        value: function open(optionalLinkElement) {
            // used by: ClassicTextBlockUrlPickerReceiver
            this.linkElement = optionalLinkElement;

            this.setState({
                isOpen: true
            });
        }
    }, {
        key: 'close',
        value: function close() {
            if (this.state.isOpen) {
                this.setState({
                    isOpen: false
                });
            }
        }
    }, {
        key: 'closeInactive',
        value: function closeInactive() {
            this.setState({
                isOpen: false
            });
        }
    }, {
        key: 'isCustomAllowableClicableElement',
        value: function isCustomAllowableClicableElement($target) {
            return $target == this.linkElement;
        }
    }, {
        key: 'handleEditorWasClicked',
        value: function handleEditorWasClicked(event) {
            var target = $(event.target);

            if (target.hasClass(__WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].CLASSES)) {

                this.open(target);
            } else if (!target.hasClass('hwpro-url-picker')) {
                this.close();
            }
        }
    }, {
        key: 'handleNewIdReceived',
        value: function handleNewIdReceived(id) {
            // we are editing an existing link
            if (this.linkElement) {

                if (id) {
                    this.linkElement.attr(__WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].ATTRIBUTES.id, id);
                } else {
                    // remove the link
                    this.linkElement.contents().unwrap();
                }
            } else {
                // we're creating a new link from scratch!
                if (id) {
                    this.props.editor.execCommand('mceReplaceContent', false, '<hwprourl class="' + __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].CLASSES + '" ' + __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].ATTRIBUTES.id + '="' + id + '">{$selection}</hwprourl>');
                }
            }
        }
    }, {
        key: 'getCurrentCoordinates',
        value: function getCurrentCoordinates() {
            if (!this.state.isOpen) {
                return {};
            }

            /**
             * Shame-lessly borrowed from: 
             * 
             * https://github.com/abrimo/TinyMCE-Autocomplete-Plugin/blob/master/src/autocomplete/editor_plugin_src.js
             *
             * Thanks a ton!
             * 
             * Talk about backwards compatibility!
             *
             */

            var editorContainer = this.props.editor.getContainer();

            if (editorContainer) {
                var editorElement = jQuery(editorContainer);
            } else {
                var editorElement = jQuery('#' + this.props.editor.id);
            }

            var tinymcePosition = editorElement.offset();
            var toolbarPosition = editorElement.find(".mce-toolbar-grp").first();
            var nodePosition = jQuery(this.props.editor.selection.getNode()).position();
            var textareaTop = 0;
            var textareaLeft = 0;
            if (this.props.editor.selection.getRng().getClientRects().length > 0) {
                textareaTop = this.props.editor.selection.getRng().getClientRects()[0].top + this.props.editor.selection.getRng().getClientRects()[0].height;
                textareaLeft = this.props.editor.selection.getRng().getClientRects()[0].left;
            } else {
                textareaTop = parseInt(jQuery(this.props.editor.selection.getNode()).css("font-size")) * 1.3 + nodePosition.top;
                textareaLeft = nodePosition.left;
            }

            var lineHeight = 5;

            if (editorContainer) {
                var top = tinymcePosition.top + toolbarPosition.innerHeight() + textareaTop + lineHeight;
                var left = tinymcePosition.left + textareaLeft;
            } else {
                var top = toolbarPosition.innerHeight() + textareaTop + lineHeight;
                var left = textareaLeft;
            }

            return {
                top: top - $(window).scrollTop(),
                left: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].calculateViewableLeftCoordinates(left)
            };
        }
    }], [{
        key: 'register',
        value: function register() {
            document.createElement(__WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].TAG_NAME);

            tinymce.PluginManager.add('myplugin', function (editor, url) {

                editor.addCommand('HighWayPro_handleAddButtonWasCliked', AddShortUrlButton.handleAddButtonWasCliked);

                editor.addButton('myplugin', {
                    title: __WEBPACK_IMPORTED_MODULE_0__AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].TITLE,
                    image: window.HighWayProPostEditor.pluginURI + 'app/scripts/postEditorGutenberg/src/images/logo.svg',
                    cmd: 'HighWayPro_handleAddButtonWasCliked',
                    onpostrender: function onpostrender() {
                        jQuery('<div id="highwaypro-classic-editor-picker"></div>').appendTo(jQuery('body'));

                        ReactDOM.render(createElement(AddShortUrlButton, { editor: editor }), document.getElementById('highwaypro-classic-editor-picker'));
                    }
                });
            });
        }
    }, {
        key: 'handleAddButtonWasCliked',
        value: function handleAddButtonWasCliked() {
            AddShortUrlButton.instance.open();
        }
    }]);

    return AddShortUrlButton;
}(Component);

/* harmony default export */ __webpack_exports__["default"] = (AddShortUrlButton);

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg) && arg.length) {
				var inner = classNames.apply(null, arg);
				if (inner) {
					classes.push(inner);
				}
			} else if (argType === 'object') {
				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if (typeof module !== 'undefined' && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {
		window.classNames = classNames;
	}
}());


/***/ }),
/* 13 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = delay;
function delay(fn, ms) {
  var timer = 0;
  return function () {
    clearTimeout(timer);

    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    timer = setTimeout(fn.bind.apply(fn, [this].concat(args)), ms || 0);
  };
}

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

var React = __webpack_require__(5);

function Delete (props) {
    return React.createElement("svg",props,[React.createElement("path",{"fill":"none","d":"M0 0h24v24H0V0z","key":0}),React.createElement("path",{"d":"M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v10zm3.17-7.83c.39-.39 1.02-.39 1.41 0L12 12.59l1.42-1.42c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41L13.41 14l1.42 1.42c.39.39.39 1.02 0 1.41-.39.39-1.02.39-1.41 0L12 15.41l-1.42 1.42c-.39.39-1.02.39-1.41 0-.39-.39-.39-1.02 0-1.41L10.59 14l-1.42-1.42c-.39-.38-.39-1.02 0-1.41zM15.5 4l-.71-.71c-.18-.18-.44-.29-.7-.29H9.91c-.26 0-.52.11-.7.29L8.5 4H6c-.55 0-1 .45-1 1s.45 1 1 1h12c.55 0 1-.45 1-1s-.45-1-1-1h-2.5z","key":1})]);
}

Delete.defaultProps = {"width":"24","height":"24","viewBox":"0 0 24 24"};

module.exports = Delete;

Delete.default = Delete;


/***/ }),
/* 15 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ClassicTextBlockUrlPickerReceiver; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_AddShortUrlButtonCentral__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__UrlPickerReceiver__ = __webpack_require__(3);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var ClassicTextBlockUrlPickerReceiver = function (_UrlPickerReceiver) {
    _inherits(ClassicTextBlockUrlPickerReceiver, _UrlPickerReceiver);

    function ClassicTextBlockUrlPickerReceiver(addShortUrlButton) {
        _classCallCheck(this, ClassicTextBlockUrlPickerReceiver);

        var _this = _possibleConstructorReturn(this, (ClassicTextBlockUrlPickerReceiver.__proto__ || Object.getPrototypeOf(ClassicTextBlockUrlPickerReceiver)).call(this, addShortUrlButton));

        _this.addShortUrlButton = addShortUrlButton;
        return _this;
    }

    _createClass(ClassicTextBlockUrlPickerReceiver, [{
        key: 'getId',
        value: function getId() {
            if (this.addShortUrlButton.linkElement) {
                return this.addShortUrlButton.linkElement.attr(__WEBPACK_IMPORTED_MODULE_0__components_AddShortUrlButtonCentral__["a" /* AddShortUrlButtonCentral */].ATTRIBUTES.id);
            }

            return null;
        }
    }, {
        key: 'handleNewId',
        value: function handleNewId(id) {
            this.addShortUrlButton.handleNewIdReceived(id);
        }
    }]);

    return ClassicTextBlockUrlPickerReceiver;
}(__WEBPACK_IMPORTED_MODULE_1__UrlPickerReceiver__["a" /* UrlPickerReceiver */]);

/***/ }),
/* 16 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return HighWayProApp; });
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HighWayProApp = function () {
    function HighWayProApp() {
        _classCallCheck(this, HighWayProApp);
    }

    _createClass(HighWayProApp, null, [{
        key: 'getComponent',
        value: function getComponent() {
            return HighWayProApp.gutenbergIsEnabled() ? window.wp.element.Component : window.React.Component;
        }
    }, {
        key: 'gutenbergIsEnabled',
        value: function gutenbergIsEnabled() {
            return window.wp && window.wp.editor && typeof window.wp.editor.BlockControls !== 'undefined';
        }
    }, {
        key: 'getCreateElement',
        value: function getCreateElement() {
            return HighWayProApp.gutenbergIsEnabled() ? window.wp.element.createElement : window.React.createElement;
        }
    }]);

    return HighWayProApp;
}();

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

var React = __webpack_require__(5);

function Logo (props) {
    return React.createElement("svg",props,[React.createElement("title",{"key":0},"Direction"),React.createElement("desc",{"key":1},"A solid styled icon from Orion Icon Library."),React.createElement("path",{"data-name":"layer1","d":"M49 30H15a8.005 8.005 0 0 1-7.976-8.059A7.906 7.906 0 0 1 15 14h38l-3.566 3.924 2.844 2.846L61 12l-8.72-9-2.846 2.843L53 10H15a12 12 0 1 0 0 24h34c4.436 0 9 3.563 9 8a7.977 7.977 0 0 1-8 8H11l4-4-2.946-2.768L3 52l1.584 1.525.02.02L12 61l3-3-4-4h39a11.964 11.964 0 0 0 12-12c0-6.656-6.344-12-13-12z","fill":"","key":2})]);
}

Logo.defaultProps = {"viewBox":"0 0 64 64","aria-labelledby":"title","aria-describedby":"desc","role":"img","width":"20","height":"20"};

module.exports = Logo;

Logo.default = Logo;


/***/ })
/******/ ]);
});
//# sourceMappingURL=postPicker.js.map