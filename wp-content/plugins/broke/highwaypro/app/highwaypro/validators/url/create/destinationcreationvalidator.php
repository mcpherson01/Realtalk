<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationErrors;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Class DestinationCreationValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new DestinationCreationRequest;
    }

    public function validate()
    {
        (object) $destinationValidator = new DestinationValidator(['url_id' => $this->request->data->url->id]); 

        if ($this->request->data->excluded->destination->id > 0) {
            return (new Response)->withStatusCode(409)
                                 ->containing(DestinationErrors::get('destination_with_id')->asArray());
        } elseif ($this->request->data->excluded->destination->position > 0) {
            return (new Response)->withStatusCode(409)
                                 ->containing(DestinationErrors::get('destination_with_position')->asArray());
        } elseif ($this->request->data->url->id <= 0) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('url_with_no_id')->asArray());
        } elseif ($destinationValidator->urlDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_url_id')->asArray());
        }

        return true;
    }

}