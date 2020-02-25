jQuery(document).ready(function ($) {
    // Show account api display
    if($("#cloudflare-cache").is(":checked")){
        $("#cloudflare-cache-form").show();
    }
    if($("#keycdn-cache").is(":checked")){
        $("#keycdn-cache-form").show();
    }
    if($("#maxcdn-cache").is(":checked")){
        $("#maxcdn-cache-form").show();
    }

    if($("#varnish-cache").is(":checked")){
        $("#varnish-cache-form").show();
    }

    $(".thirds-party-select").on('change',function(){
        var selected = $(this).attr('id');
        if ($(this).is(':checked')) {
            $("#"+selected+"-form").show("blind", 500);
        }else{
            $("#"+selected+"-form").hide("blind", 500);
        }

    });

    // Save account api
    $("#maxcdn-save-settings").click(function(){
        var maxcdn_consumer_key = $("input[name=maxcdn-consumer-key]").val();
        var maxcdn_consumer_secret = $("input[name=maxcdn-consumer-secret]").val();
        var maxcdn_alias = $("input[name=maxcdn-alias]").val();
        var zone = $("input[name=maxcdn-zone-ids]").val();

        $.ajax({
            url : ajaxurl,
            dataType : 'json',
            method : 'POST',
            data : {
                action : 'wpsol_save_max_cdn_3rd_party',
                maxcdn_consumer_key : maxcdn_consumer_key,
                maxcdn_consumer_secret : maxcdn_consumer_secret,
                maxcdn_alias : maxcdn_alias,
                zone : zone,
                security : _author_third_party_token_name.check_save_authorization
            },
            success : function(res){
                if(res){
                    $(".maxcdn-display-results").show('fade');
                    setTimeout(function () {
                        $(".maxcdn-display-results").hide('fade');
                    },2000);
                }
            }
        });
    });

    $("#keycdn-save-settings").click(function(){
        var authorization = $("input[name=keycdn-authorization-key]").val();
        var zone = $("input[name=keycdn-zone-ids]").val();

        $.ajax({
            url : ajaxurl,
            dataType : 'json',
            method : 'POST',
            data : {
                action : 'wpsol_save_key_cdn_3rd_party',
                authorization : authorization,
                zone : zone,
                security : _author_third_party_token_name.check_save_authorization
            },
            success : function(res){
                if(res){
                    $(".keycdn-display-results").show('fade');
                    setTimeout(function () {
                        $(".keycdn-display-results").hide('fade');
                    },2000);
                }
            }
        });
    });

    $("#cloudflare-save-settings").click(function(){
        var username = $("input[name=cloudflare-username]").val();
        var key = $("input[name=cloudflare-key]").val();
        var domain = $("input[name=cloudflare-domain]").val();

        $.ajax({
            url : ajaxurl,
            dataType : 'json',
            method : 'POST',
            data : {
                action : 'wpsol_save_cloudflare_3rd_party',
                username : username,
                key : key,
                domain : domain,
                security : _author_third_party_token_name.check_save_authorization
            },
            success : function(res){
                if(res){
                    $(".cloudflare-display-results").show('fade');
                    setTimeout(function () {
                        $(".cloudflare-display-results").hide('fade');
                    },2000);
                }
            }
        });
    });

    $("#varnish-save-settings").click(function(){
        var ip = $("input[name=varnish-ip]").val();

        $.ajax({
            url : ajaxurl,
            dataType : 'json',
            method : 'POST',
            data : {
                action : 'wpsol_save_varnish_3rd_party',
                ip : ip,
                security : _author_third_party_token_name.check_save_authorization
            },
            success : function(res){
                if(res){
                    $(".varnish-display-results").show('fade');
                    setTimeout(function () {
                        $(".varnish-display-results").hide('fade');
                    },2000);
                }
            }
        });
    });


});

