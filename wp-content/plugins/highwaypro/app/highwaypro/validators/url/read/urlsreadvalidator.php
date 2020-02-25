<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Read;

use HighWayPro\App\HighWayPro\HTTP\Requests\ReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlsReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\ReadErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlTypeErrors;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\UrlTypes\Validators\UrlTypeValidator;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlsReadValidator extends Validator
{
    protected function request()
    {
        return new UrlsReadRequest;
    }

    public function validate()
    {
        if ($this->request->data->filters->dataFound->asCollection()->haveAny()) {
            if ($this->request->hasTypeIdFilter()) {

                (object) $urlTypeValidator = new UrlTypeValidator(
                    new UrlType($this->request->data->filters->urlType->asArray()),
                    new UrlTypeGateway(new WordPressDatabaseDriver)
                );

                if ($urlTypeValidator->idDoesNotExist()) {
                    return (new Response)
                                 ->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_id')->asArray());
                }
            } else if (!$this->request->hasName()) {
                return (new Response)->withStatusCode(400)
                                    ->containing(
                                        ReadErrors::getErrorWithReceivedData(
                                            'url_read_invalid_filters',
                                            $this->request
                                    ));
            }
        }

        return true;
    }

}
