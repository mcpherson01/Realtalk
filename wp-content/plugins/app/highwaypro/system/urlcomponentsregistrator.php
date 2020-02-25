<?php

namespace HighWayPro\App\HighWayPro\System;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Utilities\TypeChecker;

Class URLComponentsRegistrator
{
    use TypeChecker;

    private static $instance;

    private $conditions = []; 
    private $targets = [];

    public static function get()
    {
        if (!static::$instance) {
            static::$instance = new Static;
        }

        return static::$instance;   
    }

    public function all()
    {
        return new Collection(array_merge($this->conditions, $this->targets));   
    }
    
    protected function __construct()
    {
        do_action(Env::idLowerCase(). '_register_destination_component', $this);
    }

    public function register($destinationComponent)
    {
        $this->{$destinationComponent::type}[$destinationComponent::name] = $this->expect($destinationComponent)
                                                         ->toBe(DestinationComponent::class);
    }

    public function isRegistered(Array $destinationComponent)
    {
        (object) $destinationComponent = new Collection($destinationComponent);

        return isset(
            $this->{$destinationComponent->get('type')}[$destinationComponent->get('name')]
        );   
    }

    public function createComponent(Array $componentData)
    {
        (string) $type = $componentData['type'];
        (string) $Component = $this->{$componentData['type']}[$componentData['component']];

        return new $Component(
            $componentData['parameters'], 
            $componentData['destination']);
    }
}



