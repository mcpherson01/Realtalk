<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseColumn\DatabaseColumnDefaultString as DefaultString;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;


Class UrlExtraTable extends DatabaseTable
{
    protected function name()
    {
        return strtolower(Env::id() . '_Url_Extra');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id', 'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('url_id', 'integer', 'NOT NULL'),
                         new DatabaseColumn('name', 'VARCHAR(250)', 'NOT NULL'),
                         new DatabaseColumn('value', 'VARCHAR(250)'),
                         new DatabaseColumn('type', 'VARCHAR(100)'),
                         new DatabaseColumn('context', 'VARCHAR(250)', new DefaultString(UrlExtra::DEFAULT_CONTEXT)),
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