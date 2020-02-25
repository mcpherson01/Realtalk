<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition\DestinationConditionCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\DestinationComponentCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationConditionErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationErrors;
use HighwayPro\App\Data\Model\DestinationConditions\Validators\DestinationConditionValidator;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Class DestinationConditionCreationValidator extends DestinationComponentCreationValidator
{
    protected $url;

    public function defineRequest()
    {
        return new DestinationConditionCreationRequest;
    }

    protected function getFieldType()
    {
        return $this->request->data->destination->condition->type->get();
    }

    protected function getFieldParameters()
    {
        return $this->request->data->destination->condition->parameters->get();
    }

    public function getComponentValidatorType()
    {
        return DestinationConditionValidator::class;   
    }

    public function getComponentErrorsType()
    {
        return DestinationConditionErrors::class;   
    }

    public function getComponentType()
    {
        return 'condition';   
    }
}