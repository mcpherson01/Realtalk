<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\Controllers\DestinationCondition\DestinationConditionCreatorController;
use HighWayPro\App\HighWayPro\Controllers\DestinationCondition\DestinationConditionDeleterController;
use HighWayPro\App\HighWayPro\Controllers\DestinationTarget\DestinationTargetCreatorController;
use HighWayPro\App\HighWayPro\Controllers\Destination\DestinationCreatorController;
use HighWayPro\App\HighWayPro\Controllers\Destination\DestinationDeleterController;
use HighWayPro\App\HighWayPro\Controllers\Destination\DestinationUpdaterController;
use HighWayPro\App\HighWayPro\Controllers\Destination\DestinationsReaderController;
use HighWayPro\App\HighWayPro\Controllers\Posts\PostsReaderController;
use HighWayPro\App\HighWayPro\Controllers\Posts\TermsReaderController;
use HighWayPro\App\HighWayPro\Controllers\Preferences\PreferencesUpdaterController;
use HighWayPro\App\HighWayPro\Controllers\UrlExtra\UrlExtraReaderController;
use HighWayPro\App\HighWayPro\Controllers\UrlExtra\UrlExtraUpdaterController;
use HighWayPro\App\HighWayPro\Controllers\UrlType\UrlTypeCreatorController;
use HighWayPro\App\HighWayPro\Controllers\UrlType\UrlTypeUpdaterController;
use HighWayPro\App\HighWayPro\Controllers\UrlType\UrlTypesReaderCreatorController;
use HighWayPro\App\HighWayPro\Controllers\UrlView\UrlViewStatisticsReaderController;
use HighWayPro\App\HighWayPro\Controllers\Url\UrlCreatorController;
use HighWayPro\App\HighWayPro\Controllers\Url\UrlDeleterController;
use HighWayPro\App\HighWayPro\Controllers\Url\UrlReaderController;
use HighWayPro\App\HighWayPro\Controllers\Url\UrlUpdaterController;
use HighWayPro\App\HighWayPro\Controllers\Url\UrlsReaderController;
use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\HTTP\Router;
use HighWayPro\Original\Events\Handler\EventHandler;

Class HighWayProPOSTRequestHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        (object) $router = new Router();

        $router->setErrorSupression();
        
        $router->addController(UrlCreatorController::getRegistrationData());
        $router->addController(UrlsReaderController::getRegistrationData());
        $router->addController(UrlReaderController::getRegistrationData());
        $router->addController(UrlUpdaterController::getRegistrationData());
        $router->addController(UrlDeleterController::getRegistrationData());

        $router->addController(UrlTypeCreatorController::getRegistrationData());
        $router->addController(UrlTypesReaderCreatorController::getRegistrationData());
        $router->addController(UrlTypeUpdaterController::getRegistrationData());

        $router->addController(DestinationCreatorController::getRegistrationData());
        $router->addController(DestinationsReaderController::getRegistrationData());
        $router->addController(DestinationUpdaterController::getRegistrationData());
        $router->addController(DestinationDeleterController::getRegistrationData());

        $router->addController(DestinationConditionCreatorController::getRegistrationData());
        $router->addController(DestinationConditionDeleterController::getRegistrationData());

        $router->addController(DestinationTargetCreatorController::getRegistrationData());

        $router->addController(UrlExtraUpdaterController::getRegistrationData());
        $router->addController(UrlExtraReaderController::getRegistrationData());

        $router->addController(PreferencesUpdaterController::getRegistrationData());

        $router->addController(PostsReaderController::getRegistrationData());

        $router->addController(TermsReaderController::getRegistrationData());

        $router->addController(UrlViewStatisticsReaderController::getRegistrationData());

        $router->handle(new Request);
    }
}