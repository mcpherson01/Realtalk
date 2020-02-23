<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_search extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	$css = '';
        extract(shortcode_atts(array(
			"placeholder_text" => 'Search Products',	
			 'css' => '',
            'search_style' => ''
        ), $atts));
		
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
       <div class="product-search-form <?php echo esc_attr( $search_style ); ?> <?php echo esc_attr( $css_class ); ?>">
		<form method="GET" action="<?php echo esc_url(home_url('/')); ?>">

			<?php 
				$taxonomies = array('download_category');
				$args = array('orderby'=>'count','hide_empty'=>true);
				echo mayosis_get_terms_dropdown($taxonomies, $args);
			 ?>
			
			 
			<div class="search-fields">
				<input name="s" value="<?php echo (isset($_GET['s']))?$_GET['s']: null; ?>" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>">
				<input type="hidden" name="post_type" value="download">
			<span class="search-btn"><input value="" type="submit"></span>
			</div>
		</form>
	</div><?php echo $this->endBlockComment('dm_search'); ?>

<div class="clearfix"></div>
      
        
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_search",
    "name"      => __("Mayosis Search", 'mayosis'),
    "description"      => __("Mayosis Search Box", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
 
	 array(
                        'type' => 'textarea',
                        'heading' => __( 'Search Placeholder Text', 'mayosis' ),
                        'param_name' => 'placeholder_text',
                        'value' => __( 'Search Now', 'mayosis' ),
                        'description' => __( 'The Search Placeholder Text', 'mayosis' ),
	"group" => 'General',
                    ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Search Style', 'mayosis' ),
            'param_name' => 'search_style',
            "value"      => array(
                'Style One' => 'style1',
                'Style Two' => 'style2',
            ), //Add default value in $atts
            "group" => 'General',
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

	

      
    )

));