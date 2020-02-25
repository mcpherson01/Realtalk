<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class DashboardSectionMenuText extends TextComponent
{
    const name = 'dashboardSectionMenu';

    protected static function registerTexts()
    {
        return new Collection([
            'overview' => esc_html__('overview', Env::textDomain()),
            'urls' => esc_html__('urls', Env::textDomain()),
            'types' => esc_html__('types', Env::textDomain()),
            'preferences' => esc_html__('preferences', Env::textDomain()),
        ]);
    }
    
}