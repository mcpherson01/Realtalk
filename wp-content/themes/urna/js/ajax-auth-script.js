'use strict';

class customLogin {
  constructor() {
    this._changeDefaultErrorMessage();

    this._initLogin();
  }

  _initLogin() {
    jQuery('form#custom-login, form#custom-register').on('submit', function (e) {
      if (!$(this).valid()) return false;
      $('p.status', this).show().text(urna_ajax_auth_object.loadingmessage);
      var action = 'ajaxlogin';
      var username = $('form#custom-login #cus-username').val();
      var password = $('form#custom-login #cus-password').val();
      var rememberme = $('#cus-rememberme').is(':checked') ? true : false;
      var email = '';
      security = $('form#custom-login #security').val();

      if ($(this).attr('id') == 'custom-register') {
        action = 'ajaxregister';
        username = $('#signonname').val();
        password = $('#signonpassword').val();
        email = $('#signonemail').val();
        var security = $('#signonsecurity').val();
      }

      var self = $(this);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: urna_ajax_auth_object.ajaxurl,
        data: {
          'action': action,
          'username': username,
          'password': password,
          'email': email,
          'rememberme': rememberme,
          'security': security
        },
        success: function (data) {
          $('p.status', self).text(data.message);

          if (data.loggedin == true) {
            $('p.status', self).addClass('successful');
            document.location.href = urna_ajax_auth_object.redirecturl;
          } else {
            $('p.status', self).addClass('wrong');
          }
        }
      });
      e.preventDefault();
    });
    if (jQuery("#custom-register").length) jQuery("#custom-register").validate({
      rules: {
        password2: {
          equalTo: '#signonpassword'
        }
      }
    });else if (jQuery("#custom-login").length) jQuery("#custom-login").validate();
  }

  _changeDefaultErrorMessage() {
    jQuery.extend(jQuery.validator.messages, {
      required: urna_settings.validate.required,
      remote: urna_settings.validate.remote,
      email: urna_settings.validate.email,
      url: urna_settings.validate.url,
      date: urna_settings.validate.date,
      dateISO: urna_settings.validate.dateISO,
      number: urna_settings.validate.number,
      digits: urna_settings.validate.digits,
      creditcard: urna_settings.validate.creditcard,
      equalTo: urna_settings.validate.equalTo,
      accept: urna_settings.validate.accept,
      maxlength: jQuery.validator.format(urna_settings.validate.maxlength),
      minlength: jQuery.validator.format(urna_settings.validate.minlength),
      rangelength: jQuery.validator.format(urna_settings.validate.rangelength),
      range: jQuery.validator.format(urna_settings.validate.range),
      max: jQuery.validator.format(urna_settings.validate.max),
      min: jQuery.validator.format(urna_settings.validate.min)
    });
  }

}

jQuery(document).ready(function ($) {
  new customLogin();
});
