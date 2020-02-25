<?php

namespace Highwaypro\App\Data\Model\Preferences;

use HighWayPro\App\HighWayPro\Posts\WordPressPostTypes;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PostPreferences extends Preferences
{
    const BEHAVIOUR_CURRENT_CONTEXT = 'open_in_current_context';
    const BEHAVIOUR_NEW_CONTEXT     = 'open_in_new_context';
    const BEHAVIOUR_IN_SITU         = 'open_in_situ';


    const FOLLOW_TYPE_NO            = 'no-follow';
    const FOLLOW_TYPE_DO            = 'do-follow';
    
    static public function fields()
    {
        return new Collection([
            'keyword_injection_is_enabled' => Types::BOOLEAN()->withDefault(true),
            'keyword_injection_post_types_enabled' => Types::COLLECTION()->withDefault(['post'])
                                                        ->allowed(WordPressPostTypes::get()
                                                                  ->add('all', 'All')
                                                                  ->reverse()),
            'keyword_injection_limit' => Types::INTEGER()->withDefault(4),
          // keyword_injection_limit: this is per keyword
            'link_placement_click_behaviour' => Types::STRING()
                     ->withDefault(self::BEHAVIOUR_CURRENT_CONTEXT)
                     ->allowed([
                         'Open In Current Tab (Default)'        => self::BEHAVIOUR_CURRENT_CONTEXT, 
                         'Open In New Tab'                       => self::BEHAVIOUR_NEW_CONTEXT,
                         ]),
                         /*coming soon, has been postponed to v 1.1*///'In Situ (redirection with JavaScript)' => self::BEHAVIOUR_IN_SITU
                         //,
            'link_placement_follow_type' => Types::STRING()
                                                     ->withDefault(self::FOLLOW_TYPE_NO)
                                                     ->allowed([
                                                         self::FOLLOW_TYPE_NO,
                                                         self::FOLLOW_TYPE_DO
                                                     ]),
        ]);
    }
    
    protected function getMap()
    {
        return static::fields()->asArray();
    }
}