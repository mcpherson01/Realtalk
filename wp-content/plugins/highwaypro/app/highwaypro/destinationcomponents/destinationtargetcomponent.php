<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Abstract Class DestinationTargetComponent extends DestinationComponent
{
    const type = 'targets';
    const event = 'plugins_loaded';

    abstract public function response();

    public static function description()
    {
        return __('The final location the short URL should redirect to.', Env::textDomain());
    }

    protected function getUrl($url)
    {
        if ($this->parameters->queryString->hasValue()) {

            (string) $queryString = ($this->parameters->queryString[0] === '?')? substr($this->parameters->queryString, 1) : $this->parameters->queryString;

            $url = add_query_arg(
                (new Collection(explode('&', $queryString)))->mapWithKeys(function($value, $key) {
                    list($key, $value) = explode('=', $value);
                    return [
                        'key' => $key,
                        'value' => urlencode($value)
                    ];
                })->asArray(),
                $url
            );
        }

        return $url;
    }
}