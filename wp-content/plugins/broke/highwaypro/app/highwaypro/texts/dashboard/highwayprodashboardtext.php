<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\ApplicationText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\AnalyticsText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\DashboardSectionMenuText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\DestinationsText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\OtherText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\PreferencesText;
use HighWayPro\App\HighWayPro\Texts\Dashboard\UrlsText;
use HighWayPro\Original\Collections\Collection;

Class HighWayProDashBoardText extends ApplicationText
{
    protected static function register()
    {
        return new Collection([
            DashboardSectionMenuText::class,
            AnalyticsText::class,
            UrlsText::class,
            DestinationsText::class,
            PreferencesText::class,
            OtherText::class,
            TourText::class
        ]);
    }
}