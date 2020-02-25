<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * @param $type
 * Display wpwBot Icon ball
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
add_action('wp_footer', 'qcld_wp_chatbot_load_footer_html');
function qcld_wp_chatbot_load_footer_html(){
	
	
	
	$qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
	
    if (get_option('disable_wp_chatbot') != 1 && qcld_wp_chatbot_load_controlling() == true) {
        ?>
        
        
        <?php if (get_option('qcld_wb_chatbot_change_bg') == 1) {

            

            if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
                $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
            } else {
                $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
            }
            ?>
            <?php

                

                if($qcld_wb_chatbot_theme=='template-04' || $qcld_wb_chatbot_theme=='template-01' || $qcld_wb_chatbot_theme=='template-00'){
                    $custom_css  =".wp-chatbot-container {                        
                        border-radius: 6px;
                    }
                    .wp-chatbot-content{
                        background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top center !important;
                        background-size: cover !important;
                        border-radius: 5px 5px 0px 0px;
                    }
                    ";
                }else{
                    $custom_css  =".wp-chatbot-container {
                        background-image: url(".esc_url($qcld_wb_chatbot_board_bg_path).") !important;
                        
                    }";
                }

                
                echo '<style type="text/css">'.$custom_css.'</style>';
                wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css );
            ?>
        <?php }
        $wp_chatbot_enable_rtl = "";
        if (get_option('enable_wp_chatbot_rtl')) {
            $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
        }
        $wp_chatbot_enable_mobile_screen = "";
        if (get_option('enable_wp_chatbot_mobile_full_screen')==1 ) {
            $wp_chatbot_enable_mobile_screen .= "wp-chatbot-mobile-full-screen";
        }
        if(get_option('disable_wp_chatbot_floating_icon')==1){
            $hide_class = 'wpbot_hide_floating_icon';
        }else{
            $hide_class = '';
        }
        

        ?>
        <div id="wp-chatbot-chat-container" class="<?php echo esc_html($wp_chatbot_enable_rtl) .' '.esc_html($wp_chatbot_enable_mobile_screen).' '.esc_attr($hide_class); ?> qcchatbot-<?php echo esc_html($qcld_wb_chatbot_theme);?>">



            <div id="<?php echo ($qcld_wb_chatbot_theme=='template-07'?'wp-chatbot-integration-container-07':'wp-chatbot-integration-container'); ?>">

                <div class="wp-chatbot-integration-button-container">
                    <?php if (get_option('enable_wp_chatbot_skype_floating_icon') == 1) { ?>
                        <a href="skype:<?php echo get_option('enable_wp_chatbot_skype_id'); ?>?chat"><span
                                    class="inetegration-skype-btn" title="<?php echo esc_html__('Skype', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
                    <?php if (get_option('enable_wp_chatbot_floating_whats') == 1) { ?>
                        <a href="<?php echo esc_url('https://api.whatsapp.com/send?phone=' . get_option('qlcd_wp_chatbot_whats_num')); ?>"
                           target="_blank"><span class="intergration-whats"
                                                 title="<?php echo esc_html__('WhatsApp', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                    <?php if (get_option('enable_wp_chatbot_floating_viber') == 1) { ?>
                        <a href="<?php echo esc_url('https://live.viber.com/#/' . get_option('qlcd_wp_chatbot_viber_acc')); ?>"
                           target="_blank"><span class="intergration-viber"
                                                 title="<?php echo esc_html__('Viber', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_phone') == 1 && get_option('qlcd_wp_chatbot_phone') != "") { ?>
                        <a href="tel:<?php echo get_option('qlcd_wp_chatbot_phone'); ?>"><span
                                    class="intergration-phone"
                                    title="<?php echo esc_html__('Phone', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
					
					<?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") { ?>
						<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                            <a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo get_option('wp_custom_icon_livechat'); ?>)"></a>
                            

						<?php else: ?>
							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
						<?php endif; ?>
                    <?php } ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
                        <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                                    class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                </div>
            </div>
            <?php
            
            if (class_exists('WooCommerce')){
                global $woocommerce;
                $cart_items_number = $woocommerce->cart->cart_contents_count;
            }else{
                $cart_items_number='';
            }
            //check extended ui is installed then load template from addon.
            if(qcld_wpbot_is_extended_ui_activate() && ($qcld_wb_chatbot_theme=='template-07' || $qcld_wb_chatbot_theme=='template-06')){
                if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                    wp_register_style('qcld-wp-chatbot-style', qcld_chatbot_eui_root_url . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                    wp_enqueue_style('qcld-wp-chatbot-style');
                }
                
                if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                    require_once(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
                } else {
                    echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
                }
            }else{
                // Default template loading path
                if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                    wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                    wp_enqueue_style('qcld-wp-chatbot-style');
                }
    
                if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                    require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
                } else {
                    echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
                }
            }

            

            ?>
            <?php
				
            if (get_option('disable_wp_chatbot_notification') != 1) {
                ?>
                 <?php 
					
                $notification_intent = qcld_wb_chatbot_func_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications_intent'))); 
                
                ?>
                <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container" <?php echo (isset($notification_intent[0]) && $notification_intent[0]!=''?'data-intent="'.$notification_intent[0].'"':''); ?>>
                    <div class="wp-chatbot-notification-controller"> <span class="wp-chatbot-notification-close">
      <?php echo esc_html__('X', 'wpchatbot'); ?>
      </span></div>
                    <?php
                    $testingTip="";
                    if (get_option('wp_chatbot_agent_image') == "custom-agent.png") {
                        $wp_chatbot_custom_agent_path = get_option('wp_chatbot_custom_agent_path');
                    } else if (get_option('wp_chatbot_agent_image') != "custom-agent.png") {
                        $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
                    } else {
                        $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                    }
                    ?>
                    <div class="wp-chatbot-notification-agent-profile">
                        <div class="wp-chatbot-notification-widget-avatar" ><img
                                    src="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>" alt=""></div>
                        <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . get_option('qlcd_wp_chatbot_host') . '</strong>'; ?></div>
                    </div>
                    <?php 
					
					$notifications = qcld_wb_chatbot_func_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications'))); 
					
					?>
					
                    <div class="wp-chatbot-notification-message"><?php echo esc_html($notifications[0]); ?></div>
                </div>
            <?php } ?>
            <!--wp-chatbot-board-container-->
            <div id="wp-chatbot-ball" class="">
                <div class="wp-chatbot-ball">
                    <div class="wp-chatbot-ball-animator wp-chatbot-ball-animation-switch"></div>
                    <?php
                    if (get_option('wp_chatbot_icon') == "custom.png") {
                        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                    } else if (get_option('wp_chatbot_icon') != "custom.png") {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
                    } else {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                    }
                    ?>
                    <img src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"
                         alt="wpChatIcon" qcld_agent="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>">
                    <?php 
                        if(function_exists('qcpd_wpwc_addon_lang_init')){
                            do_action('qcld_wpwc_cart_item_number_woocommerce', $cart_items_number);
                        }

                    ?>
                    

                </div>
            </div>
            <?php
            $fb_app_id = get_option('qlcd_wp_chatbot_fb_app_id');
            $fb_page_id = get_option('qlcd_wp_chatbot_fb_page_id');
            $fb_mgs_color = get_option('qlcd_wp_chatbot_fb_color') != '' ? get_option('qlcd_wp_chatbot_fb_color') : '#0084ff';
            $fb_mgs_in = get_option('qlcd_wp_chatbot_fb_in_msg') != '' ? get_option('qlcd_wp_chatbot_fb_in_msg') : 'You are welcome';
            $fb_mgs_out = get_option('qlcd_wp_chatbot_fb_out_msg') != '' ? get_option('qlcd_wp_chatbot_fb_out_msg') : 'You are not logged in';
            if (get_option('enable_wp_chatbot_messenger') == 1 && get_option('enable_wp_chatbot_messenger_floating_icon') == 1) {
                ?>
                <!--                wp-chatbot-board-container-->

                <?php 
                $script = "window.fbAsyncInit = function () {
                    FB.init({
                        appId: '".esc_html($fb_app_id)."',
                        autoLogAppEvents: true,
                        xfbml: true,
                        version: 'v2.12'
                    });
                };
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = '".esc_url('https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js')."';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
                ";
                wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script ); 
                ?>

                <div class="fb-customerchat"
                     page_id="<?php echo esc_attr($fb_page_id); ?>"
                     greeting_dialog_display="hide"
                     theme_color="<?php echo esc_attr($fb_mgs_color); ?>"
                     logged_in_greeting="<?php echo esc_attr($fb_mgs_in); ?>"
                     logged_out_greeting="<?php echo esc_attr($fb_mgs_out); ?>"></div>
                <?php
            }
            ?>
            <!--container-->
            <!--wp-chatbot-ball-wrapper-->
        </div>
        <audio id="wp-chatbot-proactive-audio" <?php if (get_option('enable_wp_chatbot_sound_initial') == 1) {
            echo "autoplay";
        } ?>>
            <source src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'pro-active.mp3'); ?>">
            </source>
        </audio>
        <?php
    }else{
        ?>

        <?php 
        $script1 = "var openingHourIsFn = 1;";
        wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script1 ); 
        ?>

        <?php
    }
	
	if(get_option('wp_custom_help_icon')!=''){
	?>
    
    <?php 
    $custom_css1 = ".wp-chatbot-tab-nav ul li a[data-option=\"help\"] {
        background-position: center center !important;
        background: url(".esc_url(get_option('wp_custom_help_icon')).") no-repeat !important;
    }";
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css1 );
    ?>


	<?php
	}
	if(get_option('wp_custom_support_icon')!=''){
	?>

    <?php 
    $custom_css2 = ".wp-chatbot-tab-nav ul li a[data-option=\"support\"] {
        background-position: center center !important;
        background: url(".esc_url(get_option('wp_custom_support_icon')).") no-repeat !important;
    }";
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css2 );
    ?>
	<?php
	}
	if(get_option('wp_custom_chat_icon')!=''){
	?>
    
    <?php 
    $custom_css3 = ".wp-chatbot-tab-nav ul li a[data-option=\"chat\"] {
        background-position: center center !important;
        background: url(".esc_url(get_option('wp_custom_support_icon')).") no-repeat !important;
    }";
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css3 );
    ?>

	<?php
    }
    if(get_option('skip_wp_greetings_trigger_intent')==1 && get_option('wpbot_trigger_intent')!=''){
        echo  '<script type="text/javascript">var clickintent = "'.get_option('wpbot_trigger_intent').'"</script>';
    }
    
	
}
//wp_chatbot load control handler.
function qcld_wp_chatbot_load_controlling(){
    $wp_chatbot_load = true;
    
    if (get_option('wp_chatbot_show_home_page') == 'off' && is_home()) {
        $wp_chatbot_load = false;
    }
    // && 'post' == get_post_type()
    if (get_option('wp_chatbot_show_posts') == 'off' && 'page' != get_post_type()) {
        $wp_chatbot_load = false;
    }
    if (get_option('wp_chatbot_show_pages') == 'off') {
        $wp_chatbot_select_pages = unserialize(get_option('wp_chatbot_show_pages_list'));
        if (is_page() && !empty($wp_chatbot_select_pages)) {
            if (in_array(get_the_ID(), $wp_chatbot_select_pages) == true) {
                $wp_chatbot_load = true;
            } else {
                $wp_chatbot_load = false;
            }
        }
    }

    

    if (get_option('wp_chatbot_show_woocommerce') == 'off') {
        if (is_shop() || is_cart() || is_checkout() || 'product' == get_post_type()) {
            $wp_chatbot_load = false;
        }
    }
    //load wpwbot shortcode template and prevent default wpwbot from footer.
    if (is_page()) {
        $page_id = get_the_ID();
        $page = get_post($page_id);
        if (has_shortcode($page->post_content, 'wpwbot')) {
            $wp_chatbot_load = false;
        }
    }

    if (get_option('wp_chatbot_show_home_page') == 'on' && is_front_page()) {
        $wp_chatbot_load = true;
    }

    //Opening Hours for wpwBot.
    if (get_option('enable_wp_chatbot_opening_hour') == 1) {
        if(qcld_wp_chatbot_check_opening_hours()==false){
            $wp_chatbot_load = false;
        }else{
            $wp_chatbot_load = true;
        }
    }

	if (qcld_wp_chatbot_is_mobile() && get_option('disable_wp_chatbot_on_mobile') == 1) {
        $wp_chatbot_load = false;
    }

    if (is_page()){
        $page_id = get_the_ID();
        $exclude_pages = unserialize(get_option('wp_chatbot_exclude_pages_list'));
		if(@in_array($page_id, $exclude_pages)){
			$wp_chatbot_load = false;
		}
    }


	// Disable in post types
    $post_list = unserialize(get_option('wp_chatbot_exclude_post_list'));
    if(is_array($post_list) && get_post_type()!=''){
        if(in_array(get_post_type(), $post_list)){
            $wp_chatbot_load = false;
        }
    }
	
    
    if (is_page('wpwbot-mobile-app')) {
		$wp_chatbot_load = false;
	}
	
    return $wp_chatbot_load;
}
//checking Devices
function qcld_wp_chatbot_is_mobile(){
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return true;
    } else {
        return false;
    }
}
//Checking wpwbot opening hour
function qcld_wp_chatbot_check_opening_hours(){
    $curent_day=strtolower(date('l',strtotime(current_time( 'mysql' ))));
    $current_time=date('H:i',strtotime(current_time( 'mysql')));
    $is_wpwbot_open =false;
    if(get_option('wpwbot_hours')) {
        $wpwbot_times = unserialize(get_option('wpwbot_hours'));
        if (isset($wpwbot_times[$curent_day])) {
            $day_times = $wpwbot_times[$curent_day];
            if (!empty($day_times)) {
                foreach ($day_times as $day_time) {
                    if(strtotime($current_time) > strtotime($day_time[0]) && strtotime($current_time) < strtotime($day_time[1])  ){
                        $is_wpwbot_open=true;
                    }
                }
            }
        }
    }
    return $is_wpwbot_open;
}
//wpwBot shortcode.
add_shortcode('wpwbot', 'qcld_wp_chatbot_short_code');
function qcld_wp_chatbot_short_code($atts = []){
    ob_start();
    qcld_wp_chatbot_shortcode_dom($atts);
    $content = ob_get_clean();
    return $content;
}
//shortcode for skip greetings
add_shortcode('wpbot-skip-gretting', 'qcld_wp_chatbot_skip_gretting');
function qcld_wp_chatbot_skip_gretting($atts = []){
    ob_start();
    $content = ob_get_clean();
    return $content;
}

function qcld_wp_chatbot_shortcode_dom($atts){
    //Defaults & Set Parameters for shortcode

    extract(shortcode_atts(
        array(
            'template' => '01',
        ), $atts
    ));
    
    ?>

        <?php if(get_option('wp_chatbot_custom_css')!=""){
            
            wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', get_option('wp_chatbot_custom_css') );
        } ?>
  
    <?php if (get_option('qcld_wb_chatbot_change_bg') == 1) {
        if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
            $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
        } else {
            $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
        }
        ?>

        <?php 
        $custom_css = ".wp-chatbot-container {
            background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top right !important;
        }";
        wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
        ?>


<?php }
    
    $wp_chatbot_enable_rtl = "";
    if (get_option('enable_wp_chatbot_rtl')) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }
    
    ?>
    <div id="wp-chatbot-chat-container" class="<?php echo esc_html($wp_chatbot_enable_rtl); ?>">
		<div id="wp-chatbot-integration-container">
                <div class="wp-chatbot-integration-button-container">
                    <?php if (get_option('enable_wp_chatbot_skype_floating_icon') == 1) { ?>
                        <a href="skype:<?php echo esc_html(get_option('enable_wp_chatbot_skype_id')); ?>?chat"><span
                                    class="inetegration-skype-btn" title="<?php echo esc_html__('Skype', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
                    
                    <?php if (get_option('enable_wp_chatbot_floating_whats') == 1) { ?>
                        <a href="<?php echo esc_url('https://api.whatsapp.com/send?phone=' . get_option('qlcd_wp_chatbot_whats_num')); ?>"
                           target="_blank"><span class="intergration-whats"
                                                 title="<?php echo esc_html__('WhatsApp', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                    
                    <?php if (get_option('enable_wp_chatbot_floating_viber') == 1) { ?>
                        <a href="<?php echo esc_url('https://live.viber.com/#/' . get_option('qlcd_wp_chatbot_viber_acc')); ?>"
                           target="_blank"><span class="intergration-viber"
                                                 title="<?php echo esc_html__('Viber', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_phone') == 1 && get_option('qlcd_wp_chatbot_phone') != "") { ?>
                        <a href="tel:<?php echo esc_html(get_option('qlcd_wp_chatbot_phone')); ?>"><span
                                    class="intergration-phone"
                                    title="<?php echo esc_html__('Phone', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
					
					<?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") { ?>
						<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo esc_html(get_option('wp_custom_icon_livechat')); ?>)"></a>
						<?php else: ?>
							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
						<?php endif; ?>
                    <?php } ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
                        <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                                    class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                </div>
            </div>
        <?php
        
        global $woocommerce;
        $cart_items_number = $woocommerce->cart->cart_contents_count;

        $qcld_wb_chatbot_theme = 'template-' . $template;

        

        //check extended ui is installed then load template from addon.
        if(qcld_wpbot_is_extended_ui_activate() && ($qcld_wb_chatbot_theme=='template-07' || $qcld_wb_chatbot_theme=='template-06')){
            if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                wp_register_style('qcld-wp-chatbot-style', qcld_chatbot_eui_root_url . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-style');
            }

            if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                require_once(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
            } else {
                echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
            }
        }else{
            // Default template loading path
            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-style');
            }

            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
            } else {
                echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
            }
        }

        ?>
        <?php if (get_option('disable_wp_chatbot') != 1): ?>
            <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container">
                <div class="wp-chatbot-notification-controller"> <span class="wp-chatbot-notification-close">X</span> </div>
                <?php
                if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
                    $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
                } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
                    $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
                } else {
                    $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                }
                ?>
                <div class="wp-chatbot-notification-agent-profile">
                    <div class="wp-chatbot-notification-widget-avatar"><img
                                src="<?php echo esc_html($wp_chatbot_custom_icon_path); ?>" alt=""></div>
                    <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . get_option('qlcd_wp_chatbot_host') . '</strong>'; ?></div>
                </div>
                <div class="wp-chatbot-notification-message"><?php echo qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_notifications'))); ?></div>
            </div>
            <!--wp-chatbot-board-container-->
            <div id="wp-chatbot-ball" class="">
                <div class="wp-chatbot-ball">
                    <div class="wp-chatbot-ball-animator wp-chatbot-ball-animation-switch"></div>
                    <?php
                    if (get_option('wp_chatbot_custom_icon_path') != "" && get_option('wp_chatbot_icon') == "custom.png") {
                        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                    } else if (get_option('wp_chatbot_custom_icon_path') != "" && get_option('wp_chatbot_icon') != "custom.png") {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
                    } else {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                    }
                    ?>
                    <img src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"
                         alt="wpChatIcon"> </div>
            </div>
			<?php
            $fb_app_id = get_option('qlcd_wp_chatbot_fb_app_id');
            $fb_page_id = get_option('qlcd_wp_chatbot_fb_page_id');
            $fb_mgs_color = get_option('qlcd_wp_chatbot_fb_color') != '' ? get_option('qlcd_wp_chatbot_fb_color') : '#0084ff';
            $fb_mgs_in = get_option('qlcd_wp_chatbot_fb_in_msg') != '' ? get_option('qlcd_wp_chatbot_fb_in_msg') : 'You are welcome';
            $fb_mgs_out = get_option('qlcd_wp_chatbot_fb_out_msg') != '' ? get_option('qlcd_wp_chatbot_fb_out_msg') : 'You are not logged in';
            if (get_option('enable_wp_chatbot_messenger') == 1 && get_option('enable_wp_chatbot_messenger_floating_icon') == 1) {
                ?>
                <!--                wp-chatbot-board-container-->
                <?php 
                $script = "window.fbAsyncInit = function () {
                    FB.init({
                        appId: '".esc_html($fb_app_id)."',
                        autoLogAppEvents: true,
                        xfbml: true,
                        version: 'v2.12'
                    });
                };
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = '".esc_url('https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js')."';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
                ";
                wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script ); 
                ?>

                <div class="fb-customerchat"
                     page_id="<?php echo esc_attr($fb_page_id); ?>"
                     greeting_dialog_display="hide"
                     theme_color="<?php echo esc_attr($fb_mgs_color); ?>"
                     logged_in_greeting="<?php echo esc_attr($fb_mgs_in); ?>"
                     logged_out_greeting="<?php echo esc_attr($fb_mgs_out); ?>"></div>
                <?php
            }
            ?>
            <!--                wp-chatbot-board-container-->
        <?php endif; ?>
        <!--container-->
        <!--wp-chatbot-ball-wrapper-->
    </div>
<?php } ?>
<?php
//Create shortcode for wpwBot for pages.
add_shortcode('wpbot-page', 'qcld_wp_chatbot_page_short_code');
function qcld_wp_chatbot_page_short_code($atts = array()){

    extract( shortcode_atts(
		array(
            'intent' => ''
		), $atts
    ));

    ob_start();
    qcld_wp_chatbot_page_dom($intent);
    $content = ob_get_clean();
    return $content;
}
function qcld_wp_chatbot_page_dom($intent){ ?>
    
        <?php if(get_option('wp_chatbot_custom_css')!=""){

            wp_add_inline_style( 'qcld-wp-chatbot-common-style', get_option('wp_chatbot_custom_css') );
    } ?>

    <?php
    //Get woocommerce cart
    global $woocommerce;
    $cart_items_number = $woocommerce->cart->cart_contents_count;
    $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
    $wp_chatbot_enable_rtl = "";
    if (get_option('enable_wp_chatbot_rtl') == 1) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }

    if($qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-07'){
        $qcld_wb_chatbot_theme=='template-01';
    }

    if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.php')) {
        require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.php');
        echo  '<script type="text/javascript">var clickintent = "'.$intent.'"</script>';
    } else {
        echo "<h2>" . esc_html__('No WPBot ShortCode Theme Found!', 'wpchatbot') . "</h2>";
    }
}
//shortcode for wpWBot mobile app
add_shortcode('wpwbot_app', 'qcld_wp_chatbot_mobile_app_short_code');
function qcld_wp_chatbot_mobile_app_short_code(){ ?>
    <?php if(get_option('wp_chatbot_custom_css')!=""){

    wp_add_inline_style( 'qcld-wp-chatbot-common-style', get_option('wp_chatbot_custom_css') );
    } ?>
    <?php if (get_option('qcld_wb_chatbot_change_bg') == 1) {
    if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
        $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
    } else {
        $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
    }
    ?>



<?php 
$custom_css = ".wp-chatbot-container {
    background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top right !important;
}";
wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
?>

<?php }
    $wp_chatbot_enable_rtl = "";
    if (get_option('enable_wp_chatbot_rtl')) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }
    ?>
    <div id="wp-chatbot-chat-app-shortcode-container" class="<?php echo esc_html($wp_chatbot_enable_rtl); ?>">
        <?php
        // keep traking app template.
        $template_app = 'yes';
        //Get woocommerce cart
        global $woocommerce;
        $cart_items_number = $woocommerce->cart->cart_contents_count;
        //Handling shortcode enqeue and remove features part.
        define('wpCOMMERCE', true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('woocommerce', array('jquery'));
        wp_enqueue_script('wc-cart', array('jquery', 'woocommerce'));
        wp_enqueue_script('wc-address-i18n');
        wp_enqueue_script('wc-country-select');
        wp_enqueue_script('wc-checkout', array('jquery', 'woocommerce', 'wc-address-i18n', 'wc-country-select'));
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        // add the action
        if (isset($_GET['from']) && $_GET['from'] == 'app') {
            if (!isset($_COOKIE['from_app'])) {
                setcookie('from_app', 'yes', time() + 3600);
            }
        }
        $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');

        if($qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-07'){
            $qcld_wb_chatbot_theme=='template-01';
        }

        if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
            require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
        } else {
            echo "<h2>" . esc_html__('No WPBot Theme Found!', 'wpchatbot') . "</h2>";
        }
        ?>
    </div>
    <?php
}

/**
 * wpwBot Search keyword product
 */
add_action('wp_ajax_qcld_wb_chatbot_keyword', 'qcld_wb_chatbot_keyword');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_keyword', 'qcld_wb_chatbot_keyword');
function qcld_wb_chatbot_keyword(){
    $keyword = sanitize_text_field($_POST['keyword']);
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    if (get_option('qlcd_wp_chatbot_search_option') == 'standard') {
        $product_orderby = get_option('qlcd_wp_chatbot_product_orderby') != '' ? get_option('qlcd_wp_chatbot_product_orderby') : 'title';
        $product_order = get_option('qlcd_wp_chatbot_product_order') != '' ? get_option('qlcd_wp_chatbot_product_order') : 'ASC';
        //Merging all query together.
        $argu_params = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $product_per_page,
            'orderby' => $product_orderby,
            'order' => $product_order,
            's' => $keyword,
        );
        /******
         *WP Query Operation to get products.*
         *******/
        $product_query = new WP_Query($argu_params);
        $product_num = $product_query->post_count;
        //Getting total product number by string.
        $total_argu = array('post_type' => 'product', 's' => $keyword, 'posts_per_page' => 100);
        $total_query = new WP_Query($total_argu);
        $total_product_num = $total_query->post_count;
        $html = '<div class="wp-chatbot-products-area">';
        $_pf = new WC_Product_Factory();
        //repeating the products
        if ($product_num > 0) {
            $html .= '<ul class="wp-chatbot-products">';
            while ($product_query->have_posts()) : $product_query->the_post();
                $product = $_pf->get_product(get_the_ID());
                if (qcld_wp_chatbot_product_controlling(get_the_ID()) == true) {
                    $html .= '<li class="wp-chatbot-product">';
                    $html .= '<a target="_blank" href="' . get_permalink(get_the_ID()) . '"  wp-chatbot-pid= "' . get_the_ID() . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
                    $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                       <div class="wp-chatbot-product-summary">
                       <div class="wp-chatbot-product-table">
                       <div class="wp-chatbot-product-table-cell">
                       <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
                       <div class="price">' . ($product->get_price_html()) . '</div>';
                    $html .= ' </div>
                       </div>
                       </div></a>
                       </li>';
                }
            endwhile;
            wp_reset_postdata();
            $html .= '</ul>';
            if ($total_product_num > $product_per_page && $product_per_page > 0 ) {
                $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="' . esc_html($keyword) . '" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
            }
        }
        $html .= '</div>';
    } else if (get_option('qlcd_wp_chatbot_search_option') == 'advanced') {
        $result = wpwBot_Search::factory()->search($keyword);
        $products = $result['products'];
        $product_num = count($result['products']);
        $total_product_num = $result['total_products'];
        $more_product_ids = implode(",", $result['more_ids']);
        $html = '<div class="wp-chatbot-products-area">';
        $_pf = new WC_Product_Factory();
        //repeating the products
        if ($product_num > 0) {
            $html .= '<ul class="wp-chatbot-products">';
            foreach ($products as $product) {
                if (qcld_wp_chatbot_product_controlling($product->get_id()) == true) {
                    $html .= '<li class="wp-chatbot-product">';
                    $html .= '<a target="_blank" href="' . get_permalink($product->get_id()) . '" wp-chatbot-pid= "' . esc_html($product->get_id()) . '"  title="' . esc_attr($product->get_title()) . '">';
                    $html .= get_the_post_thumbnail($product->get_id(), 'shop_catalog') . '
                       <div class="wp-chatbot-product-summary">
                       <div class="wp-chatbot-product-table">
                       <div class="wp-chatbot-product-table-cell">
                       <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                       <div class="price">' . ($product->get_price_html()) . '</div>';
                    $html .= ' </div></div></div></a></li>';
                }
            }
            $html .= '</ul>';
            if ($total_product_num > $product_per_page && $product_per_page > 0) {
                $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="' . esc_html($more_product_ids) . '" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
            }
        }
        $html .= '</div>';
    }
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}
/**
 * wpwBot Categories
 */
add_action('wp_ajax_qcld_wb_chatbot_category', 'qcld_wb_chatbot_category');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_category', 'qcld_wb_chatbot_category');
function qcld_wb_chatbot_category(){
    $category_type="common";
    if (get_option('wp_chatbot_show_parent_category') != "") {
        $terms = get_terms('product_cat', array('parent' => 0, 'hide_empty' => true, 'fields' => 'all'));

    } else {
        $terms = get_terms('product_cat', array('hide_empty' => true, 'fields' => 'all'));
    }
    $html = "";
    foreach ($terms as $term) {
        $child_terms=get_terms('product_cat', array('parent' => $term->term_id, 'hide_empty' => true, 'fields' => 'all'));
        if(get_option('wp_chatbot_show_sub_category')==1 && count($child_terms) >0){
            $category_type="hasChilds";
        }
        $html .= '<span class="qcld-chatbot-product-category" data-category-type="' . esc_html($category_type) . '"  data-category-slug="' . esc_html($term->slug) . '" data-category-id="' . esc_html($term->term_id) . '">' . esc_html($term->name) . '</span>';
    }
    echo wp_send_json($html);
    wp_die();
}
/**
 * wpwBot Sub categories
 */
add_action('wp_ajax_qcld_wb_chatbot_sub_category', 'qcld_wb_chatbot_sub_category');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_sub_category', 'qcld_wb_chatbot_sub_category');
function qcld_wb_chatbot_sub_category(){
    $parent_id = stripslashes($_POST['parent_id']);
    $terms = get_terms('product_cat', array('parent' => $parent_id, 'hide_empty' => true, 'fields' => 'all'));
    $html = "";
    foreach ($terms as $term) {
        $html .= '<span class="qcld-chatbot-product-category" data-category-type="common"  data-category-slug="' . esc_html($term->slug) . '" data-category-id="' . esc_html($term->term_id) . '">' . esc_html($term->name) . '</span>';
    }
    echo wp_send_json($html);
    wp_die();
}
/**
 * wpwBot category product
 */
add_action('wp_ajax_qcld_wb_chatbot_category_products', 'qcld_wb_chatbot_category_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_category_products', 'qcld_wb_chatbot_category_products');
function qcld_wb_chatbot_category_products(){
    $category_id = stripslashes($_POST['category']);
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_wp_chatbot_product_orderby') != '' ? get_option('qlcd_wp_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_wp_chatbot_product_order') != '' ? get_option('qlcd_wp_chatbot_product_order') : 'ASC';
    //Merging all query together.
    $argu_params = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby' => $product_orderby,
        'order' => $product_order,
        'posts_per_page' => $product_per_page,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'operator' => 'IN'
            )
        )
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'operator' => 'IN'
            )
        )
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $_pf = new WC_Product_Factory();
    //repeating the products
    $html = '';
    if ($product_num > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . esc_html(get_the_ID()) . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page && $product_per_page >0) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="category" data-search-term="' . esc_html($category_id) . '" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
        $html .= '</div>';
    } else {
        $html = '';
    }
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}
/**
 * wpwBot latest, featured, recent product
 */
add_action('wp_ajax_qcld_wb_chatbot_featured_products', 'qcld_wb_chatbot_featured_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_featured_products', 'qcld_wb_chatbot_featured_products');
function qcld_wb_chatbot_featured_products(){
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_wp_chatbot_product_orderby') != '' ? get_option('qlcd_wp_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_wp_chatbot_product_order') != '' ? get_option('qlcd_wp_chatbot_product_order') : 'ASC';
    //get featured products query.
    $argu_params = array('post_status' => 'publish',
        'posts_per_page' => $product_per_page,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array('post_status' => 'publish',
        'posts_per_page' => 100,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured',),)
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $html = '<div class="wp-chatbot-products-area">';
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . get_the_ID() . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="featured" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
    }
    $html .= '</div>';
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}
//Product display controll
function qcld_wp_chatbot_product_controlling($product_id){
    $display_product = true;
    //Controlling Out of Stock product display from back end.
    $_pf = new WC_Product_Factory();
    $product = $_pf->get_product($product_id);
    if ($product->manage_stock == 'yes' && $product->stock_quantity <= 0 && get_option('wp_chatbot_exclude_stock_out_product') == 1) {
        $display_product = false;
    }
    return $display_product;
}
//Get Sale products
add_action('wp_ajax_qcld_wb_chatbot_sale_products', 'qcld_wb_chatbot_sale_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_sale_products', 'qcld_wb_chatbot_sale_products');
function qcld_wb_chatbot_sale_products(){
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_wp_chatbot_product_orderby') != '' ? get_option('qlcd_wp_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_wp_chatbot_product_order') != '' ? get_option('qlcd_wp_chatbot_product_order') : 'ASC';
    //get sale products query.
    $argu_params = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $product_per_page,
        'meta_query' => array(
            'relation' => 'OR',
            array( // Simple products type
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ),
            array( // Variable products type
                'key' => '_min_variation_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            )
        )
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'meta_query' => array(
            'relation' => 'OR',
            array( // Simple products type
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ),
            array( // Variable products type
                'key' => '_min_variation_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            )
        )
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $html = '<div class="wp-chatbot-products-area">';
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . get_the_ID() . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="sale" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
    }
    $html .= '</div>';
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}

function qcld_wpbot_load_additional_validation_required(){
    
    $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 2 days'));
    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_brand_logo')!=''){
        
        echo '<p class="wpqcld_chk_seft"><a target="_blank" href="#"><img src="'.get_option('wpwl_brand_logo').'"></a></p>';

    }else{
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjsuelsdfj_');
        }
    }
    

}

//load more
add_action('wp_ajax_qcld_wb_chatbot_load_more', 'qcld_wb_chatbot_load_more');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_load_more', 'qcld_wb_chatbot_load_more');
function qcld_wb_chatbot_load_more(){
    $offset = stripslashes($_POST['offset']);
    $search_type = stripslashes($_POST['search_type']);
    $search_term = stripslashes($_POST['search_term']);
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_wp_chatbot_product_orderby') != '' ? get_option('qlcd_wp_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_wp_chatbot_product_order') != '' ? get_option('qlcd_wp_chatbot_product_order') : 'ASC';
    $next_offset = intval($product_per_page + $offset);
    if ($search_type == 'product' && $search_term != 'featured' && $search_term != 'sale' && get_option('qlcd_wp_chatbot_search_option') == 'advanced') {
        //if have multiple ids then explode else have single need to array push
        if (strpos($search_term, ',') !== false) {
            $product_ids = explode(',', $search_term);
        } else {
            $product_ids = array($search_term);
        }
        $result = wpwBot_Search::factory()->get_load_more_products($product_ids);
        $products = $result['products'];
        $product_num = count($result['products']);
        $total_product_num = $result['total_products'];
        $more_product_ids = implode(",", $result['more_ids']);
        $_pf = new WC_Product_Factory();
        //repeating the products
        $html = '';
        if ($product_num > 0) {
            foreach ($products as $product) {
                $html .= '<li class="wp-chatbot-product">';
                $html .= '<a target="_blank" href="' . esc_url(get_permalink($product->get_id())) . '" wp-chatbot-pid= "' . esc_html($product->get_id()) . '"  title="' . esc_attr($product->get_title()) . '">';
                $html .= get_the_post_thumbnail($product->get_id(), 'shop_catalog') . '
               <div class="wp-chatbot-product-summary">
               <div class="wp-chatbot-product-table">
               <div class="wp-chatbot-product-table-cell">
               <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
               <div class="price">' . ($product->get_price_html()) . '</div>';
                $html .= ' </div></div></div></a></li>';
            }
        }
        $response = array('html' => $html, 'product_num' => $total_product_num, 'search_term' => $more_product_ids, 'offset' => $next_offset, 'per_page' => $product_per_page);
    } else {
        if ($search_type == 'product' && $search_term != 'featured' && $search_term != 'sale') {  //For Standard search
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $product_per_page,
                'offset' => $offset,
                'orderby' => $product_orderby,
                'order' => $product_order,
                's' => $search_term,
            );
        } else if ($search_type == 'category') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $search_term,
                        'operator' => 'IN'
                    )
                )
            );
        } else if ($search_type == 'product' && $search_term == 'featured') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'meta_query' => array('key' => '_featured', 'value' => 'yes')
            );
        } else if ($search_type == 'product' && $search_term == 'sale') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'meta_query' => array(
                    'relation' => 'OR',
                    array( // Simple products type
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    ),
                    array( // Variable products type
                        'key' => '_min_variation_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    )
                )
            );
        }
        $product_query = new WP_Query($argu_params);
        $product_num = $product_query->post_count;
        $_pf = new WC_Product_Factory();
        //repeating the products
        $html = '';
        if ($product_num > 0) {
            while ($product_query->have_posts()) : $product_query->the_post();
                $product = $_pf->get_product(get_the_ID());
                $html .= '<li class="wp-chatbot-product">';
                $html .= '<a target="_blank" href="' . esc_url(get_permalink(get_the_ID())) . '"  wp-chatbot-pid= "' . esc_html(get_the_ID()) . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
                $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                   <div class="wp-chatbot-product-summary">
                   <div class="wp-chatbot-product-table">
                   <div class="wp-chatbot-product-table-cell">
                   <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
                   <div class="price">' . ($product->get_price_html()) . '</div>';
                $html .= ' </div>
                   </div>
                   </div></a>
                   </li>';
            endwhile;
            wp_reset_postdata();
        } else {
            $html .= '';
        }
        $response = array('html' => $html, 'product_num' => $product_num, 'search_term' => $search_term, 'offset' => $next_offset, 'per_page' => $product_per_page);
    }
    echo wp_send_json($response);
    wp_die();
}
//product details
add_action('wp_ajax_qcld_wb_chatbot_product_details', 'qcld_wb_chatbot_product_details');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_product_details', 'qcld_wb_chatbot_product_details');
function qcld_wb_chatbot_product_details(){
    $product_id = stripslashes($_POST['wp_chatbot_pid']);
    //Tracking product view from chat board
    qcld_wp_chatbot_view_track_product_by_id($product_id);
    //woocommerce product factory
    $wc_pf = new WC_Product_Factory();
    $product = $wc_pf->get_product($product_id);
    $product_type = $wc_pf->get_product_type($product_id);
    $product_title = '<h2 id="wp-chatbot-product-title" ><a target="_blank" href="' . get_permalink($product->get_id()) . '">' . esc_html($product->get_title()) . '</a></h2>';
    $product_desc = apply_filters('the_excerpt', $product->get_description());
    $gallery_ids = $product->get_gallery_image_ids();
    //images processing..
    $product_feature_image_id = get_post_thumbnail_id($product_id);
    $product_feature_image = wp_get_attachment_image_src($product_feature_image_id, 'full');
    $product_feature_thumb = wp_get_attachment_image_src($product_feature_image_id, 'shop_thumbnail');

    $product_image = '<div class="wp-chatbot-product-image-large">
                     <a href="' . esc_url($product_feature_image[0]) . '" id="wp-chatbot-product-image-large-path"><img id="wp-chatbot-product-image-large-src" src="' . esc_url($product_feature_image[0]) . '" alt="Large Image" title="Zoom Image" /></a>
                      </div>';
    $product_image .= '<div class="wp-chatbot-product-image-thumbs"><ul> 
                      <li class="wp-chatbot-product-active-image-thumbs"><a href="' . esc_url($product_feature_image[0]) . '" class="wp-chatbot-product-image-thumbs-path"><img  class="wp-chatbot-product-image-thumbs-src" src="' . esc_url($product_feature_thumb[0]) . '" alt="Thumb Image" /></a></li>';
    if (!empty($gallery_ids)) {
        foreach ($gallery_ids as $gallery_id) {
            $gallery_image = wp_get_attachment_image_src($gallery_id, 'full');
            $gallery_thumb = wp_get_attachment_image_src($gallery_id, 'shop_thumbnail');
            $product_image .= '<li><a href="' . esc_url($gallery_image[0]) . '" class="wp-chatbot-product-image-thumbs-path"><img class="wp-chatbot-product-image-thumbs-src" src="' . esc_url($gallery_thumb[0]) . '" alt="Thumb Image" /></a></li>';
        }
    }
    $product_image .= '</ul></div>';
    $product_price = '<p class="wp-chatbot-product-price" id="wp-chatbot-product-price">' . ($product->get_price_html()) . '</p>';
    $product_sku = '<p class="wp-chatbot-product-sku"> ' . esc_html__('SKU', 'wpchatbot') . ' : ' . esc_html($product->get_sku()) . '</p>';
    
    //Handle variable product start
    $variations = "";
    $add_cart_button = "";
    $product_quantity = "";
    if ($product->is_in_stock()) {
        if ($product_type == "variable") {
            //Getting product variation number based details
            $variations_data = array();
            foreach ($product->get_children() as $child_id) {
                $all_cfs = get_post_custom($child_id);
                array_push($variations_data, array('variation_id' => $child_id, 'variation_data' => $all_cfs));
            }
            $variations_data = json_encode($variations_data);
            $attributes = $product->get_attributes();
            //Handling Variant & Non Variant products
            $var_attrs = $product->get_variation_attributes();
            $varation_names = array();
            if (!empty($var_attrs)) {
                foreach ($var_attrs as $key => $value) {
                    array_push($varation_names, $key);
                }
            }
            $debug = $varation_names;
            foreach ($attributes as $attribute) {

                $title = wc_attribute_label($attribute['name']);
                $name = $attribute['name'];
                if ($attribute['is_taxonomy']) {
                    $values = wc_get_product_terms($product->get_id(), $attribute['name'], array('fields' => 'slugs'));
                } else {
                    $values = array_map('trim', explode(WC_DELIMITER, $attribute['value']));
                }
                natsort($values);
                if (!in_array($name, $varation_names)) {
                    $variations .= '<p><label for="' . sanitize_title($name) . '">' . esc_html($title) . '</label> ' . ucfirst(implode(",", $values)) . '</p>';
                } else {
                    $variations .= '<div class="wp-chatbot-variable-' . sanitize_title($name) . '">';
                    $variations .= '<label for="' . sanitize_title($name) . '">' . esc_html($title) . '</label>';
                    $variations .= '<select id="' . esc_attr(sanitize_title($name)) . '" name="attribute_' . sanitize_title($name) . '" data-attribute_name="attribute_' . sanitize_title($name) . '" class="each_attribute">';
                    $variations .= '<option value="">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_choose_option'))) . '</option>';
                    foreach ($values as $value) {
                        if (isset($_REQUEST['attribute_' . sanitize_title($name)])) {
                            $selected_value = $_REQUEST['attribute_' . sanitize_title($name)];
                        } else {
                            $selected_value = '';
                        }
                        $variations .= '<option value="' . esc_attr(strtolower($value)) . '"' . selected($selected_value, $value, false) . '>' . apply_filters('woocommerce_variation_option_name', $value) . '</option>';
                    }
                    $variations .= '</select></div>';
                }
            }
            $add_cart_button .= '<input type="button"  id="wp-chatbot-variation-add-to-cart" wp-chatbot-product-id="' . esc_html($product_id) . '" value="' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_add_to_cart'))) . '" variation_id="" />';
            $add_cart_button .= "<input type='hidden'   id='wp-chatbot-variation-data'  data-product-variation='" . esc_html($variations_data) . "' />";
        } else {
            $add_cart_button .= '<input type="button" id="wp-chatbot-add-cart-button" wp-chatbot-product-id="' . esc_html($product_id) . '" value="' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_add_to_cart'))) . '" />';
        }
        //Handle variable product end.
        $product_quantity .= '<label for="">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</label>
       <input type="number" id="vPQuantity" value="1" />';
    }
    
    $response = array('title' => $product_title, 'description' => $product_desc, 'image' => $product_image, 'price' => $product_price, 'sku' => $product_sku, 'quantity' => $product_quantity, 'buttton' => $add_cart_button, 'variation' => $variations, 'type' => $product_type, 'debug' => $debug);
    echo wp_send_json($response);
    wp_die();
}
//Add to cart for variable product.
add_action('wp_ajax_variable_add_to_cart', 'qcld_wb_chatbot_variable_add_to_cart');
add_action('wp_ajax_nopriv_variable_add_to_cart', 'qcld_wb_chatbot_variable_add_to_cart');
function qcld_wb_chatbot_variable_add_to_cart(){
    $product_id = stripslashes($_POST['p_id']);
    $quantity = stripslashes($_POST['quantity']);
    $variations_id = stripslashes($_POST['variations_id']);
    $attrs = stripslashes($_POST['attributes']);
    
    $attributes = array();
    foreach ($attrs as $attr) {
        $single = explode("#", $attr);
        if (isset($single[0])) {
            $a_name = explode("_", $single[0]);
        }
        $attributes[$a_name[2]] = $single[1];
    }
    global $woocommerce;
    $result = $woocommerce->cart->add_to_cart($product_id, $quantity, $variations_id, $attributes, null);
    if ($result != false) {
        echo wp_send_json('variable');
    } else {
        echo wp_send_json('error');
    }
    wp_die();
}
//Add to cart for simple product.
add_action('wp_ajax_qcld_wb_chatbot_add_to_cart', 'qcld_wb_chatbot_add_to_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_add_to_cart', 'qcld_wb_chatbot_add_to_cart');
function qcld_wb_chatbot_add_to_cart(){
    $product_id = stripslashes($_POST['product_id']);
    $product_quantity = stripslashes($_POST['quantity']);
    global $woocommerce;
    $result = $woocommerce->cart->add_to_cart($product_id, $product_quantity);
    if ($result != false) {
        echo wp_send_json('simple');
    } else {
        echo wp_send_json('error');
    }
    wp_die();
}
//Support part
add_action('wp_ajax_qcld_wb_chatbot_support_email', 'qcld_wb_chatbot_support_email');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_support_email', 'qcld_wb_chatbot_support_email');
function qcld_wb_chatbot_support_email(){
    $name = trim(sanitize_text_field($_POST['name']));
    $email = sanitize_email($_POST['email']);
    $message = sanitize_text_field($_POST['message']);
    $subject = get_option('qlcd_wp_chatbot_email_sub') != '' ? get_option('qlcd_wp_chatbot_email_sub') : 'Support Request from WPBOT';
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');
    $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
    $fromEmail = "wordpress@" . $domain;

    if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
        $fromEmail = get_option('qlcd_wp_chatbot_from_email');
    }

    $replyto = $fromEmail;

    if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
        $replyto = get_option('qlcd_wp_chatbot_reply_to_email');
    }

    //Starting messaging and status.
    $response['status'] = 'fail';
    $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_email_fail'));
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $response['message'] = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_invalid_email')));
        $response['status'] = 'fail';
    } else {
        //build email body
        $bodyContent = "";
        $bodyContent .= '<p><strong>' . esc_html__('Support Request Details', 'wpchatbot') . ':</strong></p><hr>';
        $bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html($email) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Subject', 'wpchatbot') . ' : ' . esc_html($subject) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Message', 'wpchatbot') . ' : ' . esc_html($message) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
        $to = $toEmail;
        $body = $bodyContent;
        $headers = array();
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
        $headers[] = 'Reply-To: ' . esc_html($name) . ' <' . esc_html($email) . '>';
        $result = wp_mail($to, $subject, $body, $headers);
        $support_email_to_crm_contact = get_option('wpbot_support_mail_to_crm_contact');
        if($support_email_to_crm_contact){
            do_action( 'qcld_mailing_list_subscription_success', $name, $email );
        }
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_email_sent'));
        }
    }
    
    echo json_encode($response);
    die();
}



add_action('wp_ajax_qcld_wb_chatqcld_wb_chatbot_phone_validate', 'qcld_wb_chatbot_phone_validate');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_phone_validate', 'qcld_wb_chatbot_phone_validate');


function qcld_wb_chatbot_phone_validate(){
    $name = trim(sanitize_text_field($_POST['name']));
    $phone =sanitize_text_field($_POST['phone']);

    $matches = array();
    // returns all results in array $matches
    preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{11}|[0-9]{10}|[0-9]{9}|[0-9]{8}|[0-9]{7}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $phone, $matches);
    $matches = $matches[0];
    if(empty($matches)){
        $response['status'] = 'invalid';
    }else{
        $response['status'] = 'success';

    }
    echo json_encode($response);
    die();

}

//Support Phone
add_action('wp_ajax_qcld_wb_chatbot_support_phone', 'qcld_wb_chatbot_support_phone');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_support_phone', 'qcld_wb_chatbot_support_phone');
function qcld_wb_chatbot_support_phone(){
    
    $name = trim(sanitize_text_field($_POST['name']));
    $phone =sanitize_text_field($_POST['phone']);

    $matches = array();
    // returns all results in array $matches
    preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{11}|[0-9]{10}|[0-9]{9}|[0-9]{8}|[0-9]{7}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $phone, $matches);
    $matches = $matches[0];
    if(empty($matches)){
        $response['status'] = 'invalid';
        $response['message'] = str_replace('\\', '',qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_valid_phone_number'))));

        

        echo json_encode($response);
    }else{
        $phone = $matches[0];

        $subject = 'wpWBot Support Mail Request for Call Back';
        //Extract Domain
        $url = get_site_url();
        $url = parse_url($url);
        $domain = $url['host'];
        
        $admin_email = get_option('admin_email');
        $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
        $fromEmail = "wordpress@" . $domain;

        if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
            $fromEmail = get_option('qlcd_wp_chatbot_from_email');
        }
    
        $replyto = $fromEmail;
    
        if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
            $replyto = get_option('qlcd_wp_chatbot_reply_to_email');
        }

        //Starting messaging and status.
        $response['status'] = 'fail';
        $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_phone_fail'));
            //build email body
            $bodyContent = "";
            $bodyContent .= '<p><strong>' . esc_html__('Support Request Details', 'wpchatbot') . ':</strong></p><hr>';
            $bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Phone', 'wpchatbot') . ' : ' . esc_html($phone) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Subject', 'wpchatbot') . ' : ' . esc_html($subject) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Message', 'wpchatbot') . ' : ' . esc_html__(' Call me at ', 'wpchatbot'). esc_html($phone) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
            $to = $toEmail;
            $body = $bodyContent;
            $headers = array();
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
            $headers[] = 'Reply-To: ' . esc_html($name) . ' <' . esc_html($replyto) . '>';
            $result = wp_mail($to, $subject, $body, $headers);
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_phone_sent'));
            }
        ob_clean();
        echo json_encode($response);
    }
    die();
}
// Order Status part.
add_action('wp_ajax_qcld_wb_chatbot_check_user', 'qcld_wb_chatbot_check_user');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_check_user', 'qcld_wb_chatbot_check_user');
function qcld_wb_chatbot_check_user(){
    global $woocommerce;
    $user_name = trim(sanitize_text_field($_POST['user_name']));
    $response = array();
    $response['message'] = "";
    if (username_exists($user_name)) {
        if (get_option('qlcd_wp_chatbot_order_user') == 'login') {
            $response['status'] = "success";
            $response['message'] .= qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_username_thanks')));
            $response['html'] .= '<p>' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_username_password'))) . '</p>';
        } else if (get_option('qlcd_wp_chatbot_order_user') == 'not_login') {
            $response = qcld_wpbot_get_order_by_username($user_name);
        }
    } else {
        $response['status'] = "fail";
        $response['message'] .= '<strong>' . esc_html($user_name) . '</strong> ' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_username_not_exist')));
    }
    echo wp_send_json($response);
    die();
}
function qcld_wpb_randmom_message_handle($items=array()){
    if(!empty($items)){
        return $items[rand(0, count($items) - 1)];
    }else{
        return '';
    }
    
}
function qcld_wb_chatbot_func_str_replace($messages = array()){
    $refined_mesgses = array();
    if(!empty($messages)){
        foreach ($messages as $message) {
            $refined_msg = str_replace('\\', '', $message);
            array_push($refined_mesgses, $refined_msg);
        }
    }
    return $refined_mesgses;
}
add_action('wp_ajax_qcld_wb_chatbot_login_user', 'qcld_wb_chatbot_login_user');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_login_user', 'qcld_wb_chatbot_login_user');
function qcld_wb_chatbot_login_user(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer('wpwbot-order-nonce', 'security');
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = trim(sanitize_text_field($_POST['user_name']));
    $info['user_password'] = trim(sanitize_text_field($_POST['user_pass']));
    $info['remember'] = true;
    $user_signon = wp_signon($info, false);
    $response = array();
    if (is_wp_error($user_signon)) {
        $response['status'] = "fail";
        $response['message'] = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_password_incorrect')));
    } else {
        $response = qcld_wpbot_get_order_by_username($info['user_login']);
        $response['status'] = "success";
    }
    echo wp_send_json($response);
    die();
}


add_action('wp_ajax_qcld_wb_chatbot_order_status_check', 'qcld_wb_chatbot_order_status_check');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_order_status_check', 'qcld_wb_chatbot_order_status_check');
function qcld_wb_chatbot_order_status_check(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer('wpwbot-order-nonce', 'security');
    // Nonce is checked, get the POST data and sign user on
    $order_email = trim(sanitize_email($_POST['order_email']));
    $order_id = trim(sanitize_text_field($_POST['order_id']));
    $response = array();
    
    //func
    $response['status'] .= "success";
    
    // The query arguments
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_billing_email',
        'meta_value' => $order_email,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'orderby' => 'date',
        'post__in' => array($order_id)
    ));

    $response['order_num'] = count($customer_orders);
    $order_html = '';
    if ($response['order_num'] > 0) {
        $response['message'] .= qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_found')));
        $order_html .= '<div class="wp-chatbot-orders-container">
            <div class="wp-chatbot-orders-header">
                <div class="order-id">' . esc_html__('ID', 'wpchatbot') . '</div> 
                <div class="order-date">' . esc_html__('Date', 'wpchatbot') . ' </div>
                <div class="order-items">' . esc_html__('Items', 'wpchatbot') . '</div>
                <div class="order-status">' . esc_html__('Status', 'wpchatbot') . '</div>
            </div>';
        foreach ($customer_orders as $order) {
            //Formatting order summery
            if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
                $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
                $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
                $order_url = '<a href="' . esc_url($thanks_parmanlink . '?order_id=' . $order->ID) . '" >' . ($order->ID) . '</a>';
            } else {
                $order_url = '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '/view-order/' . $order->ID) . '" target="_blank" >' . $order->ID . '</a>';
            }
            $order_html .= '<div class="wp-chatbot-orders-single">
                <div class="order-id"> ' . ($order_url) . '</div>
                <div class="order-date"> <p>' . (date("m/d/Y", strtotime($order->post_date))) . '</p> </div>
                <div class="order-items">';
            $singleOrder = new WC_Order($order->ID);
            $items = $singleOrder->get_items();
            foreach ($items as $item) {
                $order_html .= '<p>' . ($item["name"]) . ' X ' . ($item["qty"]) . '</p>';
            }
            $order_html .= '</div>
                <div class="order-status">' . (strtoupper(end(explode("-", $order->post_status)))) . '</div>
                
                 </div>';
            $customernote = $singleOrder->get_customer_order_notes();
            if(!empty($customernote)){
                $order_html .= '<div class="qc_order_note">';
                    $order_html .= '<h2>Order Notes</h2>';
                    foreach($customernote as $cnote){
                        $order_html .= '<p>'.esc_html($cnote->comment_content).'</p>';
                    }

                $order_html .= '</div>';
            }
        }
        $order_html .= '</div>';
    } else {
        $response['message'] .= get_option('qlcd_wp_chatbot_sorry') . '!';
        $order_html .= '<p>' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_not_found'))) . '</p>';
    }
    $response['html'] = $order_html;
    
    //func-end

    echo wp_send_json($response);
    die();
}


add_action('wp_ajax_qcld_wb_chatbot_loged_in_user_orders', 'qcld_wb_chatbot_loged_in_user_orders');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_loged_in_user_orders', 'qcld_wb_chatbot_loged_in_user_orders');
function qcld_wb_chatbot_loged_in_user_orders(){
    $current_user = wp_get_current_user();
    $user_name = $current_user->user_login;
    $response = qcld_wpbot_get_order_by_username($user_name);
    echo wp_send_json($response);
    die();
}
/*
* Loading secure data
*/

function qldf_botwp_content($action){
    if(file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH.'/languages/'.$action.'.txt')){
        $data = wp_remote_fopen(QCLD_wpCHATBOT_PLUGIN_URL.'languages/'.$action .'.txt');

        if($action=='themedata'){
            $actionurl = QCLD_theme_BANNER_LANDING;
        }
        if($action=='customservicedata'){
            $actionurl = QCLD_wpCHATBOT_ACTION;
        }
        if($action=='logodata'){
            $actionurl = 'https://www.quantumcloud.com/products/';
        }

        return '<p class="'.QCLD_wpCHATBOT_ACTION_hook.'"><a target="_blank" href="'.$actionurl.'"><img src="'.$data.'" /></a></p>';
    }else{
        return '';
    }
    
}

function qcld_wpbot_get_order_by_username($user_name){
    global $post;
    $response = array();
    $response['status'] .= "success";
    $user = get_user_by('login', $user_name);
    // The query arguments
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'meta_value' => $user->ID,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'orderby' => 'date',
    ));
    $response['order_num'] = count($customer_orders);
    $order_html = '';
    if ($response['order_num'] > 0) {
        $response['message'] .= qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_found')));
        $order_html .= '<div class="wp-chatbot-orders-container">
            <div class="wp-chatbot-orders-header">
                <div class="order-id">' . esc_html__('ID', 'wpchatbot') . '</div> 
                <div class="order-date">' . esc_html__('Date', 'wpchatbot') . ' </div>
                <div class="order-items">' . esc_html__('Items', 'wpchatbot') . '</div>
                <div class="order-status">' . esc_html__('Status', 'wpchatbot') . '</div>
            </div>';
        foreach ($customer_orders as $order) {
            //Formatting order summery
            if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
                $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
                $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
                $order_url = '<a href="' . esc_url($thanks_parmanlink . '?order_id=' . $order->ID) . '" >' . ($order->ID) . '</a>';
            } else {
                $order_url = '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '/view-order/' . $order->ID) . '" target="_blank" >' . $order->ID . '</a>';
            }
            $order_html .= '<div class="wp-chatbot-orders-single">
                <div class="order-id"> ' . ($order_url) . '</div>
                <div class="order-date"> <p>' . (date("m/d/Y", strtotime($order->post_date))) . '</p> </div>
                <div class="order-items">';
            $singleOrder = new WC_Order($order->ID);
            $items = $singleOrder->get_items();
            foreach ($items as $item) {
                $order_html .= '<p>' . ($item["name"]) . ' X ' . ($item["qty"]) . '</p>';
            }
            $order_html .= '</div>
                <div class="order-status">' . (strtoupper(end(explode("-", $order->post_status)))) . '</div>
                
                 </div>';
        }
        $order_html .= '</div>';
    } else {
        $response['message'] .= get_option('qlcd_wp_chatbot_sorry') . '! <strong>' . ($user_name) . '</strong>';
        $order_html .= '<p>' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_order_not_found'))) . '</p>';
    }
    $response['html'] = $order_html;
    return $response;
}
//Recently viewed products

function qc_wpbot_theme_validation_fnc(){

    if(!qcld_wpbot_is_active_white_label()):

        $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjegdsetheme_');
        }

    endif;

}


//keeping id in cookies as
function qcld_wp_chatbot_track_product_view(){
    if (!is_singular('product')) {
        return;
    }
    global $post;
    qcld_wp_chatbot_view_track_product_by_id($post->ID);
}
function qcld_wp_chatbot_view_track_product_by_id($post_id){
    if (empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']))
        $viewed_products = array();
    else
        $viewed_products = (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']);
    if (!in_array($post_id, $viewed_products)) {
        $viewed_products[] = $post_id;
    }
    if (sizeof($viewed_products) > 15) {
        array_shift($viewed_products);
    }
    // Store for session only
    if(function_exists('wc_setcookie')){
        wc_setcookie('wp_chatbot_woocommerce_recently_viewed', implode('|', $viewed_products));
    }
    
}
add_action('template_redirect', 'qcld_wp_chatbot_track_product_view', 20);
//recent view product ajax
add_action('wp_ajax_qcld_wb_chatbot_recently_viewed_products', 'qcld_wb_chatbot_recently_viewed_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_recently_viewed_products', 'qcld_wb_chatbot_recently_viewed_products');
function qcld_wb_chatbot_recently_viewed_products(){
    // Get wpCommerce Global
    $_pf = new WC_Product_Factory();
    //show post per page.
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
    // Get recently viewed product cookies data
    $viewed_products = !empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']) ? (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']) : array();
    $viewed_products = array_filter(array_map('absint', $viewed_products));
    //get featured products if has.
    $featured_products = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))));
    //Getting recently vieew products.
    if (!empty($viewed_products)) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_viewed_product_welcome')));
        $product_query = new WP_Query(array(
            'posts_per_page' => $product_per_page,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
        ));
        //Getting featured products
    } else if ($featured_products->post_count > 0) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_featured_product_welcome')));
        $product_query = $featured_products;
    } else {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
        //Getting recent products
        $product_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'orderby' => 'date', 'order' => 'DESC'));
    }
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . get_option('qlcd_wp_chatbot_agent') . '</div>
            <div class="wp-chatbot-bubble">' . esc_html($wp_chatbot_product_title) . '</div>
            </div>';
    if ($product_query->post_count > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a target="_blank" href="' . get_permalink(get_the_ID()) . '" wp-chatbot-pid= "' . get_the_ID() . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
       <div class="wp-chatbot-product-summary">
       <div class="wp-chatbot-product-table">
       <div class="wp-chatbot-product-table-cell">
       <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
       <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
       </div>
       </div></a>
       </li>';
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        $html .= '</ul></div>';
    } else {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<p class="wpbot_p_align_center">You have no products !';
        $html .= '</div>';
    }
    echo wp_send_json($html);
    die();
}
//Recently viewed product shortcode
add_shortcode('wpwbot_products', 'qcld_wb_chatbot_recently_viewed_shortcode');
function qcld_wb_chatbot_recently_viewed_shortcode(){
    // Get wpCommerce Global
    $_pf = new WC_Product_Factory();
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
    // Get recently viewed product cookies data
    $viewed_products = !empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']) ? (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']) : array();
    $viewed_products = array_filter(array_map('absint', $viewed_products));
    //get featured products if has.
    $featured_products = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))));
    //Getting recently vieew products.
    if (!empty($viewed_products)) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_viewed_product_welcome')));
        $product_query = new WP_Query(array(
            'posts_per_page' => $product_per_page,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
        ));
        //implementing featured products
    } else if ($featured_products->post_count > 0) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_featured_product_welcome')));
        $product_query = $featured_products;
    } else {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
        //Getting recent products
        $product_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'orderby' => 'date', 'order' => 'DESC'));
    }
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . get_option('qlcd_wp_chatbot_agent') . '</div>
            <div class="wp-chatbot-bubble">' . esc_html($wp_chatbot_product_title) . '</div>
            </div>';
    if ($product_query->post_count > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a target="_blank" href="' . get_permalink(get_the_ID()) . '" wp-chatbot-pid= "' . get_the_ID() . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
       <div class="wp-chatbot-product-summary">
       <div class="wp-chatbot-product-table">
       <div class="wp-chatbot-product-table-cell">
       <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
       <div class="price">' . esc_html($product->get_price_html()) . '</div>';
            $html .= ' </div>
       </div>
       </div></a>
       </li>';
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        $html .= '</ul></div>';
    } else {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<p class="wpbot_p_align_center">' . esc_html__('You have no products', 'wpchatbot') . ' !';
        $html .= '</div>';
    }
    return $html;
}
//Show cart for wp chatbot
add_action('wp_ajax_qcld_wb_chatbot_show_cart', 'qcld_wb_chatbot_show_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_show_cart', 'qcld_wb_chatbot_show_cart');
function qcld_wb_chatbot_show_cart(){
    global $woocommerce;
    
    $cart_url = wc_get_cart_url();
    $checkout_url = wc_get_checkout_url();
    
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $cart_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_shopping_cart')));
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . get_option('qlcd_wp_chatbot_agent') . '</div>
            <div class="wp-chatbot-bubble">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_welcome'))) . '</div>
            </div>';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div><div class="qcld-wp-chatbot-cell"></div></div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item= apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title()) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . $woocommerce->cart->get_cart_total() . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a class="wp-chatbot-cart-link" href="' . esc_url($cart_url) . '" target="_blank"  >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a class="wp-chatbot-checkout-link" href="' . esc_url($checkout_url) . '" target="_blank"  >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . esc_html($no_cart_item_msg) . '</p></div>';
        $html .= '</div>';
    }
    $response = array('html' => $html, 'items' => $itemCount);
    echo wp_send_json($response);
    wp_die();
}
//cart onley for wp chatbot
add_action('wp_ajax_qcld_wb_chatbot_only_cart', 'qcld_wb_chatbot_only_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_only_cart', 'qcld_wb_chatbot_only_cart');
function qcld_wb_chatbot_only_cart(){
    global $woocommerce;
    
    $cart_url = wc_get_cart_url();
    $checkout_url = wc_get_checkout_url();
   
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));

    $html = '';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div><div class="qcld-wp-chatbot-cell"></div></div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item= apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title()) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . esc_html($woocommerce->cart->get_cart_total()) . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a class="wp-chatbot-cart-link" href="' . $cart_url . '" target="_blank"  >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a class="wp-chatbot-checkout-link" href="' . esc_url($checkout_url) . '" target="_blank"  >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . $no_cart_item_msg . '</p></div>';
        $html .= '</div>';
    }
    $response = array('html' => $html, 'items' => $itemCount);
    echo wp_send_json($response);
    wp_die();
}

add_shortcode('wpbot-click-chat', 'qcld_wp_chatbot_chat_link');

function qcld_wp_chatbot_chat_link($atts = array()){
    extract( shortcode_atts(
		array(
            'text' => 'Click to Chat',
            'bot_visibility' => 'show',
            'intent' => '',
            'display_as'=> 'link',
            'bgcolor'=>'',
            'textcolor'=> ''
		), $atts
    ));
    
    $addclass = '';
    if($display_as =='button'){
        $addclass = 'qc_click_to_button';
    }

    $html =  '<span class="qc_wpbot_chat_link '.$addclass.'" data-intent="'.$intent.'">'.$text.'</span>';

    $html .='<style type="text/css">';
    if($bot_visibility=='hide'){
        $html .= '#wp-chatbot-chat-container{display:none}.fb_dialog{display:none !important}';        
    }
    if($bgcolor!=''){
        $html .= '.qc_wpbot_chat_link{background-color: '.$bgcolor.' !important}';        
    }
    if($textcolor!=''){
        $html .= '.qc_wpbot_chat_link{color: '.$textcolor.' !important}';        
    }
    $html .='</style>';
    return $html;
}

//Cart show Shortcode
add_shortcode('wpwbot_cart', 'qcld_wb_chatbot_cart_shortcode');
function qcld_wb_chatbot_cart_shortcode(){
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $cart_title = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_shopping_cart')));
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . get_option('qlcd_wp_chatbot_agent') . '</div>
            <div class="wp-chatbot-bubble">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_welcome'))) . '</div>
            </div>';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div> <div class="qcld-wp-chatbot-cell"></div> </div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item = apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title()) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . esc_html($woocommerce->cart->get_cart_total()) . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a href="' . site_url() . '/cart" target="_blank" >' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a href="' . site_url() . '/checkout" target="_blank">' . qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . esc_html($no_cart_item_msg) . '</p></div>';
        $html .= '</div>';
    }
    
    return $html;
}
//Updating the cart items.
add_action('wp_ajax_qcld_wb_chatbot_update_cart_item_number', 'qcld_wb_chatbot_update_cart_item_number');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_update_cart_item_number', 'qcld_wb_chatbot_update_cart_item_number');
function qcld_wb_chatbot_update_cart_item_number(){
    //getting cart items n
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $qnty = sanitize_text_field($_POST['qnty']);
    global $woocommerce;
    $result = $woocommerce->cart->set_quantity($cart_item_key, $qnty);
    echo wp_send_json($result);
    wp_die();
}
//Show item after removing from cart page.
add_action('wp_ajax_qcld_wb_chatbot_cart_item_remove', 'qcld_wb_chatbot_cart_item_remove');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_cart_item_remove', 'qcld_wb_chatbot_cart_item_remove');
function qcld_wb_chatbot_cart_item_remove(){
    //getting cart items n
    $cart_item_key = sanitize_text_field($_POST['cart_item']);
    global $woocommerce;
    $result = $woocommerce->cart->remove_cart_item($cart_item_key);
    echo wp_send_json($result);
    wp_die();
}
//Show cart page by shortcode.
add_action('wp_ajax_qcld_wb_chatbot_cart_page', 'qcld_wb_chatbot_cart_page');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_cart_page', 'qcld_wb_chatbot_cart_page');
function qcld_wb_chatbot_cart_page(){
    global $woocommerce;
    $itemCount = $woocommerce->cart->cart_contents_count;
    $html = "";
    if ($itemCount < 0) {
        $html .= qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    } else {
        $html .= do_shortcode("[woocommerce_cart]");
    }
    echo wp_send_json($html);
    wp_die();
}
//Show checkout page by shortcode.
add_action('wp_ajax_qcld_wb_chatbot_checkout_page', 'qcld_wb_chatbot_checkout_page');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_checkout_page', 'qcld_wb_chatbot_checkout_page');
function qcld_wb_chatbot_checkout_page(){
    global $woocommerce;
    $itemCount = $woocommerce->cart->cart_contents_count;
    $html = "";
    if ($itemCount < 0) {
        $status = 'no';
        $html .= qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    } else {
        $status = 'yes';
        $checkout_page_id = get_option('wp_chatbot_app_checkout');
        $checkout_parmanlink = esc_url(get_permalink($checkout_page_id));
        $html .= $checkout_parmanlink;
    }
    $response = array('status' => $status, 'html' => $html);
    echo wp_send_json($response);
    wp_die();
}
//User login on Checkout page.
add_action('wp_ajax_qcld_wb_chatbot_checkout_user_login', 'qcld_wb_chatbot_checkout_user_login');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_checkout_user_login', 'qcld_wb_chatbot_checkout_user_login');
function qcld_wb_chatbot_checkout_user_login(){
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    
    $info['user_login'] = trim(sanitize_text_field($_POST['user_name']));
    $info['user_password'] = trim(sanitize_text_field($_POST['user_pass']));
    $info['remember'] = true;
    $user_signon = wp_signon($info, false);
    $response = array();
    if (is_wp_error($user_signon)) {
        
        $response = "no";
    } else {
        $response = "yes";
    }
    echo wp_send_json($response);
    die();
}

//User session count
add_action('wp_ajax_qcld_wb_chatbot_session_count', 'qcld_wb_chatbot_session_count');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_session_count', 'qcld_wb_chatbot_session_count');
function qcld_wb_chatbot_session_count(){
    // Nonce is checked, get the POST data and sign user on
    global $wpdb;
    $wpdb->show_errors = true;
    $tableuser    = $wpdb->prefix.'wpbot_sessions';
    $response = array();
    

    $session_exists = $wpdb->get_row("select * from $tableuser where 1 and id = '1'");
		if(empty($session_exists)){
			$wpdb->insert(
				$tableuser,
				array(
					'session'   => 1,
				)
			);
		}else{

			$session_id = $session_exists->id;
			$wpdb->update(
				$tableuser,
				array(
					'session'=>($session_exists->session+1),
				),
				array('id'=>$session_id),
				array(
					'%d',
				),
				array('%d')
			);
		}
	
    echo wp_send_json($response);
    die();
}


// Load template for App Order Thank You page url
function qcld_wp_chatbot_load_app_template($template){
    if (is_page('wpwbot-mobile-app')) {
        return dirname(__FILE__) . '/templates/app-templates/app.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_template', 99);
// Load template for App Order Thank You page url
function qcld_wp_chatbot_load_app_order_thankyou_template($template){
    if (is_page('wpwbot-app-order-thankyou')) {
        return dirname(__FILE__) . '/templates/app-templates/app-order-thankyou.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_order_thankyou_template', 99);
// Load template for App checkout
function qcld_wp_chatbot_load_app_checkout_template($template){
    if (is_page('wpwbot-app-checkout')) {
        return dirname(__FILE__) . '/templates/app-templates/app-checkout.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_checkout_template', 99);
// Create embed page when plugin install or activate

add_action('init', 'qcld_wp_chatbot_create_app_checkout_thankyou_page');
function qcld_wp_chatbot_create_app_checkout_thankyou_page(){
    
    //Keep tracking from App by cookies
    if (isset($_GET['from']) && $_GET['from'] == 'app') {
        if (!isset($_COOKIE['from_app'])) {
            setcookie('from_app', 'yes', (time() + 3600), '/');
        }
    }
}
/***
 * Override order Thank page for mobile app
 */
add_action('woocommerce_thankyou', 'qcld_wb_chatbot__redirect_after_purchase', 10, 1);
function qcld_wb_chatbot__redirect_after_purchase($order_get_id){
    if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
        global $wp;
        if (is_checkout() && !empty($wp->query_vars['order-received'])) {
            $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
            $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
            wp_redirect($thanks_parmanlink . '?order_id=' . $order_get_id);
            exit;
        }
    } else {
        remove_action('woocommerce_thankyou', 'qcld_wb_chatbot__redirect_after_purchase');
        //do_action('woocommerce_thankyou', $order_get_id);
    }
}

/* is operator online */

function wpbot_get_users(){
		
    $data = get_option('wbca_options');
    
    if(@$data['admin_able_to_chat']=='1'){
        $roles = array('operator', 'administrator');
    }else{
        $roles = array('operator');
    }
    
    
    $users = array();
    foreach($roles as $role){
        $current_user_role = get_users( array('role'=> $role));
        $users = array_merge($current_user_role, $users);
    }
    return $users;
}




function qcld_wpbot_is_operator_online(){

    global $wpdb;
    $operator = array();
    
    if(qcld_wpbot_is_active_livechat()){

        $users = wpbot_get_users();
        $data = get_option('wbca_options');
        $blogtime = strtotime(current_time( 'mysql' ));
        foreach ( $users as $user ) {
            $meta = strtotime(get_user_meta($user->ID, 'wbca_login_time', true));
            $user_status = get_user_meta($user->ID, 'wbca_login_status', true);
            $interval  = abs($blogtime - $meta);
            $minutes   = round($interval / 60);
            if($minutes <= 5){
                array_push($operator, $user->ID);
            }
    
        }
        if(!empty($operator)){
            return 1;
        }else {
            if(isset($data['always_allow_livechat']) && $data['always_allow_livechat']==true){
                return 1;
            }else{
                return 0;
            }
            
        }

    }else{

        return 0;

    }



}

/* livechat addon check */
function qcld_wpbot_is_active_livechat(){
    if(class_exists('wbca_Apps')){
        return true;
    }else{
        return false;
    }
	
}

/* Extended ui check */

function qcld_wpbot_is_extended_ui_activate(){
    if(function_exists('qcpd_wpeui_dependencies')){
        return true;
    }else{
        return false;
    }
}


/* WPBot Chat History Addon check */
function qcld_wpbot_is_active_chat_history(){

    if(function_exists('qcwp_chat_session_menu_fnc')){
        return true;
    }else{
        return false;
    }

}

/* WPBot Post Type Search Addon check */
function qcld_wpbot_is_active_post_type_search(){

    if(class_exists('wbpt_Admin_Area_Controller')){
        return true;
    }else{
        return false;
    }    
	
}

/* WPBot white label Addon check */
function qcld_wpbot_is_active_white_label(){
	if(class_exists('wbwl_Admin_Area_Controller')){
        return true;
    }else{
        return false;
    }  

}

function wpbot_License_page_callback_func(){
    ob_start();
    wp_enqueue_script('qcld-wp-chatbot-license-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/license.js', array('jquery'), true);
    wp_enqueue_style('qcld-wp-chatbot-help-page-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/help-page.css');
    
    ?>

<div class="wrap swpm-admin-menu-wrap">
		
        <?php wpbotpro_display_license_section(); ?>

        <div class="qcld-wpbot-help-section">
            <h1>Welcome to the <?php echo wpbot_text(); ?> Pro! You are awesome, by the way <img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/11/svg/1f642.svg"></h1>
            <div class="qcld-wpbot-section-block">
                <h2>Shortcode for Widget</h2>
                <p><b>[chatbot-widget]</b></p>
                    <p>If you want to add the Bot as like widget then please add the above shortcode anywhere in the page. It will display like widget. <br><b>Please Note -</b> The WPBot bot icon would not load on that page you have added the above shortcode.</p>
                <p>Available Parameter: width, intent</p>
                <p><b>width</b>: This parameter allow you to specify the widget width. Default value: 400px. You can also use percentage instead of pixel<br>
                Ex: [chatbot-widget width="400px"]
                </p>
                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback, <?php echo qc_dynamic_intent(); ?>
                <br>Ex: [chatbot-widget intent="Request Callback"]
                </p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2>Shortcode for Click to Chat</h2>
                <p><b>[wpbot-click-chat text="Click to Chat"]</b></p>
                <p><b>Available Parameters: text, bot_visibility, intent, display_as, bgcolor, textcolor</b></p>
                <p><b>text</b>: This is for the button text. Value for this option would be a text that will be automatically linked to open the ChatBot.<br>Ex: [wpbot-click-chat text="Click to Chat"]</p>
                <p><b>bot_visibility</b>: This is show or hide bot floating icon. Available values: show, hide. Default value is "show".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide"]</p>
                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback, <?php echo qc_dynamic_intent(); ?>
                <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription"]
                </p>
                <p><b>display_as</b>: This parameter can control the appearence. Available values: button, link. Default value is "link".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" display_as="button"]</p>
                <p><b>bgcolor</b>: You can set the background color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9"]</p>
                <p><b>textcolor</b>: You can set the text color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9" textcolor="#fff"]</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2>Show Bot on a Page</h2>
                <b>[wpbot-page]</b> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                <p>Available Parameter: intent</p>
                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback, <?php echo qc_dynamic_intent(); ?>
                <br>Ex: [wpbot-page intent="Send Us Email"]
                </p>
            </div>
                

            <div class="qcld-wpbot-section-block">
                <h2>Language Settings</h2>
                <p><strong style="font-weight:bold;">1.</strong> You can use this variable for user name: %%username%%</p>
                <p><strong style="font-weight:bold;">2.</strong> Insert full link to an image to show in the chatbot responses like https://www.quantumcloud.com/wp/sad.jpg</p>
                <p><strong style="font-weight:bold;">3.</strong> Insert full link to an youtube video to show in the chatbot responses like https://www.youtube.com/watch?v=gIGqgLEK1BI</p>
                <p><strong style="font-weight:bold;">4.</strong> After making changes in the language center or settings, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                <p><strong style="font-weight:bold;">5.</strong> You could use &lt;br&gt; tag in Language Center & Dialogflow Responses for line break.</p>
            </div>

		</div>
		
		
</div>

    <?php
    $content = ob_get_clean();
    echo $content;
}



/*
 *
 * Widget Shortcode
 */

function qc_wpbot_theme_chatbot_shortcode($atts = array())
{

    // Attributes

    extract( shortcode_atts(
		array(
            'width' => '400px',
            'intent'=> ''
		), $atts
	));


    wp_enqueue_style('qcld-wp-chatbot-widget-css');
    ob_start();
    ?>

    <div id="wp-chatbot-shortcode-template-container"
         class="chatbot-theme-shortcode-container">
        <div class="wp-chatbot-container">
            <div class="wp-chatbot-ball-inner wp-chatbot-content">
                <div class="wp-chatbot-messages-wrapper">
                    <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
                    </ul>
                </div>
                <!--wp-chatbot-messages-wrapper-->
            </div>
            <!--wp-chatbot-ball-inner-->
            <div class="wp-chatbot-footer">
                <div id="wp-chatbot-editor-area" class="wp-chatbot-editor-area">
                    <input id="wp-chatbot-editor" class="wp-chatbot-editor" required=""
                           placeholder="<?php _e('Send a message', 'assistent'); ?>"
                    >
                    <button type="button" id="wp-chatbot-send-message"
                            class="wp-chatbot-button"><?php _e('send', 'assistent'); ?></button>
                </div>
                <!--wp-chatbot-editor-container-->
            </div>
            <!--wp-chatbot-footer-->
        </div>
        <!--wp-chatbot-container-->
    </div>
    <!--wp-chatbot-ball-container-->
    <?php
    echo  '<script type="text/javascript">var clickintent = "'.$intent.'"</script>';
    echo '<style type="text/css"> .chatbot-theme-shortcode-container{max-width: '.$width.' !important;} </style>';
    $content = ob_get_clean();
    return $content;
}
add_shortcode('chatbot-widget', 'qc_wpbot_theme_chatbot_shortcode');
function qcld_wpbot_field_valudation_df(){

    //checking date
    if(!qcld_wpbot_is_active_white_label()){
        $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjegdselsdfj_');
        }
    }
   
    
}

function wpbot_menu_text(){

    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_word_wpbot_pro')!=''){
        return get_option('wpwl_word_wpbot_pro');
    }else{
        return 'Chatbot Pro';
    }

}

function wpbot_text(){

    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_word_wpbot')!=''){
        return get_option('wpwl_word_wpbot');
    }else{
        return 'Chatbot';
    }

}

add_action('init', 'qcwp_email_subscription_delete');
function qcwp_email_subscription_delete(){

    global $wpdb;
    $table             = $wpdb->prefix.'wpbot_subscription';
    if(isset($_POST['wpbot_email_subscription_remove']) && !empty($_POST['emails'])){
        $emails = $_POST['emails'];
        foreach($emails as $id){
            do_action( 'qcld_mailing_list_unsubscription_by_admin', $id, $table );
            $wpdb->delete(
				"$table",
				array( 'id' => $id ),
				array( '%d' )
			);
        }
        wp_redirect(admin_url( 'admin.php?page=email-subscription&msg=success'));exit;
    }

}

function qcld_wpbot_modified_keyword($keyword){
    $keyword = rtrim($keyword, '!');
    $pattern = '/[?\/]/';
    $strings = preg_split( $pattern, $keyword );
    $strings = array_filter(array_map('trim', $strings));
    $keyword = rtrim($strings[0], '!');
    return htmlspecialchars_decode($keyword);
}

function qcld_choose_random($array){
    return $array[array_rand($array)];
}


function qc_get_formbuilder_forms(){
    global $wpdb;
    $forms = array();
    if(class_exists('Qcformbuilder_Forms_Admin')){
        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
        if(!empty($results)){
            foreach($results as $result){
                $form = unserialize($result->config);
                $forms[] = trim($form['name']);
            }
            return $forms;
        }else{
            return array();   
        }
    }else{
        return array();
    }
}

function qc_get_formbuilder_form_commands(){
    global $wpdb;
    $command = array();
    if(class_exists('Qcformbuilder_Forms_Admin')){
        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
        if(!empty($results)){
            foreach($results as $result){
                $form = unserialize($result->config);
                
                $command[] = (isset($form['command'])?trim($form['command']):'');
                
                
            }
            return $command;
        }else{
            return array();   
        }
    }else{
        return array();
    }
}

function qc_get_formbuilder_form_ids(){
    global $wpdb;
    $forms = array();
    if(class_exists('Qcformbuilder_Forms_Admin')){
        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
        if(!empty($results)){
            foreach($results as $result){
                $form = unserialize($result->config);
                $forms[] = trim($form['ID']);
            }
            return $forms;
        }else{
            return array();   
        }
    }else{
        return array();
    }
}

function qc_is_formbuilder_active(){

    if(class_exists('Qcformbuilder_Forms_Admin')){
        return true;
    }else{
        return false;
    }

}

function qc_dynamic_intent(){
    global $wpdb;
    $intents = array();
 
    $ai_df = get_option('enable_wp_chatbot_dailogflow');
    $custom_intent_labels = unserialize( get_option('qlcd_wp_custon_intent_label'));
    if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):

        foreach($custom_intent_labels as $custom_intent_label):
            $intents[] = $custom_intent_label;
        endforeach;
        
    endif;

    

    if(class_exists('Qcformbuilder_Forms_Admin')){
        

        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
        if(!empty($results)){

            foreach($results as $result){
                $form = unserialize($result->config);
                $intents[] = $form['name'];
            }

        }
    }
    
    if(!empty($intents)){
        return implode(", ", $intents);
    }else{
        return '';
    }

}

function qc_get_all_intents(){

    $array = array();
    $array['predefined'] = array(
        'Faq',
        'Email Subscription',
        'Site Search',
        'Send Us Email',
        'Leave A Feedback',
    );

    if(function_exists('qcpd_wpwc_addon_lang_init')){
        $array['woocommerce'] = array(
            'Product Search',
            'Catalog',
            'Featured Products',
            'Products on Sale',
            'Order Status',
        );
    }

    $custom = qc_dynamic_intent();
    if($custom!=''){

        $array['custom'] = explode(',', $custom);

    }

    return $array;

}