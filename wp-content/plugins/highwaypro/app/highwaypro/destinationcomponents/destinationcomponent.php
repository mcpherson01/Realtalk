<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents;

use Exception;
use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationTargetErrors;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Collections\JSONMapper;
use HighwayPro\Original\Collections\Mapper\Types;
use StdClass;

Abstract Class DestinationComponent
{
    const event = 'plugins_loaded';

    protected $parameters;
    protected $allowed;

    abstract protected function parametersMap();
    abstract public function validateParameters();

    protected function getAllowedValues() { return new Collection([]); }

    public static function getMetaData()
    {
        return new Collection([
            'title' => Static::title(),
            'shortDescription' => Static::shortDescription(),
            'description' => Static::description(),
            'parametersMap' => (new Static(''))->parameters,
            'allowedValues' => (new Static(''))->allowed
        ]);   
    }
    
    protected function defaultMap()
    {
        return [
            'queryString' => Types::STRING()->escape(Types::returnValueCallable())
        ];   
    }

    public function __construct($parameters, Destination $destination = null)
    {
        (object) $JSONMapper = new JSONMapper(
            array_merge($this->parametersMap(), $this->defaultMap())
        );

        $this->allowed = $this->getAllowedValues();
        $this->parameters = $JSONMapper->map($parameters);
        $this->destination = $destination? $destination : null;
    }

    public function getEvent()
    {
        return Static::event;   
    }

    public function getParameterValidationResult()
    {
        (boolean) $parametersExceedAllowedlength = 
            $this->parameters->asCollection()->asJson()->length() >= DestinationTargetTable::PARAMETERS_LENGTH;
            
        if ($parametersExceedAllowedlength) {
            return DestinationTargetErrors::get('allowed_parameter_size_exceeded');
        }   

        return $this->validateParameters();
    }

    public function getParameters()
    {
        return clone $this->parameters;   
    }

    public function getAllowed()
    {
        return clone $this->allowed;   
    }
}



