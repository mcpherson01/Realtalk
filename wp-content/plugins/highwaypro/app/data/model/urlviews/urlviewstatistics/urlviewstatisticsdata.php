<?php

namespace HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics;

use Carbon\Carbon;
use HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics\UrlViewStatistics;
use HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics\UrlViewStatisticsInterface;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Abstract Class UrlViewStatisticsData
{
    protected $urlViewStatistics;
    protected $carbonDate;

    protected abstract function getDataToExport(); #: Collection

    protected static function getCurrentDate()
    {
        (object) $date = new Collection([
            'day' => date('d'),
            'month' => date('m'),
            'year' => date('Y')
        ]);

        if (Env::isRemoteTesting()) {
            $customDate = apply_filters('highwaypro_develoment_set_date', null);

            if (is_array($customDate)) {
                $date = $date->merge($customDate);
            }
        }

        return $date;
    }
    
    public function __construct(UrlViewStatistics $urlViewStatistics, Carbon $carbonDate = null)
    {
        $this->urlViewStatistics = $urlViewStatistics;
        $this->carbonDate = ($carbonDate instanceof Carbon)? $carbonDate : $this->newCarbonInstance();

        $this->urlViewStatistics->setTimeStamp($this->carbonDate->getTimestamp());
    }

    public function export()
    {
        return $this->getDataToExport();
    }    

    public function getType()
    {
        return $this->urlViewStatistics->isForSingleUrl()? 'single' : 'all';   
    }

    protected function newCarbonInstance()
    {
        (object) $date = Static::getCurrentDate();

        return Carbon::createFromDate(
            $date->get('year'),
            $date->get('month'),
            $date->get('day')
        );   
    }
    
}