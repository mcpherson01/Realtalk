<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors\PostTargetErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\HighwayPro\HTTP\Responses\NotFoundResponse;
use HighwayPro\App\HighwayPro\HTTP\Responses\Redirection;
use HighwayPro\Original\Collections\Mapper\Types;
/*
    Redirects to a post type with an spceific id, or 
    to the lastest post with type of post.
    Custom post types by id are supported
*/
Class PostTarget extends DestinationTargetComponent
{
    const event = 'setup_theme';
    const name  = 'highwaypro.PostTarget';

    public static function title()
    {
        return __('Post Type (Post, Page, ...)', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Redirect to a post type entry.', Env::textDomain());
    }

    public static function description()
    {
        return __("Redirect to a WordPress post type like a post, page or WooCommerce product, or to the newest published post.\nAll registered post types are supported, including those registered by third party plugins, like a WooCommerce product.", Env::textDomain());
    }

    protected function getAllowedValues()
    {
        return new Collection([
            'types' => new Collection([
                'newest' => 'Newest',
                'withid' => 'With Specific Id'
            ])
        ]);
    }

    protected function parametersMap()
    {
        return [
            'type' => Types::STRING,
            'id' => Types::INTEGER, // the post ID
            'queryString' => Types::STRING
        ];
    }
    
    public function response()
    {
        if ($this->postIs('withid')) {
            $post = $this->getPostById();
        } else {
            $post = $this->getNewestPost();
        }

        if (is_object($post)) {
            return (new Redirection)->to($this->getUrl(get_the_permalink($post->ID)));
        }

        return new NotFoundResponse;
    }

    protected function getNewestPost()
    {
        return wp_get_recent_posts(
                ['numberposts'=>1, 'post_type'=>'post', 'post_status'=>'publish'], 
                OBJECT
            )[0];   
    }

    protected function getPostById()
    {
        return get_post($this->parameters->id, OBJECT); 
    }

    protected function postIs($type)
    {
        return $this->parameters->type->is($type);   
    }

    public function validateParameters()
    {
        if ($this->parameters->type->isNotEither($this->allowed->get('types')->getKeys())) {
            return PostTargetErrors::get('invalid_type');
        } elseif ($this->parameters->type->is('withid')) {
            if ($this->parameters->id < 1) {
                return PostTargetErrors::get('empty_post_id');
            } elseif (get_post_status($this->parameters->id) === false) {
                return PostTargetErrors::get('invalid_post_id');
            }
        }

        return true;
    }
}