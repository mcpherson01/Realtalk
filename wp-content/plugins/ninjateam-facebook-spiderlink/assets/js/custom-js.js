jQuery(document).ready(function($){

	$('input#title[name="post_title"]').attr("required","");
/*
	$('input#njt_like_comment_title[name="njt_like_comment_title"]').removeAttr("required");
	
	$('textarea#njt_like_comment_description[name="njt_like_comment_description"]').removeAttr("required");
*/	
	// Copy & Post
    $(document).on('click', 'a#njt_spider_copy_and_post', function (e) {
        e.preventDefault();
        $("#message_copy_post_group").fadeIn(1000).delay(5000).fadeOut(1000);
        $("#message_copy_post_group").show();
        $("textarea#njt_spider_fb_message_post_group").css('background','lemonchiffon');
        $("textarea#njt_spider_fb_message_post_group").select();
              document.execCommand('copy');
    });




});


