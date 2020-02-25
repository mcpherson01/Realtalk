<?php

namespace HighwayPro\App\Data\Model\UrlTypes;

use HighWayPro\App\Data\Schema\UrlTypeTable;
use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;

Class UrlTypeGateway extends Gateway
{
    protected function model()
    {
        return [
            'table' => new UrlTypeTable,
            'domain' => UrlType::class
        ];
    }    

    /**
     * This method checks the existence of a row with an id 
     * it does not do JOINs as opposed to getWithId
     */
    public function idExists($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT id FROM {$this->table->getName()} WHERE id = ?", 
                        [$id]
                    )
                )->haveAny();
    }       

    public function nameExists($name)
    {
        return $this->fieldWithValueExists([
            'name' => 'name',
            'value' => trim($name)
        ]);
    }
    
    public function basePathExists($basePath)
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT id FROM {$this->table->getName()} WHERE base_path = ? AND base_path != ''", 
                        [(new PathManager($basePath))->getClean()]
                    )
                )->haveAny();
    }

    public function getWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE id = ?", [$id])
                )->first();
    }   

}