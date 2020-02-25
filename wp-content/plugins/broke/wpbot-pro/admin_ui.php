<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php 
global $wpdb;
$table    = $wpdb->prefix.'wpbot_subscription';
?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>
<div class="wp-chatbot-wrap">

    <form action="<?php echo esc_attr($action); ?>" method="POST" id="wp-chatbot-admin-form"
          enctype="multipart/form-data">
        <div class="container form-container">
            <header class="wp-chatbot-admin-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><?php echo esc_html__(wpbot_text().' Control Panel', 'wpchatbot'); ?><?php echo get_option('wp_chatbot_index_meta'); ?></h2>
                    </div>
                    <div class="col-sm-6 text-right wp-chatbot-version">
                        <h3><?php echo esc_html__('The Pro Version', 'wpchatbot'); ?></h3>
                        <?php qcld_wpbot_load_additional_validation_required(); ?>
                    </div>
                </div>
            </header>
            <section class="wp-chatbot-tab-container-inner">
                <div class="wp-chatbot-tabs wp-chatbot-tabs-style-flip">
                    <nav>
                        <ul>
                            <li tab-data="general"><a href="<?php echo esc_attr($action); ?>&tab=general">
                                    <span class="wpwbot-admin-tab-icon">
                                        <i class="fa fa-toggle-on"> </i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('GENERAL SETTINGS', 'wpchatbot'); ?></span>
                                </a></li>
                            <li tab-data="themes"><a href="<?php echo esc_attr($action); ?>&tab=themes">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-gear faa-spin"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('ICONS & THEMES', 'wpchatbot'); ?></span>
                                </a></li>

                            <li tab-data="app"><a href="<?php echo esc_attr($action); ?>&tab=app" title="MOBILE APP & IFRAME INTEGRATION">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-mobile"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Embed Code', 'wpchatbot'); ?></span>
                                </a></li>

                             <li tab-data="startmenu"><a href="<?php echo esc_attr($action); ?>&tab=startmenu">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-bars"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Start Menu', 'wpchatbot'); ?></span>
                                </a></li>

                                <li tab-data="target"><a href="<?php echo esc_attr($action); ?>&tab=target">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-retweet"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Retargeting ', 'wpchatbot'); ?></span>
                                </a></li>

                                <li tab-data="hours"><a href="<?php echo esc_attr($action); ?>&tab=hours">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Bot Activity Hour', 'wpchatbot'); ?></span>
                                </a></li>

                                

                                <li tab-data="social"><a href="<?php echo esc_attr($action); ?>&tab=social">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-share"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Button Integrations', 'wpchatbot'); ?></span>
                            </a></li>

                            <li tab-data="ai"><a href="<?php echo esc_attr($action); ?>&tab=ai">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-500px"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Dialogflow', 'wpchatbot'); ?></span>
                                </a></li>

                            <li tab-data="formbuilder"><a href="<?php echo esc_attr($action); ?>&tab=formbuilder">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Conversations & Form Maker', 'wpchatbot'); ?></span>
                                </a></li>


                            <li tab-data="support"><a href="<?php echo esc_attr($action); ?>&tab=support">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-life-ring"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"> <?php echo esc_html__('FAQ Builder', 'wpchatbot'); ?></span>
                                </a></li>
                            


                            <li tab-data="notification"><a href="<?php echo esc_attr($action); ?>&tab=notification">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-bell-o"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Notification Builder', 'wpchatbot'); ?></span>
                                </a></li>
                            <li tab-data="language"><a href="<?php echo esc_attr($action); ?>&tab=language">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-language"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('LANGUAGE CENTER', 'wpchatbot'); ?></span>
                                </a></li>
                            
                               
                            <li tab-data="custom"><a href="<?php echo esc_attr($action); ?>&tab=custom">
                                    <span class="wpwbot-admin-tab-icon">
                                    <i class="fa fa-code"></i>
                                    </span>
                                    <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Custom CSS', 'wpchatbot'); ?> </span>
                                </a></li>
                            <?php if(!qcld_wpbot_is_active_white_label()): ?>
                            <li tab-data="addons"><a href="<?php echo esc_attr($action); ?>&tab=addons">
                                <span class="wpwbot-admin-tab-icon">
                                <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                </span>
                                <span class="wpwbot-admin-tab-name"><?php echo esc_html__('Addons', 'wpchatbot'); ?> </span>
                            </a></li>
                            <?php endif; ?>
                                
                                
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-flip-1">
                            <div class="top-section">
                                <!--                                row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php
                                                $url = get_site_url();
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $admin_email = get_option('admin_email');
                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Emails Will be Sent to', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_admin_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email); ?>">
                                                <label for="disable_wp_chatbot"><?php echo esc_html__('Support and Call Back requests will be sent to this address', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
										<div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                
                                                <h4 class="qc-opt-title"><?php echo esc_html__('From Name', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_from_name"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_from_name') != '' ? get_option('qlcd_wp_chatbot_from_name') : 'Wordpress'); ?>">
                                                <label for="qlcd_wp_chatbot_from_name"><?php echo esc_html__('From name for email address', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php

                                                $url = get_site_url();  
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $fromEmail = "wordpress@" . $domain;

                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('From Email Address', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_from_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_from_email') != '' ? get_option('qlcd_wp_chatbot_from_email') : $fromEmail); ?>">
                                                <label for="qlcd_wp_chatbot_from_email"><?php echo esc_html__('All email will be send from this email address. If you change the From Email Address then please make sure the domain remain same otherwise the email would not send.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
										

                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <?php

                                                $url = get_site_url();
                                                $url = parse_url($url);
                                                $domain = $url['host'];
                                                
                                                $fromEmail = "wordpress@" . $domain;

                                                ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Reply To', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_reply_to_email"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_reply_to_email') != '' ? get_option('qlcd_wp_chatbot_reply_to_email') : ''); ?>">
                                                <label for="qlcd_wp_chatbot_reply_to_email"><?php echo esc_html__('Please set the Reply To address. By default Reply To address will by From Email Address.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                               

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot" type="checkbox"
                                                   name="disable_wp_chatbot" <?php echo(get_option('disable_wp_chatbot') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot"><?php echo esc_html__('Disable Bot to Load', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot Floating Icon', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_floating_icon" type="checkbox"
                                                   name="disable_wp_chatbot_floating_icon" <?php echo(get_option('disable_wp_chatbot_floating_icon') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_floating_icon"><?php echo esc_html__('Disable Bot Floating Icon on All Page', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Skip Greetings and Trigger an Intent', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="skip_wp_greetings_trigger_intent" type="checkbox"
                                                   name="skip_wp_greetings_trigger_intent" <?php echo(get_option('skip_wp_greetings_trigger_intent') == 1 ? 'checked' : ''); ?>>
                                            <label for="skip_wp_greetings_trigger_intent"><?php echo esc_html__('Skip Greetings and Trigger an Intent', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="qc_wp_intent_select" <?php echo(get_option('skip_wp_greetings_trigger_intent') == 1 ? 'style="display:block"' : 'style="display:none"') ?>>
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Select an Intent', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                        
                                            <select name="wpbot_trigger_intent">
                                                <?php 
                                                    $intents = qc_get_all_intents();

                                                    

                                                    foreach($intents as $key=>$values){
                                                    ?>
                                                    <optgroup label="<?php echo ucfirst($key); ?>">
                                                        <?php 
                                                            foreach($values as $value){
                                                            ?>
                                                                <option value="<?php echo trim($value); ?>" <?php echo (get_option('wpbot_trigger_intent')==trim($value)?'selected="selected"':''); ?>><?php echo trim($value); ?></option>
                                                            <?php
                                                            }
                                                        ?>
                                                    </optgroup>
                                                    <?php
                                                    }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>

								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Skip Greetings and Show Start Menu', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="skip_wp_greetings" type="checkbox"
                                                   name="skip_wp_greetings" <?php echo(get_option('skip_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="skip_wp_greetings"><?php echo esc_html__('Skip Greetings and Show Start Menu', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Show Start Menu After Greetings', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="show_menu_after_greetings" type="checkbox"
                                                   name="show_menu_after_greetings" <?php echo(get_option('show_menu_after_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="show_menu_after_greetings"><?php echo esc_html__('Show Start Menu After Greetings', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable First Message', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_first_msg" type="checkbox"
                                                   name="disable_first_msg" <?php echo(get_option('disable_first_msg') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_first_msg"><?php echo esc_html__('Disable First Message', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                

								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Asking for Email', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="ask_email_wp_greetings" type="checkbox"
                                                   name="ask_email_wp_greetings" <?php echo(get_option('ask_email_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="ask_email_wp_greetings"><?php echo esc_html__('Enable Asking for Email', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Email Subscription Offer', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="qc_email_subscription_offer" type="checkbox"
                                                   name="qc_email_subscription_offer" <?php echo(get_option('qc_email_subscription_offer') == 1 ? 'checked' : ''); ?>>
                                            <label for="qc_email_subscription_offer" style="width: 500px !important;"><?php echo esc_html__('If you enable this option, WPBot will send a eMail to the subscriber. Please edit the content of this eMail from the Language Center->Email Subscription tab . By including a coupon, eBook or other offer you can get more valid subscriptions this way.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Asking for Phone Number', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="ask_phone_wp_greetings" type="checkbox"
                                                   name="ask_phone_wp_greetings" <?php echo(get_option('ask_phone_wp_greetings') == 1 ? 'checked' : ''); ?>>
                                            <label for="ask_phone_wp_greetings"><?php echo esc_html__('Enable Asking for Phone', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                            </div>

                            <?php if ( is_plugin_active( 'qc-crm/qc-crm.php' ) ) { ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Create ChatBot CRM Contact from Support Email', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_support_mail_to_crm_contact" type="checkbox"
                                                   name="wpbot_support_mail_to_crm_contact" <?php echo(get_option('wpbot_support_mail_to_crm_contact') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_support_mail_to_crm_contact"><?php echo esc_html__('Create ChatBot CRM Contact from Support Email', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Bot on Mobile Device', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_on_mobile" type="checkbox"
                                                   name="disable_wp_chatbot_on_mobile" <?php echo(get_option('disable_wp_chatbot_on_mobile') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_on_mobile"><?php echo esc_html__('Disable Bot to Load on Mobile Device', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Auto Focus in Message Area', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_auto_focus_message_area" type="checkbox"
                                                   name="disable_auto_focus_message_area" <?php echo(get_option('disable_auto_focus_message_area') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_auto_focus_message_area"><?php echo esc_html__('Disable Auto Focus in Message Area', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Sound on Page Load', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_sound_initial" type="checkbox"
                                                   name="enable_wp_chatbot_sound_initial" <?php echo(get_option('enable_wp_chatbot_sound_initial') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_sound_initial"><?php echo esc_html__('Enable to play sound on initial page load (some browsers may prevent this sound for non user interaction)', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Auto Open Chatbot Window For First Time Page Load', 'wpchatbot'); ?> </h4>
                                        <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_open_initial" type="checkbox"
                                                   name="enable_wp_chatbot_open_initial" <?php echo(get_option('enable_wp_chatbot_open_initial') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_open_initial"><?php echo esc_html__('Enable to open chatbot window automatically for first time page load.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Icon Animation', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_icon_animation" type="checkbox"
                                                   name="disable_wp_chatbot_icon_animation" <?php echo(get_option('disable_wp_chatbot_icon_animation') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_icon_animation"><?php echo esc_html__('Disable icon border animation', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Disable Persistent Chat History', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_history" type="checkbox"
                                                   name="disable_wp_chatbot_history" <?php echo(get_option('disable_wp_chatbot_history') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_history"><?php echo esc_html__('Disable Persistent Chat History', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Notification', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="disable_wp_chatbot_notification" type="checkbox"
                                                   name="disable_wp_chatbot_notification" <?php echo(get_option('disable_wp_chatbot_notification') == 1 ? 'checked' : ''); ?>>
                                            <label for="disable_wp_chatbot_notification"><?php echo esc_html__('Disable Opening notification messages', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable RTL', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_rtl" type="checkbox"
                                                   name="enable_wp_chatbot_rtl" <?php echo(get_option('enable_wp_chatbot_rtl') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_rtl"><?php echo esc_html__('Enable RTL (Right to Left language) Support for Chat', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Open Full Screen in Mobile', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_mobile_full_screen" type="checkbox"
                                                   name="enable_wp_chatbot_mobile_full_screen" <?php echo(get_option('enable_wp_chatbot_mobile_full_screen') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_mobile_full_screen"><?php echo esc_html__('Enable Open Full Screen in Mobile', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Number Of Search Result to Show', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="<?php echo(get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5); ?>" id="wpbot_search_result_number" type="text" name="wpbot_search_result_number" />
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Search Result Click to Open in New Window', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_search_result_new_window" type="checkbox"
                                                   name="wpbot_search_result_new_window" <?php echo(get_option('wpbot_search_result_new_window') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_search_result_new_window"><?php echo esc_html__('Enable to open search result in new window', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Search Result Image Size', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                           
                                        

                                            <select name="wpbot_search_image_size">
                                                <option value="thumbnail" <?php echo(get_option('wpbot_search_image_size') == 'thumbnail' ? 'selected="selected"' : ''); ?>>Thumbnail</option>
                                                <option value="medium" <?php echo(get_option('wpbot_search_image_size') == 'medium' ? 'selected="selected"' : ''); ?>>Medium resolution</option>
                                                <option value="large" <?php echo(get_option('wpbot_search_image_size') == 'large' ? 'selected="selected"' : ''); ?>>Large resolution</option>
                                                <option value="full" <?php echo(get_option('wpbot_search_image_size') == 'full' ? 'selected="selected"' : ''); ?>>Full resolution</option>
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable GDPR Compliance', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_gdpr_compliance" type="checkbox"
                                                   name="enable_wp_chatbot_gdpr_compliance" <?php echo(get_option('enable_wp_chatbot_gdpr_compliance') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_gdpr_compliance"><?php echo esc_html__('Click to Enable GDPR Compliance', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('GDPR Compliance Text', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input style="width: 100%;" value='<?php echo(get_option('wpbot_gdpr_text')!=''?get_option('wpbot_gdpr_text'):'We will never spam you! You can read our <a href="#" target="_blank">Privacy Policy here.</a>'); ?>' id="wpbot_gdpr_text" type="text" name="wpbot_gdpr_text" />
                                            
                                        </div>
                                    </div>
                                </div>

                                


								
								<div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Show Start Menu after (x) Times Attempt No Result', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input id="no_result_attempt_count" type="text"
                                                   name="no_result_attempt_count" value="<?php echo(get_option('no_result_attempt_count') > 0 ? get_option('no_result_attempt_count') : 3); ?>" >
                                            <label for="no_result_attempt_count"><?php echo esc_html__('Times', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Disable Repetitive  asking for – “You may choose an option from below.”', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="wpbot_disable_repeatative" type="checkbox"
                                                   name="wpbot_disable_repeatative" <?php echo(get_option('wpbot_disable_repeatative') == 1 ? 'checked' : ''); ?>>
                                            <label for="wpbot_disable_repeatative"><?php echo esc_html__('Enable to disable repetitive asking for – “You may choose an option from below.”', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>

                                
                                
								
                                <!-- row-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Override Icon\'s Position', 'wpchatbot'); ?>  </h4>
                                        <div class="cxsc-settings-blocks">
                                            <?php
                                            $qcld_wb_chatbot_position_x = get_option('wp_chatbot_position_x');
                                            if ((!isset($qcld_wb_chatbot_position_x)) || ($qcld_wb_chatbot_position_x == "")) {
                                                $qcld_wb_chatbot_position_x = esc_html__("120", "wp_chatbot");
                                            }
                                            $qcld_wb_chatbot_position_y = get_option('wp_chatbot_position_y');
                                            if ((!isset($qcld_wb_chatbot_position_y)) || ($qcld_wb_chatbot_position_y == "")) {
                                                $qcld_wb_chatbot_position_y = esc_html__("120", "wp_chatbot");
                                            } ?>
                                            <input type="number" class="qc-opt-dcs-font"
                                                   name="wp_chatbot_position_x"
                                                   id=""
                                                   value="<?php echo esc_html($qcld_wb_chatbot_position_x); ?>"
                                                   placeholder="<?php echo esc_html__('From Right', 'wpchatbot'); ?>"> <span class="qc-opt-dcs-font"><?php echo esc_html__('From Right', 'wpchatbot'); ?></span>
                                            <input type="number" class="qc-opt-dcs-font"
                                                   name="wp_chatbot_position_y"
                                                   id=""
                                                   value="<?php echo esc_html($qcld_wb_chatbot_position_y); ?>"
                                                   placeholder="<?php echo esc_html__('From Bottom', 'wpchatbot'); ?>"> <span class="qc-opt-dcs-font"><?php echo esc_html__('From Bottom ', 'wpchatbot'); ?></span>
                                                   <span class="qc-opt-dcs-font"><?php echo esc_html__(' In ', 'wpchatbot'); ?></span>
                                            <select name="wp_chatbot_position_in">
                                                <option value="px" <?php echo (get_option('wp_chatbot_position_in')=='px'?'selected="selected"':''); ?>>Px</option>
                                                <option value="%" <?php echo (get_option('wp_chatbot_position_in')=='%'?'selected="selected"':''); ?>>Percent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--.col-sm-12-->
                                </div>
                                <!--                                row-->
								
                                
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Loading Control Options', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <div class="row">
                                                <div class="col-sm-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on Home Page', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="radio-inline">
                                                        <input id="wp-chatbot-show-home-page" type="radio"
                                                               name="wp_chatbot_show_home_page"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_home_page') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('YES', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input id="wp-chatbot-show-home-page" type="radio"
                                                               name="wp_chatbot_show_home_page"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_home_page') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('NO', 'wpchatbot'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--  row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on blog posts', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-sm-8">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-posts" type="radio"
                                                               name="wp_chatbot_show_posts"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_posts') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('YES', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-posts" type="radio"
                                                               name="wp_chatbot_show_posts"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_posts') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('NO', 'wpchatbot'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- row-->
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                    <span class="qc-opt-title-font"><?php echo esc_html__('Show on  pages', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-pages" type="radio"
                                                               name="wp_chatbot_show_pages"
                                                               value="on" <?php echo(get_option('wp_chatbot_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('All Pages', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-show-pages" type="radio"
                                                               name="wp_chatbot_show_pages"
                                                               value="off" <?php echo(get_option('wp_chatbot_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                        <?php echo esc_html__('Selected Pages Only ', 'wpchatbot'); ?></label>
                                                    <div id="wp-chatbot-show-pages-list">
                                                        <ul class="checkbox-list">
                                                            <?php
                                                            $wp_chatbot_pages = get_pages();
                                                            $wp_chatbot_select_pages = unserialize(get_option('wp_chatbot_show_pages_list'));
                                                            foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                                ?>
                                                                <li>
                                                                    <input
                                                                            id="wp_chatbot_show_page_<?php echo esc_html($wp_chatbot_page->ID); ?>"
                                                                            type="checkbox"
                                                                            name="wp_chatbot_show_pages_list[]"
                                                                            value="<?php echo esc_html($wp_chatbot_page->ID); ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                        echo 'checked';
                                                                    } ?> >
                                                                    <label
                                                                            for="wp_chatbot_show_page_<?php echo esc_html($wp_chatbot_page->ID); ?>"> <?php echo esc_html($wp_chatbot_page->post_title); ?></label>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                            <!--row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right"> <span class="qc-opt-title-font">
                                                <?php _e('Exclude from Pages', 'wpchatbot'); ?>
                                                </span></div>
                                                <div class="col-sm-8">
                                                <div id="wp-chatbot-exclude-pages-list">
                                                    <ul class="checkbox-list">
                                                    <?php
                                                        $wp_chatbot_pages = get_pages();
                                                        $wp_chatbot_select_pages = unserialize(get_option('wp_chatbot_exclude_pages_list'));
                                                        foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                            ?>
                                                    <li>
                                                        <input
                                                                    id="wp_chatbot_exclude_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_exclude_pages_list[]"
                                                                    value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                        <label
                                                            for="wp_chatbot_exclude_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                    </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- row--> 
                                            
                                            <!--row-->
                                            <div class="row">
                                                <div class="col-sm-4 text-right"> <span class="qc-opt-title-font">
                                                <?php _e('Exclude from Custom Post', 'wpchatbot'); ?>
                                                </span></div>
                                                <div class="col-sm-8">
                                                <div id="wp-chatbot-exclude-post-list">
                                                    <ul class="checkbox-list">
                                                    <?php
                                                            $get_cpt_args = array(
                                                                'public'   => true,
                                                                '_builtin' => false
                                                            );
                                                            
                                                            $post_types = get_post_types( $get_cpt_args, 'object' );
                                                            $wp_chatbot_exclude_post_list = unserialize(get_option('wp_chatbot_exclude_post_list'));
                                                            foreach ($post_types as $post_type) {
                                                                ?>
                                                    <li>
                                                        <input
                                                                    id="wp_chatbot_exclude_post_<?php echo $post_type->name; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_exclude_post_list[]"
                                                                    value="<?php echo $post_type->name; ?>" <?php if (!empty($wp_chatbot_exclude_post_list) && in_array($post_type->name, $wp_chatbot_exclude_post_list) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                        <label
                                                            for="wp_chatbot_exclude_post_<?php echo $post_type->name; ?>"> <?php echo $post_type->name; ?></label>
                                                    </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- row--> 

                                           
                                        </div>
                                        <!-- cxsc-settings-blocks-->
                                    </div>
                                    <!-- col-xs-12-->
                                </div>
                                <!--  row-->


								
                            </div>
                            <!-- top-section-->

                            


                        </section>
                        <section id="section-flip-2">


                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-icon-theme-settings"><?php echo esc_html__('Icons & Themes', 'wpchatbot'); ?></a></li>

								
                                <li><a data-toggle="tab" href="#wp-chatbot-custom-color-options"><?php echo esc_html__('Custom Color Options', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-bottom-icons-setting"><?php echo esc_html__('Bottom Icon Settings', 'wpchatbot'); ?></a></li>

                                
                            </ul>
                            <div class="tab-content">
                                
                                <div id="wp-chatbot-icon-theme-settings" class="tab-pane fade in active">

                                    <div class="top-section">
                                        <div class="row">
                                        <div class="col-xs-12">
                                                <?php qc_wpbot_theme_validation_fnc(); ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Bot on a Page', 'wpchatbot'); ?></h4>
                                                
                                                <div class="cxsc-settings-blocks">
                                                    <p class="qc-opt-title-font"><?php echo esc_html__('Paste the shortcode', 'wpchatbot'); ?>
                                                        <input disabled id="shirtcode-selector" type="text" value="[wpbot-page]"> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Icons', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <ul class="radio-list">
                                                        <li><label for="wp_chatbot_icon_0" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-0.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_0" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-0.png' ? 'checked' : ''); ?>
                                                                                value="icon-0.png">
                                                            <?php echo esc_html__('Icon - 0', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_1" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-1.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_1" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-1.png' ? 'checked' : ''); ?>
                                                                                value="icon-1.png">
                                                            <?php echo esc_html__('Icon - 1', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_2" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-2.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_2" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-2.png' ? 'checked' : ''); ?>
                                                                                value="icon-2.png">
                                                            <?php echo esc_html__('Icon - 2', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_3" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-3.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_3" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-3.png' ? 'checked' : ''); ?>
                                                                                value="icon-3.png">
                                                            <?php echo esc_html__('Icon - 3', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_4" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-4.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_4" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-4.png' ? 'checked' : ''); ?>
                                                                                value="icon-4.png">
                                                            <?php echo esc_html__('Icon - 4', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_5" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-5.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_5" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-5.png' ? 'checked' : ''); ?>
                                                                                value="icon-5.png">
                                                            <?php echo esc_html__('Icon - 5', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_6" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-6.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_6" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-6.png' ? 'checked' : ''); ?>
                                                                                value="icon-6.png">
                                                            <?php echo esc_html__('Icon - 6', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_7" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-7.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_7" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-7.png' ? 'checked' : ''); ?>
                                                                                value="icon-7.png">
                                                            <?php echo esc_html__('Icon - 7', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_8" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-8.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_8" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-8.png' ? 'checked' : ''); ?>
                                                                                value="icon-8.png">
                                                            <?php echo esc_html__('Icon - 8', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_9" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-9.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_9" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-9.png' ? 'checked' : ''); ?>
                                                                                value="icon-9.png">
                                                            <?php echo esc_html__('Icon - 9', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_10" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-10.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_10" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-10.png' ? 'checked' : ''); ?>
                                                                                value="icon-10.png">
                                                            <?php echo esc_html__('Icon - 10', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_11" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-11.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_11" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-11.png' ? 'checked' : ''); ?>
                                                                                value="icon-11.png">
                                                            <?php echo esc_html__('Icon - 11', 'wpchatbot'); ?></label>
                                                        </li>
                                                        <li><label for="wp_chatbot_icon_12" class="qc-opt-dcs-font"><img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-12.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_icon_12" type="radio"
                                                                                name="wp_chatbot_icon" <?php echo(get_option('wp_chatbot_icon') == 'icon-12.png' ? 'checked' : ''); ?>
                                                                                value="icon-12.png">
                                                            <?php echo esc_html__('Icon - 12', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                        <li>
                                                            <?php
                                                            if (get_option('wp_chatbot_custom_icon_path') != "") {
                                                                $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                                                            } else {
                                                                $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                                                            }
                                                            ?>
                                                            <label for="wp_chatbot_custom_icon_input" class="qc-opt-dcs-font">
                                                            <img id="wp_chatbot_custom_icon_src"
                                                                src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>" alt="">
                                                            <input id="wp_chatbot_custom_icon_input" type="radio"
                                                                name="wp_chatbot_icon"
                                                                value="custom.png" <?php echo(get_option('wp_chatbot_icon') == 'custom.png' ? 'checked' : ''); ?>>
                                                            <?php echo esc_html__('Custom Icon', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <!--  cxsc-settings-blocks-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload custom Icon ', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_chatbot_custom_icon_path"
                                                        id="wp_chatbot_custom_icon_path"
                                                        value="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"/>
                                                    <button type="button" class="wp_chatbot_custom_icon_button button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Agent Image', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <ul class="radio-list">
                                                        <li>
                                                            <label for="wp_chatbot_agent_image_def" class="qc-opt-dcs-font">
                                                            <img src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'icon-0.png'); ?>"
                                                                alt=""> <input id="wp_chatbot_agent_image_def" type="radio"
                                                                                name="wp_chatbot_agent_image" <?php echo(get_option('wp_chatbot_agent_image') == 'agent-0.png' ? 'checked' : ''); ?>
                                                                                value="agent-0.png">
                                                                            
                                                            <?php echo esc_html__('Default Agent', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                        <li>
                                                            <?php
                                                            if (get_option('wp_chatbot_custom_agent_path') != "") {
                                                                $wp_chatbot_custom_agent_path = get_option('wp_chatbot_custom_agent_path');
                                                            } else {
                                                                $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                                                            }
                                                            ?>
                                                            <label for="wp_chatbot_agent_image_custom" class="qc-opt-dcs-font">
                                                                <img id="wp_chatbot_custom_agent_src"
                                                                src="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>"
                                                                alt="Agent">
                                                            <input type="radio" name="wp_chatbot_agent_image"
                                                                id="wp_chatbot_agent_image_custom"
                                                                value="custom-agent.png" <?php echo(get_option('wp_chatbot_agent_image') == 'custom-agent.png' ? 'checked' : ''); ?>>
                                                            <?php echo esc_html__('Custom Agent', 'wpchatbot'); ?></label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <!--                                        cxsc-settings-blocks-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Custom Agent Icon', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_chatbot_custom_agent_path"
                                                        id="wp_chatbot_custom_agent_path"
                                                        value="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>"/>
                                                    <button type="button" class="wp_chatbot_custom_agent_button button"><?php echo esc_html__('Upload Agent Icon', 'wpchatbot'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Client Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 60x60</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_client_icon"
                                                        id="wp_custom_client_icon"
                                                        value="<?php echo (get_option('wp_custom_client_icon') != '' ? get_option('wp_custom_client_icon') : ''); ?>" />
                                                    <div id="wp_custom_client_icon_src">
                                                        <?php if(get_option('wp_custom_client_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_client_icon'); ?>" alt="" width="60" height="60" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_client_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_client_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_client_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Help Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 24x24</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_help_icon"
                                                        id="wp_custom_help_icon"
                                                        value="<?php echo (get_option('wp_custom_help_icon') != '' ? get_option('wp_custom_help_icon') : ''); ?>" />
                                                    <div id="wp_custom_help_icon_src">
                                                        <?php if(get_option('wp_custom_help_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_help_icon'); ?>" alt="" width="24" height="24" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_help_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_help_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_help_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Support Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 24x24</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_support_icon"
                                                        id="wp_custom_support_icon"
                                                        value="<?php echo (get_option('wp_custom_support_icon') != '' ? get_option('wp_custom_support_icon') : ''); ?>" />
                                                    <div id="wp_custom_support_icon_src">
                                                        <?php if(get_option('wp_custom_support_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_support_icon'); ?>" alt="" width="24" height="24" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_support_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_support_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_support_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Chat Icon ', 'wpchatbot'); ?></h4>
                                                <p>Icon size: 35x35</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_chat_icon"
                                                        id="wp_custom_chat_icon"
                                                        value="<?php echo (get_option('wp_custom_chat_icon') != '' ? get_option('wp_custom_chat_icon') : ''); ?>" />
                                                    <div id="wp_custom_chat_icon_src">
                                                        <?php if(get_option('wp_custom_chat_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_chat_icon'); ?>" alt="" width="35" height="35" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_chat_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_chat_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_chat_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="qc-opt-title"><?php echo esc_html__(' Upload Custom Bot Typing Animation Icon', 'wpchatbot'); ?></h4>
                                                
                                                <div class="cxsc-settings-blocks">
                                                    <input type="hidden" name="wp_custom_typing_icon"
                                                        id="wp_custom_typing_icon"
                                                        value="<?php echo (get_option('wp_custom_typing_icon') != '' ? get_option('wp_custom_typing_icon') : ''); ?>" />
                                                    <div id="wp_custom_typing_icon_src">
                                                        <?php if(get_option('wp_custom_typing_icon')!=''): ?>
                                                        <img src="<?php echo get_option('wp_custom_typing_icon'); ?>" alt=""  />
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="wp_custom_typing_icon button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                                                    <?php if(get_option('wp_custom_typing_icon')!=''): ?>
                                                    <button type="button" class="wp_custom_typing_icon_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div id="top-section">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Themes', 'wpchatbot'); ?></h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_0">
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-00.JPG'); ?>"
                                                    alt="Theme Basic">
                                                <input id="qcld_wb_chatbot_theme_0" type="radio"
                                                    name="qcld_wb_chatbot_theme" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-00' ? 'checked' : ''); ?>
                                                    value="template-00">
                                                <?php echo esc_html__('Theme Basic', 'wpchatbot'); ?></label>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_1" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-01.JPG'); ?>"
                                                    alt="Theme one"> <input id="qcld_wb_chatbot_theme_1" type="radio"
                                                                            name="qcld_wb_chatbot_theme" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-01' ? 'checked' : ''); ?>
                                                                            value="template-01">
                                                <?php echo esc_html__('Theme One', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_2" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-02.JPG'); ?>"
                                                    alt="Theme Two">
                                                <input id="qcld_wb_chatbot_theme_2" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-02" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-02' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Two', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_3" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-03.JPG'); ?>"
                                                    alt="Theme Three">
                                                <input id="qcld_wb_chatbot_theme_3" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-03" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-03' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Three', 'wpchatbot'); ?></label>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="row">
                                        
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_4" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-04.jpg'); ?>"
                                                    alt="Theme Four">
                                                <input id="qcld_wb_chatbot_theme_4" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-04" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-04' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Theme Four', 'wpchatbot'); ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="qcld_wb_chatbot_theme_5" >
                                                <img class="thumbnail theme_prev"
                                                    src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'templates/template-05.jpg'); ?>"
                                                    alt="Theme Five">
                                                <input id="qcld_wb_chatbot_theme_5" type="radio" name="qcld_wb_chatbot_theme"
                                                    value="template-05" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-05' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Mini Mode', 'wpchatbot'); ?></label>
                                            </div>

                                            <?php if(qcld_wpbot_is_extended_ui_activate()): ?>
                                                <div class="col-sm-3">
                                                    <label for="qcld_wb_chatbot_theme_6" >
                                                    <img class="thumbnail theme_prev"
                                                        src="<?php echo esc_url(qcld_chatbot_eui_root_url.'images/templates/template-6.png'); ?>"
                                                        alt="Theme Six">
                                                    <input id="qcld_wb_chatbot_theme_6" type="radio" name="qcld_wb_chatbot_theme"
                                                        value="template-06" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-06' ? 'checked' : ''); ?>>
                                                    <?php echo esc_html__('Theme Six', 'wpchatbot'); ?></label>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="qcld_wb_chatbot_theme_7" >
                                                    <img class="thumbnail theme_prev"
                                                        src="<?php echo esc_url(qcld_chatbot_eui_root_url.'images/templates/template-7.jpg'); ?>"
                                                        alt="Theme Seven">
                                                    <input id="qcld_wb_chatbot_theme_7" type="radio" name="qcld_wb_chatbot_theme"
                                                        value="template-07" <?php echo(get_option('qcld_wb_chatbot_theme') == 'template-07' ? 'checked' : ''); ?>>
                                                    <?php echo esc_html__('Theme Seven', 'wpchatbot'); ?></label>
                                                </div>
                                            <?php endif; ?>
                                            

                                            
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="top-section">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="qc-opt-title"> <?php echo esc_html__('Custom Backgroud', 'wpchatbot'); ?></h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="qcld_wb_chatbot_change_bg" type="checkbox"
                                                        name="qcld_wb_chatbot_change_bg" <?php echo(get_option('qcld_wb_chatbot_change_bg') == 1 ? 'checked' : ''); ?>>
                                                    <label for="qcld_wb_chatbot_change_bg"><?php echo esc_html__('Change the Bot message board background for Theme 2 and Theme 3.', 'wpchatbot'); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row qcld-wp-chatbot-board-bg-container" <?php if (get_option('qcld_wb_chatbot_change_bg') != 1) {
                                            echo 'style="display:none"';
                                        } ?>>
                                            <div class="col-xs-6">
                                                <p class="wp-chatbot-settings-instruction"> <?php echo esc_html__('Upload Bot message board background (Ideal image size 376px X 688px).', 'wpchatbot'); ?> </p>
                                                <div class="cxsc-settings-blocks">
                                                    <?php
                                                    if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
                                                        $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
                                                    } else {
                                                        $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
                                                    }
                                                    ?>
                                                    <input type="hidden" name="qcld_wb_chatbot_board_bg_path"
                                                        id="qcld_wb_chatbot_board_bg_path"
                                                        value="<?php echo esc_html($qcld_wb_chatbot_board_bg_path); ?>"/>
                                                    <button type="button" class="qcld_wb_chatbot_board_bg_button button"><?php echo esc_html__('Upload background.', 'wpchatbot'); ?></button>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-6">
                                                <p class="wp-chatbot-settings-instruction"> <?php echo esc_html__('Custom message board background', 'wpchatbot'); ?> </p>
                                                <img id="qcld_wb_chatbot_board_bg_image"
                                                    src="<?php echo esc_url($qcld_wb_chatbot_board_bg_path); ?>"
                                                    alt="Custom Background">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- Custom Color OPtions-->
                                <div id="wp-chatbot-custom-color-options" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                <h3 class="qc-opt-title">
                                                <?php _e('Custom Color Options', 'woochatbot'); ?>
                                                </h3>
                                                <div class="cxsc-settings-blocks">
                                                <input value="1" id="enable_wp_chatbot_custom_color" type="checkbox"
                                                                                name="enable_wp_chatbot_custom_color" <?php echo(get_option('enable_wp_chatbot_custom_color') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_custom_color">
                                                    <?php _e('Enable Custom Colors ', 'woochatbot'); ?>
                                                </label>
                                                </div>
                                                <br>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_text_color" type="hidden"
                                                                                    name="wp_chatbot_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_text_color') != '' ? get_option('wp_chatbot_text_color') : '#37424c'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Link Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_link_color" type="hidden"
                                                                                    name="wp_chatbot_link_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_link_color') != '' ? get_option('wp_chatbot_link_color') : '#e2cc1f'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Link Hover Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_link_hover_color" type="hidden"
                                                                                    name="wp_chatbot_link_hover_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_link_hover_color') != '' ? get_option('wp_chatbot_link_hover_color') : '#734006'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Bot Message  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_bot_msg_bg_color" type="hidden"
                                                                                    name="wp_chatbot_bot_msg_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_bot_msg_bg_color') != '' ? get_option('wp_chatbot_bot_msg_bg_color') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Bot Message Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_bot_msg_text_color" type="hidden"
                                                                                    name="wp_chatbot_bot_msg_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_bot_msg_text_color') != '' ? get_option('wp_chatbot_bot_msg_text_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('User Message  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_user_msg_bg_color" type="hidden"
                                                                                    name="wp_chatbot_user_msg_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_user_msg_bg_color') != '' ? get_option('wp_chatbot_user_msg_bg_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('User Message Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_user_msg_text_color" type="hidden"
                                                                                    name="wp_chatbot_user_msg_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_user_msg_text_color') != '' ? get_option('wp_chatbot_user_msg_text_color') : '#000000'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_bg_color" type="hidden"
                                                                                    name="wp_chatbot_buttons_bg_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_bg_color') != '' ? get_option('wp_chatbot_buttons_bg_color') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons  Background Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_bg_color" type="hidden"
                                                                                    name="wp_chatbot_buttons_bg_color_hover"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_bg_color_hover') != '' ? get_option('wp_chatbot_buttons_bg_color_hover') : '#1f8ceb'); ?>"/>
                                                </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons Text Color.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_text_color" type="hidden"
                                                                                    name="wp_chatbot_buttons_text_color"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_text_color') != '' ? get_option('wp_chatbot_buttons_text_color') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Buttons Text Color Hover.', 'woochatbot'); ?>
                                                    </h4>
                                                    <input id="wp_chatbot_buttons_text_color" type="hidden"
                                                                                    name="wp_chatbot_buttons_text_color_hover"
                                                                                    value="<?php echo(get_option('wp_chatbot_buttons_text_color_hover') != '' ? get_option('wp_chatbot_buttons_text_color_hover') : '#ffffff'); ?>"/>
                                                </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="wp-chatbot-bottom-icons-setting" class="tab-pane fade">
                                    <div class="top-section">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3 class="qc-opt-title">
                                            <?php _e('Bottom Icon Settings', 'woochatbot'); ?>
                                            </h3>
                                            
                                            <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable All Icons', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_allicon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_allicon" <?php echo(get_option('enable_wp_chatbot_disable_allicon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_allicon">
                                                        <?php _e('Enable to hide all icons from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Help Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_helpicon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_helpicon" <?php echo(get_option('enable_wp_chatbot_disable_helpicon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_helpicon">
                                                        <?php _e('Enable to hide help icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                <div class="row" >
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Support Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_supporticon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_supporticon" <?php echo(get_option('enable_wp_chatbot_disable_supporticon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_supporticon">
                                                        <?php _e('Enable to hide support icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="row">
                                                <div class="col-xs-12">
                                                    <h4 class="qc-opt-title">
                                                    <?php _e('Disable Chat Icon', 'woochatbot'); ?>
                                                    </h4>
                                                    <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_disable_chaticon" type="checkbox"
                                                                                    name="enable_wp_chatbot_disable_chaticon" <?php echo(get_option('enable_wp_chatbot_disable_chaticon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_disable_chaticon">
                                                        <?php _e('Enable to hide chat icon from WPBot bottom area.', 'woochatbot'); ?>
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>

                                                

                                        </div>
                                    </div>
                                    </div>

                                </div>

                            </div>



                        </section>

                        <section id="section-flip-12">
                            <div class="wp-chatbot-language-center-summmery">
                                <p><?php echo esc_html__('Embed the Bot on any website copying the code below', 'wpchatbot'); ?> </p>
                            </div>
                            <div class="top-section">
                                <div class="row">

									<div class="col-xs-12 wpbot_embed_code_section" >
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Embed Code', 'wpchatbot'); ?> </h4>
                                        
												
                                                <p>Copy the below code & add to any page before closing the body tag. <b>Please note that some features like retargeting will not work on embedded pages and it will always use the "Template One" template.</b> SIte search will be performed on the website the WPBot is installed on. Not the site the embed code is on.</p>
												
												<?php 
												$css_url = QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css';
												$page = get_page_by_title('wpwBot Mobile App');
												$wp_chatbot_custom_icon_path = '';
												if (get_option('wp_chatbot_icon') == "custom.png") {
													$wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
												} else if (get_option('wp_chatbot_icon') != "custom.png") {
													$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
												} else {
													$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
												}
												
												?>
												
												<textarea class="wpbot_embed_textarea"><?php echo htmlentities('<script type="text/javascript">var wpIframeUrl = "'.esc_html($page->guid).'"</script><script type="text/javascript" src="'.esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'js/qcld-wp-chatbot-api.js').'"></script>');  ?></textarea>
											
                                                
                                    </div>

                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Widget', 'wpchatbot'); ?></h4>
                                        <hr>
                                        
                                        <div class="col-xs-8">

                                            <div class="cxsc-settings-blocks">
                                                <p><b>Use Shortcode: [chatbot-widget]</b></p>
                                                    <p>If you want to add the Bot as like widget then please add the above shortcode anywhere in the page. It will display like widget. <br><b>Please Note -</b> The WPBot bot icon would not load on that page you have added the above shortcode.</p>
                                                <p>Available Parameter: width, intent</p>
                                                <p><b>width</b>: This parameter allow you to specify the widget width. Default value: 400px. You can also use percentage instead of pixel<br>
                                                Ex: [chatbot-widget width="400px"]
                                                </p>
                                                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                                <br>
                                                Available Values:
                                                <br>
                                                
                                                Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                                
                                                <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>


                                                Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                                <br>
                                                Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                                
                                                <br>Ex: [chatbot-widget intent="Request Callback"]
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-xs-4">
                                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/widget.jpg'); ?>" alt="">
                                        
                                        </div>

                                    </div>                                    
                                   
                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Shortcode for Click to Chat Button', 'wpchatbot'); ?>  </h4>
                                        <hr>
                                        <div class="cxsc-settings-blocks">
                                            <p><b>Use Shortcode: [wpbot-click-chat text="Click to Chat"]</b></p>
                                            <p><b>Available Parameters: text, bot_visibility, intent, display_as, bgcolor, textcolor</b></p>
                                            <p><b>text</b>: This is for the button text. Value for this option would be a text that will be automatically linked to open the ChatBot.<br>Ex: [wpbot-click-chat text="Click to Chat"]</p>
                                            <p><b>bot_visibility</b>: This is show or hide bot floating icon. Available values: show, hide. Default value is "show".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide"]</p>



                                            <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                            <br>
                                            Available Values:
                                            <br>
                                            
                                            Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                            <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>
                                            Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                            <br>
                                            Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                            
                                            <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription"]
                                            </p>

                                            <p><b>display_as</b>: This parameter can control the appearence. Available values: button, link. Default value is "link".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" display_as="button"]</p>
                                            <p><b>bgcolor</b>: You can set the background color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9"]</p>
                                            <p><b>textcolor</b>: You can set the text color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9" textcolor="#fff"]</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12">
                                        <hr>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Show Bot on a Page', 'wpchatbot'); ?></h4>
                                        <hr>
                                        <div class="cxsc-settings-blocks">
                                            <p class="qc-opt-title-font"><?php echo esc_html__('Paste the shortcode', 'wpchatbot'); ?>
                                                <b>[wpbot-page]</b> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                                            <p><b>Available Parameter: intent</b></p>

                                            <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents.
                                            <br>
                                            Available Values:
                                            <br>
                                            
                                            Predefined Intents: <b>Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback</b><br>
                                            <?php 
                                                    if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                    ?>
                                                    Woocommerce Intents: <b>Product Search, Catalog, Featured Products, Products on Sale, Order Status</b><br>
                                                    <?php
                                                    }
                                                ?>
                                            Custom Intents: Any custom intent you create using the Conversational Forms or DialogFlow. Add the custom intent name exactly as you created. For conversational forms, use the exact form name. For Dialogflow use the exact intent name.
                                            <br>
                                            Your available custom intents are:  <b><?php echo qc_dynamic_intent(); ?></b>
                                            
                                            <br>Ex: [wpbot-page intent="Send Us Email"]
                                            </p>

                                            
                                        </div>
                                    </div>


                                </div>
                            </div>
                            
                        </section>

                        <section id="section-flip-6">
                        <?php 
                        wp_enqueue_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                        ?>
                            <div class="top-section">
                                <div class="custom_class_startmenu">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            
                                        <div class="row">
                                    <div class="col-xs-12">
										<h2>Predefined Intents</h2>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Site Search', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_site_search" type="checkbox"
														   name="disable_wp_chatbot_site_search" <?php echo(get_option('disable_wp_chatbot_site_search') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_site_search"><?php echo esc_html__('Disable Site Search feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										<div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                        name="qlcd_wp_site_search"
                                                        value="<?php echo(get_option('qlcd_wp_site_search') != '' ? get_option('qlcd_wp_site_search') : 'Site Search'); ?>">
                                            </div>
										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Call Me', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_call_gen" type="checkbox"
														   name="disable_wp_chatbot_call_gen" <?php echo(get_option('disable_wp_chatbot_call_gen') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_call_gen"><?php echo esc_html__('Disable Call Me feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
											
										</div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                        name="qlcd_wp_chatbot_support_phone"
                                                        value="<?php echo(get_option('qlcd_wp_chatbot_support_phone') != '' ? get_option('qlcd_wp_chatbot_support_phone') : 'Leave your number. We will call you back!'); ?>">
                                                    
                                        </div>

										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Send Email', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_feedback" type="checkbox"
														   name="disable_wp_chatbot_feedback" <?php echo(get_option('disable_wp_chatbot_feedback') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_feedback"><?php echo esc_html__('Disable Send Email feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                    name="qlcd_wp_send_us_email"
                                                    value="<?php echo(get_option('qlcd_wp_send_us_email') != '' ? get_option('qlcd_wp_send_us_email') : 'Send Us Email'); ?>">
                                        </div>

										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Leave a Feedback', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_leave_feedback" type="checkbox"
														   name="disable_wp_leave_feedback" <?php echo(get_option('disable_wp_leave_feedback') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_leave_feedback"><?php echo esc_html__('Disable Leave a Feedback feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                    name="qlcd_wp_leave_feedback"
                                                    value="<?php echo(get_option('qlcd_wp_leave_feedback') != '' ? get_option('qlcd_wp_leave_feedback') : 'Leave a Feedback'); ?>">
                                        </div>

										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('FAQ', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_wp_chatbot_faq" type="checkbox"
														   name="disable_wp_chatbot_faq" <?php echo(get_option('disable_wp_chatbot_faq') == 1 ? 'checked' : ''); ?>>
													<label for="disable_wp_chatbot_faq"><?php echo esc_html__('Disable FAQ feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                    name="qlcd_wp_chatbot_wildcard_support"
                                                    value="<?php echo(get_option('qlcd_wp_chatbot_wildcard_support') != '' ? get_option('qlcd_wp_chatbot_wildcard_support') : 'FAQ'); ?>">

                                        </div>

										<div class="row">
											<div class="col-xs-12">
												<h4 class="qc-opt-title"><?php echo esc_html__('Email Subscription', 'wpchatbot'); ?>  </h4>
												<div class="cxsc-settings-blocks">
													<input value="1" id="disable_email_subscription" type="checkbox"
														   name="disable_email_subscription" <?php echo(get_option('disable_email_subscription') == 1 ? 'checked' : ''); ?>>
													<label for="disable_email_subscription"><?php echo esc_html__('Disable Email Subscription feature and button on start', 'wpchatbot'); ?> </label>
												</div>
											</div>
										</div>
										
                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Button Label', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                    name="qlcd_wp_email_subscription"
                                                    value="<?php echo(get_option('qlcd_wp_email_subscription') != '' ? get_option('qlcd_wp_email_subscription') : 'Email Subscription'); ?>">
                                        </div>

									</div>
									
								</div>

                                    <div class="col-xs-12" style="padding-left: 0px;">
                                        <div class="wpb_custom_intent">
                                            <h2>Add Custom Menu Button with Link</h2>
                                            <div class="form-group">
                                                <?php
                                                $agent_join_options = unserialize(get_option('qlcd_wp_custon_menu'));
                                                $agent_join_option = 'qlcd_wp_custon_menu';
                                                $agent_join_text = esc_html__('', 'wpchatbot');
                                                $this->qcld_wb_chatbot_dynamic_multi_option_menu($agent_join_options, $agent_join_option, $agent_join_text);
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>

                                            <h2>Menu Sorting & Customization Area</h2>
                                            <p style="color:red">*After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                                            <p>In this section you can control the UI of the menu.<br>
To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

                                            <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Menu Area" and add it back from "Menu list".</p>
                                            <div class="qc_menu_setup_area">

                                                <div class="qc_menu_area">
                                                    <h3>Menu Area</h3>
                                                    
                                                    <div class="qc_menu_area_container" id="qc_menu_area">

                                                        <?php echo stripslashes(get_option('qc_wpbot_menu_order')); ?>

                                                    </div>
                                                </div>

                                                <div class="qc_menu_list_area" >
                                                    <h3>Menu List</h3>
                                                    
                                                    <div class="qc_menu_list_container">
                                                    <p>Predefined Intents</p>
                                                    <ul>
                                                        <li>
                                                            <?php if(qcld_wpbot_is_active_livechat()==true): ?>
                                                                <span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>" ><?php echo (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'); ?></span>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <span class="qcld-chatbot-default wpbd_subscription qc_draggable_item"><?php echo get_option('qlcd_wp_email_subscription'); ?></span>
                                                        </li>
                                                        <li>
                                                            <?php if(get_option('enable_wp_custom_intent_livechat_button')==1 && qcld_wpbot_is_active_livechat()): ?>
                                                                <span class="qcld-chatbot-default wpbo_live_chat qc_draggable_item" ><?php echo get_option('qlcd_wp_livechat_button_label'); ?></span>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <?php if(get_option('disable_wp_chatbot_site_search')==''): ?>
                                                                <span class="qcld-chatbot-site-search qc_draggable_item" ><?php echo get_option('qlcd_wp_site_search'); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>
                                                        <li>
                                                            <?php if(get_option('disable_wp_chatbot_faq')==''): ?>
                                                            <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="support"><?php echo get_option('qlcd_wp_chatbot_wildcard_support'); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>
                                                        <li>
                                                            <?php if(get_option('enable_wp_chatbot_messenger')=='1'): ?>
                                                            <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="messenger"><?php echo qcld_choose_random(unserialize(get_option('qlcd_wp_chatbot_messenger_label'))) ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>

                                                        <li>
                                                            <?php if(get_option('enable_wp_chatbot_whats')=='1'): ?>
                                                            <span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="whatsapp"><?php echo qcld_choose_random(unserialize(get_option('qlcd_wp_chatbot_whats_label'))); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>

                                                        <li>
                                                            <?php if(get_option('disable_wp_chatbot_feedback')==''): ?>
                                                            <span class="qcld-chatbot-suggest-email qc_draggable_item"><?php echo get_option('qlcd_wp_send_us_email'); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>

                                                        <li>
                                                            <?php if(get_option('disable_wp_leave_feedback')==''): ?>
                                                            <span class="qcld-chatbot-suggest-email wpbd_feedback qc_draggable_item"><?php echo get_option('qlcd_wp_leave_feedback'); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>

                                                        <li>
                                                            <?php if(get_option('disable_wp_chatbot_call_gen')==''): ?>
                                                            <span class="qcld-chatbot-suggest-phone qc_draggable_item" ><?php echo get_option('qlcd_wp_chatbot_support_phone'); ?></span>
                                                            <?php endif; ?>
                                                        
                                                        </li>

                                                        <?php 
                                                            if(function_exists('qcpd_wpwc_addon_lang_init')){
                                                                do_action('qcld_wpwc_start_menu_option_woocommerce');
                                                            }

                                                        ?>

                                                    </ul>

                                                    <?php 
                                                    $ai_df = get_option('enable_wp_chatbot_dailogflow');
                                                    $custom_intent_labels = unserialize( get_option('qlcd_wp_custon_intent_label'));
                                                    if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):
                                                    ?>
                                                    <p>Custom Intents</p>
                                                    <ul>

                                                        <?php foreach($custom_intent_labels as $custom_intent_label): ?>
                                                            <li>
                                                            <span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo $custom_intent_label ?>" ><?php echo $custom_intent_label ?></span>

                                                            </li>
                                                        <?php endforeach; ?>
                                                        
                                                    </ul>
                                                    <?php endif; ?>

                                                    <?php 
                                                    $qlcd_wp_custon_menu = unserialize( get_option('qlcd_wp_custon_menu'));
                                                    $qlcd_wp_custon_menu_link = unserialize( get_option('qlcd_wp_custon_menu_link'));
                                                    $qlcd_wp_custon_menu_checkbox = unserialize( get_option('qlcd_wp_custon_menu_checkbox'));

                                                    if(isset($qlcd_wp_custon_menu[0]) && trim($qlcd_wp_custon_menu[0])!=''):
                                                    ?>
                                                    <p>Custom Button</p>
                                                    <ul>

                                                        <?php foreach($qlcd_wp_custon_menu as $key=>$value): ?>
                                                            <li>
                                                            <span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink qc_draggable_item" data-link="<?php echo (isset($qlcd_wp_custon_menu_link[$key])?$qlcd_wp_custon_menu_link[$key]:''); ?>" data-target="<?php echo (isset($qlcd_wp_custon_menu_checkbox[$key])?$qlcd_wp_custon_menu_checkbox[$key]:'') ?>" ><?php echo $value ?></span>

                                                            </li>
                                                        <?php endforeach; ?>
                                                        
                                                    </ul>
                                                    <?php endif; ?>

                                                    
                                                    <?php
                                                    if(class_exists('Qcformbuilder_Forms_Admin')){
                                                        global $wpdb;

                                                        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
                                                        if(!empty($results)){
                                                        ?>
                                                        <p>Conversational Form</p>
                                                        <ul>
                                                        <?php
                                                            foreach($results as $result){
                                                                $form = unserialize($result->config);
                                                            ?>
                                                                <li><span class="qcld-chatbot-wildcard qcld-chatbot-form qc_draggable_item" data-form="<?php echo $form['ID']; ?>" ><?php echo $form['name']; ?></span></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    

                                                    </div>

                                                </div>
                                            
                                            </div>
                                            
                                            <input id="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_menu_order" value='<?php echo stripslashes(get_option('qc_wpbot_menu_order')); ?>' />

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="section-flip-8">
                            <div class="wp-chatbot-language-center-summmery">
                                <p><?php echo esc_html__('On Site Retargeting  ', 'wpchatbot'); ?> </p>
                            </div>
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group interaction-re-target">
                                                    <label for="qlcd_wp_chatbot_ret_greet"><?php echo esc_html__('Hello (When available, we will use user name)', 'wpchatbot'); ?> </label>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_ret_greet"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_ret_greet') != '' ? get_option('qlcd_wp_chatbot_ret_greet') : 'Hello'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                <p class="wpbot_gretting_user_demo" ><?php echo esc_html__('(GREETING + USER DEMO NAME)', 'wpchatbot'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Retargeting  message container background color.', 'wpchatbot'); ?></h4>
                                                <input id="wp_chatbot_proactive_bg_color" type="hidden" name="wp_chatbot_proactive_bg_color" value="<?php echo(get_option('wp_chatbot_proactive_bg_color') != '' ? get_option('wp_chatbot_proactive_bg_color') : '#ffffff'); ?>"/>
                                            </div>
                                        </div>

                                        <div class="cxsc-settings-blocks">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Retargeting Sound', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <input value="1" id="enable_wp_chatbot_ret_sound" type="checkbox"
                                                       name="enable_wp_chatbot_ret_sound" <?php echo(get_option('enable_wp_chatbot_ret_sound') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_ret_sound"><?php echo esc_html__('Enable to play sound on Exit-Intent, Scroll Opening etc', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="cxsc-settings-blocks">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Window Focus Title', 'wpchatbot'); ?></h4>

                                            <div class="form-group">
                                                <input value="1" id="enable_wp_chatbot_meta_title" type="checkbox"
                                                       name="enable_wp_chatbot_meta_title" <?php echo(get_option('enable_wp_chatbot_meta_title') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_meta_title"><?php echo esc_html__('Focus window with a short message appended to page title', 'wpchatbot'); ?> </label>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="qlcd_wp_chatbot_meta_label"><?php echo esc_html__('Custom Meta Title', 'wpchatbot'); ?> </label>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="qlcd_wp_chatbot_meta_label"
                                                       value="<?php echo(get_option('qlcd_wp_chatbot_meta_label') != '' ? get_option('qlcd_wp_chatbot_meta_label') : '***New Messages'); ?>">
                                            </div>
                                        </div>


                                        <div class="cxsc-settings-blocks">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('User Exit Intent', 'wpchatbot'); ?> (<?php echo esc_html__('Show Message when mouse pointer moves out of browser viewport', 'wpchatbot'); ?>)</h4>
                                            <div class="form-group">
                                            <input value="1" id="enable_wp_chatbot_exit_intent" type="checkbox"
                                                   name="enable_wp_chatbot_exit_intent" <?php echo(get_option('enable_wp_chatbot_exit_intent') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_exit_intent"><?php echo esc_html__('Enable to show On Exit-Intent Message', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        
                                        <?php if(class_exists('Qcld_Bargain_Admin_Area_Controller'))://if bargain bot activate then ?>
                                        <br>
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_exit_intent_bargain_pro_single_page" type="checkbox"
                                                       name="wp_chatbot_exit_intent_bargain_pro_single_page" <?php echo(get_option('wp_chatbot_exit_intent_bargain_pro_single_page') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_exit_intent_bargain_pro_single_page">
                                                    <?php _e('Trigger bargain bot on Exit Intent for product single pages', 'woochatbot'); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <br>
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_exit_intent_once" type="checkbox"
                                                       name="wp_chatbot_exit_intent_once" <?php echo(get_option('wp_chatbot_exit_intent_once') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_exit_intent_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>

                                        <br>
										
                                        <div class="row">
                                            <div class="col-md-3"> <span class="qc-opt-title-font">
                                            <?php _e('Trigger on  pages', 'wpchatbot'); ?>
                                            </span>
                                            </div>
                                            <div class="col-md-9">
                                            <label class="radio-inline">
                                                <input class="wp-chatbot-exitintent-show-pages" type="radio"
                                                                                    name="wp_chatbot_exitintent_show_pages"
                                                                                    value="on" <?php echo(get_option('wp_chatbot_exitintent_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                <?php _e('All Pages', 'wpchatbot'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input class="wp-chatbot-exitintent-show-pages" type="radio"
                                                                                    name="wp_chatbot_exitintent_show_pages"
                                                                                    value="off" <?php echo(get_option('wp_chatbot_exitintent_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                <?php _e('Selected Pages Only ', 'wpchatbot'); ?>
                                            </label>
                                            <div id="wp-chatbot-exitintent-show-pages-list">
                                                <ul class="checkbox-list">
                                                <?php
                                                $wp_chatbot_pages = get_pages();
                                                $wp_chatbot_select_pages = unserialize(get_option('wp_chatbot_exitintent_show_pages_list'));
                                                foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                    ?>
                                                <li>
                                                    <input id="wp_chatbot_exitintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                            type="checkbox"
                                                            name="wp_chatbot_exitintent_show_pages_list[]"
                                                            value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                        echo 'checked';
                                                    } ?> >
                                                    <label for="wp_chatbot_exitintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                </li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                            <?php $exit_intent_settings = array('textarea_name' =>
                                                'wp_chatbot_exit_intent_msg',
                                                'textarea_rows' => 20,
                                                'editor_height' => 100,
                                                'disabled' => 'disabled',
                                                'media_buttons' => false,
                                                'tinymce'       => array(
                                                    'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                            );
                                            wp_editor(html_entity_decode(stripcslashes(get_option('wp_chatbot_exit_intent_msg'))), 'wp_chatbot_exit_intent_msg', $exit_intent_settings); ?>
                                        </div>
										<br>

                                        <?php if(class_exists('Qcld_Bargain_Admin_Area_Controller'))://if bargain bot activate then ?>
                                        <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                            <h4 class="qc-opt-title">
                                                <?php _e('Your Bargain Message', 'woochatbot'); ?>
                                            </h4>
                                            <?php $exit_intent_bargain_settings = array('textarea_name' =>
                                                                                'wp_chatbot_exit_intent_bargain_msg',
                                                                                'textarea_rows' => 20,
                                                                                'editor_height' => 100,
                                                                                'disabled' => 'disabled',
                                                                                'media_buttons' => false,
                                                                                'tinymce' => array(
                                                                                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                            );
                                                                            wp_editor(html_entity_decode(stripcslashes(get_option('wp_chatbot_exit_intent_bargain_msg'))), 'wp_chatbot_exit_intent_bargain_msg', $exit_intent_bargain_settings); ?>
                                        </div>
                                        <?php endif; ?>

										<div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="wp_chatbot_exit_intent_custom"
                                                       value="<?php echo(get_option('wp_chatbot_exit_intent_custom') != '' ? get_option('wp_chatbot_exit_intent_custom') : ''); ?>">
                                            </div>
                                        </div>
										
										<div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_exit_intent_email" type="checkbox"
                                                       name="wp_chatbot_exit_intent_email" <?php echo(get_option('wp_chatbot_exit_intent_email') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_exit_intent_email"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        
                                    </div>
									<br>
									<br>
                                    <div class="col-xs-12">
                                        <br>
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Scroll Down', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                             <div class="form-group">
                                                <input value="1" id="enable_wp_chatbot_scroll_open" type="checkbox"
                                                       name="enable_wp_chatbot_scroll_open" <?php echo(get_option('enable_wp_chatbot_scroll_open') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_scroll_open"><?php echo esc_html__('Enable to show message once user scrolls down a page', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        <div class="cxsc-settings-blocks">
                                            <span class="qc-opt-dcs-font"> <?php echo esc_html__('WPBot will be shown after scrolling down ', 'wpchatbot'); ?></span>
                                            <input type="number"  name="wp_chatbot_scroll_percent" value="<?php echo(get_option('wp_chatbot_scroll_percent') != '' ? get_option('wp_chatbot_scroll_percent') : 50); ?>">
                                            <span class="qc-opt-dcs-font"> <?php echo esc_html__('percent', 'wpchatbot'); ?></span>
                                        </div>
                                        <div class="cxsc-settings-blocks">
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_scroll_once" type="checkbox"
                                                       name="wp_chatbot_scroll_once" <?php echo(get_option('wp_chatbot_scroll_once') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_scroll_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="cxsc-settings-blocks" id="wp_chatbot_scroll_open_body">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                            <?php $scroll_open_msg_settings = array('textarea_name' =>
                                                'wp_chatbot_scroll_open_msg',
                                                'textarea_rows' => 20,
                                                'editor_height' => 100,
                                                'disabled' => 'disabled',
                                                'media_buttons' => false,
                                                'tinymce'       => array(
                                                    'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                            );
                                            wp_editor(html_entity_decode(stripcslashes(get_option('wp_chatbot_scroll_open_msg'))), 'wp_chatbot_scroll_open_msg', $scroll_open_msg_settings); ?>
                                        </div>

										<div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="wp_chatbot_scroll_open_custom"
                                                       value="<?php echo(get_option('wp_chatbot_scroll_open_custom') != '' ? get_option('wp_chatbot_scroll_open_custom') : ''); ?>">
                                            </div>
                                        </div>
										
										<div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_scroll_open_email" type="checkbox"
                                                       name="wp_chatbot_scroll_open_email" <?php echo(get_option('wp_chatbot_scroll_open_email') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_scroll_open_email"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										
                                        <br>
                                        <br>
                                     </div>
                                     <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Show Message After "X" Seconds', 'wpchatbot'); ?> </h4>
                                         <div class="cxsc-settings-blocks">
                                               <div class="form-group">
                                                <input value="1" id="enable_wp_chatbot_auto_open" type="checkbox"
                                                       name="enable_wp_chatbot_auto_open" <?php echo(get_option('enable_wp_chatbot_auto_open') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_wp_chatbot_auto_open"><?php echo esc_html__('Show message after X seconds', 'wpchatbot'); ?> </label>
                                               </div>
                                         </div>
                                         <div class="cxsc-settings-blocks">
                                             <span class="qc-opt-dcs-font"> <?php echo esc_html__('WPBot will be opened automatically after ', 'wpchatbot'); ?></span>
                                             <input type="number"  name="wp_chatbot_auto_open_time" value="<?php echo(get_option('wp_chatbot_auto_open_time') != '' ? get_option('wp_chatbot_auto_open_time') : 300); ?>">
                                             <span class="qc-opt-dcs-font"> <?php echo esc_html__('seconds', 'wpchatbot'); ?></span>
                                         </div>
                                         <div class="cxsc-settings-blocks">
                                             <div class="form-group">
                                                 <input value="1" id="wp_chatbot_auto_open_once" type="checkbox"
                                                        name="wp_chatbot_auto_open_once" <?php echo(get_option('wp_chatbot_auto_open_once') == 1 ? 'checked' : ''); ?>>
                                                 <label for="wp_chatbot_auto_open_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                             </div>
                                         </div>
                                         <br>
                                         <div class="cxsc-settings-blocks" id="wp_chatbot_auto_open_body">
                                             <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                             <?php $auto_open_msg_settings = array('textarea_name' =>
                                                 'wp_chatbot_auto_open_msg',
                                                 'textarea_rows' => 20,
                                                 'editor_height' => 100,
                                                 'disabled' => 'disabled',
                                                 'media_buttons' => false,
                                                 'tinymce'       => array(
                                                     'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                             );
                                             wp_editor(html_entity_decode(stripcslashes(get_option('wp_chatbot_auto_open_msg'))), 'wp_chatbot_auto_open_msg', $auto_open_msg_settings); ?>

                                         </div>
										 <br>
										 <div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                       name="wp_chatbot_auto_open_custom"
                                                       value="<?php echo(get_option('wp_chatbot_auto_open_custom') != '' ? get_option('wp_chatbot_auto_open_custom') : ''); ?>">
                                            </div>
                                        </div>
										<div class="cxsc-settings-blocks">
											<h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                            <div class="form-group">
                                                <input value="1" id="wp_chatbot_auto_open_email" type="checkbox"
                                                       name="wp_chatbot_auto_open_email" <?php echo(get_option('wp_chatbot_auto_open_email') == 1 ? 'checked' : ''); ?>>
                                                <label for="wp_chatbot_auto_open_email"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
										<br>
										<br>
                                      </div>

                                    </div>
                                </div>
                            <!-- top-section-->
                        </section>

                        <section id="section-flip-10">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('WPBot will be opened based on the following settings', 'wpchatbot'); ?> </p>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable Bot Activity Hour', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks wpbot_bot_activity">
                                            <input value="1" id="enable_wp_chatbot_opening_hour" type="checkbox"
                                                   name="enable_wp_chatbot_opening_hour" <?php echo(get_option('enable_wp_chatbot_opening_hour') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_opening_hour"><?php echo esc_html__('If enabled Bot will show only during the time schedule you set below. The timezone you set from WordPress general settings will be used.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>
                                </div>
                               

                                <?php 
                                $custom_css = ".wp-chatbot-hours-container{
                                    padding:0px 0 15px 0;
                                    display: flex;
                                    justify-content: space-between;
                                }
                                .wp-chatbot-hours{
                                    
                                    display: inline-block;
                                }
                                .wp-chatbot-hours input{
                                    display: inline-block;
                                    width: 40%;
                                    padding-right: 10px;
                                    text-align: center;
                                }
                                .wp-chatbot-hours-remove{
                                    display: inline-block;
                                }";
                                wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
                                ?>


                                <div class="row" id="wp-chatbot-hours-wrapper">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('WPBot Bot Activity Hours', 'wpchatbot'); ?> </h4>
                                        <?php

                                         if(get_option('wpwbot_hours')){
                                             $wpwbot_times=unserialize(get_option('wpwbot_hours'));
                                         }else{
                                             $wpwbot_times=array();
                                         }
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-3">Monday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                 <?php
                                                 $this->wp_chatbot_opening_hours('monday',$wpwbot_times);
                                                 ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="monday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Tuesday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                    <?php
                                                    $this->wp_chatbot_opening_hours('tuesday',$wpwbot_times);
                                                    ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="tuesday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Wednesday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                $this->wp_chatbot_opening_hours('wednesday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="wednesday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Thursday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                $this->wp_chatbot_opening_hours('thursday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="thursday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Friday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                $this->wp_chatbot_opening_hours('friday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="friday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Saturday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                $this->wp_chatbot_opening_hours('saturday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="saturday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">Sunday</div>
                                            <div class="col-xs-4 wp-chatbot-day">
                                                <?php
                                                $this->wp_chatbot_opening_hours('sunday',$wpwbot_times);
                                                ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-success btn-sm wp-chatbot-hours-add-btn" type="button" data-day="sunday">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- top-section-->
                        </section>

                        

                        <section id="section-flip-7">
                            <div class="wp-chatbot-language-center-summmery">
                                <p> <?php echo esc_html__('WPBot integration like Facebook Messenger, WhatApps etc.', 'wpchatbot'); ?></p>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-scl-general"><?php echo esc_html__('General', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-scl-fb"><?php echo esc_html__('Messenger', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-scl-skype"><?php echo esc_html__('Skype', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-whats"><?php echo esc_html__('WhatsApp', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-viber"><?php echo esc_html__('Viber', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-link"><?php echo esc_html__('Web Link', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-phone"><?php echo esc_html__('Phone', 'wpchatbot'); ?></a></li>
								
                                <li><a data-toggle="tab" href="#wp-chatbot-scl-livechat"><?php echo esc_html__('Live Chat', 'wpchatbot'); ?></a></li>
                            </ul>
                            <div class="tab-content">
                            <div id="wp-chatbot-scl-general" class="tab-pane fade in active">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Auto Hide Floating Buttons', 'wpchatbot'); ?> </h4>
                                                        <div class="cxsc-settings-blocks">
                                                            <input value="1" id="qc_auto_hide_floating_button" type="checkbox"
                                                                name="qc_auto_hide_floating_button" <?php echo(get_option('qc_auto_hide_floating_button') == 1 ? 'checked' : ''); ?>>
                                                            <label for="qc_auto_hide_floating_button"><?php echo esc_html__('Enable to auto hide floating buttons', 'wpchatbot'); ?> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <h4 class="qc-opt-title"> <?php echo esc_html__('Enable Reset & Close Button at Top', 'wpchatbot'); ?> </h4>
                                                        <div class="cxsc-settings-blocks">
                                                            <input value="1" id="enable_reset_close_button" type="checkbox"
                                                                name="enable_reset_close_button" <?php echo(get_option('enable_reset_close_button') == 1 ? 'checked' : ''); ?>>
                                                            <label for="enable_reset_close_button"><?php echo esc_html__('Enable reset & close button at top', 'wpchatbot'); ?> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Reset Button Toolip Text', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_reset_lan"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_reset_lan') != '' ? get_option('qlcd_wp_chatbot_reset_lan') : 'Reset'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Close Button Toolip Text', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_close_lan"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_close_lan') != '' ? get_option('qlcd_wp_chatbot_close_lan') : 'Close'); ?>">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-fb" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-interaction-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Enable Messenger (if enabled it will show as option during chat and support)', 'wpchatbot'); ?>  </h4>
                                                 <p><?php echo esc_html__('Create', 'wpchatbot'); ?>  <a href="https://www.facebook.com/business/help/104002523024878" target="_blank"><?php echo esc_html__('Facebook Page Id', 'wpchatbot'); ?> </a> <?php echo esc_html__('and', 'wpchatbot'); ?> <a href="https://developers.facebook.com/docs/apps/register" target="_blank"><?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?></a>.</p>
                                                 <p>You need to add your domain name in the App Domains field in the Basic section of your Facebook Developers-> App settings area.</p>
                                                 <p>You need to add your domain name in the Whitelisted Domains field under your Page Settings -> Messenger Platform area.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_messenger" type="checkbox"
                                                           name="enable_wp_chatbot_messenger" <?php echo(get_option('enable_wp_chatbot_messenger') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_messenger"><?php echo esc_html__('Enable Messenger', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <?php
                                                    $messenger_options = unserialize(get_option('qlcd_wp_chatbot_messenger_label'));
                                                    $messenger_option = 'qlcd_wp_chatbot_messenger_label';
                                                    $messenger_text = esc_html__('Chat with Us on Facebook Messenger', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($messenger_options, $messenger_option, $messenger_text);
                                                    ?>
                                                </div>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Messenger Icon beside Bot Icon', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_messenger_floating_icon" type="checkbox"
                                                           name="enable_wp_chatbot_messenger_floating_icon" <?php echo(get_option('enable_wp_chatbot_messenger_floating_icon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_messenger_floating_icon"><?php echo esc_html__('Enable to display Messenger Icon beside Bot Icon', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_app_id"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_app_id') != '' ? get_option('qlcd_wp_chatbot_fb_app_id') : ''); ?>" placeholder="<?php echo esc_html__('Facebook App ID', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Facebook Page ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_page_id"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_page_id') != '' ? get_option('qlcd_wp_chatbot_fb_page_id') : ''); ?>" placeholder="<?php echo esc_html__('Facebook Page ID', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Messenger Color', 'wpchatbot'); ?></h4>
                                                    <input id="qlcd_wp_chatbot_fb_color" type="hidden" name="qlcd_wp_chatbot_fb_color" value="<?php echo(get_option('qlcd_wp_chatbot_fb_color') != '' ? get_option('qlcd_wp_chatbot_fb_color') : '#0084ff'); ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Logged In Welcome Message', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_in_msg"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_in_msg') != '' ? get_option('qlcd_wp_chatbot_fb_in_msg') :'Welcome to Our Store!'); ?>" placeholder="<?php echo esc_html__('Facebook logged in welcome message', 'wpchatbot'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Logged Out Welcome Message', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_fb_out_msg"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_fb_out_msg') != '' ? get_option('qlcd_wp_chatbot_fb_out_msg') : 'You are not logged in'); ?>" placeholder="<?php echo esc_html__('Facebook logged out welcome message', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-skype" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                               <h4 class="qc-opt-title"><?php echo esc_html__('Show Skype Floating Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_skype_floating_icon" type="checkbox"
                                                           name="enable_wp_chatbot_skype_floating_icon" <?php echo(get_option('enable_wp_chatbot_skype_floating_icon') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_skype_floating_icon"><?php echo esc_html__('Enable to display Skype Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Skype ID', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="enable_wp_chatbot_skype_id"
                                                           value="<?php echo(get_option('enable_wp_chatbot_skype_id') != '' ? get_option('enable_wp_chatbot_skype_id') : ''); ?>" placeholder="<?php echo esc_html__('Skype', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="wp-chatbot-scl-whats" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Enable WhatsApp (if enabled it will show as option during chat and support)', 'wpchatbot'); ?>  </h4>
                                                <p><?php echo esc_html__('Find', 'wpchatbot'); ?> <a target="_blank" href="https://faq.whatsapp.com/en/android/27585377/?category=5245246"><?php echo esc_html__('WhatsApp phone number', 'wpchatbot'); ?></a> <?php echo esc_html__('for settings', 'wpchatbot'); ?>.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_whats" type="checkbox"
                                                           name="enable_wp_chatbot_whats" <?php echo(get_option('enable_wp_chatbot_whats') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_whats"><?php echo esc_html__('Enable WhatsApp', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <?php
                                                    $whatsapp_options = unserialize(get_option('qlcd_wp_chatbot_whats_label'));
                                                    $whatsapp_option = 'qlcd_wp_chatbot_whats_label';
                                                    $whatsapp_text = esc_html__('Chat with Us on WhatsApp', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($whatsapp_options, $whatsapp_option, $whatsapp_text);
                                                    ?>
                                                </div>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show WhatsApp Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_whats" type="checkbox"
                                                           name="enable_wp_chatbot_floating_whats" <?php echo(get_option('enable_wp_chatbot_floating_whats') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_whats"><?php echo esc_html__('Enable to display WhatsApp Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('WhatsApp Phone Number', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_whats_num"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_whats_num') != '' ? get_option('qlcd_wp_chatbot_whats_num') : ''); ?>" placeholder="<?php echo esc_html__('WhatsApp Phone Number', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <div id="wp-chatbot-scl-viber" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Viber Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <p> <?php echo esc_html__('Create', 'wpchatbot'); ?><a href="<?php echo esc_url('https://support.viber.com/customer/en/portal/articles/2733413-get-started-with-a-public-account'); ?>" target="_blank"> <?php echo esc_html__('Viber public Account ', 'wpchatbot'); ?> </a> <?php echo esc_html__('for settings', 'wpchatbot'); ?>.</p>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_viber" type="checkbox"
                                                           name="enable_wp_chatbot_floating_viber" <?php echo(get_option('enable_wp_chatbot_floating_viber') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_viber"><?php echo esc_html__('Enable to display Viber Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Viber Account', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_viber_acc"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_viber_acc') != '' ? get_option('qlcd_wp_chatbot_viber_acc') : ''); ?>" placeholder="<?php echo esc_html__('Viber Account', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                
                                <div id="wp-chatbot-scl-link" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Website Floating Link on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_link" type="checkbox"
                                                           name="enable_wp_chatbot_floating_link" <?php echo(get_option('enable_wp_chatbot_floating_link') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_link"><?php echo esc_html__('Enable to display Website Floating Link on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Website Url', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_weblink"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_weblink') != '' ? get_option('qlcd_wp_chatbot_weblink') : ''); ?>" placeholder="<?php echo esc_html__('Website Url', 'wpchatbot'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <div id="wp-chatbot-scl-phone" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Phone Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_phone" type="checkbox"
                                                           name="enable_wp_chatbot_floating_phone" <?php echo(get_option('enable_wp_chatbot_floating_phone') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_phone"><?php echo esc_html__('Enable to display Phone Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Phone Number', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_phone"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_phone') != '' ? get_option('qlcd_wp_chatbot_phone') : ''); ?>" placeholder="<?php echo esc_html__('Phone Number', 'wpchatbot'); ?>">
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
								
								<div id="wp-chatbot-scl-livechat" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Show Live Chat Icon on Bot Message Board Border', 'wpchatbot'); ?>  </h4>
                                                <div class="cxsc-settings-blocks">
                                                    <input value="1" id="enable_wp_chatbot_floating_livechat" type="checkbox"
                                                           name="enable_wp_chatbot_floating_livechat" <?php echo(get_option('enable_wp_chatbot_floating_livechat') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_floating_livechat"><?php echo esc_html__('Enable to display Livechat Floating Icon on Bot message board border.', 'wpchatbot'); ?> </label>
                                                </div>
                                                <br>
                                                <?php if(qcld_wpbot_is_active_livechat()!==true): ?>
                                                <br>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Direct Chat Link', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_livechatlink"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_livechatlink') != '' ? get_option('qlcd_wp_chatbot_livechatlink') : ''); ?>" placeholder="<?php echo esc_html__('Direct Chat Link', 'wpchatbot'); ?>">
                                                </div>
												<img class="wpbot_direct_chat_link" src="<?php echo QCLD_wpCHATBOT_IMG_URL.'/live-chat.jpg' ?>" alt="" />
                                                <br>
												
												<div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Enable Display in Start Menu', 'wpchatbot'); ?></h4>
                                                    <input value="1" id="enable_wp_custom_intent_livechat_button" type="checkbox"
                                                           name="enable_wp_custom_intent_livechat_button" <?php echo(get_option('enable_wp_custom_intent_livechat_button') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_custom_intent_livechat_button"><?php echo esc_html__('Enable custom intent button for livechat.', 'wpchatbot'); ?> </label>
                                                </div>
												<br>
												<br>
												<div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Livechat Button Label', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_livechat_button_label"
                                                           value="<?php echo(get_option('qlcd_wp_livechat_button_label') != '' ? get_option('qlcd_wp_livechat_button_label') : ''); ?>" placeholder="<?php echo esc_html__('Ex: Live Chat', 'wpchatbot'); ?>">
                                                </div>
												<br>
                                                <?php endif; ?>
												<div class="row">
													<div class="col-xs-12">
														<h4 class="qc-opt-title"><?php echo esc_html__(' Upload custom Icon ', 'wpchatbot'); ?></h4>
														<div class="cxsc-settings-blocks">
															<input type="hidden" name="wp_custom_icon_livechat"
																   id="wp_custom_icon_livechat"
																   value="<?php echo (get_option('wp_custom_icon_livechat') != '' ? get_option('wp_custom_icon_livechat') : ''); ?>" />
															<div id="wp_custom_icon_livechat_src">
																<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
																<img src="<?php echo get_option('wp_custom_icon_livechat'); ?>" alt="" width="50" height="50" />
																<?php endif; ?>
															</div>
															<button type="button" class="wp_custom_icon_livechat button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
															<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
															<button type="button" class="wp_custom_icon_livechat_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
															<?php endif; ?>
														</div>
														
													</div>
												</div>
												
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    top-section-->
                                </div>
								
                            </div>
                            <!--                            tab-content-->
                        </section>

<section id="section-flip-11">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('DialogFlow as Artificial Intelligences Engine for wpwBot', 'wpchatbot'); ?> </p>
                                </div>

                                <?php qcld_wpbot_field_valudation_df(); ?>                   

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-title"><?php echo esc_html__('Enable DialogFlow as AI Engine to Detect Intent', 'wpchatbot'); ?> </h4>
                                        <div class="cxsc-settings-blocks">
                                            <input value="1" id="enable_wp_chatbot_dailogflow" type="checkbox"
                                                   name="enable_wp_chatbot_dailogflow" <?php echo(get_option('enable_wp_chatbot_dailogflow') == 1 ? 'checked' : ''); ?>>
                                            <label for="enable_wp_chatbot_dailogflow"><?php echo esc_html__('Enable DialogFlow AI Engine to process Natural Language commands from users.', 'wpchatbot'); ?> </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12">
                                        <br>
                                        <p><?php echo esc_html__('Log in to DialogFlow Console from', 'wpchatbot'); ?>
                                            <a class="wpbot_df_instruction" href="<?php echo esc_url('https://dialogflow.com/'); ?>" target="_blank"><?php echo esc_html__('Here', 'wpchatbot'); ?></a> <?php echo esc_html__('with your gmail account.', 'wpchatbot'); ?> 

                                       <a class="wpbot_df_instruction" href="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'download/wpwBot.zip'); ?>" download ><?php echo esc_html__('Download', 'wpchatbot'); ?></a> <?php echo esc_html__('the agent training data and import from DialogFlow->Settings->Export and Import tab. You can add your own intents in that agent but do not modify our following system intents which are', 'wpchatbot'); ?> <b>email, email subscription, faq, get email, get name, help, phone, reset, site search and start.</b> </p>
                                    </div>

                                    <div class="col-xs-12" id="wp-chatbot-dialflow-section">
                                    <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow API Version', 'wpchatbot'); ?></h4>
                                        <div class="form-group">

                                            <label class="radio-inline">
                                                <input id="wp-chatbot-df-api" type="radio"
                                                        name="wp_chatbot_df_api"
                                                        value="v1" <?php echo(get_option('wp_chatbot_df_api') == 'v1' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Dialogflow API V1', 'wpchatbot'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input id="wp-chatbot-df-api" type="radio"
                                                        name="wp_chatbot_df_api"
                                                        value="v2" <?php echo(get_option('wp_chatbot_df_api') == 'v2' ? 'checked' : ''); ?>>
                                                <?php echo esc_html__('Dialogflow API V2', 'wpchatbot'); ?>
                                            </label>

                                        </div>

                                        <div id="wp-chatbot-df-section-v2">
                                            <!-- Dialogflow V2 Configuration -->
                                            
                                            <?php if(!file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')): ?>
                                            <div class="form-group">
                                                
                                                <br>
                                                <h4 class="qc-opt-title" style="color:red"><?php echo esc_html__('For Interacting with Dialogflow V2 the Google Client Package is Required!', 'wpchatbot'); ?></h4>
                                                <p>Please click the download button below to download the Google Client package. The package will be downloaded inside your Wordpress's <b>/wp-content</b> folder. This package is around <b>10 MB</b> in zip file format and it will be about <b>49 MB</b> after unzipping. Please make sure that your server has enough space to store that package.</p>
                                                <div class="qcld-wpbot-gcdownload-area">
                                                    <button class="btn btn-primary" id="qc_wpbot_gc_download" <?php echo (!is_writable(QCLD_wpCHATBOT_GC_ROOT)?'disabled':''); ?>>Download and Install the Google Client</button>
													<?php 
														if(!is_writable(QCLD_wpCHATBOT_GC_ROOT)){
															echo '<span style="color:red;font-size: 12px;"><b>wp-content</b> folder is not writable.</span>';
														}
													?>
													<br><br>
													<p>Alternatively, If the download operation fails for some reason like folder permission or server timeout issue then you can manually upload the <u title="Google Client">GC</u> package by following some simple steps.</p>
													<p>1. Download GC package from: <a href="https://github.com/qcloud/gc/archive/master.zip" target="_blank">https://github.com/qcloud/gc/archive/master.zip</a></p>
													<p>2. Unzip the <b>wpbotgc.zip</b> inside to your computer.</p>
													<p>3. Create a folder with name <b>wpbot-dfv2-client</b> under <b>wp-content</b> into your server.</p>
													<p>4. Upload the upziped files and folders into <b>wpbot-dfv2-client</b> via FTP.</p>
													
													
                                                    <div class="qcld_wpbot_download_statuses">
                                                        
                                                    </div>
                                                </div>
                                                <br>
                                                
                                            </div>
                                            <?php else: ?>
                                            <div class="form-group">
                                                <h4 class="qc-opt-title" style="color:green"><?php echo esc_html__('Google Client Package is Installed on Your System.', 'wpchatbot'); ?></h4>
                                            </div>
                                            <?php endif; ?>

                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?></h4>
                                                <p>You can follow the <a href="https://dialogflow.com/docs/reference/v2-auth-setup" target="_blank">tutorial</a> to get the Project ID. </p>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                        name="qlcd_wp_chatbot_dialogflow_project_id"
                                                        value="<?php echo(get_option('qlcd_wp_chatbot_dialogflow_project_id') != '' ? get_option('qlcd_wp_chatbot_dialogflow_project_id') : ''); ?>" placeholder="<?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?>">
                                            </div>

                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Private Key', 'wpchatbot'); ?></h4>
                                                <p>Put your google service account's private key JSON string here. You can follow the <a href="https://dialogflow.com/docs/reference/v2-auth-setup" target="_blank">tutorial</a> to get private key JSON file. </p>
                                                <textarea class="form-control" rows="20" name="qlcd_wp_chatbot_dialogflow_project_key"><?php echo(get_option('qlcd_wp_chatbot_dialogflow_project_key') != '' ? get_option('qlcd_wp_chatbot_dialogflow_project_key') : ''); ?></textarea>
                                            </div>

                                            <!-- End Dialogflow V2 Configuration -->
                                        </div>

                                        <div id="wp-chatbot-df-section-v1">

                                            <div class="form-group">
                                                <p style="color:red" class="qc-opt-title"><?php echo esc_html__('DialogFlow API V1 is going to be retired on October 23, 2019. Please move on to API V2 now so do not face any service interruption.', 'wpchatbot'); ?></>
                                            </div>

                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow client Access Token', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font"
                                                    name="qlcd_wp_chatbot_dialogflow_client_token"
                                                    value="<?php echo(get_option('qlcd_wp_chatbot_dialogflow_client_token') != '' ? get_option('qlcd_wp_chatbot_dialogflow_client_token') : ''); ?>" placeholder="<?php echo esc_html__('DialogFlow Client Access Token', 'wpchatbot'); ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Defualt reply', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                   name="qlcd_wp_chatbot_dialogflow_defualt_reply"
                                                   value="<?php echo(get_option('qlcd_wp_chatbot_dialogflow_defualt_reply') != '' ? get_option('qlcd_wp_chatbot_dialogflow_defualt_reply') : 'Sorry, I did not understand you. You may browse'); ?>" placeholder="<?php echo esc_html__('DialogFlow defualt reply', 'wpchatbot'); ?>">
                                        </div>
										
										<div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Agent Language (Ex: en)', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                   name="qlcd_wp_chatbot_dialogflow_agent_language"
                                                   value="<?php echo (get_option('qlcd_wp_chatbot_dialogflow_agent_language') != '' ? get_option('qlcd_wp_chatbot_dialogflow_agent_language') : 'en'); ?>" placeholder="<?php echo esc_html__('DialogFlow Agent Language', 'wpchatbot'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Webhook URL', 'wpchatbot'); ?></h4>
                                            <input type="text" class="form-control qc-opt-dcs-font" value="<?php echo home_url(); ?>/wp-json/wpbot/v1/dialogflow_webhook" />
                                            <p>You can use this webhook url for Dialogflow agent fulfillment. You can write your own fulfillment code in "qcld-df-webhook.php" file that can be found in plugin root directory.</p>
                                        </div>

                                        <div class="form-group">
                                            <h4 class="qc-opt-title"><?php echo esc_html__('Enable Authentication for Webhook URL', 'wpchatbot'); ?> </h4>
                                            <div class="cxsc-settings-blocks">
                                                <input value="1" id="enable_authentication_webhook" type="checkbox"
                                                    name="enable_authentication_webhook" <?php echo(get_option('enable_authentication_webhook') == 1 ? 'checked' : ''); ?>>
                                                <label for="enable_authentication_webhook"><?php echo esc_html__('Enable Authentication for Dialogflow fulfillment Webhook URL', 'wpchatbot'); ?> </label>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <br>
										<div class="qcld_webhook_auth_container">
                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Auth Username', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control qc-opt-dcs-font" value="<?php echo(get_option('qcld_auth_username') != '' ? get_option('qcld_auth_username') : ''); ?>" name="qcld_auth_username" placeholder="<?php echo esc_html__('Enter Username', 'wpchatbot'); ?>" />
                                                
                                            </div>
                                            <div class="form-group">
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Auth Password', 'wpchatbot'); ?></h4>
                                                <input type="password" class="form-control qc-opt-dcs-font" value="<?php echo(get_option('qcld_auth_password') != '' ? get_option('qcld_auth_password') : ''); ?>" name="qcld_auth_password" placeholder="<?php echo esc_html__('Enter Password', 'wpchatbot'); ?>" />
                                                
                                            </div>
                                        </div>
										<br>
										<div class="form-group">
										<div class="wpb_custom_intent">
											<h2>Custom Intent Options</h2>
											<p>Need to enable Artificial Intelligence for Custom Intent work. The intent name & label must be added in training phrases. The intent name must match EXACTLY as in what you added in DialogFlow.</p>
											<div class="form-group">
												<?php
												$agent_join_options = unserialize(get_option('qlcd_wp_custon_intent'));
												$agent_join_option = 'qlcd_wp_custon_intent';
												$agent_join_text = esc_html__('', 'wpchatbot');
												$this->qcld_wb_chatbot_dynamic_multi_option_custom($agent_join_options, $agent_join_option, $agent_join_text);
												?>
											</div>
											
										</div>
										</div>
										
										
                                    </div>
									
                                </div>
                            </div>
							
                        </section>

                        <section id="section-flip-20">
                            <div class="top-section">
                                <div class="wp-chatbot-language-center-summmery">
                                    <p><?php echo esc_html__('Conversational Form Builder', 'wpchatbot'); ?> </p>
                                </div>

            

                                <div class="row">
                                    <div class="col-xs-12">
                                    <div class="qc-column-12"><!-- qc-column-4 -->
                                        <!-- Feature Box 1 -->
                                        <div class="support-block support-block-custom">
                                            <div class="support-block-img">
                                                <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/conversational-forns.png'); ?>" alt="">
                                            </div>
                                            <div class="support-block-info">
                                                <h4 style="font-weight: normal !important;">Conversational Form Addon</h4>
                                                <p>Use the Conversational form builder AddOn to create conversations and forms for a native WordPress ChatBot experience without any 3rd party integrations. Conversational forms can also be emailed to you.</p>
                                                <p><a href="https://wordpress.org/plugins/conversational-forms/" target="_blank">Download Free</a>|<a href="<?php echo esc_url('https://www.quantumcloud.com/products/conversations-and-form-builder/ '); ?>" target="_blank">Download Pro</a></p>

                                            </div>
                                        </div>
                                    </div><!--/qc-column-4 -->
                                    </div>
									
                                </div>
                            </div>
							
                        </section>



                        <section id="section-flip-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    
                                </div>
                            </div>
                            <div class="top-section">
                                <h4 class="qc-opt-title"><?php echo esc_html__('Build FAQ Query and Answers', 'wpchatbot'); ?></h4>
                                <div class="block-inner ui-sortable" id="wp-chatbot-support-builder">
                                    <?php
                                    $support_quereis=$this->qcld_wb_chatbot_str_replace(unserialize( get_option('support_query')));
                                    $support_ans=$this->qcld_wb_chatbot_str_replace(unserialize( get_option('support_ans')));
                                    if (count($support_ans) >= 1) {
                                        
                                        $query_ans_counter=0;
                                        foreach (array_combine($support_quereis, $support_ans) as $query => $ans) {
                                            ?>
                                            <div class="row">
                                                <span class="pull-right">  </span>
                                                <div class="col-xs-12">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>
                                                    <span  class="wp-chatbot-support-cross pull-right" >
                                                        <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                                                    </span>
                                                    <div class="cxsc-settings-blocks">
                                                        <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query ', 'wpchatbot'); ?></p>
                                                        <input type="text" class="form-control" name="support_query[]"
                                                               placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>" value="<?php echo esc_html($query) ?>">
                                                       <br>
                                                        <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></p>
                                                       <?php wp_editor(html_entity_decode(stripcslashes($ans)), 'support_ans'.'_'.esc_html($query_ans_counter), array('textarea_name' =>
                                                        'support_ans[]',
                                                        'textarea_rows' => 20,
                                                        'editor_height' => 100,
                                                        'disabled' => 'disabled',
                                                        'media_buttons' => false,
                                                        'tinymce'       => array(
                                                        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                        )); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $query_ans_counter++;
                                        }
                                        
                                    } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="button"
                                                        class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </button>
                                                <span  class="wp-chatbot-support-cross pull-right" >
                                                        <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                                                    </span>
                                                <div class="cxsc-settings-blocks">
                                                    <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query', 'wpchatbot'); ?> </p>
                                                    <input type="text" class="form-control" name="support_query[]"
                                                           placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>">
                                                    <br>
                                                    <p class="qc-opt-dcs-font"><strong><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></strong></p>
                                                    <?php wp_editor(html_entity_decode(stripcslashes('')), 'support_ans_0', array('textarea_name' =>
                                                        'support_ans[]',
                                                        'textarea_rows' => 20,
                                                        'editor_height' => 100,
                                                        'disabled' => 'disabled',
                                                        'media_buttons' => false,
                                                        'tinymce'       => array(
                                                            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                    )); ?>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 text-left"></div>
                                    <div class="col-sm-6 text-right">
                                        <button class="btn btn-success btn-sm" type="button"
                                                id="add-more-support-query"><i
                                                    class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add More Questions and Answers', 'wpchatbot'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="section-flip-4">
                            <div class="top-section">
                                <div class="notification-block-inner">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="cxsc-settings-blocks">
                                                <?php $notification_interval = get_option('qlcd_wp_chatbot_notification_interval') != "" ? get_option('qlcd_wp_chatbot_notification_interval') : 5 ?>
                                                <h4 class="qc-opt-title"><?php echo esc_html__('Interval between notifications (in Seconds).', 'wpchatbot'); ?></h4>
                                                <input type="text" class="form-control"
                                                       name="qlcd_wp_chatbot_notification_interval"
                                                       value="<?php echo esc_html($notification_interval); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    $notifications = $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications')));
                                    $intents = $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications_intent')));

                                    
                                    if (!empty($notifications)) {
                                        $chatbot_notif_counter=0;
                                        foreach ($notifications as $notification) {
                                            ?>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="cxsc-settings-blocks" style="margin-top:26px">
                                                        <?php wp_editor(html_entity_decode(stripcslashes($notification)), 'qlcd_wp_chatbot_notifications_'.esc_html($chatbot_notif_counter), array('textarea_name' =>
                                                            'qlcd_wp_chatbot_notifications[]',
                                                            'textarea_rows' => 20,
                                                            'editor_height' => 100,
                                                            'disabled' => 'disabled',
                                                            'media_buttons' => false,
                                                            'tinymce'       => array(
                                                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                        )); ?>
                                                    </div>
                                                    <?php $allIntents = qc_get_all_intents(); ?>
                                                    <div class="cxsc-settings-blocks">
                                                        <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                                                        <select name="qlcd_wp_chatbot_notifications_intent[]">

                                                            <?php 
                                                                foreach($allIntents as $key => $value){
                                                                    ?>
                                                                    <optgroup label="<?php echo $key ?>">
                                                                        <option value="" >None</option>
                                                                        <?php foreach($value as $val){ ?>

                                                                            <option value="<?php echo $val; ?>" <?php echo (isset($intents[$chatbot_notif_counter])&&$intents[$chatbot_notif_counter]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                                        <?php } ?>
                                                                    </optgroup>
                                                                    <?php
                                                                }
                                                            ?>

                                                        </select>                                                   
                                                    </div>

                                                </div>
                                                
                                            </div>
                                            
                                            <?php
                                            $chatbot_notif_counter++;
                                        }
                                        
                                    } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="button"
                                                        class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </button>
                                                <div class="cxsc-settings-blocks">
                                                    <?php wp_editor(html_entity_decode(stripcslashes('')), 'qlcd_wp_chatbot_notifications_0', array('textarea_name' =>
                                                        'qlcd_wp_chatbot_notifications[]',
                                                        'textarea_rows' => 20,
                                                        'editor_height' => 100,
                                                        'disabled' => 'disabled',
                                                        'media_buttons' => false,
                                                        'tinymce'       => array(
                                                            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                    )); ?>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                                                    <select name="qlcd_wp_chatbot_notifications_intent[]">

                                                        <?php 
                                                            foreach($allIntents as $key => $value){
                                                                ?>
                                                                <optgroup label="<?php echo $key ?>">
                                                                    <option value="" >None</option>
                                                                    <?php foreach($value as $val){ ?>

                                                                        <option value="<?php echo $val; ?>" ><?php echo $val; ?></option>

                                                                    <?php } ?>
                                                                </optgroup>
                                                                <?php
                                                            }
                                                        ?>

                                                    </select>                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 text-left"></div>
                                    <div class="col-sm-6 text-right">
                                        <button class="btn btn-success btn-sm" type="button"
                                                id="add-more-notification-message">
                                            <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </section>
                        <section id="section-flip-5">
                            <div class="wp-chatbot-language-center-summmery">
                                
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-lng-general"><?php echo esc_html__('General', 'wpchatbot'); ?></a></li>
                                
                                
                                <li><a data-toggle="tab" href="#wp-chatbot-lng-support"><?php echo esc_html__('FAQ', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-lng-subscription"><?php echo esc_html__('Email Subscription', 'wpchatbot'); ?></a></li>
								
								
                               
                                <li><a data-toggle="tab" href="#wp-chatbot-lng-system-keyword"><?php echo esc_html__('System Keywords', 'wpchatbot'); ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="wp-chatbot-lng-general" class="tab-pane fade in active">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h5><strong style="font-weight:bold;">1.</strong> You can use this variable for user name: %%username%%</h5>
                                                <h5><strong style="font-weight:bold;">2.</strong> Insert full link to an image to show in the chatbot responses like https://www.quantumcloud.com/wp/sad.jpg</h5>
                                                <h5><strong style="font-weight:bold;">3.</strong> Insert full link to an youtube video to show in the chatbot responses like https://www.youtube.com/watch?v=gIGqgLEK1BI</h5>
                                                <h5 ><strong style="font-weight:bold;">4.</strong> After making changes in the language center or settings, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in chrome).</h5>
                                                <h5 style="line-height: 20px;"><strong style="font-weight:bold;">5.</strong> You could use &lt;br&gt; tag for line break.</h5>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Your Company or Website Name', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_host"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_host') != '' ? get_option('qlcd_wp_chatbot_host') : 'Our Store'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Agent name', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_agent"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_agent') != '' ? get_option('qlcd_wp_chatbot_agent') : 'Carrie'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('User demo name', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_shopper_demo_name"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_shopper_demo_name') != '' ? get_option('qlcd_wp_chatbot_shopper_demo_name') : 'Amigo'); ?>">
                                                </div>
												<div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Ok, I will just call you', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_shopper_call_you"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_shopper_call_you') != '' ? get_option('qlcd_wp_chatbot_shopper_call_you') : 'Ok, I will just call you'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('YES', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_yes"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_yes') != '' ? get_option('qlcd_wp_chatbot_yes') : 'YES'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('NO', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_no"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_no') != '' ? get_option('qlcd_wp_chatbot_no') : 'NO'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('OR', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_or"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_or') != '' ? get_option('qlcd_wp_chatbot_or') : ''); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Sorry', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_sorry"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_sorry') != '' ? get_option('qlcd_wp_chatbot_sorry') : 'Sorry'); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Hello', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_hello"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_hello') != '' ? get_option('qlcd_wp_chatbot_hello') : 'Hello'); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Chat with us!', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_chat_with_us"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_chat_with_us') != '' ? get_option('qlcd_wp_chatbot_chat_with_us') : 'Chat with us!'); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <?php
                                                    $agent_join_options = unserialize(get_option('qlcd_wp_chatbot_agent_join'));
                                                    $agent_join_option = 'qlcd_wp_chatbot_agent_join';
                                                    $agent_join_text = esc_html__('has joined the conversation', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($agent_join_options, $agent_join_option, $agent_join_text);
                                                    ?>
                                                </div>
                                            </div>
                                            <!--col-xs-12-->
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                                <h4 class="text-success"><?php echo esc_html__(' Message setting for Greetings: ', 'wpchatbot'); ?></h4>
                                                <div class="form-group">
                                                    <?php
                                                    $welcome_to_options = unserialize(get_option('qlcd_wp_chatbot_welcome'));
                                                    $welcome_to_option = 'qlcd_wp_chatbot_welcome';
                                                    $welcome_to_text = esc_html__('Welcome to', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($welcome_to_options, $welcome_to_option, $welcome_to_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $welcome_back_options = unserialize(get_option('qlcd_wp_chatbot_welcome_back'));
                                                    $welcome_back_option = 'qlcd_wp_chatbot_welcome_back';
                                                    $welcome_back_text = esc_html__('Welcome back', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($welcome_back_options, $welcome_back_option, $welcome_back_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $back_to_start_options = unserialize(get_option('qlcd_wp_chatbot_back_to_start'));
                                                    $back_to_start_option = 'qlcd_wp_chatbot_back_to_start';
                                                    $back_to_start_text = esc_html__('Back to Start', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($back_to_start_options, $back_to_start_option, $back_to_start_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $hi_there_options = unserialize(get_option('qlcd_wp_chatbot_hi_there'));
                                                    $hi_there_option = 'qlcd_wp_chatbot_hi_there';
                                                    $hi_there_text = esc_html__('Hi There!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($hi_there_options, $hi_there_option, $hi_there_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $asking_name_options = unserialize(get_option('qlcd_wp_chatbot_asking_name'));
                                                    $asking_name_option = 'qlcd_wp_chatbot_asking_name';
                                                    $asking_name_text = esc_html__('May I know your name?', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_name_options, $asking_name_option, $asking_name_text);
                                                    ?>
                                                </div>
												<div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_asking_emailaddress'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_asking_emailaddress';
                                                    $asking_email_text = esc_html__('May I know your email?', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>
												<div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_got_email'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_got_email';
                                                    $asking_email_text = esc_html__('Thanks for sharing your email!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>

                                                <div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_email_ignore'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_email_ignore';
                                                    $asking_email_text = esc_html__('No problem if you do not want to share your email address!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>

                                                <div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_asking_phone_gt'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_asking_phone_gt';
                                                    $asking_email_text = esc_html__('May I know your phone number?', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>
												<div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_got_phone'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_got_phone';
                                                    $asking_email_text = esc_html__('Thanks for sharing your phone number!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>

												<div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_phone_ignore'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_phone_ignore';
                                                    $asking_email_text = esc_html__('No problem if you do not want to share your phone number', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                    ?>
                                                </div>

                                                <div class="form-group">
                                                    <?php
                                                    $i_am_options = unserialize(get_option('qlcd_wp_chatbot_i_am'));
                                                    $i_am_option = 'qlcd_wp_chatbot_i_am';
                                                    $i_am_text = esc_html__('I am', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($i_am_options, $i_am_option, $i_am_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $name_greeting_options = unserialize(get_option('qlcd_wp_chatbot_name_greeting'));
                                                    $name_greeting_option = 'qlcd_wp_chatbot_name_greeting';
                                                    $name_greeting_text = esc_html__('Nice to meet you', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($name_greeting_options, $name_greeting_option, $name_greeting_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $wildcard_msg_options = unserialize(get_option('qlcd_wp_chatbot_wildcard_msg'));
                                                    $wildcard_msg_option = 'qlcd_wp_chatbot_wildcard_msg';
                                                    $wildcard_msg_text = esc_html__('Hi %%username%%. I am here to find what you need. What are you looking for?', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wildcard_msg_options, $wildcard_msg_option, $wildcard_msg_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $empty_filter_msgs = unserialize(get_option('qlcd_wp_chatbot_empty_filter_msg'));
                                                    $empty_filter_msg = 'qlcd_wp_chatbot_empty_filter_msg';
                                                    $empty_filter_msg_text = esc_html__('Sorry, I did not understand that', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($empty_filter_msgs, $empty_filter_msg, $empty_filter_msg_text);
                                                    ?>
                                                </div>
                                                
                                                <h4 class="text-success"> <?php echo esc_html__('Message setting for Editor Box ', 'wpchatbot'); ?></h4>
                                                <div class="form-group">
                                                    <?php
                                                    $is_typing_options = unserialize(get_option('qlcd_wp_chatbot_is_typing'));
                                                    $is_typing_option = 'qlcd_wp_chatbot_is_typing';
                                                    $is_typing_text = esc_html__('is typing...', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($is_typing_options, $is_typing_option, $is_typing_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $send_a_msg_options = unserialize(get_option('qlcd_wp_chatbot_send_a_msg'));
                                                    $send_a_msg_option = 'qlcd_wp_chatbot_send_a_msg';
                                                    $send_a_msg_text =esc_html__('Send a message', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($send_a_msg_options, $send_a_msg_option, $send_a_msg_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $choose_option_options = unserialize(get_option('qlcd_wp_chatbot_choose_option'));
                                                    $choose_option_option = 'qlcd_wp_chatbot_choose_option';
                                                    $choose_option_text = esc_html__('Choose an option', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($choose_option_options, $choose_option_option, $choose_option_text);
                                                    ?>
                                                </div>
                                                
                                                <div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('Support Mail Subject', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_email_sub"
														   value="<?php echo(get_option('qlcd_wp_chatbot_email_sub') != '' ? get_option('qlcd_wp_chatbot_email_sub') : 'Support Request from WPBOT'); ?>">
												</div>

                                                <div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('We have found #result results for #keyword', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_we_have_found"
														   value="<?php echo(get_option('qlcd_wp_chatbot_we_have_found') != '' ? get_option('qlcd_wp_chatbot_we_have_found') : 'We have found #result results for #keyword'); ?>">
												</div>

												
												<div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('qlcd_wp_chatbot_no_result'));
                                                    $wp_chatbot_no_result = 'qlcd_wp_chatbot_no_result';
                                                    $wp_chatbot_no_result_text = esc_html__('Sorry, No result found!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>
                                                </div>
												
												
												
												<div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('Your email was sent successfully.Thanks!', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_email_sent"
														   value="<?php echo(get_option('qlcd_wp_chatbot_email_sent') != '' ? get_option('qlcd_wp_chatbot_email_sent') : 'Your email was sent successfully.Thanks!'); ?>">
												</div>
												<div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('Sorry! I could not send your mail! Please contact the webmaster.', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_email_fail"
														   value="<?php echo(get_option('qlcd_wp_chatbot_email_fail') != '' ? get_option('qlcd_wp_chatbot_email_fail') : 'Sorry! fail to send email'); ?>">
												</div>
												
												
												<div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('Thank you for the Phone number. We will call back ASAP.', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_phone_sent"
														   value="<?php echo(get_option('qlcd_wp_chatbot_phone_sent') != '' ? get_option('qlcd_wp_chatbot_phone_sent') : 'Thank you for the Phone number. We will call back ASAP.'); ?>">
												</div>
												<div class="form-group">
													<h4 class="qc-opt-title"><?php echo esc_html__('Sorry! I could not collect phone number! Please contact the webmaster.', 'wpchatbot'); ?></h4>
													<input type="text" class="form-control qc-opt-dcs-font"
														   name="qlcd_wp_chatbot_phone_fail"
														   value="<?php echo(get_option('qlcd_wp_chatbot_phone_fail') != '' ? get_option('qlcd_wp_chatbot_phone_fail') : 'Sorry! I could not collect phone number!'); ?>">
												</div>
												<div class="form-group">
                                                    <?php
                                                    $support_email_options = unserialize(get_option('qlcd_wp_chatbot_support_email'));
                                                    $support_email_option = 'qlcd_wp_chatbot_support_email';
                                                    $support_email_text = esc_html__('Click me if you want to send us a email.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($support_email_options, $support_email_option, $support_email_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_asking_email'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_asking_email';
                                                    $asking_email_text = esc_html__('Please provide your email address', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                 ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $asking_email_options = unserialize(get_option('qlcd_wp_chatbot_valid_phone_number'));
                                                    $asking_email_option = 'qlcd_wp_chatbot_valid_phone_number';
                                                    $asking_email_text = esc_html__('Please provide a valid phone number', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                                 ?>
                                                </div>
												<div class="form-group">
                                                    <?php
                                                    $search_keyword = unserialize(get_option('qlcd_wp_chatbot_search_keyword'));
                                                    $search_keyword_option = 'qlcd_wp_chatbot_search_keyword';
                                                    $search_keyword_text = esc_html__('Hello #name!, Please enter your keyword for searching', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($search_keyword, $search_keyword_option, $search_keyword_text);
                                                 ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $invalid_email_options = unserialize(get_option('qlcd_wp_chatbot_invalid_email'));
                                                    $invalid_email_option = 'qlcd_wp_chatbot_invalid_email';
                                                    $invalid_email_text = esc_html__('Sorry, Email address is not valid! Please provide a valid email.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($invalid_email_options, $invalid_email_option, $invalid_email_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $asking_msg_options = unserialize(get_option('qlcd_wp_chatbot_asking_msg'));
                                                    $asking_msg_option = 'qlcd_wp_chatbot_asking_msg';
                                                    $asking_msg_text = esc_html__('Thank you for email address. Please write your message now.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_msg_options, $asking_msg_option, $asking_msg_text);
                                                    ?>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <?php
                                                    $feedback_label_options = unserialize(get_option('qlcd_wp_chatbot_feedback_label'));
                                                    $feedback_label_option = 'qlcd_wp_chatbot_feedback_label';
                                                    $feedback_label_text = esc_html__('Send Feedback!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($feedback_label_options, $feedback_label_option, $feedback_label_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $asking_phone_options = unserialize(get_option('qlcd_wp_chatbot_asking_phone'));
                                                    $asking_phone_option = 'qlcd_wp_chatbot_asking_phone';
                                                    $asking_phone_text = esc_html__('Please provide your Phone number', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($asking_phone_options, $asking_phone_option, $asking_phone_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $thanks_phone_options = unserialize(get_option('qlcd_wp_chatbot_thank_for_phone'));
                                                    $thanks_phone_option = 'qlcd_wp_chatbot_thank_for_phone';
                                                    $thanks_phone_text = esc_html__('Thank you for Phone number', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($thanks_phone_options, $thanks_phone_option, $thanks_phone_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $support_option_again_options = unserialize(get_option('qlcd_wp_chatbot_support_option_again'));
                                                    $support_option_again_option = 'qlcd_wp_chatbot_support_option_again';
                                                    $support_option_again_text = esc_html__('You may choose an option from below.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($support_option_again_options, $support_option_again_option, $support_option_again_text);
                                                    ?>
                                                </div>

                                                

                                            </div>
                                        </div>

                                        


                                    </div>
                                </div>
                                
                                
                                
                                <div id="wp-chatbot-lng-support" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">

                                        

                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>
                                                
                                                <div class="form-group">
                                                    <?php
                                                    $support_welcome_options = unserialize(get_option('qlcd_wp_chatbot_support_welcome'));
                                                    $support_welcome_option = 'qlcd_wp_chatbot_support_welcome';
                                                    $support_welcome_text = esc_html__('Welcome to FAQ Section', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($support_welcome_options, $support_welcome_option, $support_welcome_text);
                                                    ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div id="wp-chatbot-lng-subscription" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">

                                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>

                                                
                                                
                                            </div>
											<div class="col-xs-12" id="wp-chatbot-language-section">
												<div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('do_you_want_to_subscribe'));
                                                    $wp_chatbot_no_result = 'do_you_want_to_subscribe';
                                                    $wp_chatbot_no_result_text = esc_html__('Do you want to subscribe to our newsletter?', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('qlcd_wp_email_subscription_success'));
                                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_success';
                                                    $wp_chatbot_no_result_text = esc_html__('You have successfully subscribed to our newsletter. Thank you!', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>
                                                </div>
												<div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('qlcd_wp_email_already_subscribe'));
                                                    $wp_chatbot_no_result = 'qlcd_wp_email_already_subscribe';
                                                    $wp_chatbot_no_result_text = esc_html__('You have already subscribed to our newsletter.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>
                                                </div>
												
												
                                                    
                                                <div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('qlcd_wp_email_subscription_offer_subject'));
                                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_offer_subject';
                                                    $wp_chatbot_no_result_text = esc_html__('Email Subscription Offer Subject', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>

                                                </div>

                                                <div class="form-group">
                                                    <?php
                                                    $wp_chatbot_no_results = unserialize(get_option('qlcd_wp_email_subscription_offer'));
                                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_offer';
                                                    $wp_chatbot_no_result_text = esc_html__('Email Subscription Offer Content.', 'wpchatbot');
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                    ?>
                                                    <p>If email subscription offer is enabled from General Settings, It will be sent to subscriber's email when subscription done.</p>
                                                    <br>
                                                </div>
												
                                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                                    <div class="form-group">
                                                        <h4 class="qc-opt-title"><?php echo esc_html__('Unsubscribe', 'wpchatbot'); ?></h4>
                                                        <input type="text" class="form-control qc-opt-dcs-font"
                                                            name="qlcd_wp_email_unsubscription"
                                                            value="<?php echo(get_option('qlcd_wp_email_unsubscription') != '' ? get_option('qlcd_wp_email_unsubscription') : 'Unsubscribe'); ?>">
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                                    <div class="form-group">
                                                        <?php
                                                        $wp_chatbot_no_results = unserialize(get_option('do_you_want_to_unsubscribe'));
                                                        $wp_chatbot_no_result = 'do_you_want_to_unsubscribe';
                                                        $wp_chatbot_no_result_text = esc_html__('Do you want to unsubscribe from our newsletter?', 'wpchatbot');
                                                        $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                                    <div class="form-group">
                                                        <?php
                                                        $wp_chatbot_no_results = unserialize(get_option('you_have_successfully_unsubscribe'));
                                                        $wp_chatbot_no_result = 'you_have_successfully_unsubscribe';
                                                        $wp_chatbot_no_result_text = esc_html__('You have successfully unsubscribed from our newsletter!', 'wpchatbot');
                                                        $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                                    <div class="form-group">
                                                        <?php
                                                        $wp_chatbot_no_results = unserialize(get_option('we_do_not_have_your_email'));
                                                        $wp_chatbot_no_result = 'we_do_not_have_your_email';
                                                        $wp_chatbot_no_result_text = esc_html__('We do not have your email in the ChatBot database.', 'wpchatbot');
                                                        $this->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                                        ?>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="wp-chatbot-lng-system-keyword" class="tab-pane fade">
                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Start Keyword', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_sys_key_help"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_sys_key_help') != '' ? get_option('qlcd_wp_chatbot_sys_key_help') : 'start'); ?>">
                                                </div>
                                                

                                                


                                                
                                                
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><strong><?php echo esc_html__('FAQ', 'wpchatbot'); ?></strong> <?php echo esc_html__('Keyword', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_sys_key_support"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_sys_key_support') != '' ? get_option('qlcd_wp_chatbot_sys_key_support') : 'faq'); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <h4 class="qc-opt-title"><strong><?php echo esc_html__('Converstion History Clear', 'wpchatbot'); ?></strong> <?php echo esc_html__('Keyword', 'wpchatbot'); ?></h4>
                                                    <input type="text" class="form-control qc-opt-dcs-font"
                                                           name="qlcd_wp_chatbot_sys_key_reset"
                                                           value="<?php echo(get_option('qlcd_wp_chatbot_sys_key_reset') != '' ? get_option('qlcd_wp_chatbot_sys_key_reset') : 'reset'); ?>">
                                                </div>
												
                                                <div class="form-group">
                                                    <?php
                                                    $help_welcome_options = unserialize(get_option('qlcd_wp_chatbot_help_welcome'));
                                                    $help_welcome_option = 'qlcd_wp_chatbot_help_welcome';
                                                    $help_welcome_text = 'Welcome to Help Section';
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($help_welcome_options, $help_welcome_option, $help_welcome_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $help_msg_options = unserialize(get_option('qlcd_wp_chatbot_help_msg'));
                                                    $help_msg_option = 'qlcd_wp_chatbot_help_msg';
                                                    $help_msg_text = '<h3>Type and Hit Enter</h3>  1. <b>start</b> Get back to the main menu. <br> 2. <b>faq</b> for  FAQ. <br> 3. <b>reset</b> To clear chat history and start from the beginning.  4. <b>livechat</b>  To navigating into the livechat window. 5. <b>unsubscribe</b> to remove your email from our newsletter.';
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($help_msg_options, $help_msg_option, $help_msg_text);
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $reset_options = unserialize(get_option('qlcd_wp_chatbot_reset'));
                                                    $reset_option = 'qlcd_wp_chatbot_reset';
                                                    $reset_text = 'Do you want to clear our chat history and start over?';
                                                    $this->qcld_wb_chatbot_dynamic_multi_option($reset_options, $reset_option, $reset_text);
                                                    ?>
                                                </div>
                                            </div>
                                            <!--                                            col-xs-12-->
                                        </div>
                                        <!--                                        row-->
                                    </div>
                                    <!--                                    top-section-->
                                </div>
                                <!--                                wp-chatbot-lng-system-keyword-->
                            </div>
                            <!--                            tab-content-->
                        </section>


                        <section id="section-flip-13">
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="qc-opt-dcs"><?php echo esc_html__('You can paste or write your custom css here.', 'wpchatbot'); ?></h4>
                                        <textarea name="wp_chatbot_custom_css"
                                                  class="form-control wp-chatbot-custom-css"
                                                  cols="10"
                                                  rows="16"><?php echo get_option('wp_chatbot_custom_css'); ?></textarea>
                                    </div>
                                </div>
                                <!--                                row-->
                            </div>
                        </section>
                        <?php if(!qcld_wpbot_is_active_white_label()): ?>

                        <section id="section-flip-14">
                            <div class="top-section">
                                <div class="row">
                                    <div class="col-xs-12">

        <?php wp_enqueue_style( 'qcpd-google-font-lato', 'https://fonts.googleapis.com/css?family=Lato' ); ?>
		<?php wp_enqueue_style( 'qcpd-style-addon-page', QCLD_wpCHATBOT_PLUGIN_URL.'qc-support-promo-page/css/style.css' ); ?>
        <?php wp_enqueue_style( 'qcpd-style-responsive-addon-page', QCLD_wpCHATBOT_PLUGIN_URL.'qc-support-promo-page/css/responsive.css' ); ?>
        
<div class="qc_support_container"><!--qc_support_container-->

<div class="qc_tabcontent clearfix-div">
<div class="qc-row">
	
    <h2 class="plugin-title wpbot_page_title" >Extend <?php echo wpbot_text(); ?> and give it more Super Powers</h2>
    
    

	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				 <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/conversational-forns.png'); ?>" alt="">
			</div>
			<div class="support-block-info">
				<h4 style="font-weight: normal !important;">Conversational Form Addon</h4>
				<p>Use the Conversational form builder AddOn to create conversations and forms for a native WordPress ChatBot experience without any 3rd party integrations. Conversational forms can also be emailed to you.</p>
                <p><a href="https://wordpress.org/plugins/conversational-forms/" target="_blank">Download Free</a>|<a href="<?php echo esc_url('https://www.quantumcloud.com/products/conversations-and-form-builder/ '); ?>" target="_blank">Download Pro</a></p>

			</div>
		</div>
	</div><!--/qc-column-4 -->

    

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/custom-post-type-addon-logo.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Extended Search</a></h4>
				<p>Extend <?php echo wpbot_text(); ?>’s search power to include almost any Custom Post Type including WooCommerce</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/woo-addon-256.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Woocommerce Addon</a></h4>
				<p>Utilize the <?php echo wpbot_text(); ?> on your Woocommerce website and make a Woocommerce Chatbot with zero configuration</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->

	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/messenger-chatbot.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Messenger ChatBot Addon</a></h4>
				<p>Utilize the <?php echo wpbot_text(); ?> on your website as a hub to respond to customer questions on FB Page & Messenger</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
	
	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/chatbot-sesssion-save.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">ChatBot Session Save Addon</a></h4>
				<p>This AddOn saves the user chat sessions and helps you fine tune the bot for better support and performance.</p>

			</div>
		</div>
	</div><!--/qc-column-4 -->
	
	
	<div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/WPBot-LiveChat.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">LiveChat Addon</a></h4>
				<p>Live Human Chat integrated with <?php echo wpbot_text(); ?><p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/white-label.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">White Label <?php echo wpbot_text(); ?></a></h4>
				<p>Replace the QuantumCloud Logo and branding with yours. Suitable for developers and agencies interested in providing ChatBot services for their clients.<p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->

    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/mailing-list-integrationt (1).png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">Mailing List Integration AddOn</a></h4>
				<p>Mailing List Integration is an addon that lets you connect our ChatBot with Mailchimp and Zapier accounts. You can add new subscribers to your Mailchimp Lists and unsubscribe them.<p/>
			</div>
		</div>
	</div><!--/qc-column-4 -->
    <div class="qc-column-6"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block support-block-custom">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank"> <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/chatbot-addons.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">More Addons</a></h4>
				<p>Check out all the available ChatBot AddOns<p/>
			</div>
		</div>
    </div><!--/qc-column-4 -->
    
    <div class="qc-column-12"><!-- qc-column-4 -->
		<!-- Feature Box 1 -->
		<div class="support-block ">
			<div class="support-block-img">
				<a href="<?php echo esc_url('https://www.quantumcloud.com/products/themes/chatbot-theme/'); ?>" target="_blank"> <img class="wp_addon_fullwidth" src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/ChatBot-Master-theme.png'); ?>" alt=""></a>
			</div>
			<div class="support-block-info" style="min-height:150px">
				<h4><a href="<?php echo esc_url('https://www.quantumcloud.com/products/chatbot-addons/'); ?>" target="_blank">ChatBot Master Theme</a></h4>
                <p>Get a ChatBot Powered Theme!</p>
			</div>
		</div>
	</div><!--/qc-column-4 -->

</div>
<!--qc row-->
</div>

</div><!--qc_support_container-->



                                    </div>
                                </div>
                                <!--                                row-->
                            </div>
                        </section>
                                            <?php endif; ?>
                    


                    </div><!-- /content -->
                </div><!-- /wp-chatbot-tabs -->
                <footer class="wp-chatbot-admin-footer">
                    <div class="row">
                        <div class="text-left col-sm-3 col-sm-offset-3">
                            <input type="button" class="btn btn-warning submit-button"
                                   id="qcld-wp-chatbot-reset-option"
                                   value="<?php echo esc_html__('Reset all options to Default', 'wpchatbot'); ?>"/>
                        </div>
                        <div class="text-right col-sm-6">
                            <input type="submit" class="btn btn-primary submit-button" name="submit"
                                   id="submit" value="<?php echo esc_html__('Save Settings', 'wpchatbot'); ?>"/>
                        </div>
                    </div>
                    <!--                    row-->
                </footer>
            </section>
        </div>
        <?php wp_nonce_field('wp_chatbot'); ?>
    </form>

<div class="wpbot-fabs" style="display:none">
  <a id="wpbot-upload" target="_blank" class="wpbot-fab" title="Copy Image Link from Gallery"><i class="fa fa-upload" aria-hidden="true"></i></a>
  <a id="wpbot-giphy" target="_blank" class="wpbot-fab" title="Copy Giphy Image Link"><i class="fa fa-grav" aria-hidden="true"></i></a>
  <a id="wpbot-prime" class="wpbot-fab"><i class="fa fa-picture-o" aria-hidden="true" title="Paste a full Image or Youtube URL inside the ChatBot responses to display them to your users"></i></a>
</div>


<div id="wpbot-giphy-myModal" class="wpbot-giphy-modal">

<!-- Modal content -->
<div class="wpbot-giphy-modal-content">
  <span class="wpbot-giphy-close">&times;</span>
  <iframe src="https://giphy.com/" height="100%" width="100%" style="border:none;min-height: 500px;"></iframe>
</div>

</div>

<script type="text/javascript">

jQuery(document).ready(function($){
// toggleFab();

//Fab click
$('#wpbot-prime').click(function() {
  toggleFab();
});

//Toggle chat and links
function toggleFab() {
  $('.wpbot-prime').toggleClass('wpbot-is-active');
  $('#wpbot-prime').toggleClass('wpbot-is-float');
  $('.wpbot-fab').toggleClass('wpbot-is-visible');
  
}

// Ripple effect
var target, ink, d, x, y;
$(".wpbot-fab").click(function(e) {
  target = $(this);
  //create .ink element if it doesn't exist
  if (target.find(".wpbot-ink").length == 0)
    target.prepend("<span class='wpbot-ink'></span>");

  ink = target.find(".wpbot-ink");
  //incase of quick double clicks stop the previous animation
  ink.removeClass("wpbot-animate");

  //set size of .ink
  if (!ink.height() && !ink.width()) {
    //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
    d = Math.max(target.outerWidth(), target.outerHeight());
    ink.css({
      height: d,
      width: d
    });
  }

  //get click coordinates
  //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
  x = e.pageX - target.offset().left - ink.width() / 2;
  y = e.pageY - target.offset().top - ink.height() / 2;

  //set the position and add class .animate
  ink.css({
    top: y + 'px',
    left: x + 'px'
  }).addClass("wpbot-animate");
});

})

// Get the modal
var modal = document.getElementById("wpbot-giphy-myModal");

// Get the button that opens the modal
var btn = document.getElementById("wpbot-giphy");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("wpbot-giphy-close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>