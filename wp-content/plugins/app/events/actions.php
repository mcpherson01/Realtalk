<?php

return [
    'plugins_loaded' => [
        'HighWayPro\\App\\Handlers\\HighWayProInitializationHandler',
        'HighWayPro\\App\\Handlers\\TextDomainHandler',
    ],
    'highwaypro_register_destination_component' => [
        'HighWayPro\\App\\Handlers\\BuilInDestinationComponentsRegistratorHandler',
    ],
    'init' => [
        'HighWayPro\\App\\Handlers\\ShortCodesRegistratorHandler',
        'HighWayPro\\App\\Handlers\\TinyMCERegistratorHandler',
        'HighWayPro\\App\\Handlers\\PostMetaHanlder',
    ],
    'wp' => [
        'HighWayPro\\App\\Handlers\\OpenGraphThirdPartyCompatibilityHandler',
        'HighWayPro\\App\\Handlers\\PostFeaturesRegistratorHandler',
    ],
    'admin_post_highwaypro_post' => [
        'HighWayPro\\App\\Handlers\\HighWayProPOSTRequestHandler',
    ],
    'admin_post_nopriv_highwaypro_post' => [
        'HighWayPro\\App\\Handlers\\NonAdminUnallowedAccessHandler',
    ],
    'admin_menu' => [
        'HighWayPro\\App\\Handlers\\DashboardRegistrationHandler',
    ],
    'admin_enqueue_scripts' => [
        'HighWayPro\\App\\Handlers\\DashboardScriptsHandler',
    ],
    'wp_enqueue_scripts' => [
        'HighWayPro\\App\\Handlers\\FrontEndScriptsRegistrator',
    ],
];