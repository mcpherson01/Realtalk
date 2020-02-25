<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class UrlTypeSuccesses extends JSONObjectsContainer
{
    public static function getUrlType(UrlType $urlType, $type, $message = 'Success')
    {
        return new Collection([
            'state' => 'success',
            'message' => $message,
            'type' =>  $type,
            'urlType' => $urlType->getAvailableValues()
        ]);
    }

    public static function getUrlTypes(Collection $urlTypes, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'urlTypes' => $urlTypes
        ]);
    }
}