<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\RefererCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors\DirectTargetErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\HighwayPro\HTTP\Responses\Redirection;
use HighwayPro\Original\Collections\Mapper\Types;

/*
    Redirects to a supplied url
    url needs to have a protocol, a host and a path
*/
Class DirectTarget extends DestinationTargetComponent
{
    const name  = 'highwaypro.DirectTarget';

    public static function title()
    {
        return __('Direct URL', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Redirect to specific URL.', Env::textDomain());
    }

    public static function description()
    {
        return __("Redirect to a specific URL. It is recommended to include protocol, for example, https.\nAn example of valid urls include: https://google.com and google.com\n", Env::textDomain());
    }

    protected function parametersMap()
    {
        return [
            'url' => Types::STRING()->escape(Types::returnValueCallable())
        ];
    }

    public function response()
    {
        return (new Redirection)->to($this->getUrl($this->getUrlWithScheme()));
    }

    public function getUrlWithScheme()
    {
        (object) $urlComponents = new Collection(parse_url($this->parameters->url));
        
        if (!$urlComponents->hasKey('scheme')) {
            return "//{$this->parameters->url}";
        }

        return $this->parameters->url;
    }
    

    public function validateParameters()
    {
        if ($this->parameters->url->isEmpty()) {
            return DirectTargetErrors::get('no_target_url');
        } 
        // Let's relax the URL requirements, as matching multiple schemas, subdomains, extensions and the ultra wide range of accepted URL characters is not a god idea.
        /*elseif (!$this->parameters->url->matches(static::URL_REGEX)) {
            return DirectTargetErrors::get('invalid_url_format');
        }*/

        return true;
    }
}