$('.input_field').focus(function(){
	$(this).addClass("transform_input");
	$(this).parent().parent().find(".input_label").addClass("transform_label");
});

$('.input_field').blur(function(){
	if( $(this).val().length === 0 ) {
		$(this).removeClass("transform_input");
		$(this).parent().parent().find(".input_label").removeClass("transform_label");
	}
});

/* NOT VALID E-MAIL */
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


$(document).ready(function() {
	custom_bind_submit();
});

function custom_bind_submit() {
	$( '.data_form_id' ).submit(function( event ) {
		event.preventDefault();
		var r=validate();
		if (r) leadeo_send_data();
	});
}

function validate(){
	var email = $(".email-b", '#base_'+active_form).val();
	if (validateEmail(email))
	{
		$(".error", '#base_'+active_form).removeClass("not-valid");
		$(".email-b", '#base_'+active_form).css("background", "rgba(255,255,255,0.1)");
		$(".error-text", '#base_'+active_form).fadeOut(200);
		return true;
	}
	else
	{
		$(".error", '#base_'+active_form).addClass("not-valid");
		$(".email-b", '#base_'+active_form).css("background", "rgba(255,0,0,0.45)");
		$(".error-text", '#base_'+active_form).fadeIn(200);
		$(".send", '#base_'+active_form).css({"transform": "scaleX(0.99)", "margin-top": "2px", "border": "rgba(255,255,255,0)", "background-color": "rgba(255,255,255,0.1)"});
		//$('<style>.wrong-email::after{border-bottom: 4px solid #E54C3C !important; transform: translate3d(0, 0, 0);}</style>').appendTo('head');
		return false;
	}
}


$(".email-b").on("click", function(){
	$(".error", '#base_'+active_form).removeClass("not-valid");
	$(".error-text", '#base_'+active_form).fadeOut(200);
	$(".email-b", '#base_'+active_form).css("background", "rgba(255,255,255,0.1)");
});

$(".email-b").blur(function(){
	if($(".email-b", '#base_'+active_form).hasClass("transform_input"))
	{
		
	}
	else
	{
		$(".email-b", '#base_'+active_form).css("background", "rgba(255,255,255,0)");
	}
});

var count = $(".dropdown dd ul li").length;
for (i = 0; i < count; i++) {
	if(i%2 == 0)
	{
		$(".dropdown dd ul li").eq(i).css("background-color", "rgba(255,255,255,0.2)");
	}
	else{
		$(".dropdown dd ul li").eq(i).css("background-color", "rgba(255,255,255,0.1)");
	}
}

$(".dropdown dt a").click(function(e) {
  $(".dropdown dt a span i").show();
  $(".dropdown dd ul").toggle();
  e.preventDefault();
});

$(".dropdown dd ul li a").click(function() {
  var text = $(this).html();
  $(".dropdown dt a span").html(text);
  $(".dropdown dd ul").hide();
  
}); 

$(document).bind('click', function(e) {
    var $clicked = $(e.target);
    if (! $clicked.parents().hasClass("dropdown"))
        $(".dropdown dd ul").hide();
});

$(".radio-btn").on("click", function(){
	$(".radio-btn .dot").toggleClass("radioON");
});

$(".remember-reset .fa-square-o").on("click", function(){
	//$(this).toggleClass("fa-square-o");
	//$(this).toggleClass("fa-check-square-o");
	$(this).parent().find(".checked").toggleClass("yes");
});

$(".pass-remember").on("click", function(){
	$(this).parent().find(".checked").toggleClass("yes");
});

/*
$(window).load(function(){
	$(".overlay").height($(".bg-img").height());
});
*/