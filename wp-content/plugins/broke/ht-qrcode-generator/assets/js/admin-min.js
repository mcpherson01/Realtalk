jQuery(document).ready(function($) {
    'use strict';
    //Initiate Color Picker
    $('.htqrcode-color-picker').wpColorPicker();


    $('.htqrcode-browse').on( 'click', function (event) {
        event.preventDefault();

        var self = $(this);

        // Create the media frame.
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: self.data('uploader_title'),
            button: {
                text: self.data('uploader_button_text'),
            },
            multiple: false
        });

        file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();
            self.prev('.htqrcode-logo-url').val(attachment.url).change();
        });

        // Finally, open the modal
        file_frame.open();
    });


});