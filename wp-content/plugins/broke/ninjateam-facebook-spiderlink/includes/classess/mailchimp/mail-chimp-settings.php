<?php



	class NJT_MAIL_CHIMP_OPTIONS extends njt_core_notify_pluign {

		
		private $api_key_mail_chimp;
		public function __construct(){
			$this->api_key_mail_chimp=get_option('njt_spiderlink_mail_chimp_api_key');
		}
		public function add_options_page( $args=array(), $options = array() ){
			$this->options = $options;
			$this->slug = "mail-chimp-settings"		;
			$this->textdomain ="njt-app-like-comment-fb";
			$defaults = array(

				'parent'     => 'ninja-team-menu-spiderlink',
				'menu_title' => 'Mail Chimp Settings',
				'page_title' => 'Mail Chimp Settings',
				'capability' => 'manage_options',
				'link'       => true

			);


			$this->settings = wp_parse_args( $args, $defaults );
			$this->admin_url = admin_url( 'admin.php?page=' . $this->slug );
			add_action('admin_menu',array(&$this,'options_page'));

		

		}

		

		function  options_page() {
			$hook =	add_submenu_page(

				$this->settings['parent'], __( $this->settings['page_title'], $this->textdomain ), __( $this->settings['menu_title'], $this->textdomain ), $this->settings['capability'], $this->slug, array(

					&$this,

					'Render_page'

				)

				);

		

			}




		public function render_panes(){


			$connected = get_option('njt_spiderlink_mail_chimp_api_key');
			if(!empty($connected)){
				
				try{

					
					$connected = $this->get_api()->is_connected();
					
				}catch( NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING $e){
					
					$connected = false;

				}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX $e ){
					
					$connected = false;
				}


			}




			foreach ( $this->options as $option ) {

				
				$option_file = NJT_APP_LIKE_COMMENT_URL . '/includes/views/' . $option['type'] . '.php';
				if ( file_exists( $option_file ) ) {

					include $option_file;


				} else {
					trigger_error( 'Option file <strong>' . $option_file . '</strong> not found!', E_USER_NOTICE );
				}
			}


		}

		public function get_api(){

			$api = new NJT_SPIDERLINK_API_MAIL_CHIMP($this->api_key_mail_chimp);
			return  $api;

		}

		public function Render_page(){

			
			include_once(NJT_APP_LIKE_COMMENT_URL.'/includes/views/mail-chimp-settings.php');

			if(!empty($this->api_key_mail_chimp)){

				try{
					$list = $this->get_api()->lists_cache(true);
				}catch( NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING $e){
					
					///$connected = false;

				}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX $e ){
					
					//$connected = false;
				}
				


				 
				include_once(NJT_FI_PLUGIN_PATH.'/includes/views/mailchimp/list-mail-chimp-account.php');


			}
			

		}




	}

	

?>