<?php
$page = isset($_GET["page"]) ? '?page=' . $_GET["page"] : '';
$location = network_admin_url('admin.php' . $page);
$admin_nonce = wp_create_nonce("useyourdrive-admin-action");
$network_wide_authorization = $this->get_processor()->is_network_authorized();
?>

<div class="useyourdrive admin-settings">
  <form id="useyourdrive-options" method="post" action="<?php echo network_admin_url('edit.php?action=' . $this->plugin_network_options_key); ?>">
    <?php wp_nonce_field('update-options'); ?>
    <?php settings_fields('use_your_drive_settings'); ?>
    <input type="hidden" name="action" value="update">

    <div class="wrap">
      <div class="useyourdrive-header">
        <div class="useyourdrive-logo"><img src="<?php echo USEYOURDRIVE_ROOTPATH; ?>/css/images/logo64x64.png" height="64" width="64"/></div>
        <div class="useyourdrive-form-buttons" style="<?php echo (is_plugin_active_for_network(USEYOURDRIVE_SLUG) === false) ? 'display:none;' : ''; ?>"> <div id="save_settings" class="simple-button default save_settings" name="save_settings"><?php _e("Save Settings", 'useyourdrive'); ?>&nbsp;<div class='uyd-spinner'></div></div></div>
        <div class="useyourdrive-title">Use-your-Drive <?php _e('Settings', 'useyourdrive'); ?></div>
      </div>


      <div id="" class="useyourdrive-panel useyourdrive-panel-left">      
        <div class="useyourdrive-nav-header"><?php _e('Settings', 'useyourdrive'); ?></div>

        <ul class="useyourdrive-nav-tabs">
          <li id="settings_general_tab" data-tab="settings_general" class="current"><a ><?php _e('General', 'useyourdrive'); ?></a></li>
          <?php if ($network_wide_authorization) { ?>
              <li id="settings_advanced_tab" data-tab="settings_advanced" ><a ><?php _e('Advanced', 'useyourdrive'); ?></a></li>
          <?php } ?>
          <li id="settings_system_tab" data-tab="settings_system" ><a><?php _e('System information', 'useyourdrive'); ?></a></li>
          <li id="settings_help_tab" data-tab="settings_help" ><a><?php _e('Support', 'useyourdrive'); ?></a></li>
        </ul>

        <div class="useyourdrive-nav-header" style="margin-top: 50px;"><?php _e('Other Cloud Plugins', 'useyourdrive'); ?></div>
        <ul class="useyourdrive-nav-tabs">
          <li id="settings_help_tab" data-tab="settings_help"><a href="https://1.envato.market/c/1260925/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Foutofthebox-dropbox-plugin-for-wordpress-%2F5529125" target="_blank" style="color:#0078d7;">Dropbox <i class="fas fa-external-link-square-alt" aria-hidden="true"></i></a></li>
          <li id="settings_help_tab" data-tab="settings_help"><a href="https://1.envato.market/c/1260925/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Fshareonedrive-onedrive-plugin-for-wordpress%2F11453104" target="_blank" style="color:#0078d7;">OneDrive <i class="fas fa-external-link-square-alt" aria-hidden="true"></i></a></li>
          <li id="settings_help_tab" data-tab="settings_help"><a href="https://1.envato.market/c/1260925/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Fletsbox-box-plugin-for-wordpress%2F8204640" target="_blank" style="color:#0078d7;">Box <i class="fas fa-external-link-square-alt" aria-hidden="true"></i></a></li>
        </ul> 

        <div class="useyourdrive-nav-footer"><a href="<?php echo admin_url('update-core.php'); ?>"><?php _e('Version', 'useyourdrive'); ?>: <?php echo USEYOURDRIVE_VERSION; ?></a></div>
      </div>

      <div class="useyourdrive-panel useyourdrive-panel-right">

        <!-- General Tab -->
        <div id="settings_general" class="useyourdrive-tab-panel current">

          <div class="useyourdrive-tab-panel-header"><?php _e('General', 'useyourdrive'); ?></div>

          <div class="useyourdrive-option-title"><?php _e('Plugin License', 'useyourdrive'); ?></div>
          <?php
          echo $this->get_plugin_activated_box();
          ?>

          <?php if (is_plugin_active_for_network(USEYOURDRIVE_SLUG)) { ?>
              <div class="useyourdrive-option-title"><?php _e('Network Wide Authorization', 'useyourdrive'); ?>
                <div class="useyourdrive-onoffswitch">
                  <input type='hidden' value='No' name='use_your_drive_settings[network_wide]'/>
                  <input type="checkbox" name="use_your_drive_settings[network_wide]" id="network_wide" class="useyourdrive-onoffswitch-checkbox" <?php echo (empty($network_wide_authorization)) ? '' : 'checked="checked"'; ?> data-div-toggle="network_wide"/>
                  <label class="useyourdrive-onoffswitch-label" for="network_wide"></label>
                </div>
              </div>


              <?php
              if ($network_wide_authorization) {
                  ?>
                  <div class="useyourdrive-option-title"><?php _e('Accounts', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-accounts-list">
                    <?php
                    $app = $this->get_app();
                    $app->get_client()->setPrompt('select_account');
                    $app->get_client()->setAccessType('offline');
                    $app->get_client()->setApprovalPrompt("force");
                    ?>
                    <div class='account account-new'>
                      <img class='account-image' src='<?php echo USEYOURDRIVE_ROOTPATH; ?>/css/images/google_drive_logo.png'/>
                      <div class='account-info-container'>
                        <div class='account-info'>
                          <div class='account-actions'>
                            <div id='add_drive_button' type='button' class='simple-button blue' data-url="<?php echo $app->get_auth_url(); ?>" title="<?php _e('Add account', 'useyourdrive'); ?>"><i class='fas fa-plus-circle' aria-hidden='true'></i>&nbsp;<?php _e('Add account', 'useyourdrive'); ?></div>
                          </div>
                          <div class="account-info-name">
                            <?php _e('Add account', 'useyourdrive'); ?>
                          </div>
                          <span class="account-info-space"><?php _e('Link a new account to the plugin', 'useyourdrive'); ?></span>
                        </div>
                      </div>
                    </div>
                    <?php
                    foreach ($this->get_main()->get_accounts()->list_accounts() as $account_id => $account) {
                        echo $this->get_plugin_authorization_box($account);
                    }
                    ?>
                  </div>
                  <?php
              }
              ?>

              <?php
          }
          ?>

        </div>
        <!-- End General Tab -->


        <!--  Advanced Tab -->
        <?php if ($network_wide_authorization) { ?>
            <div id="settings_advanced"  class="useyourdrive-tab-panel">
              <div class="useyourdrive-tab-panel-header"><?php _e('Advanced', 'useyourdrive'); ?></div>

              <div class="useyourdrive-option-title"><?php _e('"Lost Authorization" notification', 'useyourdrive'); ?></div>
              <div class="useyourdrive-option-description"><?php _e('If the plugin somehow loses its authorization, a notification email will be send to the following email address', 'useyourdrive'); ?>:</div>
              <input class="useyourdrive-option-input-large" type="text" name="use_your_drive_settings[lostauthorization_notification]" id="lostauthorization_notification" value="<?php echo esc_attr($this->settings['lostauthorization_notification']); ?>">  

              <div class="useyourdrive-option-title"><?php _e('Own Google App', 'useyourdrive'); ?>
                <div class="useyourdrive-onoffswitch">
                  <input type='hidden' value='No' name='use_your_drive_settings[googledrive_app_own]'/>
                  <input type="checkbox" name="use_your_drive_settings[googledrive_app_own]" id="googledrive_app_own" class="useyourdrive-onoffswitch-checkbox" <?php echo (empty($this->settings['googledrive_app_client_id']) || empty($this->settings['googledrive_app_client_secret'])) ? '' : 'checked="checked"'; ?> data-div-toggle="own-app"/>
                  <label class="useyourdrive-onoffswitch-label" for="googledrive_app_own"></label>
                </div>
              </div>

              <div class="useyourdrive-suboptions own-app <?php echo (empty($this->settings['googledrive_app_client_id']) || empty($this->settings['googledrive_app_client_secret'])) ? 'hidden' : '' ?> ">
                <div class="useyourdrive-option-description">
                  <strong>Using your own Google App is <u>optional</u></strong>. For an easy setup you can just use the default App of the plugin itself by leaving the ID and Secret empty. The advantage of using your own app is limited. If you decided to create your own Google App anyway, please enter your settings. In the <a href="https://florisdeleeuwnl.zendesk.com/hc/en-us/articles/201804806--How-do-I-create-my-own-Google-Drive-App-" target="_blank">documentation</a> you can find how you can create a Google App.
                  <br/><br/>
                  <div class="uyd-warning">
                    <i><strong><?php _e('NOTICE', 'useyourdrive'); ?></strong>: <?php _e('If you encounter any issues when trying to use your own App with Use-your-Drive, please fall back on the default App by disabling this setting', 'useyourdrive'); ?>.</i>
                  </div>
                </div>

                <div class="useyourdrive-option-title"><?php _e('Google Client ID', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('<strong>Only</strong> if you want to use your own App, insert your Google App  Client ID here', 'useyourdrive'); ?>.</div>
                <input class="useyourdrive-option-input-large" type="text" name="use_your_drive_settings[googledrive_app_client_id]" id="googledrive_app_client_id" value="<?php echo esc_attr($this->settings['googledrive_app_client_id']); ?>" placeholder="<--- <?php _e('Leave empty for easy setup', 'useyourdrive') ?> --->" >

                <div class="useyourdrive-option-title"><?php _e('Google Client Secret', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('If you want to use your own App, insert your Google App Client secret here', 'useyourdrive'); ?>.</div>
                <input class="useyourdrive-option-input-large" type="text" name="use_your_drive_settings[googledrive_app_client_secret]" id="googledrive_app_client_secret" value="<?php echo esc_attr($this->settings['googledrive_app_client_secret']); ?>" placeholder="<--- <?php _e('Leave empty for easy setup', 'useyourdrive') ?> --->" >   

                <div>
                  <div class="useyourdrive-option-title"><?php _e('OAuth 2.0 Redirect URI', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e('Set the redirect URI in your application to the following', 'useyourdrive'); ?>:</div>
                  <code style="user-select:initial">
                    <?php
                    if ($this->get_app()->has_plugin_own_app()) {
                        echo $this->get_app()->get_redirect_uri();
                    } else {
                        _e('Enter Client ID and Secret, save settings and reload the page to see the Redirect URI you will need', 'useyourdrive');
                    }
                    ?>
                  </code>
                </div>

              </div>

              <?php
              $using_gsuite = (!empty($this->settings['permission_domain']) || $this->settings['teamdrives'] === "Yes");
              ?>

              <div class="useyourdrive-option-title"><?php _e('Using Google G Suite?', 'useyourdrive'); ?>
                <div class="useyourdrive-onoffswitch">
                  <input type='hidden' value='No' name='use_your_drive_settings[gsuite]'/>
                  <input type="checkbox" name="use_your_drive_settings[gsuite]" id="gsuite" class="useyourdrive-onoffswitch-checkbox" <?php echo ($using_gsuite) ? 'checked="checked"' : ''; ?> data-div-toggle="gsuite"/>
                  <label class="useyourdrive-onoffswitch-label" for="gsuite"></label>
                </div>
              </div>

              <div class="useyourdrive-suboptions gsuite <?php echo ($using_gsuite) ? '' : 'hidden' ?> ">
                <div class="useyourdrive-option-title"><?php _e('Your Google G Suite Domain', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('If you have a Google G Suite Domain and you want to share your documents ONLY with users having an account in your G Suite Domain, please insert your domain. If you want your documents to be accessible to the public, leave this setting empty.', 'useyourdrive'); ?>.</div>
                <input class="useyourdrive-option-input-large" type="text" name="use_your_drive_settings[permission_domain]" id="permission_domain" value="<?php echo esc_attr($this->settings['permission_domain']); ?>">   

                <div class="useyourdrive-option-title"><?php _e('Enable Team Drives', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type='hidden' value='No' name='use_your_drive_settings[teamdrives]'/>
                    <input type="checkbox" name="use_your_drive_settings[teamdrives]" id="teamdrives" class="useyourdrive-onoffswitch-checkbox" <?php echo ($this->settings['teamdrives'] === "Yes") ? 'checked="checked"' : ''; ?> />
                    <label class="useyourdrive-onoffswitch-label" for="teamdrives"></label>
                  </div>
                </div>
              </div>

            </div>
        <?php } ?>
        <!-- End Advanced Tab -->

        <!-- System info Tab -->
        <div id="settings_system"  class="useyourdrive-tab-panel">
          <div class="useyourdrive-tab-panel-header"><?php _e('System information', 'useyourdrive'); ?></div>
          <?php echo $this->get_system_information(); ?>
        </div>
        <!-- End System info -->

        <!-- Help Tab -->
        <div id="settings_help"  class="useyourdrive-tab-panel">
          <div class="useyourdrive-tab-panel-header"><?php _e('Support', 'useyourdrive'); ?></div>

          <div class="useyourdrive-option-title"><?php _e('Support & Documentation', 'useyourdrive'); ?></div>
          <div id="message">
            <p><?php _e('Check the documentation of the plugin in case you encounter any problems or are looking for support.', 'useyourdrive'); ?></p>
            <div id='documentation_button' type='button' class='simple-button blue'><?php _e('Open Documentation', 'useyourdrive'); ?></div>
          </div>
          <br/>
          <div class="useyourdrive-option-title"><?php _e('Reset Cache', 'useyourdrive'); ?></div>
          <?php echo $this->get_plugin_reset_box(); ?>

        </div>  
      </div>
      <!-- End Help info -->
    </div>
  </form>
  <script type="text/javascript" >
      jQuery(document).ready(function ($) {

        $('#add_drive_button, .refresh_drive_button').click(function () {
          var $button = $(this);
          $button.addClass('disabled');
          $button.find('.uyd-spinner').fadeIn();
          $('#authorize_drive_options').fadeIn();
          popup = window.open($(this).attr('data-url'), "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=900,height=900");

          var i = sessionStorage.length;
          while (i--) {
            var key = sessionStorage.key(i);
            if (/CloudPlugin/.test(key)) {
              sessionStorage.removeItem(key);
            }
          }
        });

        $('.revoke_drive_button, .delete_drive_button').click(function () {
          $(this).addClass('disabled');
          $(this).find('.uyd-spinner').show();
          $.ajax({type: "POST",
            url: '<?php echo USEYOURDRIVE_ADMIN_URL; ?>',
            data: {
              action: 'useyourdrive-revoke',
              account_id: $(this).attr('data-account-id'),
              force: $(this).attr('data-force'),
              _ajax_nonce: '<?php echo $admin_nonce; ?>'
            },
            complete: function (response) {
              location.reload(true)
            },
            dataType: 'json'
          });
        });


        $('#resetDrive_button').click(function () {
          var $button = $(this);
          $button.addClass('disabled');
          $button.find('.uyd-spinner').show();
          $.ajax({type: "POST",
            url: '<?php echo USEYOURDRIVE_ADMIN_URL; ?>',
            data: {
              action: 'useyourdrive-reset-cache',
              _ajax_nonce: '<?php echo $admin_nonce; ?>'
            },
            complete: function (response) {
              $button.removeClass('disabled');
              $button.find('.uyd-spinner').hide();
            },
            dataType: 'json'
          });

          var i = sessionStorage.length;
          while (i--) {
            var key = sessionStorage.key(i);
            if (/CloudPlugin/.test(key)) {
              sessionStorage.removeItem(key);
            }
          }
        });

        $('#updater_button').click(function () {

          if ($('#purcase_code.useyourdrive-option-input-large').val()) {
            $('#useyourdrive-options').submit();
            return;
          }

          popup = window.open('https://www.wpcloudplugins.com/updates/activate.php?init=1&client_url=<?php echo strtr(base64_encode($location), '+/=', '-_~'); ?>&plugin_id=<?php
          echo $this->plugin_id;
          ?>', "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=900,height=700");
        });

        $('#check_updates_button').click(function () {
          window.location = '<?php echo admin_url('update-core.php'); ?>';
        });

        $('#purcase_code.useyourdrive-option-input-large').focusout(function () {
          var purchase_code_regex = '^([a-z0-9]{8})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{4})-?([a-z0-9]{12})$';
          if ($(this).val().match(purchase_code_regex)) {
            $(this).css('color', 'initial');
          } else {
            $(this).css('color', '#dc3232');
          }
        });

        $('#deactivate_license_button').click(function () {
          $('#purcase_code').val('');
          $('#useyourdrive-options').submit();
        });


        $('#documentation_button').click(function () {
          popup = window.open('<?php echo plugins_url('_documentation/index.html', dirname(__FILE__)); ?>', "_blank");
        });

        $('#network_wide').click(function () {
          $('#save_settings').trigger('click');
        });

        $('#save_settings').click(function () {
          var $button = $(this);
          $button.addClass('disabled');
          $button.find('.uyd-spinner').fadeIn();
          $('#useyourdrive-options').ajaxSubmit({
            success: function () {
              $button.removeClass('disabled');
              $button.find('.uyd-spinner').fadeOut();
              location.reload(true);
            },
            error: function () {
              $button.removeClass('disabled');
              $button.find('.uyd-spinner').fadeOut();
              location.reload(true);
            },
          });
          //setTimeout("$('#saveMessage').hide('slow');", 5000);
          return false;
        });
      }
      );


  </script>
</div>