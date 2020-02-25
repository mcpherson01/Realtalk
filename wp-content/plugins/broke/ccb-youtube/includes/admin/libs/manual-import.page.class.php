<?php

class CBC_Manual_Import_Page extends CBC_Page_Init implements CBC_Page{

	/**
	 * Holds reference to ajax class
	 * 
	 * @var CBC_AJAX_Actions
	 */
	private $ajax;

	/**
	 * Constructor, fires up parent and stores variables
	 * 
	 * @param CBC_Video_Post_Type $post_type
	 * @param CBC_AJAX_Actions $ajax
	 */
	public function __construct( CBC_Video_Post_Type $post_type, CBC_AJAX_Actions $ajax ){
		parent::__construct( $post_type );
		$this->ajax = $ajax;
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		?>
<div class="wrap">
	<div class="icon32 icon32-posts-video" id="icon-edit">
		<br>
	</div>
	<h2>
		<?php _e('Import videos', 'cbc_video')?>
		<?php if( isset( $this->list_table ) ):?>
		<a class="add-new-h2" id="cbc-new-search" href="#">New Search</a>
		<?php endif;?>
	</h2>
		<?php
		if( ! isset( $this->list_table ) ){
			require_once CBC_PATH . 'views/import_videos.php';
		}else{
			$this->list_table->prepare_items();
			// get ajax call details
			$data = $this->ajax->__get_action_data( 'manual_video_bulk_import' );
			?>
	<?php if( cbc_debug() ):?>
		<div class="updated">
		<p><?php do_action('cbc-manual-import-admin-message');?></p>
	</div>		
	<?php endif;?>
	
	<div id="search_box" class="hide-if-js">
		<?php include_once CBC_PATH . '/views/import_videos.php';?>
	</div>

	<form method="post" action="" class="ajax-submit">
		<?php wp_nonce_field( $data['nonce']['action'], $data['nonce']['name'] );?>
		<input type="hidden" name="action" class="cbc_ajax_action"
			value="<?php echo $data['action'];?>" /> <input type="hidden"
			name="cbc_source" value="youtube" />
		<?php
			// import as theme posts - compatibility layer for deTube WP theme
			if( isset( $_REQUEST[ 'cbc_theme_import' ] ) ):
				?>
		<input type="hidden" name="cbc_theme_import" value="1" />
		<?php endif;// end of condition for compatibility layer for themes?>
		
		<?php $this->list_table->display();?>
	</form>	
		<?php
		}
		?>
</div>
<?php
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		$this->video_import_assets();
		
		// search videos result
		if( isset( $_GET[ 'cbc_search_nonce' ] ) ){
			if( check_admin_referer( 'cbc-video-import', 'cbc_search_nonce' ) ){
				require_once CBC_PATH . '/includes/admin/libs/video-list.class.php';
				$this->list_table = new CBC_Video_List();
			}
		}
		
		// import videos / alternative to AJAX import
		if( isset( $_REQUEST[ 'cbc_import_nonce' ] ) ){
			if( check_admin_referer( 'cbc-import-videos-to-wp', 'cbc_import_nonce' ) ){
				if( 'import' == $_REQUEST[ 'action_top' ] || 'import' == $_REQUEST[ 'action2' ] ){
					$this->ajax->import_videos();
				}
				$options = cbc_get_settings();
				wp_redirect( 'edit.php?post_status=' . $options[ 'import_status' ] . '&post_type=' . $this->cpt->get_post_type() );
				die();
			}
		}
	}

	/**
	 * Enqueue scripts and styles needed on import page
	 */
	private function video_import_assets(){
		// video import form functionality
		wp_enqueue_script( 'cbc-video-search-js', CBC_URL . 'assets/back-end/js/video-import.js', array( 
				'jquery' 
		), '1.0' );
		wp_localize_script( 'cbc-video-search-js', 'cbc_importMessages', array( 
				'loading' => __( 'Importing, please wait...', 'cbc_video' ), 
				'wait' => __( "Not done yet, still importing. You'll have to wait a bit longer.", 'cbc_video' ), 
				'server_error' => __( 'There was an error while importing your videos. The process was not successfully completed. Please try again. <a href="#" id="cbc_import_error">See error</a>', 'cbc_video' ) 
		) );
		
		// change view details
		$view = $this->ajax->__get_action_data( 'import_view' );
		$data = array( 
				'action' => $view[ 'action' ] 
		);
		$data[ $view[ 'nonce' ][ 'name' ] ] = wp_create_nonce( $view[ 'nonce' ][ 'action' ] );
		wp_localize_script( 'cbc-video-search-js', 'cbc_view_data', $data );
		
		wp_enqueue_style( 'cbc-video-search-css', CBC_URL . 'assets/back-end/css/video-import.css', array(), '1.0' );
	}
}