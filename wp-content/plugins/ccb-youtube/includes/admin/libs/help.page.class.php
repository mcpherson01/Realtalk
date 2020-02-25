<?php

class CBC_Help_Page extends CBC_Page_Init implements CBC_Page{

	public function __construct( CBC_Video_Post_Type $object ){
		parent::__construct( $object );
		
		add_action( 'admin_head', array( 
				$this, 
				'register_meta_boxes' 
		) );
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		$themes = cbc_get_compatible_themes();
		$theme = cbc_check_theme_support();
		
		if( $theme ){
			$key = array_search( $theme, $themes );
			if( $key ){
				$themes[ $key ][ 'active' ] = true;
			}
		}
		
		$installed_themes = wp_get_themes( array( 
				'allowed' => true 
		) );
		foreach( $installed_themes as $t ){
			$name = strtolower( $t->Name );
			if( array_key_exists( $name, $themes ) && ! isset( $themes[ $name ][ 'active' ] ) ){
				$themes[ $name ][ 'installed' ] = true;
			}
		}
		
		if( ! class_exists( 'CBC_Shortcodes' ) ){
			include_once CBC_PATH . 'includes/libs/shortcodes.class.php';
		}
		$shortcodes_obj = new CBC_Shortcodes();
		
		// view
		include CBC_PATH . '/views/help.php';
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		wp_enqueue_style( 'cbc-admin-compat-style', CBC_URL . 'assets/back-end/css/help-page.css' );
	}

	public function register_meta_boxes(){
		add_meta_box( 'cbc-doc-links', __( 'Documentation', 'cbc_video' ), array( 
				$this, 
				'documentation_meta_box' 
		), 'cbc_help_screen', 'side' );
		
		add_meta_box( 'cbc-system', __( 'Environment info', 'cbc_video' ), array( 
				$this, 
				'environment_info' 
		), 'cbc_help_screen', 'side' );
	}

	public function environment_info(){
		?>
<ul>
	<li><?php _e('PHP version', 'cbc_video');?> : <strong><?php echo phpversion();?></strong></li>
	<li><?php _e('WordPress version', 'cbc_video');?> : <strong><?php echo get_bloginfo('version');?></strong></li>
	<li><?php _e('WP YouTube Hub version', 'cbc_video')?> : <strong><?php echo CBC_VERSION;?></strong></li>
</ul>
<hr />
<ul>
	<li><?php _e('WP Debug', 'cbc_video') ?> : <?php WP_DEBUG ? _e('On', 'cbc_video') : _e('Off', 'cbc_video');?></li>
	<li><?php _e('Remote requests', 'cbc_video')?> : <?php defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL ? _e( 'Blocked', 'cbc_video') : _e( 'Allowed', 'cbc_video'); ?></li>
<?php if( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL ):?>
	<li><?php _e( 'Accesible hosts', 'cbc_video' )?> : <?php echo  defined( 'WP_ACCESSIBLE_HOSTS' ) ? WP_ACCESSIBLE_HOSTS : __( 'Plugin unable to make API queries' , 'cbc_video');?></li>
<?php endif;?>
</ul>

<?php
	}

	public function documentation_meta_box(){
		$links = array( 
				array( 
						'text' => __( 'Video import options', 'cbc_video' ), 
						'url' => cbc_docs_link( 'plugin-settings/video-import-options/' ) 
				), 
				array( 
						'text' => __( 'Importing videos manually', 'cbc_video' ), 
						'url' => cbc_docs_link( 'content-importing/manual-video-bulk-import/' ) 
				), 
				array( 
						'text' => __( 'Automatic video import', 'cbc_video' ), 
						'url' => cbc_docs_link( 'content-importing/automatic-video-import/' ) 
				), 
				array( 
						'text' => __( 'Theme compatibility tutorial', 'cbc_video' ), 
						'url' => cbc_docs_link( 'third-party-compatibility/' ) 
				), 
				array( 
						'text' => __( 'AMP plugin compatibility', 'cbc_video' ), 
						'url' => cbc_docs_link( 'tutorials/amp-plugin-compatibility/' ) 
				), 
				array( 
						'text' => __( 'Store video stats in custom fields', 'cbc_video' ), 
						'url' => cbc_docs_link( 'tutorials/storing-video-statistics-custom-fields/' ) 
				), 
				array( 
						'text' => __( 'A detailed view on automatic importing', 'cbc_video' ), 
						'url' => cbc_docs_link( 'tutorials/automatic-import-explained/' ) 
				), 
				array( 
						'text' => __( 'Plugin actions', 'cbc_video' ), 
						'url' => cbc_docs_link( 'plugin-actions/' ) 
				), 
				array( 
						'text' => __( 'Plugin filters', 'cbc_video' ), 
						'url' => cbc_docs_link( 'plugin-filters/' ) 
				) 
		);
		
		?>
<h4><?php _e( 'Videos', 'cbc_video' );?></h4>
<ul>
	<li><a href="https://www.youtube.com/watch?v=kn9aOAe6O3I"
		target="_blank"><?php _e( 'Plugin initial configuration', 'cbc_video' );?></a></li>
</ul>

<h4><?php _e( 'Documentation', 'cbc_video' );?></h4>
<ul>
	<?php foreach($links as $link):?>
	<li>
		<?php if( isset( $link['before'] ) ){ echo $link['before']; }?>
		<a href="<?php echo $link['url']?>" target="_blank"><?php echo $link['text'];?></a>
	</li>
	<?php endforeach;?>
</ul>
<?php
	}
}