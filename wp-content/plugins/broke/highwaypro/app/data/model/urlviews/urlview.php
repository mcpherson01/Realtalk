<?php

namespace HighwayPro\App\Data\Model\UrlViews;

use DeviceDetector\DeviceDetector;
use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\Location\LocationDetector;
use HighWayPro\Original\Data\Model\Domain;
use HighwayPro\App\Data\Model\Destinations\Destination;

Class UrlView extends Domain
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    
    public static function create(Destination $destination, $date = null)
    {
        (object) $request = new Request;
        (object) $deviceDetector = new DeviceDetector($request->getUserAgent());
        (object) $locationDetector = new LocationDetector($_SERVER['REMOTE_ADDR']);

        $deviceDetector->parse();

        return new Static([
            'destination_id' => $destination->id,
            'device_type' => $deviceDetector->getDeviceName(),
            'device_name' => $deviceDetector->getModel(),
            'device_os' => isset($deviceDetector->getOs()['name'])? $deviceDetector->getOs()['name'] : '',
            'device_browser' => isset($deviceDetector->getClient()['name'])? $deviceDetector->getClient()['name'] : '',
            'device_browser_version' => isset($deviceDetector->getClient()['version'])? $deviceDetector->getClient()['version'] : '',
            'device_user_agent' => $request->getUserAgent(),
            'device_referer' => $request->getReferer(),
            'location_country' => $locationDetector->getCountry(),
            'location_continent' => $locationDetector->getContinent(),
            'location_language' => $request->getLanguage(),
            'date' => $date? $date : date(Static::DATE_FORMAT)
        ]);
    }
}