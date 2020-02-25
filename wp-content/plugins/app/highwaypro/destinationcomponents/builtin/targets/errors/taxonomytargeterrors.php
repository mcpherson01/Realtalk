<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class TaxonomyTargetErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'no_term_id',
                'message' => 'Empty term id. This target requires a valid term id.'
            ],
            [
                'type' => 'nonexistent_term',
                'message' => 'NonExistent term. This target requires a valid term id.'
            ],
        ];
    }
}

