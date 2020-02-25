<?php

namespace HighWayPro\App\HighWayPro\Controllers\Posts;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Post\Successes\PostSuccesses;
use HighWayPro\Original\Collections\Collection;

Class PostsReaderController extends Controller
{
    const path = 'posts';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator
        ]);
    }

    public function control()
    {
        // To do: as this is an ajax, live search, we may query the db directly
        // using WPDB for improved perfomance (to avoid unnecessary wp_query load)
        (object) $posts = new \WP_Query(['s' => $this->request->get('data')->get('keyword')]);

        return (new Response)->withStatusCode(200)
                             ->containing(
                                PostSuccesses::getPosts($posts->posts, 'posts_read_success')->asArray()
                             );
    }
}   

