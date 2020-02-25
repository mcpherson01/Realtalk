<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\App\Data\Schema\DestinationConditionTable;
use HighWayPro\App\Data\Schema\DestinationTable;
use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\App\Data\Schema\UrlExtraTable;
use HighWayPro\App\Data\Schema\UrlTable;
use HighWayPro\App\Data\Schema\UrlTypeTable;
use HighWayPro\App\Data\Schema\UrlViewTable;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Schema\DatabaseSchema;
use HighWayPro\Original\Environment\Env;

Class ApplicationDatabase extends DatabaseSchema
{
    protected function tables()
    {
        return [
            new UrlTable, 
            new DestinationTable,
            new DestinationConditionTable,
            new DestinationTargetTable,
            new UrlTypeTable,
            new UrlViewTable,
            new UrlExtraTable
        ];
    }
}