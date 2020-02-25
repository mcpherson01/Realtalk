<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Url;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Characters\StringManager;

Class UrlCreationRequest extends Request
{
    public function map()
    {
        return [
            'url' => Url::fields()->except(['id', 'date_added'])->asArray(),
            'excluded' => [
                'url' => Url::fields()->only(['id'])->asArray()
            ]
        ];
    }
}