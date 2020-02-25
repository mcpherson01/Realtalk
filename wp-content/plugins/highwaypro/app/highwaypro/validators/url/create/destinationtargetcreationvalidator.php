<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationTarget\DestinationTargetCreationRequest;
use HighWayPro\App\HighWayPro\Validators\Url\Create\DestinationComponentCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationTargetErrors;
use HighwayPro\App\Data\Model\DestinationTargets\Validators\DestinationTargetValidator;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Class DestinationTargetCreationValidator extends DestinationComponentCreationValidator
{
    public function defineRequest()
    {
        return new DestinationTargetCreationRequest;
    }

    protected function getFieldType()
    {
        return $this->request->data->destination->target->type->get();
    }

    protected function getFieldParameters()
    {
        return $this->request->data->destination->target->parameters->get();
    }

    public function getComponentValidatorType()
    {
        return DestinationTargetValidator::class;   
    }

    public function getComponentErrorsType()
    {
        return DestinationTargetErrors::class;   
    }

    public function getComponentType()
    {
        return 'target';   
    }
}




