<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Url;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Characters\StringManager;
use HighwayPro\Original\Collections\Mapper\Types;

Class UrlUpdateRequest extends Request
{
    public function map()
    {
        return [
            'url' => Url::fields()->asArray(),
            'fieldToUpdate' => Types::STRING
        ];
    }

    public function getDataToUpdate()
    {
        (string) $fieldToUpdate = $this->data->fieldToUpdate->get();
        
        return new Collection([
            'id' => $this->data->url->id,
            $fieldToUpdate => (string) $this->data->url->{$fieldToUpdate}
        ]);   
    }
    
}