<?php

namespace HighWayPro\Original\Collections\Mapper;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Collections\ArrayGetter;
use HighWayPro\Original\Collections\Mapper\Types\BooleanType;
use HighWayPro\Original\Collections\Mapper\Types\CollectionType;
use HighWayPro\Original\Collections\Mapper\Types\IntegerType;
use HighWayPro\Original\Collections\Mapper\Types\StringType;

Abstract Class Types
{
    const STRING = 100000;
    const INTEGER = 200000;
    const BOOLEAN = 300000;
    const COLLECTION = 400000;
    const ANY = 999999;

    protected $type;
    protected $defaultValue;
    protected $allowedValues;
    protected $anyValueIsAllowed = true;
    protected $escapeCallable;

    abstract protected function setType();
    abstract protected function hasDefaultValue();
    abstract protected function concretePickValue($newValue);
    abstract protected function isCorrectType($value);

    public static function isString($value)
    {
        return is_string($value) || ($value instanceof StringManager);
    }
    
    public static function STRING()
    {
        return new StringType(static::STRING);
    }

    public static function INTEGER()
    {
        return new IntegerType(static::INTEGER);
    }

    public static function BOOLEAN()
    {
        return new BooleanType(static::BOOLEAN);
    }

    public static function Collection()
    {
        return new CollectionType(static::COLLECTION);
    }

    public static function returnValueCallable()
    {
        return function($value){return $value;};   
    }
    
    protected function __construct()
    {
        $this->type = $this->setType();   
        $this->allowedValues = new Collection([]);
    }

    public function getType()
    {
        return $this->type;
    }

    public function is($type)
    {
        return $this->getType() === $type;
    }

    public function withDefault($value)
    {
        $this->defaultValue = $this->castToExpectedType($value);

        return $this;   
    }    

    public function getDefaultValue()
    {
        return $this->defaultValue;   
    }

    public function allowed(/*Array|Collection*/ $values)
    {
        (array) $values = ArrayGetter::getArrayOrThrowExceptionFrom($values);
        
        $this->allowedValues = new Collection($values);
        $this->anyValueIsAllowed = false;

        return $this;   
    }    

    public function anyValueIsAllowed()
    {
        return $this->anyValueIsAllowed;   
    }

    public function escape($callable)
    {
        if (is_callable($callable)) {
            $this->escapeCallable = $callable;
        }

        return $this;
    }
    
    public function hasDefinedEscapeFunction()
    {
        return is_callable($this->escapeCallable);   
    }

    public function getEscapeFunction()
    {
        return $this->escapeCallable;   
    }
    
    public function getAllowedValues()
    {
        return $this->allowedValues;   
    }

    public function getFallbackAllowedValue()
    {
        if ($this->getDefaultValue() !== null) {
            return $this->getDefaultValue();
        }

        return $this->getAllowedValues()->first();
    }

    public function pickValue($newValue)
    {
        if ($this->hasDefaultvalue()) {
            return $this->concretePickValue($newValue);
        }

        return $newValue;
    }

    protected function valueIsScalar($value)
    {
        return (is_string($value) || is_numeric($value) || is_bool($value));   
    }

    protected function throwExceptionIfTypeIsInvalid($type)
    {
        switch ($type) {
            case static::STRING:
            case static::INTEGER:
            case static::BOOLEAN:
                 // ok
                break;
            
            default:
                throw new \Exception("Invalid type {$type}");
                break;
        }
    }     

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        throw new \Exception("cannot call abstract method castToExpectedType");
        
    }
}