<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Collections\JSONObjectsContainer;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;

Class UrlExtraSuccesses extends JSONObjectsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'success',
                'type' =>  'url_extra_save_success',
                'message' => 'Url Extra data saved.'
            ]
        ];
    }

    public static function getUrlExtra(UrlExtra $urlExtra, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'message' => 'UrlExtra Data Successfully Saved.',
            'urlExtra' => $urlExtra
        ]);
    }

    public static function getUrlExtras(Collection $urlExtras, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'message' => 'UrlExtra Data Successfully Read.',
            'urlExtras' => $urlExtras
        ]);
    }
}
