<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Delete;

use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition\DestinationConditionDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationConditionErrors;
use HighwayPro\App\Data\Model\DestinationConditions\Validators\DestinationConditionValidator;
use HighwayPro\App\Data\Model\Destinations\Validators\DestinationComponentValidator;

Class DestinationConditionDeletionValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new DestinationConditionDeleteRequest;
    }

    public function validate()
    {
        (object) $destinationConditionValidator = new DestinationConditionValidator([
            'id' => $this->request->data->destinationCondition->id,
        ]); 

        if ($this->request->data->destinationCondition->allFieldsFoundInSource->areNot(['id'])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationConditionErrors::get('condition_delete_invalid_fields')->asArray());
        } elseif ($destinationConditionValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationConditionErrors::get('condition_with_invalid_id')->asArray());
        }
        
        return true;
    }

}