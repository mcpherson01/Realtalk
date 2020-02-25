<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;

Class DestinationTable extends DatabaseTable
{
    protected function name()
    {
        return strtolower(Env::id() . '_Destinations');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',         'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('url_id',         'integer', 'NOT NULL'),
                         new DatabaseColumn('position',         'integer'),
                         new DatabaseColumn('date',         'TIMESTAMP', 'DEFAULT CURRENT_TIMESTAMP'),
        ];
    }

    protected function changes()
    {
        return [
            'transforms' => [
                //[
                //    'from' => new DatabaseColumn('id',         'integer'),
                //    'to' => new DatabaseColumn('identifier',         'integer'),
                //]
            ],
            'additions' => [
            ],
            'deductions' => [
            ]
        ];
    }
}