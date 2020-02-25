<h2 class="vidseo_heading"><?php echo  esc_html__( 'STEP 3: Start embedding videos with transcription', 'vidseo' ) ;?></h2>

<div class="vidseo-alert vidseo-success">
    
    <?php echo sprintf( wp_kses( __( 'Click <a href="%s">HERE</a> to use VidSEO post type & start adding new videos with transcription (with shortcode)', 'vidseo' ), array( 
    'a' => array( 
        'href' => array(), 
        'target' => array(), 
    ),
    ) ), esc_url( 'edit.php?post_type=vidseo' ) );?>

    <?php echo sprintf( wp_kses( __( 'See examples of <a href="%s">settings with VidSEO</a>', 'vidseo' ), array( 
    'a' => array( 
        'href' => array(), 
        'target' => array(), 
    ),
    ) ), esc_url( 'https://better-robots.com/vidseo/' ) );?>

</div>

    <iframe src="https://player.vimeo.com/video/365180429" width="100%" height="530" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>

    <h4><?php echo __('Create your first shortcode:', 'vidseo'); ?></h4>

    <p><ul>
        <li><?php echo __('Copy-paste your Video URL from Youtube/Vimeo', 'vidseo'); ?></li>
        <li><?php echo __('Define where this video is from (Youtube/Vimeo)', 'vidseo'); ?></li>
        <li><?php echo __('Insert your content or transcription (check "Get Youtube Video transcription" tab if required)', 'vidseo'); ?></li>
        <li><?php echo __('Customize your content - (HTML edition available only with PRO version)', 'vidseo'); ?></li>
        <li><?php echo __('Copy-paste shortcode to your pages/posts/products', 'vidseo'); ?></li>
        <li><?php echo __('Customize your shortcode with attributes (other than defined on VidSEO setting page)', 'vidseo'); ?></li>
        <li><?php echo __('Check the result !', 'vidseo'); ?></li>
    </ul></p>


<?php if ( !vidseo_fs()->can_use_premium_code__premium_only() ) { ?>

<h2 class="vidseo_heading"><?php echo  esc_html__( 'STEP 4: GET PRO:', 'vidseo' ) ;?></h2>
    
    <ul>
        <li><?php echo __( 'edit video transcriptions with visual text editor (formatting options)', 'vidseo' );?></li>

        <li><?php echo __( 'enable "Hidden" feature (hide video transcription to visitors)', 'vidseo' );?></li>

        <li><?php echo __( 'customize embedder background color', 'vidseo' );?></li>

        <li><?php echo __( 'remove footer credit (Powered by VidSEO)', 'vidseo' );?></li>
    </ul>

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