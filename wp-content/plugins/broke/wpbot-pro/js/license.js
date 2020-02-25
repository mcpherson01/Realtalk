jQuery(document).ready(function(){
    var val = jQuery('input[name="qcld_wpbotpro_buy_from_where"]:checked').val();
    show_hide_license_box(val);
    jQuery('input[name="qcld_wpbotpro_buy_from_where"]').on('change',function(e){
        var val = jQuery(this).val();
        show_hide_license_box(val);
    });
    function show_hide_license_box(value){
        if(value == 'quantumcloud'){
            jQuery('#quantumcloud_portfolio_license_row').show();
            jQuery('#show_envato_plugin_downloader').hide();
        }else if(value == 'codecanyon'){
            jQuery('#show_envato_plugin_downloader').show();
            jQuery('#quantumcloud_portfolio_license_row').hide();
        }
    }
});