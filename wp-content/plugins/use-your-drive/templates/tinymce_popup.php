<?php
$settings = (array) get_option('use_your_drive_settings');

if (
        !(\TheLion\UseyourDrive\Helpers::check_user_role($this->settings['permissions_add_shortcodes'])) &&
        !(\TheLion\UseyourDrive\Helpers::check_user_role($this->settings['permissions_add_links'])) &&
        !(\TheLion\UseyourDrive\Helpers::check_user_role($this->settings['permissions_add_embedded']))
) {
    die();
}

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'default';
$standalone = isset($_REQUEST['standaloneshortcodebuilder']);

function wp_roles_and_users_input($name, $selected = array()) {

    if (!is_array($selected)) {
        $selected = array('administrator');
    }

    /* Workaround: Add temporarily selected value to prevent an empty selection in Tagify when only user ID 0 is selected */
    $selected[] = '_______PREVENT_EMPTY_______';

    /* Create value for imput field */
    $value = implode(', ', $selected);

    /* Input Field */
    echo "<input class='useyourdrive-option-input-large useyourdrive-tagify useyourdrive-permissions-placeholders' type='text' name='$name' value='$value' placeholder='' />";
}

$this->load_scripts();
$this->load_styles();
$this->load_custom_css();

function UseyourDrive_remove_all_scripts() {
    global $wp_scripts;
    $wp_scripts->queue = array();

    wp_enqueue_script('jquery-effects-fade');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('jquery');
    wp_enqueue_script('UseyourDrive');
    wp_enqueue_script('UseyourDrive.tinymce');
}

function UseyourDrive_remove_all_styles() {
    global $wp_styles;
    $wp_styles->queue = array();
    wp_enqueue_style('qtip');
    wp_enqueue_style('UseyourDrive.tinymce');
    wp_enqueue_style('UseyourDrive');
    wp_enqueue_style('Awesome-Font-5-css');
}

add_action('wp_print_scripts', 'UseyourDrive_remove_all_scripts', 1000);
add_action('wp_print_styles', 'UseyourDrive_remove_all_styles', 1000);

/* Count number of openings for rating dialog */
$counter = get_option('use_your_drive_shortcode_opened', 0) + 1;
update_option('use_your_drive_shortcode_opened', $counter);

/* Initialize shortcode vars */
$mode = (isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : 'files';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      <?php
      if ($type === 'default') {
          $title = __('Shortcode Builder', 'useyourdrive');
          $mcepopup = 'shortcode';
      } else if ($type === 'links') {
          $title = __('Insert direct Links', 'useyourdrive');
          $mcepopup = 'links';
      } else if ($type === 'embedded') {
          $title = __('Embed files', 'useyourdrive');
          $mcepopup = 'embedded';
      } else if ($type === 'gravityforms') {
          $title = __('Shortcode Builder', 'useyourdrive');
          $mcepopup = 'shortcode';
      } else if ($type === 'woocommerce') {
          $title = __('Shortcode Builder', 'useyourdrive');
          $mcepopup = 'shortcode';
      } else if ($type === 'contactforms7') {
          $title = __('Shortcode Builder', 'useyourdrive');
          $mcepopup = 'shortcode';
      }
      ?></title>
    <?php if ($type !== 'gravityforms' && $type !== 'contactforms7' && $standalone === false) { ?>
        <script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <?php } ?>

    <?php wp_print_scripts(); ?>
    <?php wp_print_styles(); ?>
  </head>

  <body class="useyourdrive" data-mode="<?php echo $mode; ?>">
    <?php $this->ask_for_review(); ?>

    <form action="#">

      <div class="wrap">
        <div class="useyourdrive-header">
          <div class="useyourdrive-logo"><img src="<?php echo USEYOURDRIVE_ROOTPATH; ?>/css/images/logo64x64.png" height="64" width="64"/></div>
          <div class="useyourdrive-form-buttons">
            <?php if ($type === 'default') { ?>
                <?php if ($standalone) { ?>
                    <div id="get_shortcode" class="simple-button default get_shortcode" name="get_shortcode" title="<?php _e("Get raw Shortcode", 'useyourdrive'); ?>"><?php _e("Create Shortcode", 'useyourdrive'); ?><i class="fas fa-code" aria-hidden="true"></i></div>
                <?php } else { ?>
                    <div id="get_shortcode" class="simple-button default get_shortcode" name="get_shortcode" title="<?php _e("Get raw Shortcode", 'useyourdrive'); ?>"><?php _e("Raw", 'useyourdrive'); ?><i class="fas fa-code" aria-hidden="true"></i></div>
                    <div id="doinsert"  class="simple-button default insert_shortcode" name="insert"><?php _e("Insert Shortcode", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>                    
                <?php } ?>
            <?php } elseif ($type === 'links') { ?>
                <div id="doinsert" class="simple-button default insert_links" name="insert"  ><?php _e("Insert Links", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>
            <?php } elseif ($type === 'embedded') { ?>
                <div id="doinsert" class="simple-button default insert_embedded" name="insert" ><?php _e("Embed Files", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>
            <?php } elseif ($type === 'gravityforms') { ?>
                <div id="doinsert" class="simple-button default insert_shortcode_gf" name="insert"><?php _e("Insert Shortcode", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>
            <?php } elseif ($type === 'woocommerce') { ?>
                <div id="doinsert" class="simple-button default insert_shortcode_woocommerce" name="insert"><?php _e("Insert Shortcode", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>
            <?php } elseif ($type === 'contactforms7') { ?>
                <div id="doinsert" class="simple-button default insert_shortcode_cf" name="insert"><?php _e("Insert Shortcode", 'useyourdrive'); ?>&nbsp;<i class="fas fa-chevron-circle-right" aria-hidden="true"></i></div>
            <?php } ?>
          </div>

          <div class="useyourdrive-title"><?php echo $title; ?></div>

        </div>
        <?php
        if ($type === 'links' || $type === 'embedded') {
            echo '<div class="useyourdrive-panel useyourdrive-panel-full">';
            if ($type === 'embedded') {
                echo "<p>" . __('Please note that the embedded files need to be public (with link)', 'useyourdrive') . "</p>";
            }

            $atts = array(
                'singleaccount' => '0',
                'dir' => 'drive',
                'mode' => 'files',
                'showfiles' => '1',
                'upload' => '0',
                'delete' => '0',
                'rename' => '0',
                'addfolder' => '0',
                'showcolumnnames' => '0',
                'viewrole' => 'all',
                'candownloadzip' => '0',
                'showsharelink' => '0',
                'previewinline' => '0',
                'mcepopup' => $mcepopup,
                'includeext' => '*',
                '_random' => 'embed'
            );

            $user_folder_backend = apply_filters('useyourdrive_use_user_folder_backend', $this->settings['userfolder_backend']);

            if ($user_folder_backend !== 'No') {
                $atts['userfolders'] = $user_folder_backend;

                $private_root_folder = $this->settings['userfolder_backend_auto_root'];
                if ($user_folder_backend === 'auto' && !empty($private_root_folder) && isset($private_root_folder['id'])) {

                    if (!isset($private_root_folder['account']) || empty($private_root_folder['account'])) {
                        $main_account = $this->get_processor()->get_accounts()->get_primary_account();
                        $params['account'] = $main_account->get_id();
                    } else {
                        $params['account'] = $private_root_folder['account'];
                    }

                    $atts['dir'] = $private_root_folder['id'];

                    if (!isset($private_root_folder['view_roles']) || empty($private_root_folder['view_roles'])) {
                        $private_root_folder['view_roles'] = array('none');
                    }
                    $atts['viewuserfoldersrole'] = implode('|', $private_root_folder['view_roles']);
                }
            }

            echo $this->create_template($atts);
            echo '</div>';
            ?>
            <?php
        } else {
            ?>

            <div id="" class="useyourdrive-panel useyourdrive-panel-left">
              <div class="useyourdrive-nav-header"><?php _e('Shortcode Options', 'useyourdrive'); ?></div>
              <ul class="useyourdrive-nav-tabs">
                <li id="settings_general_tab" data-tab="settings_general" class="current"><a><span><?php _e('General', 'useyourdrive'); ?></span></a></li>
                <li id="settings_folder_tab" data-tab="settings_folders"><a><span><?php _e('Folders', 'useyourdrive'); ?></span></a></li>
                <li id="settings_layout_tab" data-tab="settings_layout"><a><span><?php _e('Layout', 'useyourdrive'); ?></span></a></li>
                <li id="settings_sorting_tab" data-tab="settings_sorting"><a><span><?php _e('Sorting', 'useyourdrive'); ?></span></a></li>
                <li id="settings_advanced_tab" data-tab="settings_advanced"><a><span><?php _e('Advanced', 'useyourdrive'); ?></span></a></li>
                <li id="settings_exclusions_tab" data-tab="settings_exclusions"><a><span><?php _e('Exclusions', 'useyourdrive'); ?></span></a></li>
                <li id="settings_upload_tab" data-tab="settings_upload"><a><span><?php _e('Upload Box', 'useyourdrive'); ?></span></a></li>
                <li id="settings_notifications_tab" data-tab="settings_notifications"><a><span><?php _e('Notifications', 'useyourdrive'); ?></span></a></li>
                <li id="settings_manipulation_tab" data-tab="settings_manipulation"><a><span><?php _e('File Manipulation', 'useyourdrive'); ?></span></a></li>
                <li id="settings_permissions_tab" data-tab="settings_permissions" class=""><a><span><?php _e('User Permissions', 'useyourdrive'); ?></span></a></li>
              </ul>
            </div>

            <div class="useyourdrive-panel useyourdrive-panel-right">

              <!-- General Tab -->
              <div id="settings_general" class="useyourdrive-tab-panel current">

                <div class="useyourdrive-tab-panel-header"><?php _e('General', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Plugin Mode', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('Select how you want to use Use-your-Drive in your post or page', 'useyourdrive'); ?>:</div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="files" name="mode" <?php echo (($mode === 'files') ? 'checked="checked"' : ''); ?> value="files" class="mode"/>
                  <label for="files" class="useyourdrive-option-radio-label"><?php _e('File browser', 'useyourdrive'); ?></label>
                </div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="upload" name="mode" <?php echo (($mode === 'upload') ? 'checked="checked"' : ''); ?> value="upload" class="mode"/>
                  <label for="upload" class="useyourdrive-option-radio-label"><?php _e('Upload Box', 'useyourdrive'); ?></label>
                </div>
                <?php if ($type !== 'gravityforms' && $type !== 'contactforms7') { ?>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="gallery" name="mode" <?php echo (($mode === 'gallery') ? 'checked="checked"' : ''); ?> value="gallery" class="mode"/>
                      <label for="gallery" class="useyourdrive-option-radio-label"><?php _e('Photo gallery', 'useyourdrive'); ?> <small>(Images only)</small></label>
                    </div>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="audio" name="mode" <?php echo (($mode === 'audio') ? 'checked="checked"' : ''); ?> value="audio" class="mode"/>
                      <label for="audio" class="useyourdrive-option-radio-label"><?php _e('Audio player', 'useyourdrive'); ?> <small>(MP3, M4A, OGG, OGA, WAV)</small></label>
                    </div>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="video" name="mode" <?php echo (($mode === 'video') ? 'checked="checked"' : ''); ?> value="video" class="mode"/>
                      <label for="video" class="useyourdrive-option-radio-label"><?php _e('Video player', 'useyourdrive'); ?> <small>(MP4, M4V, OGG, OGV, WEBM, WEBMV)</small></label>
                    </div>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="search" name="mode" <?php echo (($mode === 'search') ? 'checked="checked"' : ''); ?> value="search" class="mode"/>
                      <label for="search" class="useyourdrive-option-radio-label"><?php _e('Search Box', 'useyourdrive'); ?></label>
                    </div>
                    <?php
                } else {
                    ?>
                    <br/>
                    <div class="uyd-updated">
                      <i><strong>TIP</strong>: <?php _e("Don't forget to check the Upload Permissions on the User Permissions tab", 'useyourdrive'); ?>. <?php _e("By default, only logged-in users can upload files", 'useyourdrive'); ?>.</i>
                    </div>
                    <?php
                }
                ?>

              </div>
              <!-- End General Tab -->
              <!-- User Folders Tab -->
              <div id="settings_folders" class="useyourdrive-tab-panel">

                <div class="useyourdrive-tab-panel-header"><?php _e('Folders', 'useyourdrive'); ?></div>

                <div class="forfilebrowser forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Use single cloud account', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_singleaccount" id="UseyourDrive_singleaccount" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['singleaccount']) && $_REQUEST['singleaccount'] === '0') ? '' : 'checked="checked"'; ?> data-div-toggle='option-singleaccount'/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_singleaccount"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Use a folder from one of the linked account. Disabling this option allows your users to navigate through the folders of all your linked accounts', 'useyourdrive'); ?>
                  </div>
                </div>

                <div class="option-singleaccount <?php echo (isset($_REQUEST['singleaccount']) && $_REQUEST['singleaccount'] === '0') ? 'hidden' : ''; ?>">
                  <div class="useyourdrive-option-title"><?php _e('Select start Folder', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e('Select which folder should be used as starting point, or in case the Smart Client Area is enabled should be used for the Private Folders', 'useyourdrive'); ?>. <?php _e('Users will not be able to navigate outside this folder', 'useyourdrive'); ?>.</div>
                  <div class="root-folder">
                    <?php
                    $atts = array(
                        'singleaccount' => '0',
                        'dir' => 'drive',
                        'mode' => 'files',
                        'maxheight' => '300px',
                        'filelayout' => 'list',
                        'showfiles' => '1',
                        'filesize' => '0',
                        'filedate' => '0',
                        'upload' => '0',
                        'delete' => '0',
                        'rename' => '0',
                        'addfolder' => '0',
                        'showbreadcrumb' => '1',
                        'showcolumnnames' => '0',
                        'search' => '0',
                        'roottext' => '',
                        'viewrole' => 'all',
                        'downloadrole' => 'none',
                        'candownloadzip' => '0',
                        'showsharelink' => '0',
                        'previewinline' => '0',
                        'mcepopup' => $mcepopup
                    );

                    if (isset($_REQUEST['account'])) {
                        $atts['startaccount'] = $_REQUEST['account'];
                    }

                    if (isset($_REQUEST['dir'])) {
                        $atts['startid'] = $_REQUEST['dir'];
                    }

                    $user_folder_backend = apply_filters('useyourdrive_use_user_folder_backend', $this->settings['userfolder_backend']);

                    if ($user_folder_backend !== 'No') {
                        $atts['userfolders'] = $user_folder_backend;

                        $private_root_folder = $this->settings['userfolder_backend_auto_root'];
                        if ($user_folder_backend === 'auto' && !empty($private_root_folder) && isset($private_root_folder['id'])) {

                            if (!isset($private_root_folder['account']) || empty($private_root_folder['account'])) {
                                $main_account = $this->get_processor()->get_accounts()->get_primary_account();
                                $params['account'] = $main_account->get_id();
                            } else {
                                $params['account'] = $private_root_folder['account'];
                            }

                            $atts['dir'] = $private_root_folder['id'];

                            if (!isset($private_root_folder['view_roles']) || empty($private_root_folder['view_roles'])) {
                                $private_root_folder['view_roles'] = array('none');
                            }
                            $atts['viewuserfoldersrole'] = implode('|', $private_root_folder['view_roles']);
                        }
                    }

                    echo $this->create_template($atts);
                    ?>
                  </div>

                  <br/>
                  <div class="useyourdrive-tab-panel-header"><?php _e('Smart Client Area', 'useyourdrive'); ?></div>

                  <div class="useyourdrive-option-title"><?php _e('Use Private Folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_linkedfolders" id="UseyourDrive_linkedfolders" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['userfolders'])) ? 'checked="checked"' : ''; ?> data-div-toggle='option-userfolders'/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_linkedfolders"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-option-description">
                    <?php echo sprintf(__('The plugin can easily and securily share documents on your %s with your users/clients', 'useyourdrive'), 'Google Drive'); ?>. 
                    <?php _e('This allows your clients to preview, download and manage their documents in their own private folder', 'useyourdrive'); ?>.
                    <?php echo sprintf(__('Specific permissions can always be set via %s', 'useyourdrive'), '<a href="#" onclick="jQuery(\'li[data-tab=settings_permissions]\').trigger(\'click\')">' . __('User Permissions', 'useyourdrive') . '</a>'); ?>. 

                    <?php _e('The Smart Client Area can be useful in some situations, for example', 'useyourdrive'); ?>:
                    <ul>
                      <li><?php _e('You want to share documents with your clients privately', 'useyourdrive'); ?></li>
                      <li><?php _e('You want your clients, users or guests upload files to their own folder', 'useyourdrive'); ?></li>
                      <li><?php _e('You want to give your customers a private folder already filled with some files directly after they register', 'useyourdrive'); ?></li>
                    </ul>
                  </div>

                  <div class="useyourdrive-suboptions option-userfolders forfilebrowser foruploadbox forgallery <?php echo (isset($_REQUEST['userfolders'])) ? '' : 'hidden'; ?>">

                    <div class="useyourdrive-option-title"><?php _e('Mode', 'useyourdrive'); ?></div>
                    <div class="useyourdrive-option-description"><?php _e('Do you want to link your users manually to their Private Folder or should the plugin handle this automatically for you', 'useyourdrive'); ?>.</div>

                    <?php
                    $userfolders = 'auto';
                    if (isset($_REQUEST['userfolders'])) {
                        $userfolders = $_REQUEST['userfolders'];
                    }
                    ?>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="userfolders_method_manual" name="UseyourDrive_userfolders_method"<?php echo ($userfolders === 'manual') ? 'checked="checked"' : ''; ?> value="manual"/>
                      <label for="userfolders_method_manual" class="useyourdrive-option-radio-label"><?php echo sprintf(__('I will link the users manually via %sthis page%s', 'useyourdrive'), '<a href="' . admin_url('admin.php?page=UseyourDrive_settings_linkusers') . '" target="_blank">', '</a>'); ?></label>
                    </div>
                    <div class="useyourdrive-option-radio">
                      <input type="radio" id="userfolders_method_auto" name="UseyourDrive_userfolders_method" <?php echo ($userfolders === 'auto') ? 'checked="checked"' : ''; ?> value="auto"/>
                      <label for="userfolders_method_auto" class="useyourdrive-option-radio-label"><?php _e('Let the plugin automatically manage the Private Folders for me in the folder I have selected above', 'useyourdrive'); ?></label>
                    </div>

                    <div class="option-userfolders_auto">
                      <div class="useyourdrive-option-title"><?php _e('Template Folder', 'useyourdrive'); ?>
                        <div class="useyourdrive-onoffswitch">
                          <input type="checkbox" name="UseyourDrive_userfolders_template" id="UseyourDrive_userfolders_template" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['usertemplatedir'])) ? 'checked="checked"' : ''; ?> data-div-toggle='userfolders-template-option'/>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_userfolders_template"></label>
                        </div>
                      </div>
                      <div class="useyourdrive-option-description">
                        <?php _e('Newly created Private Folders can be prefilled with files from a template', 'useyourdrive'); ?>. <?php _e('The content of the template folder selected will be copied to the user folder', 'useyourdrive'); ?>.
                      </div>

                      <div class="useyourdrive-suboptions userfolders-template-option <?php echo (isset($_REQUEST['usertemplatedir'])) ? '' : 'hidden'; ?>">
                        <div class="template-folder">
                          <?php
                          $user_folders = (($user_folder_backend === 'No') ? '0' : $this->settings['userfolder_backend']);

                          $atts = array(
                              'singleaccount' => '0',
                              'dir' => 'drive',
                              'mode' => 'files',
                              'filelayout' => 'list',
                              'maxheight' => '300px',
                              'showfiles' => '1',
                              'filesize' => '0',
                              'filedate' => '0',
                              'upload' => '0',
                              'delete' => '0',
                              'rename' => '0',
                              'addfolder' => '0',
                              'showbreadcrumb' => '1',
                              'showcolumnnames' => '0',
                              'viewrole' => 'all',
                              'downloadrole' => 'none',
                              'candownloadzip' => '0',
                              'showsharelink' => '0',
                              'userfolders' => $user_folders,
                              'mcepopup' => $mcepopup
                          );

                          if (isset($_REQUEST['usertemplatedir'])) {
                              $atts['startid'] = $_REQUEST['usertemplatedir'];
                          }

                          echo $this->create_template($atts);
                          ?>
                        </div>
                      </div>

                      <div class="useyourdrive-option-title"><?php _e('Full Access', 'useyourdrive'); ?></div>
                      <div class="useyourdrive-option-description"><?php _e('By default only Administrator users will be able to navigate through all Private Folders', 'useyourdrive'); ?>. <?php _e('When you want other User Roles to be able do browse to the Private Folders as well, please check them below', 'useyourdrive'); ?>.</div>

                      <?php
                      $selected = (isset($_REQUEST['viewuserfoldersrole'])) ? explode('|', $_REQUEST['viewuserfoldersrole']) : array('administrator');
                      wp_roles_and_users_input('UseyourDrive_view_user_folders_role', $selected);
                      ?>
                    </div>
                  </div>
                </div>

              </div>
              <!-- End User Folders Tab -->

              <!-- Layout Tab -->
              <div id="settings_layout"  class="useyourdrive-tab-panel">

                <div class="useyourdrive-tab-panel-header"><?php _e('Layout', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Plugin container width', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e("Set max width for the Use-your-Drive container", "useyourdrive"); ?>. <?php _e("You can use pixels or percentages, eg '360px', '480px', '70%'", "useyourdrive"); ?>. <?php _e('Leave empty for default value', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_max_width" id="UseyourDrive_max_width" placeholder="100%" value="<?php echo (isset($_REQUEST['maxwidth'])) ? $_REQUEST['maxwidth'] : ''; ?>"/>


                <div class="forfilebrowser forgallery forsearch">
                  <div class="useyourdrive-option-title"><?php _e('Plugin container height', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e("Set max height for the Use-your-Drive container", "useyourdrive"); ?>. <?php _e("You can use pixels or percentages, eg '360px', '480px', '70%'", "useyourdrive"); ?>. <?php _e('Leave empty for default value', 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_max_height" id="UseyourDrive_max_height" placeholder="auto" value="<?php echo (isset($_REQUEST['maxheight'])) ? $_REQUEST['maxheight'] : ''; ?>"/>
                </div>

                <div class="useyourdrive-option-title"><?php _e('Custom CSS Class', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('Add your own custom classes to the plugin container. Multiple classes can be added seperated by a whitespace', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_class" id="UseyourDrive_class" value="<?php echo (isset($_REQUEST['class'])) ? $_REQUEST['class'] : '' ?>" autocomplete="off"/>

                <div class="foraudio forvideo">

                  <div class="useyourdrive-option-title"><?php _e('Media Player', 'useyourdrive'); ?></div>
                  <div>
                    <div class="useyourdrive-option-description"><?php _e("Select which Media Player you want to use", 'useyourdrive'); ?>.</div>
                    <select name="UseyourDrive_mediaplayer_skin_selectionbox" id="UseyourDrive_mediaplayer_skin_selectionbox" class="ddslickbox">
                      <?php
                      $default_player = $this->settings['mediaplayer_skin'];
                      $selected = (isset($_REQUEST['mediaplayerskin'])) ? $_REQUEST['mediaplayerskin'] : $default_player;

                      foreach (new DirectoryIterator(USEYOURDRIVE_ROOTDIR . '/skins/') as $fileInfo) {
                          if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                              if (file_exists(USEYOURDRIVE_ROOTDIR . '/skins/' . $fileInfo->getFilename() . '/js/Player.js')) {
                                  $selected = ($fileInfo->getFilename() === $selected) ? 'selected="selected"' : '';
                                  $icon = file_exists(USEYOURDRIVE_ROOTDIR . '/skins/' . $fileInfo->getFilename() . '/Thumb.jpg') ? USEYOURDRIVE_ROOTPATH . '/skins/' . $fileInfo->getFilename() . '/Thumb.jpg' : '';
                                  echo '<option value="' . $fileInfo->getFilename() . '" data-imagesrc="' . $icon . '" data-description="" ' . $selected . '>' . $fileInfo->getFilename() . "</option>\n";
                              }
                          }
                      }
                      ?>
                    </select>
                    <input type="hidden" name="UseyourDrive_mediaplayer_skin" id="UseyourDrive_mediaplayer_skin" value="<?php echo $selected; ?>"/>
                    <input type="hidden" name="UseyourDrive_mediaplayer_default" id="UseyourDrive_mediaplayer_default" value="<?php echo $default_player; ?>"/>
                  </div> 

                  <div class="useyourdrive-option-title"><?php _e('Mediaplayer Buttons', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e("Set which buttons (if supported) should be visible in the mediaplayer", "useyourdrive"); ?>.</div>

                  <?php
                  $buttons = array(
                      'prevtrack' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M76 480h24c6.6 0 12-5.4 12-12V285l219.5 187.6c20.6 17.2 52.5 2.8 52.5-24.6V64c0-27.4-31.9-41.8-52.5-24.6L112 228.1V44c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v424c0 6.6 5.4 12 12 12zM336 98.5v315.1L149.3 256.5 336 98.5z"></path></svg>',
                      'playpause' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6zM48 453.5v-395c0-4.6 5.1-7.5 9.1-5.2l334.2 197.5c3.9 2.3 3.9 8 0 10.3L57.1 458.7c-4 2.3-9.1-.6-9.1-5.2z"></path></svg>',
                      'nexttrack' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M372 32h-24c-6.6 0-12 5.4-12 12v183L116.5 39.4C95.9 22.3 64 36.6 64 64v384c0 27.4 31.9 41.8 52.5 24.6L336 283.9V468c0 6.6 5.4 12 12 12h24c6.6 0 12-5.4 12-12V44c0-6.6-5.4-12-12-12zM112 413.5V98.4l186.7 157.1-186.7 158z"></path></svg>',
                      'volume' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 512"><path fill="currentColor" d="M394.23 100.85c-11.19-7.09-26.03-3.8-33.12 7.41s-3.78 26.03 7.41 33.12C408.27 166.6 432 209.44 432 256s-23.73 89.41-63.48 114.62c-11.19 7.09-14.5 21.92-7.41 33.12 6.51 10.28 21.12 15.03 33.12 7.41C447.94 377.09 480 319.09 480 256s-32.06-121.09-85.77-155.15zm-56 78.28c-11.58-6.33-26.19-2.16-32.61 9.45-6.39 11.61-2.16 26.2 9.45 32.61C327.98 228.28 336 241.63 336 256c0 14.37-8.02 27.72-20.92 34.81-11.61 6.41-15.84 21-9.45 32.61 6.43 11.66 21.05 15.8 32.61 9.45 28.23-15.55 45.77-45 45.77-76.87s-17.54-61.33-45.78-76.87zM231.81 64c-5.91 0-11.92 2.18-16.78 7.05L126.06 160H24c-13.26 0-24 10.74-24 24v144c0 13.25 10.74 24 24 24h102.06l88.97 88.95c4.87 4.87 10.88 7.05 16.78 7.05 12.33 0 24.19-9.52 24.19-24.02V88.02C256 73.51 244.13 64 231.81 64zM208 366.05L145.94 304H48v-96h97.94L208 145.95v220.1z"></path></svg>',
                      'current' => '<span>00:01</span>',
                      'duration' => '<span>- 59:59</span>',
                      'skipback' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M267.5 281.2l192 159.4c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6L267.5 232c-15.3 12.8-15.3 36.4 0 49.2zM464 130.3V382L313 256.6l151-126.3zM11.5 281.2l192 159.4c20.6 17.2 52.5 2.8 52.5-24.6V96c0-27.4-31.9-41.8-52.5-24.6L11.5 232c-15.3 12.8-15.3 36.4 0 49.2zM208 130.3V382L57 256.6l151-126.3z"></path></svg>',
                      'jumpforward' => '<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M244.5 230.8L52.5 71.4C31.9 54.3 0 68.6 0 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160.6c15.3-12.8 15.3-36.4 0-49.2zM48 381.7V130.1l151 125.4L48 381.7zm452.5-150.9l-192-159.4C287.9 54.3 256 68.6 256 96v320c0 27.4 31.9 41.8 52.5 24.6l192-160.6c15.3-12.8 15.3-36.4 0-49.2zM304 381.7V130.1l151 125.4-151 126.2z"></path></svg>',
                      'speed' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M381.06 193.27l-75.76 97.4c-5.54-1.56-11.27-2.67-17.3-2.67-35.35 0-64 28.65-64 64 0 11.72 3.38 22.55 8.88 32h110.25c5.5-9.45 8.88-20.28 8.88-32 0-11.67-3.36-22.46-8.81-31.88l75.75-97.39c8.16-10.47 6.25-25.55-4.19-33.67-10.57-8.15-25.6-6.23-33.7 4.21zM288 32C128.94 32 0 160.94 0 320c0 52.8 14.25 102.26 39.06 144.8 5.61 9.62 16.3 15.2 27.44 15.2h443c11.14 0 21.83-5.58 27.44-15.2C561.75 422.26 576 372.8 576 320c0-159.06-128.94-288-288-288zm212.27 400H75.73C57.56 397.63 48 359.12 48 320 48 187.66 155.66 80 288 80s240 107.66 240 240c0 39.12-9.56 77.63-27.73 112z"></path></svg>',
                      'shuffle' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 400l-79.2 72.9c-15.1 15.1-41.8 4.4-41.8-17v-40h-31c-3.3 0-6.5-1.4-8.8-3.9l-89.8-97.2 38.1-41.3 79.8 86.3H384v-48c0-21.4 26.7-32.1 41.8-17l79.2 71c9.3 9.6 9.3 24.8 0 34.2zM12 152h91.8l79.8 86.3 38.1-41.3-89.8-97.2c-2.3-2.5-5.5-3.9-8.8-3.9H12c-6.6 0-12 5.4-12 12v32c0 6.7 5.4 12.1 12 12.1zm493-41.9l-79.2-71C410.7 24 384 34.7 384 56v40h-31c-3.3 0-6.5 1.4-8.8 3.9L103.8 360H12c-6.6 0-12 5.4-12 12v32c0 6.6 5.4 12 12 12h111c3.3 0 6.5-1.4 8.8-3.9L372.2 152H384v48c0 21.4 26.7 32.1 41.8 17l79.2-73c9.3-9.4 9.3-24.6 0-33.9z"></path></svg>',
                      'loop' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M512 256c0 83.813-68.187 152-152 152H136.535l55.762 54.545c4.775 4.67 4.817 12.341.094 17.064l-16.877 16.877c-4.686 4.686-12.284 4.686-16.971 0l-104-104c-4.686-4.686-4.686-12.284 0-16.971l104-104c4.686-4.686 12.284-4.686 16.971 0l16.877 16.877c4.723 4.723 4.681 12.393-.094 17.064L136.535 360H360c57.346 0 104-46.654 104-104 0-19.452-5.372-37.671-14.706-53.258a11.991 11.991 0 0 1 1.804-14.644l17.392-17.392c5.362-5.362 14.316-4.484 18.491 1.847C502.788 196.521 512 225.203 512 256zM62.706 309.258C53.372 293.671 48 275.452 48 256c0-57.346 46.654-104 104-104h223.465l-55.762 54.545c-4.775 4.67-4.817 12.341-.094 17.064l16.877 16.877c4.686 4.686 12.284 4.686 16.971 0l104-104c4.686-4.686 4.686-12.284 0-16.971l-104-104c-4.686-4.686-12.284-4.686-16.971 0l-16.877 16.877c-4.723 4.723-4.681 12.393.094 17.064L375.465 104H152C68.187 104 0 172.187 0 256c0 30.797 9.212 59.479 25.019 83.447 4.175 6.331 13.129 7.209 18.491 1.847l17.392-17.392a11.991 11.991 0 0 0 1.804-14.644z"></path></svg>',
                      'fullscreen' => '<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M0 180V56c0-13.3 10.7-24 24-24h124c6.6 0 12 5.4 12 12v24c0 6.6-5.4 12-12 12H48v100c0 6.6-5.4 12-12 12H12c-6.6 0-12-5.4-12-12zM288 44v24c0 6.6 5.4 12 12 12h100v100c0 6.6 5.4 12 12 12h24c6.6 0 12-5.4 12-12V56c0-13.3-10.7-24-24-24H300c-6.6 0-12 5.4-12 12zm148 276h-24c-6.6 0-12 5.4-12 12v100H300c-6.6 0-12 5.4-12 12v24c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24V332c0-6.6-5.4-12-12-12zM160 468v-24c0-6.6-5.4-12-12-12H48V332c0-6.6-5.4-12-12-12H12c-6.6 0-12 5.4-12 12v124c0 13.3 10.7 24 24 24h124c6.6 0 12-5.4 12-12z"></path></svg>',
                      'airplay' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.9 13.9"><g id="airplay"><polygon fill="currentColor" points="0 0 16.9 0 16.9 10.4 13.2 10.4 11.9 8.9 15.4 8.9 15.4 1.6 1.5 1.6 1.5 8.9 5 8.9 3.6 10.4 0 10.4 0 0"/><polygon fill="currentColor"  points="2.7 13.9 8.4 7 14.2 13.9 2.7 13.9"/></g></svg>',
                      'chromecast' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.3 13.4"><path id="chromecast" fill="currentColor" d="M80.4,13v2.2h2.2A2.22,2.22,0,0,0,80.4,13Zm0-2.9v1.5a3.69,3.69,0,0,1,3.7,3.68s0,0,0,0h1.5a5.29,5.29,0,0,0-5.2-5.2h0ZM93.7,4.9H83.4V6.1a9.59,9.59,0,0,1,6.2,6.2h4.1V4.9h0ZM80.4,7.1V8.6a6.7,6.7,0,0,1,6.7,6.7h1.4a8.15,8.15,0,0,0-8.1-8.2h0ZM95.1,1.9H81.8a1.54,1.54,0,0,0-1.5,1.5V5.6h1.5V3.4H95.1V13.7H89.9v1.5h5.2a1.54,1.54,0,0,0,1.5-1.5V3.4A1.54,1.54,0,0,0,95.1,1.9Z" transform="translate(-80.3 -1.9)"/></svg>'
                  );

                  $selected = (isset($_REQUEST['mediabuttons'])) ? explode('|', $_REQUEST['mediabuttons']) : array('prevtrack', 'playpause', 'nexttrack', 'volume', 'current', 'duration', 'fullscreen');

                  foreach ($buttons as $button_value => $button_text) {
                      if (in_array($button_value, $selected) || $selected[0] == 'all') {
                          $checked = 'checked="checked"';
                      } else {
                          $checked = '';
                      }

                      echo '<div class="useyourdrive-option-checkbox useyourdrive-option-checkbox-vertical-list media-buttons">';
                      echo '<input class="simple" type="checkbox" name="UseyourDrive_media_buttons[]" value="' . $button_value . '" ' . $checked . '/>';
                      echo '<label for="UseyourDrive_media_buttons" class="useyourdrive-option-checkbox-label">' . $button_text . '</label>';
                      echo '</div>';
                  }
                  ?>

                  <div class="useyourdrive-option-title"><?php _e('Show Playlist', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_showplaylist" id="UseyourDrive_showplaylist" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['hideplaylist']) && $_REQUEST['hideplaylist'] === '1') ? '' : 'checked="checked"'; ?> data-div-toggle="playlist-options">
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showplaylist"></label>
                    </div>
                  </div>   

                  <div class="useyourdrive-suboptions playlist-options <?php echo (isset($_REQUEST['hideplaylist']) && $_REQUEST['hideplaylist'] === '1') ? 'hidden' : ''; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Playlist open on start', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_showplaylistonstart" id="UseyourDrive_showplaylistonstart" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showplaylistonstart']) && $_REQUEST['showplaylistonstart'] === '0') ? '' : 'checked="checked"'; ?>>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showplaylistonstart"></label>
                      </div>
                    </div>  

                    <div class="forvideo">
                      <div class="useyourdrive-option-title"><?php _e('Playlist opens on top of player', 'useyourdrive'); ?>
                        <div class="useyourdrive-onoffswitch">
                          <input type="checkbox" name="UseyourDrive_showplaylistinline" id="UseyourDrive_showplaylistinline" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['playlistinline']) && $_REQUEST['playlistinline'] === '1') ? 'checked="checked"' : ''; ?>>
                            <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showplaylistinline"></label>
                        </div>
                      </div>  
                    </div>

                    <div class="useyourdrive-option-title"><?php _e('Display thumbnails', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_playlistthumbnails" id="UseyourDrive_playlistthumbnails" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['playlistthumbnails']) && $_REQUEST['playlistthumbnails'] === '0') ? '' : 'checked="checked"'; ?>>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_playlistthumbnails"></label>
                      </div>
                    </div>   
                    <div class="useyourdrive-option-description"><?php _e('Show thumbnails of your files in the Playlist', 'useyourdrive'); ?>. <?php _e('The plugin show the thumbnail provided by the cloud server or you can use your own one', 'useyourdrive'); ?>. <?php _e('If you want to use your own thumbnail, add a *.png or *.jpg file with the same name in the same folder. You can also add a cover with the name of the folder to show the cover for all files', 'useyourdrive'); ?>. <?php _e('If no cover is available, a placeholder will be used', 'useyourdrive'); ?>.</div>

                    <div class="useyourdrive-option-title"><?php _e('Show last modified date', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_media_filedate" id="UseyourDrive_media_filedate" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['filedate']) && $_REQUEST['filedate'] === '0') ? '' : 'checked="checked"'; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_media_filedate"></label>
                      </div>
                    </div>

                    <div class="useyourdrive-option-title"><?php _e('Download Button', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_linktomedia" id="UseyourDrive_linktomedia" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['linktomedia']) && $_REQUEST['linktomedia'] === '1') ? 'checked="checked"' : ''; ?>>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_linktomedia"></label>
                      </div>
                    </div>   

                    <div class="useyourdrive-option-title"><?php _e('Purchase Button', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_mediapurchase" id="UseyourDrive_mediapurchase" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['linktoshop']) && $_REQUEST['linktoshop'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle='webshop-options'>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_mediapurchase"></label>
                      </div>
                    </div>  

                    <div class="option webshop-options <?php echo (isset($_REQUEST['linktoshop'])) ? '' : 'hidden'; ?>">
                      <div class="useyourdrive-option-title"><?php _e('Link to webshop', 'useyourdrive'); ?></div>  
                      <input class="useyourdrive-option-input-large" type="text" name="UseyourDrive_linktoshop" id="UseyourDrive_linktoshop" placeholder="https://www.yourwebshop.com/" value="<?php echo (isset($_REQUEST['linktoshop'])) ? $_REQUEST['linktoshop'] : ''; ?>"/>
                    </div>
                  </div>
                </div>

                <div class="forfilebrowser forsearch">
                  <div class="useyourdrive-option-title"><?php _e('File Browser view', 'useyourdrive'); ?></div>
                  <?php
                  $filelayout = (!isset($_REQUEST['filelayout'])) ? 'grid' : $_REQUEST['filelayout'];
                  ?>
                  <div class="useyourdrive-option-radio">
                    <input type="radio" id="file_layout_grid" name="UseyourDrive_file_layout"  <?php echo ($filelayout === 'grid') ? 'checked="checked"' : ''; ?> value="grid" />
                    <label for="file_layout_grid" class="useyourdrive-option-radio-label"><?php _e('Grid/Thumbnail View', 'useyourdrive'); ?></label>
                  </div>
                  <div class="useyourdrive-option-radio">
                    <input type="radio" id="file_layout_list" name="UseyourDrive_file_layout"  <?php echo ($filelayout === 'list') ? 'checked="checked"' : ''; ?> value="list" />
                    <label for="file_layout_list" class="useyourdrive-option-radio-label"><?php _e('List View', 'useyourdrive'); ?></label>
                  </div>
                </div>

                <div class=" forfilebrowser forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Show header', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_breadcrumb" id="UseyourDrive_breadcrumb" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showbreadcrumb']) && $_REQUEST['showbreadcrumb'] === '0') ? '' : 'checked="checked"'; ?> data-div-toggle="header-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_breadcrumb"></label>
                    </div>
                  </div>  

                  <div class="useyourdrive-suboptions header-options <?php echo (isset($_REQUEST['showbreadcrumb']) && $_REQUEST['showbreadcrumb'] === '0') ? 'hidden' : ''; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Show refresh button', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_showrefreshbutton" id="UseyourDrive_showrefreshbutton" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showrefreshbutton']) && $_REQUEST['showrefreshbutton'] === '0') ? '' : 'checked="checked"'; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showrefreshbutton"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Add a refresh button in the header so users can refresh the file list and pull changes', 'useyourdrive'); ?></div>

                    <div class="useyourdrive-option-title"><?php _e('Breadcrumb text for top folder', 'useyourdrive'); ?></div>
                    <input type="text" name="UseyourDrive_roottext" id="UseyourDrive_roottext" placeholder="<?php _e('Start', 'useyourdrive'); ?>" value="<?php echo (isset($_REQUEST['roottext'])) ? $_REQUEST['roottext'] : ''; ?>"/>
                  </div>
                </div>
                <div class=" forfilebrowser forsearch forgallery">
                  <div class="option forfilebrowser forsearch forlistonly">
                    <div class="useyourdrive-option-title"><?php _e('Show columnnames', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_showcolumnnames" id="UseyourDrive_showcolumnnames" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showcolumnnames']) && $_REQUEST['showcolumnnames'] === '0') ? '' : 'checked="checked"'; ?> data-div-toggle="columnnames-options"/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showcolumnnames"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Display the columnnames of the date and filesize in the List View of the File Browser', 'useyourdrive'); ?></div>

                    <div class="useyourdrive-suboptions columnnames-options">
                      <div class="option-filesize">
                        <div class="useyourdrive-option-title"><?php _e('Show file size', 'useyourdrive'); ?>
                          <div class="useyourdrive-onoffswitch">
                            <input type="checkbox" name="UseyourDrive_filesize" id="UseyourDrive_filesize" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['filesize']) && $_REQUEST['filesize'] === '0') ? '' : 'checked="checked"'; ?>/>
                            <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_filesize"></label>
                          </div>
                        </div>
                        <div class="useyourdrive-option-description"><?php _e('Display or Hide column with file sizes in List view', 'useyourdrive'); ?></div>
                      </div>

                      <div class="option-filedate">
                        <div class="useyourdrive-option-title"><?php _e('Show last modified date', 'useyourdrive'); ?>
                          <div class="useyourdrive-onoffswitch">
                            <input type="checkbox" name="UseyourDrive_filedate" id="UseyourDrive_filedate" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['filedate']) && $_REQUEST['filedate'] === '0') ? '' : 'checked="checked"'; ?>/>
                            <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_filedate"></label>
                          </div>
                        </div>
                        <div class="useyourdrive-option-description"><?php _e('Display or Hide column with last modified date in List view', 'useyourdrive'); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="option forfilebrowser forsearch forgallery">
                    <div class="useyourdrive-option-title"><?php _e('Show file extension', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_showext" id="UseyourDrive_showext" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showext']) && $_REQUEST['showext'] === '0') ? '' : 'checked="checked"'; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showext"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Display or Hide the file extensions', 'useyourdrive'); ?></div>

                    <div class="useyourdrive-option-title"><?php _e('Show files', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_showfiles" id="UseyourDrive_showfiles" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showfiles']) && $_REQUEST['showfiles'] === '0') ? '' : 'checked="checked"'; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showfiles"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Display or Hide files', 'useyourdrive'); ?></div>
                  </div>

                  <div class="useyourdrive-option-title"><?php _e('Show folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_showfolders" id="UseyourDrive_showfolders" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showfolders']) && $_REQUEST['showfolders'] === '0') ? '' : 'checked="checked"'; ?>/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showfolders"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Display or Hide child folders', 'useyourdrive'); ?></div>

                  <div class="showfiles-options">
                    <div class="useyourdrive-option-title"><?php _e('Amount of files', 'useyourdrive'); ?>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Number of files to show', 'useyourdrive'); ?>. <?php _e('Can be used for instance to only show the last 5 updated documents', 'useyourdrive'); ?>. <?php _e("Leave this field empty or set it to -1 for no limit", 'useyourdrive'); ?></div>
                    <input type="text" name="UseyourDrive_maxfiles" id="UseyourDrive_maxfiles" placeholder="-1" value="<?php echo (isset($_REQUEST['maxfiles'])) ? $_REQUEST['maxfiles'] : ''; ?>"/>
                  </div>
                </div>

                <div class="option forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Show file names', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_showfilenames" id="UseyourDrive_showfilenames" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showfilenames']) && $_REQUEST['showfilenames'] === '1') ? 'checked="checked"' : ''; ?>/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showfilenames"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Display or Hide the file names in the gallery', 'useyourdrive'); ?></div>

                  <div class="useyourdrive-option-title"><?php _e('Gallery row height', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e("The ideal height you want your grid rows to be", 'useyourdrive'); ?>. <?php _e("It won't set it exactly to this as plugin adjusts the row height to get the correct width", 'useyourdrive'); ?>. <?php _e('Leave empty for default value', 'useyourdrive'); ?> (200px).</div>
                  <input type="text" name="UseyourDrive_targetHeight" id="UseyourDrive_targetHeight" placeholder="200" value="<?php echo (isset($_REQUEST['targetheight'])) ? $_REQUEST['targetheight'] : ''; ?>"/>

                  <div class="useyourdrive-option-title"><?php _e('Number of images lazy loaded', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php _e("Number of images to be loaded each time", 'useyourdrive'); ?>. <?php _e("Set to 0 to load all images at once", 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_maximage" id="UseyourDrive_maximage" placeholder="25" value="<?php echo (isset($_REQUEST['maximages'])) ? $_REQUEST['maximages'] : ''; ?>"/>

                  <!---
                  <div class="useyourdrive-option-title"><?php _e('Show Folder Thumbnails in Gallery', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_folderthumbs" id="UseyourDrive_folderthumbs" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['folderthumbs']) && $_REQUEST['folderthumbs'] === '1') ? 'checked="checked"' : ''; ?> />
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_folderthumbs"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e("Do you want to show thumbnails for the Folders in the gallery mode?", 'useyourdrive'); ?> <?php _e("Please note, when enabled the loading performance can drop proportional to the number of folders present in the Gallery", 'useyourdrive'); ?>.</div>
                  -->

                  <div class="useyourdrive-option-title"><?php _e('Slideshow', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_slideshow" id="UseyourDrive_slideshow" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['slideshow']) && $_REQUEST['slideshow'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="slideshow-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_slideshow"></label>
                    </div>
                  </div>

                  <div class="slideshow-options">                  
                    <div class="useyourdrive-option-description"><?php _e('Enable or disable the Slideshow mode in the Lightbox', 'useyourdrive'); ?></div>                  
                    <div class="useyourdrive-option-title"><?php _e('Delay between cycles (ms)', 'useyourdrive'); ?></div>
                    <div class="useyourdrive-option-description"><?php _e('Delay between cycles in milliseconds, the default is 5000', 'useyourdrive'); ?>.</div>
                    <input type="text" name="UseyourDrive_pausetime" id="UseyourDrive_pausetime" placeholder="5000" value="<?php echo (isset($_REQUEST['pausetime'])) ? $_REQUEST['pausetime'] : ''; ?>"/>
                  </div>
                </div>
              </div>
              <!-- End Layout Tab -->

              <!-- Sorting Tab -->
              <div id="settings_sorting"  class="useyourdrive-tab-panel">

                <div class="useyourdrive-tab-panel-header"><?php _e('Sorting', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Sort field', 'useyourdrive'); ?></div>
                <?php
                $sortfield = (!isset($_REQUEST['sortfield'])) ? 'name' : $_REQUEST['sortfield'];
                ?>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="name" name="sort_field" <?php echo ($sortfield === 'name') ? 'checked="checked"' : ''; ?> value="name"/>
                  <label for="name" class="useyourdrive-option-radio-label"><?php _e('Name', 'useyourdrive'); ?></label>
                </div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="size" name="sort_field" <?php echo ($sortfield === 'size') ? 'checked="checked"' : ''; ?> value="size" />
                  <label for="size" class="useyourdrive-option-radio-label"><?php _e('Size', 'useyourdrive'); ?></label>
                </div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="created" name="sort_field" <?php echo ($sortfield === 'created') ? 'checked="checked"' : ''; ?> value="created" />
                  <label for="created" class="useyourdrive-option-radio-label"><?php _e('Date of creation', 'useyourdrive'); ?></label>
                </div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="modified" name="sort_field" <?php echo ($sortfield === 'modified') ? 'checked="checked"' : ''; ?> value="modified" />
                  <label for="modified" class="useyourdrive-option-radio-label"><?php _e('Date modified', 'useyourdrive'); ?></label>
                </div>
                <div class="useyourdrive-option-radio">
                  <input type="radio" id="shuffle" name="sort_field" <?php echo ($sortfield === 'shuffle') ? 'checked="checked"' : ''; ?> value="shuffle" />
                  <label for="shuffle" class="useyourdrive-option-radio-label"><?php _e('Shuffle/Random', 'useyourdrive'); ?></label>
                </div>

                <div class="option-sort-field">
                  <div class="useyourdrive-option-title"><?php _e('Sort order', 'useyourdrive'); ?></div>

                  <?php
                  $sortorder = (isset($_REQUEST['sortorder']) && $_REQUEST['sortorder'] === 'desc') ? 'desc' : 'asc';
                  ?>
                  <div class="useyourdrive-option-radio">
                    <input type="radio" id="asc" name="sort_order" <?php echo ($sortorder === 'asc') ? 'checked="checked"' : ''; ?> value="asc"/>
                    <label for="asc" class="useyourdrive-option-radio-label"><?php _e('Ascending', 'useyourdrive'); ?></label>
                  </div>
                  <div class="useyourdrive-option-radio">
                    <input type="radio" id="desc" name="sort_order" <?php echo ($sortorder === 'desc') ? 'checked="checked"' : ''; ?> value="desc"/>
                    <label for="desc" class="useyourdrive-option-radio-label"><?php _e('Descending', 'useyourdrive'); ?></label>
                  </div>
                </div>
              </div>
              <!-- End Sorting Tab -->
              <!-- Advanced Tab -->
              <div id="settings_advanced"  class="useyourdrive-tab-panel">
                <div class="useyourdrive-tab-panel-header"><?php _e('Advanced', 'useyourdrive'); ?></div>

                <div class=" forfilebrowser forsearch forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Allow Preview', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_allow_preview" id="UseyourDrive_allow_preview" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['forcedownload']) && $_REQUEST['forcedownload'] === '1') ? '' : 'checked="checked"'; ?> data-div-toggle="preview-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_allow_preview"></label>
                    </div>
                  </div>


                  <div class="useyourdrive-suboptions preview-options <?php echo (isset($_REQUEST['forcedownload']) && $_REQUEST['forcedownload'] === '1') ? 'hidden' : ''; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Inline Preview', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_previewinline" id="UseyourDrive_previewinline" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['previewinline']) && $_REQUEST['previewinline'] === '0') ? '' : 'checked="checked"'; ?> data-div-toggle="preview-options-inline"/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_previewinline"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Open preview inside a lightbox or open in a new window', 'useyourdrive'); ?></div>

                    <div class="useyourdrive-suboptions preview-options-inline <?php echo (isset($_REQUEST['previewinline']) && $_REQUEST['previewinline'] === '0') ? 'hidden' : ''; ?>">

                      <div class="useyourdrive-option-title"><?php _e('Enable Google pop out Button', 'useyourdrive'); ?>
                        <div class="useyourdrive-onoffswitch">
                          <input type="checkbox" name="UseyourDrive_canpopout" id="UseyourDrive_canpopout"  class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['canpopout']) && $_REQUEST['canpopout'] === '1') ? 'checked="checked"' : ''; ?>/>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_canpopout"></label>
                        </div>
                      </div>
                      <div class="useyourdrive-option-description"><?php _e('Activate the Google Pop Out button which is visible in the inline preview for a couple of file formats', 'useyourdrive'); ?>. </div>

                      <div class="useyourdrive-option-title"><?php _e('Lightbox navigation', 'useyourdrive'); ?>
                        <div class="useyourdrive-onoffswitch">
                          <input type="checkbox" name="UseyourDrive_lightboxnavigation" id="UseyourDrive_lightboxnavigation"  class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['lightboxnavigation']) && $_REQUEST['lightboxnavigation'] === '0') ? '' : 'checked="checked"'; ?>/>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_lightboxnavigation"></label>
                        </div>
                      </div>
                      <div class="useyourdrive-option-description"><?php _e('Navigate through your documents in the lightbox. Disable when each document should be shown individually without navigation arrows', 'useyourdrive'); ?>. </div>

                    </div>

                  </div>
                </div>

                <div class="option forfilebrowser foruploadbox forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Allow Searching', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_search" id="UseyourDrive_search" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['search']) && $_REQUEST['search'] === '0') ? '' : 'checked="checked"'; ?> data-div-toggle="search-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_search"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('The search function allows your users to find files by filename and content (when files are indexed)', 'useyourdrive'); ?></div>


                  <div class="option search-options <?php echo (isset($_REQUEST['search']) && $_REQUEST['search'] === '1') ? '' : 'hidden'; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Perform Full-Text search', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_search_field" id="UseyourDrive_search_field"  class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['searchcontents']) && $_REQUEST['searchcontents'] === '1') ? 'checked="checked"' : ''; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_search_field"></label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class=" forfilebrowser forsearch forgallery">
                  <?php
                  if (class_exists('ZipArchive')) {
                      ?>
                      <div class="useyourdrive-option-title"><?php _e('Allow ZIP Download', 'useyourdrive'); ?>
                        <div class="useyourdrive-onoffswitch">
                          <input type="checkbox" name="UseyourDrive_candownloadzip" id="UseyourDrive_candownloadzip" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['candownloadzip']) && $_REQUEST['candownloadzip'] === '1') ? 'checked="checked"' : ''; ?>/>
                          <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_candownloadzip"></label>
                        </div>
                      </div>
                      <div class="useyourdrive-option-description"><?php _e('Allow users to download multiple files at once', 'useyourdrive'); ?></div>
                  <?php } ?>
                </div>

                <div class="foraudio forvideo">
                  <div class="useyourdrive-option-title"><?php _e('Auto Play', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_autoplay" id="UseyourDrive_autoplay" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['autoplay']) && $_REQUEST['autoplay'] === '1') ? 'checked="checked"' : ''; ?>>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_autoplay"></label>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Autoplay is generally not recommended as it is seen as a negative user experience. It is also disabled in many browsers', 'useyourdrive'); ?>.</div>
                  </div>
                </div>

                <div class="forvideo">
                  <div class="useyourdrive-option-title"><?php _e('Enable Video Advertisements', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_media_ads" id="UseyourDrive_media_ads" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['ads']) && $_REQUEST['ads'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="ads-options">
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_media_ads"></label>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('The mediaplayer of the plugin supports VAST XML advertisments to offer monetization options for your videos. You can enable advertisments for the complete site on the Advanced tab of the plugin settings page and per shortcode. Currently, this plugin only supports Linear elements with MP4', 'useyourdrive'); ?>.</div>
                  </div> 

                  <div class="useyourdrive-suboptions ads-options <?php echo ((isset($_REQUEST['ads']) && $_REQUEST['ads'] === '1') ? '' : 'hidden') ?> ">
                    <div class="useyourdrive-option-title"><?php echo 'VAST XML Tag Url'; ?></div>
                    <input type="text" name="UseyourDrive_media_ads" id="UseyourDrive_media_adstagurl" class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['ads_tag_url'])) ? $_REQUEST['ads_tag_url'] : ''; ?>" placeholder="<?php echo $this->get_processor()->get_setting('mediaplayer_ads_tagurl'); ?>" />

                    <div class="uyd-warning">
                      <i><strong><?php _e('NOTICE', 'useyourdrive'); ?></strong>: <?php _e('If you are unable to see the example VAST url below, please make sure you do not have an ad blocker enabled.', 'useyourdrive'); ?>.</i>
                    </div>

                    <a href="https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/single_ad_samples&ciu_szs=300x250&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&cust_params=deployment%3Ddevsite%26sample_ct%3Dskippablelinear&correlator=" rel="no-follow">Example Tag URL</a>

                    <div class="useyourdrive-option-title"><?php _e('Enable Skip Button', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_media_ads_skipable" id="UseyourDrive_media_ads_skipable" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['ads_skipable']) && $_REQUEST['ads_skipable'] === '1') ? 'checked="checked"' : ''; ?>data-div-toggle="ads_skipable"/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_media_ads_skipable"></label>
                      </div>
                    </div>

                    <div class="useyourdrive-suboptions ads_skipable <?php echo ((isset($_REQUEST['ads_skipable']) && $_REQUEST['ads_skipable'] === '0') ? 'hidden' : '') ?> ">
                      <div class="useyourdrive-option-title"><?php _e('Skip button visible after (seconds)', 'useyourdrive'); ?></div>
                      <input class="useyourdrive-option-input-large" type="text" name="UseyourDrive_media_ads_skipable_after" id="UseyourDrive_media_ads_skipable_after" value="<?php echo (isset($_REQUEST['ads_skipable_after'])) ? $_REQUEST['ads_skipable_after'] : ''; ?>" placeholder="<?php echo $this->get_processor()->get_setting('mediaplayer_ads_skipable_after'); ?>">
                        <div class="useyourdrive-option-description"><?php _e('Allow user to skip advertisment after after the following amount of seconds have elapsed', 'useyourdrive'); ?></div>
                    </div>
                  </div>

                </div>

              </div>
              <!-- End Advanced Tab -->
              <!-- Exclusions Tab -->
              <div id="settings_exclusions"  class="useyourdrive-tab-panel">
                <div class="useyourdrive-tab-panel-header"><?php _e('Exclusions', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Only show files with those extensions', 'useyourdrive'); ?>:</div>
                <div class="useyourdrive-option-description"><?php echo __('Add extensions separated with | e.g. (jpg|png|gif)', 'useyourdrive') . '. ' . __('Leave empty to show all files', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_include_ext" id="UseyourDrive_include_ext" class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['includeext'])) ? $_REQUEST['includeext'] : ''; ?>"/>

                <div class="useyourdrive-option-title"><?php _e('Only show the following files or folders', 'useyourdrive'); ?>:</div>
                <div class="useyourdrive-option-description"><?php echo __('Add files or folders by name or Google Drive ID separated with | e.g. (file1.jpg|long folder name)', 'useyourdrive'); ?>. <?php echo __('Wildcards like * and ? are allowed', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_include" id="UseyourDrive_include" class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['include'])) ? $_REQUEST['include'] : ''; ?>"/>

                <div class="useyourdrive-option-title"><?php _e('Hide files with those extensions', 'useyourdrive'); ?>:</div>
                <div class="useyourdrive-option-description"><?php echo __('Add extensions separated with | e.g. (jpg|png|gif)', 'useyourdrive') . '. ' . __('Leave empty to show all files', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_exclude_ext" id="UseyourDrive_exclude_ext" class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['excludeext'])) ? $_REQUEST['excludeext'] : ''; ?>"/>

                <div class="useyourdrive-option-title"><?php _e('Hide the following files or folders', 'useyourdrive'); ?>:</div>
                <div class="useyourdrive-option-description"><?php echo __('Add files or folders by name or Google Drive ID separated with | e.g. (file1.jpg|long folder name)', 'useyourdrive'); ?>. <?php echo __('Wildcards like * and ? are allowed', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_exclude" id="UseyourDrive_exclude"  class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['exclude'])) ? $_REQUEST['exclude'] : ''; ?>"/>

              </div>
              <!-- End Exclusions Tab -->

              <!-- Upload Tab -->
              <div id="settings_upload"  class="useyourdrive-tab-panel">

                <div class="useyourdrive-tab-panel-header"><?php _e('Upload Box', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Allow Upload', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type="checkbox" name="UseyourDrive_upload" id="UseyourDrive_upload" data-div-toggle="upload-options" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['upload']) && $_REQUEST['upload'] === '1') ? 'checked="checked"' : ''; ?>/>
                    <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_upload"></label>
                  </div>
                </div>
                <div class="useyourdrive-option-description"><?php _e('Allow users to upload files', 'useyourdrive'); ?>. <?php echo sprintf(__('You can select which Users Roles should be able to upload via %s', 'useyourdrive'), '<a href="#" onclick="jQuery(\'li[data-tab=settings_permissions]\').trigger(\'click\')">' . __('User Permissions', 'useyourdrive') . '</a>'); ?>.</div>

                <div class="option upload-options <?php echo (isset($_REQUEST['upload']) && $_REQUEST['upload'] === '1' && in_array($mode, array('files', 'upload', 'gallery'))) ? '' : 'hidden'; ?>">

                  <div class="useyourdrive-option-title"><?php _e('Allow folder upload', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_upload_folder" id="UseyourDrive_upload_folder"  class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['upload_folder']) && $_REQUEST['upload_folder'] === '0') ? '' : 'checked="checked"'; ?>/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_upload_folder"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Adds an Add Folder button to the upload form if the browser supports it', 'useyourdrive'); ?>. </div>


                  <div class="useyourdrive-option-title"><?php _e('Overwrite existing files', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_overwrite" id="UseyourDrive_overwrite"  class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['overwrite']) && $_REQUEST['overwrite'] === '1') ? 'checked="checked"' : ''; ?>/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_overwrite"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Overwrite already existing files or auto-rename the new uploaded files', 'useyourdrive'); ?>. </div>

                  <div class="useyourdrive-option-title"><?php _e('Restrict file extensions', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php echo __('Add extensions separated with | e.g. (jpg|png|gif)', 'useyourdrive') . ' ' . __('Leave empty for no restriction', 'useyourdrive', 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_upload_ext" id="UseyourDrive_upload_ext" value="<?php echo (isset($_REQUEST['uploadext'])) ? $_REQUEST['uploadext'] : ''; ?>"/>

                  <div class="useyourdrive-option-title"><?php _e('Max uploads per session', 'useyourdrive'); ?></div>
                  <div class="useyourdrive-option-description"><?php echo __('Number of maximum uploads per upload session', 'useyourdrive') . ' ' . __('Leave empty for no restriction', 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_maxnumberofuploads" id="UseyourDrive_maxnumberofuploads" placeholder="-1" value="<?php echo (isset($_REQUEST['maxnumberofuploads'])) ? $_REQUEST['maxnumberofuploads'] : ''; ?>"/>

                  <div class="useyourdrive-option-title"><?php _e('Minimum file size', 'useyourdrive'); ?></div>
                  <?php
                  /* Convert bytes to MB when needed */
                  $min_size_value = (isset($_REQUEST['minfilesize']) ? $_REQUEST['minfilesize'] : '');
                  if (!empty($min_size_value) && ctype_digit($min_size_value)) {
                      $min_size_value = \TheLion\UseyourDrive\Helpers::bytes_to_size_1024($min_size_value);
                  }
                  ?>
                  <div class="useyourdrive-option-description"><?php _e('Min filesize (e.g. 1 MB) for uploading', 'useyourdrive'); ?>. <?php echo __('Leave empty for no restriction', 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_minfilesize" id="UseyourDrive_minfilesize" value="<?php echo $min_size_value; ?>"/>

                  <div class="useyourdrive-option-title"><?php _e('Maximum file size', 'useyourdrive'); ?></div>
                  <?php
                  /* Convert bytes in version before 1.8 to MB */
                  $max_size_value = (isset($_REQUEST['maxfilesize']) ? $_REQUEST['maxfilesize'] : '');
                  if (!empty($max_size_value) && ctype_digit($max_size_value)) {
                      $max_size_value = \TheLion\UseyourDrive\Helpers::bytes_to_size_1024($max_size_value);
                  }
                  ?>
                  <div class="useyourdrive-option-description"><?php _e('Max filesize for uploading', 'useyourdrive'); ?>. <?php echo __('Leave empty for no restriction', 'useyourdrive'); ?>.</div>
                  <input type="text" name="UseyourDrive_maxfilesize" id="UseyourDrive_maxfilesize" placeholder="<?php _e('No limit', 'useyourdrive'); ?>" value="<?php echo $max_size_value; ?>"/>

                  <div style="<?php echo ((version_compare(phpversion(), '7.1.0', '<='))) ? '' : "display:none;" ?>">
                    <div class="useyourdrive-option-title"><?php _e('Encryption', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_encryption" id="UseyourDrive_encryption"  data-div-toggle="upload-encryption-options" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['upload_encryption']) && $_REQUEST['upload_encryption'] === '1') ? 'checked="checked"' : ''; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_encryption"></label>
                      </div>
                    </div>
                    <div class="useyourdrive-option-description"><?php _e('Use the powerful 256-bit AES Crypt encryption to securely store your files in the cloud', 'useyourdrive'); ?>. <?php _e('The encryption takes place on your server before the files are uploaded', 'useyourdrive'); ?>. <?php _e('You can decrypt the files with a tool like: ', 'useyourdrive'); ?> <a href="https://www.aescrypt.com/download/" target="_blank">AES Crypt</a>.</div>
                    <div class="useyourdrive-suboptions upload-encryption-options <?php echo (isset($_REQUEST['upload_encryption']) && $_REQUEST['upload_encryption'] === '1') ? '' : 'hidden'; ?>">
                      <div class="useyourdrive-option-title"><?php _e('Passphrase'); ?></div>
                      <input type="text" name="UseyourDrive_encryption_passphrase" id="UseyourDrive_encryption_passphrase" class="useyourdrive-option-input-large" value="<?php echo (isset($_REQUEST['upload_encryption_passphrase'])) ? $_REQUEST['upload_encryption_passphrase'] : ''; ?>"/>
                    </div>
                  </div>

                  <div class="useyourdrive-option-title"><?php _e('Convert to Google Docs when possible', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_upload_convert" id="UseyourDrive_upload_convert" data-div-toggle="upload-convert-options" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['convert']) && $_REQUEST['convert'] === '1') ? 'checked="checked"' : ''; ?>/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_upload_convert"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-suboptions upload-convert-options <?php echo (isset($_REQUEST['convert']) && $_REQUEST['convert'] === '1') ? '' : 'hidden'; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Convert following mimetypes', 'useyourdrive'); ?></div>
                    <?php
                    $importFormats = array(
                        "application/msword" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.template" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.ms-word.document.macroenabled.12" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.ms-word.template.macroenabled.12" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/x-vnd.oasis.opendocument.text" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/pdf" =>
                        "application/vnd.google-apps.document"
                        ,
                        "text/html" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.oasis.opendocument.text" =>
                        "application/vnd.google-apps.document"
                        ,
                        "text/richtext" =>
                        "application/vnd.google-apps.document"
                        ,
                        "text/rtf" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/rtf" =>
                        "application/vnd.google-apps.document"
                        ,
                        "text/plain" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.sun.xml.writer" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.ms-excel" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.ms-excel.sheet.macroenabled.12" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.ms-excel.template.macroenabled.12" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.template" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.oasis.opendocument.spreadsheet" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/x-vnd.oasis.opendocument.spreadsheet" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "text/tab-separated-values" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "text/csv" =>
                        "application/vnd.google-apps.spreadsheet"
                        ,
                        "application/vnd.ms-powerpoint" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.openxmlformats-officedocument.presentationml.template" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.openxmlformats-officedocument.presentationml.presentation" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.openxmlformats-officedocument.presentationml.slideshow" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.oasis.opendocument.presentation" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.ms-powerpoint.template.macroenabled.12" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.ms-powerpoint.presentation.macroenabled.12" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/vnd.ms-powerpoint.slideshow.macroenabled.12" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "application/x-vnd.oasis.opendocument.presentation" =>
                        "application/vnd.google-apps.presentation"
                        ,
                        "image/jpg" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/jpeg" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/bmp" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/x-bmp" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/gif" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/png" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/x-png" =>
                        "application/vnd.google-apps.document"
                        ,
                        "image/pjpeg" =>
                        "application/vnd.google-apps.document"
                        ,
                        "application/vnd.google-apps.script+text/plain" =>
                        "application/vnd.google-apps.script"
                        ,
                        "application/json" =>
                        "application/vnd.google-apps.script"
                        ,
                        "application/vnd.google-apps.script+json" =>
                        "application/vnd.google-apps.script"
                        ,
                        "application/x-msmetafile" =>
                        "application/vnd.google-apps.drawing"
                    );


                    $selected_formats = (isset($_REQUEST['convertformats'])) ? explode('|', $_REQUEST['convertformats']) : array_keys($importFormats);

                    foreach ($importFormats as $mimetype => $import_mimetype) {
                        if (in_array($mimetype, $selected_formats)) {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = '';
                        }
                        echo '<div class="useyourdrive-option-checkbox">';
                        echo '<input class="simple" type="checkbox" name="UseyourDrive_upload_convert_formats[]" id="UseyourDrive_upload_convert_formats" value="' . $mimetype . '" ' . $checked . '>';
                        echo '<label for="userfolders_method_auto1" class="useyourdrive-option-checkbox-label">' . $mimetype . '</label>';
                        echo '</div>';
                    }
                    ?>
                  </div>

                </div>
              </div>
              <!-- End Upload Tab -->

              <!-- Notifications Tab -->
              <div id="settings_notifications"  class="useyourdrive-tab-panel">

                <div class="useyourdrive-tab-panel-header"><?php _e('Notifications', 'useyourdrive'); ?></div>

                <div class="useyourdrive-option-title"><?php _e('Download email notification', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type="checkbox" name="UseyourDrive_notificationdownload" id="UseyourDrive_notificationdownload" class="useyourdrive-onoffswitch-checkbox"  <?php echo (isset($_REQUEST['notificationdownload']) && $_REQUEST['notificationdownload'] === '1') ? 'checked="checked"' : ''; ?>/>
                    <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_notificationdownload"></label>
                  </div>
                </div>

                <div class="useyourdrive-option-title"><?php _e('Upload email notification', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type="checkbox" name="UseyourDrive_notificationupload" id="UseyourDrive_notificationupload" class="useyourdrive-onoffswitch-checkbox"  <?php echo (isset($_REQUEST['notificationupload']) && $_REQUEST['notificationupload'] === '1') ? 'checked="checked"' : ''; ?>/>
                    <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_notificationupload"></label>
                  </div>
                </div>
                <div class="useyourdrive-option-title"><?php _e('Delete email notification', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type="checkbox" name="UseyourDrive_notificationdeletion" id="UseyourDrive_notificationdeletion" class="useyourdrive-onoffswitch-checkbox"  <?php echo (isset($_REQUEST['notificationdeletion']) && $_REQUEST['notificationdeletion'] === '1') ? 'checked="checked"' : ''; ?>/>
                    <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_notificationdeletion"></label>
                  </div>
                </div>

                <div class="useyourdrive-option-title"><?php _e('Recipients', 'useyourdrive'); ?></div>
                <div class="useyourdrive-option-description"><?php _e('On which email address would you like to receive the notification? You can use <code>%admin_email%</code>, <code>%user_email%</code> (user that executes the action) and <code>%linked_user_email%</code> (Private Folders owners)', 'useyourdrive'); ?>.</div>
                <input type="text" name="UseyourDrive_notification_email" id="UseyourDrive_notification_email" class="useyourdrive-option-input-large" placeholder="<?php echo get_option('admin_email'); ?>" value="<?php echo (isset($_REQUEST['notificationemail'])) ? $_REQUEST['notificationemail'] : ''; ?>" />

                <div class="uyd-warning">
                  <i><strong><?php _e('NOTICE', 'useyourdrive'); ?></strong>: <?php echo sprintf(__("%s can be used to send notications to the owner(s) of the Private Folder", 'useyourdrive'), '<code>%linked_user_email%</code>'); ?>. <?php echo sprintf(__("When using this placeholder in combination with automatically linked Private Folders, the %sName Template%s should contain %s", 'useyourdrive'), '<a href="' . admin_url('admin.php?page=UseyourDrive_settings#settings_userfolders') . '" target="_blank">', '</a>', '<code>%user_email%</code>'); ?>. <?php _e("I.e. the Private Folder name needs to contain the emailaddress", 'useyourdrive'); ?>.</i>
                </div>

                <div class="useyourdrive-option-title"><?php _e('Skip notification of the user that executes the action', 'useyourdrive'); ?>
                  <div class="useyourdrive-onoffswitch">
                    <input type="checkbox" name="UseyourDrive_notification_skip_email_currentuser" id="UseyourDrive_notification_skip_email_currentuser" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['notification_skipemailcurrentuser']) && $_REQUEST['notification_skipemailcurrentuser'] === '1') ? 'checked="checked"' : ''; ?>/>
                    <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_notification_skip_email_currentuser"></label>
                  </div>
                </div>

              </div>
              <!-- End Notifications Tab -->

              <!-- Manipulation Tab -->
              <div id="settings_manipulation"  class="useyourdrive-tab-panel">
                <div class="useyourdrive-tab-panel-header"><?php _e('File Manipulation', 'useyourdrive'); ?></div>

                <div class="option forfilebrowser forgallery forsearch">
                  <div class="useyourdrive-option-title"><?php _e('Allow Sharing', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_showsharelink" id="UseyourDrive_showsharelink" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['showsharelink']) && $_REQUEST['showsharelink'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="sharing-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_showsharelink"></label>
                    </div>
                  </div>
                  <div class="useyourdrive-option-description"><?php _e('Allow users to generate permanent shared links to the files', 'useyourdrive'); ?></div>

                  <div class="useyourdrive-option-title"><?php _e('Edit descriptions', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_editdescription" id="UseyourDrive_editdescription" class="useyourdrive-onoffswitch-checkbox"  <?php echo (isset($_REQUEST['editdescription']) && $_REQUEST['editdescription'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="editdescription-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_editdescription"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-option-title"><?php _e('Rename files and folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_rename" id="UseyourDrive_rename" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['rename']) && $_REQUEST['rename'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="rename-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_rename"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-option-title"><?php _e('Move files and folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_move" id="UseyourDrive_move" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['move']) && $_REQUEST['move'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="move-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_move"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-option-title"><?php _e('Delete files and folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_delete" id="UseyourDrive_delete" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['delete']) && $_REQUEST['delete'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="delete-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_delete"></label>
                    </div>
                  </div>

                  <div class="useyourdrive-suboptions delete-options <?php echo (isset($_REQUEST['delete']) && $_REQUEST['delete'] === '1') ? '' : 'hidden'; ?>">
                    <div class="useyourdrive-option-title"><?php _e('Delete to trash', 'useyourdrive'); ?>
                      <div class="useyourdrive-onoffswitch">
                        <input type="checkbox" name="UseyourDrive_deletetotrash" id="UseyourDrive_deletetotrash" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['deletetotrash']) && $_REQUEST['deletetotrash'] === '0') ? '' : 'checked="checked"'; ?>/>
                        <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_deletetotrash"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="option forfilebrowser forgallery">
                  <div class="useyourdrive-option-title"><?php _e('Create new folders', 'useyourdrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_addfolder" id="UseyourDrive_addfolder" class="useyourdrive-onoffswitch-checkbox" <?php echo (isset($_REQUEST['addfolder']) && $_REQUEST['addfolder'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="addfolder-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_addfolder"></label>
                    </div>
                  </div>
                </div>

                <div class="option forfilebrowser">
                  <div class="useyourdrive-option-title"><?php _e('Edit Google Docs and Office documents', 'shareonedrive'); ?>
                    <div class="useyourdrive-onoffswitch">
                      <input type="checkbox" name="UseyourDrive_edit" id="UseyourDrive_edit" class="useyourdrive-onoffswitch-checkbox"  <?php echo (isset($_REQUEST['edit']) && $_REQUEST['edit'] === '1') ? 'checked="checked"' : ''; ?> data-div-toggle="edit-options"/>
                      <label class="useyourdrive-onoffswitch-label" for="UseyourDrive_edit"></label>
                    </div>
                  </div>
                </div>

                <br/><br/>

                <div class="useyourdrive-option-description">
                  <?php echo sprintf(__('Select via %s which User Roles are able to perform the actions', 'useyourdrive'), '<a href="#" onclick="jQuery(\'li[data-tab=settings_permissions]\').trigger(\'click\')">' . __('User Permissions', 'useyourdrive') . '</a>'); ?>.
                </div>

              </div>
              <!-- End Manipulation Tab -->
              <!-- Permissions Tab -->
              <div id="settings_permissions"  class="useyourdrive-tab-panel">
                <div class="useyourdrive-tab-panel-header"><?php _e('User Permissions', 'useyourdrive'); ?></div>

                <div class="useyourdrive-accordion">

                  <div class="option forfilebrowser foruploadbox forupload forgallery foraudio forvideo forsearch useyourdrive-permissions-box">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can see the plugin', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['viewrole'])) ? explode('|', $_REQUEST['viewrole']) : array('administrator', 'author', 'contributor', 'editor', 'subscriber', 'pending', 'guest');
                      wp_roles_and_users_input('UseyourDrive_view_role', $selected);
                      ?>
                    </div>

                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can download', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['downloadrole'])) ? explode('|', $_REQUEST['downloadrole']) : array('all');
                      wp_roles_and_users_input('UseyourDrive_download_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery foruploadbox forupload upload-options">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can upload', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['uploadrole'])) ? explode('|', $_REQUEST['uploadrole']) : array('administrator', 'author', 'contributor', 'editor', 'subscriber');
                      wp_roles_and_users_input('UseyourDrive_upload_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch sharing-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can share content', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['sharerole'])) ? explode('|', $_REQUEST['sharerole']) : array('all');
                      wp_roles_and_users_input('UseyourDrive_share_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch edit-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can edit content', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['editrole'])) ? explode('|', $_REQUEST['editrole']) : array('administrator', 'author', 'editor');
                      wp_roles_and_users_input('UseyourDrive_edit_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch editdescription-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can edit descriptions', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['editdescriptionrole'])) ? explode('|', $_REQUEST['editdescriptionrole']) : array('administrator', 'editor');
                      wp_roles_and_users_input('UseyourDrive_editdescription_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch rename-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can rename files', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['renamefilesrole'])) ? explode('|', $_REQUEST['renamefilesrole']) : array('administrator', 'author', 'contributor', 'editor');
                      wp_roles_and_users_input('UseyourDrive_rename_files_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch rename-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can rename folders', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['renamefoldersrole'])) ? explode('|', $_REQUEST['renamefoldersrole']) : array('administrator', 'author', 'contributor', 'editor');
                      wp_roles_and_users_input('UseyourDrive_rename_folders_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch move-options">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can move files', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['movefilesrole'])) ? explode('|', $_REQUEST['movefilesrole']) : array('administrator', 'editor');
                      wp_roles_and_users_input('UseyourDrive_move_files_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch move-options">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can move folders', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['movefoldersrole'])) ? explode('|', $_REQUEST['movefoldersrole']) : array('administrator', 'editor');
                      wp_roles_and_users_input('UseyourDrive_move_folders_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch delete-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can delete files', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['deletefilesrole'])) ? explode('|', $_REQUEST['deletefilesrole']) : array('administrator', 'author', 'contributor', 'editor');
                      wp_roles_and_users_input('UseyourDrive_delete_files_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery forsearch delete-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can delete folders', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['deletefoldersrole'])) ? explode('|', $_REQUEST['deletefoldersrole']) : array('administrator', 'author', 'contributor', 'editor');
                      wp_roles_and_users_input('UseyourDrive_delete_folders_role', $selected);
                      ?>
                    </div>
                  </div>

                  <div class="option useyourdrive-permissions-box forfilebrowser forgallery addfolder-options ">
                    <div class="useyourdrive-accordion-title useyourdrive-option-title"><?php _e('Who can create new folders', 'useyourdrive'); ?></div>
                    <div>
                      <?php
                      $selected = (isset($_REQUEST['addfolderrole'])) ? explode('|', $_REQUEST['addfolderrole']) : array('administrator', 'author', 'contributor', 'editor');
                      wp_roles_and_users_input('UseyourDrive_addfolder_role', $selected);
                      ?>
                    </div>
                  </div>

                </div>
              </div>
              <!-- End Permissions Tab -->

            </div>
            <?php
        }
        ?>

        <div class="footer">

        </div>
      </div>
    </form>
    <script type="text/javascript">
        var whitelist = <?php echo json_encode(TheLion\UseyourDrive\Helpers::get_all_users_and_roles()); ?>; /* Build Whitelist for permission selection */
    </script>
  </body>
</html>