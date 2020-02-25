<?php

namespace HighWayPro\Original\Data\Model;

use HighWayPro\Original\Utilities\ObjectSetter;
use HighWayPro\Original\Cache\MemoryCache;
use HighWayPro\Original\Collections\JSONMapper;
use ReflectionObject;
use ReflectionProperty;

Class Domain
{
    protected $cache;

    public static function fromJson($jsonString)
    {
        return new Static(JSONMapper::getArrayFromJson($jsonString));
    }

    public function __construct(Array $values = [], $valueToBind = null)
    {
        $this->cache = new MemoryCache;
        
        if (method_exists($this, 'map')) {
            $values = $this->buildMap($values);
        }

        ObjectSetter::setPublicValues(['object' => $this, 'values' => $values]);

        if (method_exists($this, 'setUp')) {
            $valueToBind? $this->setUp($valueToBind) : $this->setUp();
        }
    }

    protected function buildMap(Array $values)
    {
        return (new JSONMapper($this->map()))->smartMap($values)->asArray();   
    }

    public function getAvailableFields()
    {
        return array_keys($this->getAvailableValues());
    }

    public function getAvailableValuesBut(array $fieldsToExclude)
    {
        return array_diff_key($this->getAvailableValues(), array_flip($fieldsToExclude));
    }

    public function getAvailableValues()
    {
        (object) $reflection = new ReflectionObject($this);

        (array) $publicProperties = [];

        foreach($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $publicProperty) {
            $value = $this->{$publicProperty->name};
            $publicProperties[$publicProperty->name] = $this->getScalarValue($value);
        }


        return $publicProperties;
    }

    public function prepareForInsertion()
    {
        if (method_exists($this, 'beforeInsertion')) {
            $this->beforeInsertion();
        }
    }

    public function prepareForUpdate()
    {
        if (method_exists($this, 'beforeUpdate')) {
            $this->beforeUpdate();
        }
    }

    protected function getScalarValue($value)
    {

        if (is_object($value) && (method_exists($value, '__toString') || method_exists($value, 'asStringRepresentation'))) {
            if (method_exists($value, 'asStringRepresentation')) {
                return (string) $value->asStringRepresentation();
            }
            return (string) $value;
        } elseif (is_object($value) || is_array($value)) {
            return '';
        }

        return $value;
    }

}