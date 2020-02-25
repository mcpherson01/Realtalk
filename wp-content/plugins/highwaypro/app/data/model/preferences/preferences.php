<?php

namespace Highwaypro\App\Data\Model\Preferences;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\Mapper\Mappable;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\PostPreferences;

Class Preferences extends Mappable
{
    const KEY = 'highwaypro_preferences';

    private static $instance;

    public $preferences;

    static public function components()
    {
        return new Collection([
            'dashboard' => DashboardPreferences::class,
            'url' => UrlPreferences::class,
            'social' => SocialPreferences::class,
            'post' => PostPreferences::class
        ]);   
    }
    
    protected function getMap()
    {
        return Static::components()->asArray();  
    }

    public static function get()
    {
        if (!(static::$instance instanceof Preferences)) {
            static::$instance = new Self(get_option(Static::KEY));
        }

        return static::$instance;        
    }

    /*
        Gets the values straight from the data-base. 
        This method ensures no caching will be made to the results
    */
    public static function getReloaded()
    {
        if (!(static::$instance instanceof Preferences)) {
        }

        return static::$instance;
    }
    
    /**
     * Constructs a new preferences object
     * Maps values to fields in self::components()
     * DATABASE QUERIES MUST NOT BE MADE IN THE CONSTRUCTOR
     */
    public function __construct($preferences)
    {
        $this->preferences = $this->map($preferences);
    }

    public function saveField(Collection $field)
    {
        (string) $component = (string) $field->get('component');
        (string) $settingName = (string) $field->get('settingName');
                 $value = $field->get('value');
        (string) $ComponentClass = Self::components()->get($component);

        $existingValue = $this->preferences->{$component}->preferences->{$settingName};
        $existingValue = Types::isString($existingValue)? ((string) $existingValue) : $existingValue;
        $newProcessedValue = (new $ComponentClass(json_encode([
                                                         $settingName => $value
                                                      ])))->preferences->{$settingName};
        $newProcessedValue = Types::isString($newProcessedValue)? ((string) $newProcessedValue) : $newProcessedValue;


        if (($existingValue === $newProcessedValue) || Collection::areEqual($existingValue, $newProcessedValue)) {
            return true;
        }

        $this->preferences->{$component}->preferences->{$settingName} = (new $ComponentClass(json_encode([
                                                         $settingName => $value
                                                      ])))->preferences->{$settingName};

        return $this->save();
    }
    

    public function save()
    {
        (boolean) $updateResult = update_option(
            $name = Static::KEY, 
            $value = $this->unMap(), 
            $autoLoad = true
        );      

        static::reset();
        wp_cache_delete('alloptions', 'options');

        return $updateResult;
    }

    public static function reset()
    {
        static::$instance = null;   
    }

    public static function factoryReset()
    {
        (boolean) $updateResult = update_option(
            $name = Static::KEY, 
            $value = (new Self(''))->unMap(), 
            $autoLoad = true
        );    

        static::reset();

        return $updateResult;
    }

    public function export()
    {
        return $this->unMap();   
    }

    public function exportWithAllowedValues()
    {
        (object) $components = new Collection([]);

        foreach ($this->getValuesToUnmap()->asArray() as $componentName => $component) {
            $components->add(
                $componentName, 
                $component->getValuesToUnmap()->append(
                    [
                        '_allowed' => $component->getFieldsWithAllowedValues(),
                        '_default' => $component->getFieldsWithDefaultValues()
                    ]
                )
            );
        }

        return $components->asJson()->get();
    }
    
    public function getFieldsWithDefaultValues()
    {
        return $this->getFieldsWith(function($field) {
            return $field->getDefaultValue();
        });
    }

    public function getFieldsWithAllowedValues()
    {
        return $this->getFieldsWith(function($field){
            return $field->getAllowedValues();
        });
    }

    protected function getFieldsWith(callable $fieldValueGetter)
    {
        (object) $fields = new Collection([]);

        foreach ($this->getMap() as $fieldName => $field) {
            $fields->add($fieldName, $fieldValueGetter($field));
        }

        return $fields;
    }

    public function getValuesToUnmap()
    {
        return $this->preferences->asCollection();
    }

    public function validateField(Collection $field)
    {
        (object) $fieldType = static::fields()->get($field->get('name'));

        if ($fieldType->anyValueIsAllowed()) {
            return $fieldType->isCorrectType($field->get('value'));
        } else {

            if (!$fieldType->isCorrectType($field->get('value'))) return false;

            if (is_array($field->get('value'))) {
                return $fieldType->getAllowedValues()->containAll($field->get('value'));;
            }

            return $fieldType->getAllowedValues()->contain($field->get('value'));
        }
    }
}