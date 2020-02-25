<?php 
class NJT_POST_TYPE_USER_SUB {
    public function __construct(){
    }
  
    public function CheckUserExit($args=false){
         $default = array(
            'post_type' => 'njt_user_subscriber',
            'post_status'=>array('publish','pending','future'),
            'meta_query'=>array(
                    'relation' => 'OR',
                    array(
                      'key'=>'njt_fb_l_c_id_user',
                      'value'=>$args['id'],
                      'compare'=>'=' 
                    ),
                  
                    array(
                      'key'=>'njt_fb_l_c_email_user',
                      'value'=>$args['email'],
                      'compare'=>'=' 
                    ),
                 
                ),
            );
         if($args!=false){
               // $args = wp_parse_args($args, $default );
                $posts = new WP_Query($default);
                if($posts->have_posts())
                {   
                    
                    return true ;
                }
         }
         return false;
    }
    

    public function Insert($args=false){
        $arr = array(
            'post_content' => $args['mess'],
            'post_date' => $args['post_date'],
            'post_date_gmt' => $args['post_date'],
            'post_type' => $args['post_type'],
            'post_title' => wp_trim_words($args['mess'], 200),
           'post_status' => 'publish',
        );
        // print_r($args);
        if($args!=false && is_array($args) ){
            $insert_id = wp_insert_post($arr);
            if($args['post_type']=='njt_user_subscriber'){
                
                update_post_meta($insert_id, 'njt_fb_l_c_id_user', $args['njt_fb_l_c_id_user']);
                update_post_meta($insert_id, 'njt_fb_l_c_gender_user', $args['njt_fb_l_c_gender_user']);
                update_post_meta($insert_id, 'njt_fb_l_c_lang_user', $args['njt_fb_l_c_lang_user']);
                update_post_meta($insert_id, 'njt_fb_l_c_name_user', $args['njt_fb_l_c_name_user']);
                update_post_meta($insert_id, 'njt_fb_l_c_email_user', $args['njt_fb_l_c_email_user']);  
                update_post_meta($insert_id, 'njt_fb_l_c_first_name_user', $args['njt_fb_l_c_first_name_user']); 
                update_post_meta($insert_id, 'njt_fb_l_c_last_name_user', $args['njt_fb_l_c_last_name_user']);
             
                update_post_meta($insert_id, 'njt_fb_l_c_picture_user', $args['njt_fb_l_c_picture_user']);
                update_post_meta($insert_id, 'njt_fb_l_c_token_user', $args['njt_fb_l_c_token_user']);
            } //njt_user_subscriber
            
            return $insert_id;
        }
        return false;
    }

    // GROUP
    public function CheckGroupExit($args=false){
         $default = array(
            'post_type' => 'njt_fb_gr',
            'post_status'=>array('publish','pending','future'),
            'meta_query'=>array(
                    'relation' => 'OR',
                    array(
                      'key'=>'njt_fb_gr_id_group',
                      'value'=>$args['id_group'],
                      'compare'=>'=' 
                    ),
                    
                ),
            );
         if($args!=false){
               // $args = wp_parse_args($args, $default );
                $posts = new WP_Query($default);
                if($posts->have_posts())
                {   
                    
                    return true ;
                }
         }
         return false;
    }
    public function Insert_Group($args=false){
        $arr = array(
            'post_content' => $args['mess'],
            'post_date' => $args['post_date'],
            'post_date_gmt' => $args['post_date'],
            'post_type' => $args['post_type'],
            'post_title' => wp_trim_words($args['mess'], 200),
           'post_status' => 'publish',
        );

        if($args!=false && is_array($args) ){
            $insert_id = wp_insert_post($arr);
            if($args['post_type']=='njt_fb_gr'){
                
                update_post_meta($insert_id, 'njt_fb_gr_id_group', $args['njt_fb_gr_id_group']);
                
                update_post_meta($insert_id, 'njt_fb_gr_name_group', $args['njt_fb_gr_name_group']);
                update_post_meta($insert_id, 'njt_fb_gr_group_url', $args['njt_fb_gr_group_url']);
                
            } //njt_fb_gr
            
            return $insert_id;
        }
        return false;
    }


    //
    public  function getAllUserAddMailChimp($args=array()){
        $posts = array();
        $default = array(
                    'post_type'   => 'njt_user_subscriber',
                    'post_status' => 'publish',
                    'posts_per_page' => -1 ,
                    'order'               => 'DESC',
                    'orderby'             => 'date',
            );
        $args_fill = wp_parse_args($default,$args);
        $posts_from_db = new WP_Query(
            $args_fill
        );
        if ($posts_from_db->have_posts()) {
            $dem = 0;
            while ($posts_from_db->have_posts()) {
                $posts_from_db->the_post();
                $email =get_post_meta(get_the_id(),'njt_fb_l_c_email_user',true);
                if(!empty($email)){
                $posts[$dem]['email_address'] = get_post_meta(get_the_id(),'njt_fb_l_c_email_user',true);
                $posts[$dem]['email_type'] = 'html';
                $posts[$dem]['merge_fields'] =array(
                                "FNAME"=>get_post_meta(get_the_id(),'njt_fb_l_c_first_name_user',true), 
                                "LNAME"=>get_post_meta(get_the_id(),'njt_fb_l_c_last_name_user',true),
                    );
                $posts[$dem]['status'] ='subscribed';
                $dem++;
                }
            }
        }
        return $posts;
    }
}
?>