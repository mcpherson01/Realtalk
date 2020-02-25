<?php 
  if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class NJT_L_C_List_Facebook_Group extends WP_List_Table{
    private  $locale;
    function __construct(){
        global $status, $page;      
        //Set parent defaults
        parent::__construct( array(
            'singular'  => __( 'Facebook Group', NJT_APP_LIKE_COMMENT ),    
            'plural'    => __( 'Facebook Group', NJT_APP_LIKE_COMMENT ),    
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
          'post_type'=>'njt_fb_gr',
        );
        $arg_s_1 = array();
        if (!empty($_REQUEST['s'])) {
          $arg_s_1 =array(
              'relation' => 'OR',
                array( 
                    'key' => 'njt_fb_gr_name_group',
                    'value' =>$_REQUEST['s'],
                    'compare'=>'LIKE'
                  ),
                
              );
          }
        
        $args = array(
              'meta_query' => array(
                  'relation' => 'AND',
                  
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
        _e( 'No Group avaliable.', NJT_APP_LIKE_COMMENT );
    }
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  
            /*$2%s*/ $item['ID']                
        );
    }
    function column_id($item){
    //    return $item['ID'];
      return get_post_meta($item['ID'],'njt_fb_gr_id_group' ,true);
    }
    function column_picture_group($item){
      $fb_api = new NJT_APP_LIKE_COMMENT_API();
      $user_token=get_option('njt_token_full_permission');
      $id_group=get_post_meta($item['ID'],'njt_fb_gr_id_group' ,true);
      $image = $fb_api->SpiderLink_Group_Icon_To_GroupID($id_group,$user_token);
      $icon = isset($image["icon"]) ? $image["icon"] : "";
      return sprintf('<a href="%2$s" target="_blank" ><img src="%1$s" /></a>',$icon,get_post_meta($item['ID'],'njt_fb_gr_group_url' ,true));
    }
    function column_group_name($item){
      //  return get_post_meta($item['ID'],'njt_fb_gr_name_group' ,true);
      return sprintf('<a href="%2$s" target="_blank" >%1$s</a>',get_post_meta($item['ID'],'njt_fb_gr_name_group' ,true),get_post_meta($item['ID'],'njt_fb_gr_group_url' ,true));
    }
   
    function column_day($item){
      return get_the_date('m/d/Y',$item['ID']);
    }
    // GET FILEDS TABLE CUSTOM
    public function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'id'    =>__('ID',NJT_APP_LIKE_COMMENT),
            'picture_group'     => __('Picture',NJT_APP_LIKE_COMMENT),
            'group_name'     => __('Name',NJT_APP_LIKE_COMMENT),
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
            $delete_ids = esc_sql( $_GET['facebookgroup'] );
 
              foreach ( $delete_ids as $id ) {
         
                  wp_delete_post($id);
              }
            wp_safe_redirect( add_query_arg( array( 'page' => 'list-fb-group' ), admin_url( 'admin.php' )));  
          }else{
            self::delete_post( absint( $_GET['facebookgroup'] ));
            wp_safe_redirect( add_query_arg( array( 'page' => 'list-fb-group' ), admin_url( 'admin.php' )));
          }   
        }
    }
    // SHOW LIST CATEGORY EXTRA TABLE NAV ( SEARCH, FILTER, ...)
    public function extra_tablenav($which){
        if ($which == 'top') {
          ?>
          <div style="margin-top:3px;margin-left:5px;" class="button button-primary njt_add_new_group_popup">
                <?php echo __('Add New Facebook Group', 'njt-app-like-comment-fb'); ?>
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