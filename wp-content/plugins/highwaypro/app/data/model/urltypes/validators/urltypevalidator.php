<?php

namespace HighwayPro\App\Data\Model\UrlTypes\Validators;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeColors;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;

Class UrlTypeValidator
{
    protected $urlType;
    protected $urlTypeGateway;

    public function __construct(UrlType $urlType, UrlTypeGateway $urlTypeGateway)
    {
        $this->urlType = $urlType;   
        $this->urlTypeGateway = $urlTypeGateway;
    }

    public function hasId()
    {
        return $this->urlType->id > 0;
    }

    public function idDoesNotExist()
    {
        return !$this->urlTypeGateway->idExists($this->urlType->id);   
    }
    

    public function hasName()
    {
        return $this->urlType->name->isNotEmpty();
    }

    public function nameIsValid()
    {
        return $this->urlType->name->trim()->matches('/^[\w\s]+$/');   
    }

    public function nameAlreadyExists()
    {
        return $this->urlTypeGateway->nameExists($this->urlType->name);   
    }
    
    public function hasPathButItIsInvalid()
    {
        return $this->urlType->base_path->isNotEmpty() && $this->pathIsInvalid();
    }

    public function pathIsInvalid()
    {
        (object) $pathManager = new PathManager($this->urlType->base_path->get());

        if (!$pathManager->formatIsValid()) {
            return true;
        }

        return false;
    }

    public function hasPathButItAlreadyExists()
    {
        return $this->urlType->base_path->isNotEmpty() && $this->pathAlreadyExists();   
    }
    

    public function pathAlreadyExists()
    {
        return $this->urlTypeGateway->basePathExists($this->urlType->base_path->get());   
    }

    public function hasColorButItIsInvalid()
    {
        return $this->urlType->color->isNotEmpty() && !$this->colorIsValid();
    }

    public function colorIsValid()
    {
        return $this->urlType->color->isEither(UrlTypeColors::getAll()->asArray());   
    }
}