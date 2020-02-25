<?php

namespace HighwayPro\App\Data\Model\UrlTypes;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Domain;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\UrlTypes\Validators\UrlTypeValidator;
use HighwayPro\Original\Collections\Mapper\Types;

Class UrlType extends Domain
{
    public static function fields()
    {
        return new Collection([
            'id' => Types::INTEGER,
            'name' => Types::STRING,
            'base_path' => Types::STRING,
            'color' => Types::STRING()->withDefault('original')
        ]);   
    }
    
    public static function updatableFields()
    {
        return static::fields()->only([
            'name', 'base_path', 'color'
        ])->getKeys();   
    }

    public function beforeInsertion()
    {
        unset($this->id);
        $this->unsetBasePathIfEmpty();
    }

    public function beforeUpdate()
    {
        $this->unsetBasePathIfEmpty();
    }
    
    public function unsetBasePathIfEmpty()
    {
        if ($this->base_path->isEmpty()) {
            unset($this->base_path);
        }
    }
    
    protected function map()
    {
        return static::fields()->asArray();
    }

    public function getPath()
    {
        (object) $pathCleaner = new PathManager($this->base_path);

        return $pathCleaner->getClean();
    }

    public function getValidator()
    {
        return new UrlTypeValidator($this, new UrlTypeGateway(new WordPressDatabaseDriver));   
    }
}