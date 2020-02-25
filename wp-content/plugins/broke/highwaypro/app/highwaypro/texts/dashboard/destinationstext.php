<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class DestinationsText extends TextComponent
{
    const name = 'destinations';

    protected static function registerTexts()
    {
        return new Collection([
            'lastConditionMessage' => esc_html__('A 404 (not found) response will be sent if neither of the destinations above matched a conditon ', Env::textDomain()),
            'newDestination' => esc_html__('New Destination', Env::textDomain()),


            'noDestinationsTitle' => esc_html__('No destinations for this url yet!', Env::textDomain()),
            'noDestinationsMessage' => esc_html__('This url needs at least one destination. You can add one or more by clicking the button below.', Env::textDomain()),

            'loading' => esc_html__('Loading Destinations', Env::textDomain()),


            'selectATypeTitle' => esc_html__('Select a *', Env::textDomain())
        ]);
    }
    
}