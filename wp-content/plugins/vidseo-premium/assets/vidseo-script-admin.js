jQuery(document).ready(function () {
    jQuery('.vidseo-alert').on('click', '.closebtn', function () {
        jQuery(this).closest('.vidseo-alert').fadeOut(); //.css('display', 'none');
    });

    jQuery('.vidseo-boost-label input').on('click', function() { 
        jQuery('.vidseo-boost').slideToggle();
    });

    jQuery('.vidseo-bialty-label input').on('click', function() { 
        jQuery('.vidseo-bialty').slideToggle();
    });

    jQuery('.vidseo-mobi-label input').on('click', function() { 
        jQuery('.vidseo-mobi').slideToggle();
    });

    jQuery(function() {
        jQuery(".vidseo-meter > span").each(function() {
            jQuery(this)
                .data("origWidth", jQuery(this).width())
                .width(0)
                .animate({
                    width: jQuery(this).data("origWidth")
                }, 2500);
        });
    });

});