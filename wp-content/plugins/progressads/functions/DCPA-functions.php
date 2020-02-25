<?php
if ( !function_exists( 'add_action' ) ) {
    exit;
}

if( get_option("DCPA_start") == 1 ) {
	
/////////////////////////
//add header
/////////////////////////
function DCPA_progressCSS() {
if( get_option("DCPA_enable_home") == 1 && is_home() || get_option("DCPA_enable_home") == 1 && is_front_page() || get_option("DCPA_enable_archives") == 1 && is_archive() || get_option("DCPA_enable_search") == 1 && is_search() || get_option("DCPA_enable_404") == 1 && is_404() || !empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_archive() && !is_404() && !is_search()) {
	//Add CSS Style for Admin Panel
   wp_enqueue_style( 'dcpa-progress-style', DCPA_URL."functions/assets/css/progressplugin.css",array(), "1.0.0" );
}
}

/////////////////////////
//add footer
/////////////////////////

function DCPA_progressFooter() {
if( get_option("DCPA_enable_home") == 1 && is_home() || get_option("DCPA_enable_home") == 1 && is_front_page() || get_option("DCPA_enable_archives") == 1 && is_archive() || get_option("DCPA_enable_search") == 1 && is_search() || get_option("DCPA_enable_404") == 1 && is_404() || !empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_archive() && !is_404() && !is_search()) {
    wp_enqueue_script( 'dcpa-progress-script', 
                       DCPA_URL."functions/assets/js/progressplugin.js", 
                       array(), 
                       '1.0.0', 
                       true);
}
}


function DCPA_customableJS() { 
if( get_option("DCPA_enable_home") == 1 && is_home() || get_option("DCPA_enable_home") == 1 && is_front_page() || get_option("DCPA_enable_archives") == 1 && is_archive() || get_option("DCPA_enable_search") == 1 && is_search() || get_option("DCPA_enable_404") == 1 && is_404() || !empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_archive() && !is_404() && !is_search()) {

$modalJSShow = 0;

if(!empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_archive() && !is_404() && !is_search()) {
	
	global $post;
	$post_id = get_the_ID();
	
	if(!empty(get_post_meta( $post_id, 'DCPA_post_mb', true ))) {
		$modalJSShow = get_post_meta( $post_id, 'DCPA_post_mb', true );
	} else {
		$modalJSShow = 0;
	}
}

	if (get_option("DCPA_showPop") == 1) { if(is_user_logged_in() && get_option("DCPA_logged_prog") == 1 || is_user_logged_in() && get_option("DCPA_logged_modal") == 1 || $modalJSShow == 1) { $type = 0; $range = 0; $modal = 0; } else { $type = get_option("DCPA_closerType"); $range = get_option("DCPA_modalPlace"); $modal = 1;}} else { $type = 0; $range = 0; $modal = 0; } 
	
	if (get_option("DCPA_removProg") == 1) { $afterads = 1; } else { $afterads = 0; }
	
	if (get_option("DCPA_skipType") == 2) {
		$time = get_option("DCPA_cdButton"); 
		$skip = get_option("DCPA_cdText"); 
		$remaining = get_option("DCPA_remaininText");  
		if ($time == NULL) {
			$time = "5";
		} else {
			$time = get_option("DCPA_cdButton");
		}
				
		if ($skip == NULL) {
			$skip = "Skip Ad >";
		} else {
			$skip = get_option("DCPA_cdText");
		}		
		
		if ($remaining == NULL) {
			$remaining = "seconds remaining";
		} else {
			$remaining = get_option("DCPA_remaininText");
		}
		
	} else { $time = 0; $skip = 0; $remaining = 0;}
	
	if(get_option("DCPA_modalFreq") == "") { $freq = 0; } else { $freq = get_option("DCPA_modalFreq");}
	
	?>
	<script type="text/javascript">
		window.addEventListener("scroll", function () {
		  var top = window.scrollY;
		  var height = document.body.getBoundingClientRect().height - window.innerHeight;
		  var color1 = "<?php echo esc_js(get_option('DCPA_progressColor')); ?>";
		  var color2 = "<?php echo esc_js(get_option('DCPA_progressColorAd')); ?>";
		  var type = <?php echo esc_js($type); ?>;
		  var range = <?php echo esc_js($range); ?>;
		  var modal = <?php echo esc_js($modal);?>;
		  var time = <?php echo esc_js($time); ?>;
		  var skip = "<?php echo esc_js($skip); ?>";
		  var remaining = "<?php echo esc_js($remaining);?>";
		  var freq = <?php echo esc_js($freq); ?>;
		  var afterads = <?php echo esc_js($afterads); ?>;
		  updateDCPAProgress(top, height, color1, color2, range, time, skip, remaining, type, modal, freq, afterads);
		});
	</script>
<?php
}
}

function DCPA_customableHTML() {
$progressHTMLShow = 0;
$modalHTMLShow = 0;

if(!empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_home() && !is_archive() && !is_404() && !is_search()) {
	
	global $post;
	$post_id = get_the_ID();
	
	if(!empty(get_post_meta( $post_id, 'DCPA_post_pb', true ))) {
		$progressHTMLShow = get_post_meta( $post_id, 'DCPA_post_pb', true );
	} else {
		$progressHTMLShow = 0;
	}	
	
	if(!empty(get_post_meta( $post_id, 'DCPA_post_mb', true ))) {
		$modalHTMLShow = get_post_meta( $post_id, 'DCPA_post_mb', true );
	} else {
		$modalHTMLShow = 0;
	}
}
	
	$closerType = get_option("DCPA_closerType");
	$progType = get_option("DCPA_progType");
	$progSty = get_option("DCPA_progSty");
	
	
	if ($progType == 1) {
		$setProgType = "top:0;";
	} else if ($progType == 2) {
		$setProgType = "bottom:0;";
	} else	{
		$setProgType = "top:0;";
	}
	
	if ($closerType == 1) {
		$closeTypeRL = "right:0.8rem;";
		$closeTypeUB = "top:1.2rem;";
	} else if ($closerType == 2) {
		$closeTypeRL = "left:0.8rem;";
		$closeTypeUB = "top:1.2rem;";
	} else if ($closerType == 3) {
		$closeTypeRL = "right:0.8rem;";
		$closeTypeUB = "bottom:1.2rem;";
	} else if ($closerType == 4) {
		$closeTypeRL = "left:0.8rem;";
		$closeTypeUB = "bottom:1.2rem;";
	} else {
		$closeTypeRL = "right:0.8rem;";
		$closeTypeUB = "top:1.2rem;";
	}	
	
	if ($progSty == 1) {
		$progStyClass = "progressAd";
	} else if ($progSty == 2) {
		$progStyClass = "progressAd2";
	} else if ($progSty == 3) {
		$progStyClass = "progressAd3";
	} else if ($progSty == 4) {
		$progStyClass = "progressAd4";
	} else if ($progSty == 5) {
		$progStyClass = "progressAd5";
	} else if ($progSty == 6) {
		$progStyClass = "progressAd6";
	} else if ($progSty == 7) {
		$progStyClass = "progressAd7";
	} else if ($progSty == 8) {
		$progStyClass = "progressAd8";
	} else if ($progSty == 9) {
		$progStyClass = "progressAd9";
	} else if ($progSty == 10) {
		$progStyClass = "progressAd10";
	} else if ($progSty == 11) {
		$progStyClass = "progressAd11";
	} else {
		$progStyClass = "progressAd";
	}
	
if( get_option("DCPA_enable_home") == 1 && is_home() || get_option("DCPA_enable_home") == 1 && is_front_page() || get_option("DCPA_enable_archives") == 1 && is_archive() || get_option("DCPA_enable_search") == 1 && is_search() || get_option("DCPA_enable_404") == 1 && is_404() || !empty(get_option("DCPA_customPosts")) && in_array(get_post_type(), get_option("DCPA_customPosts")) && !is_archive() && !is_404() && !is_search()) {
	
	if(!isset($_COOKIE['padsTime'])) {?>
	<div style="<?php if(get_option("DCPA_show") == 0 || is_user_logged_in() && get_option("DCPA_logged_prog") == 1 || $progressHTMLShow == 1) {?>display:none;<?php } ?><?php echo esc_attr($setProgType); ?><?php echo "height:".esc_attr(get_option("DCPA_progressHeight"))."px;background:".esc_attr(get_option("DCPA_pbBack"));?>;" id="progressContainer" class="progressContainer">
	<div id="progressAd" class="<?php echo esc_attr($progStyClass); ?>" style="background-color:<?php echo esc_attr(get_option("DCPA_progressColor")); ?>;width:0%;<?php echo "height:".esc_attr(get_option("DCPA_progressHeight"));?>px;"></div>
	</div>
	
	<div style="background-color:<?php echo esc_attr(get_option("DCPA_adBackground")); ?>;<?php if(!get_option("DCPA_showPop") == 1 || is_user_logged_in() && get_option("DCPA_logged_modal") == 1 || $modalHTMLShow == 1) {?>display:none;<?php } ?>" id="progressModal" class="progressModal">
	  <?php if(get_option("DCPA_skipType") == 1) { ?>
	  <span class="pClose" style="<?php echo esc_attr($closeTypeRL).esc_attr($closeTypeUB); ?>background-color:<?php echo esc_attr(get_option("DCPA_closerButton")); ?>;color:<?php echo esc_attr(get_option("DCPA_closerTextButton")); ?>" id="progressCloser">X</span>
	  <?php } else if(get_option("DCPA_skipType") == 2 ) { ?>
	  <span class="pClose" style="<?php echo esc_attr($closeTypeRL).esc_attr($closeTypeUB); ?>background-color:<?php echo esc_attr(get_option("DCPA_closerButton")); ?>;color:<?php echo esc_attr(get_option("DCPA_closerTextButton")); ?>" id="progressSkipper"><?php if(get_option("DCPA_standText") == "") { echo esc_html__("Please wait...", "DCPA-plugin"); } else {echo esc_html(get_option("DCPA_standText")); }?></span>
	  <?php } ?>
	  <div class="progresContentArea"><?php echo do_shortcode(get_option('DCPA_customedit')) ?></div>
	</div>
<?php
}
}
}

add_action('wp_footer', 'DCPA_customableJS');
add_action('wp_footer', 'DCPA_customableHTML');
add_action( 'wp_enqueue_scripts', 'DCPA_progressFooter' );
add_action( 'wp_enqueue_scripts', 'DCPA_progressCSS' );

///////////// POST 

function DCPA_progMeta() {
	
$post_types = get_post_types( array('public' => true) );

add_meta_box(
    'DCPA-progAddMeta', // $id
    'Progress Ads Settings', // $title 
    'DCPA_progAddMeta', // $callback
     $post_types,
    'normal', // $context
    'high' // $priority
);

}

function DCPA_progAddMeta( $post ) {
	
		$values = get_post_custom ( $post->ID ); 
		
		//progress bar
		if (isset($values['DCPA_post_pb'][0])) 
			$postPbOn = $values['DCPA_post_pb'][0];	
		else
			$postPbOn = 0;
		
		//modal bar
		if (isset($values['DCPA_post_mb'][0])) 
			$postMbOn = $values['DCPA_post_mb'][0];	
		else
			$postMbOn = 0;
		
		
		wp_nonce_field( 'DCPA_nonce', 'meta_box_nonce' );
		?>
		
		<p>
		<label for="DCPA_post_pb"><input <?php if( $postPbOn == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_post_pb" type="checkbox">
		<?php printf( esc_html__("Hide %s for this post.", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( 'Progress Bar', 'DCPA-plugin' ) ) ); ?></label>
		</p>		
		<p>
		<label for="DCPA_post_mb"><input <?php if( $postMbOn == 1) {echo 'checked="checked"';} ?> value="1" name="DCPA_post_mb" type="checkbox">
		<?php printf( esc_html__("Hide %s for this post.", "DCPA-plugin"), sprintf( '<strong>%s</strong>', esc_html__( 'Modal Box (POPUP)', 'DCPA-plugin' ) ) ); ?></label>
		</p><?php
	}
add_action( 'add_meta_boxes', 'DCPA_progMeta' );

//save meta
add_action( 'save_post', 'DCPA_saveMeta' );
function DCPA_saveMeta( $post_id ) {
	// Autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'DCPA_nonce' ) ) return;

	// User can "edit_post"
	if( !current_user_can( 'edit_post' ) ) return;

	// Update data
	update_post_meta( $post_id, 'DCPA_post_pb', $_POST['DCPA_post_pb'] );
	update_post_meta( $post_id, 'DCPA_post_mb', $_POST['DCPA_post_mb'] );

}
		
}