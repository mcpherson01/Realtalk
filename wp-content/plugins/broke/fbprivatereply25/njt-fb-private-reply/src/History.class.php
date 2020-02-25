<?php
class NjtFbPrHistory {
    public static function insert($args)
    {
        $fb_post_wpid = $args['fb_post_wpid'];
        unset($args['fb_post_wpid']);

        $args['post_type'] = 'njt_fb_histories';
        $args['post_status'] = 'publish';

        $id = wp_insert_post($args);
        update_post_meta($id, 'fb_post_wpid', $fb_post_wpid);
        return $id;
    }
    public static function getHistory($fb_post_wpid)
    {
        $posts = get_posts(array(
            'post_type' => 'njt_fb_histories',
            'post_status' => 'any',
            'posts_per_page' => '-1',
            'meta_query' => array(
                array(
                    'key'     => 'fb_post_wpid',
                    'value'   => $fb_post_wpid,
                    'compare' => '=',
                ),
            ),
        ));
        $histories = array();
        foreach ($posts as $k => $v) {
            $histories[] = maybe_unserialize($v->post_content);
        }
        /*exit();
        
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $histories[] = maybe_unserialize(get_the_content());
            }
        }
        wp_reset_postdata();*/
        return $histories;
    }
}
