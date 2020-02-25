<?php
if ( !function_exists( 'add_action' ) ) {
    exit;
}

//function start
function DCPA_plugin_editor() {
?>

<div class="wrap projectStyle">
	<div id="whiteboxH" class="postbox">
	
	<div class="topHead">
		<h2><?php echo esc_html__("Progress Ads Plugin - Editor", "DCPA-plugin") ?></h2>
	</div>
	
	<div class="topHead settingsPanel">  <nav id="nav" class="clearfix">
		<ul class="clearfix">
		  <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_dashboard' ) ?>"><?php echo esc_html__("Dashboard", "DCPA-plugin") ?></a></li>
		  <li><a class="hover" href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_editor' ) ?>"><?php echo esc_html__("Editor", "DCPA-plugin") ?></a></li>
		  <li><a href="<?php echo admin_url( 'admin.php?page=DCPA_plugin_styles' ) ?>"><?php echo esc_html__("Settings", "DCPA-plugin") ?></a></li>
		</ul>
	  </nav>
	</div>
	<div class="inside"><?php if( get_option("DCPA_start") == 1) { ?>
        <form action="options.php" method="post">
		
		<p class="editorFontSet"><strong>*</strong> <?php echo esc_html__("You can edit advertisement space in this editor.", "DCPA-plugin") ?></p>
        <?php settings_fields("DCPA_editor_settings");

		$customEditorID = "DCPA_customedit";
		$editorContent = get_option('DCPA_customedit');
		
		wp_editor( $editorContent, $customEditorID );
		
		?>
         <?php } else { ?>
	<p><?php echo esc_html__("Please enable the plugin from the Progress Ads Dashboard page.", "DCPA-plugin") ?></p>
	<?php } ?>
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
	</form>
	</div>
	</div>
</div>
<?php }

add_action("admin_init","DCPA_editor_register");
function DCPA_editor_register() {

	//register settings
	register_setting("DCPA_editor_settings","DCPA_customedit");
	
}