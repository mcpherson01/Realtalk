<?php

class CBC_Video_List_Page extends CBC_Page_Init implements CBC_Page{

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		_wp_admin_html_begin();
		printf( '<title>%s</title>', __( 'Video list', 'cbc_video' ) );
		wp_enqueue_style( 'colors' );
		wp_enqueue_style( 'ie' );
		wp_enqueue_script( 'utils' );
		wp_enqueue_style( 'buttons' );
		
		wp_enqueue_style( 'cbc-video-list-modal', CBC_URL . 'assets/back-end/css/video-list-modal.css', false, '1.0' );
		
		wp_enqueue_script( 'cbc-video-list-modal', CBC_URL . 'assets/back-end/js/video-list-modal.js', array( 
				'jquery' 
		), '1.0' );
		
		do_action( 'admin_print_styles' );
		do_action( 'admin_print_scripts' );
		do_action( 'cbc_video_list_modal_print_scripts' );
		echo '</head>';
		echo '<body class="wp-core-ui">';
		
		require CBC_PATH . 'includes/admin/libs/video-list-table.class.php';
		$table = new CBC_Video_List_Table( $this->cpt );
		$table->prepare_items();
		
		$post_type = $this->cpt->get_post_type();
		if( isset( $_GET[ 'pt' ] ) && 'post' == $_GET[ 'pt' ] ){
			$post_type = 'post';
		}
		
		?>
<div class="wrap">
	<form method="get" action="" id="cbc-video-list-form">
		<input type="hidden" name="pt" value="<?php echo $post_type;?>" /> <input
			type="hidden" name="page" value="<?php echo $_REQUEST['page'];?>" />
				<?php $table->views();?>
				<?php $table->search_box( __('Search', 'cbc_video'), 'video' );?>
				<?php $table->display();?>
			</form>
	<div id="cbc-shortcode-atts"></div>
</div>
<?php
		
		echo '</body>';
		echo '</html>';
		die();
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		$_GET[ 'noheader' ] = 'true';
		if( ! defined( 'IFRAME_REQUEST' ) ){
			define( 'IFRAME_REQUEST', true );
		}
		
		if( isset( $_GET[ '_wp_http_referer' ] ) ){
			wp_redirect( remove_query_arg( array( 
					'_wp_http_referer', 
					'_wpnonce', 
					'volume', 
					'width', 
					'aspect_ratio', 
					'autoplay', 
					'controls', 
					'cbc_video', 
					'filter_videos' 
			), stripslashes( $_SERVER[ 'REQUEST_URI' ] ) ) );
		}
	}
}