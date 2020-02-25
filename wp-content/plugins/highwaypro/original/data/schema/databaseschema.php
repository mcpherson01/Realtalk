<?php

namespace HighWayPro\Original\Data\Schema;

use HighWayPro\Original\Data\Drivers\DatabaseDriver;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use HighWayPro\Original\Utilities\TypeChecker;
use HighWayPro\Original\Utilities\className;

Class DatabaseSchema
{
    use className;
    use TypeChecker;

    protected $driver;
    protected $tables;

    public function __construct(DatabaseDriver $driver)
    {
        $this->driver = $driver;
        $this->tables = $this->expectEach($this->tables())->toBe(DatabaseTable::class);
    }

    public function install()
    {
        $this->applyToEach($this->tables, 'install');
    }

    public function update()
    {
        $this->applyToEach($this->tables, 'update');
    }

    public function uninstall()
    {
        $this->applyToEach($this->tables, 'uninstall');
    }

    public function reinstall()
    {
        $this->uninstall();
        $this->install();
    }

    protected function applyToEach(array $tables, $action)
    {
        foreach ($tables as $table) {
            $this->driver->{$action}($table);
        }
    }
}