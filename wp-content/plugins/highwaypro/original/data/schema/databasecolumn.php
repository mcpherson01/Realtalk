<?php

namespace HighWayPro\Original\Data\Schema;

use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Data\Schema\DatabaseColumn\DatabaseColumnDefault;
use HighWayPro\Original\Utilities\className;

Class DatabaseColumn
{
    use className;

    protected $name;
    protected $type;
    protected $extra;

    public function __construct($name, $type, $extra = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->extra = $extra;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return (array) $this->type;
    }

    public function getDefinition()
    {
        return "{$this->name} {$this->getClean('type')} {$this->getClean('extra')}";
    }

    protected function getClean($property)
    {
        if ($this->{$property} instanceof DatabaseColumnDefault) {
            return $this->{$property}->getDefinition();
        }

        return (new StringManager($this->{$property}))->getOnly('A-Za-z0-9_() ');
    }
}