<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\HighWayPro\Shortcodes\URLShortcode;
use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Collections\Collection;

Class PlaceHoldersParser
{
    public function __construct($postContent)
    {
        $this->postContent = new StringManager($postContent);
    }

    public function getParsed()
    {
        $this->replaceOpeningTag()
             ->replaceClosingTag();

        return $this->postContent->get();
    }

    protected function replaceOpeningTag()
    {
        $this->postContent = $this->postContent->replaceRegEx(
            '/<hwprourl((\s+[a-zA-Z-]+="[a-zA-Z0-9-]*")+)>/',
            function(array $matches) {
                (object) $groups = new Collection($matches);
                (string) $attributesString = new StringManager($groups->atPosition(2));

                (string) $attributes = $attributesString->replace('data-id', 'url_id')->get();

                return URLShortcode::buildOpeningTag($attributes);
            }
        );

        return $this;   
    }

    protected function replaceClosingTag()
    {
        $this->postContent =  $this->postContent->replace('</hwprourl>', URLShortCode::buildClosingTag());   

        return $this;
    }

}