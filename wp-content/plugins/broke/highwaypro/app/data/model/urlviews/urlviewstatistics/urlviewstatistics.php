<?php

namespace HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics;

use HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics\AllUrlViewStatistics;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlViews\UrlViewGateway;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlViewStatistics implements UrlViewStatisticsInterface
{
    protected $urlViewGateway;
    protected $urlId;
    protected $timeStamp;

    public function __construct(Array $data = null)
    {
        $data = new Collection($data?$data:[]);

        $this->urlId = $data->get('urlId');
        $this->timeStamp = $data->get('timeStamp'); # optional, null if no time stamp

        $this->urlViewGateway = new UrlViewGateway(new WordPressDatabaseDriver);
    }    

    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    public function getStatistics()
    {
        return new AllUrlViewStatistics($this);
    }
    
    public function getTotal()
    {
        return $this->urlViewGateway->getTotalNumberOfRows($this->getOptionalUrlId());
    }

    public function getTotalInDate(Array $dateRange)
    {
        return $this->urlViewGateway->getTotalNumberOfRowsInDate(
            $dateRange, 
            $this->getOptionalUrlId()
        );
    }

    public function getCountFromPastDays($numberOfDays)
    {
        return $this->urlViewGateway->getCountFromPastDays(
            $numberOfDays, 
            $this->getOptionalUrlId(),
            $this->timeStamp
        );
    }

    public function getTotalBy($field)
    {
        return $this->urlViewGateway->getTotalCountByField($field, $this->getOptionalUrlId());
    }

    public function isForSingleUrl()
    {
        return is_numeric($this->urlId);   
    }
    
    public function getOptionalUrlId()
    {
        if ($this->isForSingleUrl()) {
            return $this->urlId;
        }
    }
}