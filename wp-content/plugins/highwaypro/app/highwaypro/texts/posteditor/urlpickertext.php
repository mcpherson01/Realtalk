<?php

namespace HighWayPro\App\HighWayPro\Texts\Posteditor;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class UrlPickerText extends TextComponent
{
    const name = 'urlPicker';

    protected static function registerTexts()
    {
        return new Collection([
            'enterUrlToSearch' => __("Enter the name of a URL to insert...", Env::textDomain()),
            'noUrls' => [
                'title' => __('No Urls!', Env::textDomain()),
                'message' => __('Search for a URL or try a different URL name', Env::textDomain())
            ]
        ]);
    }
    
}