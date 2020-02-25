<?php 
  if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class NJT_L_C_List_Table_User extends WP_List_Table{
    private  $locale;
    function __construct(){
        global $status, $page;      
        //Set parent defaults
        parent::__construct( array(
            'singular'  => __( 'List User', NJT_APP_LIKE_COMMENT ),    
            'plural'    => __( 'List User', NJT_APP_LIKE_COMMENT ),    
            'ajax'      => false        
        ) );
        $this->locale = array(
                          'af_ZA' => 'Afrikaans',
                          // Arabic
                          'ar_AR' => 'Arabic',
                          // Azerbaijani
                          'az_AZ' => 'Azerbaijani',
                          // Belarusian
                          'be_BY' => 'Belarusian',
                          // Bulgarian
                          'bg_BG' => 'Bulgarian',
                          // Bengali
                          'bn_IN' => 'Bengali',
                          // Bosnian
                          'bs_BA' => 'Bosnian',
                          // Catalan
                          'ca_ES' => 'Catalan',
                          // Czech
                          'cs_CZ' => 'Czech',
                          // Welsh
                          'cy_GB' => 'Welsh',
                          // Danish
                          'da_DK' => 'Danish',
                          // German
                          'de_DE' => 'German',
                          // Greek
                          'el_GR' => 'Greek',
                          // English (UK)
                          'en_GB' => 'English (GB)',
                          // English (Pirate)
                          'en_PI' => 'English (Pirate)',
                          // English (Upside Down)
                          'en_UD' => 'English (Upside Down)',
                          // English (US)
                          'en_US' => 'English (US)',
                          // Esperanto
                          'eo_EO' => 'Esperanto',
                          // Spanish (Spain)
                          'es_ES' => 'Spanish (Spain)',
                          // Spanish
                          'es_LA' => 'Spanish',
                          // Estonian
                          'et_EE' => 'Estonian',
                          // Basque
                          'eu_ES' => 'Basque',
                          // Persian
                          'fa_IR' => 'Persian',
                          // Leet Speak
                          'fb_LT' => 'Leet Speak',
                          // Finnish
                          'fi_FI' => 'Finnish',
                          // Faroese
                          'fo_FO' => 'Faroese',
                          // French (Canada)
                          'fr_CA' => 'French (Canada)',
                          // French (France)
                          'fr_FR' => 'French (France)',
                          // Frisian
                          'fy_NL' => 'Frisian',
                          // Irish
                          'ga_IE' => 'Irish',
                          // Galician
                          'gl_ES' => 'Galician',
                          // Hebrew
                          'he_IL' => 'Hebrew',
                          // Hindi
                          'hi_IN' => 'Hindi',
                          // Croatian
                          'hr_HR' => 'Croatian',
                          // Hungarian
                          'hu_HU' => 'Hungarian',
                          // Armenian
                          'hy_AM' => 'Armenian',
                          // Indonesian
                          'id_ID' => 'Indonesian',
                          // Icelandic
                          'is_IS' => 'Icelandic',
                          // Italian
                          'it_IT' => 'Italian',
                          // Japanese
                          'ja_JP' => 'Japanese',
                          // Georgian
                          'ka_GE' => 'Georgian',
                          // Khmer
                          'km_KH' => 'Khmer',
                          // Korean
                          'ko_KR' => 'Korean',
                          // Kurdish
                          'ku_TR' => 'Kurdish',
                          // Latin
                          'la_VA' => 'Latin',
                          // Lithuanian
                          'lt_LT' => 'Lithuanian',
                          // Latvian
                          'lv_LV' => 'Latvian',
                          // Macedonian
                          'mk_MK' => 'Macedonian',
                          // Malayalam
                          'ml_IN' => 'Malayalam',
                          // Malay
                          'ms_MY' => 'Malay',
                          // Norwegian (bokmal)
                          'nb_NO' => 'Norwegian (bokmal)',
                          // Nepali
                          'ne_NP' => 'Nepali',
                          // Dutch
                          'nl_NL' => 'Dutch',
                          // Norwegian (nynorsk)
                          'nn_NO' => 'Norwegian (nynorsk)',
                          // Punjabi
                          'pa_IN' => 'Punjabi',
                          // Polish
                          'pl_PL' => 'Polish',
                          // Pashto
                          'ps_AF' => 'Pashto',
                          // Portuguese (Brazil)
                          'pt_BR' => 'Portuguese (Brazil)',
                          // Portuguese (Portugal)
                          'pt_PT' => 'Portuguese (Portugal)',
                          // Romanian
                          'ro_RO' => 'Romanian',
                          // Russian
                          'ru_RU' => 'Russian',
                          // Slovak
                          'sk_SK' => 'Slovak',
                          // Slovenian
                          'sl_SI' => 'Slovenian',
                          // Albanian
                          'sq_AL' => 'Albanian',
                          // Serbian
                          'sr_RS' => 'Serbian',
                          // Swedish
                          'sv_SE' => 'Swedish',
                          // Swahili
                          'sw_KE' => 'Swahili',
                          // Tamil
                          'ta_IN' => 'Tamil',
                          // Telugu
                          'te_IN' => 'Telugu',
                          // Thai
                          'th_TH' => 'Thai',
                          // Filipino
                          'tl_PH' => 'Filipino',
                          // Turkish
                          'tr_TR' => 'Turkish',
                          //
                          'uk_UA' => 'Ukrainian',
                          // Vietnamese
                          'vi_VN' => 'Vietnamese',
                          //
                          'zh_CN' => 'Simplified Chinese (China)',
                          //
                          'zh_HK' => 'Traditional Chinese (Hong Kong)',
                          //
                          'zh_TW' => 'Traditional Chinese (Taiwan)',
        );
    }
    function get_custom_post( $per_page = 5, $page_number = 1){
        global $wpdb,$post,$wp_query;
        $users = array();
        $args=array();
        $result = array();
        $args_locale='';
        $args_gender=''; 
        $def=array(
          'paged' => $page_number,
          'posts_per_page' => $per_page,
          'post_type'=>'njt_user_subscriber',
        );
        $arg_s_1 = array();
        if (!empty($_REQUEST['s'])) {
          $arg_s_1 =array(
              'relation' => 'OR',
                array( 
                    'key' => 'njt_fb_l_c_first_name_user',
                    'value' =>$_REQUEST['s'],
                    'compare'=>'LIKE'
                  ),
                array( 
                    'key' => 'njt_fb_l_c_last_name_user',
                    'value' =>$_REQUEST['s'],
                    'compare'=>'LIKE'
                  )
              );
          }
        if (isset($_REQUEST['locale']) && !empty($_REQUEST['locale'])) {
            $args_locale=array(
                      'key' => 'njt_fb_l_c_lang_user',
                      'value' =>$_REQUEST['locale'],
                      'compare'=>'=' 
                      );
        }
        if (isset($_REQUEST['gender']) && !empty($_REQUEST['gender'])) {
            $args_gender=array(
                      'key' => 'njt_fb_l_c_gender_user',
                      'value' =>$_REQUEST['gender'],
                      'compare'=>'='
                      );
          }
        $args = array(
              'meta_query' => array(
                  'relation' => 'AND',
                  $args_locale,
                  $args_gender,
                  $arg_s_1,
            ),
        ); 
        $args = wp_parse_args($args,$def);
        $users  = new  WP_Query($args);
      return $users;
    }
    public function loops($users){
        $result = array();
        if($users->have_posts()){
        while ($users->have_posts()){
          $users->the_post();
          $result[]=get_post(get_the_id(),'ARRAY_A');
        }
      }
      return $result;
    }
    public function no_items() {
        _e( 'No User avaliable.', NJT_APP_LIKE_COMMENT );
    }
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  
            /*$2%s*/ $item['ID']                
        );
    }
    function column_id($item){
        return $item['ID'];
    }
    function column_first_name($item){
        return get_post_meta($item['ID'],'njt_fb_l_c_first_name_user' ,true);
    }
    function column_last_name($item){
        return get_post_meta($item['ID'],'njt_fb_l_c_last_name_user' ,true);
    }
    function column_avatar($item){
      //return get_post_meta($item['ID'],'njt_fb_l_c_id_user',true);
      //return get_post_meta($item['ID'],'njt_fb_l_c_token_user' ,true);
      // if(get_post_meta($item['ID'],'njt_fb_l_c_token_user' ,true)){
      if(get_post_meta($item['ID'],'njt_fb_l_c_id_user' ,true)){
        $token_admin =get_option('njt_app_fb_like_comment_user');
        $api_fb = new NJT_APP_LIKE_COMMENT_API();
        $token_user = get_post_meta($item['ID'],'njt_fb_l_c_token_user' ,true);
        $id_user = get_post_meta($item['ID'],'njt_fb_l_c_id_user',true);
        //$token_user = get_option("njt_token_full_permission");
        
        //njt_token_full_permission
        $data = $api_fb->GET_INFO_USER_SUB_FULL_PER($token_user,$id_user);
        if(isset($data['error']['message'])){

          $picture = NJT_APP_LIKE_COMMENT_URL.'assets/images/avatar.png';
          return sprintf('<img width="50" src="%1$s" />',$picture);
        }else{
          $picture=$data['picture'];
          $picture = $picture['data'];
          $picture= $picture['url'];
        
          $href = 'https://facebook.com/' . get_post_meta($item['ID'],'njt_fb_l_c_id_user' ,true) ;
          return sprintf('<img width="50" src="%1$s" />',$picture);
        }
        
      }else{
        $picture = NJT_APP_LIKE_COMMENT_URL.'assets/images/avatar.png';
        return sprintf('<img width="50" src="%1$s" />',$picture);
      }
    }
    function column_email($item){
        return get_post_meta($item['ID'],'njt_fb_l_c_email_user' ,true);
      /*
      $api_fb = new NJT_APP_LIKE_COMMENT_API();
      $token_user = get_post_meta($item['ID'],'njt_fb_l_c_token_user' ,true);
      $id_user = get_post_meta($item['ID'],'njt_fb_l_c_id_user',true);
      $data = $api_fb->GET_INFO_USER_SUB_FULL_PER($token_user,$id_user);
      if(isset($data['email']) && !empty($data['email'])){
        //update_post_meta($item['ID'],'njt_fb_l_c_email_user' ,$data['email']);
        return $data['email'];
      }else{
        return get_post_meta($item['ID'],'njt_fb_l_c_email_user' ,true);
      }
      */
    }
    function column_gender($item){
        return get_post_meta($item['ID'],'njt_fb_l_c_gender_user' ,true);
    }
    function column_locale($item){
      $key=get_post_meta($item['ID'],'njt_fb_l_c_lang_user' ,true);
      return  $this->locale[$key] ;
    }
    function column_day($item){
      return get_the_date('m/d/Y',$item['ID']);
    }
    // GET FILEDS TABLE CUSTOM
    public function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'id'    =>__('ID',NJT_APP_LIKE_COMMENT),
            'first_name'     => __('First Name',NJT_APP_LIKE_COMMENT),
            'last_name'     => __('Last Name',NJT_APP_LIKE_COMMENT),
            'avatar'=>__('Profile Pic',NJT_APP_LIKE_COMMENT),
            'email'=>__('Email',NJT_APP_LIKE_COMMENT),
            //'gender'    => __('Gender',NJT_APP_LIKE_COMMENT),         
            //'locale' =>__('Locale',NJT_APP_LIKE_COMMENT),
            'day' =>__('Date',NJT_APP_LIKE_COMMENT),
        );
        return $columns;
    }
    // GET SHOW BULK ACTIONS
    public function get_bulk_actions() {
        $actions = array(
            'delete'    => __('Delete',NJT_APP_LIKE_COMMENT),
        );
        return $actions;
    }
    // PROCESS BULK ACTION CUSTOM
    public function process_bulk_action() {
        if ( 'delete' === $this->current_action() ) 
        {
          if((isset( $_GET['action']) && $_GET['action'] == 'delete')||isset( $_GET['action2']) && $_GET['action2'] == 'delete'){
            $delete_ids = esc_sql( $_GET['listuser'] );
        //    wp_die(print_r($delete_ids));
              foreach ( $delete_ids as $id ) {
            //    wp_die($id);
               //   self::delete_post( $id );
                  wp_delete_post($id);
              }
            wp_safe_redirect( add_query_arg( array( 'page' => 'list-user-subscriber' ), admin_url( 'admin.php' )));  
          }else{
            self::delete_post( absint( $_GET['listuser'] ));
            wp_safe_redirect( add_query_arg( array( 'page' => 'list-user-subscriber' ), admin_url( 'admin.php' )));
          }   
        }
    }
    // SHOW LIST CATEGORY EXTRA TABLE NAV ( SEARCH, FILTER, ...)
    public function extra_tablenav($which){
        if ($which == 'top') {
          ?>
          <div class="alignleft actions">  
               <?php
                $selected_locale = ((isset($_GET['locale'])) ? $_GET['locale']: '');
                $locales = $this->locale;
              ?>
              <select name="locale" id="">
                  <option value="" <?php selected('', $selected_locale); ?>>
                      <?php _e('All Locales', NJT_APP_LIKE_COMMENT); ?>                    
                  </option>
                  <?php
                  foreach ($locales as $k => $v) {
                      print_r($v);
                      // if (!empty($v->locale)) {
                          echo sprintf('<option value="%1$s" %3$s>%2$s</option>', esc_attr($k),$v , selected($k, $selected_locale, false));
                      //}
                  }
                  ?>
              </select>
              <?php
              /*
               * Filter by gender
               */
              $selected_gender = ((isset($_GET['gender'])) ? $_GET['gender']: '');
              $genders = array('male', 'female');
              ?>
              <select name="gender" id="">
                  <option value="" <?php selected('', $selected_locale); ?>>
                      <?php _e('All Genders', NJT_APP_LIKE_COMMENT); ?>                    
                  </option>
                  <?php
                  foreach ($genders as $k => $v) {
                      echo sprintf('<option value="%1$s" %3$s>%2$s</option>', $v, $v, selected($v, $selected_gender, false));
                  }
                  ?>
              </select>
              <input type="submit" name="filter_action" class="button action" value="<?php _e('Filter',NJT_APP_LIKE_COMMENT); ?>">
              <img style="display:none;width: 25px;padding-left: 5px;padding-top: 3px;" id="njt_img_export_csv" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/load.gif'; ?>">
              <input type="hidden" id="njt_home_url" value="<?php echo wp_upload_dir()['baseurl'].'/spiderlink.csv'; ?>">
              <div style="margin:0;margin-left: 15px;" class="button button-primary njt_spiderlinkcsv">
                <?php echo __('Export to CSV', 'njt-app-like-comment-fb'); ?>
              </div>
            </div>
          <?php
        }
    }
    public  function record_count(){
      $count =self::get_custom_post(-1);
      return $count->post_count;  
    }
    public  function column_default($item, $column_name)
    {
        return ((in_array($column_name, array_keys($this->get_columns()))) ? $item[$column_name] : print_r($item, true));
    }
    // SHOW TABLE CUSTOM
    public function prepare_items() {
        $per_page = $this->get_items_per_page('njt_l_c_user__per_page', 20);
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns,$hidden,$sortable);  // SHOW COLUM FIELDS CUSTOM
        $this->process_bulk_action();
        $current_page = $this->get_pagenum(); 
        $total_items  = self::record_count();
        $loops = $this->get_custom_post($per_page,$current_page);
        $this->items = $this->loops($loops);
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  
            'per_page'    => $per_page,       
        ) );
    }
}
?>