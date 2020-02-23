<?php
defined('ABSPATH') or die();
$custombtext= get_theme_mod( 'custom_button_text','Custom Text' );
$customburl= get_theme_mod( 'custom_button_url' );
$custombtntype= get_theme_mod( 'ct-button-type','standard-button' );
$custombtnbg= get_theme_mod( 'button-bg-ct', '#0088CC');
$custombtnborder= get_theme_mod( 'button-border-ct', '#0088CC');
$custombtntextcolor= get_theme_mod( 'button-color-text', '#ffffff');
$custombtnbghov= get_theme_mod( 'button-bghover-ct', '#0088CC');
$custombtnborderhov= get_theme_mod( 'button-borderhov-ct', '#0088CC');
$custombtntextcolorhov= get_theme_mod( 'button-colorhov-text', '#ffffff');
?>
<style>
    .custom-button{
        color:<?php echo esc_attr($custombtntextcolor);  ?>;
        background-color:<?php echo esc_attr($custombtnbg);  ?>;
        border-color:<?php echo esc_attr($custombtnborder);  ?>;
    }
    
    .custom-button:hover{
        color:<?php echo esc_attr($custombtntextcolorhov);  ?>;
        background-color:<?php echo esc_attr($custombtnbghov);  ?>;
        border-color:<?php echo esc_attr($custombtnborderhov);  ?>;
    }
    
    .ghost-button.custom-button:hover{
        background-color:<?php echo esc_attr($custombtnbghov);  ?> !important;
    }
</style>
<a href="<?php echo esc_url($customburl);  ?>" class="custom-button <?php echo esc_attr($custombtntype);  ?>" style="line-height:22px;"><?php echo esc_attr($custombtext);  ?></a>