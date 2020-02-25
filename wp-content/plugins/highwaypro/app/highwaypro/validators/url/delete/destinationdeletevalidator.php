<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Delete;

use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationErrors;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Class DestinationDeleteValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new DestinationDeleteRequest;
    }

    public function validate()
    {
        (object) $destinationValidator = new DestinationValidator([
            'id' => $this->request->data->destination->id,
        ]); 

        if ($this->request->data->destination->allFieldsFoundInSource->areNot(['id'])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('invalid_destination_data_delete')->asArray());
        } elseif ($destinationValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_destination_id')->asArray());
        } 
        
        return true;
    }

}