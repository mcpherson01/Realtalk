<?php
class NjtFbPrApi
{
    private $app_id;
    private $app_secret;
    private $ver = 'v2.8';

    public $fb_var;

    public function __construct()
    {
        $this->app_id = get_option('njt_fb_pr_fb_app_id', false);
        $this->app_secret = get_option('njt_fb_pr_fb_app_secret', false);

        $this->fbVar();
    }
    public function getAppID()
    {
        return isset($this->app_id) ? $this->app_id : "";
    }
    private function fbVar()
    {
        if ($this->app_id != false && $this->app_secret != false) {
            return $this->fb_var = new Facebook\Facebook(array(
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => $this->ver,
            ));
        }
    }
    public function getPostCountComment($post_id, $page_token)
    {
        $json = $this->cURL('https://graph.facebook.com/' . $this->ver . '/' . $post_id . '/comments?summary=1&access_token=' . $user_token);
        $json = json_decode($json);
        if (isset($json->summary)) {
            return (isset($json->summary->total_count) ? $json->summary->total_count : 0);
        } else {
            return 0;
        }
    }
    public function codeToToken($code, $redirect_uri)
    {

        $url = sprintf('https://graph.facebook.com/%5$s/oauth/access_token?client_id=%1$s&redirect_uri=%2$s&client_secret=%3$s&code=%4$s', $this->app_id, $redirect_uri, $this->app_secret, $code, $this->ver);
        $request = $this->cURL($url);
        $request = json_decode($request);
        return ((isset($request->access_token)) ? $request->access_token : $request);

    }
    public function getNewPosts($page_id, $page_token)
    {
        $limit = apply_filters('njt-fbpr-limit-get-posts', 50);
        //$url = sprintf('https://graph.facebook.com/%1$s/%2$s/posts?access_token=%3$s&limit=%4$s&fields=id,story,icon,message,created_time,full_picture,picture,likes,comments,is_published', $this->ver, $page_id, $page_token, $limit);
        $url = sprintf('https://graph.facebook.com/%1$s/%2$s/posts?access_token=%3$s&limit=%4$s&fields=id,icon,message,created_time,full_picture,picture', $this->ver, $page_id, $page_token, $limit);
        $posts = $this->cURL($url);
        return json_decode($posts);
    }
    public function getNewPostsByUrl($url)
    {
        $posts = $this->cURL($url);
        return json_decode($posts);
    }
    public function generateLoginUrl($redirect_uri, $permissions = array())
    {
        // (#200) If posting to a group, requires app being installed in the group, and \
        // either publish_to_groups permission with user token, or both manage_pages \
        // and publish_pages permission with page token; If posting to a page, \
        // requires both manage_pages and publish_pages as an admin with \
        // sufficient administrative permission
        if (empty($permissions)) {
            $permissions = array('email', 'manage_pages', 'public_profile', 'pages_messaging', 'publish_pages'); //publish_actions,  'read_page_mailboxes', 'publish_pages'
        }

        $helper = $this->fb_var->getRedirectLoginHelper();

        return $helper->getLoginUrl($redirect_uri, $permissions);
    }

    public function getAllPages($user_token)
    {
        $pages = array();
        if (!is_null($user_token)) {
            $json = $this->cURL('https://graph.facebook.com/' . $this->ver . '/me/accounts?access_token=' . $user_token . '&limit=10000');
            $json = json_decode($json);

            foreach ($json->data as $k => $page) {
                $pages[] = array(
                    'category' => $page->category,
                    'name' => $page->name,
                    'id' => $page->id,
                    'access_token' => $page->access_token,
                );
            }
        }
        return $pages;
    }

    /**
     * Add new post to page
     * 
     * We need: manage_pages, publish_pages. And app must be in development mode
     */
    public function newPost($message, $page_id, $page_token) {
        $url = sprintf('https://graph.facebook.com/%1$s/%2$s/feed', $this->ver, $page_id);
        $post = json_encode(array(
            'access_token' => $page_token,
            'message' => $message,
        ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post),
        )
        );
        $result = curl_exec($ch);
        return json_decode($result);
    }
    public function getAppAccessToken()
    {
        $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $this->app_id . "&client_secret=" . $this->app_secret . "&grant_type=client_credentials";
        $app_token = $this->cURL($token_url);
        $app_token = json_decode($app_token);
        return (isset($app_token->access_token) ? $app_token->access_token : '');
    }
    public function subscribeAppToPage($page_token)
    {
        /*
        $url = 'https://graph.facebook.com/'.$this->ver.'/me/subscribed_apps';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'access_token=' . $page_token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : true);
         */
        $url = 'https://graph.facebook.com/' . $this->ver . '/me/subscribed_apps';
        $post = [
            "subscribed_fields" => array("messaging_postbacks", "messaging_optins", "messages", "message_deliveries", "message_reads", "messaging_referrals", "feed"),
            'access_token' => $page_token,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : true);
    }
    public function deleteSubscribe($page_id, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $page_id . '/subscribed_apps';
        $data = 'access_token=' . $page_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return $result;
    }
    /*
     * create new Webhooks subscriptions
     * @var $token string: app access token
     */
    public function addPageWebhooks($callback_url)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $this->app_id . "/subscriptions";
        $fields = 'messages, messaging_optins, messaging_postbacks, feed';

        $post = "access_token=" . $this->getAppAccessToken() . "&object=page&callback_url=" . $callback_url . "&fields=" . $fields . "&verify_token=" . get_option('njt_fb_pr_fb_verify_token');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return $str;
    }

    /*
     * Delete page subscriptions using this operation:
     */
    public function deletePageWebhooks()
    {
        global $app_id, $app_secret;

        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $this->app_id . '/subscriptions';
        $post = "access_token=" . $this->getAppAccessToken() . "&object=page";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    public function sendMessenger($to, $text, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/me/messages?access_token=' . $page_token;
        $post = json_encode(array(
            'recipient' => array('id' => $to),
            'message' => array('text' => $text),
        ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post),
        )
        );
        $result = curl_exec($ch);
        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : 'sent');
    }
    public function getSenderInfo($sender_id, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $sender_id . '?access_token=' . $page_token . '&format=json';
        $info = $this->cURL($url);
        return json_decode($info);
    }
    public function privateReply($comment_id, $message, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/me/messages?access_token=' . $page_token;
        $data = json_encode(array(
            'recipient' => array('comment_id' => $comment_id),
            'message' => array("text" => $message),
        ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function ReplyMessenger($comment_id, $message, $page_token)
    {

        $url = "https://graph.facebook.com/" . $this->ver . "/me/messages";
        $post = [
            "recipient" => array("id" => $comment_id),
            "message" => array("text" => $message),
            "access_token" => $page_token,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return json_decode($str);
    }
    /**
     * Publish a comment to a post, or a comment
     *
     * @param  Interger $object_id  The post's id or comment's id
     * @param  String $message    The comment's content
     * @param  String $page_token The page token, required : 'manage_pages', 'publish_actions', 'publish_pages'
     * @return Object             The result, like : {"id": "1716067775351111_1718920035222569"}
     */
    public function postComment($object_id, $message, $page_token)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $object_id . "/comments";
        $post = 'access_token=' . $page_token . '&' . $message;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);

        return json_decode($str);
    }

    public function likeComment($object_id, $page_token)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $object_id . "/likes";
        $post = 'access_token=' . $page_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);

        return json_decode($str);
    }

    public function hideComment($object_id, $page_token)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $object_id;
        $post = 'access_token=' . $page_token . '&is_hidden=true';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return json_decode($str);
    }

    public function getComments($object_id, $page_token = null)
    {
        if (filter_var($object_id, FILTER_VALIDATE_URL)) {
            $url = $object_id;
        } else {
            $url = "https://graph.facebook.com/" . $this->ver . "/" . $object_id . "/comments/?access_token=" . $page_token;
        }
        $comments = $this->cURL($url);
        return json_decode($comments);
    }

    /**
     * Deletes a comment
     *
     * @param  String $comment_id Comment ID
     * @param  String $page_token Page Access Token
     *
     * @return Object
     */

    public function deleteComment($comment_id, $page_token)
    {
        $url = 'https://graph.facebook.com/' . $this->ver . '/' . $comment_id;
        $post = 'access_token=' . $page_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Find a post on page with post id
     *
     * @param  Interger $post_id    The id of the post, eg: 1712269452398294
     * @param  String $page_token The page token
     *
     * @return Object
     */

    public function findFBPost($post_id, $page_token)
    {
        $url = "https://graph.facebook.com/" . $this->ver . "/" . $post_id . "?access_token=" . $page_token;
        $request = $this->cURL($url);
        $request = json_decode($request);

        return $request; /* {created_time, name, id} */
    }

    /**
     * Get my information
     *
     * @param  String $user_token
     * @return Object
     */

    public function getUserInfo($user_token)
    {
        return json_decode($this->cURL('https://graph.facebook.com/me?access_token=' . $user_token));
        // {'id' => '782197764823'}
    }

    public function cURL($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);

        return $return;
    }
}
