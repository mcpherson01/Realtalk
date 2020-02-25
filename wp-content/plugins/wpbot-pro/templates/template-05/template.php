<div id="wp-chatbot-ball-container"  class=" wp-chatbot-<?php echo esc_html($qcld_wb_chatbot_theme);?>">
    <div class="wp-chatbot-container">
        <?php 
            if(function_exists('qcpd_wpwc_addon_lang_init')){
                do_action('qcld_wpwc_product_details_woocommerce');
            }

        ?>
        <!--        wp-chatbot-product-container-->
        <div id="wp-chatbot-board-container" class="wp-chatbot-board-container">

            <!--wp-chatbot-header-->
            <div class="wp-chatbot-ball-inner wp-chatbot-content">
                <!-- only show on Mobile app -->
                <?php if(isset($template_app) && $template_app=='yes'){?>
                    <div class="wp-chatbot-cart-checkout-wrapper">
                        <div id="wp-chatbot-cart-short-code">
                        </div>
                        <div id="wp-chatbot-checkout-short-code">
                        </div>
                    </div>
                <?php } ?>
                <div class="wp-chatbot-messages-wrapper">
                    <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
                    </ul>
                </div>
            </div>
            <div class="wp-chatbot-footer">
                <div id="wp-chatbot-editor-container" class="wp-chatbot-editor-container">
                    <input id="wp-chatbot-editor" class="wp-chatbot-editor" required placeholder="<?php echo qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))); ?>"
                           >
                    <button type="button" id="wp-chatbot-send-message" class="wp-chatbot-button"><?php echo esc_html__('send', 'wpchatbot'); ?></button>
                </div>
                <!--wp-chatbot-editor-container-->
                <div class="wp-chatbot-tab-nav">

					<ul>
						<li class="wp-chatbot-operation-active">
							<a class="wp-chatbot-operation-option wp-chatbot-tpl-4-chat-trigger" data-option="chat" href="">CHAT</a>
						</li>
                        <?php if(get_option('enable_wp_chatbot_disable_helpicon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="help" href=""></a></li>
                        <?php endif; ?>
                        
                        <?php if(get_option('enable_wp_chatbot_disable_supporticon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="support"  href=""></a></li>
                        <?php endif; ?>
                        <?php 
                            if(function_exists('qcpd_wpwc_addon_lang_init')){
                                do_action('qcld_wpwc_template_bottom_icon_woocommerce', $cart_items_number);
                            }

                        ?>
                    </ul>
                </div>
                <!--wp-chatbot-tab-nav-->
            </div>
            <!--wp-chatbot-footer-->
        </div>
        <!--        wp-chatbot-board-container-->
    </div>
</div>


<?php 
$script = "jQuery(document).ready(function () {
    jQuery('body').on('click', function (event) {
        
        if (jQuery(event.target).hasClass('wp-chatbot-tpl-4-chat-trigger') || jQuery(event.target).hasClass('wp-chatbot-editor')) {
            if (jQuery(event.target).hasClass('wp-chatbot-tpl-4-chat-trigger')){ event.preventDefault();}
            jQuery('.wp-chatbot-tab-nav').hide();
            jQuery('.slimScrollDiv').show();
            
        } else {
            jQuery('.wp-chatbot-tab-nav').show();
        }
    });

    jQuery('body').on('click', '.wp-chatbot-tab-nav ul li a', function (event) {
        jQuery('.slimScrollDiv').show();
    });


    jQuery(document).on('click', '#wp-chatbot-ball', function () {

        if(jQuery(this).hasClass('chat_active')){
            jQuery('#wp-chatbot-chat-container').css({
                    'transform': 'translateX(274px)'
            })
            jQuery(this).removeClass('chat_active');
        }else{
            jQuery('#wp-chatbot-chat-container').css({
                'transform': 'translateX(0px)'
            })
            jQuery(this).addClass('chat_active');
        }
        setTimeout(function(){
            wp_fbicon_position();
        },1000)
    })

    setTimeout(function () {
        if(jQuery('#wp-chatbot-ball').length>0){
        
            var pos = jQuery('#wp-chatbot-ball').offset();
            
            jQuery('.fb_dialog').css({
                'left': parseInt(parseInt(pos.left) - 30) + 'px',
                'top': parseInt(parseInt(pos.top) + 10) + 'px',
                'visibility': 'visible'
            });
            
        }
    }, 3030);

});

function wp_fbicon_position(){
    if(jQuery('#wp-chatbot-ball').length>0){
        
        var pos = jQuery('#wp-chatbot-ball').offset();
        
        jQuery('.fb_dialog').css({
            'left': parseInt(parseInt(pos.left) - 30) + 'px',
            'top': parseInt(parseInt(pos.top) + 10) + 'px',
            'visibility': 'visible'
        });
        
    }

}
";
wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script ); 
?>