<?php

namespace HighWayPro\Original\Cache;

use HighWayPro\Original\Collections\Collection;

Abstract Class Cache
{
    protected $data;

    abstract public function get($key);
    abstract public function getIfExists($key); #: CacheValueResolver

    public function __construct($initnialValues = [])
    {
        $this->data = new Collection($initnialValues);   
    }
    
}