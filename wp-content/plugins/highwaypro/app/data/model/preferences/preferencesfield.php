<?php

namespace Highwaypro\App\Data\Model\Preferences;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Characters\StringManager;

Class PreferencesField
{
    protected $fieldSource;

    public function __construct(Array $field)
    {
        (object) $field = new Collection($field);

        $this->fieldSource = new StringManager((string) $field->get('name'));
        $this->value = $field->get('value');
    }

    public function getComponent()
    {
        return $this->getFieldParts()->atPosition(1);   
    }
    
    public function getFieldName()
    {
        return $this->getFieldParts()->atPosition(2);   
    }   

    protected function getFieldParts()
    {
        return $this->fieldSource->explode('.');   
    }
}