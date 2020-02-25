<?php

namespace HighWayPro\App\Components;

use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\Original\Cache\MemoryCache;
use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Presentation\Component;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class ShortUrlMetaBoxComponent extends Component
{
    protected $file = 'shortUrlMetaBoxComponent.php';

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->urlGateway = new UrlGateway(new WordPressDatabaseDriver);
        $this->cache = new MemoryCache;
    }

    public function getPost()
    {
        return $this->post;   
    }
    

    public function getUrlId()
    {
        $url = $this->post->getUrl();

        return $url? $url->id : 0;
    }
    
    
    public function getPath()
    {
        return $this->cache->getIfExists('path')->otherwise(function(){
            if ($this->post->hasShortUrlsFromMeta()) {
                return ltrim((string) $this->post->getUrl()->getPath(), '/');
            }

            return $this->urlGateway->findNewRandomPath();
        });
    }

    public function getBasePath()
    {
        $postType = $this->post->getPostTypeUrl();

        return $postType? S::create($postType->base_path)->ensureLeft('/')->ensureRight('/')->get() : '/';   
    }
    

    public function getFullUrlWithBase()
    {
        $postType = $this->post->getPostTypeUrl();

        return get_site_url(
            $id = null, 
            $path = $this->getBasePath()
        );   
    }
          
}