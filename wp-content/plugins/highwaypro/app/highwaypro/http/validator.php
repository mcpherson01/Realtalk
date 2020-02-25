<?php

namespace HighWayPro\App\HighWayPro\HTTP;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Utilities\TypeChecker;

Abstract Class Validator
{
    use TypeChecker;

    protected $request;

    abstract public function validate();

    public function setRequest(Request $request)
    {
        if (method_exists($this, 'request')) {
            $request = $this->expect($this->request())->toBe(Request::class);
        }

        $this->request = $request;   
    }

    public function getRequest()
    {
        return $this->request;
    }
}