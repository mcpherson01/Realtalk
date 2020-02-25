var leadeo_send_ajax;

(function($) {
	leadeo_send_ajax = function(action, pdata, callback, datatype) {
		if (typeof datatype=='undefined') datatype='json';
		var sdata='action='+action;
		if (typeof pdata=='object') {
			Object.keys(pdata).forEach(function(key) {
				sdata+='&'+key+'='+encodeURIComponent(pdata[key]);
			});
		} else {
			sdata+='&'+pdata;
		}
		$.ajax({
			type: 'POST',
			dataType: datatype,
			url: ajaxurl,
			data: sdata,
			success: function(response) {
				callback(response, datatype, 1);
			},
			error: function(request, status){
				console.log('Ajax error: '+request.responseText);
				callback(request.responseText, 'text', 0);
			}
		});
	}

})(jQuery);