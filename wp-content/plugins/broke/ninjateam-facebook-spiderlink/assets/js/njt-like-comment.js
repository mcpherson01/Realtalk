jQuery(document).ready(function($){
    //$('#njt-like_comment-setup-fb').parent().css({"width":"48%","float":"left"});
    //$('#njt-like_comment-set-permission-access').parent().css({"width":"48%","float":"left"});
    $("#njt_like_comment_number_comment").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
        }
    });
    $('.njt_like_comment_usercomment').change(function() {
        if(this.checked) {
            $('.njt_like_comment_number_comment_container').show();
            //$('#njt_fb_number_comment').val(1);
        }
        else{
            $('.njt_like_comment_number_comment_container').hide();
            $('#njt_like_comment_number_comment').val(0);
        }       
    });
    $('.njt_like_comment_usercomment').trigger('change');
    // custom url
    $('.njt_like_comment_custom_url_option').change(function() {
        if(this.checked) {
            $('.njt_input_url_post_fb').show();
            $('#njt-like_comment-page-manager').hide();
        }
        else{
            $('.njt_input_url_post_fb').hide();
            $('#njt-like_comment-page-manager').show();
        }       
    });
    $('.njt_like_comment_custom_url_option').trigger('change');
    $('.njt_like_comment_another_url_post_fb').change(function() {
        if(this.checked) {
            $('.njt_enter_post_url_content').show();
        }
        else{
            $('.njt_enter_post_url_content').hide();
        }  
    });
    $('.njt_like_comment_another_url_post_fb').trigger('change');
/* tab */
    $('.njt_like_comment_t-toggle-button__option').click(function() {
        $(this).addClass('js-checked').siblings().removeClass('js-checked');
    });
    $('input[name="njt_like_comment_publish_to"]').change(function(){
        if($(this).val()=="timeline"){
            $('#span_njt_like_comment_page_manager').hide();
            $('#span_njt_like_comment_timeline_select').show();
            $("#span_njt_like_comment_group_manager").hide();

            /******/
            $('input#njt_like_comment_title[name="njt_like_comment_title"]').attr("required","");
            $('input#njt_like_comment_description[name="njt_like_comment_description"]').attr("required","");
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').attr("required","");
            

            $('input#njt_like_comment_title[name="njt_like_comment_title"]').removeAttr('disabled');
            $('textarea#njt_like_comment_description[name="njt_like_comment_description"]').removeAttr('disabled');
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').removeAttr('disabled');
            $('input#njt_like_comment_title,textarea#njt_like_comment_description,textarea#njt_like_comment_message').css('opacity','1');
            $('.use_facebook_post').show();
            $('#add_height_fb_t_g').css('height','0px');
            /******/
            $("#njt_fb_title,#njt_fb_description,#njt_fb_post_content").show();
        }
        else if($(this).val()=="fanpage"){
            $('#span_njt_like_comment_page_manager').show();
            $('#span_njt_like_comment_timeline_select').hide();
            $("#span_njt_like_comment_group_manager").hide();
            /******/
            $('input#njt_like_comment_title[name="njt_like_comment_title"]').attr("required","");
            $('input#njt_like_comment_description[name="njt_like_comment_description"]').attr("required","");
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').attr("required","");

            $('input#njt_like_comment_title[name="njt_like_comment_title"]').removeAttr('disabled');
            $('textarea#njt_like_comment_description[name="njt_like_comment_description"]').removeAttr('disabled');
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').removeAttr('disabled');
            $('input#njt_like_comment_title,textarea#njt_like_comment_description,textarea#njt_like_comment_message').css('opacity','1');
            $('.use_facebook_post').show();
            $('#add_height_fb_t_g').css('height','150px');
            /******/
            $("#njt_fb_title,#njt_fb_description,#njt_fb_post_content").show();
        }else{
            $('#span_njt_like_comment_page_manager').hide();
            $('#span_njt_like_comment_timeline_select').hide();
            $("#span_njt_like_comment_group_manager").show();
            /******/
            $('input#njt_like_comment_title[name="njt_like_comment_title"]').removeAttr("required");
            $('textarea#njt_like_comment_description[name="njt_like_comment_description"]').removeAttr("required");
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').removeAttr("required");

            $('input#njt_like_comment_title[name="njt_like_comment_title"]').attr('disabled','disabled');
            $('textarea#njt_like_comment_description[name="njt_like_comment_description"]').attr('disabled','disabled');
            $('textarea#njt_like_comment_message[name="njt_like_comment_message"]').attr('disabled','disabled');
        
            $('input#njt_like_comment_title,textarea#njt_like_comment_description,textarea#njt_like_comment_message').css('opacity','0.4'); 
            $('.use_facebook_post').hide();
            var check_group_show_height = $("#check_group_show_height").val();
            
            if(check_group_show_height=="no"){
                $('#add_height_fb_t_g').css('height','150px');
            }else{
                $('#add_height_fb_t_g').css('height','320px');
            }
            
            /******/
            $("#njt_fb_title,#njt_fb_description,#njt_fb_post_content").hide();
        }
    });
    // Media button
    $('#njt-l-c-insert-my-media').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function(e){
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    $('#njt_like_comment_image_url').val(image_url);
                    $('#njt_like_comment_src').attr('src',image_url);
                    $('#njt-l-c-insert-my-media').hide();
                    $('p#njt-l-c-delete-my-media').show();
                    $('.njt_like_comment_image_container').css({'height':'auto','border':'none'});
                    $('.njt_like_comment_image_container img').css('width','100%');
                });
    });
    $('p#njt-l-c-delete-my-media').click(function(e){
        e.preventDefault();
        $('#njt_like_comment_image_url').val("");
        $('#njt_like_comment_src').attr('src',"");
        $('.njt_like_comment_image_container').css({'height':'150px','border':'2px dashed #cccccc'});
        $('.njt_like_comment_image_container img').css('width','');
        $('#njt-l-c-insert-my-media').show();
        $('p#njt-l-c-delete-my-media').hide();
    });
    // insert img
    $('#njt-l-c-insert-img').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function(e){
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    $('#njt_like_comment_image_icon_url').val(image_url);
                    $('#njt_like_comment_icon_src').attr('src',image_url);
                    $('#njt-l-c-insert-img').hide();
                    $('p#njt-l-c-delete-img').show();
                    $('.njt_like_comment_image_container').css({'height':'auto','border':'none'});
                    $('.njt_like_comment_image_container_icon img').css({'width':'150px','height':'150px'});
                });
    });
    $('p#njt-l-c-delete-img').click(function(e){
        e.preventDefault();
        $('#njt_like_comment_image_icon_url').val("");
        $('#njt_like_comment_icon_src').attr('src',"");
        $('.njt_like_comment_image_container_icon').css({'height':'150px','border':'2px dashed #cccccc'});
        $('.njt_like_comment_image_container_icon img').css('width','');
        $('#njt-l-c-insert-img').show();
        $('p#njt-l-c-delete-img').hide();
    });
    // =======================JS MORE PLUGIN , SUPPORT 
    var count=$('#toplevel_page_njt-fb-api-settings .wp-submenu li a').length;
    $('#toplevel_page_njt-fb-api-settings .wp-submenu li a').each(function(index){
                if(index==(count-1))  // MORE PLUGIN
                {
                    $(this).attr('target','_blank');
                    $(this).attr('href','https://ninjateam.org/?utm_source=fb-secrect-link');
                    $(this).css('color','#ff9800');
                }
                /*
                if(index==(count-2))  // Documment
                {
                    $(this).attr('target','_blank');
                    $(this).attr('href','https://www.google.com/');
                }
                */
                if(index==(count-2))  // MORE PLUGIN
                {
                    $(this).attr('target','_blank');
                    $(this).attr('href','https://ninjateam.org/support/');
                }

                if(index==(count-5))  // Documment
                {
                    //alert("OK");
                    $(this).parent().hide();
                    
                }
                
    });

    // export csv
    $('.njt_spiderlinkcsv').click(function(){
        var action_data = {
            action:'njt_like_comment_export_csv',
            export: true
        };
        $('#njt_img_export_csv').show();
        $(this).css('margin-left','0px');
        var njt_home_url=$('#njt_home_url').val();
        $.post(ajaxurl,action_data,function(result){

                if(result){


                        $('#njt_img_export_csv').hide();
                        $('.njt_spiderlinkcsv').css('margin-left','15px');
                        window.location = njt_home_url;
                        console.log(result);
                            

                }
        });
    });


    // Group
    //==================ADD NEW GROUP============//
   
    $(document).on('click', 'a.spider_close_popup,.njt_close_popup_gr', function (e) {
        e.preventDefault();
        $('.spider_create_group_popup').removeClass('spider-open');
    });
    $(document).on('click', 'a.njt_spider_add_new_group,.button.njt_add_new_group_popup', function (e) {
        e.preventDefault();

        $('.spider_create_group_popup').addClass('spider-open');
    });

    
    // SEARCH ID & NAME GROUP
    $('#njt_spider_fb_group_url').on("input",function (){ 
        var value_group_url=$(this).val();
        $("#njt-loader").show();
        var action_data = {
            action:'njt_like_comment_find_group_id_name',
            group_url:value_group_url,          
        };
        $.post(ajaxurl,action_data,function(result){
            $("#njt-loader").hide();
            console.log(result);
            //return false;
            if(result){
                
                $("#njt_spider_fb_group_name").val("");
                $("#njt_spider_fb_group_id").val("");
                $("#njt_spider_parse_group_name").text("");
                $("#spider_add_group_error").show();
                if(result=="No result"){
                    $("#spider_add_group_error").html("Invalid URL group format"); 
                }else if(result.search("Unsupported get request. Object with ID") != -1 || result.search("Some of the aliases you requested do not exist") != -1 || result.search("An access token is required to request this resource") != -1 || result.search("Invalid OAuth access token") != -1 || result.search("Tried accessing nonexisting field") != -1 || result.search("singular published story API is deprecated for versions v2.4 and higher") != -1 || result.search("The parameter q is required") != -1 ){
                    if(result.search("An access token is required to request this resource.") != -1 || result.search("Invalid OAuth access token.") != -1){                            
                         $("#spider_add_group_error").html(result+" <a href='#'>Link Here</a>");
                    }else{
                        $("#spider_add_group_error").html(result);
                    }  
                }else{
                   var array_data_group=JSON.parse(result);
                  
                   $("#njt_spider_fb_group_name").val(array_data_group["name"]);
                   $("#njt_spider_fb_group_id").val(array_data_group["id"]);
                   $("#spider_add_group_error").html("");
                   $("#njt_spider_parse_group_name").text(array_data_group["name"]);
                }
                
            }
            else
            {
                $("#njt_spider_fb_group_name").val("");
                $("#njt_spider_fb_group_id").val("");
                $("#njt_spider_parse_group_name").text("");
            }
        
        });
    
    });
    // click add new group
    //
    $("#njt_spider_add_group,#njt-btn-add-gr").click(function(e){
        e.preventDefault();
       
        var name=$("#njt_spider_fb_group_name").val();
        var id=$("#njt_spider_fb_group_id").val();
        var group_url=$("#njt_spider_fb_group_url").val();
        var action_data = {
            action:'njt_like_comment_add_new_group',
            id:id,
            name:name,
            group_url:group_url          
        };

        $.post(ajaxurl,action_data,function(result){
            if(result){
                    //console.log(result);
                    $("#njt_spider_fb_group_name").val("");
                    $("#njt_spider_fb_group_id").val("");
                    $("#njt_spider_parse_group_name").text("");
                    $("#spider_add_group_error").show();
                    if(result=="error1"){
                        $("#spider_add_group_error").html("Please enter group URL.");
                    }else if(result == "No result"){
                        $("#spider_add_group_error").html("Data is not valid, cannot be added.");
                    }else if(result=="exits"){
                        $("#spider_add_group_error").html("Group already exists");
                    }else if(result.search("Unsupported get request. Object with ID") != -1 || result.search("Some of the aliases you requested do not exist") != -1 || result.search("An access token is required to request this resource") != -1 || result.search("Invalid OAuth access token") != -1 || result.search("Tried accessing nonexisting field") != -1 || result.search("singular published story API is deprecated for versions v2.4 and higher") != -1 || result.search("The parameter q is required") != -1 ){
                        if(result.search("An access token is required to request this resource.") != -1 || result.search("Invalid OAuth access token.") != -1){                            
                             $("#spider_add_group_error").html(result+" <a href='#'>Link Here</a>");
                        }else{
                            $("#spider_add_group_error").html(result);
                        }

                    }else{
                        $("#spider_add_group_error").html("");  
                        $("select.njt_like_comment_group_manager").append(result);
                        $('.spider_create_group_popup').removeClass('spider-open');
                        $('#njt_spider_fb_group_url').val("");

                    }
                
            }
            else
            {
                return false;
            }
        });
    });

    $("#njt_spider_add_group_tab_menu,#njt-btn-add-gr-menu").click(function(e){
        e.preventDefault();
       
        var name=$("#njt_spider_fb_group_name").val();
        var id=$("#njt_spider_fb_group_id").val();
        var group_url=$("#njt_spider_fb_group_url").val();
        var action_data = {
            action:'njt_like_comment_add_new_group_menu',
            id:id,
            name:name,
            group_url:group_url          
        };

        $.post(ajaxurl,action_data,function(result){
            if(result){
                    //console.log(result);
                    $("#njt_spider_fb_group_name").val("");
                    $("#njt_spider_fb_group_id").val("");
                    $("#njt_spider_parse_group_name").text("");
                    $("#spider_add_group_error").show();
                    if(result=="error1"){
                        $("#spider_add_group_error").html("Please enter group URL.");
                    }else if(result == "No result"){
                        $("#spider_add_group_error").html("Data is not valid, cannot be added.");
                    }else if(result=="exits"){
                        $("#spider_add_group_error").html("Group already exists");
                    }else if(result.search("Unsupported get request. Object with ID") != -1 || result.search("Some of the aliases you requested do not exist") != -1 || result.search("An access token is required to request this resource") != -1 || result.search("Invalid OAuth access token") != -1 || result.search("Tried accessing nonexisting field") != -1 || result.search("singular published story API is deprecated for versions v2.4 and higher") != -1 || result.search("The parameter q is required") != -1 ){
                        if(result.search("An access token is required to request this resource.") != -1 || result.search("Invalid OAuth access token.") != -1){                            
                             $("#spider_add_group_error").html(result+" <a href='#'>Link Here</a>");
                        }else{
                            $("#spider_add_group_error").html(result);
                        }

                    }else{
                        $("#spider_add_group_error").html("");  
                        $("#the-list").prepend(result);
                        $('.spider_create_group_popup').removeClass('spider-open');
                        $('#njt_spider_fb_group_url').val("");

                    }
                
            }
            else
            {
                return false;
            }
        });
    });
    
    //
    jQuery('.njt-spiderlink_renew_mail_chimp').on('click',function(){

      jQuery.ajax({

           url:ajaxurl,
           dataType:'json',
            method:'GET',
            data:'action=njt_renew_mailchimp',
            success:function(json){

              var class_e = jQuery.now(); 
              var html = "<p class="+class_e+">success</p>";
                jQuery('.njt-spiderlink-mailchimp-renew-result').append(html);
                console.log(class_e);
                jQuery('.'+class_e).delay(1500).fadeOut(400,function(){


                 location.reload();

                });


            }

      });
    
    });

    jQuery('.njt-spiderlink-mailchimp-sync-now').on('click',function(){

            jQuery('.njt-spiderlink-mailchimp-sync-now .njt-spiderlink-loading').show();
            var class_e = jQuery.now();  
            spiderlink_mailchimpsyc(1,0);

    });

    
    function spiderlink_mailchimpsyc(i,j){


              jQuery.ajax({

                  url:ajaxurl,
                  dataType:'json',
                  method:'GET',
                  data:{
                    
                    'i':i,
                    'j':j,
                    'action':'njt_spiderlink_mailChimpSyc',
                  },
                  success:function(data){
                      if(j<data.data.total){

                       spiderlink_mailchimpsyc(i+1,data.data.count_send);
                       jQuery('.njt-spiderlink-mailchimp-sync-now .njt-loading').show();
                      }else{

                        var class_e = jQuery.now();
                            var html = "<p class="+class_e+">"+data.data.msg+"</p>";
                            jQuery('.njt-spiderlink-mail-chimp-sync-result').append(html);
                            jQuery('.'+class_e).delay(1500).fadeOut(700);


                        
                        jQuery('.njt-spiderlink-mailchimp-sync-now .njt-spiderlink-loading').hide();

                      }
                  }

              });

        }


});