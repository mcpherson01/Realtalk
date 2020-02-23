jQuery(document).ready(function() {
	var $elist_category_image = jQuery( 'input#et_elist_category_image' );

	if ( $elist_category_image.length ){
		var et_fileInput = '';

		jQuery('a.elist_upload_image_button').click(function() {
			console.log('clicked');
			et_fileInput = jQuery(this).siblings('#et_elist_category_image');
			formfield = et_fileInput.attr('name');
			post_id = 0;
			tb_show('', 'media-upload.php?post_id='+post_id+'&amp;type=image&amp;TB_iframe=true');
			return false;
		});

		// user inserts file into post. only run custom if user started process using the above process
		// window.send_to_editor(html) is how wp would normally handle the received data

		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html){
			if (et_fileInput) {
				et_fileurl = jQuery('img',html).attr('src');

				et_fileInput.val(et_fileurl);

				$et_category_image_uploader = jQuery('.et_category_image_uploader');
				$et_category_image_uploader.find('img').remove();
				$et_category_image_uploader.find('p.description').before( '<img src="' + et_fileurl + '" width="200px" height="200px" style="border: 4px solid #eee; margin-top: 8px;" />' );

				tb_remove();

			} else {
				window.original_send_to_editor(html);
			}
		}
	}

});