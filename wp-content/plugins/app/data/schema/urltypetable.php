<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;

Class UrlTypeTable extends DatabaseTable
{
    protected function name()
    {
        return strtolower(Env::id() . '_Url_types');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',         'int(11)', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('name',         'VARCHAR(100)', 'NOT NULL UNIQUE'),
                         new DatabaseColumn('base_path',         'VARCHAR(100)', 'DEFAULT NULL UNIQUE'),
                         new DatabaseColumn('color',         'VARCHAR(70)'),
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