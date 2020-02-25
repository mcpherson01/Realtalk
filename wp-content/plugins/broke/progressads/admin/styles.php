<?php
if ( !function_exists( 'add_action' ) ) {
    exit;
}

//function start
function DCPA_plugin_styles() {
?>
<script>jQuery(document).ready(function($){
	'use strict';
    $('.progress-Color-Picker').wpColorPicker();
});
</script>

<div class="wrap projectStyle">
	<div id="whiteboxH" class="postbox">
	
	<div class="topHead">
		<h2><?php echo esc_html__("Progress Ads Plugin - Settings", "DCPA-plugin") ?></h2>
	</div>
	
	<div class="topHead settingsPanel">  <nav id="nav" class="clearfix">
		<ul class="clearfix">
		  <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_dashboard' ) ?>"><?php echo esc_html__("Dashboard", "DCPA-plugin") ?></a></li>
		  <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_editor' ) ?>"><?php echo esc_html__("Editor", "DCPA-plugin") ?></a></li>
		  <li><a class="hover" href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_styles' ) ?>"><?php echo esc_html__("Settings", "DCPA-plugin") ?></a></li>
		</ul>
	  </nav>
	</div>
	<div class="inside"><?php if( get_option("DCPA_start") == 1) { ?>
        <form action="options.php" method="post">
        <?php settings_fields("DCPA_styles_settings");?>
            <?php if( get_option("DCPA_show") == 1) { ?>
			<table class="form-table">
				<tr valign="top"><strong><h1 class="h1TextHead"><?php echo esc_html__("Progress Bar Settings", "DCPA-plugin") ?></h1></strong><br></tr>
				
			<tr valign="top">
							<th scope="row"><label for="DCPA_progSty"><?php echo esc_html__("Progress Bar Style","DCPA-plugin") ?></label></th>
							<td>
							<label>
							<select name="DCPA_progSty">
								<option value="1" <?php selected( get_option("DCPA_progSty"), 1); ?>><?php echo esc_html__("Default","DCPA-plugin") ?></option>
								<option value="2" <?php selected( get_option("DCPA_progSty"), 2); ?>><?php echo esc_html__("Striped","DCPA-plugin") ?></option>
								<option value="3" <?php selected( get_option("DCPA_progSty"), 3); ?>><?php echo esc_html__("Flat","DCPA-plugin") ?></option>
								<option value="4" <?php selected( get_option("DCPA_progSty"), 4); ?>><?php echo esc_html__("Flat with Animation","DCPA-plugin") ?></option>
								<option value="5" <?php selected( get_option("DCPA_progSty"), 5); ?>><?php echo esc_html__("Fire and Water","DCPA-plugin") ?></option>
								<option value="6" <?php selected( get_option("DCPA_progSty"), 6); ?>><?php echo esc_html__("Cutter","DCPA-plugin") ?></option>
								<option value="7" <?php selected( get_option("DCPA_progSty"), 7); ?>><?php echo esc_html__("Space","DCPA-plugin") ?></option>
								<option value="8" <?php selected( get_option("DCPA_progSty"), 8); ?>><?php echo esc_html__("Dashed Line","DCPA-plugin") ?></option>
								<option value="9" <?php selected( get_option("DCPA_progSty"), 9); ?>><?php echo esc_html__("Sunshine","DCPA-plugin") ?></option>
								<option value="10" <?php selected( get_option("DCPA_progSty"), 10); ?>><?php echo esc_html__("Waves","DCPA-plugin") ?></option>
								<option value="11" <?php selected( get_option("DCPA_progSty"), 11); ?>><?php echo esc_html__("Soft","DCPA-plugin") ?></option>
							</select>
							</label>
								<p><?php echo esc_html__("Select the style of the Progress Bar.","DCPA-plugin") ?></p>
							</td>
				</tr>
				
				<tr valign="top">
							<th scope="row"><label for="DCPA_progType"><?php echo esc_html__("Progress Bar Position","DCPA-plugin") ?></label></th>
							<td>
							<label>
							<select name="DCPA_progType">
								<option value="1" <?php selected( get_option("DCPA_progType"), 1); ?>><?php echo esc_html__("Top","DCPA-plugin") ?></option>
								<option value="2" <?php selected( get_option("DCPA_progType"), 2); ?>><?php echo esc_html__("Bottom","DCPA-plugin") ?></option>
							</select>
							</label>
								<p><?php echo esc_html__("Select the position of the Progress Bar.","DCPA-plugin") ?></p>
							</td>
				</tr>
				
                <tr valign="top">
                    <th scope="row"><label for="DCPA_progressColor"><?php echo esc_html__("Progress Bar Color","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_progressColor" type="text" value="<?php echo esc_attr(get_option("DCPA_progressColor")) ?>" data-default-color="#dd3333" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the color of the progress bar.", "DCPA-plugin") ?></p>
                    </td>
                </tr>    

				<tr valign="top">
                    <th scope="row"><label for="DCPA_progressColorAd"><?php echo esc_html__("Progress Color with Advertisement","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_progressColorAd" type="text" value="<?php echo esc_attr(get_option("DCPA_progressColorAd")) ?>" data-default-color="#eff700" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the color of the progress during the ad.","DCPA-plugin") ?></p>
                    </td>
                </tr>				
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_pbBack"><?php echo esc_html__("Progress Bar Background Color","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_pbBack" type="text" value="<?php echo esc_attr(get_option("DCPA_pbBack")) ?>" data-default-color="#d2d2d2" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the background color of the progress bar.","DCPA-plugin") ?></p>
                    </td>
                </tr>  
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_progressHeight"><?php echo esc_html__("Progress Bar Height","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_progressHeight" type="number" value="<?php echo esc_attr(get_option("DCPA_progressHeight")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php printf( esc_html__("Select the height %s of the progress bar.", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( '(px)', 'DCPA-plugin' ) ) ); ?></p>
                    </td>
                </tr>
				</table>
				<div class="SpaceDCPA"></div>
			<?php } ?>
			<?php if(get_option("DCPA_showPop") == 1) { ?>
				<tr valign="top"><strong><h1 class="h1TextHead"><?php echo esc_html__("Modal Box (POPUP) Settings","DCPA-plugin") ?></h1></strong></tr>
				<table class="form-table">
				<tr valign="top">
                    <th scope="row"><label for="DCPA_modalPlace"><?php echo esc_html__("Modal Place","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_modalPlace" type="number" min="0" max="80" value="<?php echo esc_attr(get_option("DCPA_modalPlace")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Adjust the ad starting place. (eg.) 0 - top of page, 50 - middle of page, 80 - bottom of page","DCPA-plugin") ?></p>
                    </td>
                </tr>				
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_modalFreq"><?php echo esc_html__("Modal Impression Freq. (seconds format)","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_modalFreq" type="number" min="0" max="80" value="<?php echo esc_attr(get_option("DCPA_modalFreq")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Adjust the ad impression frequency. If you want the user to see an ad every 1 hour, type in seconds:","DCPA-plugin") ?> <strong>3600</strong></p>
						<p class="alertText" ><?php echo esc_html__("If you don't want to limit, leave blank.","DCPA-plugin") ?></p>
                    </td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_adBackground"><?php echo esc_html__("Modal (Popup) Background Color","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_adBackground" type="text" value="<?php echo esc_attr(get_option("DCPA_adBackground")) ?>" data-default-color="#fff" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the background color of the ad page.","DCPA-plugin") ?></p>
                    </td>
                </tr>				
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_closerButton"><?php echo esc_html__("Ad Skip Type","DCPA-plugin") ?></label></th>
                    <td>
							<label>
							<select name="DCPA_skipType">
								<option value="1" <?php selected( get_option("DCPA_skipType"), 1); ?>><?php echo esc_html__("Close Button","DCPA-plugin") ?></option>
								<option value="2" <?php selected( get_option("DCPA_skipType"), 2); ?>><?php echo esc_html__("Countdown Button","DCPA-plugin") ?></option>
							</select>
							</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Choose how to skip the ad.","DCPA-plugin") ?></p>
                    </td>
                </tr> 				
				<?php if(get_option("DCPA_skipType") == 2) { ?> 
				<tr valign="top">
                    <th scope="row"><label for="DCPA_cdText">- <?php echo esc_html__("Countdown Button Text","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_cdText" type="text" value="<?php echo esc_attr(get_option("DCPA_cdText")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Adjust the button text. (eg.) Skip Ad","DCPA-plugin") ?></p>
                    </td>
                </tr>					
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_standText">- <?php echo esc_html__("Countdown Standby Text","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_standText" type="text" value="<?php echo esc_attr(get_option("DCPA_standText")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Adjust the standby text. (eg.) Please wait...","DCPA-plugin") ?></p>
                    </td>
                </tr>					
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_remaininText">- <?php echo esc_html__("Countdown Remaining Text","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_remaininText" type="text" value="<?php echo esc_attr(get_option("DCPA_remaininText")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Adjust the ad remaining time text. (eg.) seconds remaining","DCPA-plugin") ?></p>
                    </td>
                </tr>				
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_cdButton">- <?php echo esc_html__("Countdown Timing","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input name="DCPA_cdButton" type="number" value="<?php echo esc_attr(get_option("DCPA_cdButton")) ?>" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Set the wait time for ads. (eg.) 5","DCPA-plugin") ?></p>
                    </td>
                </tr>				
				
				<?php } ?> 
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_closerButton"><?php echo esc_html__("Close Button Color","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_closerButton" type="text" value="<?php echo esc_attr(get_option("DCPA_closerButton")) ?>" data-default-color="#000" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the background color of the Close Button.","DCPA-plugin") ?></p>
                    </td>
                </tr> 				
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_closerTextButton"><?php echo esc_html__("Close Button Text Color","DCPA-plugin") ?></label></th>
                    <td>
					<label>
					  <input class="progress-Color-Picker" name="DCPA_closerTextButton" type="text" value="<?php echo esc_attr(get_option("DCPA_closerTextButton")) ?>" data-default-color="#fff" />
					</label>
                        <p class="tableMargin description" ><?php echo esc_html__("Select the color of the Close Buton Text.","DCPA-plugin") ?></p>
                    </td>
                </tr> 
				
				<tr valign="top">
							<th scope="row"><label for="DCPA_closerType"><?php echo esc_html__("Close Button Position","DCPA-plugin") ?></label></th>
							<td>
							<label>
							<select name="DCPA_closerType">
								<option value="1" <?php selected( get_option("DCPA_closerType"), 1); ?>><?php echo esc_html__("Top - Right","DCPA-plugin") ?></option>
								<option value="2" <?php selected( get_option("DCPA_closerType"), 2); ?>><?php echo esc_html__("Top - Left","DCPA-plugin") ?></option>
								<option value="3" <?php selected( get_option("DCPA_closerType"), 3); ?>><?php echo esc_html__("Bottom - Right","DCPA-plugin") ?></option>
								<option value="4" <?php selected( get_option("DCPA_closerType"), 4); ?>><?php echo esc_html__("Bottom - Left","DCPA-plugin") ?></option>
							</select>
							</label>
								<p><?php echo esc_html__("Select the position of the Close Button.","DCPA-plugin") ?></p>
							</td>
				</tr>
				
                <tr valign="top">
                    <th scope="row"><label for="DCPA_removProg"><?php echo esc_html__("Progress Bar after Ads","DCPA-plugin") ?></label></th>
                    <td>
					<label class="button-toggle-wrap">
					  <input <?php if( get_option("DCPA_removProg") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_removProg" class="toggler" type="checkbox" data-toggle="button-toggle"/>
					  <div class="button-toggle">
						<div class="handle">
						  <div class="bars"></div>
						</div>
					  </div>
					</label>
                        <p class="description" ><?php echo esc_html__("Remove the Progress Bar after the ads.","DCPA-plugin") ?></p>
                    </td>
                </tr> 
			</table>
			<?php } ?>
    <?php } else { ?>
	<p><?php echo esc_html__("Please enable the plugin from the Progress Ads Dashboard page.","DCPA-plugin") ?></p>
	<?php } ?></div>
	
	  
	</div>
	
</div>

	<div class="wrap projectStyle" id="whiteboxH">
	<div class="postbox">
	<div class="inside">
	<div class="inlineblockSet">
  
		<div class="contentDoYouLike">
		  <p><?php echo esc_html__("How would you rate this plugin?", "DCPA-plugin") ?></p>
		</div>

		<div class="wrapperDoYouLike">
		  <input type="checkbox" id="st1" value="1" />
		  <label for="st1"></label>
		  <input type="checkbox" id="st2" value="2" />
		  <label for="st2"></label>
		  <input type="checkbox" id="st3" value="3" />
		  <label for="st3"></label>
		  <input type="checkbox" id="st4" value="4" />
		  <label for="st4"></label>
		  <input type="checkbox" id="st5" value="5" />
		  <label for="st5"></label>
		</div>					
		
		<a target="_blank" href="https://codecanyon.net/user/divcoder/portfolio" class="sabutton button button-primary boxMarginSet"><?php echo esc_html__("Rate this plugin!", "DCPA-plugin") ?></a>
	</div>
	<?php submit_button() ?>
	</form>
	</div>
	</div>
</div>
<?php }

add_action( 'admin_enqueue_scripts', 'DCPA_progressColorPicker' );
function DCPA_progressColorPicker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
}

add_action("admin_init","DCPA_styles_register");
function DCPA_styles_register() {

	//register settings
	register_setting("DCPA_styles_settings","DCPA_progType");
	register_setting("DCPA_styles_settings","DCPA_progressHeight");
	register_setting("DCPA_styles_settings","DCPA_progressColor");
	register_setting("DCPA_styles_settings","DCPA_pbBack");
	register_setting("DCPA_styles_settings","DCPA_progressColorAd");
	register_setting("DCPA_styles_settings","DCPA_adBackground");
	register_setting("DCPA_styles_settings","DCPA_closerButton");
	register_setting("DCPA_styles_settings","DCPA_closerTextButton");
	register_setting("DCPA_styles_settings","DCPA_closerType");
	register_setting("DCPA_styles_settings","DCPA_skipType");
	register_setting("DCPA_styles_settings","DCPA_cdButton");
	register_setting("DCPA_styles_settings","DCPA_cdText");
	register_setting("DCPA_styles_settings","DCPA_modalPlace");
	register_setting("DCPA_styles_settings","DCPA_progSty");
	register_setting("DCPA_styles_settings","DCPA_remaininText");
	register_setting("DCPA_styles_settings","DCPA_standText");
	register_setting("DCPA_styles_settings","DCPA_modalFreq");
	register_setting("DCPA_styles_settings","DCPA_removProg");
	
}