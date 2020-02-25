<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\Data\Model\Posts\Post;

Class PostShortCodeInsertionRegistrator
{
    protected $post;

    public function __construct($post)
    {
        if ($post instanceof Post) {
            $this->post = $post;
            $this->register();
        }   
    }

    protected function register()
    {
        (integer) $lowPriorityToReplacePlaceholdersBeforeShortCodesAreParsed = 1;
        
        add_filter(
            'the_content', 
            [$this->post, 'replacePlaceholdersWithShortcodes'], 
            $lowPriorityToReplacePlaceholdersBeforeShortCodesAreParsed
        );
    }
}