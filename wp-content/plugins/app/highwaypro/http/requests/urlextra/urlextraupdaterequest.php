<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Mapper\Types;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlExtraUpdateRequest extends Request
{
    public function map()
    {
        return [
            'url' => Url::fields()->only(['id'])->asArray(),
            'urlExtra' => UrlExtra::fields()->only(['value'])->asArray(),
            'fieldToUpdate' => Types::STRING
        ];
    }    
}