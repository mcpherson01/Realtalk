<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\Components\ShortUrlMetaBoxComponent;
use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;

Class PostMetaHanlder extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 2;

    public function execute()
    {
        add_action("add_meta_boxes_post", $this->dispatcher('addShortUrlMetaBox'), 2);       

        add_action("save_post", $this->dispatcher('saveShortUrl'), 10, 3);
    }

    public function addShortUrlMetaBox($post)
    {
        add_meta_box(
            $id = 'highwaypro_post_short_url_meta_box', 
            $titile = "HighWayPro ".__('Short URL', Env::textDomain()), 
            $handler = $this->dispatcher('addShortUrlMetaBoxRenderer'), 
            $screen = "post", 
            $context = "side", 
            $priority = "high",
            $handlerArguments = [$post]
        );
    }
 
    public function addShortUrlMetaBoxRenderer($post = null)
    {
        $post = is_object($post)? Post::fromPostObject($post) : Post::fromCurentRequest();

        (object) $shortUrlMetaBoxComponent = new ShortUrlMetaBoxComponent($post);


        $shortUrlMetaBoxComponent->render();
    }

    public function saveShortUrl($postId, $post)
    {
        if (!isset($_POST["hwpro_save_url_nonce"]) || !wp_verify_nonce($_POST["hwpro_save_url_nonce"], 'hwpro_save_url')) {
            return;
        }

        if (!current_user_can("edit_post", $postId)) {
            return;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return;
        }

        if ($post->post_type !== 'post') {
            return;
        }


        if (isset($_POST["hwpro-url-path"])) {
            (object) $postModel = Post::fromPostObject($post);

            $postModel->saveUrlPath(sanitize_text_field($_POST["hwpro-url-path"]));
        }   

    }  
}