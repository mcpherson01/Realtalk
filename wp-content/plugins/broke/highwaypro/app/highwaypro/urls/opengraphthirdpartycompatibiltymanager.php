<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\Mapper\Types;

Class OpenGraphThirdPartyCompatibiltyManager
{
    public static function getFilters() 
    {
        return [
            'yoast' => [
                'filter' => 'wpseo_opengraph_url',
                'returnType' => Types::STRING
            ],
            'allInOne' => [
                'filter' => 'aiosp_opengraph_meta',
                'returnType' => Types::STRING
            ],
            'jetPack' => [
                'filter' => 'jetpack_open_graph_tags',
                'returnType' => Types::COLLECTION
            ]
        ];
    }

    protected static function methods()
    {
        return new Collection([
            'setUrlString' => Types::STRING,
            'setUrlArray' => Types::COLLECTION
        ]);
    }

    public function __construct(Array $filters, $post)
    {
        if (($post instanceof Post) && $post->needsShortUrlForOG()) {
            $this->post = $post;

            if ($this->aSupportedThirdPartyPluginIsActive()) {
                $this->registerOgMetaFilters($filters);
            } else {
                $this->addOgMetaManually();
            }
        }
    }

    public function getMethod($returnType)
    {
        return self::methods()->search($returnType);
    }

    public function setUrlString($oldUrl)
    {
        return $this->getUrl();
    }

    public function setUrlArray(Array $meta)
    {
        $meta['og:url'] = $this->getUrl();

        return $meta;
    }

    public function getUrl()
    {
        return $this->post->getUrlsFromMeta()->first()->getFullUrl();
    }

    public function aSupportedThirdPartyPluginIsActive()
    {
        return ($this->pluginIsActive('yoast')) ||
               ($this->pluginIsActive('allInOne')) || 
               ($this->pluginIsActive('jetpack'));

    }

    protected function registerOgMetaFilters(Array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter['filter'], [$this, $this->getMethod($filter['returnType'])]);
        }   
    }

    protected function addOgMetaManually()
    {
        add_action(
            'wp_head',
            [
                $this, 
                'printMetaTag'
            ]
       );  
    }

    public function printMetaTag()
    {
        print "<meta property=\"og:url\" content=\"{$this->getUrl()}\" />";
    }

    public function pluginIsActive($pluginName)
    {
        switch (strtolower($pluginName)) {
            case 'yoast':
                return defined('WPSEO_VERSION');
                break;
            case 'allinone':
                return defined('AIOSEOP_VERSION');
                break;
            case 'jetpack':
                return class_exists('Jetpack') && \Jetpack::is_active();
                break;
            
            default:
                return false;
                break;
        }
    }
    protected function addFilter($name, $handler)
    {
        add_filter($name, $handler);
    }
}