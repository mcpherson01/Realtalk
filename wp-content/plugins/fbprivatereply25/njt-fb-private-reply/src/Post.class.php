<?php
class NjtFbPrPost {

    private static $post_type = 'njt_fb_pr_tmp_posts';
    public static function findPostWithFbId($fb_id, $fb_page_id)
    {
        $found = false;
        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'fb_post_id',
                    'value' => $fb_id,
                    'compare' => 'LIKE',
                ),
                array(
                    'key' => 'fb_page_id',
                    'value' => $fb_page_id,
                    'compare' => '=',
                )
                
            ),
            'post_type' => self::$post_type,
            'orderby' => 'ID',
            'order'   => 'DESC',
            'posts_per_page' => 1,
        );
        $posts = get_posts($args);

        foreach ($posts as $k => $v) {
            $found = $v->ID;
        }
        return $found;
    }
    public static function checkIfPostEnabledPrivateReplies($fb_post_id)
    {
        $found = false;
        $args = array(
            'meta_query'     => array(
                array(
                    'key' => 'fb_post_id',
                    'value' => $fb_post_id,
                    'compare' => '=',
                ),
                array(
                    'key' => '_njt_fb_pr_enable',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
            'post_type' => self::$post_type,
            'orderby' => 'ID',
            'order'   => 'DESC',
            'posts_per_page' => 1,
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $found = get_the_id();
            }
        }
        wp_reset_postdata();
        return $found;
    }
    public static function checkIfPostEnabledNormalReplies($fb_post_id)
    {
        $found = false;
        $args = array(
            'meta_query'     => array(
                array(
                    'key' => 'fb_post_id',
                    'value' => $fb_post_id,
                    'compare' => '=',
                ),
                array(
                    'key' => '_njt_fb_normal_pr_enable',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
            'post_type' => self::$post_type,
            'orderby' => 'ID',
            'order'   => 'DESC',
            'posts_per_page' => 1,
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $found = get_the_id();
            }
        }
        wp_reset_postdata();
        return $found;
    }
    public static function deleteOldPosts($s_page_id)
    {
        $posts_from_db = get_posts(array(
            'post_type' => self::$post_type,
            'meta_key' => 's_page_id',
            'meta_value' => $s_page_id,
            'post_status' => 'any',
            'posts_per_page' => '-1',
        ));
        foreach ($posts_from_db as $k => $v) {
            wp_delete_post($v->ID, true);
        }
    }
    public static function isExists($fb_post_id, $s_page_id)
    {
        $posts_from_db = get_posts(array(
            'post_type' => self::$post_type,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'fb_post_id',
                    'value' => $fb_post_id,
                    'compare' => '=',
                ),
                array(
                    'key' => 's_page_id',
                    'value' => $s_page_id,
                    'compare' => '=',
                )
                
            ),
        ));
        return (count($posts_from_db) > 0);
    }
    public static function insert($args)
    {
        $arr = array(
            'post_content' => $args['mess'],
            'post_date' => $args['post_date'],
            'post_date_gmt' => $args['post_date'],
            'post_type' => self::$post_type,
            'post_title' => wp_trim_words($args['mess'], 200),
            'post_status' => 'publish'
        );
        if (get_option('njt_fb_pr_is_using_utf8encode', '0') == '1') {
            $arr['post_title'] = utf8_encode($arr['post_title']);
            $arr['post_content'] = utf8_encode($arr['post_content']);
        }
        
        
        $insert_id = wp_insert_post($arr);
        update_post_meta($insert_id, 'fb_post_id', $args['fb_post_id']);
        update_post_meta($insert_id, 'fb_page_id', $args['fb_page_id']);
        update_post_meta($insert_id, 's_page_id', $args['s_page_id']);
        update_post_meta($insert_id, '_fb_attachment', $args['_fb_attachment']);
        return $insert_id;
    }
    public static function getAllPosts($s_page_id = null)
    {
        $posts = array();
        $arr = array(
            'post_type' => self::$post_type,
            'posts_per_page' => -1,
        );
        if (!is_null($s_page_id)) {
            $arr['meta_key'] = 's_page_id';
            $arr['meta_value'] = $s_page_id;
        }
        $posts_from_db = get_posts($arr);
        foreach ($posts_from_db as $k => $v) {
            $post_id = $v->ID;
            $posts[] = (object)array(
                'id' => get_post_meta($post_id, 'fb_post_id', true),
                'message' => $v->post_content,
                'created_time' => date_i18n('Y-m-d H:i:s', strtotime($v->post_date)),
                'post_id' => $post_id,
            );
        }
        return $posts;
    }
    public static function findOldPostsWithSamePageId($fb_page_id, $s_page_id, $user_id, $return_count = false)
    {
        $posts_from_db = get_posts(array(
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'fb_page_id',
                    'value' => $fb_page_id,
                    'compare' => '=',
                ),
                array(
                    'key' => 's_page_id',
                    'value' => $s_page_id,
                    'compare' => '!=',
                )
            ),
            'post_type' => self::$post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ));
        if ($return_count === true) {
            return count($posts_from_db);
        } else {
            $posts = array();
            foreach ($posts_from_db as $k => $v) {
                $posts[] = (object)array(
                    'id' => get_post_meta($v->ID, 'fb_post_id', true),
                    'message' => $v->post_content,
                    'created_time' => date_i18n('Y-m-d H:i:s', strtotime($v->post_date)),
                    'post_id' => $v->ID,
                );
            }
            return $posts;
        }
    }
}
