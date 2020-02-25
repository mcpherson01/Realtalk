<?php

namespace HighwayPro\App\Data\Model\Urls\Validators;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlValidator
{
    protected $url;
    protected $urlGateway;
    protected $urlTypeGateway;

    public function __construct(Url $url, UrlGateway $urlGateway, UrlTypeGateway $urlTypeGateway)
    {
        $this->url = $url;   
        $this->urlGateway = $urlGateway;
        $this->urlTypeGateway = $urlTypeGateway;
    }

    public function hasId()
    {
        return isset($this->url->id) && $this->url->id !== 0;
    }

    public function idDoesNotExist()
    {   
        return !($this->urlGateway->getWithId($this->url->id) instanceof Url);
    }
        
    public function pathIsInvalid()
    {
        (object) $pathManager = new PathManager($this->url->path->get());

        if ($this->url->path->isEmpty()) {
            return true;
        } elseif (!$pathManager->formatIsValid()) {
            return true;
        }

        return false;
    }

    public function pathAlreadyExists()
    {
        return $this->urlGateway->pathExists($this->url->path->get());   
    }

    public function pathAlreadyExistsAndItIsNotFromThisUrl()
    {
        return $this->urlGateway->pathExists($this->url->path->get()) 
                &&
               (!$this->urlGateway->hasFieldWithValue([
                   'id' => $this->url->id,
                   'name' => 'path',
                   'value' => $this->url->path->get()
               ]));
    }
    

    public function hasTypeId()
    {
        return $this->url->type_id > 0;   
    }
    
    public function typeIdDoesntExist()
    {
        if ($this->url->type_id == 0) {
            return true;
        }
        
        return !$this->urlTypeGateway->idExists($this->url->type_id);   
    }

    public function nameIsValid()
    {
        return $this->url->name->trim()->matches('/^[\w\s]+$/');
    }

    public function nameAlreadyExists()
    {
        return $this->urlGateway->nameExists($this->url->name->get());      
    }
    
}