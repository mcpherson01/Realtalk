<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;

Class DestinationTargetTable extends DatabaseTable
{
    const PARAMETERS_LENGTH = 1000;
    
    protected function name()
    {
        return strtolower(Env::id() . '_Destination_targets');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',              'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('destination_id',  'integer', 'NOT NULL'),
                         new DatabaseColumn('type',            'VARCHAR(250)', 'NOT NULL'),
                         new DatabaseColumn('parameters',      'VARCHAR('.SELF::PARAMETERS_LENGTH.')')
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