<?php
class NjtFbPrPage {
    public static function insert($args)
    {
        $insert_id = wp_insert_post(array(
            'post_type' => 'njt_fb_pr_pages',
            'post_status' => 'publish',
        ));
        update_post_meta($insert_id, 'fb_page_id', $args['fb_page_id']);
        update_post_meta($insert_id, 'fb_page_name', $args['fb_page_name']);
        update_post_meta($insert_id, 'fb_page_token', $args['fb_page_token']);
        update_post_meta($insert_id, 'fb_user_id', $args['fb_user_id']);

        return $insert_id;
    }
    public static function isExists($fb_page_id, $user_id)
    {
        $pages = get_posts(array(
            'post_type' => 'njt_fb_pr_pages',
            'meta_query' => array(
                array(
                    'key' => 'fb_user_id',
                    'value' => $user_id,
                    'compare' => 'LIKE',
                ),
                array(
                    'key' => 'fb_page_id',
                    'value' => $fb_page_id,
                    'compare' => '=',
                )
                
            ),
        ));
        $is_exists = false;
        if (count($pages) > 0) {
            $is_exists = true;
        }
        return $is_exists;
    }
    public static function Get_Post_ID_Exists($fb_page_id, $user_id)
    {
        $default = array(
            'post_type' => 'njt_fb_pr_pages',
            'post_status'=>array('publish','pending','future'),
            'meta_query'=>array(
                    'relation' => 'AND',
                    array(
                      'key'=>'fb_user_id',
                      'value'=>$user_id,
                      'compare'=>'LIKE' 
                    ),
                    array(
                      'key'=>'fb_page_id',
                      'value'=>$fb_page_id,
                      'compare'=>'=' 
                    ),
                ),
          );

         if($fb_page_id!=false && $user_id!=false){

                $posts = new WP_Query($default);

                if($posts->have_posts())

                {   

                  return $posts->post->ID;

                }

         }

         return false;
    }
    public static function getPageTokenFromPageId($s_page_id, $return_object = false)
    {
        $object = array();
        $token = get_post_meta($s_page_id, 'fb_page_token', true);
        $object = (object)array('wp_id' => $s_page_id, 'token' => $token);
        if ($return_object) {
            return $object;
        } else {
            return $token;
        }
    }

    /**
     * Get page token from facebook page id, if we have more than 1 post, it will get the latest post
     *
     * @param  String  $fb_page_id    Facebook Page ID
     * @param  boolean $return_object Return token(string) or object
     * @return Object or String
     */
    
    public static function getPageTokenFromFacebookPageId($fb_page_id, $return_object = false)
    {
        $object = array();
        $pages = get_posts(array(
            'post_type' => 'njt_fb_pr_pages',
            'meta_key' => 'fb_page_id',
            'meta_value' => $fb_page_id,
            'orderby' => 'ID',
            'order'   => 'DESC',
            'posts_per_page' => 1,
        ));
        $token = '';
        foreach ($pages as $k => $v) {
            $id = $v->ID;
            $token = get_post_meta($id, 'fb_page_token', true);
            $object = (object)array('wp_id' => $id, 'token' => $token);
        }
        if ($return_object) {
            return $object;
        } else {
            return $token;
        }
    }
    public static function getPageInfo($fb_page_id)
    {
        $page = array();

        $pages = get_posts(array(
            'post_type' => 'njt_fb_pr_pages',
            'meta_key' => 'fb_page_id',
            'meta_value' => $fb_page_id,
        ));
        
        foreach ($pages as $k => $v) {
            $id = $v->ID;
            $page = (object)array(
                'page_name' => get_post_meta($id, 'fb_page_name', true),
                'page_id' => get_post_meta($id, 'fb_page_id', true),
            );
        }
        return $page;
    }
    public static function getAllPages($user_id = null, $debug = false)
    {
        $pages = array();
        if (is_null($user_id)) {
            return $pages;
        }
        
        $pages_from_db = get_posts(array(
            'post_type' => 'njt_fb_pr_pages',
            'meta_key' => 'fb_user_id',
            'meta_value' => $user_id,
            'post_status' => 'any',
            'posts_per_page' => '-1',
        ));
        if ($debug) {
            print_r($pages_from_db);
            exit();
        }
        foreach ($pages_from_db as $k => $v) {
            $id = $v->ID;
            //wp_delete_post($id, true);
            $page = (object)array(
                'sql_post_id' => $id,
                'page_id' => get_post_meta($id, 'fb_page_id', true),
                'page_name' => get_post_meta($id, 'fb_page_name', true),
                'page_token' => get_post_meta($id, 'fb_page_token', true),
                'app_id' => get_post_meta($id, 'fb_app_id', true),
                'user_id' => get_post_meta($id, 'fb_user_id', true),
                'is_subscribed' => get_post_meta($id, 'is_subscribed', true),
            );
            if ($page->is_subscribed == '') {
                $page->is_subscribed = 'no';
            }
            $pages[] = $page;
        }
        return $pages;
    }
    public static function deleteAllPages($user_id)
    {
        $posts = self::getAllPages($user_id);
        foreach ($posts as $k => $v) {
            wp_delete_post($v->post_id, true);
        }
    }
    public static function deletePage($page_id)
    {
        if (get_post_type($page_id) == 'njt_fb_pr_pages') {
            wp_delete_post($page_id, true);
        }
    }
}
