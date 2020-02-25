<?php

namespace HighWayPro\App\HighWayPro\HTTP;

Class Response
{
    public $statusCode = 200;
    public $headers = [];
    public $body;

    protected $needsToExit = true;
    protected $shouldSaveView = true;

    protected function beforeSend(){}

    public function __construct(Array $data = [])
    {
        if (isset($data['statusCode'])) {
            $this->statusCode = (integer) $data['statusCode'];
        }    

        if (isset($data['headers'])) {
            $this->headers = (array) $data['headers'];
        }  

        if (isset($data['body'])) {
            $this->body = (string) $data['body'];
        }   
    }

    public function withStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    } 

    public function containing($content)
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }

        $this->body = $content;

        return $this;
    }

    public function withHeaders(array $headers)
    {
        $this->headers = array_merge(
            $this->headers,
            $headers
        );

        return $this;
    }
    

    public function needsToExit()
    {
        return $this->needsToExit;   
    }

    public function shouldSaveView()
    {
        return $this->shouldSaveView;   
    }

    public function setNeedsToExit($needsToExit)
    {
        $this->needsToExit = (boolean) $needsToExit;   
    }

    public function send()
    {
        if (!headers_sent()) {
            $this->beforeSend();

            $this->buildStatusCode();
            $this->buildHeaders();
            
        }

        $this->buildBody();
    }

    protected function buildStatusCode()
    {
        http_response_code($this->statusCode);   
    }

    protected function buildHeaders()
    {
        foreach($this->headers as $name => $value)   
        {
            header("{$name}: {$value}");
        }
    }

    protected function buildBody()
    {
        print $this->body;   
    }
}






