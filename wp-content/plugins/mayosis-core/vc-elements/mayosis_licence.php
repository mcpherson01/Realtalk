<?php
class WPBakeryShortCode_dm_license extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(
			"num_of_post" => '1',
			"post_order_term" => 'DESC',
			'license_category' => '',
			 'css' => ''
        ), $atts));
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );



        /* ================  Render Shortcodes ================ */
	
	

        ob_start();
		
		
			//Fetch data
		$arguments = array(
			'post_type' => 'licence',
			'post_status' => 'publish',
			//'posts_per_page' => -1,
			'order' => (string) trim($post_order_term),
			'posts_per_page' => $num_of_post,
			'license-group' => $license_category,
			'ignore_sticky_posts' => 1
			//'tag' => get_query_var('tag')
		);
	
		$post_query = new WP_Query($arguments); ?>
		  <?php if ( $post_query->have_posts() ) : while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
		  	<?php if( get_field('licence_type') == 'youcan' ): ?>
	<div class="dm_licence_main">
		<h2 class="licence_main_title youcantitle"><?php the_title();?></h2>
		<div class="main_content_licence youcan">
		<?php if( have_rows('licence_table_(you_can)') ): ?>
			<table class="table table-striped">
			<?php while( have_rows('licence_table_(you_can)') ): the_row(); 

		// vars
		$details_text = get_sub_field('details_text');

		?>
				<tr>
					<td><?php echo esc_html($details_text); ?></td>
					<td>
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle fa-stack-2x icon-background1"></i>
					  <i class="fa fa-check fa-stack-1x color_ic_n"></i>
					</span>
					</td>
				</tr>
				<?php endwhile; ?>
			</table>
			<?php endif; ?>
		</div>
	</div><?php echo $this->endBlockComment('dm_license'); ?>
	
		<?php else: ?>
		<div class="dm_licence_main">
		<h2 class="licence_main_title youcannottitle"><?php the_title(); ?></h2>
		<div class="main_content_licence youcannot">
		<?php if( have_rows('licence_table_(you_can_not)') ): ?>
			<table class="table table-striped">
			<?php while( have_rows('licence_table_(you_can_not)') ): the_row(); 

		$details_text = get_sub_field('details_text');

		?>
				<tr>
					<td><?php echo esc_html($details_text); ?></td>
					<td>
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle fa-stack-2x icon-background1"></i>
					  <i class="fa fa-times fa-stack-1x color_ic_n"></i>
					</span>
					</td>
				</tr>
				<?php endwhile; ?>

			
			</table>
			
<?php endif; ?>
		</div>
	</div><?php echo $this->endBlockComment('dm_license'); ?>
			<?php endif; ?>
	<?php endwhile; else: ?>
	
                    <div class="col-lg-12 pm-column-spacing">
                     <p><?php echo esc_attr('No posts were found.', 'mayosis'); ?></p>
                    </div>
                <?php endif; ?>
	
        <?php wp_reset_postdata(); ?>

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_license",
    "name"      => __('Mayosis License', 'mayosis'),
    "description"      => __('Mayosis License Block', 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __('Mayosis Elements', 'mayosis'),
    "params"    => array(

		array(
            "type" => "textfield",
            "heading" => __('Amount of License Block to display:', 'mayosis'),
            "param_name" => "num_of_post",
            "description" => __('Choose how many news posts you would like to display.', 'mayosis'),
			'value' => __( '3' , 'mayosis' ),
        ),
	
		
		array(
            "type" => "dropdown",
            "heading" => __('Post Order', 'mayosis'),
            "param_name" => "post_order_term",
            "description" => __('Set the order in which news posts will be displayed.', 'mayosis'),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
	 array(
                    "type" => "textfield",
                    "heading" => __('License Group',  'mayosis'),
                    "param_name" => "license_category",
                    "value" =>'',
                    "description" => __('Enter a comma separated list of License Group IDs / names',  'mayosis'),
                    
                ),
	
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

		

    )

));