<?php

namespace HighwayPro\App\Data\Model\Preferences\Validators;

use HighWayPro\App\HighWayPro\HTTP\Requests\Preferences\PreferencesUpdateRequest;
use HighWayPro\Original\Collections\Collection;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PreferencesValidator
{
    protected $preferencesField;

    public function __construct(PreferencesUpdateRequest $request)
    {
        $this->request = $request;
    }
    
    public function hasInvalidFieldName()
    {
        (object) $components = Preferences::components();
        (string) $componentClass = $components->get($this->request->getComponent());

        return (!$this->request->data->preferencesField->name->explode('.')->haveExactly(2)) || 
               (!$components->getKeys()->contain($this->request->getComponent())) ||
               (
                (!class_exists($componentClass)) || 
                (class_exists($componentClass) && !$componentClass::fields()->getKeys()->contain($this->request->getSettingName())) 
                );

    }

    public function valueIsInvalid()
    {
        if (!isset($this->request->data->preferencesField->value)) return true;
        
        (string) $ComponentClass = Preferences::components()->get($this->request->getComponent());
        (object) $preferencesComponent = new $ComponentClass('');

        return !$preferencesComponent->validateField(new Collection([
            'name' => $this->request->getSettingName(),
            'value' => $this->request->data->preferencesField->value
        ]));
    }
    
}