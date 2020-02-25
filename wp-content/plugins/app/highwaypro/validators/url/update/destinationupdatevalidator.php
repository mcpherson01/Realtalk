<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Update;

use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationErrors;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Class DestinationUpdateValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new DestinationUpdateRequest;
    }

    public function validate()
    {
        (object) $destinationValidator = new DestinationValidator([
            'id' => $this->request->data->destination->id,
            'position' => $this->request->data->destination->position
        ]); 

        if ($this->request->data->destination->allFieldsFoundInSource->areNot(['id', 'position'])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('invalid_destination_data')->asArray());
        } elseif ($destinationValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_destination_id')->asArray());
        } elseif ($destinationValidator->hasNoUrlAssociated()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_not_associated_with_a_url')->asArray());
        } elseif ($destinationValidator->positionIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_position')->asArray());
        } 
        
        return true;
    }

}