<?php

namespace HighWayPro\App\HighWayPro\HTTP;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Utilities\TypeChecker;
use HighwayPro\Original\Characters\StringManager;

Abstract Class Controller
{
    use TypeChecker;
    
    protected $request;
    protected static $HTTPMethod = 'GET';

    abstract public function control();
    abstract protected function getValidators();

    public static function getRegistrationData()
    {
        return new Collection([
            'controller' => static::class,
            'route' => static::path
        ]);
    }

    public static function getMethod()
    {
        return new StringManager(static::$HTTPMethod);   
    }
    
    public function __construct(Request $request)
    {
        if (method_exists($this, 'request')) {
            $request = $this->expect($this->request())->toBe(Request::class);
        }
        
        $this->request = $request;
    }

    public function handle()
    {
        $validationResult = $this->validate();

        if ($validationResult instanceof Response) {
            return $validationResult;
        } elseif ($validationResult === true) {
            return $this->control();
        }

        throw new \Exception("Validation returned invalid value");
        
    }

    public function getRequest()
    {
        return $this->request;   
    }
    protected function validate()
    {
        (object) $validators = $this->getValidators();

        if ($validators->haveAny()) {
            foreach ($validators->asArray() as $validator) {

                $validator->setRequest($this->request);

                $result = $validator->validate();

                if ($result instanceof Response) {
                    return $result;
                }
            }
        }

        return isset($result)? $result: true;
    }

}