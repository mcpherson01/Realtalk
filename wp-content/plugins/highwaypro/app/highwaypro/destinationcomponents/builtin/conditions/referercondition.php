<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\RefererConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Collections\Mapper\Types;
use HighWayPro\Original\Environment\Env;

Class RefererCondition extends DestinationConditionComponent
{
    const DOMAIN_REGEX = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
    const URL_REGEX = '/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/';
    const name = 'highwaypro.RefererCondition';

    public static function title()
    {
        return __('Referer', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Limit access by origin.', Env::textDomain());
    }

    public static function description()
    {
        return __("Limit access by the web page or domain the short url is being attempted to be accessed from.\nFor example, you may want to give access to the destination target only when the short URL link has been clicked from a specific page or website, like google.com.\nYou may specify whole domains or specific URLs only.\nPlease note this condition is subject to the correct implementation of the HTTP Referer header. If your domain has a non-secure protocol (http) and your link is clicked from a site with a secure domain (https), this condition will not work as expected.", Env::textDomain());
    }

    protected function parametersMap()
    {
        return [
            'domains' => Types::Collection()->escape(Types::returnValueCallable()),
            'urls' => Types::Collection()->escape(Types::returnValueCallable())
        ];
    }

    public function hasPassed()
    {
        (string) $url = (string) Collection::create($_SERVER)->get('HTTP_REFERER');
        (array) $urlElements = parse_url($url);
        (string) $domain = (string) Collection::create(is_array($urlElements)? $urlElements : [])->get('host');

        if ($this->parameters->domains->haveAny()) {
            if ($this->parameters->domains->contain($domain)) {
                return true;
            }
        }

        if ($this->parameters->urls->haveAny()) {
            if ($this->parameters->urls->contain($url)) {
                return true;
            }
        }

        return false;
    }

    public function validateParameters()
    {
        if ($this->parameters->domains->haveNone() && $this->parameters->urls->haveNone()) {
            return RefererConditionErrors::get('no_referers_specified');
        } elseif ($this->parameters->domains->haveAny() && !$this->parameters->domains->allMatch(Static::DOMAIN_REGEX)) {
            return RefererConditionErrors::get('invalid_domain_format');
        } elseif ($this->parameters->urls->haveAny() && !$this->parameters->urls->allMatch(Static::URL_REGEX)) {
            return RefererConditionErrors::get('invalid_url_format');
        }

        return true;
    }
}