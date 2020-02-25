<?php

namespace HighwayPro\App\Data\Model\Urls;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\App\HighWayPro\System\Events;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Domain;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtraGateway;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\App\Data\Model\Urls\Validators\UrlValidator;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class Url extends Domain
{
    protected $destinations;
    protected $passingDestination;
    protected $foundDestination;

    public static function fields()
    {
        return new Collection([
            'id' => Types::INTEGER,
            'path' => Types::STRING,
            'name' => Types::STRING,
            'date_added' => Types::STRING,
            'type_id' => Types::INTEGER
        ]);   
    }

    public function updatableFields()
    {
        return static::fields()->only([
            'path', 'name', 'type_id'
        ])->getKeys();   
    }
    
    public function nonUpdatableFields()
    {
        return static::fields()->getKeys()
                               ->not($this->updatableFields());   
    }
    
    public function beforeInsertion()
    {
        unset($this->id);
        if(isset($this->cache)) unset($this->cache);

        $this->date_added = date('Y-m-d H:i:s');
        $this->path = UrlGateway::ensurePathFormat($this->path);
    }

    public function getClickBehaviour()
    {
        return $this->getMultiPrecedenceOption('link_placement_click_behaviour');   
    }

    public function getFollowType()
    {
        return $this->getMultiPrecedenceOption('link_placement_follow_type');   
    }

    public function getInjectionLimit()
    {
        return (integer) ((string) $this->getMultiPrecedenceOption('keyword_injection_limit'));   
    }

    public function getInjectionPostTypesAllowed()
    {
        (object) $keywordInjection = $this->getExtra('keyword_injection');

        if ($keywordInjection instanceof UrlExtra) {
            return $keywordInjection->context;
        }

        return Preferences::get()->preferences
                                 ->post
                                 ->preferences
                                 ->keyword_injection_post_types_enabled; 
    }

    public function getMultiPrecedenceOption($name)
    {
        (object) $customExtraClickBehaviour = $this->getExtra($name);

        if ($customExtraClickBehaviour instanceof UrlExtra) {
            return $customExtraClickBehaviour->value;
        } else {
            return Preferences::get()->preferences
                                 ->post
                                 ->preferences
                                 ->{$name};   
        }
    }
    
    public function getExtra($extraName)
    {
        return $this->getUrlExtraGateway()->getWithUrlIdAndName($this->id, $extraName)->first();   
    }
    
    protected function getUrlExtraGateway()
    {
        return $this->cache->getIfExists('cache')->otherwise(function(){
            return new UrlExtraGateway(NEW WordPressDatabaseDriver);
        });
    }
    

    protected function map()
    {
        return static::fields()->asArray();
    }

    public function getBaseDirectory()
    {
        (object) $type = $this->getType();   

        if ($type) {
            return $type->getPath();
        }
    }

    public function getFullUrl()
    {
        $path = "{$this->getBaseDirectory()}{$this->getPath()}";

        return get_option('siteurl').$path;
    }

    public function hasPath($path)
    {
        return $this->getPath() === (new PathManager((string) $path))->getClean();   
    }
    

    public function getPath()
    {
        (object) $pathCleaner = new PathManager($this->path);

        return $pathCleaner->getClean();
    }

    public function getDestination()
    {
        if (is_object($this->passingDestination) || $this->foundDestination === false) return $this->passingDestination;

        foreach ($this->getDestinations()->asArray() as $destination) {
            if ($destination->hasPassed()) {
                return ($this->passingDestination = $destination);
            }
        }

        $this->foundDestination = false;
    }

    public function getType()
    {
        return $this->cache->getIfExists('type')->otherwise(function(){
            return (new UrlTypeGateway(new WordPressDatabaseDriver))->getWithId($this->type_id);
        });
    }

    public function getValidator()
    {
        return $this->cache->getIfExists('validator')->otherwise(function() {
            return new UrlValidator(
                $this,
                new UrlGateway(new WordPressDatabaseDriver),
                new UrlTypeGateway(new WordPressDatabaseDriver)
            );
        });
    }
    public function getLatestEvent()
    {
        (array) $declaredEventsByComponents = $this->getDestinations()->map(function(Destination $destination){
            return $destination->getLatestEvent();
        })->asArray();

        return Events::getAll()->getLatest($declaredEventsByComponents);
    }

    public function getDestinations()
    {
        return $this->cache->getIfExists('destinations')->otherwise(function(){
            return (new DestinationGateway(new WordPressDatabaseDriver, $bind = $this))->getFromUrlWithAValidTarget($this);
        });
    }

    public function getDestinationsIncludingThoseWithoutATarget()
    {
        return $this->cache->getIfExists('destinations')->otherwise(function(){
            return (new DestinationGateway(new WordPressDatabaseDriver, $bind = $this))->getFromUrlIncludingThoseWithoutATarget($this);
        });
    }
}