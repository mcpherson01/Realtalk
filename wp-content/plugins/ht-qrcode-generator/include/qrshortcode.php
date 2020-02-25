<?php
/*
*   ShortCode 
*/
function htqr_shortcode( $attributes ){
    $ht_id = uniqid();
    extract( shortcode_atts( array(
        'title'                 => 'QR Code Titel',
        'html_tag'              => 'h3',
        'sub_titel'             => '',
        'alignment'             => 'left',

        'qrcode'                => '',
        'size'                  => 300,

        'dot_scale'             => 0.5,
        'qr_level'              => 'H',

        'logo'                  => '',
        'logo_size'             => 80,
        'logo_bg_color'         => '#ffffff',
        'logo_bg_transparent'   => 'false',

        'qr_bg_image'			=> '',
        'qr_bg_opacity'			=> 0.5,
        'qr_bg_autocolor'		=> 'true',

        'colordark'             => '#000000',
        'colorlight'            => '#FFFACD',

        
        'po'                    => '#e1622f',
        'pi'                    => '#aa5b71',
        'po_tl'                 => '',
        'pi_tl'                 => '#b7d28d',
        'po_tr'                 => '#aa5b71',
        'pi_tr'                 => '#c17e61',
        'po_bl'                 => '',
        'pi_bl'                 => '',

        'ai'                    => '#27408B',
        'ao'                    => '#7D26CD',

        'timing'                => '#111111',
        'timing_h'              => '#ff6600',
        'timing_v'              => '#cc0033',
        'quietzone'             => 0,
        'quietzonecolor'        => ''
        

    ), $attributes ) );

    $data = array();

    ob_start();
        echo sprintf('
            <div class="ht_qrcode-%1$s" style="text-align:%2$s">
            
                <p>%5$s</p>
            </div>

        <script type="text/javascript">
        	jQuery(document).ready(function($) {
                \'use strict\';

	            new QRCode(document.querySelector(".ht_qrcode-%1$s"),{
	                text: "%6$s",

	                width: %7$s,
	                height: %7$s,

	                dotScale: %8$s,
	                correctLevel: QRCode.CorrectLevel.%9$s, // L, M, Q, H

	                logo: "%10$s",
	                logoWidth:%11$s, 
	                logoHeight:%11$s,
	                logoBackgroundColor: "%12$s",
	                logoBackgroundTransparent: %13$s,


	                backgroundImage: "%14$s",
					backgroundImageAlpha: %15$s,
					autoColor: %16$s, 

	                colorDark: "%17$s",
	                colorLight: "%18$s",

	                PO: "%19$s",
	                PI: "%20$s",
	                PO_TL:"%21$s",
	                PI_TL: "%22$s",
	                PO_TR: "%23$s",
	                PI_TR: "%24$s",
	                PO_BL:"%25$s",
	                PI_BL:"%26$s",

	                AI:"%27$s",
	                AO:"%28$s",


	                timing: "%29$s",
	                timing_H: "%30$s",
	                timing_V: "%31$s",

                    quietZone: %32$s,
                    quietZoneColor: "%33$s",
                    
	            }
	        );

		 });
        </script>
    ', $ht_id, $alignment, $html_tag, $title, $sub_titel, $qrcode, $size, $dot_scale, $qr_level, $logo, $logo_size, $logo_bg_color, $logo_bg_transparent,  $qr_bg_image, $qr_bg_opacity, $qr_bg_autocolor,  $colordark, $colorlight, $po, $pi, $po_tl, $pi_tl, $po_tr, $pi_tr, $po_bl, $pi_bl, $ai, $ao, $timing, $timing_h, $timing_v, $quietzone, $quietzonecolor);
    return ob_get_clean();



}
add_shortcode( 'htqrcode', 'htqr_shortcode');   