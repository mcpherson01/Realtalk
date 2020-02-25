<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlView;

use HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics\UrlViewStatistics;
use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlView\UrlViewStatisticsReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\UrlViewStatisticsReaderValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlViewSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;

Class UrlViewStatisticsReaderController extends Controller
{
    const path = 'url/statistics';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlViewStatisticsReaderValidator
        ]);
    }

    protected function request()
    {
        return new UrlViewStatisticsReadRequest;
    }

    public function control()
    {
        (object) $UrlViewStatistics = new UrlViewStatistics([
            'urlId' => ($this->request->hasUrlId()? $this->request->data->url->id : null)
        ]);

        (object) $statistics = $UrlViewStatistics->getStatistics();
        (object) $statisticsData = $statistics->export();

        if (WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlViewSuccesses::getStatistics(
                                    $statisticsData, 
                                    "{$statistics->getType()}_url_views_read_sucess")
                                ->asArray()
                             );
    }
}   

