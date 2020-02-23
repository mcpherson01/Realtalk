/*
    Elfsight Youtube Gallery
    Version: 3.2.0
    Release date: Wed May 15 2019

    https://elfsight.com

    Copyright (c) 2019 Elfsight, LLC. ALL RIGHTS RESERVED
*/

!function(e,n,t){"use strict";n.add("api-key",e.noop),e(function(){const n="elfsight-admin-page-api-key-form",t=e(".elfsight-admin"),a=e("."+n),s=a.find("."+n+"-input"),i=a.find("."+n+"-button-connect");a.find("."+n+"-description-fail-message"),a.find("."+n+"-reload"),a.find("."+n+"-error-empty");let o,l=s.val();function c(a){e("."+n).removeClass([n+"-connect",n+"-success"].join(" ")).addClass(n+"-"+a),t.toggleClass("elfsight-admin-api-key-invalid","success"!==a),o=a,"success"===a?(s.attr("readonly",!0),i.text("Clear API key").addClass("elfsight-admin-button-gray").removeClass("elfsight-admin-button-green")):(s.attr("readonly",!1),i.text("Save API key").addClass("elfsight-admin-button-green").removeClass("elfsight-admin-button-gray"))}!function(e){return!!e}(l)?c("connect"):c("success"),i.click(function(){"success"===o&&s.val(""),l===s.val()&&""!==s.val()||(c(""===(l=s.val())?"connect":"success"),a.addClass(n+"-reload-active"),function(n){return e.post(ajaxurl,{action:"elfsight_youtube_gallery_update_api_key",api_key:n,nonce:s.attr("data-nonce")})}(l).then(function(){document.location.reload()}))})})}(window.jQuery,window.elfsightAdminPagesController||{},window);