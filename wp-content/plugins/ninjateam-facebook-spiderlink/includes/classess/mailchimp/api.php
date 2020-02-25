<?php
	/**
	* 
	*/
	class  NJT_SPIDERLINK_API_MAIL_CHIMP
	{
		protected $client;
		protected $connected;
		function __construct($api_key=false)
		{
			$key = get_option('njt_spiderlink_mail_chimp_api_key');
			$this->client= new NJT_SPIDERLINK_API_MAIL_CHIMP_CLIENT($key);
		}
		public function get_Client(){
			return $this->client;
		}
		public function is_connected(){
				if(is_null($this->connected)){
					$data = $this->client->get( '/' );
					$this->connected = is_object($data) && isset($data->account_id);
					//print_r($data->account_id);
				}
			return $this->connected;
		}
		public function get_lists($args=array()){
			$resource = '/lists';
			$data = $this->client->get($resource,$args);
			//print_r($data->lists);
			if(is_object($data)&&(isset($data->lists))){
				//echo 'dsdsđ';
				return $data->lists;
			}
			return array();
		}
		public function UserSub($id,$args){
			$resource  ='/lists/'.$id;
			$request= $this->client->post($resource,$args);
			return $request;
		}
		public function getMergeFields($id){
			$resource  ='/lists/'.$id.'/merge-fields';
				$request= $this->client->get($resource);
				$mf = $request->merge_fields;
				$cache =array();
				foreach ($mf as $key => $value) {
					$cache[]=$value->tag;
				}
				update_option('njt_mail_chimp_mergefilds_id_'.$id,$cache);
			return $mf;
		}
		public function lists_cache($fo=false){
			$list = get_option('njt_spiderlink_mailchimp_list');
			if($fo){
				if($list!=false){
					return json_decode($this->fetch_lists());
				}
				return json_decode($list);
			}
			else{
				return json_decode($this->fetch_lists());
			}
		}
		//  
		public function fetch_lists(){
			$lists_cache = array();
			$lists = $this->get_lists();
			if(!is_null($lists)){
				$dem =0;
				foreach ($lists as $key => $value) {
					$lists_cache[$dem]['id']	=$value->id;
					$lists_cache[$dem]['web_id']	=$value->web_id;
					$lists_cache[$dem]['name']	=$value->name;
					$lists_cache[$dem]['member_count']	=$value->stats->member_count;
					$dem++;
				}
			}
			update_option('njt_spiderlink_mailchimp_list',json_encode($lists_cache));
			return json_encode($lists_cache);
		}
	}
?>