<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Url;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Mapper\Types;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlsReadRequest extends Request
{
    public function map()
    {
        return [
            'filters' => [
                'urlType' => UrlType::fields()->only(['id'])->asArray(),

                // CURRENTLY, ONLY THE NAME AND LIMIT FILTERS ARE SUPPORTED SEPARATELY
                // THERE ARE TWO OPTIONS: ONE REQUEST ONLY WITH TYPE_ID
                // OR ANOTHER WITH NAME AND LIMIT
                // THIS MAY BE EXPANED IN THE FUTURE BUT IT IS NOW BEING LEFT LIKE THIS
                // AS A FULL SUPPORT IS NOT NEEDED CURRENTLY AND WE NEED AN MVP FIRST

                             // name is LIKE%, not =
                'url'     => Url::fields()->only(['name'])->asArray(),
                // AS SAID ABOVE, LIMIT DOES NOT WORK ALONE, IT NEEDS A NAME
                'limit'   => Types::INTEGER
            ]
        ];
    }

    public function hasTypeIdFilter()
    {
        return $this->data->filters->mapFieldsFoundInSource->contain('urlType');   
    }

    public function hasName()
    {
        return $this->data->filters->url->mapFieldsFoundInSource->contain('name') 
                  && 
               $this->data->filters->url->name->get();   
    }
}