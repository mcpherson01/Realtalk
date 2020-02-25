<?php

namespace HighWayPro\App\Data\Model\Posts;

use HighWayPro\App\Data\Model\Posts\PostMetaFinder;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\DatabaseDriver;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Domain;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtraGateway;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use Highwaypro\App\Data\Model\Preferences\Preferences;
use Highwaypro\app\highWayPro\urls\KeywordsManager;
use Highwaypro\app\highWayPro\urls\PlaceHoldersParser;

Class Post extends Domain
{
    protected $metaFinder;
    protected $urlsFromMeta;

    public static function fromPostObject($wp_post)
    {
        return (new Static((array) $wp_post));   
    }

    public static function fromCurentRequest()
    {
        if (!isset($GLOBALS['post'])) return;
        
        return new Static((array) $GLOBALS['post']);
    }

    public static function getWithId($id)
    {
        (array) $post = get_post($id, $format = ARRAY_A);

        if ($post) {
            return new Static($post);  
        }
    }

    protected function setUp()
    {
        $this->metaFinder = new PostMetaFinder($this->ID);
        $this->urlGateway = (new UrlGateway(new WordPressDatabaseDriver));
        $this->urlTypeGateway = new UrlTypeGateway(new WordPressDatabaseDriver);
    }

    /**
     * Takes a path, creates a new url if post has none or updates the existing url path
     * if the path is different than this post's url path.
     * @param  String $path 
     */
    public function saveUrlPath($path)
    {
        if (!$this->hasShortUrlsFromMeta()) {
            try {
                (integer) $newUrlId = $this->urlGateway->createShorturlForPostWithComponents(
                    new Url([
                        'path'       => UrlGateway::ensurePathFormat($path),
                        'name'       => $this->post_title,
                        'date_added' => DatabaseDriver::getCurrentDate(),
                        'type_id'    => $this->getPostUrlTypeId()
                    ]),
                    $this
                );

                update_post_meta(
                    $this->ID, 
                    $this->getFullMetaName('og_url_id'), 
                    $newUrlId
                );
            } catch (\Exception $exception) {
               throw $exception;
            }
        } else {
            (object) $url = $this->getUrl();

            if (!$url->hasPath($path)) {
                if ($url->id) {
                    $this->urlGateway->update([
                        'id' => $url->id,
                        'path' => UrlGateway::ensurePathFormat($path)
                    ]);
                }
            }
        }
    }

    public function getPostUrlTypeId()
    {
        return Preferences::get()->preferences
                                 ->url
                                 ->preferences
                                 ->postUrl_UrlType;
    }

    public function getPostTypeUrl()
    {
        if ($this->getPostUrlTypeId()) {
            return $this->urlTypeGateway->getWithId($this->getPostUrlTypeId())->first();
        }
    }
    
    public function canCreateShortUrl()
    {
        return $this->createNewUrlsIsEnabled() && !$this->hasShortUrlsFromMeta();
    }

    public function createNewUrlsIsEnabled()
    {
        return Preferences::get()->preferences
                                 ->url
                                 ->preferences
                                 ->generateUrlsOnNewPosts_isEnabled;
    }
    
    
    /**
     * The difference between this method and self::hasShortUrlsFromMeta() is
     * this method avoids making the JOIN query if post has no url defined in its meta 
     */
    public function hasShortUrl()
    {          
        return $this->ogUrlIsEnabled() && 
               $this->hasShortUrlsFromMeta();
    }

    public function hasShortUrlsFromMeta()
    {
        return $this->getUrlsFromMeta()->haveAny();
    }

    public function getUrl()
    {
        return $this->getUrlsFromMeta()->first();   
    }
    

    public function getUrlsFromMeta()
    {
        if (!($this->urlsFromMeta instanceof Collection)) {
            (integer) $urlId = $this->getOwnMeta('og_url_id')->getNumber();
            $this->urlsFromMeta = $this->urlGateway->getFromPostTargetWithPostId($this->ID)
                                                  ->filter(function($url) use ($urlId) {
                                                      return ((integer) $url->id) === 
                                                             ((integer) $urlId);
                                                  }); 
        }

        return $this->urlsFromMeta;
    }

    public function needsShortUrlForOG()
    {
        return $this->ogUrlIsEnabled() && 
               $this->postTypeHasOgUrlEnabled() && 
               $this->hasShortUrl();
    }

    public function ogUrlIsEnabled()
    {

        /*
            COMING SOON...
         (object) $ogUrlMeta = $this->getOwnMeta('og_url_is_enabled');

        if ($ogUrlMeta->hasValue()) {
            return $ogUrlMeta->isEnabled();
        }*/   

        return Preferences::get()->preferences->social->preferences->og_url_is_enabled;
    }

    public function postTypeHasOgUrlEnabled()
    {
        return $this->post_type === 'post';
        /* coming soon version 1.1
        return Preferences::get()->preferences
                                 ->social
                                 ->preferences
                                 ->og_url_post_types_enabled
                                 ->contain($this->post_type);*/
    }

    public function sholdInjectKeywordUrls()
    {
        return $this->typeAllowsUrlInjection() &&
               $this->urlInjectionIsEnabled();   
    }

    public function typeAllowsUrlInjection()
    {
        return Preferences::get()->preferences
                                 ->post
                                 ->preferences
                                 ->keyword_injection_post_types_enabled
                                 ->contain($this->post_type);   
    }

    public function urlInjectionIsEnabled()
    {
        (object) $urlInjectionMeta = $this->getOwnMeta('keyword_injection_is_enabled');

        if ($urlInjectionMeta->hasValue()) {
            return $urlInjectionMeta->isEnabled();
        }   

        return Preferences::get()->preferences->post->preferences->keyword_injection_is_enabled;
    }

    public function injectUrlsToContent($content)
    {
        if (is_string($content)) {
            
            (object) $keywordsManager = KeywordsManager::createFromPostType($this->post_type);

            $content = $keywordsManager->injectUrlsToContent($content);
        }

        return $content;
    }

    public function replacePlaceholdersWithShortcodes($content)
    {
        (object) $placeholdersParser = new PlaceHoldersParser($content);

        (string) $contentWithPlaceholdersReplaced = $placeholdersParser->getParsed();

        return $contentWithPlaceholdersReplaced;   
    }
    

    public function getOwnMeta($name)
    {
        return $this->getMeta($this->getFullMetaName($name));   
    }

    public function getFullMetaName($unprefixedName)
    {
        return Env::idLowerCase()."_{$unprefixedName}";   
    }
    

    public function getMeta($name)
    {
        return $this->metaFinder->getWithKey($name);
    }

}
