<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
require plugin_dir_path( __FILE__ ) .'includes/lb_helper.php';
$api = new LicenseBoxAPI();
$res = $api->verify_license();

add_action( 'admin_init', function() {
    register_setting( 'licensebox_test-settings', 'set1' );
    register_setting( 'licensebox_test-settings', 'set2' );
});
if(!empty($_POST['set1'])&&!empty($_POST['set2'])){
$api->activate_license($_POST['set2'],$_POST['set1']);
}
function mayosis_lisense_box() {
    
global $api;
global $res;
$update_data = $api->check_update();
?>
  <script>
    function updateProgress(percentage) {
      document.getElementById('progress').value = percentage;
    }
  </script>
    <div class="teconce-license-stats mayosis-system-stats">
      <h2 class="title">Enter The License Information to Activate</h2>
      <?php if ($res['status']) {
        ?> <div class="notice-green"><p>Activated! Your license is valid. Enjoy Mayosis Theme with automatic updates.</p></div> <?php }
      else{
        ?> <div class="notice-red"><p>Purchase Code or Username is Invalid. Please Enter the Correct Information!</p></div> <?php
      }?>
      <form action="options.php" method="post" class="mayosis-license">
        <?php
          settings_fields( 'licensebox_test-settings' );
          do_settings_sections( 'licensebox_test-settings' );
        ?>
        
                <p class="label">Themeforest Username</p>
                <p><input type="text" placeholder="Enter Themeforest Username" name="set1" size="50" value="<?php echo get_option("set1",null); ?>" required/></p>
            
                <p class="label">Purchase code</p>
                <p><input type="text" placeholder="Enter the purchase code" name="set2" size="50" value="<?php echo get_option("set2",null); ?>" required/></p>
            
             <?php submit_button(); ?>
          
      </form>
      <div class="teconce-box-update">
      <?php if ($res['status']) { ?>
      <h2 class="title">Updates for this theme</h2>
      <p><strong><?php echo $update_data['message']; ?></strong></p>
      <?php
        if($update_data['status']){
          ?><p>Changelog: <?php echo $update_data['changelog']; ?></p>
        <?php if(!empty($_POST['update_id'])){
          echo "<progress id=\"prog\" value=\"0\" max=\"100.0\" style=\"width: 20%;\"></progress><br>";
          $api->download_update($_POST['update_id'],$_POST['has_sql'],$_POST['version']);
          ?>
          <br><br>
        <?php }
        else {
          ?>
          <form action="" method="POST">
            <input type="hidden" value="<?php echo $update_data['update_id']; ?>" name="update_id">
            <input type="hidden" value="<?php echo $update_data['has_sql']; ?>" name="has_sql">
            <input type="hidden" value="<?php echo $update_data['version']; ?>" name="version">
            <span id="test-button">
              <input id="test-settings" type="submit" value="Download and install update" class="button">
            </span>
          </form>
        <?php }}} ?>
        </div>
    </div>
<?php
}
?>