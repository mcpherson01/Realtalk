<?php

class CBC_Settings_Page extends CBC_Page_Init implements CBC_Page{

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		$options = cbc_get_settings();
		$player_opt = cbc_get_player_settings();
		$envato_licence = get_option( '_cbc_yt_plugin_envato_licence', '' );
		$youtube_api_key = cbc_get_yt_api_key();
		$oauth_opt = cbc_get_yt_oauth_details();
		$form_action = html_entity_decode( menu_page_url( 'cbc_settings', false ) );
		
		// view
		include CBC_PATH . 'views/plugin_settings.php';
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		// set current page
		$this->cpt->__get_admin()->__set_current_page( $this );
		
		$redirect = false;
		$tab = false;
		
		if( isset( $_POST[ 'cbc_wp_nonce' ] ) ){
			check_admin_referer( 'cbc-save-plugin-settings', 'cbc_wp_nonce' );
			
			$this->update_settings();
			$this->update_player_settings();
			if( isset( $_POST[ 'envato_purchase_code' ] ) && ! empty( $_POST[ 'envato_purchase_code' ] ) ){
				update_option( '_cbc_yt_plugin_envato_licence', $_POST[ 'envato_purchase_code' ] );
			}
			if( isset( $_POST[ 'youtube_api_key' ] ) ){
				$this->update_api_key( $_POST[ 'youtube_api_key' ] );
			}
			if( isset( $_POST[ 'oauth_client_id' ] ) && isset( $_POST[ 'oauth_client_secret' ] ) ){
				cbc_update_yt_oauth( $_POST[ 'oauth_client_id' ], $_POST[ 'oauth_client_secret' ] );
			}
			
			$redirect = true;
		}
		
		if( isset( $_GET[ 'unset_token' ] ) && 'true' == $_GET[ 'unset_token' ] ){
			if( check_admin_referer( 'cbc-revoke-oauth-token', 'cbc_nonce' ) ){
				$tokens = cbc_get_yt_oauth_details();
				$endpoint = 'https://accounts.google.com/o/oauth2/revoke?token=' . $tokens[ 'token' ][ 'value' ];
				$response = wp_remote_post( $endpoint, array(
					'timeout' => 10
				) );
				cbc_update_yt_oauth( false, false, '', '' );
			}
			$redirect = true;
			$tab = '#cbc-settings-auth-options';
		}
		
		if( isset( $_GET[ 'clear_oauth' ] ) && 'true' == $_GET[ 'clear_oauth' ] ){
			if( check_admin_referer( 'cbc-clear-oauth-token', 'cbc_nonce' ) ){
				cbc_update_yt_oauth( '', '', '', '' );
			}
			$redirect = true;
			$tab = '#cbc-settings-auth-options';
		}
		
		if( $redirect ){
			wp_redirect( html_entity_decode( menu_page_url( 'cbc_settings', false ) ) . $tab );
			die();
		}
		
		$this->enqueue_assets();
	}

	/**
	 * Enqueue plugin assets
	 */
	private function enqueue_assets(){
		wp_enqueue_style( 'cbc-plugin-settings', CBC_URL . 'assets/back-end/css/plugin-settings.css', false );
		
		wp_enqueue_script( 'cbc-options-tabs', CBC_URL . 'assets/back-end/js/tabs.js', array( 
				'jquery', 
				'jquery-ui-tabs' 
		) );
		
		wp_enqueue_script( 'cbc-video-edit', CBC_URL . 'assets/back-end/js/video-edit.js', array( 
				'jquery' 
		), '1.0' );
	}

	/**
	 * Utility function, updates plugin settings
	 */
	private function update_settings(){
		/**
		 * Function returns an options object
		 * @var CBC_Plugin_Options
		 */
		$options = cbc_load_plugin_options();		
		$defaults = $options->get_defaults();
		
		foreach( $defaults as $key => $val ){
			if( is_numeric( $val ) ){
				if( isset( $_POST[ $key ] ) ){
					$defaults[ $key ] = ( int ) $_POST[ $key ];
				}
				continue;
			}
			if( is_bool( $val ) ){
				$defaults[ $key ] = isset( $_POST[ $key ] );
				continue;
			}
			
			if( isset( $_POST[ $key ] ) ){
				$defaults[ $key ] = $_POST[ $key ];
			}
		}
		
		// rewrite
		$plugin_settings = cbc_get_settings();
		$flush_rules = false;
		if( isset( $_POST[ 'post_slug' ] ) ){
			$post_slug = sanitize_title( $_POST[ 'post_slug' ] );
			if( ! empty( $_POST[ 'post_slug' ] ) && $plugin_settings[ 'post_slug' ] !== $post_slug ){
				$defaults[ 'post_slug' ] = $post_slug;
				$flush_rules = true;
			}else{
				$defaults[ 'post_slug' ] = $plugin_settings[ 'post_slug' ];
			}
		}
		if( isset( $_POST[ 'taxonomy_slug' ] ) ){
			$tax_slug = sanitize_title( $_POST[ 'taxonomy_slug' ] );
			if( ! empty( $_POST[ 'taxonomy_slug' ] ) && $plugin_settings[ 'taxonomy_slug' ] !== $tax_slug ){
				$defaults[ 'taxonomy_slug' ] = $tax_slug;
				$flush_rules = true;
			}else{
				$defaults[ 'taxonomy_slug' ] = $plugin_settings[ 'taxonomy_slug' ];
			}
		}
		
		$options->update_options( $defaults );
		
		// update automatic imports
		if( $plugin_settings[ 'import_frequency' ] != $defaults[ 'import_frequency' ] ){
			$this->cpt->__get_importer()->get_timer()->set_timer( ( $defaults[ 'import_frequency' ] * MINUTE_IN_SECONDS ) );
		}
		
		if( $flush_rules ){
			$this->cpt->register_post();
			// create rewrite ( soft )
			flush_rewrite_rules( false );
		}
	}

	/**
	 * Update general player settings
	 */
	private function update_player_settings(){
		$defaults = cbc_player_settings_defaults();
		foreach( $defaults as $key => $val ){
			if( is_numeric( $val ) ){
				if( isset( $_POST[ $key ] ) ){
					$defaults[ $key ] = ( int ) $_POST[ $key ];
				}else{
					$defaults[ $key ] = 0;
				}
				continue;
			}
			if( is_bool( $val ) ){
				$defaults[ $key ] = isset( $_POST[ $key ] );
				continue;
			}
			
			if( isset( $_POST[ $key ] ) ){
				$defaults[ $key ] = $_POST[ $key ];
			}
		}
		
		update_option( '_cbc_player_settings', $defaults );
	}

	/**
	 * Update YouTube API key
	 * 
	 * @param string $key
	 */
	private function update_api_key( $key ){
		/**
		 * Filter that allows denial of server key update.
		 * 
		 * @var boolean
		 */
		$allow = apply_filters( 'cbc_allow_youtube_server_key_update', true );
		if( ! $allow ){
			return;
		}
		
		if( empty( $key ) ){
			$key = false;
		}
		$api_key = array( 
				'key' => trim( $key ), 
				'valid' => true 
		);
		update_option( '_cbc_yt_api_key', $api_key );
	}
}