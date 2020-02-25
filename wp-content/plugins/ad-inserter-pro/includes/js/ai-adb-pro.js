jQuery (window).on ('load', function () {

  var ai_adb_debugging = typeof ai_debugging !== 'undefined'; // 1
//  var ai_adb_debugging = false;

  if (ai_adb_debugging) console.log ("AI AD BLOCKING window load pro");

//  if (!(typeof window.CHITIKA == 'object' && JSON.stringify (window.CHITIKA).length > 70)) {
//    jQuery (document).ready (function () {if (!ai_adb_active || ai_debugging_active) ai_adb_detected (8)});
//  } else {
//      jQuery (document).ready (function () {ai_adb_undetected (8)});
//    }

  setTimeout (function() {
    var ai_debugging_active = typeof ai_adb_fe_dbg !== 'undefined';

    if (jQuery("#adb-container").length) {
      if (!jQuery('#adb-container').find ('iframe').length) {
        if (!ai_adb_active || ai_debugging_active) ai_adb_detected (7);
      } else {
          ai_adb_undetected (7);
        }
    }

    // FuckAdBlock (v3.2.1)
    if (jQuery("#ai-adb-advertising").length) {
      if (typeof funAdBlock === "undefined") {
        if (!ai_adb_active || ai_debugging_active) ai_adb_detected (9);
      } else {
          funAdBlock.onDetected (function () {if (!ai_adb_active || ai_debugging_active) ai_adb_detected (9)});
          funAdBlock.onNotDetected (function () {ai_adb_undetected (9)});
        }
    }

    // FuckAdBlock (4.0.0-beta.3)
    if (jQuery("#ai-adb-adverts").length) {
      if (typeof badBlock === "undefined") {
          if (!ai_adb_active || ai_debugging_active) ai_adb_detected (10);
      } else {
          badBlock.on (true, function () {if (!ai_adb_active || ai_debugging_active) ai_adb_detected (10)}).on (false, function () {ai_adb_undetected (10)});
      }
    }

    badBlock = undefined;
    BadBlock = undefined;

  }, 100);
});



