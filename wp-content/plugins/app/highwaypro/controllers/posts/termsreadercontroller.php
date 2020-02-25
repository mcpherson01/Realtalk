<?php

namespace HighWayPro\App\HighWayPro\Controllers\Posts;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Post\Successes\PostSuccesses;
use HighWayPro\App\HighWayPro\Validators\Post\Successes\TermSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Characters\StringManager;

Class TermsReaderController extends Controller
{
    const path = 'terms';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator
        ]);
    }

    public function control()
    {
        (array) $terms = get_terms([
            'orderby'       => 'id', 
            'hide_empty'    => false,
            'fields'        => 'all',
            'name__like'    => (new StringManager($this->request->get('data')->get('keyword')))
                                ->getAlphanumeric()
        ]);

        return (new Response)->withStatusCode(200)
                             ->containing(
                                TermSuccesses::getTerms($terms, 'terms_read_success')->asArray()
                             );
    }
}   

