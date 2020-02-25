<?php

namespace HighwayPro\App\HighwayPro\HTTP\Responses;

use HighWayPro\App\HighWayPro\HTTP\Response;

Class NotFoundResponse extends Response
{
    public $statusCode = 404;
    protected $needsToExit = false;

    protected $shouldSaveView = false;

    protected function beforeSend()
    {
        global $wp_query;

        $this->buildStatusCode();
        
        $wp_query->set_404();
        $wp_query->max_num_pages = 0;
    }

}