/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?e(require("jquery")):e(jQuery)}(function(e){var n=/\+/g;function o(e){return r.raw?e:encodeURIComponent(e)}function i(o,i){var t=r.raw?o:function(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(n," ")),r.json?JSON.parse(e):e}catch(e){}}(o);return e.isFunction(i)?i(t):t}var r=e.cookie=function(n,t,c){if(arguments.length>1&&!e.isFunction(t)){if("number"==typeof(c=e.extend({},r.defaults,c)).expires){var u=c.expires,a=c.expires=new Date;a.setTime(+a+864e5*u)}return document.cookie=[o(n),"=",(d=t,o(r.json?JSON.stringify(d):String(d))),c.expires?"; expires="+c.expires.toUTCString():"",c.path?"; path="+c.path:"",c.domain?"; domain="+c.domain:"",c.secure?"; secure":""].join("")}for(var d,f,p=n?void 0:{},s=document.cookie?document.cookie.split("; "):[],m=0,x=s.length;m<x;m++){var l=s[m].split("="),v=(f=l.shift(),r.raw?f:decodeURIComponent(f)),k=l.join("=");if(n&&n===v){p=i(k,t);break}n||void 0===(k=i(k))||(p[v]=k)}return p};r.defaults={},e.removeCookie=function(n,o){return void 0!==e.cookie(n)&&(e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n))}});