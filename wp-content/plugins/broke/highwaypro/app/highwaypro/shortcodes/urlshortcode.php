<?php

namespace HighWayPro\App\HighWayPro\Shortcodes;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Presentation\AttributesManager;
use HighWayPro\Original\Shortcodes\Shortcode;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\PostPreferences;

Class URLShortcode extends Shortcode
{
    const LINK_CLASS = 'hwpsu--link';

    protected static $name = 'url';

    public static function buildOpeningTag(/*string|array*/$attributes = '')
    {
        if (is_array($attributes)) {
            $attributes = new Collection($attributes);

            (string) $attributesDefinition = $attributes->reverse()->reduce(function($carry, $attributeName) use ($attributes) {
                return "{$attributeName}=\"{$attributes->get($attributeName)}\" ";
            }, '')->trim()->get();
        } else {
            (string) $attributesDefinition = ltrim($attributes);
        }

        return '['.static::name()." {$attributesDefinition}]";
    }
    
    public static function buildClosingTag()
    {
        return '[/'.static::name().']';
    }

    protected function map()
    {
        return [
            'url_id' => Types::INTEGER,
            'open_in_new_tab' => Types::BOOLEAN()->withDefault(true),
            'hide_referer' => Types::BOOLEAN()->withDefault(false),
            'no_follow' => Types::BOOLEAN()->withDefault(false),
            'title' => Types::STRING,
            'in_situ_redirect' => Types::BOOLEAN()->withDefault(false)
        ];   
    }

    public function setUp()
    {
        $this->attributes = new AttributesManager;
    }

    public function render()
    {
        if ($this->getUrl() instanceof Url) {
            return trim("
                <a {$this->getHref()}{$this->getTitle()}{$this->getOpensInNewTab()}{$this->getRefererAndNoFollow()}{$this->getClasses()}>{$this->getText()}</a>
            ");   
        }

        return $this->getText();
    }

    protected function getClasses()
    {
        return ' class="'.URLShortcode::LINK_CLASS.'"';
    }
    

    protected function getText()
    {
        if (empty($this->content)) {
            return $this->getFullUrl();
        }

        return esc_html($this->content);   
    }

    protected function getHref()
    {
        return "href=\"{$this->getFullUrl()}\"";   
    }

    protected function getFullUrl()
    {
        if ($this->getUrl() instanceof Url) {
            return $this->getUrl()->getFullUrl();
        }   
    }
    

    protected function getUrl()
    {
        return $this->cache->getIfExists('url')->otherwise(function(){
            (object) $urlGateway = (new UrlGateway(new WordPressDatabaseDriver));
            /*object|null*/ $url = $urlGateway->getWithId($this->properties->url_id);

            return $url;
        });
    }

    protected function getTitle()
    {
        if ($this->properties->title->hasValue()) {
            return $this->attributes->build([
                'name' => 'title',
                'value' => $this->properties->title
            ]);
        }
    }

    protected function getOpensInNewTab()
    {
        // future release will make $this->properties->open_in_new_tab take precedense
        if ($this->getUrl()) {
            switch ((string) $this->getUrl()->getClickBehaviour()) {
                case PostPreferences::BEHAVIOUR_CURRENT_CONTEXT:
                    return ' target="_self"';
                    break;
                case PostPreferences::BEHAVIOUR_NEW_CONTEXT:
                    return ' target="_blank"';
                    break;
                case PostPreferences::BEHAVIOUR_IN_SITU:
                    return ' data-target="'.PostPreferences::BEHAVIOUR_IN_SITU.'"';
                    break;
            }
        }   
    }

    protected function getRefererAndNoFollow()
    {
        (object) $relationships = new Collection([]);

        if ($this->properties->hide_referer) {
            $relationships->push('noreferrer');
        }

        if ($this->getUrl()->getFollowType()->is(PostPreferences::FOLLOW_TYPE_NO)) {
            $relationships->push('nofollow');
        }

        if ($relationships->haveAny()) {
            return $this->attributes->build([
                'name' => 'rel',
                'value' => $relationships->implode(' ')
            ]);
        }
    }
}