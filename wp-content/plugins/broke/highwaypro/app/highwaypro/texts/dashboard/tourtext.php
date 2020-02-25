<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class TourText extends TextComponent
{
    const name = 'tour';

    protected static function registerTexts()
    {
        (string) $highwayproDocsUrl = "https://s.neblabs.com/docs";
        
        return new Collection([
            'dashboard' => [
                'tabs' => [
                    'overview' => [
                        'title' => esc_html__('View combined stats', Env::textDomain()),
                        'message' => esc_html__('This is the place combined stats for all your URLs are shown. You may view individual URL stats in the next section.', Env::textDomain()),
                    ],
                    'urls' => [
                        'title' => esc_html__('Manage your URLs', Env::textDomain()),
                        'message' => esc_html__('This section allows you to create and update URLs, view detailed stats per URL and more. You can also manager other URL-related features like automatic insertions within your atricles and the behaviour of in-content links.', Env::textDomain()),
                    ],
                    'urlTypes' => [
                        'title' => esc_html__('Group similar URLs together', Env::textDomain()),
                        'message' => esc_html__('URL Types allow you to categorize and group similar URLs together. You can also optionally assign a base path that will be used by all URLs that are associated with the URL Type. For example, you can create a type for all your affiliate links and another for all your social media links.', Env::textDomain()),
                    ],
                    'preferences' => [
                        'title' => esc_html__('Manage global preferences', Env::textDomain()),
                        'message' => esc_html__('Enable/disable features, set defaults and more.', Env::textDomain()),
                    ],
                ],
                'startCreatingUrl' => [
                    'title' => esc_html__("Let's create a new URL", Env::textDomain()),
                    'message' => esc_html__("Click on the URLs tab to begin. We will be creating a simple URL with a single destination.", Env::textDomain()),
                ]
            ],
            'CreateUrlSidebarTour' => [
                '1' => [
                    'title' => esc_html__("Click New + to add a new URL", Env::textDomain()),
                    'message' => esc_html__("Click New + to continue", Env::textDomain()),
                ]
            ],
            'CreateUrlWindowInputTour' => [
                '1' => [
                    'title' => esc_html__("The URL name", Env::textDomain()),
                    'message' => esc_html__("Let's give our URL a meaningful name. This is not public, the URL name helps you easily locate the URL later on. We will be redirecting to google in this example, so let's type: \"Google HomePage\"", Env::textDomain()),
                ],
                '2' => [
                    'title' => esc_html__("The URL path", Env::textDomain()),
                    'message' => esc_html__("The URL path is the last portion of the URL, after the domain name and extension (and after the subdirectory if your site is installed in a subfolder). You can only enter a single path segment (/), multiple path segments (eg: /one/two) are not allowed. You can specify a base path by selecting a URL type (see next step). As we are redirecting to google, let's set the path to \"/google\"", Env::textDomain()),
                ],
                '3' => [
                    'title' => esc_html__("The URL Type", Env::textDomain()),
                    'message' => esc_html__("You can assign a type to the URL in order to group it together with other related URLs. This is where you can assign a base path to the URL. For example, if the path is /google, in order for the URL to be: /resources/google, a URL Type with a /resources base path must be assigned to the URL. We don't have any URL Types yet, so for this example we will ignore this. You can always create and manage URL Types by clicking the URL Types tab. For now, let's just save this url. Click Next to continue.", Env::textDomain()),
                ],
                '4' => [
                    'title' => esc_html__("Let's save this URL", Env::textDomain()),
                    'message' => esc_html__("Alright, Click on Create to save this URL.", Env::textDomain()),
                ]
            ],
            'UrlContentOverViewTour' => [
                '1' => [
                    'title' => esc_html__("The URL Header", Env::textDomain()),
                    'message' => esc_html__("This section contains information about the current URL. You can update the type (base), path and name by simply typing or selecting the new value and clicking on an empty area of the screen to save it. Let's try updating the name. Click on the name (\"Google HomePage\") and replace \"HomePage\" with \"Search\". Click elsewhere on the screen to save it.", Env::textDomain()),
                ],
                '2' => [
                    'title' => esc_html__("Analytics & Routes", Env::textDomain()),
                    'message' => esc_html__("The URL section is divided in two main subsections: Analytics and Routes. You can view the stats for this URL in the Analytics section. The Routes section is where you can manage the behaviour of the current URL.", Env::textDomain()),
                ],
                '3' => [
                    'title' => esc_html__("Destinations", Env::textDomain()),
                    'message' => esc_html__("Destinations are the core of a URL. A URL is composed of one or more Destinations. This is where you can specify where and under what conditions the URL will be redirected. We will get back to this section soon. Click next to continue.", Env::textDomain()),
                ],
                '4' => [
                    'title' => esc_html__("Tools & Preferences", Env::textDomain()),
                    'message' => esc_html__("You can manage useful features like optionally inserting the URL in your site content by specifying the keywords that should be used to insert this link, among other options.", Env::textDomain()),
                ],
                '5' => [
                    'title' => esc_html__("Let's add a simple destination", Env::textDomain()),
                    'message' => esc_html__("Click on New Destination to add a destination to this URL.", Env::textDomain()),
                ]
            ],
            'DestinationOverViewTour' => [
                '1' => [
                    'title' => esc_html__("Destinations", Env::textDomain()),
                    'message' => esc_html__("This is a destination. HighWayPro supports multiple destinations per URL. A destination can have an optional condition that limits the final target, and the target the destination will redirect to. In this example, we will add a simple target with no conditions. Click Next to continue.", Env::textDomain()),
                ],
                '2' => [
                    'title' => esc_html__("Targets", Env::textDomain()),
                    'message' => esc_html__("Targets hold the final target URL the user will be redirected to. Targets are ignored when the condition for the same destination has failed. Conditions are optional, in this example, we will create a simple target that will redirect to google.com. Click on the target area to view the available targets.", Env::textDomain()),
                ]
            ],
            'TargetMenuListTour' => [
                '1' => [
                    'title' => esc_html__("Direct Target", Env::textDomain()),
                    'message' => esc_html__("This is the most basic target. It sets the target to a plain URL. Click on the menu item to continue", Env::textDomain()),
                ],
            ],
            'DirectTargetInputTour' => [
                '1' => [
                    'title' => esc_html__("Let's redirect to Google", Env::textDomain()),
                    'message' => esc_html__("This is the URL that will be used to redirect the request. In  this example, we are redirecting to Google, so type: \"google.com\" to continue", Env::textDomain()),
                ],
                '2' => [
                    'title' => esc_html__("Save the Target", Env::textDomain()),
                    'message' => esc_html__("Alright, this is all we need. Click OK to save this target.", Env::textDomain()),
                ]
            ],
            'ViewUrlTour' => [
                '1' => [
                    'title' => esc_html__("Congratulations, your first URL is ready!", Env::textDomain()),
                    'message' => str_replace(
                        "*here*", 
                        "<a href=\"{$highwayproDocsUrl}\" target=\"_blank\">here</a>",
                        esc_html__(
                            "Click \"View\" to finish this tour. You can learn more about all the features *here*.",
                            Env::textDomain()
                        )
                    )
                ],
            ],
        ]);
    }
    
}