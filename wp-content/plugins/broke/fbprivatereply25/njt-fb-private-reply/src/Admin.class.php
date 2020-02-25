<?php
class NjtFbPrAdmin {
    private static $post_type = 'njt_fb_admins';

    public static function getAll()
    {
        $admins = array();
        $query = new WP_Query(array(
            'post_type' => self::$post_type,
            'post_status' => 'any',
            'posts_per_page' => '-1',
        ));
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $admins[get_the_title()] = get_post_meta(get_the_id(), '_fb_name', true);
            }
        }
        wp_reset_postdata();
        return $admins;
    }
    public static function insert($data)
    {
        $check = get_page_by_title($data['id'], 'array', self::$post_type);
        if (is_null($check)) {
            $insert = wp_insert_post(array(
                'post_title' => $data['id'],
                'post_type' => self::$post_type,
                'post_status' => 'publish',
            ));
            update_post_meta($insert, '_fb_name', $data['name']);
            update_post_meta($insert, '_fb_token', $data['token']);
            return $insert;
        } else {
            update_post_meta($check->ID, '_fb_name', $data['name']);
            update_post_meta($check->ID, '_fb_token', $data['token']);
            $check->ID;
        }
    }
    public static function deleteAdmin($user_id)
    {
        $admin = get_page_by_title($user_id, 'array', self::$post_type);
        wp_delete_post($admin->ID, true);
    }
    public static function adminInfo($admin_id)
    {
        $admin = get_page_by_title($admin_id, 'array', self::$post_type);
        if (!is_null($admin)) {
            $admin->fb_token = get_post_meta($admin->ID, '_fb_token', true);
        }
        return $admin;
        
    }

    // show list page connected
    public static function showListPageWithToken($user_id,$pages_from_db,$pages_from_token){
        $list_fb_id = array();
        $njt_fb_pr_api = new NjtFbPrApi;
        foreach($pages_from_db as $key_db => $value_db){
            array_push($list_fb_id,$value_db->page_id);
        }
        foreach($pages_from_token as $key => $value){
            $page = (object)array();
            $page->user_id = $user_id;
            $page->page_name = $value["name"];
            $page->page_id = $value["id"];
            $page->page_token = $value["access_token"];
            $page->is_subscribed = 'no';
            $page->app_id = $njt_fb_pr_api->getAppID();
            if(!in_array($value["id"],$list_fb_id)){
                if(isset($_GET["_subscribe"])){
                    $insert_id = NjtFbPrPage::insert(array(
                        'fb_page_id' => $value["id"],
                        'fb_page_name' => $value["name"],
                        'fb_page_token' => $value["access_token"],
                        'fb_user_id' => $user_id,
                    ));
                    $page->sql_post_id = $insert_id;
                }
            }else{
                $page->sql_post_id = NjtFbPrPage::Get_Post_ID_Exists($value["id"], $user_id);
                $pages[] = $page;
            }
        }
        return $pages;
    }
}
