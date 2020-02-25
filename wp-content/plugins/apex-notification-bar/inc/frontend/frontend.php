<?php defined('ABSPATH') or die("No script kiddies please!");
global $wpdb,$wp_query,$post;
// $post->ID = (isset($wp_query->post->ID) && $wp_query->post->ID != '')?$wp_query->post->ID:$post->ID;
if ( !is_object( $wp_query ) ) {
if ( !is_object( $post ) ) {
  $post = new stdClass(); 
  $postiD = (isset($post->ID) && $post->ID != '')?$post->ID:'';
} 
  $wp_query = new stdClass();
  $post->ID = (isset($wp_query->post->ID) && $wp_query->post->ID != '')?$wp_query->post->ID:$postiD;
}
$edn_setting = $this->apexnb_settings;
/* Default Bar Settings */
$edn_enable = $edn_setting['edn_pro_optons']; // check if bar is enable or not
$edn_disable_bar_on_categories = (isset($edn_setting['edn_disable_bar_on_categories']) && $edn_setting['edn_disable_bar_on_categories'] == 1)?1:0;  //hide bar on all category page new feature
 if(is_category() || is_product_category() && $edn_disable_bar_on_categories == 1){
  //hide bar on category page
 	$check_bar = 1;
 }else{
 	$check_bar = 0;
 }

$edn_default_top_bar = $edn_setting['edn_default_bar']; // top bar
$edn_default_bottom_bar = $edn_setting['edn_bottom_bar']; // bottom bar
$edn_default_left_bar = $edn_setting['edn_left_bar']; // left bar
$edn_default_right_bar = $edn_setting['edn_right_bar']; // right bar

$disable_mobile_bar = $edn_setting['edn_pro_mobile']; // check if enable notification bar in mobile.
$edn_notify_on_pages = $edn_setting['edn_notify_on_pages']; // restriction show bar on all pages or specific pages or only home page.
/* Default Bar Settings END */
$page_wise_settings = $this->get_page_wise_bar($post->ID); 
// $this->edn_pro_print_array($page_wise_settings);
/* For top bar */
if($edn_default_top_bar != "nobar"){

	 if( intval( $page_wise_settings['top_bar'] ) ){
		$topbar = $page_wise_settings['top_bar'];
		$tshow_default = 0;
	}else{
			if($page_wise_settings['top_bar'] == "default"){
	         $topbar = "show_top_bar";
	         $tshow_default = 1;
			}else if($page_wise_settings['top_bar'] == "disable"){
				$topbar = "hide_top_bar";
				$tshow_default = 0;
			}else if($page_wise_settings['top_bar'] == ""){
				$topbar = "show_top_bar";
				$tshow_default = 1;
			}else{
				$topbar = "hide_top_bar";
				$tshow_default = 0;
			}

	}
}else{
	if(intval($page_wise_settings['top_bar'])){
         $topbar = $page_wise_settings['top_bar'];
	}else{
		 $topbar = "hide_top_bar"; 
	}
	 $tshow_default = 0;
}
/* For bottom bar */
if($edn_default_bottom_bar != "nobar"){
	if($page_wise_settings['bottom_bar'] == "default"){
         $bottombar = "show_bottom_bar";
         $bshow_default = 1;
	}else if($page_wise_settings['bottom_bar'] == "disable"){
		$bottombar = "hide_bottom_bar";
		$bshow_default = 0;
	}else if($page_wise_settings['bottom_bar'] == ""){
				$bottombar = "show_bottom_bar";
				$bshow_default = 1;
	}else{
		$bottombar = $page_wise_settings['bottom_bar'];
		$bshow_default = 0;
	}
}else{
	if(intval($page_wise_settings['bottom_bar'])){
         $bottombar = $page_wise_settings['bottom_bar'];
	}else{
		 $bottombar = "hide_bottom_bar";   
	}
	$bshow_default = 0;
}
/* For left bar */
if($edn_default_left_bar != "nobar"){
	if($page_wise_settings['left_bar'] == "default"){
         $leftbar = "show_left_bar";
         $lshow_default = 1;
	}else if($page_wise_settings['left_bar'] == "disable"){
		$leftbar = "hide_left_bar";
		$lshow_default = 0;
	}else if($page_wise_settings['left_bar'] == ""){
				$leftbar = "show_left_bar";
				$lshow_default = 1;
	}else{
		$leftbar = $page_wise_settings['left_bar'];
		 $lshow_default = 0;
	}
}else{
	if(intval($page_wise_settings['left_bar'])){
         $leftbar = $page_wise_settings['left_bar'];
	}else{
		 $leftbar = "hide_left_bar"; 
	}
	  $lshow_default = 0;
}

/* For right bar */
if($edn_default_right_bar != "nobar"){
	if($page_wise_settings['right_bar'] == "default"){
          $rightbar = "show_right_bar";
          $rshow_default = 1;
	}else if($page_wise_settings['right_bar'] == "disable"){
		$rightbar = "hide_right_bar";
		$rshow_default = 0;
	}else if($page_wise_settings['right_bar'] == ""){
				$rightbar = "show_right_bar";
				$rshow_default = 1;
	}else{
		$rightbar = $page_wise_settings['right_bar'];
		$rshow_default = 0;
	}
}else{
	if(intval($page_wise_settings['right_bar'])){
         $rightbar = $page_wise_settings['right_bar'];
	}else{
		 $rightbar = "hide_right_bar"; 
	}
   $rshow_default = 0;
}

if((isset($_GET['apexnb_bar_preview']))){
	/* Check for preview display on frontend  */
	$nb_id = isset($_GET['nb_id'])?$_GET['nb_id']:'';
	$check_me  = "alwayshow";
	if($nb_id != '' && intval($nb_id)){
        $get_data_from_table = $this->get_notification_bar_data($nb_id);
		 include('frontend-bar.php');
	}
}else{
	$check_me =  "checkshow";
if($edn_enable == 1 && $check_bar != 1){
    if(!is_feed()){
       if($edn_notify_on_pages == "all_pages"){
       	 if(is_page()){
			/* FOR TOP BAR DISPLAY */
			if($topbar == "show_top_bar" && $tshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
                      include('frontend-bar.php');
                }else if( intval( $topbar ) && $tshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($topbar);
				  include('frontend-bar.php');

			}

		   /* FOR Bottom BAR DISPLAY */
			if($bottombar == "show_bottom_bar" && $bshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
                include('frontend-bar.php');
			}else if( intval( $bottombar ) && $bshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($bottombar);
				  include('frontend-bar.php');

			}


		   /* FOR Left BAR DISPLAY */
			if($leftbar == "show_left_bar" && $lshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
                include('frontend-bar.php');
			}else if( intval( $leftbar ) && $lshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($leftbar);
				  include('frontend-bar.php');

			}


		   /* FOR Right BAR DISPLAY */
			if($rightbar == "show_right_bar" && $rshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
                include('frontend-bar.php');
			}else if( intval( $rightbar ) && $rshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($rightbar);
				  include('frontend-bar.php');

			}
         }
	   //all pages end
	   }else if($edn_notify_on_pages == "show_on_all"){
        //show on whole website.
	   	/* FOR TOP BAR DISPLAY */

			if($topbar == "show_top_bar" && $tshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
                      include('frontend-bar.php');
                }else if( intval( $topbar ) && $tshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($topbar);
				  include('frontend-bar.php');

			}

		   /* FOR Bottom BAR DISPLAY */
			if($bottombar == "show_bottom_bar" && $bshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
                include('frontend-bar.php');
			}else if( intval( $bottombar ) && $bshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($bottombar);
				  include('frontend-bar.php');

			}


		   /* FOR Left BAR DISPLAY */
			if($leftbar == "show_left_bar" && $lshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
                include('frontend-bar.php');
			}else if( intval( $leftbar ) && $lshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($leftbar);
				  include('frontend-bar.php');

			}


		   /* FOR Right BAR DISPLAY */
			if($rightbar == "show_right_bar" && $rshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
                include('frontend-bar.php');
			}else if( intval( $rightbar ) && $rshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($rightbar);
				  include('frontend-bar.php');

			}
 

	   }else if($edn_notify_on_pages == "all_posts"){
          if(is_single()){
	   	/* FOR TOP BAR DISPLAY */
			if($topbar == "show_top_bar" && $tshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
                      include('frontend-bar.php');
                }else if( intval( $topbar ) && $tshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($topbar);
				  include('frontend-bar.php');

			}

		   /* FOR Bottom BAR DISPLAY */
			if($bottombar == "show_bottom_bar" && $bshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
                include('frontend-bar.php');
			}else if( intval( $bottombar ) && $bshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($bottombar);
				  include('frontend-bar.php');

			}


		   /* FOR Left BAR DISPLAY */
			if($leftbar == "show_left_bar" && $lshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
                include('frontend-bar.php');
			}else if( intval( $leftbar ) && $lshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($leftbar);
				  include('frontend-bar.php');

			}


		   /* FOR Right BAR DISPLAY */
			if($rightbar == "show_right_bar" && $rshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
                include('frontend-bar.php');
			}else if( intval( $rightbar ) && $rshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($rightbar);
				  include('frontend-bar.php');

			}
         }

        //all posts end
	   }else if($edn_notify_on_pages == "only_home_page"){
	   	if(is_front_page()) {

	   		/* FOR TOP BAR DISPLAY */
			if($topbar == "show_top_bar" && $tshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
                include('frontend-bar.php');
			}else if( intval( $topbar ) && $tshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($topbar);
				  include('frontend-bar.php');

			}

		   /* FOR Bottom BAR DISPLAY */
			if($bottombar == "show_bottom_bar" && $tshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
                include('frontend-bar.php');
			}else if( intval( $bottombar ) && $tshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($bottombar);
				  include('frontend-bar.php');

			}


		   /* FOR Left BAR DISPLAY */
			if($leftbar == "show_left_bar" && $lshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
                include('frontend-bar.php');
			}else if( intval( $leftbar ) && $lshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($leftbar);
				  include('frontend-bar.php');

			}


		   /* FOR Right BAR DISPLAY */
			if($rightbar == "show_right_bar" && $rshow_default == 1){
				$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
                include('frontend-bar.php');
			}else if( intval( $rightbar ) && $rshow_default == 0){
				 $get_data_from_table = $this->get_notification_bar_data($rightbar);
				  include('frontend-bar.php');
			}
	   	}else{
	   		$get_data_from_table = array();

	   	}

	  //home page display complete
	   }else if($edn_notify_on_pages == "specific_categories"){
       // show by category wise
	   	 if(isset($edn_setting['edn_display_categories']) && is_array($edn_setting['edn_display_categories'])){
                $showincategories = $edn_setting['edn_display_categories'];
            }else{
                $showincategories = array();
            }
	   		$categories = get_the_category( $post->ID );
				if( is_array($categories) && count($categories) > 0 ) {
					for($i = 0; $i < count($categories); $i++) {
						 if(in_array($categories[$i]->term_id, $showincategories)){
				                /* FOR TOP BAR DISPLAY */
								if($topbar == "show_top_bar" && $tshow_default == 1){
									$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
					                include('frontend-bar.php');
								}else if( intval( $topbar ) && $tshow_default == 0){
									 $get_data_from_table = $this->get_notification_bar_data($topbar);
									  include('frontend-bar.php');
								}
							   /* FOR Bottom BAR DISPLAY */
								if($bottombar == "show_bottom_bar" && $tshow_default == 1){
									$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
					                include('frontend-bar.php');
								}else if( intval( $bottombar ) && $tshow_default == 0){
									 $get_data_from_table = $this->get_notification_bar_data($bottombar);
									  include('frontend-bar.php');

								}

							   /* FOR Left BAR DISPLAY */
								if($leftbar == "show_left_bar" && $lshow_default == 1){
									$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
					                include('frontend-bar.php');
								}else if( intval( $leftbar ) && $lshow_default == 0){
									 $get_data_from_table = $this->get_notification_bar_data($leftbar);
									  include('frontend-bar.php');

								}

							   /* FOR Right BAR DISPLAY */
								if($rightbar == "show_right_bar" && $rshow_default == 1){
									$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
					                include('frontend-bar.php');
								}else if( intval( $rightbar ) && $rshow_default == 0){
									 $get_data_from_table = $this->get_notification_bar_data($rightbar);
									  include('frontend-bar.php');
								}
									 	
						 	
						 

                        }
					}
					
				}
	   }
	   else{

            if(isset($edn_setting['edn_display_pagess']) && is_array($edn_setting['edn_display_pagess'])){
                $showpages_array = $edn_setting['edn_display_pagess'];
            }else{
                $showpages_array = array();
            }
           if(!is_category()){
           	            if(in_array($post->ID, $showpages_array)){
		           	/* FOR TOP BAR DISPLAY */
					if($topbar == "show_top_bar" && $tshow_default == 1){
						$get_data_from_table = $this->get_notification_bar_data($edn_default_top_bar);
		                include('frontend-bar.php');
					}else if( intval( $topbar ) && $tshow_default == 0){
						 $get_data_from_table = $this->get_notification_bar_data($topbar);
						  include('frontend-bar.php');

					}

				   /* FOR Bottom BAR DISPLAY */
					if($bottombar == "show_bottom_bar" && $tshow_default == 1){
						$get_data_from_table = $this->get_notification_bar_data($edn_default_bottom_bar);
		                include('frontend-bar.php');
					}else if( intval( $bottombar ) && $tshow_default == 0){
						 $get_data_from_table = $this->get_notification_bar_data($bottombar);
						  include('frontend-bar.php');

					}


				   /* FOR Left BAR DISPLAY */
					if($leftbar == "show_left_bar" && $lshow_default == 1){
						$get_data_from_table = $this->get_notification_bar_data($edn_default_left_bar);
		                include('frontend-bar.php');
					}else if( intval( $leftbar ) && $lshow_default == 0){
						 $get_data_from_table = $this->get_notification_bar_data($leftbar);
						  include('frontend-bar.php');

					}


				   /* FOR Right BAR DISPLAY */
					if($rightbar == "show_right_bar" && $rshow_default == 1){
						$get_data_from_table = $this->get_notification_bar_data($edn_default_right_bar);
		                include('frontend-bar.php');
					}else if( intval( $rightbar ) && $rshow_default == 0){
						 $get_data_from_table = $this->get_notification_bar_data($rightbar);
						  include('frontend-bar.php');
					}

            }
           }
         
	   }

     }  // is feed close
} // is bar enable close
}

