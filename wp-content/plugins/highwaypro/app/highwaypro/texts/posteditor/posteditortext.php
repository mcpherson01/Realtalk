<?php

namespace HighWayPro\App\HighWayPro\Texts\Posteditor;

use HighWayPro\App\HighWayPro\Texts\ApplicationText;
use HighWayPro\App\HighWayPro\Texts\Posteditor\UrlPickerText;
use HighWayPro\Original\Collections\Collection;

Class PostEditorText extends ApplicationText
{
    protected static function register()
    {
        return new Collection([
            UrlPickerText::class,
        ]);
    }
}