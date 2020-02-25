<?php

namespace HighWayPro\App\HighWayPro\Controllers\Url;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\ReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlsReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\ReaderValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\UrlsReadValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlsReaderController extends Controller
{
    const path = 'urls';
    protected static $HTTPMethod = 'GET';

    protected function request()
    {
        return new UrlsReadRequest;   
    }
    
    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlsReadValidator
        ]);
    }

    public function control()
    {
        (object) $urlGateway = new UrlGateway(new WordPressDatabaseDriver);

        $urls = $this->getUrls($urlGateway);

        if ($urls === false || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlSuccesses::getUrls($urls, 'urls_read_success')->asArray()
                             );
    }

    protected function getUrls(UrlGateway $urlGateway)
    {
        // CURRENTLY, ONLY THE NAME AND LIMIT FILTERS ARE SUPPORTED SEPARATELY
        if ($this->request->hasTypeIdFilter()) {
            return $urlGateway->getAllWithTypeId($this->request->data->filters->urlType->id);
        } elseif ($this->request->hasName()) {
            return $urlGateway->getWithPartialName(
                (string)  $this->request->data->filters->url->name,
                (integer) $this->request->data->filters->limit
            );
        }

        return $urlGateway->getAll();   
    }
}   
