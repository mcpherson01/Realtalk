<?php

namespace HighwayPro\App\Data\Model\Destinations\Validators;

use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;

Abstract Class DestinationComponentValidator
{
    protected $destinationComponentFields;
    protected $urlGateway;
    protected $destinationGateway;
    protected $parameterError;

    abstract public function getDestinationComponentGateway();

    /**
     * Returns the Component type. For example, DestinationCondition or DestinationTarget
     * @return string Fully quialified destination component class name.
     */
    abstract public function getComponentType();

    /**
     * Returns the type of DestinationComponent, For example, condition or target 
     */
    abstract public function getComponentExtensionType();

    public function __construct(Array $destinationComponentFields)
    {
        $this->destinationComponentFields = new Collection($destinationComponentFields);   
        $this->destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);
    }

    public function destinationHasAComponentWithADiferentId()
    {
        $destinationComponent = $this->getDestinationComponentGateway()->getFromDestination(
            new Destination([
                'id' => $this->destinationComponentFields->get('destination_id')
            ])
        );

        (string) $DestinationComponent = $this->getComponentType();

        if ($destinationComponent instanceof $DestinationComponent) {
            return ((integer) $destinationComponent->id) !== 
                   ((integer) $this->destinationComponentFields->get('id'));
        }

        return false;
    }

    /**
     * PLEASE NOTE, THIS METHOD DOES NOT CHECK WHETHER THE ASSOCIATION BETWEEN THE 
     * DESTINATION AND THE CONDITION IS VALID WHEN THE CONDITION HAS AN ID; THAT
     * IS THE JOB OF THE SELF::destinationHasAComponentWithADiferentId() METHOD
     *
     * THE ONLY GOAL OF THIS METHOD IS TO CHECK WHETHER THE CURRENT CONDITION HAS AN ID 
     * BUT THE DESTINATION IS ALREADY ASSOCIATED WITH A CONDITION ENTITY
     */
    public function componentHasNoIdButDestinationAlreadyHasAComponentAssociatedWithIt()
    {
        if (((integer) $this->destinationComponentFields->get('id')) < 1) {
            $destinationComponent = $this->getDestinationComponentGateway()->getFromDestination(
                new Destination([
                    'id' => $this->destinationComponentFields->get('destination_id')
                ])
            );

            (string) $DestinationComponent = $this->getComponentType();

            return $destinationComponent instanceof $DestinationComponent;
        }

        return false;
    }

    public function idDoesNotExist()
    {
        if ($this->destinationComponentFields->get('id') < 1) return true;
        
        return !$this->getDestinationComponentGateway()->idExists(
            $this->destinationComponentFields->get('id')
        );
    }
    

    public function typeIsValid()
    {
        return URLComponentsRegistrator::get()->isRegistered([
            'type' => $this->getComponentExtensionType(),
            'name' => $this->destinationComponentFields->get('type')
        ]);
    }

    public function parameterIsValid()
    {
        (object) $destinationComponent = URLComponentsRegistrator::get()->createComponent([
            'type' => $this->getComponentExtensionType(),
            'component' => $this->destinationComponentFields->get('type'),
            'parameters' => $this->destinationComponentFields->get('parameters'),
            'destination' => null
        ]);

        $parameterValidationResult =  $destinationComponent->getParameterValidationResult();   

        if ($parameterValidationResult instanceof Collection) {
            $this->parameterError = $parameterValidationResult;
            return false;
        }

        return true;
    }

    public function getParameterError()
    {
        return $this->parameterError;   
    }
}