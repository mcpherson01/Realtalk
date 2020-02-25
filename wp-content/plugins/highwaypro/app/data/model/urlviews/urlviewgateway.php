<?php

namespace HighwayPro\App\Data\Model\UrlViews;

use Carbon\Carbon;
use HighWayPro\App\Data\Schema\DestinationTable;
use HighWayPro\App\Data\Schema\UrlViewTable;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\UrlViews\UrlView;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Characters\IntegerManager;
use HighwayPro\Original\Characters\StringManager;

Class UrlViewGateway extends Gateway
{
    const NA_KEY = '__na__';
    const DATE_RANGE_FORMAT = 'Y-m-d';

    protected function model()
    {
        return [
            'table' => new UrlViewTable,
            'domain' => UrlView::class
        ];
    }

    public function getFromDestinationId($destinationId)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE destination_id = ?", [$destinationId])
                );
    } 

    public function saveView(UrlView $urlView)
    {
        return $this->driver->execute(
            "INSERT INTO {$this->table->getName()} ({$this->getFields($urlView)}) 
             VALUES({$this->getValuesAsMark($urlView)})", 
            $urlView->getAvailableValues()
            );
    }

    public function getTotalNumberOfRows($urlId = null)
    {
        (string) $optionallyFilteredById = '';

        if (!is_null($urlId)) {
            $optionallyFilteredById = "WHERE {$this->getFilteredByIdCondition()}";
        }

        (array) $result = (array) (new Collection(
            (array) $this->driver->get(
                "
                    SELECT COUNT(*) as total FROM {$this->table->getName()}
                    {$optionallyFilteredById}
                ",
                array_filter([
                    $urlId
                ])
            )
        ))->first();

        return $this->getTotal($result);
    }

    /**
     *  $dateData must be an array containing a date range
     *  with 'from' and 'to' items as YYYY-MM-DD date strings
     * 
     * @param  Array  $dateData 
     * @return integer           
     */
    public function getTotalNumberOfRowsInDate(Array $dateData, $urlId = null)
    {
        (string) $optionallyFilteredById = '';

        if (!is_null($urlId)) {
            $optionallyFilteredById = "AND ({$this->getFilteredByIdCondition()})";
        }

        $dateData = new Collection($dateData);

        if (!$dateData->hasKey('from') || !$dateData->hasKey('to')) {
            throw new \Exception("Missing arguments, argument array must have 'from' and 'to' dates");
        }

        (array) $result = (array) (new Collection(
            (array) $this->driver->get(
                "
                    SELECT count(*) as total FROM {$this->table->getName()}
                    WHERE (DATE(date) >= ? AND Date(date) <= ?) {$optionallyFilteredById}
                ",
                array_filter([
                    $dateData->get('from'),
                    $dateData->get('to'),
                    $urlId
                ])
            )
        ))->first();

        return $this->getTotal($result);
    }

    /**
     * TimeStamp needed for testing
     */
    public function getFromPastDays($numberOfDays, $timeStamp = null)
    {
        (object) $date = $this->getDateBeforeANumberOfDays($numberOfDays, $timeStamp);

        return $this->createCollection(
            (array) $this->driver->get(
                "
                    SELECT * FROM {$this->table->getName()}
                    WHERE date >= ?
                ",
                [
                    $date->get('daysAgoDate'),
                ]
            )
        );
    }   

    public function getCountFromPastDays($numberOfDays, $urlId,  $timeStamp = null)
    {
        (string) $optionallyFilteredById = '';

        if (!is_null($urlId)) {
            $optionallyFilteredById = "AND ({$this->getFilteredByIdCondition()})";
        }

        (object) $date = $this->getDateBeforeANumberOfDays($numberOfDays, $timeStamp);

        (object) $rows = new Collection(
            (array) $this->driver->get(
                "
                    SELECT COUNT(*) as total, 
                           DAY(date) as day, 
                           MONTH(date) as month, 
                           YEAR(date) as year, 
                           date
                    FROM highwaypro_url_views
                    WHERE (date >= ?) {$optionallyFilteredById}
                    GROUP BY DAY(date)
                    ORDER BY total DESC
                ",
                array_filter([
                    $date->get('daysAgoDate'),
                    $urlId
                ])
            )
        );   

        return $date->get('daysRange')->map(function($day) use ($rows, $date) {
            (object) $rowForThatDay = $rows->filter(function($view) use ($day) {
                $view = (object) $view;

                return ((integer) $view->day) === ((integer) $day->get('day')) 
                        && 
                       ((integer) $view->month) === ((integer) $day->get('month'));
            });

            (string) $_day = $rowForThatDay->haveAny()? 
                            $rowForThatDay->first()['day'] : 
                            $day->get('day');

            $_day = IntegerManager::create($_day)->twoDigit();

            (string) $month = $rowForThatDay->haveAny()? 
                                $rowForThatDay->first()['month'] : 
                                $day->get('month');

            $month = IntegerManager::create($month)->twoDigit();

            (integer) $year = $rowForThatDay->haveAny()? 
                                $rowForThatDay->first()['year'] : 
                                $day->get('year');

            return (object) [
                "total"=> (integer) ($rowForThatDay->haveAny()? $rowForThatDay->first()['total'] : 0),
                "day"=> $_day,
                "month"=> $month,
                "year"=> (integer) $year,
                "date"=> "{$year}-{$month}-{$_day}",
                "offset" => $day->get('offset')
            ];
 
        });
    }

    public function getTotalCountByField($field, $urlId = null)
    {
        (string) $optionallyFilteredById = '';

        if (!is_null($urlId)) {
            $optionallyFilteredById = "WHERE ({$this->getFilteredByIdCondition()})";
        }

        $field = (string) (new StringManager($field))->getAlphanumeric();

        (object) $rows = new Collection(
            (array) $this->driver->get(
                "
                    SELECT COUNT(*) as total, 
                           {$field}
                    FROM highwaypro_url_views
                    {$optionallyFilteredById}
                    GROUP BY {$field}
                    ORDER BY total DESC
                ",
                array_filter([
                    $urlId
                ])
            )
        );   

        (integer) $totalRows = $rows->reduce(function($total, $currentRow){
            return $total + $currentRow['total'];
        });

        (object) $rowsWithPercentage = $rows->map(function($row) use ($totalRows, $field) {
            $row = (object) $row;
            if ((string) $row->{$field} == '') $row->{$field} = Static::NA_KEY;

            $row->total = (integer) $row->total;
            $row->percentage = (($row->total * 100) / $totalRows);

            return $row;
        });

        (object) $emptyValuesRow = $rowsWithPercentage->filter(function($row) use ($field) {
            return $row->{$field} === Static::NA_KEY;
        })->reduce(function($previouslyProcessedRowsValue, $currentRow) {
            if (!is_object($previouslyProcessedRowsValue)) {
                return $currentRow;
            }

            $previouslyProcessedRowsValue->total += $currentRow->total;
            $previouslyProcessedRowsValue->percentage += $currentRow->percentage;

            return $previouslyProcessedRowsValue;
        });

        if (is_object($emptyValuesRow)) {
            return $rowsWithPercentage->filter(function($row) use ($field) {
                return $row->{$field} !== Static::NA_KEY;
            })->push($emptyValuesRow)
              ->resetKeys();
        }

        return $rowsWithPercentage;
    }
    
    public function GetWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE id = ?", [$id])
                )->first();
    }   

    public function getDateBeforeANumberOfDays($numberOfDays, $timeStamp = null)
    {
        (integer) $timeStamp = is_null($timeStamp)? strtotime("now") : $timeStamp; 
        (integer) $pastDaysTimeStamp = strtotime("-{$numberOfDays} days",  $timeStamp);

        (string) $daysAgoDate = date(
            UrlView::DATE_FORMAT, 
            $pastDaysTimeStamp
        );   

        (string) $currentDay = date("d", $timeStamp);
        (string) $currentMonth = date("m", $timeStamp);

        (string) $pastDay = date("d", $pastDaysTimeStamp);
        (string) $pastDayMonth = date("m", $pastDaysTimeStamp);
        (string) $pastDayYear = date("Y", $pastDaysTimeStamp);

        (array) $daysRange = Collection::range(0, $numberOfDays)->map(function($daysToSubtract) use ($timeStamp, $numberOfDays) {
            (integer) $timeStampOfPastDay = strtotime("-{$daysToSubtract} days",  $timeStamp);

            return new Collection([
                'day' => date('d', $timeStampOfPastDay),
                'month' => date('m', $timeStampOfPastDay),
                'year' => (integer) date('Y', $timeStampOfPastDay),
                'offset' => $numberOfDays - $daysToSubtract
            ]);
        });

        return new Collection([
            'daysAgoDate' => $daysAgoDate,
            'currentDay' => $currentDay,
            'pastDay' => $pastDay,
            'daysRange' => $daysRange,
            'pastDayMonth' => $pastDayMonth,
            'pastDayYear' => $pastDayYear,
        ]);
    }
 
    protected function getTotal(Array $set)
    {
        (object) $total = new Collection($set);

        return $total->hasKey('total')? (integer) $total->get('total') : 0;
    }

    protected function getFilteredByIdCondition()
    {
        (object) $destinationsTable = new DestinationTable;

        return "{$this->table->getName()}.destination_id IN (SELECT id FROM {$destinationsTable->getName()} destinations WHERE destinations.url_id = ?)";   
    }

}