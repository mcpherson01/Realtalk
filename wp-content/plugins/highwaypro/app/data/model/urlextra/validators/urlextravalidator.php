<?php

namespace HighwayPro\App\Data\Model\UrlExtra\Validators;

use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\UrlExtra\Validators\InvalidKeywordsTypeException;

Class UrlExtraValidator
{
    protected $fields;
    
    public function __construct(Array $fields)
    {
        $this->fields = new Collection($fields);   
    }

    public function validateInjectionKeywords()
    {
        if (!($this->fields->get('keyword_injection_keywords') instanceof StringManager)) {
            (string) $type = gettype($this->fields->get('keyword_injection_keywords'));

            throw new InvalidKeywordsTypeException("Invalid keywords type, received: {$this->fields->get('keyword_injection_keywords')} ({$type})");
        }
    }   
}