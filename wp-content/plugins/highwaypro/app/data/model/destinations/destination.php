<?php

namespace HighwayPro\App\Data\Model\Destinations;

use HighWayPro\App\HighWayPro\System\Events;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Domain;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationConditionGateway;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTargetGateway;
use HighwayPro\App\Data\Model\UrlViews\UrlView;
use HighwayPro\App\Data\Model\UrlViews\UrlViewGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\Original\Collections\Mapper\Types;

Class Destination extends Domain
{
    public static function fields()
    {
        return new Collection([
            'id' => Types::INTEGER,
            'url_id' => Types::INTEGER,
            'position' => Types::INTEGER,
            'date' => Types::STRING,
        ]);   
    }

    public function beforeInsertion()
    {
        unset($this->id);
        $this->date = date('Y-m-d H:i:s');
    }

    protected function map()
    {
        return static::fields()->asArray();
    }

    public function hasPassed()
    {
        return $this->cache->getIfExists('hasPassed')->otherwise(function(){
            return (!$this->hasConditions()) || 
                   ($this->hasConditions() && $this->getCondition()->hasPassed());
        });
    }

    public function getViews()
    {
        return $this->cache->getIfExists('views')->otherwise(function(){
            return (new UrlViewGateway(new WordPressDatabaseDriver))->getFromDestinationId($this->id);
        });
    } 

    public function createView()
    {
        return UrlView::create($this);
    } 

    public function hasConditions()
    {
        return is_object($this->getCondition());
    }

    public function getLatestEvent()
    {
        (object) $destinationEvents = new Collection([]);

        if ($this->hasConditions()) {
            $destinationEvents->push($this->getCondition()->getEvent());
        }

        $destinationEvents->push($this->getTarget()->getEvent());

        return Events::getAll()->getLatest($destinationEvents->asArray());
    }

    public function getUrl()
    {
        return $this->cache->getIfExists('url')->otherwise(function() {
            return (new UrlGateway(new WordPressDatabaseDriver))->getWithId($this->url_id);
        });
    }

    public function getWithComponents()
    {
        return (new Collection($this->getAvailableValues()))->append([
            'condition' => ($this->getCondition() instanceof DestinationCondition)? new Collection($this->getCondition()->getAvailableValues()) : null,
            'target' => ($this->getTarget() instanceof DestinationTarget)? new Collection($this->getTarget()->getAvailableValues()): null
        ]);
    }
    
    protected function getCondition()
    {
        return $this->cache->getIfExists('condition')->otherwise(function(){
            return (new DestinationConditionGateway(new WordPressDatabaseDriver, $bind = $this))->getFromDestination($this);
        });
    }

    public function getTarget()
    {
        return $this->cache->getIfExists('target')->otherwise(function(){
            return (new DestinationTargetGateway(new WordPressDatabaseDriver, $bind = $this))->getFromDestination($this);
        });
    }

}