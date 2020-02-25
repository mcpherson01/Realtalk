<?php

namespace HighwayPro\App\Data\Model\UrlExtra;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Collections\Mapper\Types;
use HighWayPro\Original\Data\Model\Domain;

Class UrlExtra extends Domain
{
    const DEFAULT_CONTEXT = 'post';

    public static function fields()
    {
        return new Collection([
            'id' => Types::INTEGER,
            'url_id' => Types::INTEGER,
            'name' => Types::STRING,
            'value' => Types::STRING()->escape(Types::returnValueCallable()),
            'type' => Types::STRING,
            'context' => Types::COLLECTION
        ]);   
    }

    public static function validUpdateableFields()
    {
        return [
            'keyword_injection_keywords', 
            'keyword_injection_context', 
            'keyword_injection_limit',


            'link_placement_click_behaviour',
            'link_placement_follow_type',
            'link_placement_title_attribute'
        ];
    }
    

    public static function defaults()
    {
        return [
            /**
             * Dynamic insertion
             */
            new static([
                'name' => 'keyword_injection',
                'value' => '',
                'context' => self::DEFAULT_CONTEXT
            ]),
            new static([
                'name' => 'keyword_injection_limit',
                'value' => -1,
                'context' => self::DEFAULT_CONTEXT
            ]),
            /**
             * Link Placement
             */
            new static([
                'name' => 'link_placement_click_behaviour',
                'value' => '',
                'context' => self::DEFAULT_CONTEXT
            ]),
            new static([
                'name' => 'link_placement_follow_type',
                'value' => '',
                'context' => self::DEFAULT_CONTEXT
            ]),
            new static([
                'name' => 'link_placement_title_attribute',
                'value' => '',
                'context' => self::DEFAULT_CONTEXT
            ])
        ];   
    }

    protected function map()
    {
        return self::fields()->asArray();   
    }
 
    protected function beforeInsertion()
    {
        if ($this->context->haveNone()) {
            $this->context->push(static::DEFAULT_CONTEXT);
        }
    }        
          
}