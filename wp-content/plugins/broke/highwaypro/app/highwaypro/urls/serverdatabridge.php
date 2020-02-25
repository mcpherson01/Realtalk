<?php

namespace Highwaypro\app\highWayPro\urls;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\App\HighWayPro\Texts\Dashboard\HighWayProDashBoardText;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\UrlViews\UrlViewGateway;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class ServerDataBridge
{
    public static function get()
    {
        (string) $url = get_option('siteurl');

        return new Collection([
            'name' => 'HighWayPro',
            'data' => new Collection([
                'preferences' => json_decode(Preferences::get()->exportWithAllowedValues()),
                'urls' =>  [
                    'url' => $url,
                    'dashboardUrl' => Env::directoryURI().Env::settings()->directories->app->dashboard,
                    'domainAndBase' => parse_url($url, PHP_URL_HOST).parse_url($url, PHP_URL_PATH),
                    'branding' => Env::directoryURI().Env::settings()->directories->storage->branding
                ],
                'components' => URLComponentsRegistrator::get()->all()->mapWithKeys(function($urlComponent) {
                    return [
                        'key' => strtolower($urlComponent::name),
                        'value' => $urlComponent::getMetaData()->asArray()
                    ];  
                }),
                'conditionData' => DestinationConditionComponent::description(),
                'targetData' => DestinationTargetComponent::description(),
                'urlExtras' => [
                    'default' => UrlExtra::defaults()
                ],
                'postTypes' => (new Collection(get_post_types(['public' => true], 'objects')))->map(function($postType){
                                    return [
                                        'name' => esc_html($postType->name),
                                        'label' => esc_html($postType->label)
                                    ];
                                })->getValues(),
                'text' => (new HighWayProDashBoardText)->getTexts(),
                'analytics' => [
                    'NA_KEY' => UrlViewGateway::NA_KEY
                ]
            ])
        ]);
    }
    
}