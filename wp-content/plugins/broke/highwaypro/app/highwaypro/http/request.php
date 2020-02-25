<?php

namespace HighWayPro\App\HighWayPro\HTTP;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Characters\StringManager;
use HighwayPro\Original\Collections\JSONMapper;

Class Request
{
    public $path;
    public $unMappedData;

    protected function map(){ return []; }

    public function __construct($path = '')
    {
        $this->path = $this->clean($path);
        $this->paths = (new Collection($this->path->explode('/')->asArray()))->clean();
        $this->setData();
    }

    public function get($key)
    {
        return $this->unMappedData->get($key);   
    }
    
    public function getReferer()
    {
        (string) $PHPReferer = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';

        return wp_get_referer()? wp_get_referer() : $PHPReferer;   
    }

    public function getUserAgent()
    {
        return !empty($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : '';   
    }

    public function getLanguage()
    {
        return !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : '';   
    }

    public function methodIs($httpMethod)   
    {
        return strtolower($this->getMethod()) === strtolower($httpMethod);
    }

    public function getMethod()
    {
        return isset($_SERVER['REQUEST_METHOD'])? $_SERVER['REQUEST_METHOD'] : '';
    }

    public function finish($message = null)
    {
        exit($message);
    }

    public function setData()
    {
        (array) $data = $this->methodIs('POST')? $_POST : $_GET;
        (array) $map = $this->map();

        $data = stripslashes_deep($data);

        if (!empty($map)) {
            $this->data = $this->getMappedData($data);
        }

        $this->unMappedData = $this->getUnMappedData($data);
    }

    protected function getMappedData(Array $data)
    {
        (object) $map = new Collection($this->map());
        (array) $excludedMap = [];
        (boolean) $hasExcludedKey = $map->hasKey('excluded');

        if ($hasExcludedKey) {
            $excludedMap = $map->get('excluded');
            $map->remove('excluded');
        }

        (object) $jsonMapper = new JSONMapper($map->asArray());

        $dataToMap = isset($data['data'])? $data['data'] : "";

        $dataToMap = !is_string($dataToMap)? '' : $dataToMap;
        
        (object) $regularData =  $jsonMapper->map($dataToMap);

        if ($hasExcludedKey) {
            $regularData->excluded = (new JSONMapper($excludedMap))->map($dataToMap);
        }

        return $regularData;
    }

    protected function getUnMappedData(Array $data)
    {
        return (new Collection($data))->mapWithKeys(function($value, $key) {
            return [
                'key' => $key,
                'value' => is_array($value)? new Collection($value) : new StringManager($value)
            ];
        });
    }

    protected function clean($path)
    {
        (string) $path = $path? $path : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        (string) $installationPath = parse_url(get_option('siteurl'), PHP_URL_PATH);
        (string) $pathExcludingBaseDirectory = trim(str_ireplace($installationPath, '', $path), '/');

        (string) $pathValue = $pathExcludingBaseDirectory? $pathExcludingBaseDirectory : '/';

        return new StringManager($pathValue);
    } 
}