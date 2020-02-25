<?php

namespace HighWayPro\App\Data\Schema;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Environment\Env;

Class UrlViewTable extends DatabaseTable
{
    protected function name()
    {
        return strtolower(Env::id() . '_url_views');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',              'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
                         new DatabaseColumn('destination_id',  'integer', 'NOT NULL'),
                         new DatabaseColumn('device_type',  "VARCHAR(50)"),
                         new DatabaseColumn('device_name',  "VARCHAR(60)"),
                         new DatabaseColumn('device_os',  "VARCHAR(60)"),
                         new DatabaseColumn('device_browser',  "VARCHAR(60)"),
                         new DatabaseColumn('device_browser_version',  "VARCHAR(20)"),
                         new DatabaseColumn('device_user_agent',  "VARCHAR(250)"),
                         new DatabaseColumn('device_referer',  "VARCHAR(150)"),
                         new DatabaseColumn('location_country',  "VARCHAR(50)"),
                         new DatabaseColumn('location_continent',  "VARCHAR(50)"),
                         new DatabaseColumn('location_language',  "VARCHAR(20)"),
                         new DatabaseColumn('date',  'DATETIME')
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