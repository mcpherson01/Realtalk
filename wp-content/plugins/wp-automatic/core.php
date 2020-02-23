<?php



		// spintax
		require_once ('inc/class.spintax.php');
		
		
		// youtube
		require_once ('inc/youtube_class.php');
		
		/*
		 * ---* Auto Link Builder Class ---
		 */
		class wp_automatic {
			public $ch = '';
			public $db = '';
			public $spintax = '';
			public $plugin_url = '';
			public $wp_prefix = '';
			public $used_keyword = '';
			public $used_link ='';
			public $used_tags = '' ;
			public $duplicate_id = '';
			public $cached_file_path = '';
			public $minimum_post_timestamp = '';
			public $minimum_post_timestamp_camp = '';
			public $debug = false;
			public $translationSuccess ;
			public $currentCampID ;
			
			// Excluded links cache
			public $campExcludedLinks; // excluded links of the currecnt campaign comma separated
			public $campExcludedLinksFetched; // true if the excluded links fetched from the database
			
			// Duplicated links cache
			public $campOldDuplicateLinks; // duplicate links found from last run
			public $campOldDuplicateLinksFetched; // loaded or not?
			public $campNewDuplicateLinks; // new checked and found duplicate links
			public $campDuplicateLinksUpdate; // update them or not flag
			
			// Call limit
			public $sourceCallLimit; // number of times allowed to call the source if reached exists 
			public $sourceCallTimes; // number of times the source was called
			
			// Link sufix
			public $isLinkSuffixed;
			
			//proxy connected or not 
			public  $isProxified;
			
			//general banned words
			public $generalBannedWords;
			
			/*
			 * ---* Class Constructor ---
			 */
			function __construct() {
				// plugin url
				$siteurl = get_bloginfo ( 'url' );
				$this->plugin_url = $siteurl . '/wp-content/plugins/alb/';
				
				  echo '<br><small><i>Memory used before running the script: '.  number_format(memory_get_peak_usage()/(1024*1024),2) .'MB and DB queries count:'.get_num_queries() .'</i> </small>';
				
				// db
				global $wpdb;
				$this->db = $wpdb;
				$this->wp_prefix = $wpdb->prefix;
				// $this->db->show_errors();
				@$this->db->query ( "set session wait_timeout=28800" );
				
				// curl
				$this->ch = curl_init ();
				curl_setopt ( $this->ch, CURLOPT_HEADER, 0 );
				curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $this->ch, CURLOPT_CONNECTTIMEOUT, 10 );
				curl_setopt ( $this->ch, CURLOPT_TIMEOUT, 200 );
				curl_setopt ( $this->ch, CURLOPT_REFERER, 'http://www.bing.com/' );
				curl_setopt ( $this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36' );
				//curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
				
				curl_setopt ( $this->ch, CURLOPT_MAXREDIRS, 20 ); // Good leeway for redirections.
				@curl_setopt ( $this->ch, CURLOPT_FOLLOWLOCATION, 1 ); // Many login forms redirect at least once.
				
			 	@curl_setopt ( $this->ch, CURLOPT_COOKIEJAR, str_replace('core.php', 'cookie.txt', __FILE__) );
			 	@curl_setopt ( $this->ch, CURLOPT_COOKIEJAR,  'cookie.txt' );
			  	curl_setopt ( $this->ch, CURLOPT_SSL_VERIFYPEER, false );
				
				 
				//verbose	
				$verbose=fopen( str_replace('core.php', 'verbose.txt', __FILE__)  , 'w');
				curl_setopt($this->ch, CURLOPT_VERBOSE , 1);
				curl_setopt($this->ch, CURLOPT_STDERR,$verbose);
				 
				 
				
				// spintax
				$this->spintax = new Spintax ();
				
				// Ini excluded links				
				$this->campExcludedLinksFetched     =  false;
				$this->campOldDuplicateLinksFetched =  false;
				$this->campDuplicateLinksUpdate    =  false;
				$this->campNewDuplicateLinks       =  array();
				
				// Link suffix
				$this->isLinkSuffixed = false;
				
				// Call Limit 
				$this->sourceCallLimit = 2 ;
				$this->sourceCallTimes = 0 ;
				
				// proxified
				$this->isProxified = false;
				
				//wp_automatic_ccc_stop
				$this->generalBannedWords = get_option('wp_automatic_ccc_stop','');
				
			}
	 		
			/*
			 * ---* Function Process Campaigns ---
			 */
			function process_campaigns($cid = false) {
				
				// DB prefix
				$prefix = $this->db->prefix;
				
				// Single or all check
				if (trim ( $cid ) == '') {
					
					// All campaings
					$last = get_option ( 'gm_last_processed', 0 );
					
					// get all the campaigns from the db lower than the last processed
					$query = "SELECT * FROM {$this->wp_prefix}automatic_camps  where camp_id < $last ORDER BY camp_id DESC";
					$camps = $this->db->get_results ( $query );
					
					// check if results returned with id less than the last processed or not if not using regular method
					$query = "SELECT * FROM {$this->wp_prefix}automatic_camps WHERE  camp_id >= $last ORDER BY camp_id DESC";
					$camps2 = $this->db->get_results ( $query );
					
					// merging 2 arrays
					$camps = array_merge ( $camps, $camps2 );
				} else {
					
					// Single campaign process
					$query = "SELECT * FROM {$this->wp_prefix}automatic_camps  where camp_id = $cid ORDER BY camp_id DESC";
					$camps = $this->db->get_results ( $query );
				}
				 
				// check if need to process camaigns or skip
				if (count ( $camps ) == 0) {
					  echo '<br>No valid campaigns to process ';
					return;
				}else{
					if(trim($cid) == '')
					  echo '<br>DB contains '.count($camps).' campaigns<br>';
				}
				
				// now processing each fetched campaign
				$i = 0;
				foreach ( $camps as $campaign ) {
					
					// reading post status
					$status = get_post_status ( $campaign->camp_id );
					
					// if published process
					if ($status == 'publish') {
						if ($i != 0)
							  echo '<br>';
						  echo "<b>Processing Campaign</b> $campaign->camp_name {  $campaign->camp_id  }";
						 
						// updating the last id processed
						update_option ( 'gm_last_processed', $campaign->camp_id );
				 		
						//check if deserve spinning now or not
						if(trim($cid) == false){
								
							//read post every x minutes
							if( stristr($campaign->camp_general, 'a:') ) $campaign->camp_general=base64_encode($campaign->camp_general);
							$camp_general = unserialize (base64_decode( $campaign->camp_general) );
							$camp_general=array_map('wp_automatic_stripslashes', $camp_general);
							
							if(! is_array($camp_general) || ! isset($camp_general['cg_update_every']) ){
								$camp_general = array('cg_update_every'=>60 ,'cg_update_unit'=> 1);
							}
								
							$post_every = $camp_general['cg_update_every'] * $camp_general['cg_update_unit'];
								
							  echo '<br>Campaign scheduled to process every '.$post_every . ' minutes ';
							
							//get last check time 
							$last_update=get_post_meta($campaign->camp_id,'last_update',1);
							if(trim($last_update) == '') $last_update =1388692276 ;
							//  echo '<br>Last updated stamp '.$last_update;
							
							$difference = $this->get_time_difference($last_update, time());
							
							  echo '<br> last processing was <strong>'.$difference. '</strong> minutes ago ';
							
							if($difference > $post_every ){
								  echo '<br>Campaign passed the time and eligible to be processed';
								update_post_meta($campaign->camp_id,'last_update',time());
		
								$this->log ( '<strong>Cron</strong> >> eligible waiting campaign' , $campaign->camp_name .'{'.$campaign->camp_id .'} last processing was <strong>'.$difference. '</strong> minutes ago ');
								
								//process
								$this->log ( '<strong>Cron</strong> >> Processing Campaign:' . $campaign->camp_id, $campaign->camp_name .'{'.$campaign->camp_id .'}');
								$this->process_campaign ( $campaign );
							}else{
								  echo '<br>Campaign still not passed '.$post_every . ' minutes';
							}
							
							
						}else{
							
							// No cron just regular call
							
							// update last run
							update_post_meta($campaign->camp_id,'last_update',time());
							
							// process
							$this->log ( '<strong>User</strong> >> Processing Campaign:' . $campaign->camp_id, $campaign->camp_name .'{'.$campaign->camp_id .'}' );
							$this->process_campaign ( $campaign );
							
						}
						
						
						
						$i ++;
					} elseif (! $status) {
						// deleting Camp record
						$query = "delete from {$this->wp_prefix}automatic_camps where camp_id= '$campaign->camp_id'";
						$this->db->query ( $query );
						// deleting matching records for keywords
						$query = "delete from {$this->wp_prefix}automatic_keywords where keyword_camp ='$campaign->camp_id'";
						$this->db->query ( $query );
					}else{
						  echo 'Campaign should be published firstly to run..';
					}
				}
			}
			
			/*
			 * ---* Processing Single Campaign Function ---
			 */
			function process_campaign($camp) {
				
				// Ini get options
				$this->currentCampID = $camp->camp_id;
				
				
				$camp_post_every = $camp->camp_post_every;
				$wp_automatic_tw = get_option ( 'wp_automatic_tw', 400 );
				$wp_automatic_options = get_option('wp_automatic_options',array() );
				$camp_type = $camp->camp_type;
				$camp_post_custom_k = unserialize ( $camp->camp_post_custom_k );
				$camp_post_custom_v = unserialize ( $camp->camp_post_custom_v );
				
				
				//camp general options
				if( stristr($camp->camp_general, 'a:') ) $camp->camp_general=base64_encode($camp->camp_general);
				$camp_general = unserialize ( base64_decode( $camp->camp_general) );
				@$camp_general=array_map('wp_automatic_stripslashes', $camp_general);
				
				// get the count of posted posts so far
				$key = 'Posted:' . $camp->camp_id;
				$query = "select count(id) as count from {$this->wp_prefix}automatic_log where action='$key'";
				$temp = $this->db->get_results ( $query );
				$temps = $temp [0];
				$posted = $temps->count;
				
				
				// if maximum reached skip
				if ($camp_post_every <= $posted) {
					  echo '<br>The set maximum number of posts was reached. You have set this campaign to post a maximum of '.$camp_post_every. ' posts.';
					$this->log('Cancel Campaign', 'campaign reached maximum number of posts');
					return false;
				}
				
				// campaign options
				$camp_opt = unserialize ( $camp->camp_options );
				
				if (! is_array ( $camp_opt ))
					$camp_opt = array ();
				
				//link suffix
				if(in_array('OPT_LINK_PREFIX', $camp_opt)){
					$this->isLinkSuffixed = true;
				}
				
				// reading keywords that need to be processed
				$rawKeywords = trim($camp->camp_keywords);
				if(! stristr($rawKeywords, ',')){
					
					$newLinesCount = substr_count($rawKeywords, "\n");
					
					if($newLinesCount > 0 ){
						$keywords = explode("\n", $rawKeywords);
						 
						$rawKeywords = implode(',', $keywords);
						  echo '<br>keywords suspected to be one per line adapting...';
					}
					
				}
				
				$keywords = explode ( ',', $rawKeywords );
				$keywords=array_filter($keywords);
				$keywords=array_map('trim', $keywords);
				
				 
				// set minimum item date if exists
				if(in_array('OPT_YT_DATE', $camp_opt)){
					
					// check if dynamic date
					if(in_array('OPT_YT_DATE_T', $camp_opt) && is_numeric(trim($camp_general['cg_yt_dte_minutes'])) ){
						
						$cg_yt_dte_minutes = trim($camp_general['cg_yt_dte_minutes']);
						$current_time = time('now');
						$minimum_time = $current_time - $cg_yt_dte_minutes * 60;
						//  echo '<br>Minimum timestamp:'.$minimum_time;
						$this->minimum_post_timestamp = $minimum_time;
					}else{
						$this->minimum_post_timestamp = strtotime($camp_general['cg_yt_dte_year'].'-'.$camp_general['cg_yt_dte_month'].'-'.$camp_general['cg_yt_dte_day'].'T00:00:00.000Z');
					}
					
					
					$this->minimum_post_timestamp_camp = $camp->camp_id;
					
				}
				
				//Rotate Keywords
				if(in_array('OPT_ROTATE', $camp_opt)){
					  echo '<br>Rotating Keywords Enabled';
		
					//last used keyword 
					$last_keyword = get_post_meta($camp->camp_id ,'last_keyword',1);
					
					if( ! trim($last_keyword) == ''){
						//found last keyword usage let's split
						  echo '<br>Last Keyword: '.$last_keyword;
		
						//add all keywords after the last keyword
						$add = false;
						foreach ($keywords as $current_keword){
							if($add){
								//set add flag to add all coming keywords
								$rotatedKeywords[]=$current_keword;
								
							}elseif (trim($current_keword) == trim($last_keyword)) {
								$add = true; 
							} 
						}
						
					  //add all keywords before the last keyword
						foreach ($keywords as $current_keword){
							$rotatedKeywords[]=$current_keword;
							if(trim($current_keword) == trim ($last_keyword)) break ;
						
						}
						
					  //set keywords to rotated keywords
						if( count($rotatedKeywords) != 0 ) $keywords = $rotatedKeywords;
						$keywordsString = implode(',', $rotatedKeywords);
						$camp->camp_keywords=$keywordsString;
					 } 
				 }else{
				 	$camp->camp_keywords=implode(',', $keywords);
				 }
				 
				 //Rotate feeds
				 if(in_array('OPT_ROTATE_FEEDS', $camp_opt)){
				 	  echo '<br>Rotating feeds Enabled';
				 		
				 	//last used feed
				 	$last_feed = get_post_meta($camp->camp_id ,'last_feed',1);
				 	 
				 	if( ! trim($last_feed) == ''){
				 		//found last feed usage let's split
				 		  echo '<br>Last feed: '.$last_feed;
				 			
				 		//add all feeds after the last feed
				 		$add = false;
				 		$feeds = explode("\n", $camp->feeds);
				 		$feeds = array_filter($feeds);
				 		
				 		foreach ($feeds as $current_feed){
				 			
				 			if($add){
				 				//set add flag to add all coming feeds
				 				$rotatedfeeds[]=$current_feed;
				 					
				 			}elseif (trim($current_feed) == trim($last_feed)) {
				 				$add = true;
				 			}
				 		}
				 		 
				 			
				 		//add all feeds before the last feed
				 		foreach ($feeds as $current_feed){
				 			$rotatedfeeds[]=$current_feed;
				 			if(trim($current_feed) == trim ($last_feed)) break ;
				 				
				 		}
		
				 		//set feeds to rotated feeds
				 		if( count($rotatedfeeds) != 0 ) $feeds = $rotatedfeeds;
				 		$feedsString = implode("\n", $rotatedfeeds);
				 		$camp->feeds=$feedsString;
				 	}
				 }
				
				
				$post_content = stripslashes($camp->camp_post_content );
				$post_title = stripslashes( $camp->camp_post_title );
				
				 
				
				if(in_array('OPT_USE_PROXY', $camp_opt) && $camp_type != 'Articles' && $camp_type != 'ArticlesBase'){
					$this->fire_proxy ();
				}
				
				
				// ini content
				$abcont = '';
				if ($camp_type == 'Articles') {
					
					// proxyfy
					$this->fire_proxy ();
					
					$article = $this->articlebase_get_post ( $camp );
					$abcont = $article ['cont'];
					$title = $article ['title'];
					$source_link = $article ['source_link'];
					$img = $article;
					
				}elseif ($camp_type == 'ArticlesBase') {
					
					// proxyfy
					$this->fire_proxy ();
					
					$article = $this->articlebase_get_post ( $camp );
					$abcont = $article ['cont'];
					$title = $article ['title'];
					$source_link = $article ['source_link'];
					$img = $article;	
					
				} elseif ($camp_type == 'Feeds') {
					// feeds posting
					  echo '<br>Should get content from feeds';
					$article = $this->feeds_get_post ( $camp );
					$abcont = $article ['cont'];
					$title = $article ['title'];
					$source_link = $article ['source_link'];
					$img = $article;
				} elseif ($camp_type == 'Amazon') {
					  echo '<br>Trying to post a new Amazon product...';
					$product = $this->amazon_get_post ( $camp );
					
					//update offer url to add to chart
		 
					if ( in_array('OPT_LINK_CHART', $camp_opt) ) {
					 
						$product['product_link'] = $product['chart_url'];
						 
					}  
				 
					$img =$product;
				 
					$abcont = @$product ['offer_desc'];
					$title = @$product ['offer_title'];
					$source_link = @$product ['offer_url'];
					$product_img = @$product ['offer_img'];
					$product_price = @$product ['offer_price'];
				} elseif ($camp_type == 'Clickbank') {
					
					  echo '<br>Clickbank product is required';
					$img = $product = $this->clickbank_get_post ( $camp );
					$abcont = $product ['offer_desc'];
					$title = $product ['title'];
					$source_link = $product ['offer_link'];
					$product_img = $product ['img'];
					$product_original_link = $product ['original_link'];
					
					// print_r($product);
				} elseif ($camp_type == 'Youtube') {
					
					  echo '<br>Youtube Vid is required';
					$img = $vid = $this->youtube_get_post ( $camp );
					$abcont = $vid ['vid_desc'];
					$original_title = $vid ['vid_title'];
					$title = $vid ['vid_title'];
					$source_link = $vid ['vid_url'];
				
				} elseif($camp_type == 'Vimeo'){
				
					  echo '<br>Vimeo campaign let\'s get vimeo vid';
					
					$img = $vid = $this->vimeo_get_post ( $camp );
		
					//set player width and hieght 
					
					$abcont = $vid ['vid_description'];
					$original_title = $vid ['vid_title'];
					$title = $vid ['vid_title'];
					$source_link = $vid ['vid_url'];
					
				} elseif ($camp_type == 'Flicker') {
					  echo '<br>Flicker image is required';
					$img = $this->flicker_get_post ( $camp );
					
					$abcont = $img ['img_description'];
					$original_title = $img ['img_title'];
					$title = $img ['img_title'];
					$source_link = $img ['img_link'];
				} elseif ($camp_type == 'eBay') {
					  echo '<br>eBay item is required';
					$img = $this->ebay_get_post ( $camp );
					
					$abcont = $img ['item_desc'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
				}elseif($camp_type == 'Spintax'){ 
					
					  echo '<p>Processing spintax campaign';
					
					$abconts =$post_title . '(99999)' . $post_content;
					 
					if( in_array('OPT_TBS', $camp_opt) ){
						$abconts  = $this->spin ( $abconts );
					}
					
					if(in_array('OPT_SP_SIMILAR', $camp_opt)){
						$abconts = $this->spintax->spin ( $abconts, TRUE );
					}else{
						$abconts = $this->spintax->spin ( $abconts );
					}
					
					 
					
					$tempz = explode ( '(99999)', $abconts );
					
					// Rewrite the title
					if(! in_array('OPT_TBS_TTL', $camp_opt)){
						  echo '<br>Spinning the title';
						$post_title = $tempz [0];
					}
					
					
					$post_content = $tempz [1];
					$title =trim($post_title);
					$img=array();
				}elseif( $camp_type == 'Facebook' ){
					
					 $img = $this->fb_get_post($camp);
					 
					 $abcont = $img['matched_content'];
					 $original_title = $img ['original_title'];
					 $title = $img ['original_title'];
					 $source_link = $img ['original_link'];
					  
				}elseif ($camp_type == 'Pinterest' ){
					
					 $img = $this->pinterest_get_post($camp);
		 
					 $abcont = $img ['pin_description'];
					 $original_title = $img ['pin_title'];
					 $title = $img ['pin_title'];
					 $source_link = $img ['pin_url'];
					  
				}elseif ($camp_type == 'Instagram' ){
					
					 $img = $this->instagram_get_post($camp);
		 
					 $abcont = $img ['item_description'];
					 $original_title = $img ['item_title'];
					 $title = $img ['item_title'];
					 $source_link = $img ['item_url'];
					  
				}elseif($camp_type == 'Twitter' ){
					
					$img = $this->twitter_get_post($camp);
					 	
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_url'];
					
					
				}elseif($camp_type == 'SoundCloud' ){
					
					$img = $this->sound_get_post($camp);
					 	
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_url'];
					
					
				}elseif($camp_type == 'Craigslist' ){
					
					$img = $this->craigslist_get_post($camp);
					 	
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
				
				}elseif($camp_type == 'Reddit' ){
						
					$img = $this->reddit_get_post($camp);
						
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_url'];
				
				}elseif($camp_type == 'Careerjet' ){
					
					$img = $this->careerjet_get_post($camp);
					
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_url'];
					
				}elseif($camp_type == 'Itunes' ){
					$img = $this->itunes_get_post($camp);
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
				
				}elseif($camp_type == 'Envato' ){
				
					$img = $this->envato_get_post($camp);
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
					
				}elseif($camp_type == 'DailyMotion' ){
				
					$img = $this->DailyMotion_get_post($camp);
					
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
				
				}elseif($camp_type == 'Walmart' ){
				
					$img = $this->walmart_get_post($camp);
					 
					$abcont = $img ['item_description'];
					$original_title = $img ['item_title'];
					$title = $img ['item_title'];
					$source_link = $img ['item_link'];
				
				}elseif($camp_type == 'Single' ){
					
					$img = $this->single_get_post($camp);
					
					$abcont = $img ['matched_content'];
					$original_title = $img ['original_title'];
					$title = $img ['original_title'];
					$source_link = $img ['source_link'];
				}
				
				// featured_img_local_source ini
				$img['featured_img_local_source'] = '';
				$img['featured_img_source'] = '';
				
				// link suffix
				if($this->isLinkSuffixed == true){
					if(stristr($source_link, '?')){
						$source_link = $source_link.'&rand='.$this->currentCampID ;
					}else{
						$source_link = $source_link.'?rand='.$this->currentCampID ;
					}
				}
				
				//limit the content returned
				if(in_array('OPT_LIMIT', $camp_opt)){
					  echo '<br>Triming post content to '.$camp_general['cg_content_limit'] . ' chars';
					$abcont = $this->truncateHtml($abcont,$camp_general['cg_content_limit']);
				}
				
				if(in_array('OPT_LIMIT_TITLE', $camp_opt) && trim($title) != ''){
					  echo '<br>Triming post title to '.$camp_general['cg_title_limit'] . ' chars';
					
					$titleCharsCount = $this->chars_count($title);
					
					if( $camp_general['cg_title_limit'] < $titleCharsCount ){
						
						$non_truncated_title =$title;
					
						if(function_exists('mb_substr')){
							$title = mb_substr($title, 0,$camp_general['cg_title_limit']);
						}else{
							$title = substr($title, 0,$camp_general['cg_title_limit']);
							
						}
						
						$title = $this->removeEmoji($title);
						
						
						// remove last truncated word
						if( in_array( 'OPT_LIMIT_NO_TRUN', $camp_opt) ){
							
							//get last truncated word
							$truncated_title_parts = explode(' ', $title);
							$last_truncated_word = $truncated_title_parts[count($truncated_title_parts) - 1];
							
							//check if really truncated 
							$non_truncated_title_parts =explode(' ', $non_truncated_title);
						 
							foreach ($non_truncated_title_parts as $non_truncated_word){
								
								if($non_truncated_word === $last_truncated_word){
									
									//last truncated word is not truncated 
									break;
									
								}
								
							}
							
							if($non_truncated_word === $last_truncated_word){
								
							}else{
								unset($truncated_title_parts[count($truncated_title_parts) - 1] );
								$title = implode(' ', $truncated_title_parts); 
							}
							
							
						}
							
						if( ! in_array( 'OPT_LIMIT_NO_DOT', $camp_opt) )
							$title = $title . '...';
							 
						
					}
		
				}
				 
				
				// check if valid content fetched before filling the template
				if (trim ( $title ) != '') {
					
					// Validate if the content contains wanted or execluded texts
					
					$valid = true;
					
					$exact = $camp->camp_post_exact;
					$execl = $camp->camp_post_execlude;
					$execr = '';
					$execr = @$camp_general['cg_camp_post_regex_exact'];
					$excludeRegex = @$camp_general['cg_camp_post_regex_exclude'];

					$valid = $this->validate_exacts($abcont, $title, $camp_opt, $camp,false,$camp_general);
					
					
					
					// duplicate title check
					if($valid == true){
						//check if there is a post published with the same title
						if(in_array('OPT_FEED_TITLE_SKIP',$camp_opt)  ) {
							if($this->is_title_duplicate($title,$camp->camp_post_type)){
								  echo '<-- duplicate title skipping..';
								$valid = false;
							}
						}
						
					}
					
					
					// if not valid process the campaign again and exit
					if ($valid == false) {
						
						//blacklisting the link so we don'g teg it again and cause a loop
						$this->link_execlude($camp->camp_id, $source_link);
						$this->process_campaign ( $camp );
						exit ();
					}
					
					// strip links
					if (in_array ( 'OPT_STRIP', $camp_opt )) {
						  echo '<br>Striping links ';
						//$abcont = strip_tags ( $abcont, '<p><img><b><strong><br><iframe><embed><table><del><i><div>' );
						
						
						preg_match_all('{<a.*?>(.*?)</a>}' , $abcont , $allLinksMatchs);
						
						$allLinksTexts    = $allLinksMatchs[1];
						$allLinksMatchs=$allLinksMatchs[0];
						
						$j = 0;
						foreach ($allLinksMatchs as $singleLink){
							
							if(! stristr($singleLink, 'twitter.com'))
							$abcont = str_replace($singleLink, $allLinksTexts[$j], $abcont);
							
							$j++;
						}
						
						
						if( $camp_type == 'Youtube' ){
							  echo '...striping inline links';
							$abcont = preg_replace('/https?:\/\/[^<\s]+/', '', $abcont);
						} 
						 
					}
					
					// translate the cotent
					if (in_array ( 'OPT_TRANSLATE', $camp_opt ) && trim ( $abcont ) != '') {
						  echo '<br>Translating the post...' . $title;
						   
						  //to translate tags
						  $tagsToTranslate= '';
						  if(isset($img['tags']) && trim($img['tags']) != '' ){
						  	$tagsToTranslate = trim($img['tags']);
						  }
						  
						  if(isset($img['custom_fields'])){
						  	foreach ($img['custom_fields'] as $customFieldArr ){
						  		if($customFieldArr[0] == 'tags'){
						  			$tagsToTranslate = $customFieldArr[1];
						  			break;
						  		}
						  	}
						  }
							
						  // YT tags 
						  if( trim($this->used_tags) != ''){
						  	$tagsToTranslate = $this->used_tags;
						  }
						  
						  if(  trim($tagsToTranslate) != ''){
						  
						  	$tagsToTranslate =  explode(',', $tagsToTranslate) ;
						  	$tagsToTranslate = array_filter($tagsToTranslate);
						  	$tagsToTranslate=array_map('trim', $tagsToTranslate);
						  	$tagsToTranslate=implode('[t]', $tagsToTranslate);
						  	
						  	$abcont = $abcont . '  .[tagsToTranslate]'. $tagsToTranslate ;
						  
						  }

							// Translation Method 
							$translationMethod = $camp_general['cg_translate_method'];
							
							if($translationMethod != 'googleTranslator'){
								$translationMethod = 'microsoftTranslator';
							}
						
							// Translation success flag ini
							$this->translationSuccess = false ;
							
							$translation = $this->gtranslate ( $title, $abcont, $camp->camp_translate_from, $camp->camp_translate_to ,$translationMethod);
							 
							if (in_array ( 'OPT_TRANSLATE_TITLE', $camp_opt )) {
								$title = $translation [0];
							}
							
							$abcont = $translation [1];
							
							// check if another translation needed
							if (trim ( $camp->camp_translate_to_2 ) != 'no' && trim($camp->camp_translate_to_2) !='' ) {
								// another translate
								 
								  echo '<br>translating the post another time ';
								$translation = $this->gtranslate ( $title, $abcont, $camp->camp_translate_to, $camp->camp_translate_to_2 ,$translationMethod);
								
								if (in_array ( 'OPT_TRANSLATE_TITLE', $camp_opt )) {
									$title = $translation [0];
								}
								
								$abcont = $translation [1];
							}
						 	
							//strip tagstotransate 
							if(stristr($abcont, 'tagsToTranslate') || stristr($abcont, '[t]')){
								preg_match('{\[tagsToTranslate\](.*)}', $abcont , $tagMatchs);
								$tagsTranslated = $tagMatchs[1];
								$tagsTranslated = str_replace('[t]', ',' , $tagsTranslated);
								
								//strip the tags
								$abcont = preg_replace('{\[tagsToTranslate.*}', '', $abcont);
								
								if(stristr($abcont, '[t]')){
									
									preg_match('{\[t\].*}', $abcont , $tagMatchs);
									$tagsTranslated = $tagMatchs[0];
									$tagsTranslated = explode('[t]', $tagsTranslated);
									$tagsToTranslate= implode(',', array_filter($tagsTranslated));
									
									$abcont = preg_replace('{\[t\].*}', '', $abcont);
									
								}
								
								//restore tags
								if(isset($img['tags']) && trim($img['tags']) != '' ){
									  $img['tags'] = $tagsTranslated;
								}elseif(trim($this->used_tags) != ''){
									$this->used_tags = $tagsTranslated;
								}
								
								$newFields = array();
								if(isset($img['custom_fields'])){
									foreach ($img['custom_fields'] as $customFieldArr ){
										if($customFieldArr[0] == 'tags'){
											$newFields[] = array('tags' , $tagsTranslated) ;
										}else{
											$newFields[] = $customFieldArr;
 										}
									}
									$img['custom_fields'] = $newFields;
								}
								
								
								
							}
						 
					}
					
					// replacing general terms title and source link
					if(isset($source_link)) $post_content = str_replace ( '[source_link]', $source_link, $post_content );
					$post_title = @str_replace ( '[original_title]',strip_tags( $title), $post_title );
					
					$post_content = str_replace ( '[original_title]', $title, $post_content );
					
					if ($camp_type == 'Feeds' ) {
						
							$post_content = str_replace ( '[matched_content]', $abcont, $post_content );
							
					}elseif(  $camp_type == 'Articles' || $camp_type == 'ArticlesBase'){
						
							$post_content = str_replace ( '[matched_content]', $abcont, $post_content );
						
					} elseif ($camp_type == 'Amazon') {
						
						$post_content = str_replace ( '[product_desc]', $abcont, $post_content );
						$post_content = str_replace ( '[product_img]', $product_img, $post_content );
						//$post_content = str_replace ( '[product_link]', $source_link, $post_content );
						$post_content = str_replace ( '[product_price]', $product_price, $post_content );

						//remove built-in gallery for amazon products when a woo gallery is used
						if( $camp->camp_post_type == 'product' && in_array('OPT_AM_GALLERY', $camp_opt)){
							$post_content = str_replace('[product_imgs_html]', '', $post_content);
						}
							
						
					} elseif ($camp_type == 'Clickbank') {
						$post_content = str_replace ( '[product_desc]', $abcont, $post_content );
						$post_content = str_replace ( '[product_img]', $product_img, $post_content );
						$post_content = str_replace ( '[product_link]', $source_link, $post_content );
						$post_content = str_replace ( '[product_original_link]', $product_original_link, $post_content );
					} elseif ($camp_type == 'Youtube') {
						
						$post_content = str_replace ( '[vid_player]', addslashes ( $vid ['vid_player'] ), $post_content );
						$post_content = str_replace ( '[vid_desc]', $abcont, $post_content );
						$post_content = str_replace ( '[vid_views]', $vid ['vid_views'], $post_content );
						$post_content = str_replace ( '[vid_rating]', $vid ['vid_rating'], $post_content );
						$post_content = str_replace ( '[vid_img]', $vid ['vid_img'], $post_content );
					}elseif($camp_type == 'eBay'){
						
						$post_content = str_replace('[item_desc]', $abcont, $post_content);
						
						if(stristr($post_content, '[item_images]') && is_array($img['item_images']) ){
							
							$cg_eb_full_img_t = html_entity_decode( $camp_general['cg_eb_full_img_t']);
		
							$imgs = $img['item_images'];
							
							if(! stristr($cg_eb_full_img_t, '[img_src]') ) {
								$cg_eb_full_img_t = '<img src="[img_src]" class="wp_automatic_gallery" />';
							} 
							
							$contimgs='';
							foreach ($imgs as $newimg){
								$tempimg =$cg_eb_full_img_t;
								$contimgs.= str_replace('[img_src]', $newimg, $tempimg);
							}
							
							$post_content = str_replace('[item_images]', $contimgs, $post_content);
							
						}
						
					}elseif ($camp_type == 'Flicker'   ) {
					
						$post_content = str_replace ( '[img_description]', $abcont, $post_content );
					
					} elseif( $camp_type == 'Vimeo' ) {	
						
						$post_content = str_replace('[vid_description]', $abcont, $post_content);
						
						//set player width and height 
						$vm_width = $camp_general['cg_vm_width'];
						$vm_height = $camp_general['cg_vm_height'];
						
						if(trim($vm_width)!= ''){
							$img['vid_embed'] = $vid['vid_embed'] = str_replace('width="560"', 'width="'.$vm_width.'"', $vid['vid_embed']);
						}
		
						if(trim($vm_height)!= ''){
							$img['vid_embed'] = $vid['vid_embed'] = str_replace('height="315"', 'height="'.$vm_height.'"', $vid['vid_embed']);
						}
		
					}elseif( $camp_type == 'Pinterest' ){ 	
						
						$post_content = str_replace ( '[pin_description]', $abcont, $post_content );
		
					}elseif( $camp_type == 'Instagram' ){
						
						$post_content = str_replace('[item_description]', $abcont, $post_content);
						
						// if video hide it's image 
						if(stristr($abcont, '[embed') && ! in_array('OPT_IT_NO_VID_IMG_HIDE', $camp_opt) ){
							  echo '<br>Hiding vid image';
							$post_content = str_replace('[item_img]"', '[item_img]" style="display:none;" ', $post_content);
							$post_content = str_replace('[item_img]\"', '[item_img]\" style="display:none;" ', $post_content);
						}
						
					}elseif( $camp_type == 'Twitter' ){
						
						$post_content = str_replace('[item_description]', $abcont, $post_content); 
						
					}elseif(  $camp_type == 'Facebook'  || $camp_type == 'Single'){
						$post_content = str_replace('[matched_content]', $abcont, $post_content);
					}elseif($camp_type == 'SoundCloud' || $camp_type == 'Craigslist' || $camp_type == 'Itunes' || $camp_type == 'Envato' || $camp_type == 'DailyMotion' || $camp_type == 'Reddit' || $camp_type == 'Walmart' || $camp_type == 'Careerjet'  ){
						$post_content = str_replace('[item_description]', $abcont, $post_content);
						
					} else {
						$post_content .= "<br>$abcont";
					}
					
					// Replacing generic tags
					if(stristr($this->used_keyword, '_')) {
						$pan=explode('_', $this->used_keyword);
						$this->used_keyword = $pan[1];
					}
					
					$post_content = str_replace('[keyword]', $this->used_keyword, $post_content);
					$post_title = str_replace('[keyword]', $this->used_keyword, $post_title);
				 
					//replacing attributes
					foreach ( $img as $key => $val ) {
						
						if( ! is_array($val)){
							$post_content = str_replace ( '[' . $key . ']', $val, $post_content );
							$post_title = str_replace ( '[' . $key . ']', $val, $post_title );
						}
					
					}
					 
					// replacing custom attributes for feeds
					if($camp_type == 'Feeds'){
						
						$attributes = $img['attributes'];
						
						foreach ($attributes as $attributeKey => $attributeValue){
							
							$post_content = str_replace('['.$attributeKey.']', $attributeValue[0]['data'] , $post_content);
							
						}
					}
					
					// formated date
					if(stristr($post_content ,'formated_date') || stristr($post_title, 'formated_date') ){
						
						$post_title = do_shortcode($post_title);
						$post_content = do_shortcode($post_content);
						
					}
					
					
					// replacing the keywords with affiliate links
					if (in_array ( 'OPT_REPLACE', $camp_opt )) {
						foreach ( $keywords as $keyword ) {
							
							$keyword = trim($keyword);
							
							if (trim ( $keyword != '' )) {
								//$post_content = str_replace ( $keyword, '<a href="' . $camp->camp_replace_link . '">' . $keyword . '</a>', $post_content );
								
								$post_content = preg_replace ( '/\b'.preg_quote($keyword,'/').'\b/', '<a href="' . $camp->camp_replace_link . '">' . $keyword . '</a>', $post_content );
							}
						}
					}
					
				
					
					//replacing patterns 
					if(in_array('OPT_RGX_REPLACE', $camp_opt)){
						
						$regex_patterns = trim($camp_general['cg_regex_replace']);
						  echo '<br>Replacing using REGEX';
						
						//title only flag
						$isTitleOnly = false;
						
						if(stristr($regex_patterns, '|titleonly')){
							$isTitleOnly=true;
							$regex_patterns=str_replace('|titleonly', '', $regex_patterns) ;
						}
						 
						
						//protecting tags 
						if(in_array('OPT_RGX_REPLACE_PROTECT', $camp_opt)){
							  echo '..protecting tags.';
							
							preg_match_all("/<[^<>]+>/is",$post_content,$matches,PREG_PATTERN_ORDER);
							$htmlfounds=$matches[0];
							 	
							//extract all fucken shortcodes
							$pattern="\[.*?\]";
							preg_match_all("/".$pattern."/s",$post_content,$matches2,PREG_PATTERN_ORDER);
							$shortcodes=$matches2[0];
							
							$htmlfounds = array_merge($htmlfounds,$shortcodes);
							
							$htmlfounds = array_filter( array_unique($htmlfounds) );
							
							 
							$i=1;
							foreach ($htmlfounds as $htmlfound){
								
								$post_content = str_replace($htmlfound, "[" . str_repeat('*', $i) . "]", $post_content);
								$i++;
								
							}
							
							 
						}
						
						if(stristr($regex_patterns, '|')){
							$regex_patterns_arr = explode("\n",$regex_patterns);
							
							foreach ($regex_patterns_arr as $regex_pattern){
								
								$regex_pattern = trim($regex_pattern);
								
								if(stristr($regex_pattern, '|')){
									
									$regex_pattern_parts = explode('|', $regex_pattern);
									
									$regex_pattern_search = $regex_pattern_parts[0];
 									
									if(count($regex_pattern_parts) > 2 ){
										
										$regex_pattern_replace = $regex_pattern_parts[rand(1,count($regex_pattern_parts) - 1)];
									}else{
										$regex_pattern_replace = $regex_pattern_parts[1];
									}
									
									  echo '<br>Replacing '.htmlentities($regex_pattern_search) .' with '.htmlentities($regex_pattern_replace);
									
									//  echo $post_content;
									//exit;
									
									if(! $isTitleOnly){
										if( ! in_array('OPT_RGX_REPLACE_WORD', $camp_opt)){
											$post_content = preg_replace('{'.$regex_pattern_search.'}su', $regex_pattern_replace, $post_content);
										}else{
											$post_content = preg_replace('{\b'.preg_quote( $regex_pattern_search ).'\b}su', $regex_pattern_replace, $post_content);
										}
									}else{
										  echo ' on titles only';
									}
									
									if(in_array('OPT_RGX_REPLACE_TTL', $camp_opt) || $isTitleOnly){
										
										if( ! in_array('OPT_RGX_REPLACE_WORD', $camp_opt)){
											$post_title = preg_replace('{'.$regex_pattern_search.'}su', $regex_pattern_replace, $post_title);
										}else{
											$post_title = preg_replace('{\b'.preg_quote( $regex_pattern_search ).'\b}su', $regex_pattern_replace, $post_title);
										}
										
									}
									
								}
								
							}
							
						}
						
						//restore protected tags
						if( isset($htmlfounds) and count($htmlfounds) >0 ){
							
							//restoring
							$i = 1;
							foreach ($htmlfounds as $htmlfound){
								$post_content = str_replace('['.str_repeat('*', $i).']', $htmlfound, $post_content);
								$i++; 
							}
							
							
						}
						
					}
					
					// cache images locally ?
					if (in_array ( 'OPT_CACHE', $camp_opt ) || $camp_type == 'Instagram'  || $camp_type == 'Clickbank') {
						
						//strip srcset  srcset=
						if(! in_array('OPT_FEED_SRCSET', $camp_opt)){
							$post_content= preg_replace('{srcset=".*?"}', '', $post_content);
							$post_content= preg_replace('{sizes=".*?"}', '',  $post_content );
						}
						
						preg_match_all ( '/<img [^>]*src=["|\']([^"|\']+)/i', stripslashes ( $post_content ), $matches );
						
						$srcs = $matches [1];
						$srcs = array_unique ( $srcs );
						$current_host = parse_url ( home_url (), PHP_URL_HOST );
						foreach ( $srcs as $image_url ) {
							
							//check inline images
							if(stristr($image_url, 'data:image')){
								continue;
							}
							 
							//instantiate so we replace . note we modify image_url 
							$image_url_original = $image_url;
							
							//decode html entitiies
							$image_url = html_entity_decode($image_url);
							
							if(stristr($image_url, '%') ) {
								$image_url = urldecode($image_url);
							}
							
							//file name to store
							$filename = basename ( $image_url );
								
							//clean names
							if(in_array('OPT_CACHE_CLEAN' , $camp_opt   )){
								
								$clean_name = '';
								$clean_name =  sanitize_file_name($post_title);
								
								
								
								if(trim($clean_name) != ""){
									
									//get the image extension \.\w{3}
									$ext = pathinfo($filename, PATHINFO_EXTENSION);
									
									if(stristr($ext, '?')){
										$ext_parts = explode('?',$ext);
										$ext = $ext_parts[0];
									}
									
									//clean parameters after filename 
									$filename = trim($clean_name);
									
									
									if( trim($ext) !='' ){
										$filename = $filename .'.'. $ext;
									}
									
								}
								
							}
							
							
							
							if(stristr($image_url, '%') || stristr($filename, '%') ){
								$filename = urldecode($filename);
							}
							
							 
							if(stristr($image_url ,' ')){
								$image_url = str_replace(' ', '%20', $image_url);
							} 
							
							$imghost = parse_url ( $image_url, PHP_URL_HOST );
							
							if(stristr($imghost, 'http://')){
								$imgrefer=$imghost;
							}else{
								$imgrefer = 'http://'.$imghost;
							}
							 
							
							if ($imghost != $current_host ) {
								  echo '<br>Caching image: ' . $image_url;
								
								 
								// let's cache this image
								// set thumbnail
								$upload_dir = wp_upload_dir ();
		 						
								
								//curl get
								$x='error';
								curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
								curl_setopt($this->ch, CURLOPT_URL, trim($image_url));
								
								//empty referal 
								if(! in_array('OPT_CACHE_REFER_NULL', $camp_opt) ){
									curl_setopt ( $this->ch, CURLOPT_REFERER, $imgrefer );
								}else{
									curl_setopt ( $this->ch, CURLOPT_REFERER, '' );
								}
								
								 
								curl_setopt ( $this->ch, CURLOPT_HEADER, 0 );
								 
								$image_data=$this->curl_exec_follow($this->ch);
								$contentType = curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);
								
								if(! stristr($contentType, 'image')){
									echo '<-- can not verify if the content returned is an image skipping';
									continue;
								}
								 
								
								$image_data_md5 = md5($image_data);
								
								//check if already cached before
								$is_cached = $this->is_cached($image_url , $image_data_md5);
								if( $is_cached != false ){
									  echo '<--already cached';
									$post_content = str_replace ( $image_url_original, $is_cached , $post_content );
									continue;
								}
								
								
								
								  
								$x=curl_error($this->ch);
						 
		
								if(trim($image_data) != ''){
									
									$x=curl_error($this->ch);
								 
									if (stristr ( $filename, '?' )) {
										$farr = explode ( '?', $filename );
										$filename = $farr [0];
									}
									
									if (wp_mkdir_p ( $upload_dir ['path'] ))
										$file = $upload_dir ['path'] . '/' . $filename;
									else
										$file = $upload_dir ['basedir'] . '/' . $filename;
										
										// check if same image name already exists
									
									if (file_exists ( $file )) {
										$filename =  time ( 'now' ) .'_'. rand(0,999)  . '_' . $filename;
										
										if (wp_mkdir_p ( $upload_dir ['path'] ))
											$file = $upload_dir ['path'] . '/' . $filename;
										else
											$file = $upload_dir ['basedir'] . '/' . $filename;
									} else {
									}
									 
									
									file_put_contents ( $file, $image_data );
									$file_link = $upload_dir ['url'] . '/' . $filename;
									 									
									// replace original src with new file link
									$post_content = str_replace ( $image_url_original, $file_link, $post_content );
									$this->img_cached($image_url_original, $file_link,$image_data_md5,$file);
									
									  echo '<-- cached';
								}else{
									  echo '<-- can not get image content '.$x;
								}
								
							
							}
						} // end foreach image
					}
					
					// replacing words that should be replaced
					$sets = stripslashes(get_option ( 'wp_automatic_replace', '' ) );
					
					
					//exit;
					$sets_arr = explode ( "\n", $sets );
					
					foreach ( $sets_arr as $set ) {
						if (trim ( $set ) != '' && stristr ( $set, '|' )) {
							
							// valid set let's replace
							$set_words = explode ( '|', $set );
							 
							
							// cleaning empty words
							$i = 0;
							foreach ( $set_words as $setword ) {
								if (trim ( $setword ) == '') {
									unset ( $set_words [$i] );
								}
								$i ++;
							}
							
							if (count ( $set_words ) > 1) {
								// word 1
								
								$word1 = trim($set_words [0]);
								
								// randomize replacing word
								$rand = rand ( 1, count ( $set_words ) - 1 );
								$replaceword = trim($set_words [$rand]);
								
								  echo '<br>replacing "'.$word1.'" by "'.$replaceword.'"' ;
								
								if( in_array('OPT_REPLACE_NO_REGEX', $wp_automatic_options) ){
									
									$post_title = str_replace  (  $word1 , $replaceword, $post_title );
									$post_content = str_replace (   $word1 , $replaceword, $post_content );
									
								}else{
									
									$post_title = preg_replace ( '/\b' . trim ( preg_quote( $word1,'/') ) . '\b/iu', $replaceword, $post_title );
									$post_content = preg_replace ( '/\b' . trim (  preg_quote( $word1,'/') ) . '\b/iu', $replaceword, $post_content );
								}
								
								
							}
						}
					}
					
				 
					$abcontTxt = $camp->camp_post_content;
					$abtitleTxt = $camp->camp_post_title;
						
					// spin the content
					if (in_array ( 'OPT_TBS', $camp_opt ) && trim ( $abcontTxt ) != ''   || stristr($abcontTxt, '{') && stristr($abcontTxt, '}')  && stristr($abcontTxt, '|')  || stristr($abtitleTxt, '{') && stristr($abtitleTxt, '}')  && stristr($abtitleTxt, '|') )  {
						
						if($camp_type != 'Spintax'){
						
							  echo '<br>Spin the content enabled';

							$abconts = $post_title . '(99999)' . $post_content;
							
							if (in_array ( 'OPT_TBS', $camp_opt )){
								$abconts =$this->spin ( $abconts );
							}
							
							$abconts = $this->spintax->spin ( $abconts );
							$tempz = explode ( '(99999)', $abconts );
							
							// Rewrite the title
							if(! in_array('OPT_TBS_TTL', $camp_opt)){
								  echo '<br>Spinning the title';
								$post_title = $tempz [0];
							}
							
							$post_content = $tempz [1];
							
							
							//remove nospin tags
							$post_title = str_replace('[nospin]', '', $post_title);
							$post_title = str_replace('[/nospin]', '', $post_title);
							$post_content = str_replace('[nospin]', '', $post_content);
							$post_content = str_replace('[/nospin]', '', $post_content);
							
						}//not spintax
					}
					
					
					
					//categories for post
					if( stristr($camp->camp_post_category, ',') ) {
						$categories = array_filter(explode(',',$camp->camp_post_category ));
					}else{
						$categories = array ($camp->camp_post_category);
					}
					
					
					//check if dummy title (notitle)
					if($post_title == '(notitle)') $post_title = '';
					
					// Keyword to category 
					if(in_array('OPT_KEYWORD_CAT', $camp_opt) && trim($camp_general['cg_keyword_cat']) != '' ){
						  echo '<br>Keyword to category check started...';
						
						$cg_keyword_cat = $camp_general['cg_keyword_cat'];
						$cg_keyword_cat_rules = array_filter( explode("\n", $cg_keyword_cat) );
						
						foreach ($cg_keyword_cat_rules as $cg_keyword_cat_rule) {
							if(stristr( $cg_keyword_cat_rule , '|')){
								
								$cg_keyword_cat_rule = trim($cg_keyword_cat_rule);
								
								$cg_keyword_cat_rule_parts = explode ('|', $cg_keyword_cat_rule) ;
								
								$cg_keyword_cat_rule_keyword  = $cg_keyword_cat_rule_parts[0];
								$cg_keyword_cat_rule_category = $cg_keyword_cat_rule_parts[1];
								
								if( preg_match('{\b' . preg_quote( $cg_keyword_cat_rule_keyword ). '\b}siu', $post_content) || (stristr($cg_keyword_cat_rule_keyword, '#') && stristr($post_content, trim($cg_keyword_cat_rule_keyword))  )){
									
									  echo '<br><- Key '.$cg_keyword_cat_rule_keyword . ' exists adding category:'.$cg_keyword_cat_rule_category;
									
									if(is_numeric($cg_keyword_cat_rule_category)){
										$categories[]=$cg_keyword_cat_rule_category;
										 
									}elseif( stristr($cg_keyword_cat_rule_category, ',') ){
										$categories = array_merge($categories,explode(',', $cg_keyword_cat_rule_category));
									}
									
								}
								
							}
						}
						
					}
					
					// post status 
					if(in_array('OPT_DRAFT_PUBLISH', $camp_opt) && $camp->camp_post_status == 'publish'){
						  echo '<br>Setting post status to draft temporarily';
						$postStatus = 'draft' ;
						
					}else{
						
						$postStatus = $camp->camp_post_status;
						
					}
					
					// building post
					$my_post = array (
							'post_title' => ( $post_title),
							'post_content' =>  $post_content,
							'post_status' => $postStatus,
							'post_author' => $camp->camp_post_author,
							'post_type' => $camp->camp_post_type,
							'post_category' => $categories,
							
					);
						
					
					//Pending for non english
					
					if(in_array('OPT_MUST_ENGLISH', $camp_opt)){
						  echo '<br>Checking If English or not';
							
						if($this->is_english($post_title)){
							  echo '<-- English ';
						}else{
							  echo '<--Guessed as Not English setting as pending';
							$my_post['post_status'] = 'pending';
								 
						}
							
					}
					
					//Pending for transation fail
					// skip if translation failed
					
					if( in_array('OPT_TRANSLATE', $camp_opt) && in_array('OPT_TRANSLATE_FTP', $camp_opt)){
					
						  echo '<br>Checking if translation faild..';
					
						if($this->translationSuccess == false){
							  echo ' Found Failed... set to pending..';
							$my_post['post_status'] = 'pending';
						}else{
							  echo ' Found succeeded ';
						}
					
					}
					
					
					//prepare author 
					if($camp_type == 'Feeds' && isset($img['author']) && trim($img['author']) != '' && in_array('OPT_ORIGINAL_AUTHOR', $camp_opt) ){
						  echo '<br>Trying to set the post author to '.$img['author'];
						$author_id = $this->get_user_id_by_display_name($img['author']);
						if($author_id != false){
							$my_post['post_author'] = $author_id;	
						}
					}
					
						
					kses_remove_filters ();
					
					if ( $camp_type == 'Feeds' && in_array ( 'OPT_ORIGINAL_TIME', $camp_opt ) ){
						
						$wpdate = get_date_from_gmt( $article['wpdate'] );
						  echo '<br>Setting date for the post to '.$wpdate;
						$my_post['post_date'] = $wpdate ;
					
					}
					
					if ( $camp_type == 'Craigslist' && in_array ( 'OPT_CL_TIME', $camp_opt ) ){
					
						$wpdate = get_date_from_gmt(  gmdate ( 'Y-m-d H:i:s' , strtotime($img['item_date']) )  );
						  echo '<br>Setting date for the post to '.$wpdate ;
						$my_post['post_date'] = $wpdate ;
							
					}
					
					if ( $camp_type == 'Reddit' && in_array ( 'OPT_RD_TIME', $camp_opt ) ){
							
						$wpdate = get_date_from_gmt(  gmdate ( 'Y-m-d H:i:s' , ($img['item_date']) )  );
						  echo '<br>Setting date for the post to '.$wpdate ;
						$my_post['post_date'] = $wpdate ;
							
					}
					
					if ( $camp_type == 'Instagram' && in_array ( 'OPT_IT_DATE', $camp_opt ) ){
						  echo '<br>Setting date for the post to '. $img['item_created_date'];
						$my_post['post_date']=$img['item_created_date'];
					}
					
					if (  ($camp_type == 'Twitter' && in_array ( 'OPT_IT_DATE', $camp_opt )) || ($camp_type == 'SoundCloud' && in_array('OPT_SC_DATE', $camp_opt))    ){
						
						$item_created_at = date ( 'Y-m-d H:i:s' , strtotime( $img['item_created_at'])  );
						//$item_created_at = get_date_from_gmt($item_created_at);
						
						  echo '<br>Setting date for the post to '.$item_created_at;
						$my_post['post_date']=$item_created_at;
						
					}
					
 					
					if ( $camp_type == 'Youtube' && in_array ( 'OPT_YT_ORIGINAL_TIME', $camp_opt ) ){
						
						$realDate = get_date_from_gmt( gmdate('Y-m-d H:i:s' ,$vid['vid_time'] ) );
						echo '<br>Setting date for the post to '. $realDate;
						$my_post['post_date']= $realDate ;  
						
					}
					
					if($camp_type == 'Youtube' && in_array('OPT_YT_AUTHOR', $camp_opt)){
						
						echo '<br>Setting author for the post to '. $img['vid_author_title'];
						
						$author_id = $this->get_user_id_by_display_name($img['vid_author_title']);
						if($author_id != false){
							$my_post['post_author'] = $author_id;
						}
						
					}
					
					if ( $camp_type == 'DailyMotion' && in_array ( 'OPT_DM_ORIGINAL_TIME', $camp_opt ) ){
					
						 
						$realDate = get_date_from_gmt( gmdate('Y-m-d H:i:s' ,$img['item_published_at'] ) );
					
						  echo '<br>Setting date for the post to '. $realDate;
						$my_post['post_date']= $realDate ;
					
					}
					
					if ( $camp_type == 'Vimeo' && in_array ( 'OPT_VM_ORIGINAL_TIME', $camp_opt ) ){
						$realDate =   $vid['vid_created_time']  ;
					 	  echo '<br>Setting date for the post to '. $realDate;
						$my_post['post_date']= $realDate ;
							
					}
					
					if ( $camp_type == 'Facebook' && in_array ( 'OPT_ORIGINAL_FB_TIME', $camp_opt ) ){
						$realDate = $img['original_date']; 
						  echo '<br>Setting date for the post to '. $realDate;
						$my_post['post_date']= $realDate ;
							
					}
					
					//set excerpt of amazon product post type 
					if($camp_type == 'Amazon' && $camp->camp_post_type == 'product' && in_array('OPT_AMAZON_EXCERPT', $camp_opt)){
						  echo '<br>Setting product short description';
						$my_post['post_excerpt'] = $img['product_desc'];
					}
					
					//set excerpt of ebay product post type
					if($camp_type == 'eBay' && $camp->camp_post_type == 'product' && in_array('OPT_EBAY_EXCERPT', $camp_opt)){
						  echo '<br>Setting product short description';
						$my_post['post_excerpt'] = $img['item_desc'];
					}
					
				
					//remove filter kses for security 
					remove_filter('content_save_pre', 'wp_filter_post_kses');
					
					//fixing utf8
					
					//  echo ' Fixing ... '.$my_post['post_content'];
					
					$my_post['post_content'] = $this->fix_utf8($my_post['post_content']);
					$my_post['post_title'] = $this->fix_utf8($my_post['post_title']);
					 
					
					//truemag instagram remove embed 
					if( ($camp_type == 'Instagram' )     && stristr($abcont, '[embed]')  ){
							
						if( (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
					
							//extract video url
							$my_post['post_content'] = preg_replace('{\[embed\](.*?)\[/embed\]}','', $my_post['post_content']);
						}
					}
					
					// Exact match check  after filling the template
					// validating exact
					$valid = true;
					
					
					$valid = $this->validate_exacts($my_post['post_content'], $title, $camp_opt, $camp,true,$camp_general);
					
					 
					
					// if not valid process the campaign again and exit
					if ($valid == false) {
					
						//blacklisting the link so we don'g teg it again and cause a loop
						$this->link_execlude($camp->camp_id, $source_link);
						 
						$this->process_campaign ( $camp );
						exit ();
					}
					
					 
					
					// fix html entities 
					
					
					// Emoji fix
					
					if(! isset( $wpdb)) global $wpdb;
					
					$emoji_fields = array( 'post_title', 'post_content', 'post_excerpt' );
					
					foreach ( $emoji_fields as $emoji_field ) {
						if ( isset( $my_post[ $emoji_field ] ) ) {
							$charset = $wpdb->get_col_charset( $wpdb->posts, $emoji_field );
							if (  'utf8' === $charset ) {
								$my_post[ $emoji_field ] = wp_encode_emoji( $my_post[ $emoji_field ] );
								$my_post[ $emoji_field ] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "", $my_post[ $emoji_field]);
								
							}
						}
					}

					// single campaign decide the decision
					if($camp_type == 'Single'){
						
						$previousPostID = get_post_meta( $camp->camp_id, 'wp_automatic_previous_id' ,1);
						$previousHash   = get_post_meta( $camp->camp_id, 'wp_automatic_previous_hash' ,1);
						$currentHash     = md5( $my_post['post_title'] . $my_post['post_content'] );
						$cg_sn_after       = $camp_general['cg_sn_after'] ;
						
						
						if( $cg_sn_after == 'justnew' ){
							// ignore all of that, a new post should be created ignoring last post
							
						}else{
							
							if(trim($previousPostID) == ''){
								//inogre that, it is the first post ever
								echo '<br>First time posting...';
								
							}else{
								//previous post exists
								
								if($cg_sn_after == 'delete'){
									//always delete old post, lets delete it
									echo '<br>Deleting previous post with ID:'.$previousPostID;
									wp_delete_post($previousPostID,true);
									
								}else{
									// we have a previous post, let's see if new post is a differnet or the same
									
									if($previousHash == $currentHash){
										// nothing changed, it is the same post 
										echo '<br>Previous post contains the latest content as nothing changed...';
										exit;
									}else{
										// post changed 
										if($cg_sn_after == 'deletechange'){
											
											//delete and create new one
											echo '<br>Content changed, Deleting previous post with ID:'.$previousPostID;
											wp_delete_post($previousPostID,true);
											
										}elseif( $cg_sn_after == 'new' ){
											
											// don't delete anything, just create a new post
											echo '<br>Content changed, keeping old post and create a new one';
											
										}elseif($cg_sn_after == 'update' ){
											
											// update an existing post
											echo '<br>Content changed, updating post with ID:'.$previousPostID;
											$my_post['ID'] = $previousPostID;
											
										}
										
									}
									
								}
								
								
								
							}
							
						}
						
					}
					
					// filter 
					$my_post= apply_filters( 'wp_automatic_before_insert', $my_post);
					
					// Insert the post into the database
					if($my_post['post_type'] == 'topic' && function_exists('bbp_insert_topic')){
						 
						$cg_bb_fid  = $camp_general['cg_bb_fid'];
						
						if(is_numeric($cg_bb_fid)) {
							$my_post['post_parent'] = $cg_bb_fid;
						}
						
						$topicMeta= array();
						$topicMeta['forum_id'] = $cg_bb_fid;
						
						$id = bbp_insert_topic( $my_post ,$topicMeta );
		 
					}else{
						 
						$id = wp_insert_post( $my_post );
						
					}
				 
				 
					if($id == 0){
						  echo '<br>Error:Post Insertion failure';
						//print_r($my_post);
					}
					
					if( function_exists('icl_object_id')){
						$this->log( 'icl_object_id' ,  'icl_object_id exist '  );
					}else{
						$this->log( 'icl_object_id' ,  'icl_object_id no exist'  );
					}
					
					//wpml internal cron patch
					if(   ! stristr( $_SERVER['REQUEST_URI']  , 'wp_automatic') && function_exists('icl_object_id')  ){
						
						$wpml_options = get_option( 'icl_sitepress_settings' );
						$default_lang = $wpml_options['default_language'];
						
						$args['element_id'] = $id;
						$args['element_type'] = 'post_'.$camp->camp_post_type;
						$args['language_code'] = $default_lang;
						
						do_action( 'wpml_set_element_language_details',   $args );
						
					}
					
					//wpml integration
					if(in_array('OPT_WPML', $camp_opt)  && function_exists('icl_object_id') ){
						include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
						$language_code = trim($camp_general['cg_wpml_lang']); // change the language code
						
						echo '<br>Setting WPML language to: '.$language_code;
						if(function_exists('wpml_update_translatable_content')){
							  wpml_update_translatable_content('post_'.$camp->camp_post_type, $id, ($language_code) );
							 
							
							echo '<--Done';
							
							//find if there is a previous instance in another language
							global $sitepress;
							$cleanSource = preg_replace('{.rand\=.*}', '', $source_link);
							$sourceMD5 = md5($cleanSource);
							$keyName = $sourceMD5.'_wpml';
							
							$Qresults = $this->db->get_results( "SELECT * FROM {$this->db->prefix}postmeta WHERE `meta_key` = '$keyName' limit 1", ARRAY_A );
							
							if(count($Qresults) != 0){
								
								//we have a previous instance 
								$metaRow = $Qresults[0];
								$metaValue = $metaRow['meta_value'];
								$metaParts= explode('_', $metaValue);
								echo '<br>Found a  previous instance of the post in a different langauge:'.$metaValue. ' connecting...';
								
								$sitepress->set_element_language_details($id, $my_post['post_type'] .'_'.$my_post['post_type'] , $metaParts[0], $language_code, $metaParts[1] );
							
								
								
							}else{
								//record the post for next translation
								$trid= ($sitepress->get_element_trid($id));
								add_post_meta($id,$sourceMD5.'_wpml', $trid.'_'.$language_code );
							}
							
							
						}else{
							echo '<--Failed make sure wpml directory is named "sitepress-multilingual-cms"';
						}
						
					}
					 
					
					
					//setting categories for custom post types
					if( true | $camp->camp_post_type != 'post'){
						
						$customPostTaxonomies = get_object_taxonomies($camp->camp_post_type);
							
						if(count($customPostTaxonomies) > 0)
						{
							 
							foreach($customPostTaxonomies as $tax)
							{
								 
								if(is_taxonomy_hierarchical($tax)){
									  echo '<br>Setting taxonomy '.$tax.' to '.$camp->camp_post_category;
									@wp_set_post_terms($id, $categories , $tax,true);
								}
							}
						}
						
						
						
					}else{
						 
					} 
					 
					//feeds category 
					if($camp_type == 'Feeds' && trim($img['cats'] != '')){
						
						//Removed @v3.24.0
						//add_post_meta ( $id, 'original_cats', $img['cats'] );
						
						if(in_array('OPT_ORIGINAL_CATS', $camp_opt)){
							
							  echo '<br>Setting Categories to :'.$img['cats'];
							
							$cats= array_filter(explode(',', $img['cats']));
							
							if( $camp->camp_post_type == 'post' ){
								$taxonomy = 'category';
							}else{
								$taxonomy =  $camp_general['cg_camp_tax'] ;
							}
							
							$new_cats = array();
							
							//convert cats to ids
							foreach($cats as $cat_name){
								
								$cat  = get_term_by('name', $cat_name , $taxonomy);
								
								//check existence
								if($cat == false){
								
									
									//cateogry not exist create it
									$cat = wp_insert_term($cat_name, $taxonomy);
								
									if( ! is_wp_error($cat) ){
										//category id of inserted cat
										$cat_id = $cat['term_id'] ;
										$new_cats[] = $cat_id;
									}
									
								
								}else{
								
									//category already exists let's get it's id
									$cat_id = $cat->term_id ;
									$new_cats[] = $cat_id;
								}
							}
							
							//insert cats
							if(count($new_cats) > 0) 
							wp_set_post_terms($id,$new_cats,$taxonomy ,true);
							
							//delete uncategorized 
							if($taxonomy == 'category'){
								//get uncategorized slug by term id 
								$uncatObject = get_term(1);
								wp_remove_object_terms( $id, $uncatObject->slug, $taxonomy );
							}
							
							
						}
						
					}
					
					// Feeds part to field extraction set
					if($camp_type == 'Feeds'){
						
						$customFieldsArr = $img['custom_fields'];
						
						if( is_array($customFieldsArr) && count($customFieldsArr) != 0 ){
							
							foreach ($customFieldsArr as $customFieldSet){
							
								if($customFieldSet[0] == 'excerpt'){
									$my_post = array(
											'ID'           => $id,
											'post_excerpt' => $customFieldSet[1]
									);
									
									wp_update_post( $my_post );
								
								}elseif( $customFieldSet[0] == 'tags'){
									
									if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
										wp_set_post_terms( $id, $customFieldSet[1], trim($camp_general['cg_tag_tax']), true );
									}else{
										wp_set_post_tags ( $id, $customFieldSet[1], true );
									}
								
								}else{
									add_post_meta ( $id, $customFieldSet[0], $customFieldSet[1] );
								}
							}//foreach field
						
						}//if array
					
					}//if feed
					
					$post_id = $id;
					
					
					add_post_meta ( $id, 'original_title', $title );
					if(isset($source_link) )  add_post_meta ( $id, 'original_link', $source_link );
					add_post_meta($id , 'wp_automatic_camp',$camp->camp_id);
					
					// Record link if posted before
					if (in_array('OPT_LINK_ONCE', $camp_opt)){
						
						$query="insert into {$this->wp_prefix}automatic_links(	link_url ,link_keyword ) values ('".md5($source_link)."','".$camp->camp_id."')";
						$this->db->query($query);
						
					}
					
					//if link to source set flag
					if(in_array('OPT_LINK_SOURSE', $camp_opt)){
						add_post_meta ( $id, '_link_to_source', 'yes' );
					}
					
					//if link canonical
					if(in_array('OPT_LINK_CANONICAL', $camp_opt)){
						add_post_meta ( $id, 'canonical_url', $source_link );
					}
					 
					// add featured image
					if (in_array ( 'OPT_REPLACE', $camp_opt )) {
						foreach ( $keywords as $keyword ) {
							
							$keyword = trim($keyword);
							
							if (trim ( $keyword != '' )) {
								$post_content = str_replace ( $keyword, '<a href="' . $camp->camp_replace_link . '">' . $keyword . '</a>', $post_content );
							}
						}
					}
					
					// Featured image
					if (in_array ( 'OPT_THUMB', $camp_opt )) {
						
						$srcs = array(); //ini
						$srcs_alts = array();
						
						//if force og_img
						if(in_array('OPT_FEEDS_OG_IMG', $camp_opt) && isset($img['og_img']) && trim($img['og_img']) != '' ){
						
							if(in_array('OPT_FEEDS_OG_IMG_REVERSE', $camp_opt)  && stristr($post_content, '<img')){
								  echo '<br>og:image found but will be skipped';
								//here the image contains a first image and og:image should skipped
								
								//set an og:image variable so it get appended to the end of found images. If width check is active and all images on post are not wide enough
								$og_image = $img['og_img'];
								
							}else{
								$srcs = array($img['og_img']) ;
								$srcs_alts[] = $img['og_alt'];
								
							}
						}
						
						//if youtube set thumbnail to video thum
						if($camp_type == 'Youtube' || $camp_type == 'Vimeo' ){
							//set youtube/vimeo image as featured image
							 
							//check if maxres exists
							if( stristr( $vid['vid_img'] , 'hqdefault' ) ){
								$maxres = str_replace('hqdefault', 'maxresdefault', $vid['vid_img']) ;

								$maxhead = wp_remote_head($maxres);
								
								if(! is_wp_error($maxhead) && $maxhead['response']['code'] == 200 ){
									$vid['vid_img'] = $maxres;
								}
								
							}
							
							
							$srcs=array($vid['vid_img']);
							
							  echo '<br>Vid Thumb:'.$vid['vid_img'];
						
						}elseif( $camp_type == 'DailyMotion' ){
							$srcs=array($img['item_image']);
						
						}elseif($camp_type == 'SoundCloud'){
							
							if(trim($img['item_thumbnail']) != ''){
								$srcs = array($img['item_thumbnail']);
							}elseif(trim($img['item_user_thumbnail']) != ''){
								//$srcs = array($img['item_user_thumbnail']);
							}
							
						}elseif($camp_type == 'Twitter' && in_array('OPT_TW_CARDS', $camp_opt) && isset($img['item_image']) ){
							
							$srcs = array($img['item_image']);
							
						}elseif($camp_type == 'Amazon'){
							
							$srcs = array($img['product_img']);
							
						}elseif(isset($srcs) && count($srcs) > 0 ){
						
							
						}else{

							
							// extract first image
							preg_match_all ( '/<img [^>]*src[\s]*=[\s]*["|\']([^"|\']+).*?>/i', stripslashes ( $post_content ), $matches );
							$srcs = $matches [1];
							$srcs_html = $matches[0];

							
							foreach ($srcs_html as $src_html){
								
								preg_match('/alt[\s]*=[\s]*["|\'](.*?)["|\']/i', $src_html,$alt_matches) ;
								
								 
								if(isset($alt_matches[1])){
									$srcs_alts[] = $alt_matches[1];
								}else{
									$srcs_alts[] = '';
								}
								
								
							}
							
					 
							
							if(isset($og_image)){
								$og_arr = array();
								$og_arr[] = $og_image;
								$srcs = array_merge($srcs,$og_arr);
								
							}
							
						}
						 
						
						//may be a wp_automatic_Readability missed the image on the content get it from summary ?
						if( count($srcs) == 0 &&  $camp_type == 'Feeds' && in_array('OPT_FULL_FEED', $camp_opt) ){
							  echo '<br>Featured image is missing at full content searching for it in feed instead';
							preg_match_all ( '/<img [^>]*src=["|\']([^"|\']+).*?/i', stripslashes ( $article['original_content'] ), $matches );
							$srcs = $matches [1];
							$srcs_html = $matches[0];
							
							foreach ($srcs_html as $src_html){
								
								preg_match('/alt[\s]*=[\s]*["|\'](.*?)["|\']/i', $src_html,$alt_matches) ;
								$srcs_alts[] = $alt_matches[1];
								
							}
							
							if(count($srcs) == 0){
								  echo '<br>No image found at the feed summary';
								
								if( trim($img['og_img']) != '' ){
									  echo '<br>Graph image thumb found';
									$srcs = array($img['og_img']);
								}
								
							}
							 	
						}
						
						
						//No featured image found let's check if random image list found
						if ( count($srcs) == 0 && in_array ( 'OPT_THUMB_LIST', $camp_opt )) {
							  echo '<br>Trying to set random image as featured image';
							
							$cg_thmb_list=$camp_general['cg_thmb_list'];
							
							$cg_imgs = explode("\n", $cg_thmb_list);
							$cg_imgs = array_filter($cg_imgs);
							$cg_rand_img = trim( $cg_imgs [rand(0,count($cg_imgs)-1)]);
							
							//validate image
							if(trim( $cg_rand_img)!='' ){
								$srcs=array($cg_rand_img);
							}
							  
						}elseif(in_array ( 'OPT_THUMB_LIST', $camp_opt )){
							
							$cg_thmb_list=$camp_general['cg_thmb_list'];
								
							$cg_imgs = explode("\n", $cg_thmb_list);
							$cg_imgs = array_filter($cg_imgs);
							$cg_rand_img = trim( $cg_imgs [rand(0,count($cg_imgs)-1)]);
								
							//validate image
							if( trim($cg_rand_img)!= ''  ){
								$srcs= array_merge($srcs, array($cg_rand_img) ) ;
							}
							
						}
						
						//if foce using thumb list
						if( in_array('OPT_THUMB_LIST_FORCE', $camp_opt) && in_array ( 'OPT_THUMB_LIST', $camp_opt ) ){
							
							  echo '<br>Force using image from set list';
							
							$cg_thmb_list=$camp_general['cg_thmb_list'];
								
							$cg_imgs = explode("\n", $cg_thmb_list);
							$cg_imgs = array_filter($cg_imgs);
							
							
							
							$cg_rand_img = trim( $cg_imgs [rand(0,count($cg_imgs)-1)]);
		
							
							//validate image
							if(trim( $cg_rand_img)!='' ){
								$srcs=array($cg_rand_img);
							}
							
						}
						 
						//check srcs size to skip small images
						if(count($srcs) >0 && in_array('OPT_THUMB_WIDTH_CHECK', $camp_opt)){
							
							$cg_minimum_width = 0;
							$cg_minimum_width = $camp_general['cg_minimum_width'];

							if(!  (is_numeric( $cg_minimum_width ) && $cg_minimum_width > 0 ) ){
								$cg_minimum_width = 100;
							}
							
							$n=0;
							$upload_dir = wp_upload_dir ();
							
							foreach($srcs as $current_img){
								
								  echo '<br>Candidate featured image: '.$current_img ;
								
								if(stristr($current_img, 'data:image') && stristr($current_img, 'base64,')){
									
									$ex = explode('base64,', $current_img);
									
									$image_data = base64_decode($ex[1]);
									
									
								}else{
								
									//curl get
									$x='error';
									curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
									curl_setopt($this->ch, CURLOPT_URL, trim($current_img));
									$image_data=curl_exec($this->ch);
									$x=curl_error($this->ch);
								
								}
								
							 	
									
								if(trim($image_data) != ''    ){
									
									//let's save the file
									if (wp_mkdir_p ( $upload_dir ['path'] ))
										$file = $upload_dir ['path'] . '/' . 'temp_wp_automatic';
									else
										$file = $upload_dir ['basedir'] . '/' . 'temp_wp_automatic';
									
									file_put_contents ( $file, $image_data );
		
									$size = getimagesize($file);
									  
									if($size != false){
										
										if($size[0] >$cg_minimum_width ){
											  echo '<-- Valid width is '.$size[0] . ' larger than '.$cg_minimum_width   ;
											break;
										}else{
											  echo '<-- width is too low '.$size[0];
											unset($srcs[$n]);
											if(isset($srcs_alts[$n])) unset($srcs_alts[$n]) ;
										}
										
									}else{
										  echo '<--size verification failed';
										unset($srcs[$n]);
										if(isset($srcs_alts[$n])) unset($srcs_alts[$n]) ;
									}
									
									
								}else{
									  echo '<--no content ';
									unset($srcs[$n]);
									if(isset($srcs_alts[$n])) unset($srcs_alts[$n]) ;
								}
								
								$n++;
							}
						
						}		
						
						 
						// Setting the thumb
						if (count ( $srcs ) > 0) {
							
							$src = reset($srcs);
							
							$image_url = $src;
							 
							$this->log ( 'Featured image', '<a href="' . $image_url . '">' . $image_url . '</a>' );
							echo '<br>Featured image src: '.$image_url;
							
							// set thumbnail
							$upload_dir = wp_upload_dir ();
							
							//img host
							$imghost = parse_url ( $image_url, PHP_URL_HOST );
								
							if(stristr($imghost, 'http://')){
								$imgrefer=$imghost;
							}else{
								$imgrefer = 'http://'.$imghost;
							}
		
							//empty referal
							if( ! in_array('OPT_CACHE_REFER_NULL', $camp_opt) ){
								curl_setopt ( $this->ch, CURLOPT_REFERER, $imgrefer );
							}else{
								curl_setopt ( $this->ch, CURLOPT_REFERER, '' );
							}
							
							if( stristr($image_url, 'base64,')  ){
								$filename = time('now');
							}else{
								//decode html entitiies
								$image_url = html_entity_decode($image_url);
								
								if(stristr($image_url, '%') ) {
									$image_url = urldecode($image_url);
								}
								
								//file name to store
								$filename = basename ( $image_url );
									
								//youtube hqdefault.jpg may exists with different data, change the name 
								if(stristr($filename, 'default.jpg') ) {
									$filename = time('now') . '_' .$filename;
								}	
								
								if(stristr($image_url ,' ')){
									$image_url = str_replace(' ', '%20', $image_url);
								}
									
							}
							
							// Clean thumb
							if(in_array('OPT_THUMB_CLEAN' , $camp_opt   )){
							
								$clean_name = '';
								$clean_name =  sanitize_file_name($post_title);
								
								
								if(trim($clean_name) != ""){
										
									//get the image extension \.\w{3}
									$ext = pathinfo($filename, PATHINFO_EXTENSION);
										
									if(stristr($ext, '?')){
										$ext_parts = explode('?',$ext);
										$ext = $ext_parts[0];
									}
										
									//clean parameters after filename
									$filename = trim($clean_name);
										
									if( trim($ext) !='' ){
										$filename = $filename .'.'. $ext;
									}
										
								}
							
							}
								
												
							
							if(!in_array('OPT_THUM_NELO', $camp_opt) || stristr($image_url, 'base64,')){
							
								if(  stristr($image_url, 'base64,')  ){
									$ex = explode('base64,', $current_img);
									$image_data = base64_decode($ex[1]);
									
									//set fileName extention .png, .jpg etc
									preg_match('{data:image/(.*?);}', $image_url ,$ex_matches);
									$image_ext = $ex_matches[1];
									
									if(trim($image_ext) != ''){
										$filename = $filename .'.'.$image_ext;
										
										  echo '<br>Fname:'.$filename;
										
										
									}
									
								}else{
									

									//get image content
									$x='error';
									curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
									curl_setopt($this->ch, CURLOPT_URL, trim( html_entity_decode($image_url) ) );
									$image_data=$this->curl_exec_follow($this->ch);
									$contentType = curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);
									  echo '<br>Content type:'.$contentType;
									$x=curl_error($this->ch);
									
									
								}
								 
								// do not validate content type option
								if(in_array('OPT_THUM_NOTYPE', $camp_opt)){
									$contentType = 'image';
								}
								 
								if(trim($image_data) != ''  &&     stristr($contentType	, 'image')    ){
									
			 						//check if already saved
			 						
									$image_data_md5 = md5($image_data);
									
									$is_cached = $this->is_cached($image_url , $image_data_md5);
									if( $is_cached != false ){
										  echo '<--already cached' ;
										$file = $this->cached_file_path;
										$guid = $is_cached; 
			 						}else{ 
									 
										
										if (stristr ( $filename, '?' )) {
											$farr = explode ( '?', $filename );
											$filename = $farr [0];
										}
										
										//pagepeeker fix
										if(stristr($image_url, 'pagepeeker') && ! in_array('OPT_THUMB_CLEAN' , $camp_opt )){
											$filename = md5($filename).'.jpg';
										}
										
										if (wp_mkdir_p ( $upload_dir ['path'] ))
											$file = $upload_dir ['path'] . '/' . $filename;
										else
											$file = $upload_dir ['basedir'] . '/' . $filename;
											
											// check if same image name already exists
										if (file_exists ( $file )) {
											
											 //get the current saved one to check if identical
											$already_saved_image_link=$upload_dir ['url'] . '/' . $filename;
				
											//curl get
											$x='error';
											$url=$already_saved_image_link;
											curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
											curl_setopt($this->ch, CURLOPT_URL, trim($url));
											 
											$exec=curl_exec($this->ch);
											 
											if(trim($exec) == trim($image_data)){
												$idential = true;
												  echo '<br>Featured image already exists with same path.. using it';
											}else{
												  echo '<br>Featured image exists with same path but not identical.. saving  ';
												
												$filename = time ( 'now' ) . '_' . $filename;
												
											}
											 
										}
										
										
										//saving image 
										if(! isset($idential )){
											if (wp_mkdir_p ( $upload_dir ['path'] ))
												$file = $upload_dir ['path'] . '/' . $filename;
											else
												$file = $upload_dir ['basedir'] . '/' . $filename;
											
											$f=file_put_contents ( $file, $image_data );
											//echo '<br>File URL:'.$file;
										
											
										}
										 
										$guid = $upload_dir['url'] . '/' . basename( $filename );
										
										
										 
										$this->img_cached($image_url, $guid,$image_data_md5,$file);
									
			 						}//not cached	
									
									//atttatchment check if exists or not
									global  $wpdb;
									
									
									$query = "select * from $wpdb->posts where guid = '$guid'";
									$already_saved_attachment = $wpdb->get_row($query);
									 
									if(isset($already_saved_attachment->ID)){

										$attach_id = $already_saved_attachment->ID;
										
									}else{
			
										$wp_filetype = wp_check_filetype ( $filename, null );
										
										if($wp_filetype['type'] == false){
											$wp_filetype['type'] = 'image/jpeg';
										}
										
										//Title handling
										$imgTitle = sanitize_file_name ( $filename );
										if(in_array('OPT_THUMB_ALT',$camp_opt)){
											$imgTitle = $title;
										}
										
										$attachment = array (
												'guid'           =>  $guid,
												'post_mime_type' => $wp_filetype ['type'],
												'post_title' => $imgTitle,
												'post_content' => '',
												'post_status' => 'inherit'
										);
										
										$attach_id = wp_insert_attachment ( $attachment, $file, $post_id );
										
										require_once (ABSPATH . 'wp-admin/includes/image.php');
										$attach_data = wp_generate_attachment_metadata ( $attach_id, $file );
										wp_update_attachment_metadata ( $attach_id, $attach_data );

										//alt text
										if(in_array('OPT_THUMB_ALT2', $camp_opt)){
											$img_alt= reset($srcs_alts);
											
											if(trim($img_alt) != ''){
												update_post_meta($attach_id, '_wp_attachment_image_alt', $img_alt);
											}
											
											if(in_array('OPT_THUMB_ALT3', $camp_opt)){
												
												if(trim($img_alt) == ''){
													update_post_meta($attach_id, '_wp_attachment_image_alt', $title);
												}
												
											}
											
											
										}
										
									}
									
									$img['featured_img_source'] = $image_url;
									$img['featured_img_local_source'] = $guid;
									
									set_post_thumbnail ( $post_id, $attach_id );
									echo ' <-- thumbnail set successfully';

									//if hide first image set the custom field 
									if(in_array('OPT_THUMB_STRIP', $camp_opt)){
										
										if(in_array('OPT_THUMB_STRIP_FULL', $camp_opt)){
											  echo '<br>Deleting first image from the content...';
											
											$new_post = get_post($id);
											$new_content = preg_replace ( '/<img [^>]*src=["|\'][^"|\']+.*?>/i', '' ,$new_post->post_content ,1 );
											
											$my_post = array(
													'ID'           => $id,
													'post_content' => $new_content,
											);
											
											// Update the post into the database
											wp_update_post( $my_post );
											
										}else{
											update_post_meta ( $post_id, 'wp_automatic_remove_first_image', 'yes' );
										}
									}
									
								}else{
									  echo ' <-- can not get image content '.$x;
								}
							
							}else{//nelo
								//setting custom field for nelo image
								  echo '<br>Setting the featured image custom field for nelio plugin'; 
								update_post_meta($id, '_nelioefi_url', $image_url);
								
								//if hide first image set the custom field
								if(in_array('OPT_THUMB_STRIP', $camp_opt)){
								
									if(in_array('OPT_THUMB_STRIP_FULL', $camp_opt)){
										  echo '<br>Deleting first image from the content...';
											
										$new_post = get_post($id);
										$new_content = preg_replace ( '/<img [^>]*src=["|\'][^"|\']+.*?>/i', '' ,$new_post->post_content ,1 );
											
											
										$my_post = array(
												'ID'           => $id,
												'post_content' => $new_content,
										);
											
										// Update the post into the database
											
											
										wp_update_post( $my_post );
											
									}else{
										update_post_meta ( $post_id, 'wp_automatic_remove_first_image', 'yes' );
									}
								}
								
							}	
							
							
						} else {
							
							//currently no images in the content 
							$this->log ( 'Featured image', 'No images found to set as featured' );
				
						}
					} // thumbnails
					  
					// tags
					if (in_array ( 'OPT_TAG', $camp_opt )) {
						
						$targetKeywords = $keywords;
						
						if(in_array('OPT_TAG_KEYONLY', $camp_opt) && isset($this->used_keyword) && trim($this->used_keyword) !='' ){
							$targetKeywords = $this->used_keyword;
						}
						
						if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
							wp_set_post_terms( $id, $targetKeywords , trim($camp_general['cg_tag_tax']), true );
						}else{
							wp_set_post_tags ( $id, $targetKeywords, true );
						}
					}
					
					//youtube tags and comments
					if($camp_type == 'Youtube'   ){
						
						//tags
						if(in_array('OPT_YT_TAG', $camp_opt)){
							if(trim($this->used_tags) != ''){
								
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
									wp_set_post_terms( $id, $this->used_tags , trim($camp_general['cg_tag_tax']), true );
								}else{
									wp_set_post_tags ( $id, $this->used_tags, true );
								}
								
							}	
						}
						
						//comments
						if(in_array('OPT_YT_COMMENT', $camp_opt) ){
							  echo '<br>Trying to post comments';
							
							//get id
							$temp=explode('v=', $this->used_link);
							$vid_id=$temp[1] ;
							
							$wp_automatic_yt_tocken=trim(get_option('wp_automatic_yt_tocken',''));
							
							$maxResults = rand(20,50);
							
							$comments_link="https://www.googleapis.com/youtube/v3/commentThreads?maxResults=$maxResults&part=snippet&videoId=".$vid_id."&key=$wp_automatic_yt_tocken";
							
							  echo '<br>Comments yt url:'.$comments_link;
							
							//curl get
							$x='error';
							$url=$comments_link;
							curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
							curl_setopt($this->ch, CURLOPT_URL, trim($url));
						 	$exec=curl_exec($this->ch);
 	 
						 	
							$x=curl_error($this->ch);
						 	
							if(trim($x) != '')   echo '<br>'.$x;
							
							if(trim($exec) !=''){
								
								if( stristr($exec, 'items')){
									
									$exec = str_replace('s28-', 's90-', $exec);
									
									$comments_array=json_decode($exec);
 
									$entry=$comments_array->items ;
									
									if(count($entry) == 0){
										  echo '<br>No comments found';
									}else{
										  echo  '<br>Found '.count($entry). ' comment to post';
										 
										foreach($entry as $comment ){
											
											
											$comment = $comment->snippet->topLevelComment->snippet;
											
										 
											$commentText= $comment->textDisplay;
											$commentAuthor= $comment->authorDisplayName;
											$profileImage = $comment->authorProfileImageUrl;
											
											$commentUri='';
											$comment_author_url ='';
											
											if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt)){
												$comment_author_url = $profileImage .'|'. $comment->authorChannelId->value;
												$commentUri= $comment->authorChannelUrl;
											}else{
												$comment_author_url = $profileImage.'|';
											}
											
											
											if(in_array('OPT_YT_ORIGINAL_TIME', $camp_opt)){
												$time = $comment->publishedAt;
												$time = get_date_from_gmt( gmdate('Y-m-d H:i:s' , strtotime( $time ) ) );
											}else{
												$time = current_time('mysql');
											}
		 									
											 
		 									
		 									if(trim($commentText) != '' ){
												$data = array(
														'comment_post_ID' => $id,
														'comment_author' => $commentAuthor,
														'comment_author_email' => '',
														'comment_author_url' => $comment_author_url,
														'comment_content' => $commentText,
														'comment_type' => '',
														'comment_parent' => 0,
														 
														'comment_author_IP' => '127.0.0.1',
														'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
														'comment_date' => $time,
														'comment_approved' => 1,
												);
												
												wp_insert_comment($data);
		 									}
		 									
										}
										
									}
									
								}else{
									  echo '<br>could not find comments';
								}
								
							}else{
								  echo '<br>No valid comments feed';
							}
							
						}
						
					}
					
					// After single scraper
					if($camp_type == 'Single'){
						
						//update last post 
						update_post_meta( $camp->camp_id, 'wp_automatic_previous_id' ,$id);
						update_post_meta( $camp->camp_id, 'wp_automatic_previous_hash' ,$currentHash);
						
						
					}
					
					// AFTER POST SPECIFIC DAILYMOTION
					if( $camp_type == 'DailyMotion'){
						//tags
						if(in_array('OPT_DM_TAG', $camp_opt)){
							if(trim($this->used_tags) != ''){
						
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
									wp_set_post_terms( $id, $this->used_tags , trim($camp_general['cg_tag_tax']), true );
								}else{
									wp_set_post_tags ( $id, $this->used_tags, true );
								}
						
							}
						}
					}
					
					// AFTER POST SPECIFIC
					if ($camp_type == 'Flicker') {
						if (in_array ( 'OPT_FL_TAG', $camp_opt )) {
							
							if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
							
								wp_set_post_terms( $id, $img ['img_tags'] , trim($camp_general['cg_tag_tax']), true );
							
							}else{
								wp_set_post_tags ( $id, $img ['img_tags'], true );
							}
							
							
						}
					}
					
					// AFTER POST SPECIFIC SoundCloud
					if ($camp_type == 'SoundCloud') {
						
						//tags
						if (in_array ( 'OPT_SC_TAG', $camp_opt )) {
							
							$item_tags = $img['item_tags'];
							
							//extract tags with multiple words 
							preg_match_all('{".*?"}', $item_tags, $multiple_tags_matches);
							
							$multiple_tags_matches = $multiple_tags_matches[0];
							  
							$single_item_tags = $item_tags;
							
							
							foreach ($multiple_tags_matches as $multiple_tag){
								$single_item_tags = str_replace($multiple_tag, '', $single_item_tags);
								$single_item_tags = str_replace('  ', ' ', $single_item_tags);
							}
							
							//remove "
							$multiple_tags_matches = str_replace('"', '', $multiple_tags_matches);
							
							//explode single tags
							$single_item_tags = explode(' ', $single_item_tags);
							
							$all_tags = array_merge($multiple_tags_matches,$single_item_tags);
							$all_tags = array_filter($all_tags);
							$all_tags_comma = implode(',', $all_tags);
							
							 if(trim($all_tags_comma) != ''){
							 	  echo '<br>Tags:'.$all_tags_comma;
							 	
							 	if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
							 	
							 		wp_set_post_terms( $id, $all_tags_comma , trim($camp_general['cg_tag_tax']), true );
							 	
							 	}else{
							 		wp_set_post_tags ( $id, $all_tags_comma, true );
							 	}
							 	
							 	
							 
							 }
							 
						}
						
						//comments
						if(in_array('OPT_SC_COMMENT', $camp_opt)){
							
							$wp_automatic_sc_client= get_option('wp_automatic_sc_client');
							
							if(trim($wp_automatic_sc_client) != ''){
								
								//getting the comment 
								
								$item_id = $img['item_id'];
								
								  echo '<br>Fetching comments for tack:'.$item_id;
								
								$commentsCount = rand(20,30);
								
								$api_url = "http://api.soundcloud.com/tracks/$item_id/comments?client_id=$wp_automatic_sc_client&limit=$commentsCount";
								
								//curl get
								$x='error';
								 
								curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
								curl_setopt($this->ch, CURLOPT_URL, trim($api_url));
								$exec=curl_exec($this->ch);
								$x=curl_error($this->ch);
								
								if( stristr($exec, '"comment"')){
									
									$comments_json = json_decode($exec);
									
									  echo '<br>Found '.count($comments_json) . ' comments to post.';
									
									$time = current_time('mysql');
									
									foreach ($comments_json  as $new_comment){
										
										if($new_comment->kind == 'comment'){
											
											$commentUri='';
											if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt))
											$commentUri=$new_comment->user->permalink_url;
											
											$data = array(
													'comment_post_ID' => $id,
													'comment_author' => $new_comment->user->username,
													'comment_author_email' => '',
													'comment_author_url' => $commentUri,
													'comment_content' => $new_comment->body,
													'comment_type' => '',
													'comment_parent' => 0,
											
													'comment_author_IP' => '127.0.0.1',
													'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
													'comment_date' => $time,
													'comment_approved' => 1,
											);
												
											wp_insert_comment($data);
											
											
										}
										
									}
									
									
									
									
								}else{
									  echo '<br>No comments found';
								}
								 
							}
							
						}
						
					}
					
					//After post facebook
					if($camp_type == 'Facebook'){
						//tags
						if(in_array('OPT_FB_TAGS', $camp_opt)){
							if(trim($img['item_tags']) != ''){
								echo '<br>Setting tags:'.$img['item_tags'];
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
									wp_set_post_terms( $id, $keywords , $img['item_tags'] , true );
								}else{
									wp_set_post_tags ( $id, $img['item_tags'], true );
								}
							}
						}
						
						
						// comments
						if( in_array('OPT_FB_COMMENT', $camp_opt) && isset(	$img['comments'] ) ){
							
							//trying to post FB comments
							  echo '<br>Posting FB comments as comments :'.$img['post_id'];
							
						 
							
							  if( isset( $img['comments'] )  ) {
								
							   
								
							  	$comments =$img['comments'];
								
								
								$added = 0 ;
								$time = current_time('mysql');
								
								foreach($comments as $comment){
									 
									if( trim($comment['text']) != '' ){
										
										
										$commentText= $comment['text'];
										 
										$commentAuthor= $comment['author_name'];
										$commentAuthorID= $comment['author_id'];
										$commentUri='';

										if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt))
										$commentUri= "https://facebook.com/". $commentAuthorID;
										
										
										if(in_array('OPT_ORIGINAL_FB_TIME', $camp_opt) ){
											
											$time = date('Y-m-d H:i:s', ( $comment['time'] ) );
										}
											
										
										if(trim($commentText) != '' ){
											$data = array(
													'comment_post_ID' => $id,
													'comment_author' => $commentAuthor,
													'comment_author_email' => $commentAuthorID.'@fb.com',
													'comment_author_url' => $commentUri,
													'comment_content' => $commentText,
													'comment_type' => '',
													'comment_parent' => 0,
														
													'comment_author_IP' => '127.0.0.1',
													'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
													'comment_date' => $time,
													'comment_approved' => 1,
											);
										
											wp_insert_comment($data);
										}
										
										
										
										$added++;
									}
									
								}
								
								
								echo '<br>'.$added . ' comments to post';
								
								 
								
								
							}else{
								  echo '<br>No comments found';
							}
 
							
						}
					}
					
					//After post vimeo 
					if($camp_type == 'Vimeo'){
						
						if(in_array('OPT_VM_TAG', $camp_opt)){
								
							if(trim($vid['vid_tags']) != ''){
								
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
								
									wp_set_post_terms( $id, $keywords , $vid['vid_tags'], true );
								
								}else{
									wp_set_post_tags ( $id, $vid['vid_tags'], true );
								}
							 	
							}
						}
						
					}
					
					if($camp_type == 'Envato'){
						
						if(in_array('OPT_EV_AUTO_TAGS', $camp_opt)){
							
							if(trim($img['item_tags']) != ''){
							
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
							
									wp_set_post_terms( $id, $keywords , $img['item_tags'], true );
							
								}else{
									wp_set_post_tags ( $id, $img['item_tags'], true );
								}
									
							}
							
						}
						
					}
					
					if($camp_type == 'Instagram'){
					
						if(in_array('OPT_IT_TAGS', $camp_opt)){
							if(trim($img['item_tags']) != ''){
								  echo '<br>Setting tags:'.$img['item_tags'];
								if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
									wp_set_post_terms( $id, $keywords , $img['item_tags'] , true );
								}else{
									wp_set_post_tags ( $id, $img['item_tags'], true );
								}
							}
						}
						
						//comments
						if(in_array('OPT_IT_COMMENT', $camp_opt) ){
							
							  echo '<br>Trying to post comments';
							
							$time = current_time('mysql');
		
							$comments = $img['item_comments'];
							
							 	
							if(count($comments) > 0){
								
										  echo  '<br>Found '.count($comments). ' comment to post from';
						
										// random count
										$commentsCount = count($comments);
										if($commentsCount == 40 ) {
											$commentsCount = rand(20,40);
											  echo '...Posting '.$commentsCount;
										}
										
											
										$i=0;
										foreach($comments as $comment ){

											$i++;
											
											if( $i > $commentsCount ) break;
											
											$comment = $comment->node;
											
											$commentText= $comment->text;

											if(isset($comment->created_at) && trim($comment->created_at) != ''){
												
												//new comments format 
												$commentAuthor= $comment->owner->username;
												$commentAuthorID= $comment->owner->id;
												
												
												$commentUri='';
												if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt))
												$commentUri= "https://instagram.com/". $comment->owner->username;
												
												if(in_array('OPT_IT_DATE', $camp_opt) ){
													$time = date('Y-m-d H:i:s',$comment->created_at);
												}
												
											}else{
												
												//old comments format
												$commentAuthor= $comment->from->full_name;
												if(trim($commentAuthor) == '') $commentAuthor= $comment->from->username;
												$commentAuthorID= $comment->author[0]->uri->x;
												
												
												$commentUri='';
												if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt))
												$commentUri= "https://instagram.com/". $comment->from->username;
												if(in_array('OPT_IT_DATE', $camp_opt) ){
													$time = date('Y-m-d H:i:s',$comment->created_time);
												} 
												
												
											}
											 
												
											if(trim($commentText) != '' ){
												$data = array(
														'comment_post_ID' => $id,
														'comment_author' => $commentAuthor,
														'comment_author_email' => '',
														'comment_author_url' => $commentUri,
														'comment_content' => $commentText,
														'comment_type' => '',
														'comment_parent' => 0,
															
														'comment_author_IP' => '127.0.0.1',
														'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
														'comment_date' => $time,
														'comment_approved' => 1,
												);
						
												wp_insert_comment($data);
											}
						
										}
						
									 
										
							 
						
							}else{
								  echo '<br>No comments found';
							}
								
						}
					
					
					
					}
					
					//After Twitter
					if($camp_type == 'Twitter'){
						if(in_array('OPT_TW_TAG', $camp_opt)){
							
							if(isset($img['item_hashtags'])){
								  echo '<br>Tags:'.$img['item_hashtags'];
								wp_set_post_tags ( $id, $img['item_hashtags'], true );
								
							}
						}
					}
					
					//After Reddit 
					if($camp_type == 'Reddit'){
						
						if(in_array('OPT_RD_COMMENT', $camp_opt)){
							
							//comments
							  echo '<br>Getting comments';
							$comments_link = ($img['item_link'].'.json');
							
							//curl get
							$x='error';
							
							curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
							curl_setopt($this->ch, CURLOPT_URL, trim($comments_link));
							$exec=curl_exec($this->ch);
							$x=curl_error($this->ch);
							
							if(stristr($exec, '[{')){
								
								$commentsJson = json_decode($exec);
								$commentsJson = $commentsJson[1]->data->children;
								
								  echo '<br>Found '.count($commentsJson) . ' comments ';
								$time = current_time('mysql');
								
								foreach ($commentsJson as $newComment){
									
									if(in_array('OPT_RD_TIME', $camp_opt)){
										$time = get_date_from_gmt(  gmdate ( 'Y-m-d H:i:s' , ($newComment->data->created_utc) )  ) ;
									}
									 
									$commentUri='';
									if(! in_array('OPT_NO_COMMENT_LINK', $camp_opt))
										
										$commentUri='https://www.reddit.com/'.$newComment->data->author;
											
										$data = array(
												'comment_post_ID' => $id,
												'comment_author' => $newComment->data->author,
												'comment_author_email' => '',
												'comment_author_url' => $commentUri,
												'comment_content' => $newComment->data->body,
												'comment_type' => '',
												'comment_parent' => 0,
													
												'comment_author_IP' => '127.0.0.1',
												'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
												'comment_date' => $time,
												'comment_approved' => 1,
										);
									
										wp_insert_comment($data);
											
									
								}
								
								
							}else{
								  echo '<br>Not valid reply from Reddit';
							}
							
							
							
							
						}
						
					}
					
					//After ebay 
					if(in_array('OPT_EB_REDIRECT_END', $camp_opt)){
						  echo '<br>Setting expiry date: '.$img['item_end_date'];
						
						$expiry_date = strtotime( $img['item_end_date'] );
						
						add_post_meta($id, 'wp_automatic_redirect_date', $expiry_date);
						add_post_meta($id, 'wp_automatic_redirect_link', $camp_general['cg_eb_redirect_end']);
 						
					}
					
					if(in_array('OPT_EB_TRASH', $camp_opt)){
						  echo '<br>Setting trash date: '.$img['item_end_date'];
					
						$expiry_date = strtotime( $img['item_end_date'] );
					
						add_post_meta($id, 'wp_automatic_trash_date', $expiry_date);
					 		
					}
					
					//setting post tags
					$post_tags=array();
					
					if(in_array('OPT_ADD_TAGS',$camp_opt ) ){
						
						$post_tags = array_filter( explode("\n", $camp_general['cg_post_tags']));
						
						$max = $camp_general['cg_tags_limit'];
						if(! is_numeric($max)) $max= 100;
						
						if(in_array('OPT_RANDOM_TAGS', $camp_opt)  && count($post_tags) > $max ){
							
							
							$rand_keys = array_rand($post_tags,$max);
							
							if(is_array($rand_keys)) {
								
								
								$temp_tags = array();
								foreach ($rand_keys as $key){
									$temp_tags[] = $post_tags[$key];
								}
								
							}else{
								
								//single value selected like 0
								
								$temp_tags[] = $post_tags[$rand_keys] ;
							}
							
							$post_tags = $temp_tags;
								
						}
							 
					}
					
					
		
					if(in_array('OPT_ORIGINAL_TAGS', $camp_opt) || in_array('OPT_ORIGINAL_META', $camp_opt)){
						$new_tags = explode(',', $img['tags']);
						
						if(count($new_tags) > 0 ){
							$post_tags = array_merge($post_tags,$new_tags);
						}
						
					}
					
					//title tags
					if(in_array('OPT_TITLE_TAG', $camp_opt)){
					 	
						$titleWords = explode(' ',  $my_post['post_title'] );
						$validTitleWords = array();
						
						//get stop words 
						$stopWordsRaw = file_get_contents( dirname(__FILE__) . '/stopwords.txt');
						
						$stopWords = array();
						$stopWords = explode(',', $stopWordsRaw);
						
						//additional stop words 
						$additionalStopWordsRaw = get_option('wp_automatic_ttt_stop','');
						
						if(trim($additionalStopWordsRaw) != ''){
							$additionalStopWordsArr = explode("\n", $additionalStopWordsRaw);
							$additionalStopWordsArr = array_filter($additionalStopWordsArr);
							
							$stopWords = array_merge($stopWords,$additionalStopWordsArr);
							
						}
						
						$stopWords = array_map('trim', $stopWords);
						
						foreach ($titleWords as $titleWord){
							
							$titleWord = preg_replace('#[^\p{L}\p{N}]+#u', '', $titleWord);
							
							if( ! in_array( strtolower($titleWord) , $stopWords)){
							
								if(in_array('OPT_TITLE_NUM', $camp_opt) && is_numeric(trim($titleWord))){
									//numbers
								}else{
									$validTitleWords[]=$titleWord;
								}
								
								 
							}
							
							
						}
						
					 	$post_tags = array_merge($post_tags,$validTitleWords);
						
						 
					}
					
					// Keyword to tag
					if(in_array('OPT_KEYWORD_TAG', $camp_opt) && trim($camp_general['cg_keyword_tag']) != '' ){
						  echo '<br>Keyword to tag check started...';
					
						$cg_keyword_tag = $camp_general['cg_keyword_tag'];
						$cg_keyword_tag_rules = array_filter( explode("\n", $cg_keyword_tag) );
					
						foreach ($cg_keyword_tag_rules as $cg_keyword_tag_rule) {
							if(stristr( $cg_keyword_tag_rule , '|')){
					
								$cg_keyword_tag_rule = trim($cg_keyword_tag_rule);
					
								$cg_keyword_tag_rule_parts = explode ('|', $cg_keyword_tag_rule) ;
					
								$cg_keyword_tag_rule_keyword  = $cg_keyword_tag_rule_parts[0];
								$cg_keyword_tag_rule_tag = $cg_keyword_tag_rule_parts[1];
					
								if( preg_match('{\b' . preg_quote( $cg_keyword_tag_rule_keyword ). '\b}siu', $post_title.' '.$abcont)){
										
									  echo '<br><- Key '.$cg_keyword_tag_rule_keyword . ' exists adding tag:'.$cg_keyword_tag_rule_tag;
										
									if( stristr($cg_keyword_tag_rule_tag, ',') ){
										
										$post_tags = array_merge($post_tags,explode(',', $cg_keyword_tag_rule_tag));
										
									}elseif(trim($cg_keyword_tag_rule_tag)){
										
										$post_tags[]=$cg_keyword_tag_rule_tag;
											
									}
										
								}
					
							}
						}
					
					}
					
				 
					if(count( array_filter( $post_tags ) ) > 0){
						
						$post_tags = array_filter($post_tags);
				 
						  echo '<br>Setting ' . count($post_tags) .' post tags as tags';
					
						if(in_array('OPT_TAXONOMY_TAG', $camp_opt)){
							
							wp_set_post_terms( $id, implode(',', $post_tags), trim($camp_general['cg_tag_tax']), true );
							
						}else{
							wp_set_post_tags ( $id, implode(',', $post_tags) , true );
						}
					 
					}
					
					//now timestamp
					$now = time('now');
					
					//amazon woocommerce integration
					if($camp_type == 'Amazon' && $camp->camp_post_type == 'product'){
						
						$camp_post_custom_k = array_merge ( array('product_price_updated','product_asin','product_price','product_list_price','_regular_price','_price','_sale_price','_visibility', '_product_url','_button_text','_product_type'),$camp_post_custom_k);
						
						$wp_automatic_woo_buy = get_option('wp_automatic_woo_buy','Buy Now');
						if(trim($wp_automatic_woo_buy) == '') $wp_automatic_woo_buy = 'Buy Now' ;
						
						$camp_post_custom_v = array_merge ( array( $now , '[product_asin]','[product_price]','[product_list_price]','[list_price_numeric]','[price_numeric]','[price_numeric]','visible','[product_link]',$wp_automatic_woo_buy,'external'),$camp_post_custom_v);
						
						//product gallery
						if( isset($img['product_imgs']) && stristr($img['product_imgs'], ',') && in_array('OPT_AM_GALLERY', $camp_opt)){
							
							  echo '<br>Multiple images found setting a gallery';
							$attachmentsIDs=array();
							
							$product_imgs_txt = $img['product_imgs'];
							$product_imgs = explode(',', $product_imgs_txt);
							
							//first image already attached
							if(isset($attach_id)){
								
								//$attachmentsIDs[] = $attach_id;
								unset($product_imgs[0]);
							}
							
							// set rest images as attachments
							foreach ($product_imgs as $product_img){
								  echo '<br>Attaching:'. $product_img ;
								$newAttach = $this->attach_image($product_img, $camp_opt, $post_id);
								
								if(is_numeric($newAttach) && $newAttach > 0 ){
									$attachmentsIDs[]=$newAttach;
								}
								
								
							}
							
							if(count($attachmentsIDs) > 0){
								
								$attachmentsIDsStr = implode(',', $attachmentsIDs); 
								add_post_meta($id,'_product_image_gallery',$attachmentsIDsStr);
								
							}
							
						}
						 
						wp_set_object_terms ($id, 'external', 'product_type');
						
						
						
					}elseif($camp_type == 'eBay' && $camp->camp_post_type == 'product'){
						
						$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('_regular_price','_price','_visibility', '_product_url','_button_text','_product_type'));
						$wp_automatic_woo_buy = get_option('wp_automatic_woo_buy2','Buy Now');
						if(trim($wp_automatic_woo_buy) == '') $wp_automatic_woo_buy = 'Buy Now' ;
						
						$camp_post_custom_v = array_merge ( $camp_post_custom_v , array('[item_price_numeric]','[item_price_numeric] ','visible','[item_link]',$wp_automatic_woo_buy,'external'));
							
						wp_set_object_terms ($id, 'external', 'product_type');
					
					}elseif($camp_type == 'Amazon' && $camp->camp_post_type != 'product'){
						
						$camp_post_custom_k = array_merge ( array('product_price_updated','product_asin','product_price','product_list_price'),$camp_post_custom_k);
						$camp_post_custom_v = array_merge ( array( $now , '[product_asin]','[product_price]','[product_list_price]'),$camp_post_custom_v);
						
					}elseif($camp_type == 'Walmart' && $camp->camp_post_type != 'product'){
						
						$camp_post_custom_k = array_merge ( array('product_price_updated','product_upc','product_price','product_list_price'),$camp_post_custom_k);
						$camp_post_custom_v = array_merge ( array( $now , '[item_upc]','$[item_price]','$[item_list_price]'),$camp_post_custom_v);
						
					}elseif($camp_type == 'Walmart' && $camp->camp_post_type == 'product'){
						
						//affiliate item_link
						if(stristr( $post_content , 'linksynergy')){
							$buyShortCode = '[product_affiliate_url]';
						}else{
							$buyShortCode = '[item_link]';
						}
						
						$camp_post_custom_k = array_merge ( array('product_price_updated','product_upc','product_price','product_list_price','_regular_price','_price','_sale_price','_visibility', '_product_url','_button_text','_product_type'),$camp_post_custom_k);
						
						$wp_automatic_woo_buy = get_option('wp_automatic_woo_buy','Buy Now');
						if(trim($wp_automatic_woo_buy) == '') $wp_automatic_woo_buy = 'Buy Now' ;
						
						$camp_post_custom_v = array_merge ( array( $now , '[item_upc]','$[item_price]','$[item_list_price]','[item_list_price]','[item_price]','[item_price]','visible',$buyShortCode,$wp_automatic_woo_buy,'external'),$camp_post_custom_v);
						
						//product gallery
						if( isset($img['item_imgs']) && stristr($img['item_imgs'], ',') && in_array('OPT_WM_GALLERY', $camp_opt)){
								
							  echo '<br>Multiple images found setting a gallery';
							$attachmentsIDs=array();
								
							$product_imgs_txt = $img['item_imgs'];
							$product_imgs = explode(',', $product_imgs_txt);
								
							//first image already attached
							if(isset($attach_id)){
						
								//$attachmentsIDs[] = $attach_id;
								unset($product_imgs[0]);
							}
								
							// set rest images as attachments
							foreach ($product_imgs as $product_img){
								  echo '<br>Attaching:'. $product_img ;
								$newAttach = $this->attach_image($product_img, $camp_opt, $post_id);
						
								if(is_numeric($newAttach) && $newAttach > 0 ){
									$attachmentsIDs[]=$newAttach;
								}
						
						
							}
								
							if(count($attachmentsIDs) > 0){
						
								$attachmentsIDsStr = implode(',', $attachmentsIDs);
								add_post_meta($id,'_product_image_gallery',$attachmentsIDsStr);
						
							}
								
						}
							
						wp_set_object_terms ($id, 'external', 'product_type');
						
					}elseif( $camp->camp_post_type == 'product' ){
						
							$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('_visibility'));
							$camp_post_custom_v = array_merge ( $camp_post_custom_v , array('visible'));
								
							wp_set_object_terms ($id, 'external', 'product_type');
								
						
					}
				 
					//TrueMag integration 
					if(  ($camp_type == 'Youtube' || $camp_type == 'Vimeo')    ){
						
						if( (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video')  ){
						
							  echo '<br>TrueMag/NewsTube theme exists adabting config..';
							$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('tm_video_url','_count-views_all'));
							$camp_post_custom_v = array_merge ( $camp_post_custom_v , array('[source_link]','[vid_views]'));
						 
							//adding likes n dislikes
							$vid_likes =  $img['vid_likes'];
							$vid_dislikes = $img['vid_dislikes'];
							 
							//adding likes 
							if($vid_likes > 0 ){
								
								try {
									
									$query = "INSERT INTO {$this->db->prefix}wti_like_post SET ";
									$query .= "post_id = '" . $id . "', ";
									$query .= "value = '$vid_likes', ";
									$query .= "date_time = '" . date( 'Y-m-d H:i:s' ) . "', ";
									$query .= "ip = ''";
									@$this->db->query($query);
									
								} catch (Exception $e) {
									
								}
								
							}
							
							if($vid_dislikes > 0 && $camp_type == 'Youtube'  ){
							
								$query = "INSERT INTO {$this->db->prefix}wti_like_post SET ";
								$query .= "post_id = '" . $id . "', ";
								$query .= "value = '-$vid_dislikes', ";
								$query .= "date_time = '" . date( 'Y-m-d H:i:s' ) . "', ";
								$query .= "ip = ''";
								@$this->db->query($query);
							}
							
							
						
						}
		 			}
		 			
		 			// truemag dailymotion integration
		 			if($camp_type == 'DailyMotion'){
		 				
		 				if( (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video')  ){
		 				
		 					  echo '<br>TrueMag/NewsTube theme exists adabting config..';
		 					$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('tm_video_url','_count-views_all'));
		 					$camp_post_custom_v = array_merge ( $camp_post_custom_v , array('[source_link]','[item_views]'));
		 						
		 				
		 				}
		 				
		 			}

		 			// trumag instagram integration
		 			if( ($camp_type == 'Instagram' )     && stristr($abcont, '[embed]')  ){
		 				
		 				if( (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
		 			
		 					  echo '<br>TrueMag/NewsTube theme exists adabting config..';
 		 					
		 					//extract video url
		 					preg_match('{\[embed\](.*?)\[/embed\]}', $abcont,$embedMatchs);
		 					 
		 					$embedUrl = $embedMatchs[1];
		 					 
		 					
		 					$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('tm_video_file'));
		 					$camp_post_custom_v = array_merge ( $camp_post_custom_v , array($embedUrl));
		 						
		 					//adding likes n dislikes
		 					$vid_likes =  $img['item_likes_count'];
		 					 
		 					//adding likes
		 					if($vid_likes > 0 ){
		 			
		 						try {
		 							
			 						
			 						$query = "INSERT INTO {$this->db->prefix}wti_like_post SET ";
			 						$query .= "post_id = '" . $id . "', ";
			 						$query .= "value = '$vid_likes', ";
			 						$query .= "date_time = '" . date( 'Y-m-d H:i:s' ) . "', ";
			 						$query .= "ip = ''";
			 						@$this->db->query($query);
			 						
		 						} catch (Exception $e) {
		 						}
		 						
		 					}
		 			
		 				}
		 			}
		 			
		 			
		 			//truemag facebook integration 
		 			if($camp_type =='Facebook'){
		 				
		 				if(isset($img['vid_url'])){
		 					
		 					if( (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
		 					
		 						  echo '<br>TrueMag setup and video exists...';
		 						
		 						$camp_post_custom_k = array_merge ( $camp_post_custom_k , array('tm_video_url'));
		 						$camp_post_custom_v = array_merge ( $camp_post_custom_v , array($img['vid_url']));
		 							
		 					
		 					}
		 				}
		 				
		 			}
					
		  				 	
					//replacing tags 
					$camp_post_custom_v = implode ( '****', $camp_post_custom_v );
					foreach ( $img as $key => $val ) {
						if(! is_array($val)){
							$camp_post_custom_v = str_replace ( '[' . $key . ']', $val, $camp_post_custom_v );
						}
						
						//feed custom attributes
						if($camp_type == 'Feeds'){
						
							$attributes = $img['attributes'];
						
							foreach ($attributes as $attributeKey => $attributeValue){
									
								$camp_post_custom_v = str_replace('['.$attributeKey.']', $attributeValue[0]['data'] , $camp_post_custom_v);
									
							}
						}
						
					}
					$camp_post_custom_v = explode ( '****', $camp_post_custom_v );
					
					
					//NewsPaper theme integration
					if( ($camp_type == 'Youtube' || $camp_type == 'Vimeo') && function_exists('td_bbp_change_avatar_size')){
						  echo '<br>NewsPaper theme found integrating..';
					
					
					
						$td_video = array();
						$td_video['td_video'] = $img['vid_url'];
						$td_video['td_last_video'] = $img['vid_url'];
					
							
					
						$camp_post_custom_k[] = 'td_post_video';
						$camp_post_custom_v[] =  $td_video;
					
						//format
						  echo '<br>setting post format to Video';
						set_post_format($id,  'video' );
					
						//custom field
					
					}
						
					
					// adding custom filds
					$in = 0;
					if (count ( $camp_post_custom_k ) > 0) {
						
					 	
						foreach ( $camp_post_custom_k as $key ) {
							if (  trim ($key) != '' && ( is_array($camp_post_custom_v [$in]) || trim ($camp_post_custom_v [$in]) != '' )  ) {
								  echo '<br>Setting custom field ' . $key  ;
								
								 //serialized arrays
								if(is_serialized($camp_post_custom_v [$in])) $camp_post_custom_v [$in] = unserialize($camp_post_custom_v [$in]);
							
								if($key == 'excerpt'){
	
									$my_post = array(
											'ID'           => $id,
											'post_excerpt' => $camp_post_custom_v [$in] ,
									);
									
									wp_update_post( $my_post );
									
								}else{
									
									//if rand num
									$key_val = $camp_post_custom_v [$in];
									
									if( ! is_array($key_val) && stristr($key_val, 'rand_' ) ){
										
										$key_val_clean = str_replace( array( '[' ,']') , '', $key_val);
										$val_parts = explode('_', $key_val_clean);
										
										if(count($val_parts) == 3 && is_numeric($val_parts[1]) && is_numeric($val_parts[2]) ){
											$key_val = rand($val_parts[1],$val_parts[2]);
										}
										
									}
									
									update_post_meta ( $id, $key, $key_val );
							
								}
									
							}
							
							$in ++;
						}
					}
					
					//setting post format OPT_FORMAT 
					if (in_array ( 'OPT_FORMAT', $camp_opt )) {
						  echo '<br>setting post format to '.$camp_general['cg_post_format'];
						set_post_format($id, stripslashes($camp_general['cg_post_format']) );
					}elseif ( ($camp_type == 'Youtube' || $camp_type == 'Vimeo' || $camp_type == 'DailyMotion')     ){
						
						if(  (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
							  echo '<br>setting post format to Video';
							set_post_format($id,  'video' );
						}
					}elseif ( ($camp_type == 'Instagram'  )    && stristr($abcont, '[embed]')  ){
						
						if(  (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
							  echo '<br>setting post format to Video';
							set_post_format($id,  'video' );
						}
					}elseif($camp_type == 'Facebook' && isset($img['vid_url'])){
						
						if(  (defined('PARENT_THEME') &&  (PARENT_THEME =='truemag' || PARENT_THEME =='newstube'))  || class_exists('Cactus_video') ){
							  echo '<br>setting post format to Video';
							set_post_format($id,  'video' );
						}
						
					}
					
					 
					//publishing the post 
					if(in_array('OPT_DRAFT_PUBLISH', $camp_opt) && $camp->camp_post_status == 'publish'){
						
						echo '<br>Publishing the post now...';
						$newUpdatedPostArr['ID'] = $id;
						$newUpdatedPostArr['post_status'] = 'publish';
						
						wp_update_post($newUpdatedPostArr);
					
					}
					
					if(in_array('OPT_PREVIEW_EDIT',$wp_automatic_options)){
						$plink = admin_url('post.php?post='.$id.'&action=edit');
						if(trim($plink) == '') $plink =  get_permalink ( $id ) ;
					}else{
						$plink =  get_permalink ( $id ) ;
					}
					
					$plink = str_replace('&amp;', '&', $plink) ;
					 
					
					$display_title = get_the_title ( $id );
					
					if(trim($display_title) == '') $display_title = '(no title)';
					
					$now = date ( 'Y-m-d H:i:s' );
					$now = get_date_from_gmt($now);
					 
					  echo '<br>New Post posted: <a target="_blank" class="new_post_link" time="' . $now . '" href="' .  $plink . '"> ' . $display_title . '</a>';
					$this->log ( 'Posted:' . $camp->camp_id, 'New post posted:<a href="' . $plink . '">' . get_the_title ( $id ) . '</a>' );
					
					//returning the security filter
					add_filter('content_save_pre', 'wp_filter_post_kses');
					
					//duplicate cache update
					if( $this->campDuplicateLinksUpdate == true ){
						
						$this->campNewDuplicateLinks[$id] = $source_link;
						update_post_meta($camp->camp_id, 'wp_automatic_duplicate_cache', $this->campNewDuplicateLinks);
					 	
					}
					
					exit ();
					
					print_r ( $ret );
				} // if title
			} // end function
			
			
			/**
			 * Checks if allowed to call the source or not: compares the call limit with actual previous calls
			 */
			function is_allowed_to_call(){
				
				if($this->sourceCallLimit == $this->sourceCallTimes){
					  echo '<br> We have called the source '.$this->sourceCallLimit.' times already will die now and complete next time...';
					exit;
				}
				
				$this->sourceCallTimes++ ;
				
			}
			
			
			/**
			 * Validate if the post contains the exact match keywords and does not contain the banned words
			 * @param String $cnt the content 
			 * @param String $ttl the title 
			 * @param String $opt campaign options
			 * @param String $camp whole camp record
			 * @param boolean $after true if after the template
			 */
			function validate_exacts(&$abcont,&$title,&$camp_opt,&$camp,$after=false,$camp_general = array()){
				
				// Valid 
				$valid = true;
				
				$exact = $camp->camp_post_exact;
				$execr = '';
				$execr = @$camp_general['cg_camp_post_regex_exact'];
				$excludeRegex = @$camp_general['cg_camp_post_regex_exclude'];
				
				// Validate exacts
				if(in_array('OPT_EXACT' , $camp_opt )){
					
					// Exact keys 
					
					// Validating Exact
					if (trim ( $exact ) != '' && in_array('OPT_EXACT', $camp_opt) &&  ( ! in_array('OPT_EXACT_AFTER', $camp_opt) && ! $after  ||  in_array('OPT_EXACT_AFTER', $camp_opt) && $after  )   ) {

						$valid = false;
						
						$exactArr = explode ( "\n", trim ( $exact ) );
						foreach ( $exactArr as $wordexact ) {
							if (trim ( $wordexact != '' )) {
					
								if(in_array('OPT_EXACT_STR', $camp_opt)){
										
									if(  in_array('OPT_EXACT_TITLE_ONLY', $camp_opt)  && stristr( html_entity_decode($title) ,  trim ( $wordexact )   ) ){
										
										echo '<br>Title contains the word : ' . $wordexact ;
										$valid = true;
										if(! in_array('OPT_EXACT_ALL', $camp_opt)) break;
										
									}elseif ( ! in_array('OPT_EXACT_TITLE_ONLY', $camp_opt) && (  stristr ( html_entity_decode($abcont) , trim ( $wordexact )  ) ||  stristr (   trim ( $wordexact )  , html_entity_decode($title) )  ) ) {
										 
										echo '<br>Content contains the word : ' . $wordexact ;
										 $valid = true;
										 if(! in_array('OPT_EXACT_ALL', $camp_opt)) break;
										   
									}else{
										
										  echo '<br>Content does not contain the word : ' . $wordexact . ' try another ';
										  $valid = false;
										  if( in_array('OPT_EXACT_ALL', $camp_opt)) break;
									
									} // match
										
								}else{
										
									if(  in_array('OPT_EXACT_TITLE_ONLY', $camp_opt)  && preg_match ( '/\b' . trim ( $wordexact ) . '\b/iu', html_entity_decode($title) ) ){
										  echo '<br>Title contains the word : ' . $wordexact ;
										  $valid = true;
										  if(! in_array('OPT_EXACT_ALL', $camp_opt)) break;
										  
									}elseif ( ! in_array('OPT_EXACT_TITLE_ONLY', $camp_opt) && (  preg_match ( '/\b' . trim ( $wordexact ) . '\b/iu', html_entity_decode($abcont) ) ||  preg_match ( '/\b' . trim ( $wordexact ) . '\b/iu', html_entity_decode($title) )  ) ) {
										  echo '<br>Content contains the word : ' . $wordexact ;
										 $valid = true;
										 if(! in_array('OPT_EXACT_ALL', $camp_opt)) break;
										 
									}else{
										  echo '<br>Content does not contain the word : ' . $wordexact . ' try another ';
										  $valid = false;
										  if( in_array('OPT_EXACT_ALL', $camp_opt)) break;
									} // match
					
										
								}
					
					
							} // trim wordexact
						} // foreach exactword
					} // trim exact
				}
					
				// VALIDATING EXCLUDES
				if ($valid == true) { 

					$execl = $camp->camp_post_execlude;
					
					if (trim ( $execl ) != '' && in_array('OPT_EXECLUDE', $camp_opt) &&    ( ! in_array('OPT_EXECLUDE_AFTER', $camp_opt) && ! $after  ||  in_array('OPT_EXECLUDE_AFTER', $camp_opt) && $after  )  ) {
						
						//additional excl 
						$execl.= "\n".$this->generalBannedWords ; 
						
						$execlArr = explode ( "\n", trim ( $execl ) );
							
						foreach ( $execlArr as $wordex ) {
							if (trim ( $wordex != '' )) {
								
								$wordex = trim($wordex);
								
								if(in_array('OPT_EXCLUDE_EXACT_STR', $camp_opt)){
									
									
									if(stristr( html_entity_decode($title) . html_entity_decode($abcont) , $wordex) ){
										
										echo '<br>Content contains the banned word :' . $wordex . ' getting another ';
										$valid = false;
										break;
										
									}
									
								}elseif ( preg_match ( '/\b' . trim (  $wordex  ) . '\b/iu', html_entity_decode($abcont) ) || preg_match ( '/\b' . trim (  $wordex  ) . '\b/iu', (html_entity_decode($title)) )   ) {
									  echo '<br>Content contains the banned word :' . $wordex . ' getting another ';
									$valid = false;
									break;
								}
							} // trim wordexec
						} // foreach wordex
					} // trim execl
				} // valid
					
				// Before only REGEX check
				if(! $after) {
						// validate REGEX
						if($valid == true){ 
							
							if(trim ( $execr ) != '' & in_array('OPT_EXACT_REGEX', $camp_opt)    ){
								
								$valid = false;
								$exactArr = explode ( "\n", trim ( $execr ) );
								
								foreach ( $exactArr as $wordexact ) {
									
									$wordexact = trim($wordexact);
									
									if (trim ( $wordexact != '' )) {
										if (  preg_match ( '{'.$wordexact.'}ius', html_entity_decode($abcont) ) ||  preg_match ( '{' . trim ( $wordexact ) . '}ius', html_entity_decode($title) )   ) {
											
											echo '<br>REGEX Matched : ' . $wordexact ;
											$valid = true;
											break;
										}else{
											echo '<br>REGEX did not match : ' . $wordexact . ' try another ';
										} // match
									} // trim wordexact
								} // foreach exactword
								
							}
						}
						
					 
						
						// exclude if match a specific REGEX
						if( $valid == true ){
							
							if(trim ( $excludeRegex ) != '' & in_array('OPT_EXCLUDE_REGEX', $camp_opt)  ){
								
								$excludeArr = explode ( "\n", trim ( $excludeRegex ) );
								
								foreach ( $excludeArr as $wordexact ) {
									$wordexact = trim($wordexact);
									if (trim ( $wordexact != '' )) {
										if (  preg_match ( '{'.$wordexact.'}ius', html_entity_decode($abcont) ) ||  preg_match ( '{' . trim ( $wordexact ) . '}ius', html_entity_decode($title) )   ) {
											
											echo '<br>Exclude REGEX matched : ' . $wordexact ;
											$valid = false;
											break;
										}else{
											echo '<br>Exclude REGEX did not match : ' . $wordexact . ' try another ';
										} // match
									} // trim wordexact
								} // foreach exactword
								
							}
							
						}
				
				}
				
				return $valid;
				
				
			}
			
			function fire_proxy() {
				  echo '<br>Proxy Check Fired';
				$proxies = get_option ( 'wp_automatic_proxy' );
				if (stristr ( $proxies, ':' )) {
					  echo '<br>Proxy Found lets try';
					// listing all proxies
					
					$proxyarr = explode ( "\n", $proxies );
					
					foreach ( $proxyarr as $proxy ) {
						if (trim ( $proxy ) != '') {
							
							$auth = '';
							if (substr_count ( $proxy, ':' ) == 3) {
								  echo '<br>Private proxy found .. using authentication';
								$proxy_parts = explode ( ':', $proxy );
								
								$proxy = $proxy_parts [0] . ':' . $proxy_parts [1];
								$auth = $proxy_parts [2] . ':' . $proxy_parts [3];
								
								curl_setopt ( $this->ch, CURLOPT_PROXY, trim ( $proxy ) );
								curl_setopt ( $this->ch, CURLOPT_PROXYUSERPWD, trim($auth) );
							} else {
								curl_setopt ( $this->ch, CURLOPT_PROXY, trim ( $proxy ) );
							}
							
							  echo "<br>Trying using proxy :$proxy";
							
							curl_setopt ( $this->ch, CURLOPT_HTTPPROXYTUNNEL, 1 );
							
							curl_setopt ( $this->ch, CURLOPT_URL, 'www.bing.com/search?count=50&intlF=1&mkt=En-us&first=0&q=test' );
							// curl_setopt($this->ch, CURLOPT_URL, 'http://whatismyipaddress.com/');
							$exec = curl_exec ( $this->ch );
							$x = curl_error ( $this->ch );
							
							if ( trim($x) != '' ) {
								  echo '<br>Curl Proxy Error:' . curl_error ( $this->ch );
							} else {
								
								if (stristr ( $exec, 'It appears that you are using a Proxy' ) || stristr ( $exec, 'excessive amount of traffic' )) {
									  echo '<br>Proxy working but captcha met let s skip it';
								} elseif (stristr ( $exec, 'microsoft.com' )) {
									
									// succsfull connection here
									//   echo curl_exec($this->ch);
									// reordering the proxy
									$proxies = str_replace ( ' ', '', $proxies );
									
									if(trim($auth) != '')
										$proxy = $proxy.':'.$auth;
									
									$proxies = str_replace($proxy, '', $proxies);	
										
									$proxies = str_replace ( "\n\n", "\n", $proxies );
									$proxies = "$proxy\n$proxies";
									//   echo $proxies;
									update_option ( 'wp_automatic_proxy', $proxies );
									
									  echo '<br>Connected successfully using this proxy ';
									
									$this->isProxified = true;
									
									return true;
								} else {
									
									  echo '<br>Proxy Reply:'.$exec;
									
								}
							}
						}
					}
					
					// all proxies not working let's call proxyfrog for new list
					
					// no proxyfrog list
					$this->unproxyify ();
					
					// proxifing the connection
				}else{
					  echo '..No proxies';
				}
			}
			
			/*
			 * ---* Clear proxy function ---
			 */
			function unproxyify() {
				// clean the connection
				unset ( $this->ch );
				
				// curl ini
				$this->ch = curl_init ();
				curl_setopt ( $this->ch, CURLOPT_HEADER, 0 );
				curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $this->ch, CURLOPT_CONNECTTIMEOUT, 20 );
				curl_setopt ( $this->ch, CURLOPT_TIMEOUT, 30 );
				curl_setopt ( $this->ch, CURLOPT_REFERER, 'http://www.google.com' );
				curl_setopt ( $this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8' );
				curl_setopt ( $this->ch, CURLOPT_MAXREDIRS, 5 ); // Good leeway for redirections.
				curl_setopt ( $this->ch, CURLOPT_FOLLOWLOCATION, 1 ); // Many login forms redirect at least once.
				curl_setopt ( $this->ch, CURLOPT_COOKIEJAR, "cookie.txt" );
			}
			 
			/*
			 * ---* Spin function that calls TBS ---
			 */
			function spin($html) {
				
				$url = 'http://thebestspinner.com/api.php';
				
				// $testmethod = 'identifySynonyms';
				$testmethod = 'replaceEveryonesFavorites';
				
				// Build the data array for authenticating.
				
				$data = array ();
				$data ['action'] = 'authenticate';
				$data ['format'] = 'php'; // You can also specify 'xml' as the format.
				                          
				// The user credentials should change for each UAW user with a TBS account.
				$tbs_username = get_option ( 'wp_automatic_tbs', '' ); // "gigoftheday@gmail.com"; // Enter your The Best Spinner's Email ID
				$tbs_password = get_option ( 'wp_automatic_tbs_p', '' ); // "nd8da759a40a551b9aafdc87a1d902f3d"; // Enter your The Best Spinner's Password
				$tbs_protected = get_option ('wp_automatic_tbs_protected','');
				
				if(trim($tbs_protected) != ''){
					$tbs_protected = explode("\n", $tbs_protected);
					$tbs_protected = array_filter($tbs_protected);
					$tbs_protected = array_map('trim', $tbs_protected);
					
					$tbs_protected = array_filter($tbs_protected);
					
					$tbs_protected = implode(',', $tbs_protected);
				}
				
				//add , if not exists
				if(! stristr($tbs_protected, ',')  ){
					$tbs_protected = $tbs_protected .',';
				}
				
				//add ad_1, ad_2 , numbers
				$tbs_protected = $tbs_protected . 'ad_1,ad_2,0,1,2,3,4,5,6,7,8,9,';
				
				if (trim ( $tbs_username ) == '' || trim ( $tbs_password ) == '') {
					//$this->log ( 'Info', 'No BTS account found , it is highly recommended ' );
					return $html;
				}
				
				$data ['username'] = $tbs_username;
				$data ['password'] = $tbs_password;
				
				// Authenticate and get back the session id.
				// You only need to authenticate once per session.
				// A session is good for 24 hours.
				$output = unserialize ( $this->curl_post ( $url, $data, $info ) );
				
				if ($output ['success'] == 'true') {
					
					$this->log ( 'TBS', "TBS Login success" );
					  echo '<br>TBS Login success';
					// Success.
					$session = $output ['session'];
					
					// Build the data array for the example.
					$data = array ();
					$data ['protectedterms'] = $tbs_protected;
					$data ['session'] = $session;
					$data ['format'] = 'php'; // You can also specify 'xml' as the format.
					
					//instantiate original html
					$newhtml = $html;
					
					//replace nospins with astrics
					preg_match_all('{\[nospin.*?\/nospin\]}s', $html ,$nospins);
					$nospins = $nospins[0];
					
					//shortcodes
					preg_match_all('{\[.*?]}s', $html ,$shortcodes);
					$shortcodes = $shortcodes[0];
					
					//html
					preg_match_all("/<[^<>]+>/is",$html,$matches,PREG_PATTERN_ORDER);
					$htmlfounds=$matches[0];
					
					//js
					preg_match_all("/<script.*?<\/script>/is",$html,$matches3,PREG_PATTERN_ORDER);
					$js=$matches3[0];
					
					//numbers
					preg_match_all("{\d\d+}is", $html,$numMatches);
			        $numFounds = ($numMatches[0]);
			        $numFounds = array_filter(array_unique($numFounds));
			        
			   		usort($numFounds,'wp_automatic_sort');
			       
	  	   			$nospins = array_merge($nospins,$shortcodes,$htmlfounds,$js,$numFounds,array(9,8,7,6,5,4,3,2,1));
					 
					//remove empty and duplicate
					$nospins = array_filter(array_unique($nospins));
					
					//replace nospin parts with astrics
					$i=1;
					foreach ($nospins as $nospin){
						 $newhtml = str_replace($nospin, '['.str_repeat('*', $i).']', $newhtml);
						 $i++;
					}
					
					$data ['text'] =   ( html_entity_decode($newhtml) );
					 
				 
					//$data ['text'] = 'test <br> word <a href="http://onetow.com">http://onetow.com</a> ';
					
					$data ['action'] = $testmethod;
					$data ['maxsyns'] = '100'; // The number of synonyms per term.
					
					if ($testmethod == 'replaceEveryonesFavorites') {
						// Add a quality score for this method.
						$data ['quality'] = '1';
					}
					
					 
					// Post to API and get back results.
					$output = $this->curl_post ( $url, $data, $info );
					$output = unserialize ( $output );
					
					// Show results.
					//   echo "<p><b>Method:</b><br>$testmethod</p>";
					//   echo "<p><b>Text:</b><br>$data[text]</p>";
					
					if ($output ['success'] == 'true') {
						$this->log ( 'TBS', "TBS Successfully spinned the content" );
					
						
						//replace the astrics with nospin tags 
						if( count($nospins) > 0 ){
							
							$i = 1 ;
							
							foreach($nospins as $nospin){
		
								$output ['output'] = str_replace('['.str_repeat('*', $i).']', $nospin, $output ['output']);
								
								$i++;
							}
							
							 
						}
						
		 				
						  echo '<br>TBS Successfully spinned the content';
						return $output ['output'];
					} else {
						
						
						$this->log ( 'error', "TBS Returned an error:$output[error]" );
						  echo "TBS Returned an error:$output[error]";
						return $html;
					}
				} else {
					// There were errors.
					  echo "<br>TBS returned an error : $output[error]";
					$this->log ( 'error', "TBS returned an error : $output[error]" );
					return $html;
				}
			} // end function
			
			/*
			 * gtranslte function
			 */
			function gtranslate($title, $content, $from, $to , $translationMethod = 'microsoftTranslator') {
				
				
			   // Verify API data
			   if($translationMethod == 'microsoftTranslator'){
			   	
				   	//$wp_automatic_mt_secret = trim(get_option('wp_automatic_mt_secret',''));
				   	$wp_automatic_mt_id = trim(get_option('wp_automatic_mt_key',''));
				   	
				   	if(trim($wp_automatic_mt_id) == ''){
				   		  echo '<br><span style="color:red">Microsoft translator settings required. Visit the plugin settings and set it.</span>';
				   		return array($title,$content);
				   	}
				   	
				   	$titleSeparator = '[19459000]';
				   	 
			   }else{
			   	
			   	    $titleSeparator = '##########';
			   		$titleSeparator = "\n[19459000]";
			   	     		
			   } 
	           
			   // Fix Norwegian language Translation 
			   if($from == 'nor') $from = 'no';
			   if($to == 'nor') $to = 'no';
			   
			   // Report Translate
			     echo '<br>Translating from '.$from . ' to '.$to . ' using '.$translationMethod;
				
			   // Concat title and content in one text
				$text = $title . $titleSeparator . $content;
				
				if($this->debug == true)   echo "\n\n--- Translation text-------\n".$text;
				
				//decode html for chars like &euro;  
				$text = html_entity_decode($text);
			
				//scripts
				preg_match_all('{<script.*?script>}s', $text,$script_matchs);
				$script_matchs = $script_matchs[0];
				
				
				 
				// STRIP html and links
				preg_match_all ( "/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER );
				$htmlfounds = array_filter( array_unique($matches [0]));
				
				$htmlfounds = array_merge($script_matchs,$htmlfounds);
				
				$htmlfounds[] = '&quot;';
				
				// Fix alt tags
				$imgFoundsSeparated = array();
				$new_imgFoundsSeparated = array();
				foreach($htmlfounds as $key => $currentFound){
					
					if(stristr($currentFound, '<img') && stristr($currentFound, 'alt')){
						 
						$altSeparator = '';
						$colonSeparator = '';
						if(stristr($currentFound, 'alt="')){
							$altSeparator = 'alt="';
							$colonSeparator = '"';
						}elseif(stristr($currentFound, 'alt = "')){
							$altSeparator = 'alt = "';
							$colonSeparator = '"';
						}elseif(stristr($currentFound, 'alt ="')){
							$altSeparator = 'alt ="';
							$colonSeparator = '"';
						}elseif(stristr($currentFound, 'alt= "')){
							$altSeparator = 'alt= "';
							$colonSeparator = '"';
						}elseif(stristr($currentFound, 'alt=\'')){
							$altSeparator = 'alt=\'';
							$colonSeparator = '\'';
						}elseif(stristr($currentFound, 'alt = \'')){
							$altSeparator = 'alt = \'';
							$colonSeparator = '\'';
						}elseif(stristr($currentFound, 'alt= \'')){
							$altSeparator = 'alt= \'';
							$colonSeparator = '\'';
						}elseif(stristr($currentFound, 'alt =\'')){
							$altSeparator = 'alt =\'';
							$colonSeparator = '\'';
						} 
						
						if(trim($altSeparator) != ''){
							
							$currentFoundParts = explode($altSeparator, $currentFound);
							
							//post alt
							$preAlt = $currentFoundParts[1];
							$preAltParts = explode($colonSeparator, $preAlt);
							$altText = $preAltParts[0];

							if(trim($altText) != ''){
								
								unset($preAltParts[0]);
								
								//before alt text part
								$imgFoundsSeparated[] = $currentFoundParts[0].$altSeparator;
								
								//after alt text
								$imgFoundsSeparated[] = str_replace($altText, '', $currentFoundParts[1] );
								
								//$imgFoundsSeparated[] = $colonSeparator.implode($colonSeparator, $preAltParts);
								
								/*
								  echo ' ImageFound:'.$in.' '.$currentFound;
								print_r($currentFoundParts);
								print_r($imgFoundsSeparated); */
								
								$htmlfounds[$key] = '';
								
							}
						}
					}
				}
				
				//title tag separation
				
				$title_separator = str_replace('alt', 'title', $altSeparator);
				
				foreach ($imgFoundsSeparated as  $img_part){
					
					if(stristr($img_part, ' title')){
						
						$img_part_parts = explode($title_separator, $img_part);
						
						//before title text
						$pre_title_part = $img_part_parts[0] . $title_separator;
						
						 $post_title_parts = explode($colonSeparator, $img_part_parts[1]);
						 $found_title = $post_title_parts[0];
						 
						 //after title text
						 $post_title_part = str_replace($found_title, '', $img_part_parts[1]);
						 
						 $new_imgFoundsSeparated[] = $pre_title_part;
						 $new_imgFoundsSeparated[] =  $post_title_part;
						 
						 
					}else{
						$new_imgFoundsSeparated[] = $img_part;
					}
					
				}
				
				
				if(count($new_imgFoundsSeparated) != 0){
					$htmlfounds = array_merge($htmlfounds,$new_imgFoundsSeparated);
				}
				
				//<!-- <br> -->
				preg_match_all ( "/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER );
				$newhtmlfounds = $matches2[0];
				
				//strip shortcodes
				preg_match_all ( "/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER );
				$shortcodesfounds = $matches3[0];
				
				$htmlfounds=array_merge($htmlfounds,$newhtmlfounds,$shortcodesfounds);

				//clean title separator & empties  
				$in=0;
				$cleanHtmlFounds = array();
				foreach ($htmlfounds as $htmlfound){
					
					if($htmlfound == '[19459000]') {
						 
					}elseif(trim($htmlfound) == ''){
						 
					}else{
						$cleanHtmlFounds[] = $htmlfound;
					}
					 	
				}
				 
				$htmlfounds = $cleanHtmlFounds;
				
				
				
				// Replace founds by numbers
			 	$start = 19459001;
				foreach ( $htmlfounds as $htmlfound ) {
					$text = str_replace ( $htmlfound, '[' . $start . ']', $text );
					$start++;
				}
				
				// .{ replace with . {
				$text = str_replace('.{', '. {', $text);
			 	
				//group consequent matchs [19459003][19459003][19459004][19459003]
				preg_match_all('!(?:\[1945\d*\][\s]*){2,}!s', $text,$conseqMatchs);
				
				if($this->debug == true) {
					echo "\n\n--- Html finds-------\n";
					print_r($htmlfounds);
					echo "\n\n----- Html before consequent replacements-----\n".$text;
				
					echo "\n\n--- Consequent masks finds-------\n";
				 
					print_r($conseqMatchs);
					
				}
				
				//replacing consequents
				$startConseq = 19659001 ;
				foreach ($conseqMatchs[0] as $conseqMatch){
					$text =preg_replace( '{' . preg_quote(  trim($conseqMatch) ) . '}'   , '['.$startConseq.']', $text,1 );
					$startConseq++;
				}
				
				//copy of the sent masks
				preg_match_all('{\[.*?\]}', $text,$pre_tags_matches);
				$pre_tags_matches = ($pre_tags_matches[0]);
			 
				//copy of sent masks with spaces before and after 
				preg_match_all('{\s*\[.*?\]\s*}u', $text,$pre_tags_matches_s);
				$pre_tags_matches_s = ($pre_tags_matches_s[0]);
				
				
				if($this->debug == true) {
					
					echo "\n\n----- Content to translate  without additional lins-----\n".$text;
					
				}
				
				//each tag in a new line
				$text = str_replace('[', "\n\n[", $text);
				$text = str_replace(']', "]\n\n", $text);
				
				if($this->debug == true) {
					
					echo "\n\n----- Content to translate  with  additional lins-----\n".$text;
					
				}
			 
				// Check Translation Method and use it
				
				if( $translationMethod == 'googleTranslator' ){
				
					try {
					
						// Google Translator Class
						require_once 'inc/translator.Google.php';
					
						// Google Translator Object
						$GoogleTranslator = new GoogleTranslator($this->ch);
						
						// Translate Method
						$translated = $GoogleTranslator->translateText($text, $from, $to);
						
						// same language error The page you have attempted to translate is already
						if(stristr($translated, 'The page you have attempted to translate is already')){
							echo '<br>Google refused to translate and tells that the article is in the same laguage';
							$translated=$text;
						}
						
						if($this->debug == true) {  echo "\n\n\n\n--- Returned translation-------\n".$translated."\n\n\n" ;}
					 
					} catch (Exception $e) {
					
						  echo 'Exception:'.$e->getMessage();
						
						$this->translationSuccess = false ;
						
						return array($title,$content);
					}
						
						
			    }else{
				 	
			    	 // Translating using Microsoft translator
					 require_once 'inc/translator.Microsoft.php';
					 
					 $MicrosoftTranslator = new MicrosoftTranslator($this->ch);
					 
					 try {
					 
					 	// Generate access token
					 	$accessToken = $MicrosoftTranslator->getToken($wp_automatic_mt_id);
					 	
					 	  echo '<br>Translated text chars: '. $this->chars_count($text);
					 	
					 	$translated = $MicrosoftTranslator->translateWrap($text, $from, $to);
					 		
					 	
					 } catch (Exception $e) {
					 	
					 	  echo '<br>Translation error:'.$e->getMessage();
					 	
					 	$this->translationSuccess = false ;
					 	
					 	return array($title,$content);
					 	
					 }
					 	
				 } 
				 
				 
				
				 // Fix broken ] 19459
				 $translated = preg_replace('{]\s*?1945}' , '][1945', $translated);
				 
				 // Fix broken Add Comment 19459012]
				 $translated = preg_replace('{ 19459(\d*?)]}' , ' [19459$1]', $translated);
				 
				 // Fix [[1945
				 $translated = str_replace('[ [1945', '[1945', $translated);
				 
				 // Fix ], [
				 $translated = str_replace('], ', ']', $translated);
				 
				 //file_put_contents( dirname(__FILE__) .'/test.txt' , $translated);
				 
				 // get all brackets
				 preg_match_all('{\[.*?\]}', $translated,$bracket_matchs);
				 $bracket_matchs= $bracket_matchs[0];
				 
				 foreach($bracket_matchs as $single_bracket){
				 	if(stristr($single_bracket, '1') && stristr($single_bracket, '9') ){
				 		$single_bracket_clean = str_replace( array(',',' '), '' , $single_bracket);
				 		$translated = str_replace($single_bracket,$single_bracket_clean,$translated);
				 	}
				 }
				 
				 //copy of the sent masks
				 preg_match_all('{\[.*?\]}', $translated,$post_tags_matches);
				 $post_tags_matches = ($post_tags_matches[0]);

				 if($this->debug == true) {
				 	echo "\n\n\n\n------ Pre translation and post tags-------";
				 	print_r($pre_tags_matches);
				 	print_r($pre_tags_matches_s);
				 	print_r($post_tags_matches);
				 }
				 
				 	//validate returned tags
				 	if(count($pre_tags_matches) == count($post_tags_matches)){
				 		if($pre_tags_matches !== $post_tags_matches ){
				 			
				 			$i=0;
				 			foreach ($post_tags_matches as $post_tags_match){
				 				$translated = preg_replace('{'.preg_quote( trim($post_tags_match) ).'}', '['.$i.']', $translated,1);
				 				$i++;
				 			}
				 			
				 			if($this->debug == true) {
				 				echo "\n\n\n\n-----Translated after replacing each tag with index-------";
				 				echo $translated;
				 			
				 			}
				 			
				 			//replacing index tags with real pre translation tags
				 			$i=0;
				 			foreach ($pre_tags_matches as $pre_tags_match){
				 				$translated  = str_replace('['.$i.']' ,$pre_tags_match,$translated);
				 				$i++;
				 			}
				 			
				 			
				 		}
				 	}
				 	
				 	//each tag in a new line restoration
				 	$translated = str_replace( "\n\n[" , '[', $translated);
				 	$translated = str_replace(  "]\n\n", ']' , $translated);
				 
				 	//resotring spaces before and after tags
				 	$i=0;
				 	foreach ($pre_tags_matches_s as $pre_tags_match){
				 		
				 		$pre_tags_match_h = htmlentities($pre_tags_match);
				 		if(stristr($pre_tags_match_h, '&nbsp;') ){
				 			$pre_tags_match = str_replace('&nbsp;', ' ', $pre_tags_match_h);
				 		}
				 		
				 		
				 		$translated = preg_replace('{'.preg_quote( trim($pre_tags_match) ).'}',  "[$i]" , $translated,1); 
				 		$i++;
				 	
				 	}
				 	
				 	//remove all spaces before and after current tags
				 	$translated = preg_replace('{\s*\[}u' , '[' ,$translated );
				 	$translated = preg_replace('{\]\s*}u' , ']' ,$translated );
				 	
				 	$i=0;
				 	foreach ($pre_tags_matches_s as $pre_tags_match){
				 		
				 		 
				 		
				 		// fix &nbsp;
				 	 	$pre_tags_match_h = htmlentities($pre_tags_match);
				 	 	if(stristr($pre_tags_match_h, '&nbsp;') ){
				 	 		$pre_tags_match = str_replace('&nbsp;', ' ', $pre_tags_match_h);
				 	 	} 
				 		 
				 		
				 		$translated = preg_replace('{'.preg_quote( "[$i]" ).'}',  $pre_tags_match , $translated,1); 
				 		
				 		
				 		$i++;
				 	}
				 	
				 if($this->debug == true) { 
				 	
				 	echo "\n\n\n\n--- --- Fixed translation-------"; print_r($translated);}
				 // restore consquent masks
				 $startConseq = 19659001 ;
				 foreach ($conseqMatchs[0] as $conseqMatch){
				 	$translated = str_replace( '['.$startConseq.']', $conseqMatch,$translated);
				 	$startConseq++;
				 }

				 
				 // Grab all replacements with **
				 preg_match_all('!\[.*?\]!', $translated,$brackets);
				 
				 $brackets = $brackets[0];
				 $brackets = array_unique($brackets);
				 	
				 	
				 foreach ($brackets as $bracket){
				 	if(stristr($bracket, '19')){
				 			
				 		$corrrect_bracket = str_replace(' ', '', $bracket);
				 		$corrrect_bracket = str_replace('.', '', $corrrect_bracket);
				 		$corrrect_bracket = str_replace(',', '', $corrrect_bracket);
				 			
				 		$translated = str_replace($bracket, $corrrect_bracket, $translated);
				 
				 	}
				 }
				 
				 
		   		// check if successful translation contains ***
				 if (stristr ( $translated, trim($titleSeparator) ) && count($pre_tags_matches) == count($post_tags_matches)  ) {
					
					$this->translationSuccess = true ;
					 
					// restore html tags
					$start = 19459001;
					foreach ( $htmlfounds as $htmlfound ) {
						$translated = str_replace ( '[' . $start . ']', $htmlfound, $translated );
						$start ++;
					}
					
					 
					$contents = explode ( trim($titleSeparator), $translated );
					$title = $contents [0];
					$content = $contents [1];
				} else {
					
					$this->translationSuccess = false ;
					
					  echo '<br>Translation failed ';
					 
				}
				
				return array (
						$title,
						$content 
				);
			}
			function curl_post($url, $data, &$info) {
				$ch = curl_init ();
				
				 
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($ch, CURLOPT_TIMEOUT,20);
				curl_setopt ( $ch, CURLOPT_URL, $url );
				curl_setopt ( $ch, CURLOPT_POST, true );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $this->curl_postData ( $data ) );
				curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $ch, CURLOPT_REFERER, $url );
				$html = trim ( curl_exec ( $ch ) );
				
				print_r(curl_error($ch));
				 
				return $html;
			}
			function curl_postData($data) {
				$fdata = "";
				foreach ( $data as $key => $val ) {
					$fdata .= "$key=" . urlencode ( $val ) . "&";
				}
				
				return $fdata;
			}
			
			/*
			 * ---* update cb categories ---
			 */
			function update_categories() {
				// Get
				$x = 'error';
				while ( trim ( $x ) != '' ) {
					$url = 'http://www.clickbank.com/advancedMarketplaceSearch.htm';
					curl_setopt ( $this->ch, CURLOPT_HTTPGET, 1 );
					curl_setopt ( $this->ch, CURLOPT_URL, trim ( $url ) );
					$exec = curl_exec ( $this->ch );
					  echo $x = curl_error ( $this->ch );
				}
				
				if (stristr ( $exec, '<option value="">- All categories -</option>' )) {
					  echo '<br>categories found';
					preg_match_all ( "{>- All categories -</option>((.|\s)*?)</select>}", $exec, $matches, PREG_PATTERN_ORDER );
					
					$res = $matches [0];
					$cats = $res [0];
					
					// extracting single parent categories [<option value="1510">Betting Systems</option>]
					preg_match_all ( "{<option value=\"(.*?)\">(.*?)</option>}", $cats, $matches, PREG_PATTERN_ORDER );
					$paretcats_ids = $matches [1];
					$paretcats_names = $matches [2];
					
					// delete current records
					if (count ( $paretcats_names ) > 0) {
						$query = "delete from {$this->wp_prefix}automatic_categories ";
						$this->db->query ( $query );
					}
					
					// adding parent categories
					$i = 0;
					foreach ( $paretcats_ids as $parentcat_id ) {
						
						$parentcat_name = $paretcats_names [$i];
						
						// inserting cats
						$query = "insert into {$this->wp_prefix}automatic_categories (cat_id , cat_name) values ('$parentcat_id','$parentcat_name')";
						$this->db->query ( $query );
						$i ++;
					}
					
					  echo '<br>Parent Categories added:' . $i;
					
					// extracting subcategories
					/*
					 * <option value="1265" parent="1253" path="Arts & Entertainment &raquo; Architecture"> Architecture </option>
					 */
					
					//   echo $exec;
					// exit;
					preg_match_all ( "{<option value=\"(.*?)\"  parent=\"(.*?)\"(.|\s)*?>((.|\s)*?)</option>}", $exec, $matches, PREG_PATTERN_ORDER );
					$subcats_ids = $matches [1];
					$subcats_parents = $matches [2];
					$subcats_names = $matches [4];
					
					$i = 0;
					foreach ( $subcats_ids as $subcats_id ) {
						$subcats_names [$i] = trim ( $subcats_names [$i] );
						$subcats_parents [$i] = trim ( $subcats_parents [$i] );
						$query = "insert into {$this->wp_prefix}automatic_categories(cat_id,cat_parent,cat_name) values('$subcats_id','$subcats_parents[$i]','$subcats_names[$i]')";
						$this->db->query ( $query );
						$i ++;
					}
					
					  echo '<br>Sub Categories added ' . $i;
					
					// print_r($matches);
					exit ();
					
					$res = $matches [2];
					$form = $res [0];
					
					preg_match_all ( "{<option value=\"(.*?)\"  parent=\"(.*?)\"}", $exec, $matches, PREG_PATTERN_ORDER );
					
					print_r ( $matches );
					
					// print_r($matches);
					exit ();
					$res = $matches [0];
					$cats = $res [0];
				}
			}
			
			/*
			 * ---* Proxy Frog Integration ---
			 */
			function alb_proxyfrog() {
				
				// get the current list
				$proxies = get_option ( 'alb_proxy_list' );
				
				// no proxies
				  echo '<br>Need new valid proxies';
				
				if (function_exists ( 'proxyfrogfunc' )) {
					  echo '<br>Getting New Proxy List from ProxyFrog.me';
					// Get
					$x = 'error';
					
					$ch = curl_init ();
					curl_setopt ( $ch, CURLOPT_HEADER, 0 );
					curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
					curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
					curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
					curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.bing.com/' );
					curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8' );
					curl_setopt ( $ch, CURLOPT_MAXREDIRS, 5 ); // Good leeway for redirections.
					curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 0 ); // Many login forms redirect at least once.
					curl_setopt ( $ch, CURLOPT_COOKIEJAR, "cookie.txt" );
					
					// Get
					// license
					$paypal = get_option ( 'pf_license' );
					$paypal = urlencode ( $paypal );
					$url = "http://proxyfrog.me/proxyfrog/api.php?email=$paypal";
					curl_setopt ( $ch, CURLOPT_HTTPGET, 1 );
					curl_setopt ( $ch, CURLOPT_URL, trim ( $url ) );
					$exec = curl_exec ( $ch );
					
					//   echo $exec;
					
					if (stristr ( $exec, ':' )) {
						update_option ( 'be_proxy_list', $exec );
						update_option ( 'alb_proxy_list', $exec );
						  echo '<br>New Proxy List <b>Added successfully</b> ';
						$this->log ( 'ProxyFrog', "New Proxy list added from ProxyFrog" );
						return true;
					} else {
						$this->log ( 'ProxyFrog', $exec );
					}
				} else {
					
					return false;
				}
			} // end fun
			
			/*
			 * ---* Logging Function ---
			 */
			function log($type, $data) {
				// $now= date("F j, Y, g:i a");
				$now = date ( 'Y-m-d H:i:s' );
				$data = @addslashes ( $data );
				
				 
				$query = "INSERT INTO {$this->wp_prefix}automatic_log (action,date,data) values('$type','$now','$data')";
				
				 
				
				// echome$query;
				$this->db->query ( $query );
				
				$insert = $this->db->insert_id;
				
				$insert_below_100 = $insert -100 ;
				
				if($insert_below_100 > 0){
					//delete
					$query="delete from {$this->wp_prefix}automatic_log where id < $insert_below_100 and action not like '%Posted%'" ;
					$this->db->query($query);
				}
				
			}
			
			/**
			 * Function that checks if the current link is already posted 
			 * @param unknown $link
			 */
			function is_duplicate($link_url){
				
				$duplicate=false;
				
				// link suffix
				if($this->isLinkSuffixed == true){
					if(stristr($link_url, '?')){
						$link_url = $link_url.'&rand='.$this->currentCampID ;
					}else{
						$link_url = $link_url.'?rand='.$this->currentCampID ;
					}
				}

				// Find items from the duplicate cache				
				if( ! $this->campOldDuplicateLinksFetched){
					$this->campOldDuplicateLinks = get_post_meta($this->currentCampID,'wp_automatic_duplicate_cache',1);
					
					//array it
					if(! is_array($this->campOldDuplicateLinks)) $this->campOldDuplicateLinks = array();
					
					$this->campOldDuplicateLinksFetched = true;
				}
				
				$possibleID = array_search($link_url,  $this->campOldDuplicateLinks ) ;
				
				if( $possibleID != false  ){
					 
					 $duplicate = true;
					 $this->duplicate_id = $possibleID;
				}
				
				// Find items with meta = this url
				if( ! $duplicate ){
					
					$query = "SELECT post_id from {$this->wp_prefix}postmeta where meta_key ='original_link' and meta_value='$link_url' ";
					$pres = $this->db->get_results ( $query );
					
					/*double check again
					if(count ( $pres ) == 0 ){
						$pres = $this->db->get_results ( $query );
					}
					*/
			
	
					if(count ( $pres ) == 0 ){
						$duplicate = false;
					}else{
						
						$duplicate = true;
			 
						foreach($pres as $prow){
							
							$ppid=$prow->post_id;
							$this->duplicate_id = $ppid;
							
							$pstatus = get_post_status($ppid);
								
							if($pstatus != 'trash') {
								break;
							}
						} 
						
					}
					
				}
				
				// Check if completely deleted
				if( ! $duplicate ){
				
					$md5 = md5($link_url);
					$query = "SELECT link_url from {$this->wp_prefix}automatic_links where link_url='$md5' ";
					$pres = $this->db->get_results ( $query );
					
					if ( count($pres) != 0){
						$duplicate = true;
						$this->duplicate_id = 'Deleted' ;
					}
					
				}
				
				// Update Duplicate cache 
				if($duplicate == true){
					
					// duplicated url, add it to the duplicate cache array
					if(is_numeric($this->duplicate_id)){
						$this->campNewDuplicateLinks[$this->duplicate_id] = $link_url;
						$this->campDuplicateLinksUpdate = true;
					}
					
				}
				
				return $duplicate;
			}
		
			/**
			 * Function link exclude to execlude links
			 * @param unknown $camp_id
			 * @param unknown $source_link
			 */
			function link_execlude($camp_id,$source_link){
				
				if($this->campExcludedLinksFetched == true){
					$execluded_links = $this->campExcludedLinks;
				}else{
						
					$execluded_links = get_post_meta($camp_id,'_execluded_links',1);
					$this->campExcludedLinks = $execluded_links;
					$this->campExcludedLinksFetched = true;
				}
				
				$newExecluded_links = $execluded_links.','.$source_link;
				update_post_meta($camp_id,'_execluded_links', $newExecluded_links );
				$this->campExcludedLinks = $newExecluded_links;
			
			
			}
			
			/**
			 * Check if link is execluded or not i.e it didn't contain exact match keys or contins blocked keys
			 * @param unknown $camp_id
			 * @param unknown $link
			 */
			function is_execluded($camp_id,$link){
				
				if($this->campExcludedLinksFetched == true){
					$execluded_links = $this->campExcludedLinks;
				}else{
					$execluded_links = get_post_meta($camp_id,'_execluded_links',1);
					$this->campExcludedLinks = $execluded_links;
					$this->campExcludedLinksFetched = true;
				}
		  
				if(stristr(','.$execluded_links, $link )){
					return true;
				}else{
					return false;
				}
				
			}
			
			/**
			 * function cache_image 
			 * return local image src if found 
			 * return false if not cached 
			 */
			function is_cached($remote_img,$data_md5){
				
				//md5
				$md5=md5($remote_img);
				
				//query database for this image 
				
				$query="SELECT * FROM {$this->db->prefix}automatic_cached where img_hash='$md5' and img_data_hash='$data_md5' limit 1";
				
				 
				$rows=$this->db->get_results($query);
				
				if(count($rows) == 0 ) return false;
				$row=$rows[0];
				
				//hm we have cached image with previous same source let's compare 
				$local_src = $row->img_internal;
				
				//make sure current image have same data md5 right now otherwise delete
				//curl get
				curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
				curl_setopt($this->ch, CURLOPT_URL, trim($local_src));
			 	$exec=curl_exec($this->ch);
			 	
			 	if(md5($exec) == $data_md5) {
			 		
			 		$this->cached_file_path = $row->img_path;
			 		
			 		return $local_src;
			 	}else{
			 		
			 		//now the local image no more giving the same md5 may be deleted or changed delete the record
			 		$query="delete from {$this->db->prefix}automatic_cached where img_hash = '$md5' ";
			 		$this->db->query($query);
			 		
			 		return false;
			 	}
			 	
			 	 
				 	  
			}
			
			/**
			 * 
			 * @param unknown $remote_img
			 * @param unknown $local_img
			 * @param number $thumb_id
			 */
			
			function img_cached($remote_img,$local_img,$image_data_md5,$file_path  ){
				
				$md5= md5($remote_img);
				$query="insert into {$this->db->prefix}automatic_cached(img_external,img_internal,img_hash,img_data_hash,img_path) values ('$remote_img','$local_img','$md5','$image_data_md5','$file_path')";
				$this->db->query($query);
				
				 
			}
			
			/**
			 * deactivate keyword : set the reactivation time to one comig hour
			 * @param integer $camp_id
			 * @param string $keyword
			 */
			function deactivate_key($camp_id,$keyword,$seconds= 3600){
			
				$deactivatedUntill = time('now') + $seconds ;
				
				if($seconds == 0) $deactivatedUntill = 0 ;
				
				update_post_meta($camp_id, '_'.md5($keyword), $deactivatedUntill );
			
			}
			
			/**
			 * is_deactivated: check if the current deactivated keyword is still deactivated or not 
			 * if yes it return false 
			 * if not deactivated return true
			 * @param integer $camp_id
			 * @param string $key
			 */
			function is_deactivated($camp_id,$keyword){
				
				//let's see if this keyword deactivated till date or not
				$keyword_key = '_'.md5($keyword) ;
				$deactivated_till = get_post_meta($camp_id,$keyword_key,1);
				if(trim($deactivated_till) == '') $deactivated_till = 1410020931;
				
				if($deactivated_till == 0){
					
					//still deactivated
					  echo '<br>Calling source for this keyword is <strong>deactivated</strong> permanently because last time we called the source for new items, There were no more results to get. You can still <a class="wp_automatic_key_reactivate" data-id="'.$camp_id.'" data-key="'. $keyword_key . '" href="#"><u>Reactivate Now.</u></a><span class="spinner_'.$keyword_key.'  spinner"></span>' ;
					return false;
				
				}if(time('now') > $deactivated_till ){
					//time passed let's reactivate
					  echo '<br>Keyword search reached end page lets sart from first page again ';
					return true;	
				}else{
						
					//still deactivated
					  echo '<br>Calling source for this keyword is <strong>deactivated</strong> temporarily because last time we called the source for new items, There were no more results to get. We will reactivate it after '. number_format((    $deactivated_till - time('now') )  /60 , 2 )   . ' minutes. You can still <a class="wp_automatic_key_reactivate" data-id="'.$camp_id.'" data-key="'. $keyword_key . '" href="#"><u>Reactivate Now.</u></a><span class="spinner_'.$keyword_key.'  spinner"></span>' ;
					return false;
				}
				
			}
			
			/**
			 * Function is_link_old check if the timestamp for the link is older than minimum
			 * @param unknown $camp_id
			 * @param unknown $link_timestamp
			 */
			function is_link_old($camp_id , $link_timestamp){
				
				if($this->debug == true)   echo '<br>is_link_old Minimum:'.$this->minimum_post_timestamp . ' Current:'.$link_timestamp;
				
				if($this->minimum_post_timestamp_camp == $camp_id ){
					if($link_timestamp < $this->minimum_post_timestamp){
						return true;
					}else{
						return false;
					}
				}
			}
			
			/**
			 * function is_title_duplicate
			 * @param unknown $title
			 */
			function is_title_duplicate($title,$post_type){
				
				/*
				  echo ' title is:'.$title;
				
				var_dump(get_page_by_title( $title, 'OBJECT', $post_type ));
				
				exit;*/
				
				if( get_page_by_title( $title, 'OBJECT', $post_type )  ){
					
					return true;
					
				}else{
					return false;
				}
			}
			
			function do_tag_exists(&$camp , $tags){
				
				$partToCheck = $camp->camp_post_custom_v.$camp->camp_post_content.$camp->camp_post_title;
				
				$partToCheck;
				
				foreach ($tags as $tag){
					
					if(stristr($partToCheck, $tag)){
						return true;
					}
					
				}
				
				return false;
				 
			}
			
			/*
			 * ---* validating ---
			 */
			function validate() {
				$paypal = get_option ( 'alb_license', '' );
				$active = get_option ( 'alb_license_active', '' );
				$link = 'http://wpplusone.com/trafficautomator/activate.php';
				
				// no license
				if (trim ( $paypal ) == '') {
					$this->log ( 'Error', 'License Required please visit settings and add the paypal email you used to purchase the product' );
					exit ();
				}
				
				// cehck validety
				if (trim ( $active ) != '1') {
					// first time activation
					// opening the page using curl
					$this->c->set ( CURLOPT_URL, trim ( "$link?email=$paypal" ) );
					$this->c->set ( CURLOPT_CONNECTTIMEOUT, 20 );
					$this->c->set ( CURLOPT_TIMEOUT, 50 );
					$this->c->set ( CURLOPT_HTTPGET, 1 );
					$ret = $this->c->execute ();
					$ret = trim ( $ret );
					// when no response
					if ($ret == '') {
						// service not available
						$this->log ( 'Error', 'Could not activate licence at this time may be our server is under maintenance now I will keep try and if the problem exists contact support' );
						exit ();
					} elseif ($ret == '0') {
						// not valid license
						$this->log ( 'Error', 'License is not valid please visit settings and use a valid license please, if you do\'t have a license consider to purchase <a href="http://wpsbox.com/buy">Here</a> and if you have just purchased just hold on our records will update after 10 minutes please be patient' );
						exit ();
					} elseif ($ret == '-1') {
						// Refunded
						$this->log ( 'Error', 'License is not valid a Refund may have been already issued for this license' );
						exit ();
					} elseif ($ret == '1') {
						// valid license
						update_option ( 'alb_license_active', '1' );
						// register last chek
						$date = date ( "m\-d\-y" );
						update_option ( 'alb_license_last', $date );
					} else {
						$this->log ( 'Error', 'License could not be validated at this time, our server may be under maintenance now will try the next cron' );
						exit ();
					}
				} else {
					// license is working without problem we should check again
					$date = date ( "m\-d\-y" );
					$last_check = get_option ( 'alb_license_last', $date );
					$offset = $this->dateDiff ( "-", $date, $last_check );
					if ($offset >= 1) {
						//   echo 'checking license again';
						// check again
						// opening the page using curl
						$this->c->set ( CURLOPT_URL, trim ( "$link?email=$paypal" ) );
						$this->c->set ( CURLOPT_CONNECTTIMEOUT, 20 );
						$this->c->set ( CURLOPT_TIMEOUT, 50 );
						$this->c->set ( CURLOPT_HTTPGET, 1 );
						$ret = $this->c->execute ();
						$ret = trim ( $ret );
						// when no response
						if ($ret == '0') {
							// not valid license
							$this->log ( 'Error', 'License is not valid please visit settings and use a valid license please, if you do\'t have a license consider to purchase <a href="http://wpsbox.com/buy">Here</a>' );
							update_option ( 'alb_license_active', '' );
							exit ();
						} elseif ($ret == '-1') {
							// Refunded
							$this->log ( 'Error', 'License is not valid a Refund may have been already issued for this license' );
							update_option ( 'alb_license_active', '' );
							exit ();
						} elseif ($ret == '1') {
							// valid license
							update_option ( 'alb_license_active', '1' );
							// register last chek
							$date = date ( "m\-d\-y" );
							update_option ( 'alb_license_last', $date );
						}
					}
				}
				
				return true;
			}
			
			/*
			 * ---* Date Difference return days between two dates ---
			 */
			function dateDiff($dformat, $endDate, $beginDate) {
				$date_parts1 = explode ( $dformat, $beginDate );
				$date_parts2 = explode ( $dformat, $endDate );
				$start_date = gregoriantojd ( $date_parts1 [0], $date_parts1 [1], $date_parts1 [2] );
				$end_date = gregoriantojd ( $date_parts2 [0], $date_parts2 [1], $date_parts2 [2] );
				return $end_date - $start_date;
			}
			
			/*
			 * ---* Download File ---
			 */
			function downloadfile($link) {
				$downloader = $this->plugin_url . 'downloader.php';
				// $downloader='http://localhost/php/wpsbox_aals/downloader.php';
				$link = str_replace ( 'http', 'httpz', $link );
				
				$enc = urlencode ( $link );
				// $return=file_get_contents($downloader.'?link='.$enc);
				//   echo $return ;
				
				if (stristr ( $return, 'error' )) {
					  echo '<br>An Error downloading the <b>damn file</b> :';
					  echo ' <i><small>' . $return . '</small></i>';
					
					return false;
				}
				return true;
			}
			
			/*
			 * ---* Solve captcha function ---
			 */
			function solvecap($url) {
				$decap_user = get_option ( 'alb_de_u' );
				$decap_pass = get_option ( 'alb_de_p' );
				
				// if decap not registered return false
				if (trim ( $decap_user ) == '' || trim ( $decap_pass ) == '') {
					  echo '<br>decaptcher.com <b>account needed</b>';
					$this->log ( 'Error', 'Capatcha Met at ' . $proxy . ' , Decapatcher Account needed please register one at decapatcher.com , add balance to it then enter login details at settings tab ' );
					return false;
				}
				
				// curl ini
				$ch = curl_init ();
				curl_setopt ( $ch, CURLOPT_HEADER, 0 );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
				curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
				curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.bing.com/' );
				curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8' );
				curl_setopt ( $ch, CURLOPT_MAXREDIRS, 5 ); // Good leeway for redirections.
				curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 ); // Many login forms redirect at least once.
				curl_setopt ( $ch, CURLOPT_COOKIEJAR, "cookie.txt" );
				curl_setopt ( $ch, CURLOPT_URL, trim ( $url ) );
				curl_setopt ( $ch, CURLOPT_HEADER, 0 );
				$img = curl_exec ( $ch );
				if (trim ( $img ) == '')
					return false;
				if (curl_error ( $ch ) != '') {
					  echo '<br>Image fetched with error:' . curl_error ( $ch ) . '<br>';
					return false;
				}
				
				// file_put_contents('files/cap.jpg',$img);
				
				// positng image to capatcher to get the decapatched version
				curl_setopt ( $ch, CURLOPT_VERBOSE, 0 );
				curl_setopt ( $ch, CURLOPT_URL, 'http://poster.decaptcher.com' );
				curl_setopt ( $ch, CURLOPT_POST, true );
				
				$decap_acc = '1169';
				
				$post = array (
						"pict" => "@files/cap.jpg",
						"function" => "picture2",
						"username" => $decap_user,
						"password" => $decap_pass,
						"pict_to" => "0",
						"pict_type" => $decap_acc 
				);
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				if (curl_error ( $ch ) != '') {
					  echo '<br>Captacha Posted with error:' . curl_error ( $ch ) . '<br>';
					return false;
				}
				
				$decap = curl_exec ( $ch );
				  echo '<br>Decap returned:' . $decap;
				// check if decapatcher returned an error -
				if (stristr ( $decap, '-' ) || trim ( $decap ) == '') {
					  echo '<br>Decapatcher returned an <b>error</b> ' . $decap;
					$this->log ( 'Error', 'Decapatcher Account Error Please check login details and suffecient balance' );
					return false;
				}
				
				if (trim ( $decap ) == '')
					return false;
				$decaps = explode ( '|', $decap );
				$decap = $decaps [5];
				if (trim ( $decap ) == '')
					return false;
				  echo '<br>Decap Solution:' . $decap;
				return $decap;
			}
			
			/*
			 * ---* Trackback function using wp modification ---
			 */
			function trackback($trackback_url, $author, $ttl, $excerpt, $link) {
				$options = array ();
				$options ['timeout'] = 4;
				$options ['body'] = array (
						'title' => $ttl,
						'url' => $link,
						'blog_name' => $author,
						'excerpt' => $excerpt 
				);
				
				$response = wp_remote_post ( $trackback_url, $options );
				
				if (is_wp_error ( $response )) {
					  echo '<br>Trackback Error';
					return;
				} else {
					  echo '<br>No Track back error';
				}
			}
			
			 
			/*
			 * function get_time_difference: get the time difference in minutes.
			* @start: time stamp
			* @end: time stamp
			*/
			
			function get_time_difference( $start, $end )
			{
			
				$uts['start']      =     $start ;
				$uts['end']        =      $end ;
			
			
			
				if( $uts['start']!==-1 && $uts['end']!==-1 )
				{
					if( $uts['end'] >= $uts['start'] )
					{
						$diff    =    $uts['end'] - $uts['start'];
			
						return round($diff/60,0);
			
					}
			
				}
			}
			
			function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
				if ($considerHtml) {
					// if the plain text is shorter than the maximum length, return the whole text
					if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
						return $text;
					}
					// splits all html-tags to scanable lines
					preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
					$total_length = strlen($ending);
					$open_tags = array();
					$truncate = '';
					foreach ($lines as $line_matchings) {
						// if there is any html-tag in this line, handle it and add it (uncounted) to the output
						if (!empty($line_matchings[1])) {
							// if it's an "empty element" with or without xhtml-conform closing slash
							if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
								// do nothing
								// if tag is a closing tag
							} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
								// delete tag from $open_tags list
								$pos = array_search($tag_matchings[1], $open_tags);
								if ($pos !== false) {
									unset($open_tags[$pos]);
								}
								// if tag is an opening tag
							} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
								// add tag to the beginning of $open_tags list
								array_unshift($open_tags, strtolower($tag_matchings[1]));
							}
							// add html-tag to $truncate'd text
							$truncate .= $line_matchings[1];
						}
						// calculate the length of the plain text part of the line; handle entities as one character
						$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
						if ($total_length+$content_length> $length) {
							// the number of characters which are left
							$left = $length - $total_length;
							$entities_length = 0;
							// search for html entities
							if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
								// calculate the real length of all entities in the legal range
								foreach ($entities[0] as $entity) {
									if ($entity[1]+1-$entities_length <= $left) {
										$left--;
										$entities_length += strlen($entity[0]);
									} else {
										// no more characters left
										break;
									}
								}
							}
							$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
							// maximum lenght is reached, so get off the loop
							break;
						} else {
							$truncate .= $line_matchings[2];
							$total_length += $content_length;
						}
						// if the maximum length is reached, get off the loop
						if($total_length>= $length) {
							break;
						}
					}
				} else {
					if (strlen($text) <= $length) {
						return $text;
					} else {
						$truncate = substr($text, 0, $length - strlen($ending));
					}
				}
				// if the words shouldn't be cut in the middle...
				if (!$exact) {
					// ...search the last occurance of a space...
					$spacepos = strrpos($truncate, ' ');
					if (isset($spacepos)) {
						// ...and cut the text in this position
						$truncate = substr($truncate, 0, $spacepos);
					}
				}
				// add the defined ending to the text
				$truncate .= $ending;
				if($considerHtml) {
					// close all unclosed html-tags
					foreach ($open_tags as $tag) {
						$truncate .= '</' . $tag . '>';
					}
				}
				return $truncate;
			}//end function
			
			
			/**
			 * function: curl with follocation that will get url if openbasedir is set or safe mode enabled
			 * @param unknown $ch
			 * @return mixed
			 */
			
			function curl_exec_follow( &$ch){
			
				$max_redir = 3;
			
				for ($i=0;$i<$max_redir;$i++){
			
					$exec=curl_exec($ch);
					$x=curl_error($ch);
					$info = curl_getinfo($ch);
					
					//meta refresh
					if(stristr($exec, 'http-equiv="refresh"') && $info['http_code'] == 200){
						
						//get the Redirect URL
						preg_match('{<meta.*?http-equiv="refresh".*?>}', $exec,$redirectMatch);
						if(isset($redirectMatch[0]) && trim($redirectMatch[0]) != '' ){
							
							preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $redirectMatch[0],$urlMatchs);
							
							if( isset($urlMatchs[0]) && stristr($urlMatchs[0], 'http') ){
								$info['http_code'] = 302;
								$info['redirect_url'] = $urlMatchs[0];
							}
							
						}
						
		
						
					}
					
					if($info['http_code'] == 301 ||  $info['http_code'] == 302){
						
						//if there is no reddirect_url
						if(trim($info['redirect_url']) == ''){
							$info['redirect_url']= curl_getinfo($ch, CURLINFO_REDIRECT_URL);
							
							//if php is below 5.3.7 and there is no redirect_url option
							if(trim($info['redirect_url']) == '' ){
								
									if(stristr($exec, 'Location:')){
										preg_match( '{Location:(.*)}' , $exec, $loc_matches);
										$redirect_url = trim($loc_matches[1]);
								
										if(trim($redirect_url) !=  ''){
											$info['redirect_url'] = $redirect_url;
										}
									}else{
										
										//$info['redirect_url'] = $info['url'];
										
									}
								 
								
							}
							
						}
						
						curl_setopt($ch, CURLOPT_HTTPGET, 1);
						curl_setopt($ch, CURLOPT_URL, trim($info['redirect_url']));
						
						$exec=curl_exec($ch);
							
					}else{
							
						//no redirect just return
						break;
							
					}
			
			
				}
			 
				return $exec;
			
			}
			
			/**
			 * function curl_file_exists: check existence of a file
			 * @param unknown $url
			 * @return boolean
			 */
			function curl_file_exists($url){
			
				//curl get
			
				$x='error';
				curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
				curl_setopt($this->ch, CURLOPT_URL, trim($url));
				curl_setopt($this->ch, CURLOPT_REFERER, $url);
				//curl_setopt($this->ch, CURLOPT_NOBODY, true);
			
				$exec=curl_exec($this->ch);
				$x=curl_error($this->ch);
			
				$httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
			 
				//curl_setopt($this->ch, CURLOPT_NOBODY, false);
			
			 	
				if($httpCode == '200' || $httpCode == '302') return true;
			
				return false;
			}
			
			//function to get user id and create it if not exists
			function get_user_id_by_display_name( $display_name ) {
				 
				//trim
				$display_name = trim($display_name);
				
				
				//check user existence 
				if ( ! $user = $this->db->get_row( $this->db->prepare(
						"SELECT `ID` FROM {$this->db->users} WHERE `display_name` = %s", $display_name
				) ) ){
					
					//replace spaces
					$login_name = str_replace(' ', '_', $display_name);
					
					
					//no user with this name let's create it and return the id
					$userdata['display_name'] = $display_name;
					$userdata['user_login'] = $display_name; 
					
					$user_id = wp_insert_user( $userdata );
					
					
					if( !is_wp_error($user_id) ) {
						  echo '<br>New user created:'.$login_name;
						return $user_id;
					}else {
						return false;
					}
					 
					return false;
					 
				}
					
			
				return $user->ID;
			}
			
			//remove emoji from instagram 
			 function removeEmoji($text) {
			
			 	if(function_exists('wp_staticize_emoji')){
			 		
			 		$text= wp_staticize_emoji($text);
			 		$text =  preg_replace ( '{<img src="https://s.w.org.*?>}s', '', $text);
			 		return $text;
			 		
			 	}else{
			 	
					$clean_text = "";
				
					// Match Emoticons
					$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
					$clean_text = preg_replace($regexEmoticons, '', $text);
				
					// Match Miscellaneous Symbols and Pictographs
					$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
					$clean_text = preg_replace($regexSymbols, '', $clean_text);
				
					// Match Transport And Map Symbols
					$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
					$clean_text = preg_replace($regexTransport, '', $clean_text);
				
					// Match Miscellaneous Symbols
					$regexMisc = '/[\x{2600}-\x{26FF}]/u';
					$clean_text = preg_replace($regexMisc, '', $clean_text);
				
					// Match Dingbats
					$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
					$clean_text = preg_replace($regexDingbats, '', $clean_text);
				
					return $clean_text;
				
			 	}
				
			}

			//function for hyperlinking
			function hyperlink_this($text){
				
				return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$0</a>', $text);
				
			}
			
			//function for stripping inline urls
			function strip_urls($content){
			
				return preg_replace('{http[s]?://[^\s]*}', '', $content);
			
			}
			
			//fix invalid uلtf chars
			function fix_utf8($string){

			 
				//check if wrong utf8
				if ( 1 === @preg_match( '/^./us', $string ) ) {
			
					return $string;
				}else{
					  echo '<br>Fixing invalid utf8 text...'  ;
					
					  if(function_exists('iconv')){
						  return iconv( 'utf-8', 'utf-8//IGNORE', $string );
					  }else{
					  	echo '<br>Iconv module is not installed, please install PHP iconv module';
					  	return $string;
					  }
			
				}
			
			}
			
			function cleanthetitle($title) {
				$title = str_replace('nospin', '', $title);
				$title = str_replace(' ', '-', $title); // Replaces all spaces with hyphens.
				$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title); // Removes special chars.
			
				return preg_replace('/-+/', '-', $title); // Replaces multiple hyphens with single one.
			}
			
			//is_enlish: checks if the text is english requires mb_string module
			function is_english ($string){
				
				if( !  function_exists('mb_strlen') ){
					
					  echo '<br>Will skip checking if english as mbstring module must be installed ';
					
					return true;
				}
				
				$string = str_replace(array('”','“','’','‘','’'),'',$string) ;
				
				
				if(strlen($string) != mb_strlen($string, 'utf-8'))
				{
					return false;
				}
				else {
					return true;
				}
				
				
			}
			
			function attach_image($image_url,$camp_opt,$post_id){
				
				// Upload dir
				$upload_dir = wp_upload_dir ();
					
				//img host
				$imghost = parse_url ( $image_url, PHP_URL_HOST );
				
				if(stristr($imghost, 'http://')){
					$imgrefer=$imghost;
				}else{
					$imgrefer = 'http://'.$imghost;
				}
				
				//empty referal
				if( ! in_array('OPT_CACHE_REFER_NULL', $camp_opt) ){
					curl_setopt ( $this->ch, CURLOPT_REFERER, $imgrefer );
				}else{
					curl_setopt ( $this->ch, CURLOPT_REFERER, '' );
				}
					
				if( stristr($image_url, 'base64,')  ){
				
					$filename = time('now');
				
				}else{
				
					//decode html entitiies
					$image_url = html_entity_decode($image_url);
				
					if(stristr($image_url, '%') ) {
						$image_url = urldecode($image_url);
					}
				
					//file name to store
					$filename = basename ( $image_url );
						
						
					if(stristr($image_url ,' ')){
						$image_url = str_replace(' ', '%20', $image_url);
					}
						
				}
					
				// Clean thumb
				if(in_array('OPT_THUMB_CLEAN' , $camp_opt   )){
						
					$clean_name = '';
					$clean_name =  sanitize_file_name($post_title);
					
					echo '<br>clean name'.$clean_name;
					
					if(trim($clean_name) != ""){
				
						//get the image extension \.\w{3}
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
						if(stristr($ext, '?')){
							$ext_parts = explode('?',$ext);
							$ext = $ext_parts[0];
						}
				
						//clean parameters after filename
						$filename = trim($clean_name);
				
						if( trim($ext) !='' ){
							$filename = $filename .'.'. $ext;
						}
				
					}
						
				}
				
				
						
					if(  stristr($image_url, 'base64,')  ){
						$ex = explode('base64,', $current_img);
						$image_data = base64_decode($ex[1]);
							
						//set fileName extention .png, .jpg etc
						preg_match('{data:image/(.*?);}', $image_url ,$ex_matches);
						$image_ext = $ex_matches[1];
							
						if(trim($image_ext) != ''){
							$filename = $filename .'.'.$image_ext;
						}
							
					}else{
							
				
						//get image content
						$x='error';
						curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
						curl_setopt($this->ch, CURLOPT_URL, trim( html_entity_decode($image_url) ) );
						$image_data=$this->curl_exec_follow($this->ch);
							
						$x=curl_error($this->ch);
							
							
					}
						
						
					if(trim($image_data) != ''){
							
						//check if already saved
				
						$image_data_md5 = md5($image_data);
							
						$is_cached = $this->is_cached($image_url , $image_data_md5);
						
						if( $is_cached != false ){
							  echo '<--already cached' ;
							$file = $this->cached_file_path;
							$guid = $is_cached;
						}else{
				
				
							if (stristr ( $filename, '?' )) {
								$farr = explode ( '?', $filename );
								$filename = $farr [0];
							}
				
							//pagepeeker fix
							if(stristr($image_url, 'pagepeeker') && ! in_array('OPT_THUMB_CLEAN' , $camp_opt )){
								$filename = md5($filename).'.jpg';
							}
				
							if (wp_mkdir_p ( $upload_dir ['path'] ))
								$file = $upload_dir ['path'] . '/' . $filename;
								else
									$file = $upload_dir ['basedir'] . '/' . $filename;
										
									// check if same image name already exists
									if (file_exists ( $file )) {
											
										//get the current saved one to check if identical
										$already_saved_image_link=$upload_dir ['url'] . '/' . $filename;
				
										//curl get
										$x='error';
										$url=$already_saved_image_link;
										curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
										curl_setopt($this->ch, CURLOPT_URL, trim($url));
				
										$exec=curl_exec($this->ch);
				
										if(trim($exec) == trim($image_data)){
											$idential = true;
											  echo '<br>Featured image already exists with same path.. using it';
										}else{
											  echo '<br>Featured image exists with same path but not identical.. saving  ';
				
											$filename = time ( 'now' ) . '_' . $filename;
				
										}
				
									}
				
				
									//saving image
									if(! isset($idential )){
										if (wp_mkdir_p ( $upload_dir ['path'] ))
											$file = $upload_dir ['path'] . '/' . $filename;
											else
												$file = $upload_dir ['basedir'] . '/' . $filename;
													
												$f=file_put_contents ( $file, $image_data );
				
													
									}
										
									$guid = $upload_dir['url'] . '/' . basename( $filename );
				
									$this->img_cached($image_url, $guid,$image_data_md5,$file);
										
						}//not cached
							
						//atttatchment check if exists or not
						global  $wpdb;
							
							
						$query = "select * from $wpdb->posts where guid = '$guid'";
						$already_saved_attachment = $wpdb->get_row($query);
				
						if(isset($already_saved_attachment->ID)){
				
							$attach_id = $already_saved_attachment->ID;
				
						}else{
								
							$wp_filetype = wp_check_filetype ( $filename, null );
				
							if($wp_filetype['type'] == false){
								$wp_filetype['type'] = 'image/jpeg';
							}
				
							//Alt handling
							$imgTitle = sanitize_file_name ( $filename );
							if(in_array('OPT_THUMB_ALT',$camp_opt)){
								//$imgTitle = $title;
							}
				
							$attachment = array (
									'guid'           =>  $guid,
									'post_mime_type' => $wp_filetype ['type'],
									'post_title' => $imgTitle,
									'post_content' => '',
									'post_status' => 'inherit'
							);
				
							$attach_id = wp_insert_attachment ( $attachment, $file, $post_id );
							require_once (ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata ( $attach_id, $file );
							wp_update_attachment_metadata ( $attach_id, $attach_data );
				
						}
				
				 		
						if(is_numeric($attach_id) && $attach_id > 0 ){
							return $attach_id;
						}
						
							
					}else{
						  echo ' <-- can not get image content '.$x;
						return false;
					}
						
				 
				
			}
			
			/**
			* Count chars on text using mb_ module and if not exists it count it using strlen
			* @param unknown $text
			*/
			function chars_count(&$text){
			
				if(function_exists('mb_strlen')){
					return mb_strlen($text);
				}else{
					return strlen($text);
				}
			
			}
				
			 
			function randomUserAgent(){
				
				$agents = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36
Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8
Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36
Mozilla/5.0 (Windows NT 10.0; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0
Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36
Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko
Mozilla/5.0 (Windows NT 6.1; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0
Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:55.0) Gecko/20100101 Firefox/55.0
Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063
Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0
Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36";
				
$arrAgents = explode("\n", $agents);

$rand = rand(0,count($arrAgents) -1);

return trim($arrAgents[$rand]);
				
			}		
			/**
			 * Function to download file and return the url of it at the server
			 * @param String $url
			 * @parm String optional $ext ex .xml
			 * return path of the file or false
			 */		
			function download_file($url,$ext=''){
				
				//curl get
				$x='error';
					
				curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
				curl_setopt($this->ch, CURLOPT_URL, trim($url));
				$exec=curl_exec($this->ch);
				$x=curl_error($this->ch);
					
				if(trim($x) == '' && trim($exec) != ''){
					
					$upload_dir = wp_upload_dir ();
					$filePath = $upload_dir['basedir'] .'/wp_automatic_temp'.$ext;
					$fileUrl  = $upload_dir['baseurl'] .'/wp_automatic_temp'.$ext;
					file_put_contents($filePath, $exec);
					return $fileUrl;
							
				}
				
				return false;
			}		
			
			/**
			 * Fix src links 
			 * @param string $content to be fixed content
			 * @param string $url
			 * @return string fixed content
			 */
			function fix_relative_paths($content,$url){
				
				 
				
				//fix images
				$pars=parse_url($url);
				$host = $pars['host'];
				
				/*preg_match_all('{<img.*?src[\s]*=[\s]*["|\'](.*?)["|\'].*?>}is', $res['cont'] , $matches); */
				
				preg_match_all('{(?:href|src)[\s]*=[\s]*["|\'](.*?)["|\'].*?>}is', $content , $matches);
				$img_srcs =  ($matches[1]);
				
				foreach ($img_srcs as $img_src){
					
					$original_src = $img_src;
					
					// ../ remove
					if(stristr($img_src, '../')){
						$img_src = str_replace('../', '', $img_src);
					}
					
					if(stristr($img_src, 'http:') || stristr($img_src, 'www.') || stristr($img_src, 'https:')  || stristr($img_src, 'data:image') ){
						//valid image
					}else{
						//not valid image i.e relative path starting with a / or not or //
						$img_src = trim($img_src);
						
						if(preg_match('{^//}', $img_src)){
							
							$img_src = 'http:'.$img_src;
							
						}elseif( preg_match('{^/}', $img_src) ){
							$img_src = 'http://'.$host.$img_src;
						}else{
							$img_src = 'http://'.$host.'/'.$img_src;
						}
						
						
						$reg_img = '{["|\'][\s]*'.preg_quote($original_src,'{').'[\s]*["|\']}s';
						
						$content = preg_replace( $reg_img, '"'.$img_src.'"', $content);
						
					}
					
				}
				 
				
				//Fix relative links
				$content = str_replace('href="../', 'href="http://'.$host.'/', $content);
				$content = preg_replace('{href="/(\w)}', 'href="http://'.$host.'/$1', $content);
				
				
				
				return $content;
				
			}
		
		} // End
		
?>
