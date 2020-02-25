<?php

namespace HighWayPro\Original\Data\Schema\DatabaseColumn;

use HighWayPro\Original\Data\Schema\DatabaseColumn\DatabaseColumnDefault;

Class DatabaseColumnDefaultString extends DatabaseColumnDefault
{
    public function getDefinition()
    {
        return "DEFAULT '{$this->getCleanValue()}'";
    }
}
