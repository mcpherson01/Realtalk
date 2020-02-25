<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use DeviceDetector\DeviceDetector;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\DeviceConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class DeviceCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.DeviceCondition';

    public static function title()
    {
        return __('Device', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Target users by their device.', Env::textDomain());
    }

    public static function description()
    {
        return __("Target users by the device they use when making the request.\nYou can target specific device types like smartphones or desktops, or operative systems like iOS or Windows.\nYou can select multiple options. For example, you may target all mobile devices by selecting both smartphones and tablets, or you can target Apple users by selecting iOS and Mac.", Env::textDomain());
    }

    protected function getAllowedValues()
    {
        return new Collection([
            'devices' => new Collection([
                'SmartPhone', 'Desktop', 'Tablet',
                'iOS', 'Android', 'Mac', 'Windows', 'Linux'
            ])
        ]);
    }

    protected function parametersMap()
    {
        return [
            'devices' => Collection::class
        ];
    }

    public function hasPassed()
    {
        (object) $deviceDetector = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);

        $deviceDetector->parse();

        return $this->parameters->devices->containEither([
            $deviceDetector->getDeviceName(),
            $deviceDetector->getOs()['name'],
            $deviceDetector->isPhablet()? 'smartphone': null
        ]);
    }

    public function validateParameters()
    {
        if ($this->parameters->devices->haveNone()) {
            return DeviceConditionErrors::get('no_devices_selected');
        } elseif (!$this->allowed->get('devices')->containAll($this->parameters->devices)) {
            return DeviceConditionErrors::get('unallowed_devices');
        }

        return true;
    }
}