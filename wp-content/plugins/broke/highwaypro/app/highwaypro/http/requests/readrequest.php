<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighwayPro\Original\Collections\Mapper\Types;

Class ReadRequest extends Request
{
    public function map()
    {
        return [
            'id' => Types::INTEGER
        ];
    }
}