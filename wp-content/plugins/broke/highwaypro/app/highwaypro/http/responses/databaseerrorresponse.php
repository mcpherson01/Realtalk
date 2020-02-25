<?php

namespace HighWayPro\App\HighWayPro\HTTP\Responses;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighwayPro\App\HighwayPro\HTTP\Errors\DatabaseErrors;

Class DatabaseErrorResponse extends Response
{
    public $statusCode = 500;
    public $headers = [];
    public $body;

    protected $needsToExit = true;
    protected $shouldSaveView = false;

    protected function beforeSend(){}

    public function __construct(Array $data = [])
    {
        $this->statusCode = 500;
        global $wpdb;

        $this->body = DatabaseErrors::get('database_error')->asJson();
    }

    
}






