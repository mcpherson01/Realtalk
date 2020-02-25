<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;

Class UrlTable extends DatabaseTable
{
    protected function name()
    {
        return strtolower(Env::id() . '_urls');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',         'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('path',       'varchar(100)', 'NOT NULL UNIQUE'),
                         new DatabaseColumn('name',       'varchar(190)'),
                         new DatabaseColumn('date_added', 'datetime'),
                         new DatabaseColumn('type_id', 'integer'),
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
                //new DatabaseColumn('name',       'type'),
                new DatabaseColumn('date_added', 'datetime'),
                new DatabaseColumn('date_added_new', 'datetime'),
                new DatabaseColumn('type_id', 'integer'),
            ],
            'deductions' => [
                //new DatabaseColumn('date_added', 'datetime'),
                //new DatabaseColumn('name',         'type'),
            ]
        ];
    }
}