<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Preferences;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\Preferences;
use Highwaypro\App\Data\Model\Preferences\PreferencesField;

Class PreferencesUpdateRequest extends Request
{
    protected $preferencesField;

    public function map()
    {
        return [
            'preferencesField' => [
                'name' => Types::STRING,
                'value' => Types::ANY
            ]
        ];
    }

    public function __construct($path = '')
    {
        parent::__construct($path);

        $this->preferencesField = new PreferencesField([
            'name' => $this->data->preferencesField->name,
            'value' => $this->data->preferencesField->value
        ]);
    }

    public function getPreferencesField()
    {
        return $this->preferencesField;
    }
    
    public function getFieldComponents()
    {
        return new Collection([
            'component' => $this->getComponent(),
            'settingName' => $this->getSettingName(),
            'value' => $this->data->preferencesField->value
        ]);   
    }
    
    public function getComponent()
    {
        return $this->preferencesField->getComponent();
    }

    public function getSettingName()
    {
        return $this->preferencesField->getFieldName();
    }
    
}