<?php

namespace HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\UrlViews\UrlViewGateway;

Class AllUrlViewStatistics extends UrlViewStatisticsData
{
    protected function getDataToExport()
    {
        (string) $today = (string) $this->carbonDate->format(UrlViewGateway::DATE_RANGE_FORMAT);
        (string) $lastDay = (string) $this->carbonDate
                                          ->copy()
                                          ->subDay()
                                          ->format(UrlViewGateway::DATE_RANGE_FORMAT);

        (string) $startOfTheMonth = (string) $this->carbonDate
                                                  ->copy()
                                                  ->startOfMonth()
                                                  ->format(UrlViewGateway::DATE_RANGE_FORMAT);

        (string) $endOfTheMonth = (string) $this->carbonDate
                                                ->copy()
                                                ->endOfMonth()
                                                ->format(UrlViewGateway::DATE_RANGE_FORMAT);

        return new Collection([
            'viewsType' => $this->getType(),
            'urlId' => $this->urlViewStatistics->getOptionalUrlId(),
            'count' => [
                'allTime' => $this->urlViewStatistics->getTotal(),
                'today' => $this->urlViewStatistics->getTotalInDate([
                    'from' => $today,
                    'to' => $today,
                ]),
                'lastDay' => $this->urlViewStatistics->getTotalInDate([
                    'from' => $lastDay,
                    'to' => $lastDay,
                ]),
                'thisMonth' => $this->urlViewStatistics->getTotalInDate([
                    'from' => $startOfTheMonth,
                    'to' => $endOfTheMonth
                ]),
            ],
            'dailyCount' => [
                'past30days' => $this->urlViewStatistics->getCountFromPastDays(30)
            ],
            'countByField' => [
                'countries' => $this->urlViewStatistics->getTotalBy('location_country'),
                'devices' => $this->urlViewStatistics->getTotalBy('device_type'),
                'origin' => $this->urlViewStatistics->getTotalBy('device_referer'),
                'operativeSystem' => $this->urlViewStatistics->getTotalBy('device_os'),
                'language' => $this->urlViewStatistics->getTotalBy('location_language'),
            ]
        ]);
    }
}