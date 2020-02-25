<?php // Display Shortcode on Embedder Post Edit Page
function display_vidseo_shortcode() {

    $screen = get_current_screen();

    $post_id = get_the_ID();
    $post_status = get_post_status ( $post_id );

    

    if ( $post_status == 'publish' ) {

        $vidseo_width = get_post_meta( $post_id, 'vidseo_width', true );

        if ( $screen->base == 'post' && $screen->post_type == 'vidseo' ) {

            $output = "";

            $output .= '<input type="text" value=\'[vidseo id="'.$post_id.'"';
            
            (isset($vidseo_width) && !empty($vidseo_width)) ? $output .= ' width="' . $vidseo_width . '"' : "";

            $output .= ']\' style="width: 100%; padding: 10px; font-size: 24px; margin: 10px 0;" readonly>';

            echo $output;
        }

    }  
    
}



add_action( 'edit_form_top', 'display_vidseo_shortcode');

// FIELD ON POST TYPE
add_action( 'add_meta_boxes', 'vidseo_post_options', 1 );
function vidseo_post_options() {
        add_meta_box(
            'vidseo_post_options', // id, used as the html id att
            __( 'Video SEO', 'vidseo' ), // meta box title
            'vidseo_post_func', // callback function, spits out the content
            'vidseo', // post type or page. This adds to posts only
            'normal', // context, where on the screen
            'high' // priority, where should this go in the context
        );
}

function vidseo_post_func ( $post ) {

	global $wpdb;
    $vidseo_url = get_post_meta($post->ID, 'vidseo_url', true);

    $vidseo_content = get_post_meta($post->ID, 'vidseo_content', true);
    
    $vidseo_host = get_post_meta($post->ID, 'vidseo_host', true);


    // purchase notification
    $purchase_url = "options-general.php?page=vidseo-pricing";
    $get_pro = sprintf( wp_kses( __( '<a href="%s">Get Pro version</a> to enable', 'vidseo' ), array(
        'a' => array(
        'href'   => array(),
        'target' => array(),
    ),
    ) ), esc_url( $purchase_url ) );
	
	?>
   

	<div class="misc-pub-section misc-pub-section-last"><span id="timestamp">

    
    <?php if ( isset($vidseo_content) && !empty($vidseo_content) && vidseo_fs()->can_use_premium_code__premium_only())  { ?>

    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="vidseo_text"><?php echo  esc_html__( 'Transcription Text:', 'vidseo' ); ?></label></p>
        
        <textarea name="vidseo_content" rows="4" class="vidseo-area"><?php if ( !empty($vidseo_content) ) echo $vidseo_content; ?></textarea>

        <div class="vidseo-alert vidseo-info">
            <?php echo __("You're using Pro version of VidSEO. Just migrate Transcription Text in Visual Editor above and leave this textarea empty.", "vidseo"); ?>
        </div>

    <?php }
    
    if ( !vidseo_fs()->can_use_premium_code__premium_only())  { ?>

        <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="vidseo_text"><?php echo  esc_html__( 'Transcription Text:', 'vidseo' ); ?></label></p>

        <textarea name="vidseo_content" rows="4" class="vidseo-area"><?php if ( !empty($vidseo_content) ) echo $vidseo_content; ?></textarea>

        <div class="vidseo-alert vidseo-info">
            <span class="closebtn">&times;</span>
            <?php echo $get_pro . " " . sprintf( wp_kses( __( 'Visual & HTML editor along with other awesome features, <a href="%s" target="_blank">Like this</a>', 'vidseo' ), array( 
            'a' => array( 
                'href' => array(), 
                'target' => array(), 
            ),
            ) ), esc_url( plugin_dir_url( __FILE__ ) . '../assets/imgs/pro.png' ) ); ?>
        </div>

    <?php } ?>
    
    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="vidseo_text"><?php echo  esc_html__( 'Video Host:', 'vidseo' ); ?></label></p>

    <div class="vidseo-switch-radio">

        <input type="radio" id="vidseo_host_btn1" name="vidseo_host" value="vidseo_youtube" <?php if ( $vidseo_host == 'vidseo_youtube' ) echo 'checked="checked"'; ?> />
        <label for="vidseo_host_btn1" class="vidseo-youtube"><?php echo esc_html__( 'Youtube', 'vidseo' ); ?></label>

        <input type="radio" id="vidseo_host_btn2" name="vidseo_host" value="vidseo_vimeo" <?php if ( $vidseo_host == 'vidseo_vimeo' ) echo 'checked="checked"'; ?> />
        <label for="vidseo_host_btn2" class="vidseo-vimeo"><?php echo esc_html__( 'Vimeo', 'vidseo' ); ?></label>

    </div>

	<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="vidseo_text"><?php echo  esc_html__( 'YouTube Video URL:', 'vidseo' ); ?></label></p>

    <input type="text" name="vidseo_url" value="<?php if ( !empty($vidseo_url) ) echo $vidseo_url; ?>" style="width: 100%; padding: 10px; font-size: 24px; margin: 10px 0;">
    
    <div class="vidseo-note">

        <p><?php echo __('Note: Please make sure to select proper host for video otherwise it will not work.', 'vidseo'); ?></p>

    </div>

    <div class="vidseo-note">

        <h2><?php echo __('Custom Settings for Shortcode', 'vidseo'); ?></h2>

        <p><?php echo __('You already have defined default/global settings on VidSeo setting page BUT you can control individual videos with shortcode attributes. Please use attributes with shortcode, like this:', 'vidseo'); ?></p>

        <p class="vidseo-code">[vidseo id="123" width="600px" transcript="0" title="0"]</p>

        <h2><?php echo __('Available Attributes', 'vidseo'); ?></h2>

        <p><ul>
            <li><?php echo __('Player width:"XXXpx" (Define width "xxx" in pixels or percentage - Don\'t forget to add "px" or "%" at the end)', 'vidseo'); ?></li>
            <li><?php echo __('Hide title: title="0" (true or false, 1 or 0)', 'vidseo'); ?></li>
            <li><?php echo __('Disable transcript:  transcript="0" (true or false, 1 or 0)', 'vidseo'); ?></li>
            <li><?php echo __('Excerpt Length:  excerpt="60" (characters length in numbers)', 'vidseo'); ?></li>
            <li><?php echo __('Hidden Transcript:  trans_hidden="1" (true or false, 1 or 0) (Note: Hidden Transcription is a PRO Feature)', 'vidseo'); ?></li>
        </ul></p>

    </div>

</div>

<?php

}

add_action( 'save_post', 'vidseo_metadata');

function vidseo_metadata($postid) {   
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
    if ( !current_user_can( 'edit_page', $postid ) ) return false;
    if( empty($postid) ) return false;

    $vidseo_host = sanitize_text_field( $_REQUEST['vidseo_host'] );
    $vidseo_url_value = sanitize_text_field( $_REQUEST['vidseo_url'] );
    $vidseo_content_value = sanitize_textarea_field( $_REQUEST['vidseo_content'] );

    $vidseo_safe = array(
        "vidseo_youtube",
        "vidseo_vimeo"
    );

    ( isset($_POST['vidseo_host']) && in_array( $vidseo_host, $vidseo_safe ) ) ? update_post_meta( $postid, 'vidseo_host', $vidseo_host) : delete_post_meta( $postid, 'vidseo_host' );

    ( isset( $_POST['vidseo_url'] ) && !empty( $_POST['vidseo_url'] ) ) ? update_post_meta( $postid, 'vidseo_url', $vidseo_url_value ) : delete_post_meta( $postid, 'vidseo_url' );

    ( isset( $_POST['vidseo_content'] ) && !empty( $_POST['vidseo_content'] ) ) ? update_post_meta( $postid, 'vidseo_content', $vidseo_content_value ) : delete_post_meta( $postid, 'vidseo_content' );

}