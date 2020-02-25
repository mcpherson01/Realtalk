<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\HighWayPro\Shortcodes\URLShortcode;
use HighWayPro\Original\Cache\MemoryCache;
use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtraGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\Original\Characters\StringManager as Stri;

Class KeywordsManager
{
    protected $keywords;

    public static function createFromPostType($postType, UrlExtraGateway $urlExtraGateway = null)
    {
        if (is_null($urlExtraGateway)) {
            $urlExtraGateway = new UrlExtraGateway(new WordPressDatabaseDriver);
        }

        (object) $keywords = $urlExtraGateway->getInjectionKeywordsForPostType($postType); 

        return new Self($keywords);  
    }

    public function __construct(Collection $keywords)
    {
        $this->keywords = $this->explodeComaSeparatedKeywords($keywords);
        $this->cache    = new MemoryCache;
    }

    public function injectUrlsToContent($content)
    {
        foreach($this->getSorted()->asArray() as $keyword) {
            (object) $url = $this->getUrl($keyword);

            if (!($url instanceof Url)) return $content;
            if (!$url->getInjectionPostTypesAllowed()->containEither([get_post_type(), 'all'])) return $content;
            
            $content = preg_replace_callback(
                $this->getRegexPattern($keyword), 
                function(Array $matches) use ($keyword, $url) {
                    return (
                        new URLShortcode(
                            [
                                'url_id' => $url->id
                            ],
                            $text = $matches[0]
                        )
                    )->render();
                }, 
                $content,
                $limit = $url->getInjectionLimit()
            );
        }   

        return $content;
    }

    protected function getRegexPattern(UrlExtra $keyword)
    {
        return "/<a[^>]*>(?:[a-zA-Z0-9\s'\-\.,]|(?:<(.*)>.*<\/\1>))*<\/a>(*SKIP)(*FAIL)|\b({$keyword->value})\b(?=[^>]*(?:<|$))/i";   
    }

    public function getUrl(UrlExtra $urlExtra)
    {
        return $this->cache->getIfExists($urlExtra->url_id)->otherwise(function() use ($urlExtra) {
            (object) $url = (new UrlGateway(new WordPressDatabaseDriver))
                            ->getWithId($urlExtra->url_id);

            return $url;
        });
    }

    public function getSorted()
    {
        return $this->getValidKeywords()->sort(function(UrlExtra $firstElement, UrlExtra $secondElement) {
            (object) $firstElementKeys = (new Stri($firstElement->value))->explode(' ');
            (object) $secondElementKeys = (new Stri($secondElement->value))->explode(' ');

            if ($secondElementKeys->haveMoreThan($firstElementKeys->count())) {
                return 1;
            } elseif ($secondElementKeys->haveLessThan($firstElementKeys->count())) {
                return -1;
            } else {
                return 0;
            }
        });
    }

    public function getValidKeywords()
    {
        return $this->keywords->filter(function(UrlExtra $keyword){
            return Stri::create($keyword->value)->trim()->length() > 0;
        });   
    }
    

    public function getSingleWordKeywords()
    {
        return $this->keywords->filter(function(UrlExtra $keyword) {
            return count(explode(' ', $keyword->value)) === 1;
        });
    }

    public function getMultiWordKeywords()
    {
        return $this->keywords->filter(function(UrlExtra $keyword) {
            return count(explode(' ', $keyword->value)) > 1;
        });
    }

    protected function explodeComaSeparatedKeywords(Collection $keywords)
    {
        (object) $allExlodedKeywords = new Collection([]);

        foreach ($keywords->asArray() as /*UrlExtra*/ $keyword) {
            // let's keep the references for unit testing purposes...
            if ($keyword->value->contains(',')) {
                (object) $explodedKeywords = $keyword->value->explode(',')->map(function(StringManager $keywordString) use ($keyword) {
                    return new UrlExtra(
                        array_merge(
                            $keyword->getAvailableValues(),
                            ['value' => $keywordString->trim()]
                        )
                    );
                });
            } else {
                (object) $explodedKeywords = new Collection([$keyword]);
            }

            $allExlodedKeywords = $allExlodedKeywords->merge($explodedKeywords);
        }

        return $allExlodedKeywords;
    }
    
}
