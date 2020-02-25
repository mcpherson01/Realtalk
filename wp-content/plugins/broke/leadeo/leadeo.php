<?php

/*
Plugin Name: Leadeo ( - Themepa.com)
Plugin URI: http://leadeo.shindiristudio.com/
Description: Plugin for contact and opt-in forms.
Version: 1.5.1
Author: ShindiriStudio
Author URI: http://www.shindiristudio.com/
*/

// define ('LEADEO_LITE', 1);

/**
 * @property leadeo_model $model
 * @property leadeo_view $view
 * @property leadeo_backend_view $backend_view
 * @property leadeo_fonts $fonts
 */


class leadeo_main {
	public $base_plugin_file, $plugin_code_name, $plugin_name, $plugin_version, $activation_sql, $url, $model, $view, $backend_view, $fonts, $mailchimp, $admin_url, $mode, $path, $fonts_fields, $sort_by_sub_field;

	function __construct() {

		$this->base_plugin_file=__FILE__;
		$this->plugin_code_name=basename(dirname(__FILE__));
		$this->plugin_name='Leadeo';
		$this->plugin_version='1.5.1';
		$this->url = $this->get_plugins_url()."/".$this->plugin_code_name."/";
		$this->path = dirname( __FILE__ );	// without backslash
		$this->model=null;
		$this->view=null;
		$this->mailchimp=null;

		if( $this->is_admin() ) {
			$this->mode='backend';
			$this->basic_backend_init();
			if (strpos($_SERVER['QUERY_STRING'], 'leadeo')!==FALSE || defined('leadeo_DEMO') || defined('DOING_AJAX')) {
				$this->admin_url=$this->get_admin_url();
				$this->backend_init();
			}
		} else {
			$this->mode='frontend';
			$this->frontend_init();
		}

	}

	function basic_backend_init() {
		add_filter( 'plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
		register_activation_hook( $this->base_plugin_file, array(&$this, 'install_plugin') );
		add_action('admin_menu', array(&$this, 'on_event_init_menu'));

		add_action( 'wp_ajax_leadeo_save', array(&$this, 'ajax_save') );
		add_action( 'wp_ajax_leadeo_preview', array(&$this, 'ajax_get_leadeo_iframe_source') );
		add_action( 'wp_ajax_leadeo_get_form', array(&$this, 'ajax_get_form') );

		add_action( 'wp_ajax_get_leadeo_iframe_source', array(&$this, 'ajax_get_leadeo_iframe_source') );
		add_action( 'wp_ajax_nopriv_get_leadeo_iframe_source', array(&$this, 'ajax_get_leadeo_iframe_source') );

		add_action( 'wp_ajax_leadeo_submit', array(&$this, 'ajax_submit') );
		add_action( 'wp_ajax_nopriv_leadeo_submit', array(&$this, 'ajax_submit') );

		add_action( 'wp_ajax_leadeo_get_mailchimp_lists', array(&$this, 'ajax_get_mailchimp_lists') );
	}

	function backend_init() {
		add_filter('admin_footer_text', array(&$this, 'dashboard_footer'));	// Add plugin name to footer
		add_action( 'admin_enqueue_scripts', array(&$this, 'load_admin_scripts') );
		//$this->add_hook('wp_'.$id, $arr);
		if (defined('DOING_AJAX')) $this->init_fonts();
	}


	function frontend_js_and_css() {
/*
		wp_enqueue_style($this->plugin_code_name.'-css', $this->url . 'css/leadeo_player.css');
		wp_enqueue_script('jquery');
*/
		wp_enqueue_script($this->plugin_code_name.'-js', $this->url . 'js/frontend.js', array('jquery'), '1.0', true);
	}

	function backend_js_and_css() {
		if (strpos($_SERVER['QUERY_STRING'], $this->plugin_code_name)!==FALSE) {
			wp_enqueue_style($this->plugin_code_name.'-admin-css', $this->url . 'css/admin.css');
			wp_enqueue_style($this->plugin_code_name.'-tooltip-css', $this->url . 'css/smoothness/jquery-ui-1.9.2.custom.min.css');
			wp_enqueue_script('jquery');
			wp_enqueue_script('iris');
			wp_enqueue_script("jquery-touch-pounch");
			wp_enqueue_script("jquery-ui-core");
			wp_enqueue_script("jquery-ui-widget");
			wp_enqueue_script("jquery-ui-dialog");
			wp_enqueue_script("jquery-ui-tooltip");
			wp_enqueue_script($this->plugin_code_name.'-functions-js', $this->url . 'js/functions.js');
			wp_enqueue_script($this->plugin_code_name.'-admin-edit-js', $this->url . 'js/admin_edit.js');
			wp_enqueue_script($this->plugin_code_name.'-form-js', $this->url . 'js/form.js');

			$LEADEO_LITE=0;
			if (defined('LEADEO_LITE') && LEADEO_LITE==1) $LEADEO_LITE=1;
			$data=array(
				'preview_url' => $this->get_preview_url(),
				'LEADEO_LITE' => $LEADEO_LITE
			);
			wp_register_script($this->plugin_code_name.'-backend-js', $this->url . 'js/backend.js' );
			wp_localize_script($this->plugin_code_name.'-backend-js', 'leadeo_data', $data);
			wp_enqueue_script($this->plugin_code_name.'-backend-js');
		}
	}

	function frontend_init() {
		//---add_action('wp_head', array(&$this, 'inline_header'));
		//---add_action('wp', array(&$this, 'frontend_includes'));
		//add_action( 'wp_enqueue_scripts', array(&$this, 'frontend_enqueue_scripts') ); // for js and css
		add_shortcode('leadeo', array(&$this, 'shortcode') );
	}

	// -----------------------------------------

	function admin_page() {
		$show_index=1;
		$this->init_model();
		if (isset($_GET['action'])) {
			if ($_GET['action']==='delete') {
				$id=intval($_GET['id']);
				$this->model->delete($id);
			}
			if ($_GET['action']==='list_submitted_data') {
				if (isset($_GET['del'])) {
					$del=intval($_GET['del']);
					$this->model->delete_submitted_data($del);
				}
				$leadeo_id=intval($_GET['id']);
				$this->model->load($leadeo_id);
				$name=$this->model->get('name');
				$data=$this->model->list_submitted_data($leadeo_id);
				//echo '<pre>'; print_r($data); echo '</pre>'; exit;
				include('backend_browse.php');
				$show_index=0;
			}
		}

		if ($show_index) {
			$items = $this->model->list_items();
			include('backend_index.php');
		}
	}

	function admin_page_edit() {
		$mode='new';
		if (isset($_GET['id'])) $mode='edit';
		$this->init_model($mode);
		if (isset($_GET['id'])) $this->model->load(intval($_GET['id']));
		$this->init_fonts();
		$this->fonts->init_google_fonts();
		$this->set_fonts();
		$this->fonts_fields=$this->fonts->get_font_listboxes();
		$this->init_backend_view();
		include('backend_edit.php');
	}

	function ajax_get_form() {
		$this->init_model();
		if (!isset($_POST['id'])) exit;
		if (!isset($_POST['type'])) exit;
		$id=intval($_POST['id']);
		$type=intval($_POST['type']);
		$this->init_model('new');
		$this->init_backend_view();
		$r=$this->backend_view->generate_form ($id, $type);
		if ($r) $this->ajax_return(1, array('content'=>$r));
		else $this->ajax_return(0, 'error');
	}

	function ajax_save(){
		$this->init_model();
		$id=0;
        $arr=$this->strip_separator();
		$temp=false;
        if (isset($_POST['leadeo_preview'])) $temp=true;
        if (isset($arr['leadeo_id'])) {$id=intval($arr['leadeo_id']); unset($arr['leadeo_id']);}
		$arr2=$arr;
		$arr=array();
		foreach ($arr2 as $var=>$val) {
			if (substr($var,0,11)=='leadeo_base') $var=substr($var,7);
			$arr[$var]=$val;
		}
        $r=$this->model->save($id, $arr, $temp);
		if ($r) $this->ajax_return(1, array('id'=>$r, 'mode'=>$this->model->last_save_mode));
        else $this->ajax_return(0, 'error');
	}

	/**
	 * 	 Submited data from frontend forms goes here
	 */
	function ajax_submit() {
		unset($_POST['action']);
		$this->init_model();

		if (!isset($_POST['id'])) exit;
		$id=intval($_POST['id']);
		unset($_POST['id']);

		if (!isset($_POST['form_id'])) exit;
		$form_id=intval($_POST['form_id']);
		//unset($_POST['form_id']);

		$is_preview=intval($_POST['is_preview']);
		unset($_POST['is_preview']);

		$this->init_model('view');
		$this->model->load($id, $is_preview);

		$arr=array();
		if (!$is_preview) $arr=$this->model->submit($id, $_POST);

		$form_type=intval($this->model->get('form_type', $form_id));

		if ($form_type==2) {
			$mailchimp_api = $this->model->get('mailchimp_api', $form_id);
			if ($mailchimp_api != '') {
				$this->init_mailchimp();
				$email=$_POST['email'];
				$this->mailchimp_subscribe($email, $form_id);
			}
		}

		if ($form_type==1) {
			$form_name=$this->model->get('name');
			$from_name=get_bloginfo('name');
			$from_email=get_bloginfo('admin_email');

			$to=$this->model->get('recipients_email');
			$subject=$form_name;
			$body='';
			foreach ($arr as $field=>$value) $body.=$field.": ".$value."\n";
			$headers='From: "'.$from_name.'" <'.$from_email.'>';
			wp_mail($to, $subject, $body, $headers);
			//echo $to.", ".$subject.", ".$body.", ".$headers;
		}

		//$data=print_r($_POST, true);
		//$this->ajax_return(1, array('data'=>$data));
	}

	function ajax_get_mailchimp_lists() {
		$this->init_mailchimp();
		if (!isset($_POST['apikey'])) return;
		if (!isset($_POST['leadeo_id'])) return;
		if (!isset($_POST['form_id'])) return;
		$apikey=$_POST['apikey'];
		$leadeo_id=intval($_POST['leadeo_id']);
		$form_id=intval($_POST['form_id']);
		$this->init_model('load');
		if ($leadeo_id>0) $this->model->load($leadeo_id);

		$mailchimp = new leadeo_mailchimp($apikey);
		$lists = $mailchimp->list_lists();
		echo $this->generate_mailchimp_list($form_id, $lists);
		exit;
	}

	// -----------------------------------------

	function init_model($for='new') {
		if ($this->model!==null) return;
		include('model.php');
		$this->model = new leadeo_model($this, $for);
	}

	function init_mailchimp() {
		include_once('mailchimp_wrapper.php');
	}

	function init_fonts() {
		if ($this->fonts!==null) return;
		include('fonts.php');
		$this->fonts = new leadeo_fonts($this, $this->model);
	}

	function set_fonts() {
		$arr=array(
			'font' => $this->model->get('font_name'),
			'variant' => $this->model->get('font_variant'),
			'subset' => $this->model->get('font_subset'),
			'size' => $this->model->get('font_size')
			//'color' => $this->model->get('font_color')
		);
		$this->fonts->set_selection($arr);
	}

	function init_view() {
		if ($this->view!==null) return;
		$this->init_model('load');
		include('view.php');
		$this->view = new leadeo_view($this, $this->model);
	}
	function init_backend_view() {
		if ($this->backend_view!==null) return;
		include('backend_view.php');
		$this->backend_view = new leadeo_backend_view($this, $this->model);
	}

    function ajax_return ($status, $data) {
        $arr['status']=$status;
        if (!is_array($data)) $arr['data']=$data;
        else {
            foreach ($data as $var=>$val) $arr[$var]=$val;
        }
        echo json_encode($arr);
        die();
    }

	function create_tables($execute_sql=0) {
		$temp_table_name = $this->get_plugin_table_name().'_temp';
		if ($this->db_get_var("SHOW TABLES LIKE '".$temp_table_name."'") != $temp_table_name) {
			$sql = "CREATE TABLE " . $temp_table_name ." (
						`id` int(4) NOT NULL AUTO_INCREMENT,
						name TINYTEXT NOT NULL COLLATE utf8_general_ci,
						settings TEXT NOT NULL COLLATE utf8_general_ci,
						PRIMARY KEY (`id`)
					);";
			$this->db_query($sql);
			$sql="INSERT INTO ".$temp_table_name." (id, name, settings) VALUES (1, 'temp', '')";
			$this->db_query($sql);
		}

		$data_table_name = $this->get_plugin_table_name().'_data';
		if ($this->db_get_var("SHOW TABLES LIKE '".$data_table_name."'") != $data_table_name) {
			$sql = "CREATE TABLE " . $data_table_name ." (
						`id` int(4) NOT NULL AUTO_INCREMENT,
						leadeo_id int(4) NOT NULL,
						data TEXT NOT NULL COLLATE utf8_general_ci,
						time int(4) NOT NULL,
						PRIMARY KEY (`id`), INDEX(`leadeo_id`)
					);";
			$this->db_query($sql);
		}

		$table_name = $this->get_plugin_table_name();
		$sql = "CREATE TABLE " . $table_name ." (
				  id INT(4) NOT NULL AUTO_INCREMENT,
				  name TINYTEXT NOT NULL COLLATE utf8_general_ci,
				  settings TEXT NOT NULL COLLATE utf8_general_ci,
				  PRIMARY KEY (id)
			);";
		if ($this->db_get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {
			$this->activation_sql=$sql;
			if ($execute_sql) $this->db_query($sql);
			return true;
		}
		return false;
	}


	// -----------------------------------------

	function install_plugin() {
		$r=$this->create_tables();
		if ($r) $this->run_activation_sql($this->activation_sql);
	}

	function run_activation_sql($sql) {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	function load_admin_scripts() {
		wp_enqueue_media();
	}

	function on_event_init_menu() {
		$ctmenu = add_menu_page( $this->plugin_name, $this->plugin_name, 'manage_options', $this->plugin_code_name, array(&$this, 'admin_page'));
		$submenu = add_submenu_page( $this->plugin_code_name, $this->plugin_name, 'Add new', 'manage_options', $this->plugin_code_name.'_edit', array(&$this, 'admin_page_edit'));
		add_action('load-'.$ctmenu, array(&$this, 'backend_js_and_css'));
		add_action('load-'.$submenu, array(&$this, 'backend_js_and_css'));

	}

	function add_hook($hook, $arr) {
		return add_action($hook, $arr);
	}
	function add_ajax_hook($hook, $arr) {
		return add_action('wp_ajax_'.$hook, $arr);
	}

	function get_plugins_url () {	// without / on the end
		return plugins_url();
	}

	function get_admin_url() {
		return admin_url('admin.php?page='.$this->plugin_code_name);
	}

	function get_site_url() {
		return get_site_url();
	}

	function get_preview_url() {
		return $this->get_ajax_url().'?action=leadeo_preview';
	}

	function get_ajax_url() {
		return $this->get_site_url().'/wp-admin/admin-ajax.php';
	}

	function is_admin() {
		if (defined('leadeo_DEMO')) return true;
		return is_admin();
	}

	function get_db_prefix() {
		global $wpdb;
		return $wpdb->prefix;
	}
	function get_plugin_table_name() {
		return $this->get_db_prefix().str_replace('-', '_', $this->plugin_code_name);
	}
	function get_db_posts_table() {
		global $wpdb;
		return $wpdb->posts;
	}

	function get_db_postmeta_table() {
		global $wpdb;
		return $wpdb->postmeta;
	}

	function db_query($sql) {
		global $wpdb;
		return $wpdb->query($sql);
	}
	function db_get_var($sql, $col_offset=0, $row_offset=0) {
		global $wpdb;
		return $wpdb->get_var($sql, $col_offset, $row_offset);
	}
	function db_get_row($sql, $row_offset=0) {
		global $wpdb;
		return $wpdb->get_row($sql, ARRAY_A, $row_offset);
	}
	function db_get_results($sql) {	// return array
		global $wpdb;
		return $wpdb->get_results($sql, ARRAY_A);
	}
	function db_insert_row($table, $data, $format=null) {
		global $wpdb;
		return $wpdb->insert($table, $data, $format);
	}
	function db_update($table, $data, $where, $data_format=null, $where_format=null) {
		global $wpdb;
		return $wpdb->update($table, $data, $where, $data_format, $where_format);
	}
	function db_get_insert_id() {
		global $wpdb;
		return $wpdb->insert_id;
	}

	function get_option($var) {	// return FALSE on error
		return get_option($var);
	}
	function add_option($var, $val) {
		return add_option($var, $val, '', 'no');
	}
	function update_option($var, $val) {
		return update_option($var, $val);
	}


	function plugin_action_links( $links, $file ) {
		if ( $file == plugin_basename( dirname(__FILE__).'/leadeo.php' ) ) {
			$links[] = '<a href="admin.php?page=leadeo">'.__('Settings').'</a>';
		}

		return $links;
	}
	function dashboard_footer () {
		echo $this->plugin_name.' '.$this->plugin_version;
	}

	function strip_separator() {
		$arr=array();
		$post_array=explode('[odvoji]', $_POST['leadeo_data']);
		foreach($post_array as $pval) {
			$pos=strpos($pval, '=');
			if ($pos!==FALSE) {
				$pkey=substr($pval, 0, $pos);
				$pval=substr($pval, $pos+1);
				$arr[$pkey]=$pval;
			}
		}
		return $arr;
	}

	function shortcode($atts) {
		$id=0;

		extract(shortcode_atts(array(
			'id' => ''
		), $atts));

		$this->init_view();
		$buffer=$this->view->generate_html_from_shortcode($id);

		$buffer = preg_replace('/\s+/', ' ',$buffer);

		return do_shortcode($buffer);
	}

	function find_all_shortcodes_on_page() {
		global $post;
		if (!isset($post->ID)) return array();
		//print_r($post); exit;
		$mypost = get_post($post->ID);
		$content = $mypost->post_content;
		$start=0;
		$arr=array();
		while (1) {
			$pos = strpos($content, '[leadeo id', $start);
			if ($pos===FALSE) break;
			$end = strpos($content, ']', $pos);
			$pos2 = strpos($content, '"', $pos);
			if ($pos2===FALSE || $pos2>$end) {
				$pos2 = strpos($content, "'", $pos);
				if ($pos2===FALSE || $pos2>$end) break;
			}
			$pos3 = strpos($content, '"', $pos2+1);
			if ($pos3===FALSE || $pos3>$end) {
				$pos3 = strpos($content, "'", $pos2+1);
				if ($pos3===FALSE || $pos3>$end) break;
			}
			$start=$pos3;
			$arr[]=substr($content, $pos2+1, $pos3-$pos2-1);
		}
		return $arr;
	}


	function inline_header() {
/*
		$frontHtml='';
		$this->init_view();
		$frontHtml=$this->view->header_function($arr);
		echo $frontHtml;
*/
	}

	function frontend_enqueue_scripts(){
		//$arr=$this->find_all_shortcodes_on_page();
		//exit;
		/*
		if (count($arr)==0) return;
		$this->frontend_js_and_css();
		*/
	}

	function ajax_get_leadeo_iframe_source() {
		$this->init_view();
		if (isset($_REQUEST['action']) && $_REQUEST['action']=='leadeo_preview') {$temp=true; $_REQUEST['id']=1;}
		else $temp=false;
		if (!isset($_REQUEST['id'])) exit;
		$id=intval($_REQUEST['id']);
		echo $this->view->get_iframe_source($id, $temp);
		exit;
	}

	function upper_first_letter($val) {
		return strtoupper(substr($val,0,1)).substr($val,1);
	}

	function list_array_that_begins_with($searching_arr, $key) {
		$arr=array();
		$len=strlen($key);
		foreach($searching_arr as $skey => $sval) {
			if (substr($skey, 0, $len)==$key) $arr[$skey]=$sval;
		}
		return $arr;
	}

	function get_meta_mailchimp_subscribe_array($form_id) {
		$arr=array();
		$base='base_'.$form_id.'_';
		$loaded=$this->model->get_all_data();

		if (!isset($loaded[$base.'mailchimp_list'])) return $arr;

		$arr['list']=$loaded[$base.'mailchimp_list'];

		//return '<pre>'.print_r($loaded, true).'</pre>';
		$searching_for=$base.'mailchimp_list_'.$arr['list'].'_group_';
		$temp_groups=$this->list_array_that_begins_with($loaded, $searching_for);
		$groups=array();
		foreach ($temp_groups as $key=>$val) {
			$okey=$key;
			$key=str_replace($searching_for, '', $key);
			if (strpos($key,  '_')===false) {
				$name=$loaded[$okey];
				$groups[$key]=$name;
			}
		}
		if (count($groups)==0) return $arr;
		foreach ($groups as $group_id=>$group_name) {
			$arr['groups'][$group_id]=array();
			$arr['groups_name'][$group_id]=$group_name;
		}
		foreach ($groups as $group_id=>$temp) {
			$searching_for=$base.'mailchimp_list_'.$arr['list'].'_group_'.$group_id;
			$temp_options=$this->list_array_that_begins_with($loaded, $searching_for);
			foreach ($temp_options as $key=>$val) {
				$okey=$key;
				$key=str_replace($searching_for, '', $key);
				if (strpos($key,  '_')!==false) {
					$option=$loaded[$okey];
					$arr['groups'][$group_id][]=$option;
					//echo $option.'<br />';
				}
			}
		}

		return $arr;
	}

	function get_real_mailchimp_subscribe_array($meta_subscribe_array) {
		$arr=array();
		if (!isset($meta_subscribe_array['list'])) return $arr;
		$arr['list']=$meta_subscribe_array['list'];
		if (!isset($meta_subscribe_array['groups'])) return $arr;
		$arr['groupings']=array();
		foreach ($meta_subscribe_array['groups'] as $group_id => $options){
			$group=array(
				'id' => $group_id,
				'name' => $meta_subscribe_array['groups_name'][$group_id],
				'groups' => $options
			);
			$arr['groupings'][]=$group;
		}
		return $arr;
	}

	function mailchimp_subscribe($email, $form_id) {
		$meta_subscribe=$this->get_meta_mailchimp_subscribe_array($form_id);
		//echo '<pre>'.print_r($subscribe, true).'</pre>';
		$real_subscribe=$this->get_real_mailchimp_subscribe_array($meta_subscribe);
		//print_r($real_subscribe); exit;
		$apikey=$this->model->get('mailchimp_api', $form_id);
		if (!isset($real_subscribe['list'])) return false;
		$list=$real_subscribe['list'];
		$mailchimp = new leadeo_mailchimp($apikey);
		$merge_vars=array();
		if (isset($real_subscribe['groupings']) && count($real_subscribe['groupings'])>0) {
			$merge_vars = array(
				'groupings' => $real_subscribe['groupings']
			);
		}
		$result=$mailchimp->subscribe($email, $list, $merge_vars);
		//var_dump($result);
		return $result;
	}

	function generate_mailchimp_list($form_id, $lists) {

		$hbase='leadeo_base_'.$form_id.'_';
		$lbase='base_'.$form_id.'_';
		$loaded=$this->model->get_all_data();
		//return '<pre>'.print_r($loaded, true).'</pre>';

		$buf='<table style="width: 100%; border: 1px solid #000;">';
		$style='style="background-color: #8ECCB6;"';
		$buf.='<tr><td '.$style.'>List</td><td '.$style.'>Group</td><td '.$style.'>Option</td><td '.$style.'>Name</td></tr>';
		$row=0;
		foreach ($lists as $i_lid => $list) {
			$checked=false;
			$name_for_html = $hbase.'mailchimp_list';
			$name_for_db   = $lbase.'mailchimp_list';
			if (isset($loaded[$name_for_db]) && $loaded[$name_for_db]==$list['id']) $checked=true;
			$buf.=$this->push_mailchimp_row($row, 0, 'radio', $name_for_html, $list['id'], $checked, $list['name']);
			$row++;
			if (intval($list['groups_count'])>0) {
				foreach ($list['groups'] as $i_gid => $group) {
					$name_for_html = $hbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'];
					$name_for_db   = $lbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'];
					$checked=false;
					if (isset($loaded[$name_for_db])) $checked=true;
					$buf.=$this->push_mailchimp_row($row, 1, 'checkbox', $name_for_html, $group['name'], $checked, $group['name']);
					$row++;
					$field_type=$group['form_field'];
					foreach ($group['options'] as $i_oid => $option) {
						$checked=false;
						if ($field_type=='checkbox' || $field_type=='checkboxes') {
							$name_for_html = $hbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'].'_option_'.$i_oid;
							$name_for_db   = $lbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'].'_option_'.$i_oid;
							if (isset($loaded[$name_for_db])) $checked=true;
						} else {
							$name_for_html = $hbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'].'_option';
							$name_for_db   = $lbase.'mailchimp_list_'.$list['id'].'_group_'.$group['id'].'_option';
							if (isset($loaded[$name_for_db]) && $loaded[$name_for_db]==$option['name']) $checked=true;
						}
						$buf.=$this->push_mailchimp_row($row, 2, $field_type, $name_for_html, $option['name'], $checked, $option['name']);
						$row++;
					}
				}
			}
		}

		$buf.='</table>';
		return $buf;
	}
	function push_mailchimp_row($row, $level, $field_type, $field_name, $field_value, $checked, $content) {
		$field=$this->generate_mailchimp_field($level, $field_type, $field_name, $field_value, $checked);
		$style='';
		$buf='';
		if ($level==0 && $row>0) $buf.='<tr><td colspan="4">&nbsp;</td></tr>';
		if ($level==0) $style="background-color: #CCCCCC;";
		if ($level==1) $style="background-color: #EEEEEE;";
		$buf.='<tr style="'.$style.'">';
		$buf.='<td>';
		if ($level==0) $buf.=$field;
		$buf.='</td>';
		$buf.='<td>';
		if ($level==1) $buf.=$field;
		$buf.='</td>';
		$buf.='<td>';
		if ($level==2) $buf.=$field;
		$buf.='</td>';
		$buf.='<td>'.$content.'</td>';
		$buf.='</tr>';
		return $buf;
	}
	function generate_mailchimp_field($level, $field_type, $field_name, $value='', $checked=false) {
		$checked_string='';
		if ($checked) $checked_string='checked="checked" ';

		$class='leadeo_mailchimp_field_'.$level;

		if ($field_type=='checkbox' || $field_type=='checkboxes') {
			return '<input class="'.$class.'" type="checkbox" name="'.$field_name.'" '.$checked_string.'value="'.$value.'" />';
		} else {
			return '<input class="'.$class.'" type="radio" name="'.$field_name.'" '.$checked_string.'value="'.$value.'" />';
		}
	}
	function sort_by_sub_value_handler($a, $b) {
		$field=$this->sort_by_sub_field;
		return $a[$field] - $b[$field];
	}
	function sort_by_sub_value(&$arr, $field) {
		$this->sort_by_sub_field=$field;
		return usort($arr, array($this, 'sort_by_sub_value_handler'));
	}
}

$leadeo=new leadeo_main();