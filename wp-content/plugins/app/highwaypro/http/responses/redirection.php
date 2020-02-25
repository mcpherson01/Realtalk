<?php

namespace HighwayPro\App\HighwayPro\HTTP\Responses;

use HighWayPro\App\HighWayPro\HTTP\Response;

Class Redirection extends Response
{
    public $statusCode = 302;
    public $redirectionUrl;

    public function to($url)
    {
        $this->redirectionUrl = $url;
        $this->headers['Location'] = $url;

        return $this;
    }

    protected function beforeSend()
    {
        $this->body = <<<BODY
<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <meta http-equiv="refresh" content="0; url={$this->redirectionUrl}" />
</head>
<body>

</body>
</html>
BODY;
    }

}