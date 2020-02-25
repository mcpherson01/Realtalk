<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationConditionErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\DestinationErrors;
use HighwayPro\App\Data\Model\destinations\Validators\DestinationValidator;

Abstract Class DestinationComponentCreationValidator extends Validator
{
    protected $url;

    abstract public function defineRequest();

    abstract protected function getFieldType();
    abstract protected function getFieldParameters();

    abstract public function getComponentValidatorType();
    abstract public function getComponentErrorsType();

    /**
     * condition, target
     */
    abstract public function getComponentType();

  # optional protected function additionalValidations();

    protected function request()
    {
        return $this->defineRequest();
    }

    public function validate()
    {

        (object) $destinationValidator = new DestinationValidator([
            'url_id' => $this->request->data->url->id,
            'id' => $this->request->data->destination->id
        ]); 

        (string) $destinationComponentValidator = $this->getComponentValidatorType();

        (object) $destinationComponentValidator = new $destinationComponentValidator([
            'id' => $this->request->data->destination->{$this->getComponentType()}->id,
            'destination_id' => $this->request->data->destination->id,
            'type' => $this->getFieldType(),
            'parameters' => $this->getFieldParameters()
        ]);

        (string) $DestinationComponentErrors = $this->getComponentErrorsType();

        if ($this->request->data->url->id <= 0) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('url_with_no_id')->asArray());
        } elseif ($destinationValidator->urlDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_url_id')->asArray());
        } elseif ($this->request->data->destination->id <= 0) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_no_id')->asArray());
        } elseif ($destinationValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(DestinationErrors::get('destination_with_invalid_destination_id')->asArray());
        } elseif ($destinationValidator->urlIsNotAssociatedWithDestination()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(DestinationErrors::get('destination_with_mismatched_url_id')->asArray());
        } elseif ($destinationComponentValidator->componentHasNoIdButDestinationAlreadyHasAComponentAssociatedWithIt()) {
            return (new Response)->withStatusCode(409)
                                 ->containing($DestinationComponentErrors::get("new_{$this->getComponentType()}_destination_with_{$this->getComponentType()}")->asArray());
        } elseif ($destinationComponentValidator->destinationHasAComponentWithADiferentId()) {
            return (new Response)->withStatusCode(409)
                                 ->containing($DestinationComponentErrors::get("destination_with_{$this->getComponentType()}_with_different_id")->asArray());
        } elseif (!$destinationComponentValidator->typeIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing($DestinationComponentErrors::get("{$this->getComponentType()}_with_invalid_type")->asArray());
        } elseif (!$destinationComponentValidator->parameterIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing($destinationComponentValidator->getParameterError()->asArray());
        }

        return true;
    }

}