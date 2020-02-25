<?php

namespace HighWayPro\Original\Data\Drivers;

use HighWayPro\Original\Data\Schema\DatabaseColumn;
use HighWayPro\Original\Data\Schema\DatabaseCredentials;
use HighWayPro\Original\Data\Schema\DatabaseTable;
use PDOStatement;

Abstract Class DatabaseDriver
{
    protected $credentials;
    
    abstract protected function setConnection();

    abstract public function execute($statement, $parameters = []);
    abstract public function get($statement, $parameters = []);
    abstract protected function shouldFetch($statement = null);

    abstract public function escapeLike($value);
    
    public static function getCurrentDate()
    {
        return date('Y-m-d H:i:s');   
    }
    

    public function __construct(DatabaseCredentials $credentials = null)
    {
        $this->credentials = $credentials;
        $this->setConnection();
    }

    public function install(DatabaseTable $table)
    {
        return $this->execute("CREATE TABLE IF NOT EXISTS {$table->getName()} ({$table->getFieldsDefinition()})");
    }

    public function uninstall(DatabaseTable $table)
    {
        return $this->execute("DROP TABLE IF EXISTS {$table->getName()}");
    }

    public function update(DatabaseTable $table)
    {
        (array) $columns = $this->execute("DESCRIBE {$table->getName()}");
        (object) $databaseTableMapper = $table->map($columns);


        $databaseTableMapper->applyToChanged(function($changeType, DatabaseColumn $column) use ($table) {
            (string) $action = "{$changeType}Column";
            $this->{$action}($table, $column);
        });

    }

    public function addColumn(DatabaseTable $table, DatabaseColumn $column)
    {
        $this->execute("ALTER TABLE {$table->getName()} ADD COLUMN {$column->getDefinition()}");
    }

    public function removeColumn(DatabaseTable $table, DatabaseColumn $column)
    {
        $this->execute("ALTER TABLE {$table->getName()} DROP COLUMN {$column->getName()}");
    }

    protected function statementIs($statement, $statementToCheck)
    {
        (string) $statementType = explode(' ', $statement)[0];

        return in_array(strtolower($statementType), explode('|', $statementToCheck));
    }
}