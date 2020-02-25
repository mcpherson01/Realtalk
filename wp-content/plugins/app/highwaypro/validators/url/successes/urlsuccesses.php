<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class UrlSuccesses extends JSONObjectsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'success',
                'type' =>  'url_delete_success',
                'message' => 'This resource has been permanently deleted.'
            ]
        ];
    }

    public static function getUrl(Url $url, $type, $message = 'URL successfully created.')
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'message' => $message,
            'url' => static::urlWithFinalUrl($url)
        ]);
    }

    public static function geUpdatedUrl(Url $url, $type, $field)
    {
        return static::getUrl($url, $type, $message = "URL {$field} successfully updated.");   
    }

    public static function getUrls(Collection $urls, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'urls' => $urls->map(function(Url $url) {
                return static::urlWithFinalUrl($url);
            })
        ]);
    }

    protected static function urlWithFinalUrl(Url $url)
    {
        return array_merge(
            $url->getAvailableValues(),
            [
                'finalUrl' => $url->getFullUrl()
            ]
        );   
    }
    
}
