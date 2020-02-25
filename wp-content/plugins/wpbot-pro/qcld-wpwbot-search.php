<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Product indexing, caching & searching features concept is taken from open source 'Advanced wp Search' Wp plugin by ILLID.
 */
include_once( 'includes/class-wpwbot-table.php' );
include_once( 'includes/class-wpwbot-search.php' );


function qcld_wpbo_search_site() {
	global $wpdb;
	$keyword = sanitize_text_field($_POST['keyword']);

	if(class_exists('qc_wpsaas')){
		qc_wpsaas::search($keyword);
	}
	elseif(qcld_wpbot_is_active_post_type_search()){
		qcpd_wppt_search_fnc($keyword);
	}

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;

	$searchkeyword = qcld_wpbot_modified_keyword($keyword);

	//advance query building

	$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('page', 'post') and post_status='publish' and ((post_title REGEXP '[[:<:]]".$searchkeyword."[[:>:]]') or (post_content REGEXP '[[:<:]]".$searchkeyword."[[:>:]]')) order by ID DESC";


	$limit = " Limit 0, ".$searchlimit;

	$results = $wpdb->get_results($sql.$limit);


	$total_results = $wpdb->get_results($sql);

	$new_window = get_option('wpbot_search_result_new_window');

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found #result results for #keyword');

	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');
	
	
	$response = array();
	$response['status'] = 'fail';
	
	if ( !empty( $results ) ) {

		

		$response['status'] = 'success';
		$response['html'] = '<div class="wpb-search-result">';
		$response['html'] .= '<p>'.str_replace(array('#result', '#keyword'),array(esc_html(count($total_results)), esc_html($_POST['keyword'])),$msg).'</p>';
		foreach ( $results as $result ) {

			$featured_img_url = get_the_post_thumbnail_url($result->ID,$imagesize);


			$response['html'] .='<div class="wpbot_card_wraper">';
			$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url($result->guid).'" '.($new_window==1?'target="_blank"':'').'>';
			
			if($featured_img_url!=''){
				$response['html'] .=		'<img src="'.$featured_img_url.'" />';
			}

			$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
			$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
			$response['html'] .=		'</div>';
			$response['html'] .=	'</a></div>';
			$response['html'] .='</div>';			
		}
		$response['html'] .='</div>';
		if(count($total_results) > $searchlimit){
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-keyword="'.$keyword.'" data-page="2">Load More <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
	}else{
		$args = array(
					'post_type' => array( 'post', 'page' ),
					'posts_per_page' => $searchlimit,
					'post_status'   => 'publish',
					's' => $keyword,
				);
		$results = new WP_Query($args);
		if( $results->have_posts() ){
			$count = 0;
			$response['status'] = 'success';
			$response['html'] = '<div class="wpb-search-result">';
			$response['html'] .= '<p>'.str_replace(array('#result', '#keyword'),array(esc_html($results->found_posts), esc_html($_POST['keyword'])),$msg).'</p>';
			while( $results->have_posts() ){
				$results->the_post();
				$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),$imagesize);
				


				$response['html'] .='<div class="wpbot_card_wraper">';
				$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
				if($featured_img_url!=''){
					$response['html'] .=		'<img src="'.$featured_img_url.'" />';
				}
				$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
				$response['html'] .=			'<h2>'.get_the_title().'</h2>';
				$response['html'] .=		'</div>';
				$response['html'] .=	'</a></div>';
				$response['html'] .='</div>';			
			}
			$response['html'] .='</div>';
			if($results->found_posts > $searchlimit){
				$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-search-type="default-wp-search" data-keyword="'.$keyword.'" data-page="2">Load More <span class="wp-chatbot-loadmore-loader"></span></button>';
			}
			wp_reset_postdata();
		}else{
			$texts = unserialize(get_option('qlcd_wp_chatbot_no_result'));
			$response['html'] = $texts[array_rand($texts)];
		}
	}
	wp_reset_query();
	echo json_encode($response);

	die();
}

add_action( 'wp_ajax_wpbo_search_site',        'qcld_wpbo_search_site' );
add_action( 'wp_ajax_nopriv_wpbo_search_site', 'qcld_wpbo_search_site' );


function qcld_wpbo_search_site_pagination2() {
	global $wpdb;
	$keyword = sanitize_text_field($_POST['keyword']);
	$page = sanitize_text_field($_POST['page']);
	$page = ($page-1);
	if(qcld_wpbot_is_active_post_type_search()){
		qcpd_wppt_search_fnc($keyword);
	}

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;

	$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('page', 'post') and post_status='publish' and ((post_title REGEXP '[[:<:]]".$keyword."[[:>:]]') or (post_content REGEXP '[[:<:]]".$keyword."[[:>:]]')) order by ID DESC";


	$limit = " Limit ".($searchlimit*$page).", ".$searchlimit;

	
	$results = $wpdb->get_results($sql.$limit);


	$total_results = $wpdb->get_results($sql);

	$new_window = get_option('wpbot_search_result_new_window');
	

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found #result results for #keyword');
	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');

	$response = array();
	$response['status'] = 'fail';
	
	if ( !empty( $results ) ) {

		

		$response['status'] = 'success';
		$response['html'] = '<div class="wpb-search-result">';
		
		foreach ( $results as $result ) {
			$featured_img_url = get_the_post_thumbnail_url($result->ID,$imagesize);
			


			$response['html'] .='<div class="wpbot_card_wraper">';
			$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url($result->guid).'" '.($new_window==1?'target="_blank"':'').'>';
			if($featured_img_url!=''){
				$response['html'] .=		'<img src="'.$featured_img_url.'" />';
			}
			$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
			$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
			$response['html'] .=		'</div>';
			$response['html'] .=	'</a></div>';
			$response['html'] .='</div>';			
		}
		$response['html'] .='</div>';
		if(count($total_results) > ($searchlimit*($page + 1))){
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-keyword="'.$keyword.'" data-page="'.($page+1).'">Load More <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
	}else{
		$texts = unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['html'] = $texts[array_rand($texts)];
	}
	wp_reset_query();
	echo json_encode($response);

	die();
}

add_action( 'wp_ajax_wpbo_search_site_pagination2',        'qcld_wpbo_search_site_pagination2' );
add_action( 'wp_ajax_nopriv_wpbo_search_site_pagination2', 'qcld_wpbo_search_site_pagination2' );

function wpbo_default_search_pagination2(){
	$keyword = sanitize_text_field($_POST['keyword']);
	$page = sanitize_text_field($_POST['page']);

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;
	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found #result results for #keyword');
	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');
	$new_window = get_option('wpbot_search_result_new_window');

	$args = array(
				'post_type' => array( 'post', 'page' ),
				'posts_per_page' => $searchlimit,
				'post_status'   => 'publish',
				's' => $keyword,
				'paged' => $page
			);
	$results = new WP_Query($args);

	$response = array();
	$response['status'] = 'fail';

	if( $results->have_posts() ){
		$count = 0;
		$response['status'] = 'success';
		$response['html'] = '<div class="wpb-search-result">';
		$response['html'] .= '<p>'.str_replace(array('#result', '#keyword'),array(esc_html($results->found_posts), esc_html($_POST['keyword'])),$msg).'</p>';
		while( $results->have_posts() ){
			$results->the_post();
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),$imagesize);
			


			$response['html'] .='<div class="wpbot_card_wraper">';
			$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
			if($featured_img_url!=''){
				$response['html'] .=		'<img src="'.$featured_img_url.'" />';
			}
			$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
			$response['html'] .=			'<h2>'.get_the_title().'</h2>';
			$response['html'] .=		'</div>';
			$response['html'] .=	'</a></div>';
			$response['html'] .='</div>';			
		}
		$response['html'] .='</div>';
		if( $page < ($results->max_num_pages) ){
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-search-type="default-wp-search" data-keyword="'.$keyword.'" data-page="'.($page+1).'">Load More <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
		wp_reset_postdata();
	}else{
		$texts = unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['html'] = $texts[array_rand($texts)];
	}

	echo json_encode($response);

	die();
}
add_action( 'wp_ajax_wpbo_default_search_pagination2',        'wpbo_default_search_pagination2' );
add_action( 'wp_ajax_nopriv_wpbo_default_search_pagination2', 'wpbo_default_search_pagination2' );

function qcld_wb_chatbot_email_subscription() {
	
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_email($_POST['email']);
	$url = esc_url_raw($_POST['url']);
	$user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
	
	if(isset($_POST['phone']) && $_POST['phone']!=''){

		$phone = sanitize_text_field($_POST['phone']);
		if($email!=''){

			$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
			if(!empty($email_exists)){
				$wpdb->update(
					$table,
					array(
						'phone' => $phone,
					),
					array('email'=>$email),
					array(
						'%s',
					),
					array('%s')
				);
			}else{
				$wpdb->insert(
					$table,
					array(
						'date'  => current_time( 'mysql' ),
						'name'   => $name,
						'email'   => $email,
						'phone'   => $phone,
						'url'   => $url,
						'user_agent' => $user_agent
					)
				);
			}
		}else{
			$wpdb->insert(
				$table,
				array(
					'date'  => current_time( 'mysql' ),
					'name'   => $name,
					'email'   => $email,
					'phone'   => $phone,
					'url'   => $url,
					'user_agent' => $user_agent
				)
			);
		}
		$response['status'] = 'success';
		echo json_encode($response);
		die();
		
	}else{

		$response = array();
		$response['status'] = 'fail';
		
		$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
		if(empty($email_exists)){
		
			$wpdb->insert(
				$table,
				array(
					'date'  => current_time( 'mysql' ),
					'name'   => $name,
					'email'   => $email,
					'url'   => $url,
					'user_agent' => $user_agent
				)
			);
			$response['status'] = 'success';

			

		
		}else{
			$texts = unserialize(get_option('qlcd_wp_email_already_subscribe'));
			$response['msg'] = $texts[array_rand($texts)];
		}
		
		
		do_action( 'qcld_mailing_list_subscription_success', $name, $email );
		$texts = unserialize(get_option('qlcd_wp_email_subscription_success'));
		$response['msg'] = $texts[array_rand($texts)];

		if(get_option('qc_email_subscription_offer')==1){

			
			if(get_option('qlcd_wp_email_subscription_offer_subject')){
				$offertextss = unserialize(get_option('qlcd_wp_email_subscription_offer_subject'));
				$subject = str_replace('%%username%%', $name, $offertextss[array_rand($offertextss)]);
			}else{
				$subject = 'Email subscription offer';
			}

			
			//Extract Domain
			$url = get_site_url();
			$url = parse_url($url);
			$domain = $url['host'];
			$toEmail = $email;
			$fromEmail = "wordpress@" . $domain;
			$fromname = (get_option('qlcd_wp_chatbot_from_name')?get_option('qlcd_wp_chatbot_from_name'):'Wordpress');

			if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
				$fromEmail = get_option('qlcd_wp_chatbot_from_email');
			}

			$replyto = $fromEmail;

			if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
				$replyto = get_option('qlcd_wp_chatbot_reply_to_email');
			}

			//Starting messaging and status.
			$offertexts = unserialize(get_option('qlcd_wp_email_subscription_offer'));
			//build email body
			$bodyContent = "";
			$bodyContent .= '<p><strong>' . esc_html__('Offer Details', 'wpchatbot') . ':</strong></p><hr>';
			$bodyContent .= '<p>' . str_replace('%%username%%', $name, $offertexts[array_rand($offertexts)]) . '</p>';
			$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
			$to = $toEmail;
			$body = $bodyContent;
		
			$headers = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: '.$fromname.' <'.$fromEmail.'>';
			$headers[] = 'Reply-To: '.$fromname.' <'. ($replyto) .'>';
			wp_mail($to, $subject, $body, $headers);
			$response['email'] = 'Send! to '.$to.' from '.$fromEmail;

		}
		
		echo json_encode($response);

		die();
	}
}

add_action( 'wp_ajax_qcld_wb_chatbot_email_subscription',        'qcld_wb_chatbot_email_subscription' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_email_subscription', 'qcld_wb_chatbot_email_subscription' );

function qcld_wb_chatbot_email_unsubscription() {
	
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	$email = sanitize_email($_POST['email']);
	$response = array();
	$response['status'] = 'fail';
	$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
	if(empty($email_exists)){
		$response['status'] = 'fail';
	}else{
		do_action('qcld_mailing_list_unsubscription_by_user', $email);
		$wpdb->delete(
            $table,
            array( 'email' => $email ),
            array( '%s' )
		);
		$response['status'] = 'success';
	}
	echo json_encode($response);
	die();
}

add_action( 'wp_ajax_qcld_wb_chatbot_email_unsubscription',        'qcld_wb_chatbot_email_unsubscription' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_email_unsubscription', 'qcld_wb_chatbot_email_unsubscription' );

function qcld_wb_chatbot_send_query() {

	$name = trim(sanitize_text_field($_POST['name']));
	$email = sanitize_email($_POST['email']);
	$data = $_POST['data'];

    $subject = 'Query details from WPWBot by Client';
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');
    $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
	$fromEmail = "wordpress@" . $domain;
	
	if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
		$fromEmail = get_option('qlcd_wp_chatbot_from_email');
	}
	
	$replyto = $fromEmail;

	if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
		$replyto = get_option('qlcd_wp_chatbot_reply_to_email');
	}

    //Starting messaging and status.
    $response['status'] = 'fail';
    $response['message'] = esc_html(str_replace('\\', '',get_option('qlcd_wp_chatbot_email_fail')));

	//build email body
	$bodyContent = "";
	$bodyContent .= '<p><strong>' . esc_html__('Query Details', 'wpchatbot') . ':</strong></p><hr>';
	
	$bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html($email) . '</p>';
	foreach($data as $key=>$val){
		if(!is_array($val)){
			$bodyContent .= '<p>'.esc_html($key).': ' . esc_html($val) . '</p>';
		}else{
			foreach($val as $k=>$v){
				$bodyContent .= '<p>'.esc_html($k).': ' . esc_html($v) . '</p>';
			}
			
		}
		
	}
		
	$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
	$to = $toEmail;
	$body = $bodyContent;

	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
	$headers[] = 'Reply-To: '. esc_html($replyto) .'';

	$result = wp_mail($to, $subject, $body, $headers);
	if ($result) {
		$response['status'] = 'success';
		$response['message'] = esc_html(str_replace('\\', '',get_option('qlcd_wp_chatbot_email_sent')));
	}
    
    ob_clean();
    echo json_encode($response);
    die();

}

add_action( 'wp_ajax_qcld_wb_chatbot_send_query',        'qcld_wb_chatbot_send_query' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_send_query', 'qcld_wb_chatbot_send_query' );

function qcld_wpbd_download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}
function qcld_wpbd_array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }

   ob_start();

   $df = fopen("php://output", 'w');

   $titles = array('Name', 'Email');

   fputcsv($df, $titles);

   foreach ($array as $row) {
      fputcsv($df, $row);
   }

   fclose($df);

   return ob_get_clean();
}
add_action( 'admin_post_wpbprint.csv', 'qcld_wpb_export_email_csv' );
function qcld_wpb_export_email_csv(){
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	
    if ( ! current_user_can( 'manage_options' ) )
        return;

	$emails = $wpdb->get_results("select * from $table where 1");
	$childArray = array();
	foreach($emails as $email){
		$innerArray = array();
		$innerArray[0] = $email->name;
		$innerArray[1] = $email->email;
		array_push($childArray, $innerArray);
	}
	qcld_wpbd_download_send_headers("wpb_email_lists_" . date("Y-m-d") . ".csv");

	$result = qcld_wpbd_array2csv($childArray);

	print $result;
}

//site search for facebook.

function qcld_wpbo_search_site_fb($keyword) {
	
	$keyword = sanitize_text_field($keyword);

	$results = new WP_Query( array(
		'post_type'     => array( 'post', 'page' ),
		'post_status'   => 'publish',
		'posts_per_page'=> 10,
		's'             => stripslashes( $keyword ),
	) );

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found #result results for #keyword');
	

	$response = array();
	$response['status'] = 'fail';
	
	if ( !empty( $results->posts ) ) {

		$response['status'] = 'success';
		$response['results'] = array();
		foreach ( $results->posts as $result ) {
			$featured_img_url = get_the_post_thumbnail_url($result->ID,'thumbnail');
			if($featured_img_url==''){
				$featured_img_url = QCLD_wpCHATBOT_IMG_URL.'wp_placeholder.png';
			}
			$response['results'][] = array(
				'imgurl'=>qc_wpbot_url_validator($featured_img_url),
				'link'=>qc_wpbot_url_validator($result->guid),
				'title'=>$result->post_title
			);
		}
		
	}else{
		$texts = unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['message'] = $texts[array_rand($texts)];
	}
	wp_reset_query();
	return $response;

	die();
}

function qc_wpbot_url_validator($url){
	return $url;
}


function qc_wpbot_input_validation($data) {
	$data = html_entity_decode($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }

