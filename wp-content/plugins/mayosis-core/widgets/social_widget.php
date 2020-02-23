<?php
// Digital Social
class mayosis_social_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'mayosis_social_widget', 

// Widget name will appear in UI
esc_html__('Mayosis Social', 'mayosis'), 

// Widget description
array( 'description' => esc_html__( 'Your site&#8217;s Social Profiles.', 'mayosis' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  $facebook = apply_filters( 'facebook', $instance[ 'facebook' ] );
  $twitter = apply_filters( 'twitter', $instance[ 'twitter' ] );
  $google = apply_filters( 'google', $instance[ 'google' ] );
  $pinterest = apply_filters( 'pinterest', $instance[ 'pinterest' ] );
  $instagram = apply_filters( 'instagram', $instance[ 'instagram' ] );
  $behance = apply_filters( 'behance', $instance[ 'behance' ] );
  $youtube = apply_filters( 'youtube', $instance[ 'youtube' ] );
  $linkedin = apply_filters( 'linkedin', $instance[ 'linkedin' ] );
  $github = apply_filters( 'github', $instance[ 'github' ] );
  $slack = apply_filters( 'slack', $instance[ 'slack' ] );
  $envato = apply_filters( 'envato', $instance[ 'envato' ] );
  $dribbble = apply_filters( 'dribbble', $instance[ 'dribbble' ] );
  $vimeo = apply_filters( 'vimeo', $instance[ 'vimeo' ] );
  $spotify = apply_filters( 'spotify', $instance[ 'spotify' ] );
  $target = apply_filters( 'target', $instance[ 'target' ] );
  $align = apply_filters( 'align', $instance[ 'align' ] );
  $without_bg = apply_filters( 'align', $instance[ 'without_bg' ] );
  echo $args['before_widget']; ?>
  <div class="sidebar-theme">
		<h4 class="footer-widget-title"><?php echo esc_html($title); ?></h4>
            <?php
            $facebookurl= get_theme_mod('facebook_url','https://facebook.com/'); 
            $twitterurl= get_theme_mod('twitter_url','https://twitter.com/'); 
            $instagramurl= get_theme_mod('instagram_url','https://instagram.com/');
            $pinteresturl= get_theme_mod('pinterest_url','https://pinterest.com/'); 
            $youtubeurl= get_theme_mod('youtube_url','https://youtube.com/');
            $linkedinurl= get_theme_mod('linkedin_url','https://linkedin.com/');
            $githuburl= get_theme_mod('github_url','https://github.io/'); 
            $slackurl= get_theme_mod('slack_url','https://slack.com/');
            $envatourl= get_theme_mod('envato_url','https://envato.com/');
            $behanceurl= get_theme_mod('behance_url','https://behance.com/');
            $dribbbleurl= get_theme_mod('dribbble_url','https://dribbble.com/');
            $vimeourl= get_theme_mod('vimeo_url','https://vimeo.com/'); 
            $spotifyurl= get_theme_mod('spotify_url','https://spotify.com/');
            ?>
			<?php if ( $without_bg ){ ?>
			<div class="without-bg-social" style="text-align:<?php echo esc_html($align); ?>">
                   <?php if($facebook){ ?>
							<a href="<?php echo esc_url($facebookurl); ?>" class="facebook" target="_<?php echo esc_html($target); ?>"><i class="zil zi-facebook"></i></a>
							<?php } ?>
							
							 <?php if($twitter){ ?>
							<a href="<?php echo esc_url($twitterurl); ?>" class="twitter" target="_<?php echo esc_html($target); ?>"><i class="zil zi-twitter"></i></a>
							<?php } ?>
							
							
							<?php if($pinterest){ ?>
							<a href="<?php echo esc_url($pinteresturl); ?>" class="pinterest" target="_<?php echo esc_html($target); ?>"><i class="zil zi-pinterest"></i></a>
							<?php } ?>
							
							<?php if($instagram){ ?>
							<a href="<?php echo esc_url($instagramurl); ?>" class="instagram" target="_<?php echo esc_html($target); ?>"><i class="zil zi-instagram"></i></a>
							<?php } ?>
							
							<?php if($behance){ ?>
							<a href="<?php echo esc_url($behanceurl); ?>" class="behance" target="_<?php echo esc_html($target); ?>"><i class="zil zi-behance"></i></a>
			            	<?php } ?>
			            	
			            	<?php if($youtube){ ?>
				            <a href="<?php echo esc_url($youtubeurl); ?>" class="youtube" target="_<?php echo esc_html($target); ?>"><i class="zil zi-youtube"></i></a>
				            <?php } ?>
				            
				            <?php if($linkedin){ ?>
				            <a href="<?php echo esc_url($linkedinurl); ?>" class="linkedin" target="_<?php echo esc_html($target); ?>"><i class="zil zi-linked-in"></i></a>
				            <?php } ?>
				            
				            <?php if($github){ ?>
				            <a href="<?php echo esc_url($githuburl); ?>" class="github" target="_<?php echo esc_html($target); ?>"><i class="zil zi-github"></i></a>
				            <?php } ?>
				            
				            <?php if($slack){ ?>
				            <a href="<?php echo esc_url($slackurl); ?>" class="slack" target="_<?php echo esc_html($target); ?>"><i class="zil zi-slack"></i></a>
				            <?php } ?>
				            
				             <?php if($envato){ ?>
				            <a href="<?php echo esc_url($envatourl); ?>" class="envato" target="_<?php echo esc_html($target); ?>"><i class="zil zi-envato"></i></a>
				            <?php } ?>
				            
				             <?php if($dribbble){ ?>
				            <a href="<?php echo esc_url($dribbbleurl); ?>" class="dribbble" target="_<?php echo esc_html($target); ?>"><i class="zil zi-dribbble"></i></a>
				            <?php } ?>
				            
				             <?php if($vimeo){ ?>
				            <a href="<?php echo esc_url($vimeourl); ?>" class="vimeo" target="_<?php echo esc_html($target); ?>"><i class="zil zi-vimeo"></i></a>
				            <?php } ?>
				            
				             <?php if($spotify){ ?>
				            <a href="<?php echo esc_url($spotifyurl); ?>" class="spotify" target="_<?php echo esc_html($target); ?>"><i class="zil zi-spotify"></i></a>
				            <?php } ?>
						</div>
			<?php } else { ?>
			
                   <div class="social-profile" style="text-align:<?php echo esc_html($align); ?>">
                   <?php if($facebook){ ?>
							<a href="<?php echo esc_url($facebookurl); ?>" class="facebook" target="_<?php echo esc_html($target); ?>"><i class="zil zi-facebook"></i></a>
							<?php } ?>
							
							 <?php if($twitter){ ?>
							<a href="<?php echo esc_url($twitterurl); ?>" class="twitter" target="_<?php echo esc_html($target); ?>"><i class="zil zi-twitter"></i></a>
							<?php } ?>
							<?php if($google){ ?>
							<a href="<?php echo esc_url($googleurl); ?>" class="google" target="_<?php echo esc_html($target); ?>"><i class="fa fa-google-plus"></i></a>
							<?php } ?>
							
							<?php if($pinterest){ ?>
							<a href="<?php echo esc_url($pinteresturl); ?>" class="pinterest" target="_<?php echo esc_html($target); ?>"><i class="zil zi-pinterest"></i></a>
							<?php } ?>
							<?php if($instagram){ ?>
							<a href="<?php echo esc_url($instagramurl); ?>" class="instagram" target="_<?php echo esc_html($target); ?>"><i class="zil zi-instagram"></i></a>
							<?php } ?>
							
							<?php if($behance){ ?>
							<a href="<?php echo esc_url($behanceurl); ?>" class="behance" target="_<?php echo esc_html($target); ?>"><i class="zil zi-behance"></i></a>
			            	<?php } ?>
			            	
			            	<?php if($youtube){ ?>
				            <a href="<?php echo esc_url($youtubeurl); ?>" class="youtube" target="_<?php echo esc_html($target); ?>"><i class="zil zi-youtube"></i></a>
				            <?php } ?>
				            
				            <?php if($linkedin){ ?>
				            <a href="<?php echo esc_url($linkedinurl); ?>" class="linkedin" target="_<?php echo esc_html($target); ?>"><i class="zil zi-linked-in"></i></a>
				            <?php } ?>
				             <?php if($github){ ?>
				            <a href="<?php echo esc_url($githuburl); ?>" class="github" target="_<?php echo esc_html($target); ?>"><i class="zil zi-github"></i></a>
				            <?php } ?>
				            
				            <?php if($slack){ ?>
				            <a href="<?php echo esc_url($slackurl); ?>" class="slack" target="_<?php echo esc_html($target); ?>"><i class="zil zi-slack"></i></a>
				            <?php } ?>
				            
				             <?php if($envato){ ?>
				            <a href="<?php echo esc_url($envatourl); ?>" class="envato" target="_<?php echo esc_html($target); ?>"><i class="zil zi-envato"></i></a>
				            <?php } ?>
				            
				             <?php if($dribbble){ ?>
				            <a href="<?php echo esc_url($dribbbleurl); ?>" class="dribbble" target="_<?php echo esc_html($target); ?>"><i class="zil zi-dribbble"></i></a>
				            <?php } ?>
				            
				             <?php if($vimeo){ ?>
				            <a href="<?php echo esc_url($vimeourl); ?>" class="vimeo" target="_<?php echo esc_html($target); ?>"><i class="zil zi-vimeo"></i></a>
				            <?php } ?>
				            
				             <?php if($spotify){ ?>
				            <a href="<?php echo esc_url($spotifyurl); ?>" class="spotify" target="_<?php echo esc_html($target); ?>"><i class="zil zi-spotify"></i></a>
				            <?php } ?>
						</div>
                   <?php } ?>
<div class="clearfix"></div>
</div>
	<?php echo $args['after_widget'];
}
	/**
	 * Handles updating the settings for the current Digital Recent Productswidget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	/**
	 * Handles updating the settings for the current Digital Recent Productswidget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['facebook'] = sanitize_text_field( $new_instance['facebook'] );
		$instance['twitter'] = sanitize_text_field( $new_instance['twitter'] );
		$instance['google'] = sanitize_text_field( $new_instance['google'] );
		$instance['pinterest'] = sanitize_text_field( $new_instance['pinterest'] );
		$instance['instagram'] = sanitize_text_field( $new_instance['instagram'] );
		$instance['behance'] = sanitize_text_field( $new_instance['behance'] );
		$instance['youtube'] = sanitize_text_field( $new_instance['youtube'] );
		$instance['linkedin'] = sanitize_text_field( $new_instance['linkedin'] );
		$instance['github'] = sanitize_text_field( $new_instance['github'] );
		$instance['slack'] = sanitize_text_field( $new_instance['slack'] );
		$instance['envato'] = sanitize_text_field( $new_instance['envato'] );
		$instance['dribbble'] = sanitize_text_field( $new_instance['dribbble'] );
		$instance['vimeo'] = sanitize_text_field( $new_instance['vimeo'] );
		$instance['spotify'] = sanitize_text_field( $new_instance['spotify'] );
		
		$instance['target'] = sanitize_text_field( $new_instance['target'] );
		$instance['align'] = sanitize_text_field( $new_instance['align'] );
		$instance['without_bg'] = sanitize_text_field( $new_instance['without_bg'] );
		

		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = sanitize_text_field( $instance['title'] );
		$instance = wp_parse_args( (array) $instance, array( 'facebook' => '#') );
		$facebook = sanitize_text_field( $instance['facebook'] );
		$instance = wp_parse_args( (array) $instance, array( 'twitter' => '#') );
		$twitter= sanitize_text_field( $instance['twitter'] );
		$instance = wp_parse_args( (array) $instance, array( 'google' => '#') );
		$google= sanitize_text_field( $instance['google'] );
		$instance = wp_parse_args( (array) $instance, array( 'pinterest' => '#') );
		$pinterest= sanitize_text_field( $instance['pinterest'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'instagram' => '#') );
		$instagram= sanitize_text_field( $instance['instagram'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'behance' => '#') );
		$behance= sanitize_text_field( $instance['behance'] );
		$instance = wp_parse_args( (array) $instance, array( 'youtube' => '#') );
		$youtube= sanitize_text_field( $instance['youtube'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'linkedin' => '#') );
		$linkedin= sanitize_text_field( $instance['linkedin'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'github' => '#') );
		$github= sanitize_text_field( $instance['github'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'slack' => '#') );
		$slack= sanitize_text_field( $instance['slack'] );
		$instance = wp_parse_args( (array) $instance, array( 'envato' => '#') );
		$envato= sanitize_text_field( $instance['envato'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'dribbble' => '#') );
		$dribbble= sanitize_text_field( $instance['dribbble'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'vimeo' => '#') );
		$vimeo= sanitize_text_field( $instance['vimeo'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'spotify' => '#') );
		$spotify= sanitize_text_field( $instance['spotify'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'target' => 'self') );
		$target= sanitize_text_field( $instance['target'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'align' => 'left') );
		$align= sanitize_text_field( $instance['align'] );
		
		$instance = wp_parse_args( (array) $instance, array( 'without_bg' => 'on') );
		$without_bg= sanitize_text_field( $instance['without_bg'] );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'mayosis' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> </p>
			<p><input class="checkbox" type="checkbox" <?php checked( $instance['facebook'], 'on' ); ?> id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'facebook' )); ?>"><?php _e('Show Facebook', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['twitter'], 'on' ); ?> id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'twitter' )); ?>"><?php _e('Show Twitter', 'mayosis'); ?></label></p>
    
      <p><input class="checkbox" type="checkbox" <?php checked( $instance['pinterest'], 'on' ); ?> id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'pinterest' )); ?>"><?php _e('Show Pinterest', 'mayosis'); ?></label></p>
    
    
     <p><input class="checkbox" type="checkbox" <?php checked( $instance['instagram'], 'on' ); ?> id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'instagram' )); ?>"><?php _e('Show Instagram', 'mayosis'); ?></label></p>
    
    
     <p><input class="checkbox" type="checkbox" <?php checked( $instance['behance'], 'on' ); ?> id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'behance' )); ?>"><?php _e('Show Behance', 'mayosis'); ?></label></p>
    
     <p><input class="checkbox" type="checkbox" <?php checked( $instance['youtube'], 'on' ); ?> id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'youtube' )); ?>"><?php _e('Show Youtube', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['linkedin'], 'on' ); ?> id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'linkedin' )); ?>"><?php _e('Show Linkedin', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['github'], 'on' ); ?> id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'github' )); ?>"><?php _e('Show Github', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['slack'], 'on' ); ?> id="<?php echo $this->get_field_id( 'slack' ); ?>" name="<?php echo $this->get_field_name( 'slack' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'slack' )); ?>"><?php _e('Show Slack', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['envato'], 'on' ); ?> id="<?php echo $this->get_field_id( 'envato' ); ?>" name="<?php echo $this->get_field_name( 'envato' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'envato' )); ?>"><?php _e('Show Envato', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['dribbble'], 'on' ); ?> id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'dribbble' )); ?>"><?php _e('Show Dribbble', 'mayosis'); ?></label></p>
    
     <p><input class="checkbox" type="checkbox" <?php checked( $instance['vimeo'], 'on' ); ?> id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'vimeo' )); ?>"><?php _e('Show Vimeo', 'mayosis'); ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked( $instance['spotify'], 'on' ); ?> id="<?php echo $this->get_field_id( 'spotify' ); ?>" name="<?php echo $this->get_field_name( 'spotify' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'spotify' )); ?>"><?php _e('Show Spotify', 'mayosis'); ?></label></p>
    
    
		
		<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php printf( esc_html__( 'Target', 'mayosis' ), edd_get_label_singular() ); ?></label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
					<option value="self" <?php if ( $instance['target'] == 'self' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Self', 'mayosis' ); ?></option>
					<option value="blank" <?php if ( $instance['target'] == 'blank' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'blank', 'mayosis' ); ?></option>
					
				</select>
			</p>
		
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>"><?php printf( esc_html__( 'Align', 'mayosis' ), edd_get_label_singular() ); ?></label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'align' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>">
					<option value="left" <?php if ( $instance['align'] == 'left' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Left', 'mayosis' ); ?></option>
					<option value="center" <?php if ( $instance['align'] == 'center' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Center', 'mayosis' ); ?></option>
					<option value="right" <?php if ( $instance['align'] == 'right' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Right', 'mayosis' ); ?></option>
					
				</select>
			</p>
	
		<p><input class="checkbox" type="checkbox" <?php checked( $instance['without_bg'], 'on' ); ?> id="<?php echo $this->get_field_id( 'without_bg' ); ?>" name="<?php echo $this->get_field_name( 'without_bg' ); ?>" /> 
    <label for="<?php echo esc_attr($this->get_field_id( 'without_bg' )); ?>"><?php _e('Show Icon Without Background', 'mayosis'); ?></label></p>
    <p><strong style="background: rgba(0, 142, 194, 0.08);
    padding: 3px 8px;
    font-size: 11px;
    color: #008ec2;
    border-radius: 3px;">Update Social Links From (Theme Options > Other Option> Social Option)</strong></p>
		<?php
	}

}
	
// Class mayosis_social_widget ends here

// Register and load the widget
function load_social_widget() {
	register_widget( 'mayosis_social_widget' );
}
add_action( 'widgets_init', 'load_social_widget' );