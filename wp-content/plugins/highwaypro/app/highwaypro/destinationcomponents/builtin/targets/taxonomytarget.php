<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors\TaxonomyTargetErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\HighwayPro\HTTP\Responses\NotFoundResponse;
use HighwayPro\App\HighwayPro\HTTP\Responses\Redirection;
use HighwayPro\Original\Collections\Mapper\Types;
use WP_Error;

Class TaxonomyTarget extends DestinationTargetComponent
{
    const event = 'wp_loaded';
    
    const name  = 'highwaypro.TaxonomyTarget';

    public static function title()
    {
        return __('Taxonomy (Category, Tag, ...)', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Redirect to a taxonomy term page, like a category or tag.', Env::textDomain());
    }

    public static function description()
    {
        return __("Redirect to a specific taxonomy term. For example, a specific category on your site.\nAll registered taxonomies are supported, included those registered by plugins, like a WooCommerce product category.", Env::textDomain());
    }

    protected function parametersMap()
    {
        return [
            'termId' => Types::INTEGER
        ];
    }

    public function response()
    {
        $termLink = get_term_link($this->parameters->termId);

        if ($termLink instanceof WP_Error) {
            return new NotFoundResponse;
        }

        return (new Redirection)->to($this->getUrl($termLink));
    }

    public function validateParameters()
    {
        if ($this->parameters->termId < 1) {
            return TaxonomyTargetErrors::get('no_term_id');
        } elseif (((integer) term_exists($this->parameters->termId)) <= 0) {
            return TaxonomyTargetErrors::get('nonexistent_term');; 
        }

        return true;
    }
}