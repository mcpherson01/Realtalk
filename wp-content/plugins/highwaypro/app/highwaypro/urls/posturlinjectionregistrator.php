<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\Data\Model\Posts\Post;

Class PostUrlInjectionRegistrator
{
    protected $post;

    public function __construct($post)
    {
        if ($post instanceof Post) {
            $this->post = $post;
            $this->register();
        }   
    }

    protected function register()
    {
        if ($this->post->sholdInjectKeywordUrls()) {
            add_filter('the_content', [$this->post, 'injectUrlsToContent']);
        }   
    }
}