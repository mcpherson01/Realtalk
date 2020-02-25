<?php

namespace HighWayPro\Original\Cache;

use Closure;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Utilities\TypeChecker;
use HighWayPro\Original\Characters\StringManager;

Class ExistingValueResolver
{
    use TypeChecker;

    protected $key;
    protected $data;

    public function __construct(Array $keyAndData)
    {
        $this->key = new StringManager($keyAndData['key']);
        $this->data =$this->expect($keyAndData['data'])->toBe(Collection::class);
    }

    public function otherwise($returnValue)
    {
        if ($this->data->hasKey($this->key)) {
            return $this->data->get($this->key);
        }

        $value = ($returnValue instanceof Closure)? $this->call($returnValue) : $returnValue;

        $this->data->add($this->key, $value);
        
        return $value;       
    }

    public function call(Callable $returnValue)
    {
        return $returnValue();
    }
    
}