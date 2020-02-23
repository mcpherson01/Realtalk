<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_search_term extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(
			"recent_section_title" => 'Search Keywords',
			"termstyle" => '',
			"style_seven_color" => '',
			'css' => '1',
		
        ), $atts));
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );



        /* ================  Render Shortcodes ================ */

        ob_start();
		

        ?>
        <div class="search--term--div <?php echo esc_attr( $css_class ); ?>">
        <h2 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h2>
        
          <?php if ($termstyle == "1") : ?>
        <div class="search-term-style-one">
            
            <?php elseif ($termstyle == "2") : ?>
               <div class="search-term-style-one bottom--border--style">
                   
              <?php elseif ($termstyle == "3") : ?>
              
               <div class="search-term-style-three tag_widget_single">
            
            <?php elseif ($termstyle == "4") :?>
              
               <div class="search-term-style-four tag_widget_single">
                   
           <?php elseif ($termstyle == "5") : ?>
              
               <div class="search-term-style-five tag_widget_single">
                   
                   
                    <?php elseif ($termstyle == "7") : ?>
              
               <div class="search-term-style-seven tag_widget_single" style="color:<?php echo esc_attr($style_seven_color); ?>;">
                       <style>
                           .search-term-style-seven.tag_widget_single  a{
                               color:<?php echo esc_attr($style_seven_color); ?>
                           }
                       </style>
                   
            <?php  else : ?>
            <div class="tag_widget_single search-term-style-six">
              <?php endif; ?>
               <?php if ($termstyle == "7") : ?>
              <span class="termtitle"><?php esc_html_e('Popular Searches:', 'mayosis'); ?></span> <?php mayosis_show_recent_searches( "<span class='termtags'>", "</span>", ", " ); ?>
              <?php else : ?>
         <?php mayosis_show_recent_searches( "<ul>\n<li>", "</li>\n</ul>", "</li>\n<li>" ); ?>
         <?php endif; ?>
         </div>
          
</div> <?php
			echo $this->endBlockComment('search_term'); ?>
        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "search_term",
    "name"      => __("Mayosis Search Keywords", 'mayosis'),
    "description"      => __("Recent Search Keywords", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	                array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title', 'mayosis' ),
                        'param_name' => 'recent_section_title',
                        'value' => __( 'Recent Edd', 'mayosis' ),
                        'description' => __( 'Title for Recent Section', 'mayosis' ),
                    ), 
                    
            array(
			"type" => "dropdown",
			"heading" => __("Search Term Style", 'mayosis') ,
			"param_name" => "termstyle",
			"description" => __("Set search term style", 'mayosis') ,
			"value" => array(
				'Style One' => '1',
				'Style Two' => '2',
				'Style Three' => '3',
				'Style Four' => '4',
				'Style Five' => '5',
				'Style Six' => '6',
				'Style Seven' => '7',
			) , //Add default value in $atts
		) ,
		
		array(
            "type" => "colorpicker",
            "heading" => __('Change text color for style seven', 'mayosis'),
            "param_name" => "style_seven_color",
			"group" => 'Style',
			"dependency" => Array('element' => "termstyle", 'value' => array('7'))
        ),
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

    )

));