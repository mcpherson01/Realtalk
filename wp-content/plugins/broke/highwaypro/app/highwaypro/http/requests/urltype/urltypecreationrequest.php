<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\UrlType;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;

Class UrlTypeCreationRequest extends Request
{
    public function map()
    {
        return [
            'urlType' => UrlType::fields()->except(['id'])->asArray(),
            'excluded' => [
                'urlType' => urlType::fields()->only(['id'])->asArray()
            ]
        ];
    }
}