<?php
/**
 * Load WP_List_Table class
 */
if( ! class_exists( 'WP_List_Table' ) ){
	require_once ( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class CBC_Playlists_List_Table extends WP_List_Table{

	private $playlist;

	/**
	 * Store main class instance
	 * 
	 * @var CBC_YouTube_Videos
	 */
	private $obj;

	/**
	 * Constructor
	 * 
	 * @param CBC_YouTube_Videos $main - reference to main plugin class
	 */
	function __construct( CBC_YouTube_Videos $main ){
		$this->obj = $main;
		// store playlist ID by accessing the autoimport queue object
		$this->playlist = $main->__get_importer()->get_queue()->get_next_autoimport();
		// start parent
		parent::__construct( array( 
				'singular' => 'playlist', 
				'plural' => 'playlists', 
				'screen' => null 
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

	/**
	 * Checkbox column
	 * 
	 * @param array $item
	 */
	function column_cb( $item ){
		return sprintf( '<input type="checkbox" name="%1$s" value="%2$s" id="%3$s" class="cbc-video-checkboxes">', 'cbc_playlist[]', $item[ 'ID' ], 'cbc-playlist-' . $item[ 'ID' ] );
	}

	function column_post_title( $item ){
		$page_args = array( 
				'post_type' => $this->obj->get_post_type(), 
				'page' => 'cbc_auto_import', 
				'action' => 'edit', 
				'id' => $item[ 'ID' ] 
		);
		$edit_url = add_query_arg( $page_args, 'edit.php' );
		
		$page_args[ 'action' ] = 'delete';
		$delete_url = add_query_arg( $page_args, 'edit.php' );
		
		$page_args[ 'action' ] = 'reset';
		$reset_url = add_query_arg( $page_args, 'edit.php' );
		
		$page_args[ 'action' ] = 'queue';
		$queue_url = add_query_arg( $page_args, 'edit.php' );
		$queue_text = 'draft' == $item[ 'post_status' ] ? __( 'Start', 'cbc_video' ) : __( 'Pause', 'cbc_video' );
		
		// row actions
		$actions = array( 
				'edit' => sprintf( '<a href="%s">%s</a>', $edit_url, __( 'Edit', 'cbc_video' ) ), 
				'delete' => sprintf( '<a href="%s">%s</a>', wp_nonce_url( $delete_url ), __( 'Delete', 'cbc_video' ) ), 
				'reset' => sprintf( '<a href="%s">%s</a>', wp_nonce_url( $reset_url ), __( 'Reset', 'cbc_video' ) ), 
				'queue' => sprintf( '<a href="%s">%s</a>', wp_nonce_url( $queue_url ), $queue_text ) 
		);
		
		$prefix = '';
		if( $item[ 'ID' ] == $this->playlist ){
			$prefix = '<i class="dashicons dashicons-update"></i> ';
		}
		
		$text = 'draft' == $item[ 'post_status' ] ? '<em>' . $item[ 'post_title' ] . '</em>' : '<strong>' . $prefix . $item[ 'post_title' ] . '</strong>';
		
		return sprintf( '%1$s %2$s', sprintf( '<a href="%s" title="">%s</a>', $edit_url, $text ), $this->row_actions( $actions ) );
	}

	function column_playlist_type( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		switch( $meta[ 'type' ] ){
			case 'user':
				return __( 'User uploads', 'cbc_video' );
			break;
			case 'playlist':
				return __( 'Video playlist', 'cbc_video' );
			break;
			case 'channel':
				return __( 'Video channel', 'cbc_video' );
			break;
		}
	}

	function column_playlist_id( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		return $meta[ 'id' ];
	}

	function column_videos_imported( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		return number_format_i18n( $meta[ 'imported' ] );
	}

	function column_total_videos( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		return number_format_i18n( $meta[ 'total' ] );
	}

	function column_not_older( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		$result = empty( $meta[ 'start_date' ] ) ? '<em style="color:#999;">' . __( 'not set', 'cbc_video' ) . '</em>' : $meta[ 'start_date' ];
		return $result;
	}

	function column_last_query( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		if( ! $meta[ 'updated' ] ){
			return __( 'never', 'cbc_video' );
		}
		
		return $meta[ 'updated' ];
	}

	function column_status( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		if( 'draft' == $item[ 'post_status' ] ){
			$message = '<span style="color:red; font-style:italic;">' . __( 'Not in queue', 'cbc_video' ) . '</span>';
			if( isset( $meta[ 'error' ] ) && ! empty( $meta[ 'error' ] ) ){
				$message .= '<br /><strong>' . __( 'Error: ', 'cbc_video' ) . '</strong><em>' . $meta[ 'error' ] . '</em>';
			}
			
			return $message;
		}
		
		$plugin_options = cbc_get_settings();
		
		$import_type_message = '';
		$is_theme_import = false;
		
		if( $meta[ 'theme_import' ] ){
			$theme = cbc_check_theme_support();
			if( $theme ){
				$import_type_message = '<span>' . sprintf( __( 'Import as posts compatible with <strong>%s</strong>.', 'cbc_video' ), $theme[ 'theme_name' ] ) . '</span>';
				$is_theme_import = true;
			}else{
				$import_type_message = __( 'Theme not active. Videos will be imported as plugin custom posts.', 'cbc_video' );
			}
		}else{
			$import_type_message = '<span>' . __( 'Import as custom post.' ) . '</span>';
		}
		
		if( isset( $meta[ 'error' ] ) ){
			$import_type_message .= '<br /><strong>Error: </strong><em>' . $meta[ 'error' ] . '</em>';
		}
		
		return $import_type_message;
	}

	function column_import_category( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		
		if( ! isset( $meta[ 'theme_import' ] ) || ! $meta[ 'theme_import' ] ){
			if( isset( $meta[ 'native_tax' ] ) && $meta[ 'native_tax' ] ){
				
				$options = cbc_get_settings();
				$taxonomy = isset( $options[ 'post_type_post' ] ) && $options[ 'post_type_post' ] ? 'category' : $this->obj->get_post_tax();
				$term = get_term( $meta[ 'native_tax' ], $taxonomy );
				if( $term && ! is_wp_error( $term ) ){
					return '<em>' . $term->name . '</em>';
				}else{
					return '-';
				}
			}else{
				return __( 'Create from feed', 'cbc_video' );
			}
		}else{
			if( isset( $meta[ 'theme_tax' ] ) && $meta[ 'theme_tax' ] ){
				$theme = cbc_check_theme_support();
				if( ! $theme ){
					return '-';
				}
				
				$term = get_term( $meta[ 'theme_tax' ], ( ! $theme[ 'taxonomy' ] ? 'category' : $theme[ 'taxonomy' ] ) );
				if( $term && ! is_wp_error( $term ) ){
					return $term->name;
				}else{
					return '-';
				}
			}else{
				return __( 'Create from feed', 'cbc_video' );
			}
		}
	}

	/**
	 * Visible when CBC_DEBUG is true
	 * 
	 * @param array $item
	 */
	function column_debug( $item ){
		$meta_key = $this->obj->get_playlist_meta_name();
		$meta = get_post_meta( $item[ 'ID' ], $meta_key, true );
		?>
<ul>
		<?php foreach($meta as $key=>$val):?>
			<li><strong><?php echo $key;?> : </strong><?php echo $val;?></li>
		<?php endforeach;?>
		</ul>
<?php
	}

	
	function column_repeat( $item ){
		$feed_obj = new CBC_Autoimport_Feed( $this->obj );
		$feed_obj->set_post( $item[ 'ID' ] );
		printf( _n( 'Repeat %s time (%s left)', 'Repeat %s times (%s left)', $feed_obj->get( 'repeat' ), 'cbc_video' ), number_format_i18n( $feed_obj->get( 'repeat' ) ), number_format_i18n( $feed_obj->get( 'repeats_left' ) ) );
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_columns()
	 */
	function get_columns(){
		$columns = array( 
				'cb' => '<input type="checkbox" />', 
				'post_title' => __( 'Title', 'cbc_video' ), 
				'playlist_type' => __( 'Playlist type', 'cbc_video' ), 
				'import_category' => __( 'Import in category', 'cbc_video' ), 
				'not_older' => __( 'Newer than', 'cbc_video' ), 
				'playlist_id' => __( 'Playlist ID', 'cbc_video' ), 
				'repeat' => __( 'Repeat import', 'cbc_video' ), 
				'videos_imported' => __( 'Imported', 'cbc_video' ), 
				'total_videos' => __( 'Total videos', 'cbc_video' ), 
				'last_query' => __( 'Queried on', 'cbc_video' ), 
				'status' => __( 'Status', 'cbc_video' )
		);
		
		if( cbc_debug() ){
			$columns[ 'debug' ] = __( 'Meta', 'cbc_video' );
		}
		
		return $columns;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_bulk_actions()
	 */
	function get_bulk_actions(){
		$actions = array( 
				'delete' => __( 'Delete', 'cbc_video' ), 
				'stop-import' => __( 'Remove from import queue', 'cbc_video' ), 
				'start-import' => __( 'Add to import queue', 'cbc_video' ) 
		);
		return $actions;
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see WP_List_Table::get_views()
	 */
	function get_views(){
		$url = menu_page_url( 'cbc_auto_import', false ) . '&view=%s';
		$lt = '<a href="' . $url . '" title="%s" class="%s">%s<span class="count"> (%d)</span></a>';
		
		$totals = wp_count_posts( $this->obj->get_playlist_post_type() );
		$all = $totals->publish + $totals->draft;
		
		$this->active = $totals->publish;
		
		$views = array( 
				'all' => sprintf( $lt, 'all', __( 'All automatic importers', 'cbc_video' ), ( ! isset( $_GET[ 'view' ] ) || 'all' == $_GET[ 'view' ] ? 'current' : '' ), __( 'All', 'cbc_video' ), $all ), 
				'active' => sprintf( $lt, 'active', __( 'Active automatic importers', 'cbc_video' ), ( isset( $_GET[ 'view' ] ) && 'active' == $_GET[ 'view' ] ? 'current' : '' ), __( 'Active', 'cbc_video' ), $totals->publish ), 
				'inactive' => sprintf( $lt, 'inactive', __( 'Inactive automatic importers', 'cbc_video' ), ( isset( $_GET[ 'view' ] ) && 'inactive' == $_GET[ 'view' ] ? 'current' : '' ), __( 'Inactive', 'cbc_video' ), $totals->draft ) 
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
		
		$status = array( 
				'publish', 
				'draft' 
		);
		if( isset( $_GET[ 'view' ] ) ){
			switch( $_GET[ 'view' ] ){
				case 'active': // active playlists
					$status = 'publish';
				break;
				case 'inactive': // inactive playlists
					$status = 'draft';
				break;
			}
		}
		
		$args = array( 
				'post_type' => $this->obj->get_playlist_post_type(), 
				'orderby' => 'ID', 
				'order' => 'ASC', 
				'posts_per_page' => $per_page, 
				'offset' => ( $current_page - 1 ) * $per_page, 
				'post_status' => $status 
		);
		
		$query = new WP_Query( $args );
		$data = array();
		if( $query->posts ){
			foreach( $query->posts as $k => $item ){
				$data[ $k ] = ( array ) $item;
			}
		}
		
		$total_items = $query->found_posts;
		$this->items = $data;
		
		$this->set_pagination_args( array( 
				'total_items' => $total_items, 
				'per_page' => $per_page, 
				'total_pages' => ceil( $total_items / $per_page ) 
		) );
	}
}