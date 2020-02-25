<?php
/*
 * Load WP_List_Table class
 */
if( ! class_exists( 'WP_List_Table' ) ){
	require_once ( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class CBC_Channels_List_Table extends WP_List_Table{

	private $error;

	public function __construct( $args = array() ){
		parent::__construct( array( 
				'singular' => 'playlist', 
				'plural' => 'playlists', 
				'screen' => isset( $args[ 'screen' ] ) ? $args[ 'screen' ] : null 
		) );
	}

	/**
	 * Default column
	 * 
	 * @param array $item
	 * @param string $column
	 */
	function column_default( $item, $column ){
		return $item[ $column ];
	}

	public function column_item_title( $item ){
		$view = $this->_get_view();
		$id = 'playlists' == $view ? $item[ 'playlist_id' ] : $item[ 'channel_id' ];
		
		$manual_bulk_url = add_query_arg( array( 
				'cbc_source' => 'youtube', 
				'cbc_feed' => 'playlists' == $view ? 'playlist' : 'channel', 
				'cbc_query' => $id 
		), html_entity_decode( menu_page_url( 'cbc_import', false ) ) );
		$manual_bulk_url = wp_nonce_url( $manual_bulk_url, 'cbc-video-import', 'cbc_search_nonce' );
		
		$automatic_bulk_url = add_query_arg( array( 
				'feed_type' => 'playlists' == $view ? 'playlist' : 'channel', 
				'list_id' => $id, 
				'title' => urlencode( $item[ 'title' ] ), 
				'action' => 'add_new' 
		), html_entity_decode( menu_page_url( 'cbc_auto_import', false ) ) );
		
		$actions = array( 
				'manual_bulk' => sprintf( '<a href="%s">%s</a>', $manual_bulk_url, __( 'Manual import', 'cbc_video' ) ), 
				'automatic_bulk' => sprintf( '<a href="%s">%s</a>', $automatic_bulk_url, __( 'Create automatic import', 'cbc_video' ) ) 
		);
		
		$fragment = 'playlists' == $view ? 'playlist?list=' : 'channel/';
		$url = 'https://www.youtube.com/' . $fragment . $id;
		
		return sprintf( '%1$s %2$s', sprintf( '<a href="%s" title="%s" target="_blank">%s</a>', $url, __( 'Open on YouTube.com', 'cbc_video' ), $item[ 'title' ] ), $this->row_actions( $actions ) );
	}

	public function column_item_id( $item ){
		$view = $this->_get_view();
		if( 'playlists' == $view ){
			return $item[ 'playlist_id' ];
		}
		return $item[ 'channel_id' ];
	}

	public function column_total_videos( $item ){
		return $item[ 'videos' ];
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::no_items()
	 */
	public function no_items(){
		if( is_wp_error( $this->error ) ){
			echo $this->error->get_error_message();
			if( 'cbc_invalid_yt_grant' == $this->error->get_error_code() ){
				echo '<br>';
				cbc_show_oauth_link();
			}
			if( 'cbc_oauth_no_credentials' == $this->error->get_error_code() ){
				printf( '<p><a href="%s" class="button button-primary">%s</a></p>', menu_page_url( 'cbc_settings', false ) . '#cbc-settings-auth-options', __( 'Go to plugin settings', 'cbc_video' ) );
			}
		}else{
			_e( 'Nothing found.', 'cbc_video' );
		}
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_columns()
	 */
	function get_columns(){
		$columns = array( 
				'item_title' => __( 'Title', 'cbc_video' ), 
				'item_id' => __( 'ID', 'cbc_video' ), 
				'total_videos' => __( 'Videos', 'cbc_video' ) 
		);
		return $columns;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_bulk_actions()
	 */
	function get_bulk_actions(){
		$actions = array();
		return $actions;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_views()
	 */
	function get_views(){
		$url = menu_page_url( 'cbc_my_youtube', false ) . '&view=%s';
		$lt = '<a href="' . $url . '" title="%s" class="%s">%s</a>';
		
		$views = array( 
				'playlists' => sprintf( $lt, 'playlists', __( 'Playlists', 'cbc_video' ), ( ! isset( $_GET[ 'view' ] ) || 'playlists' == $_GET[ 'view' ] ? 'current' : '' ), __( 'Playlists', 'cbc_video' ) ), 
				'channels' => sprintf( $lt, 'channels', __( 'Channels', 'cbc_video' ), ( isset( $_GET[ 'view' ] ) && 'channels' == $_GET[ 'view' ] ? 'current' : '' ), __( 'Channels', 'cbc_video' ) ), 
				'subscriptions' => sprintf( $lt, 'subscriptions', __( 'Subscriptions', 'cbc_video' ), ( isset( $_GET[ 'view' ] ) && 'subscriptions' == $_GET[ 'view' ] ? 'current' : '' ), __( 'Subscriptions', 'cbc_video' ) ) 
		);
		
		return $views;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::prepare_items()
	 */
	function prepare_items(){
		$per_page = 20;
		$current_page = $this->get_pagenum();
		
		$query = array( 
				'items' => array(), 
				'page_info' => array( 
						'total_results' => 0 
				) 
		);
		
		$page_token = false;
		if( isset( $_GET['c_page'] ) ){
			$page_token = $current_page > $_GET['c_page'] ? $_GET['token_next'] : $_GET['token_prev'];
		}
		
		switch( $this->_get_view() ){
			case 'channels':
				$query = cbc_yt_api_get_user_channels( $page_token, $per_page );
			break;
			case 'subscriptions':
				$query = cbc_yt_api_get_user_subscriptions( $page_token, $per_page );
			break;
			case 'playlists':
			default:
				$query = cbc_yt_api_get_user_playlists( $page_token, $per_page );
			break;
		}
		
		if( is_wp_error( $query[ 'items' ] ) ){
			$this->error = $query[ 'items' ];
			$query[ 'items' ] = array();
		}
		
		if( isset( $query[ 'page_info' ] ) ){
			$_SERVER[ 'REQUEST_URI' ] = add_query_arg( array( 
					'token_next' => $query[ 'page_info' ][ 'next_page' ], 
					'token_prev' => $query[ 'page_info' ][ 'prev_page' ],
					'c_page' => $current_page
			), $_SERVER[ 'REQUEST_URI' ] );
		}
		
		$this->items = $query[ 'items' ];
		
		$this->set_pagination_args( array( 
				'total_items' => $query[ 'page_info' ][ 'total_results' ], 
				'per_page' => $per_page, 
				'total_pages' => ceil( $query[ 'page_info' ][ 'total_results' ] / $per_page ) 
		) );
	}

	/**
	 * Returns current active view
	 */
	private function _get_view(){
		$view = isset( $_GET[ 'view' ] ) ? $_GET[ 'view' ] : '';
		$views = array( 
				'channels', 
				'subscriptions', 
				'playlists' 
		);
		if( in_array( $view, $views ) ){
			return $view;
		}else{
			return 'playlists';
		}
	}
}