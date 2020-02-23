<?php
function digitalmarketplace_login_logo_url_title() {
	return get_bloginfo( 'name' );
}

add_filter( 'login_headerurl', 'mayosis_loginlogo_url' );

function mayosis_loginlogo_url($url) {

     return  esc_url( home_url( '/' ) );

}
function digitalmarketplace_login_logo() { ?>
<?php 
$adminlogo= get_theme_mod( 'admin_logo','https://teconce.com/preview/mayosis/maindemo/wp-content/uploads/2018/04/Mayosis-Logo-Color.png');
$admingradient= get_theme_mod( 'gradient_admin', array('color1' => '#1e0046','color2' => '#1e0064',));
$loginbuttoncolor= get_theme_mod( 'login_button_admin', '#5a00f0');
?>
	<style type="text/css">
#login_error strong{
    color: #cc2944;
}
body.login h1 {
     text-align: center;
    float: left;
    width: 100%;
    background: #ffffff;
    margin-top: 20px;
    margin-left: 0;
    padding: 40px 0;
    box-sizing: border-box;
    max-height: 60px;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    font-family: Lato, Helvetica, Arial, sans-serif;
}
body.login div#login h1 a {
			background-image: url(<?php echo esc_url($adminlogo);  ?> );
			padding-bottom: 0px;
			width:130px !important;
			background-size:100%;    
			height: 90px;
			font-family: Lato, Helvetica, Arial, sans-serif;
		}
		body.login form {
    margin-top: 0;
    margin-left: 0;
    padding: 20px 44px 56px;
    background: #ffffff;
    -webkit-box-shadow:none;
    box-shadow: none;
        font-family: Lato, Helvetica, Arial, sans-serif;

}
		body.login label {
    color: #3c465a;
    font-size: 14px;
}.wp-core-ui p .button {
    vertical-align: baseline;
   background: <?php echo esc_html($loginbuttoncolor);  ?>;
    border: <?php echo esc_url($loginbuttoncolor);  ?>;
    box-shadow: none;
        font-family: Lato, Helvetica, Arial, sans-serif;
}

		body.login #login_error, body.login .message {
    border-left: 4px solid #3a9da6;
    padding: 12px;
    margin-left: 0;
    background-color: #3a9da6;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    color: #fff;
    position: absolute;
   top: 0;
    font-family: Lato, Helvetica, Arial, sans-serif;
}
		body.login-action-login.wp-core-ui,body.login-action-lostpassword {
		    background: linear-gradient(135deg, <?php echo esc_html($admingradient['color1']); ?> , <?php echo esc_html($admingradient['color2']); ?>);
		        font-family: Lato, Helvetica, Arial, sans-serif;
		}
		
	.wp-core-ui .button-group.button-large .button, .wp-core-ui .button.button-large {
    line-height: 28px;
    padding: 0 12px 2px;
    width: 100%;
    height: 50px !important;
    font-size: 16px;
    font-weight: 900;
    text-shadow: none;
    text-transform: uppercase;
    margin-top: 20px;
        font-family: Lato, Helvetica, Arial, sans-serif;
}	
.wp-core-ui p .button:hover{
    opacity:.75;
}
	@media (min-width:991px){
    #login {
    width: 520px !important;
}
body.login form {
    padding: 40px 80px 35px 80px !important;
}
body.login h1 {
    padding: 80px !important;
}
.login #nav {
    margin: 0;
    background: #fff;
    text-align: center;
   
		}
		.login #backtoblog, .login #nav {
       font-size: 14px;
    font-style: italic;
    background: #fff;
    margin: 0 !important;
    
		}
			.login #backtoblog{
			   
			    text-align: center;
			    padding-bottom:77px !important;
			    border-bottom-left-radius:3px;
			    border-bottom-right-radius:3px;
			}
			 .login #nav a{
			     margin-top:20px !important;
			 }
			 body.login #login_error{
			     border-left: none;
    padding: 12px;
    margin-left: 0;
    background-color: transparent;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: none;
    position: absolute;
    top: 240px;
    color: #000;
    padding-left: 80px;
    font-size: 15px;
    max-width: 360px;
			 }
			 body.login .message {
        border-left: none;
    padding: 12px;
    margin-left: 0;
    background-color: transparent;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: none;
    position: absolute;
    top: 260px;
    color: #000;
    padding-left: 80px;
    font-size: 15px;
    max-width: 360px;
}
.login form .input, .login input[type=text]{
    margin-top:10px;
}
}	
	@media (min-width:1400px){
	    	body.login #login_error{
	    	    border-left: none;
    padding: 12px;
    margin-left: 0;
    background-color: transparent;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: none;
    position: absolute;
    top: 280px;
    color: #000;
    padding-left: 80px;
    font-size: 15px;
    max-width: 360px;
	    	}
	     body.login .message {
        border-left: none;
    padding: 12px;
    margin-left: 0;
    background-color: transparent;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: none;
    position: absolute;
    top: 300px;
    color: #000;
    padding-left: 80px;
    font-size: 15px;
    max-width: 360px;
}
	}
	</style>
<?php }
