<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\UrlType;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\Original\Collections\Mapper\Types;

Class UrlTypeUpdateRequest extends Request
{
    public function map()
    {
        return [
            'urlType' => UrlType::fields()->asArray(),
            'fieldToUpdate' => Types::STRING
        ];
    }

    public function getDataToUpdate()
    {
        (string) $fieldToUpdate = $this->data->fieldToUpdate->get();
        /*(mixed)*/$data = $this->data->urlType->{$fieldToUpdate};

        return new Collection([
            'id' => $this->data->urlType->id,
            $fieldToUpdate => (((string) $data) == ''? null : $data)
        ]);
    }
    
}