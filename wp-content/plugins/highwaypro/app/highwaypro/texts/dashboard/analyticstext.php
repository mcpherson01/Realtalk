<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class AnalyticsText extends TextComponent
{
    const name = 'analytics';

    protected static function registerTexts()
    {
        return new Collection([
            'notEnoughDataTitle' => esc_html__('Not Enough Data', 'highwaypro-international'),

            'notEnoughDataMessageCountry' => esc_html__('There are not enough clicks to show country stats.', Env::textDomain()),
            'notEnoughDataMessageDevice' => esc_html__('There are not enough clicks to show device stats.', Env::textDomain()),
            'notEnoughDataMessageOrigin' => esc_html__('There are not enough clicks to show origin stats.', Env::textDomain()),

            'loadingMessage' => esc_html__('Loading Analytics...', Env::textDomain()),

            'clicksOverviewTitle' => esc_html__('Clicks Overview', Env::textDomain()),
            'clicksOverviewMessage' => esc_html__('All URLS including auto generated URLS', Env::textDomain()),

            'allTimeLabel' => esc_html__('All Time', Env::textDomain()),
            'todayLabel' => esc_html__('Today', Env::textDomain()),
            'lastDayLabel' => esc_html__('Yesterday', Env::textDomain()),
            'thisMonthLabel' => esc_html__('This Month', Env::textDomain()),

             'countryClicksTitle' => esc_html__('Clicks by Country', Env::textDomain()),
             'countryClicksMessage' => esc_html__("The location of the request’s IP", Env::textDomain()),

             'deviceClicksTitle' => esc_html__('Clicks by Device', Env::textDomain()),
             'deviceClicksMessage' => esc_html__('The device type used to access the URL', Env::textDomain()),

             'originClicksTitle' => esc_html__('Clicks Origin', Env::textDomain()),
             'originClicksMessage' => esc_html__('The page the link was clicked from. Untracked if the, user accessed the url from the browser adress bar.',Env::textDomain()),

             'NA' => esc_html__('Not Available', Env::textDomain()),
             'NA_SHORT' => esc_html__('N/A', Env::textDomain())
        ]);
    }
    
}