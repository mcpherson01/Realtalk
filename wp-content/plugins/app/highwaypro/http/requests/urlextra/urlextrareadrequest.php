<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlExtraReadRequest extends Request
{
    public function map()
    {
        return [
            'url' => Url::fields()->only(['id'])->asArray()
        ];
    }

    public function hasUrlObject()
    {
        return $this->data->mapFieldsFoundInSource->contain('url');   
    }

    public function hasUrlId()
    {
        return $this->hasUrlObject() &&
               $this->data->url->mapFieldsFoundInSource->contain('id');
    }
}