<?php class SocialWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Social Icons');
		$control_ops = array('width' => 400, 'height' => 500);
		parent::__construct(false,$name='ET Social',$widget_ops,$control_ops);
	}

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);

		$bannerPath[1] = empty($instance['bannerOnePath']) ? '' : $instance['bannerOnePath'];
		$bannerUrl[1] = empty($instance['bannerOneUrl']) ? '' : $instance['bannerOneUrl'];

		$bannerPath[2] = empty($instance['bannerTwoPath']) ? '' : $instance['bannerTwoPath'];
		$bannerUrl[2] = empty($instance['bannerTwoUrl']) ? '' : $instance['bannerTwoUrl'];

		$bannerPath[3] = empty($instance['bannerThreePath']) ? '' : $instance['bannerThreePath'];
		$bannerUrl[3] = empty($instance['bannerThreeUrl']) ? '' : $instance['bannerThreeUrl'];

		$bannerPath[4] = empty($instance['bannerFourPath']) ? '' : $instance['bannerFourPath'];
		$bannerUrl[4] = empty($instance['bannerFourUrl']) ? '' : $instance['bannerFourUrl'];

		$bannerPath[5] = empty($instance['bannerFivePath']) ? '' : $instance['bannerFivePath'];
		$bannerUrl[5] = empty($instance['bannerFiveUrl']) ? '' : $instance['bannerFiveUrl'];

		$bannerPath[6] = empty($instance['bannerSixPath']) ? '' : $instance['bannerSixPath'];
		$bannerUrl[6] = empty($instance['bannerSixUrl']) ? '' : $instance['bannerSixUrl'];

		$bannerPath[7] = empty($instance['bannerSevenPath']) ? '' : $instance['bannerSevenPath'];
		$bannerUrl[7] = empty($instance['bannerSevenUrl']) ? '' : $instance['bannerSevenUrl'];

		$bannerPath[8] = empty($instance['bannerEightPath']) ? '' : $instance['bannerEightPath'];
		$bannerUrl[8] = empty($instance['bannerEightUrl']) ? '' : $instance['bannerEightUrl'];

		$bannerPath[9] = empty($instance['bannerNinePath']) ? '' : $instance['bannerNinePath'];
		$bannerUrl[9] = empty($instance['bannerNineUrl']) ? '' : $instance['bannerNineUrl'];

		$bannerPath[10] = empty($instance['bannerTenPath']) ? '' : $instance['bannerTenPath'];
		$bannerUrl[10] = empty($instance['bannerTenUrl']) ? '' : $instance['bannerTenUrl'];

		$bannerPath[11] = empty($instance['bannerElevenPath']) ? '' : $instance['bannerElevenPath'];
		$bannerUrl[11] = empty($instance['bannerElevenUrl']) ? '' : $instance['bannerElevenUrl'];

		$bannerPath[12] = empty($instance['bannerTwelvePath']) ? '' : $instance['bannerTwelvePath'];
		$bannerUrl[12] = empty($instance['bannerTwelveUrl']) ? '' : $instance['bannerTwelveUrl'];

?>
<div class="widget nobg custom-social">
	<?php $i = 1;
	while ($i <= 12):
	if ($i == 7) echo("<br/>");
	if ($bannerPath[$i] <> '') { ?>
		<a href="<?php echo esc_url($bannerUrl[$i]); ?>" target="_blank"><img src="<?php echo esc_attr($bannerPath[$i]); ?>" alt="" /></a>
	<?php }; $i++;
	endwhile; ?>
</div> <!-- end .widget -->
<?php

	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['bannerOnePath'] = sanitize_text_field($new_instance['bannerOnePath']);
		$instance['bannerOneUrl'] = esc_url_raw($new_instance['bannerOneUrl']);

		$instance['bannerTwoPath'] = sanitize_text_field($new_instance['bannerTwoPath']);
		$instance['bannerTwoUrl'] = esc_url_raw($new_instance['bannerTwoUrl']);

		$instance['bannerThreePath'] = sanitize_text_field($new_instance['bannerThreePath']);
		$instance['bannerThreeUrl'] = esc_url_raw($new_instance['bannerThreeUrl']);

		$instance['bannerFourPath'] = sanitize_text_field($new_instance['bannerFourPath']);
		$instance['bannerFourUrl'] = esc_url_raw($new_instance['bannerFourUrl']);

		$instance['bannerFivePath'] = sanitize_text_field($new_instance['bannerFivePath']);
		$instance['bannerFiveUrl'] = esc_url_raw($new_instance['bannerFiveUrl']);

		$instance['bannerSixPath'] = sanitize_text_field($new_instance['bannerSixPath']);
		$instance['bannerSixUrl'] = esc_url_raw($new_instance['bannerSixUrl']);

		$instance['bannerSevenPath'] = sanitize_text_field($new_instance['bannerSevenPath']);
		$instance['bannerSevenUrl'] = esc_url_raw($new_instance['bannerSevenUrl']);

		$instance['bannerEightPath'] = sanitize_text_field($new_instance['bannerEightPath']);
		$instance['bannerEightUrl'] = esc_url_raw($new_instance['bannerEightUrl']);

		$instance['bannerNinePath'] = sanitize_text_field($new_instance['bannerNinePath']);
		$instance['bannerNineUrl'] = esc_url_raw($new_instance['bannerNineUrl']);

		$instance['bannerTenPath'] = sanitize_text_field($new_instance['bannerTenPath']);
		$instance['bannerTenUrl'] = esc_url_raw($new_instance['bannerTenUrl']);

		$instance['bannerElevenPath'] = sanitize_text_field($new_instance['bannerElevenPath']);
		$instance['bannerElevenUrl'] = esc_url_raw($new_instance['bannerElevenUrl']);

		$instance['bannerTwelvePath'] = sanitize_text_field($new_instance['bannerTwelvePath']);
		$instance['bannerTwelveUrl'] = esc_url_raw($new_instance['bannerTwelveUrl']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('bannerOnePath'=>'', 'bannerOneUrl'=>'', 'bannerTwoPath'=>'', 'bannerTwoUrl'=>'', 'bannerThreePath'=>'', 'bannerThreeUrl'=>'','bannerFourPath'=>'', 'bannerFourUrl'=>'','bannerFivePath'=>'', 'bannerFiveUrl'=>'','bannerSixPath'=>'', 'bannerSixUrl'=>'', 'bannerSevenPath'=>'', 'bannerSevenUrl'=>'','bannerEightPath'=>'', 'bannerEightUrl'=>'','bannerNinePath'=>'', 'bannerNineUrl'=>'','bannerTenPath'=>'', 'bannerTenUrl'=>'','bannerElevenPath'=>'', 'bannerElevenUrl'=>'','bannerTwelvePath'=>'', 'bannerTwelveUrl'=>'') );

		$bannerPath[1] = esc_attr($instance['bannerOnePath']);
		$bannerUrl[1] = esc_url($instance['bannerOneUrl']);

		$bannerPath[2] = esc_attr($instance['bannerTwoPath']);
		$bannerUrl[2] = esc_url($instance['bannerTwoUrl']);

		$bannerPath[3] = esc_attr($instance['bannerThreePath']);
		$bannerUrl[3] = esc_url($instance['bannerThreeUrl']);

		$bannerPath[4] = esc_attr($instance['bannerFourPath']);
		$bannerUrl[4] = esc_url($instance['bannerFourUrl']);

		$bannerPath[5] = esc_attr($instance['bannerFivePath']);
		$bannerUrl[5] = esc_url($instance['bannerFiveUrl']);

		$bannerPath[6] = esc_attr($instance['bannerSixPath']);
		$bannerUrl[6] = esc_url($instance['bannerSixUrl']);

		$bannerPath[7] = esc_attr($instance['bannerSevenPath']);
		$bannerUrl[7] = esc_url($instance['bannerSevenUrl']);

		$bannerPath[8] = esc_attr($instance['bannerEightPath']);
		$bannerUrl[8] = esc_url($instance['bannerEightUrl']);

		$bannerPath[9] = esc_attr($instance['bannerNinePath']);
		$bannerUrl[9] = esc_url($instance['bannerNineUrl']);

		$bannerPath[10] = esc_attr($instance['bannerTenPath']);
		$bannerUrl[10] = esc_url($instance['bannerTenUrl']);

		$bannerPath[11] = esc_attr($instance['bannerElevenPath']);
		$bannerUrl[11] = esc_url($instance['bannerElevenUrl']);

		$bannerPath[12] = esc_attr($instance['bannerTwelvePath']);
		$bannerUrl[12] = esc_url($instance['bannerTwelveUrl']);

		?>

		<?php	# Icon #1 Image
		echo '<p><label for="' . $this->get_field_id('bannerOnePath') . '">' . 'Icon #1 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOnePath') . '" name="' . $this->get_field_name('bannerOnePath') . '" type="text" value="' . $bannerPath[1] . '" /></p>';
		# Icon #1 Url
		echo '<p><label for="' . $this->get_field_id('bannerOneUrl') . '">' . 'Icon #1 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOneUrl') . '" name="' . $this->get_field_name('bannerOneUrl') . '" type="text" value="' . $bannerUrl[1] . '" /></p>';

		# Icon #2 Image
		echo '<p><label for="' . $this->get_field_id('bannerTwoPath') . '">' . 'Icon #2 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoPath') . '" name="' . $this->get_field_name('bannerTwoPath') . '" type="text" value="' . $bannerPath[2] . '" /></p>';
		# Icon #2 Url
		echo '<p><label for="' . $this->get_field_id('bannerTwoUrl') . '">' . 'Icon #2 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoUrl') . '" name="' . $this->get_field_name('bannerTwoUrl') . '" type="text" value="' . $bannerUrl[2] . '" /></p>';

		# Icon #3 Image
		echo '<p><label for="' . $this->get_field_id('bannerThreePath') . '">' . 'Icon #3 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreePath') . '" name="' . $this->get_field_name('bannerThreePath') . '" type="text" value="' . $bannerPath[3] . '" /></p>';
		# Icon #3 Url
		echo '<p><label for="' . $this->get_field_id('bannerThreeUrl') . '">' . 'Icon #3 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreeUrl') . '" name="' . $this->get_field_name('bannerThreeUrl') . '" type="text" value="' . $bannerUrl[3] . '" /></p>';

		# Icon #4 Image
		echo '<p><label for="' . $this->get_field_id('bannerFourPath') . '">' . 'Icon #4 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourPath') . '" name="' . $this->get_field_name('bannerFourPath') . '" type="text" value="' . $bannerPath[4] . '" /></p>';
		# Icon #4 Url
		echo '<p><label for="' . $this->get_field_id('bannerFourUrl') . '">' . 'Icon #4 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourUrl') . '" name="' . $this->get_field_name('bannerFourUrl') . '" type="text" value="' . $bannerUrl[4] . '" /></p>';

		# Icon #5 Image
		echo '<p><label for="' . $this->get_field_id('bannerFivePath') . '">' . 'Icon #5 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFivePath') . '" name="' . $this->get_field_name('bannerFivePath') . '" type="text" value="' . $bannerPath[5] . '" /></p>';
		# Icon #5 Url
		echo '<p><label for="' . $this->get_field_id('bannerFiveUrl') . '">' . 'Icon #5 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFiveUrl') . '" name="' . $this->get_field_name('bannerFiveUrl') . '" type="text" value="' . $bannerUrl[5] . '" /></p>';

		# Icon #6 Image
		echo '<p><label for="' . $this->get_field_id('bannerSixPath') . '">' . 'Icon #6 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixPath') . '" name="' . $this->get_field_name('bannerSixPath') . '" type="text" value="' . $bannerPath[6] . '" /></p>';
		# Icon #6 Url
		echo '<p><label for="' . $this->get_field_id('bannerSixUrl') . '">' . 'Icon #6 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixUrl') . '" name="' . $this->get_field_name('bannerSixUrl') . '" type="text" value="' . $bannerUrl[6] . '" /></p>';

		# Icon #7 Image
		echo '<p><label for="' . $this->get_field_id('bannerSevenPath') . '">' . 'Icon #7 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenPath') . '" name="' . $this->get_field_name('bannerSevenPath') . '" type="text" value="' . $bannerPath[7] . '" /></p>';
		# Icon #7 Url
		echo '<p><label for="' . $this->get_field_id('bannerSevenUrl') . '">' . 'Icon #7 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenUrl') . '" name="' . $this->get_field_name('bannerSevenUrl') . '" type="text" value="' . $bannerUrl[7] . '" /></p>';

		# Icon #8 Image
		echo '<p><label for="' . $this->get_field_id('bannerEightPath') . '">' . 'Icon #8 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightPath') . '" name="' . $this->get_field_name('bannerEightPath') . '" type="text" value="' . $bannerPath[8] . '" /></p>';
		# Icon #8 Url
		echo '<p><label for="' . $this->get_field_id('bannerEightUrl') . '">' . 'Icon #8 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightUrl') . '" name="' . $this->get_field_name('bannerEightUrl') . '" type="text" value="' . $bannerUrl[8] . '" /></p>';

		# Icon #9 Image
		echo '<p><label for="' . $this->get_field_id('bannerNinePath') . '">' . 'Icon #9 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerNinePath') . '" name="' . $this->get_field_name('bannerNinePath') . '" type="text" value="' . $bannerPath[9] . '" /></p>';
		# Icon #9 Url
		echo '<p><label for="' . $this->get_field_id('bannerNineUrl') . '">' . 'Icon #9 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerNineUrl') . '" name="' . $this->get_field_name('bannerNineUrl') . '" type="text" value="' . $bannerUrl[9] . '" /></p>';

		# Icon #10 Image
		echo '<p><label for="' . $this->get_field_id('bannerTenPath') . '">' . 'Icon #10 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTenPath') . '" name="' . $this->get_field_name('bannerTenPath') . '" type="text" value="' . $bannerPath[10] . '" /></p>';
		# Icon #10 Url
		echo '<p><label for="' . $this->get_field_id('bannerTenUrl') . '">' . 'Icon #10 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTenUrl') . '" name="' . $this->get_field_name('bannerTenUrl') . '" type="text" value="' . $bannerUrl[10] . '" /></p>';

		# Icon #11 Image
		echo '<p><label for="' . $this->get_field_id('bannerElevenPath') . '">' . 'Icon #11 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerElevenPath') . '" name="' . $this->get_field_name('bannerElevenPath') . '" type="text" value="' . $bannerPath[11] . '" /></p>';
		# Icon #11 Url
		echo '<p><label for="' . $this->get_field_id('bannerElevenUrl') . '">' . 'Icon #11 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerElevenUrl') . '" name="' . $this->get_field_name('bannerElevenUrl') . '" type="text" value="' . $bannerUrl[11] . '" /></p>';

		# Icon #12 Image
		echo '<p><label for="' . $this->get_field_id('bannerTwelvePath') . '">' . 'Icon #12 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwelvePath') . '" name="' . $this->get_field_name('bannerTwelvePath') . '" type="text" value="' . $bannerPath[12] . '" /></p>';
		# Icon #12 Url
		echo '<p><label for="' . $this->get_field_id('bannerTwelveUrl') . '">' . 'Icon #12 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwelveUrl') . '" name="' . $this->get_field_name('bannerTwelveUrl') . '" type="text" value="' . $bannerUrl[12] . '" /></p>';

	}

}// end AdvWidget class

function SocialWidgetInit() {
	register_widget('SocialWidget');
}

add_action('widgets_init', 'SocialWidgetInit');