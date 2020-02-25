<?php

namespace HighWayPro\App\HighWayPro\HTTP;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\HighwayPro\HTTP\Errors\RouterErrors;

Class Router
{
    protected $controllers;

    public function __construct(Collection $controllers = null)
    {
        if (is_null($controllers)) { $controllers = new Collection([]); }

        $this->controllers = $controllers;
    }

    public function setErrorSupression()
    {
        error_reporting(0);
        // we do not want errors to be outputed as
        // this router is used for HTTP APIs and the early printing of errors 
        // results in a 200 HTTP response code
        @ini_set('display_errors', 0);   

        set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine){

           if (!in_array($errorNumber, [E_WARNING, E_NOTICE, E_USER_WARNING, E_USER_NOTICE])) {
                http_response_code(500);
                $response = array_combine(['errno', 'errstr', 'errfile', 'errline', 'errcontext'], func_get_args());
                print json_encode([
                    'type' => 'system_error',
                    'message' => "Error: {$errorMessage} on {$errorLine} line {$errorLine}.\n_____\n{$this->getBackTrace()}"
                ]);
                exit;
            }
        });

        register_shutdown_function(function() {
            $last_error = error_get_last();

            if (isset($last_error['type']) && (!in_array($last_error['type'], [E_WARNING, E_NOTICE, E_USER_WARNING, E_USER_NOTICE]))) {
                http_response_code(500);
                print json_encode([
                    'type' => 'system_error',
                    'message' => "Error: {$last_error['message']} on {$last_error['file']} line {$last_error['line']}._____\n\n{$this->getBackTrace()}"
                ]);
                exit;
            }
                 
        });

    }

    public function addController(Collection $controllerData)
    {
        $this->controllers->add(
            $controllerData->get('route'), 
            $controllerData->get('controller')
        );
    }

    public function handle(Request $request)
    {

        ob_start();

        $Controller = $this->controllers->get((string) $request->get('path')->decodeUrl());

        if (class_exists($Controller) && $Controller::getMethod()->is($request->getMethod())) {
            (object) $controller = new $Controller($request);

            (object) $response = $controller->handle();
        } elseif (class_exists($Controller) && !$Controller::getMethod()->is($request->getMethod())) {
            (object) $response = (new Response)->withStatusCode(405)->containing(
                RouterErrors::get('invalid_http_method')->asArray()
            );
        } else {
            (object) $response = (new Response)->withStatusCode(404)->containing(
                RouterErrors::get('invalid_request_not_found')->asArray()
            );
        }

        ob_end_clean();

        /*$response->withHeaders([
            'Access-Control-Allow-Origin' => 'http://localhost:3000'
        ])->send();*/

        $response->send();

        $request->finish();
    }

    protected function getBackTrace()
    {
        ob_start(); 

        debug_print_backtrace(); 

        (string) $backTrace = ob_get_contents(); 

        ob_end_clean(); 

        return implode("\n\n", explode("\n", $backTrace)); 

    }
}   