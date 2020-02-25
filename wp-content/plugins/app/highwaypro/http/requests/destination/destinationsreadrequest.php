<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Destination;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Characters\StringManager;

Class DestinationsReadRequest extends Request
{
    public function map()
    {
        return [
            'url' => Url::fields()->only(['id'])->asArray(),
        ];
    }

    public function createUrl()
    {
        return new Url($this->data->url->asArray());   
    }
}