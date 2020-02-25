<?php

namespace HighWayPro\App\HighWayPro\Location;

use HighWayPro\Original\Environment\Env;
use MaxMind\Db\Reader;

Class LocationDetector
{
    protected $location;

    public function __construct($ip, Reader $reader = null)  
    {
        if (!$reader) {
            try {
                $reader = new Reader(Env::directory().'storage/db/geoip/GeoLite2-Country.mmdb');
                $this->locationArray = $reader->get($ip);
            } catch (\Exception $exception) {
                $this->locationArray = [];
            }
        }

        
        $this->location = json_decode(json_encode($this->locationArray));

        $reader->close();
    }

    public function getContinent()
    {
        return isset($this->locationArray['continent']['names']['en'])? $this->locationArray['continent']['names']['en'] : '';
    }

    public function getCountry()
    {
        return isset($this->locationArray['country']['names']['en'])? $this->locationArray['country']['names']['en'] : '';
    }

    public function getCountryCode()
    {
        return isset($this->location->country->iso_code)? $this->location->country->iso_code : null;
    }
}

