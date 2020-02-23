<?php

if ( !defined( 'URNA_CORE_ACTIVED' ) ) return;

//convert hex to rgb
if ( !function_exists ('urna_tbay_getbowtied_hex2rgb') ) {
	function urna_tbay_getbowtied_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}


if ( !function_exists ('urna_tbay_color_lightens_darkens') ) {
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
	 * @param str $hex Colour as hexadecimal (with or without hash);
	 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
	 * @return str Lightened/Darkend colour as hexadecimal (with hash);
	 */
	function urna_tbay_color_lightens_darkens( $hex, $percent ) {
		
		// validate hex string
		
		$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
		$new_hex = '#';
		
		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}
		
		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = hexdec( substr( $hex, $i*2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}		
		
		return $new_hex;
	}
}

if ( !function_exists ('urna_tbay_default_theme_primary_color') ) {
	function urna_tbay_default_theme_primary_color() {

		$active_theme = urna_tbay_get_theme();

		$theme_color = array();

		switch ($active_theme) {
			case 'furniture':
				$theme_color['main_color'] 			= '#ca0815';
				$theme_color['main_color_second'] 	= '#ff9c00';
				break;
			case 'sportwear':
				$theme_color['main_color'] 			= '#bd101b';
				break;
			case 'technology-v1':
				$theme_color['main_color'] 			= '#ffc000';
				$theme_color['main_color_second'] 	= '#db0808';
				break;
			case 'technology-v2':
				$theme_color['main_color'] 			= '#666ee8';
				$theme_color['main_color_second'] 	= '#ffd200';
				break;
			case 'technology-v3':
				$theme_color['main_color'] 			= '#ffd200';
				$theme_color['main_color_second'] 	= '#e40101';
				break;
			case 'minimal':
				$theme_color['main_color'] = '#bb0b0b';
				break;
			case 'handmade':
				$theme_color['main_color'] = '#ff0000';
				break;
			case 'interior':
				$theme_color['main_color'] = '#ff5301';
				break;
			case 'fashion':
				$theme_color['main_color'] 			= '#ff6c00';
				$theme_color['main_color_second'] 	= '#db0808';
				break;
			case 'fashion-v2':
				$theme_color['main_color'] 			= '#e50100';
				$theme_color['main_color_second'] 	= '#ff6c00';
				break;
			case 'home-shop':
				$theme_color['main_color'] = '#ff0000';
				break;
			case 'organic':
				$theme_color['main_color'] 			= '#86bc44';
				$theme_color['main_color_second'] 	= '#ff9600';
				break;
			case 'jewelry':
				$theme_color['main_color'] 			= '#151039';
				$theme_color['main_color_second'] 	= '#ffae00';
				break;
			case 'beauty':
				$theme_color['main_color'] 			= '#f88573';
				$theme_color['main_color_second'] 	= '#ff1818';
				break;
			case 'book':
				$theme_color['main_color'] 			= '#8e410e';
				$theme_color['main_color_second'] 	= '#ffd800';
				break;
			case 'kitchen':
				$theme_color['main_color'] = '#cd1218';
				break;
			case 'fashion-v3':
				$theme_color['main_color'] = '#d02121';
				break;
			case 'men':
				$theme_color['main_color'] = '#d02121';
				break;
			case 'bike':
				$theme_color['main_color'] = '#ffcc00';
				break;
			case 'marketplace-v1':
				$theme_color['main_color'] 			= '#ffa200';
				$theme_color['main_color_second'] 	= '#0a3040';
				break;
			case 'watch':
				$theme_color['main_color'] = '#ff5562';
				break;
			case 'marketplace-v2':
				$theme_color['main_color'] 			= '#ca0815';
				$theme_color['main_color_second'] 	= '#ffb503';
				break;
			case 'women':
			$theme_color['main_color'] = '#d02121';
				break;
			case 'auto-part':
			$theme_color['main_color'] = '#fcb913';
				break;
			case 'shoe':
			$theme_color['main_color'] = '#f26725';
				break;
			case 'toy':
				$theme_color['main_color'] 			= '#ffd900';
				$theme_color['main_color_second'] 	= '#004e98';
				$theme_color['main_color_third'] 	= '#ca0815';
			break;
			case 'glass':
			$theme_color['main_color'] = '#504ca2';
				break;

			case 'pet':
			$theme_color['main_color'] = '#7a59ab';
			case 'bag':
			$theme_color['main_color'] = '#ff9c00';
				break;
		}

		return apply_filters( 'urna_get_default_theme_color', $theme_color);
	}
}

if ( !function_exists ('urna_tbay_custom_styles') ) {
	function urna_tbay_custom_styles() {
		global $reduxConfig;	

		$active_theme = urna_tbay_get_theme();
		$ouput = $reduxConfig->output;

		$main_color  = $main_bg_color =  $main_border_color  = urna_tbay_get_config('main_color');

		if( $active_theme === 'toy' && urna_tbay_get_config('main_color_third') ) {
			$main_color        			= urna_tbay_get_config('main_color_second');
		}

		$logo_img_width        		= urna_tbay_get_config( 'logo_img_width' );
		$logo_padding        		= urna_tbay_get_config( 'logo_padding' );	

		$logo_img_width_mobile 		= urna_tbay_get_config( 'logo_img_width_mobile' );
		$logo_mobile_padding 		= urna_tbay_get_config( 'logo_mobile_padding' );
		$sale_border_radius 		= urna_tbay_get_config( 'sale_border_radius' );
		$enable_custom_label_sale  	= (bool) urna_tbay_get_config('enable_custom_label_sale' , false);
		$line_height_sale 			= urna_tbay_get_config( 'line_height_label_sale' );
		$min_width_label_sale 		= urna_tbay_get_config( 'min_width_label_sale' );

		$custom_css 			= urna_tbay_get_config( 'custom_css' );
		$css_desktop 			= urna_tbay_get_config( 'css_desktop' );
		$css_tablet 			= urna_tbay_get_config( 'css_tablet' );
		$css_wide_mobile 		= urna_tbay_get_config( 'css_wide_mobile' );
		$css_mobile         	= urna_tbay_get_config( 'css_mobile' );

		$show_typography        = (bool) urna_tbay_get_config( 'show_typography', false );

		$main_bg_color_mobile = '';

		$bg_buy_now 		  = urna_tbay_get_config( 'bg_buy_now' );

		ob_start();	
		?>
		
		/* Theme Options Styles */
		
		<?php if( $show_typography ) : ?>	
			/* Typography */
			/* Main Font */
			<?php
				$font_source = urna_tbay_get_config('font_source');
				$main_font = urna_tbay_get_config('main_font');
				$main_font = isset($main_font['font-family']) ? $main_font['font-family'] : false;
				$main_google_font_face = urna_tbay_get_config('main_google_font_face');
				$main_custom_font_face = urna_tbay_get_config('main_custom_font_face');
			?>
			<?php if ( ($font_source == "1" && $main_font) || ($font_source == "2" && $main_google_font_face) || ($font_source == "3" && $main_custom_font_face) ): ?>
				<?php  echo trim($ouput['primary-font'][0]); ?>
				{font-family: 
					<?php 
						switch ($font_source) {
							case '3':
								echo trim($main_custom_font_face);
								break;								
							case '2':
								echo trim($main_google_font_face);
								break;							
							case '1':
								echo trim($main_font);
								break;
							
							default:
								echo trim($main_google_font_face);
								break;
						}
					?>
				}
			<?php endif; ?>
			/* Second Font */
			<?php
				$secondary_font = urna_tbay_get_config('secondary_font');
				$secondary_font = isset($secondary_font['font-family']) ? $secondary_font['font-family'] : false;
				$secondary_google_font_face = urna_tbay_get_config('secondary_google_font_face');
				$secondary_custom_font_face = urna_tbay_get_config('secondary_custom_font_face');
			?>
			<?php if ( ($font_source == "1" && $secondary_font) || ($font_source == "2" && $secondary_google_font_face)  || ($font_source == "3" && $secondary_custom_font_face) ): ?>
					<?php  echo trim($ouput['secondary-font'][0]); ?>
				{font-family: 
					<?php 
						switch ($font_source) {
							case '3':
								echo trim($secondary_custom_font_face);
								break;								
							case '2':
								echo trim($secondary_google_font_face);
								break;							
							case '1':
								echo trim($secondary_font);
								break;
							
							default:
								echo trim($secondary_google_font_face);
								break;
						}
					?>
				}		
			<?php endif; ?>

		<?php endif; ?>


			/* Custom Color (skin) */ 

			/* check main color */ 
			<?php if ( $main_color != "" ) : ?>

				/*color*/

				/*background*/
				<?php if( isset($ouput['background_hover']) && !empty($ouput['background_hover']) ) : ?>
				<?php echo trim($ouput['background_hover']); ?> {
					background: <?php echo esc_html( urna_tbay_color_lightens_darkens( $main_bg_color, -0.1) ); ?>;
					border-color: <?php echo esc_html( urna_tbay_color_lightens_darkens( $main_border_color, -0.1) ); ?>;
				}
				<?php endif; ?>

			<?php endif; ?>

			<?php if ( $logo_img_width != "" ) : ?>
			.site-header .logo img {
	            max-width: <?php echo esc_html( $logo_img_width ); ?>px;
	        } 
	        <?php endif; ?>

	        <?php if ( $logo_padding != "" ) : ?>
	        .site-header .logo img {

	            <?php if( !empty($logo_padding['padding-top'] ) ) : ?>
					padding-top: <?php echo esc_html( $logo_padding['padding-top'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($logo_padding['padding-right'] ) ) : ?>
					padding-right: <?php echo esc_html( $logo_padding['padding-right'] ); ?>;
	        	<?php endif; ?>
	        	
	        	<?php if( !empty($logo_padding['padding-bottom'] ) ) : ?>
					padding-bottom: <?php echo esc_html( $logo_padding['padding-bottom'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($logo_padding['padding-left'] ) ) : ?>
					 padding-left: <?php echo esc_html( $logo_padding['padding-left'] ); ?>;
	        	<?php endif; ?>

	        }
	        <?php endif; ?> 

	        <?php if ( $main_color != "" ) : ?>

        	/*Tablet*/
	        @media (max-width: 1199px)  and (min-width: 768px) {
				/*color*/
				<?php if( isset($ouput['tablet_color']) && !empty($ouput['tablet_color']) ) : ?>
					<?php echo trim($ouput['tablet_color']); ?> {
						color: <?php echo esc_html( $main_color ) ?>;
					}
				<?php endif; ?>


				/*background*/
				<?php if( isset($ouput['tablet_background']) && !empty($ouput['tablet_background']) ) : ?>
					<?php echo trim($ouput['tablet_background']); ?> {
						background-color: <?php echo esc_html( $main_bg_color ) ?>;
					}
				<?php endif; ?>

				/*Border*/
				<?php if( isset($ouput['tablet_border']) && !empty($ouput['tablet_border']) ) : ?>
				<?php echo trim($ouput['tablet_border']); ?> {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
				<?php endif; ?>
		    }

		    /*Mobile*/
		    @media (max-width: 767px) {
				/*color*/
				<?php if( isset($ouput['mobile_color']) && !empty($ouput['mobile_color']) ) : ?>
					<?php echo trim($ouput['mobile_color']); ?> {
						color: <?php echo esc_html( $main_color ) ?>;
					}
				<?php endif; ?>

				/*background*/
				<?php if( isset($ouput['mobile_background']) && !empty($ouput['mobile_background']) ) : ?>
					<?php echo trim($ouput['mobile_background']); ?> {
						background-color: <?php echo esc_html( $main_bg_color ) ?>;
					}
				<?php endif; ?>

				/*Border*/
				<?php if( isset($ouput['mobile_border']) && !empty($ouput['mobile_border']) ) : ?>
				<?php echo trim($ouput['mobile_border']); ?> {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
				<?php endif; ?>
		    }

		    /*No edit code customize*/	
		    @media (max-width: 1199px)  and (min-width: 768px) {	       
		    	/*color*/
				.footer-device-mobile > * a:hover,.footer-device-mobile > *.active a,.footer-device-mobile > *.active a i , body.woocommerce-wishlist .footer-device-mobile > .device-wishlist a,body.woocommerce-wishlist .footer-device-mobile > .device-wishlist a i,.vc_tta-container .vc_tta-panel.vc_active .vc_tta-panel-title > a span,.cart_totals table .order-total .woocs_special_price_code {
					color: <?php echo esc_html( $main_color ) ?>;
				}

				/*background*/
				.topbar-device-mobile .top-cart a.wc-continue,.topbar-device-mobile .cart-dropdown .cart-icon .mini-cart-items,.footer-device-mobile > * a span.count,.footer-device-mobile > * a .mini-cart-items,.tbay-addon-newletter .input-group-btn input {
					background-color: <?php echo esc_html( $main_bg_color ) ?>;
				}

				/*Border*/
				.topbar-device-mobile .top-cart a.wc-continue {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
			}

			/*No edit custom background color button Buy Now*/
			@media (max-width: 479px) {
				#shop-now.has-buy-now .tbay-buy-now.button, #shop-now.has-buy-now .tbay-buy-now.button.disabled {
					background-color: <?php echo esc_html( $main_bg_color ) ?>;
				}
			}

		   <?php endif; ?>

	        @media (max-width: 767px) {

	        	<?php if ( $logo_img_width_mobile != "" ) : ?>
	            /* Limit logo image height for mobile according to mobile header height */
	            .mobile-logo a img {
	               	max-width: <?php echo esc_html( $logo_img_width_mobile ); ?>px;
	            }     
	            <?php endif; ?>       

	            <?php if ( $logo_mobile_padding != "" ) : ?>
	            .mobile-logo a img {

		            <?php if( !empty($logo_mobile_padding['padding-top'] ) ) : ?>
						padding-top: <?php echo esc_html( $logo_mobile_padding['padding-top'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-right'] ) ) : ?>
						padding-right: <?php echo esc_html( $logo_mobile_padding['padding-right'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-bottom'] ) ) : ?>
						padding-bottom: <?php echo esc_html( $logo_mobile_padding['padding-bottom'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-left'] ) ) : ?>
						 padding-left: <?php echo esc_html( $logo_mobile_padding['padding-left'] ); ?>;
		        	<?php endif; ?>
		           
	            }
	            <?php endif; ?>

				<?php if( $enable_custom_label_sale ) : ?>
					.woocommerce .product .product-block span.onsale .saled,.woocommerce .product .product-block span.onsale .featured {
						line-height: <?php echo esc_html( $line_height_sale); ?>px;
						min-width: <?php echo esc_html( $min_width_label_sale); ?>px;
					}
					
				<?php endif; ?>
			}
			
			
            .woocommerce .product span.onsale > span,
            .single-product .image-mains span.onsale .saled, 
            .single-product .image-mains span.onsale .featured {
	            
	            <?php if( !empty($sale_border_radius['padding-top'] ) ) : ?>
					border-top-left-radius: <?php echo esc_html( $sale_border_radius['padding-top'] ); ?>;
					-webkit-border-top-left-radius: <?php echo esc_html( $sale_border_radius['padding-top'] ); ?>;
	              	 -moz-border-top-left-radius: <?php echo esc_html( $sale_border_radius['padding-top'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($sale_border_radius['padding-right'] ) ) : ?>
					border-top-right-radius: <?php echo esc_html( $sale_border_radius['padding-right'] ); ?>;
	             	 -webkit-border-top-right-radius: <?php echo esc_html( $sale_border_radius['padding-right'] ); ?>;
	              	  -moz-border-top-right-radius: <?php echo esc_html( $sale_border_radius['padding-right'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($sale_border_radius['padding-bottom'] ) ) : ?>
					border-bottom-right-radius: <?php echo esc_html( $sale_border_radius['padding-bottom'] ); ?>;
	             	 -webkit-border-bottom-right-radius: <?php echo esc_html( $sale_border_radius['padding-bottom'] ); ?>;
	              	  -moz-border-bottom-right-radius: <?php echo esc_html( $sale_border_radius['padding-bottom'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($sale_border_radius['padding-left'] ) ) : ?>
					border-bottom-left-radius: <?php echo esc_html( $sale_border_radius['padding-left'] ); ?>;
	             	 -webkit-border-bottom-left-radius: <?php echo esc_html( $sale_border_radius['padding-left'] ); ?>;
	              	  -moz-border-bottom-left-radius: <?php echo esc_html( $sale_border_radius['padding-left'] ); ?>;
	        	<?php endif; ?>

            }

            <?php if( !empty($bg_buy_now) ) : ?>
            	@media (min-width: 480px) {
            		#shop-now.has-buy-now .tbay-buy-now.button, #shop-now.has-buy-now .tbay-buy-now.button.disabled {
						background-color: <?php echo esc_html( $bg_buy_now ) ?>;
					}
					#shop-now.has-buy-now .tbay-buy-now.button:not(.disabled):hover, #shop-now.has-buy-now .tbay-buy-now.button:not(.disabled):focus {
						background: <?php echo esc_html( urna_tbay_color_lightens_darkens( $bg_buy_now, -0.1) ); ?>;
					}
            	}
			}
			<?php endif; ?>

			@media screen and (max-width: 782px) {
				html body.admin-bar{
					top: -46px !important;
					position: relative;
				}
			}

			/* Custom CSS */
	        <?php 
	        if( $custom_css != '' ) {
	            echo trim($custom_css);
	        }
	        if( $css_desktop != '' ) {
	            echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }'; 
	        }
	        if( $css_tablet != '' ) {
	            echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }'; 
	        }
	        if( $css_wide_mobile != '' ) {
	            echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }'; 
	        }
	        if( $css_mobile != '' ) {
	            echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }'; 
	        }
	        ?>


	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			} 
		}

		$custom_css = implode($new_lines);

		wp_enqueue_style( 'urna-style', URNA_THEME_DIR . '/style.css', array(), '1.0' );

		wp_add_inline_style( 'urna-style', $custom_css );

		if( class_exists( 'WooCommerce' ) && class_exists( 'YITH_Woocompare' ) ) {
			wp_add_inline_style( 'urna-woocommerce', $custom_css );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'urna_tbay_custom_styles', 200 ); 