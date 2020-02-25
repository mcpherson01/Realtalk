<?php

namespace Highwaypro\App\Data\Model\Preferences;

use HighWayPro\App\HighWayPro\Posts\WordPressPostTypes;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class SocialPreferences extends Preferences
{
    static public function fields()
    {
        return new Collection([
            'og_url_is_enabled' => Types::BOOLEAN()->withDefault(false),
            'og_url_post_types_enabled' => Types::COLLECTION()->withDefault(['post', 'page'])
                                                              ->allowed(
                                                                WordPressPostTypes::get()->reverse()->asArray())
        ]);
    }
    
    protected function getMap()
    {
        return static::fields()->asArray();
    }

    public function validateField(Collection $field)
    {
        if (((string) $field->get('name')) === 'og_url_post_types_enabled') {
            return static::fields()->get('og_url_post_types_enabled')
                                   ->getAllowedValues()
                                   ->getValues()
                                   ->containAll($field->get('value'));
        }

        return parent::validateField($field);
    }
}