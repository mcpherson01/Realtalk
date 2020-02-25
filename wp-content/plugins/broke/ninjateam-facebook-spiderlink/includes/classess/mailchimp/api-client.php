<?php 
	/**
	* 
	*/
	class NJT_SPIDERLINK_API_MAIL_CHIMP_CLIENT 
	{
		private $api_key;
		private $api_url='https://api.mailchimp.com/3.0/';
		private $last_response ;
		function __construct($api_key)
		{
			$this->api_key=$api_key;
			$dash_position = strpos( $api_key, '-' );
       		 if( $dash_position !== false ) {
           		 $this->api_url = str_replace( '//api.', '//' . substr( $api_key, $dash_position + 1 ) . ".api.", $this->api_url );
       		 }
		}
		public function get($resource,array $args = array()){
			return $this->request('GET',$resource,$args);
		}
		public function post($resource,$data){
			return $this->request('POST',$resource,$data);
		}
		function  get_heders(){
			global  $wp_version;
			$headers = array();
        	$headers['Authorization'] = 'Basic ' . base64_encode( 'njtmc:' . $this->api_key );
            $headers['Accept'] = 'application/json';
            $headers['Content-Type'] = 'application/json';
            $headers['User-Agent'] ='njtmc/1.0; WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' );
        	// Copy Accept-Language from browser headers
        	if( ! empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
            	$headers['Accept-Language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
       		}
        	return $headers;
		}
		public function request($method, $resource,  array $data = array() ){
		 		$this->reset();
			if(empty($this->api_key)){
				return 'Missing API key';
			}
			$url = $this->api_url . ltrim( $resource, '/' );
			$args = array(
				'method' => $method,
				'timeout' => 45,
				'headers' => $this->get_heders(),
				'sslverify' => false
			);
			if($method=='GET'){
				 $url = add_query_arg( $data, $url );
			}else{
           	 $args['body'] = json_encode( $data );
        	}
        	//echo $url;
        	//print_r($args);
        	$response = wp_remote_request( $url, $args );
        	$this->last_response =$response;
        	$data = $this->parse_response( $response );
        	return $data;
		}
		private function reset(){
			$this->last_response=null;
		}
		private function parse_response($response){
			if($response instanceof WP_Error){
				throw new NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING($response->get_error_message(),(int)wp_remote_retrieve_response_code( $response ));
			}
			$code  = (int)wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			$body = wp_remote_retrieve_body($response);
			if($body < 300 && empty($body) ){
			$body = "true"	;
			}
			$data = json_decode($body);
			if($code>=400){
				if($code===400){
					throw new NjJ_SPIDERLINK_MAIL_CHIMP_EX_RESOURCE_NOT_FOUND($message,$code,$response,$data);
				}
				throw new NjJ_SPIDERLINK_MAIL_CHIMP_EX($message,$code,$response,$data);
			}
			if(!is_null($data)){
				return $data;
			}
			throw new NjJ_SPIDERLINK_MAIL_CHIMP_EX($message,$code,$response);
		}
		public function get_response(){
			return $this->last_response;
		}
		public function get_response_body(){
			return wp_remote_retrieve_body($this->last_response);
		}
		public function get_response_headers(){
			return wp_remote_retrieve_headers($this->last_response);
		}
	}
?>