<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\Components\HighWayProDashboard;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;

Class DashboardRegistrationHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        add_menu_page(
            $page_title = 'HighWayPro', 
            $menu_title = 'HighWayPro', 
            $capability = 'install_plugins',
            $menu_slug = 'highwaypro',
            $function = function(){
                (object) $highwayProDashboard = new HighWayProDashboard;

                $highwayProDashboard->render();
            },
            $icon_url = 'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title" aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20"><path data-name="layer1" d="M49 30H15a8.005 8.005 0 0 1-7.976-8.059A7.906 7.906 0 0 1 15 14h38l-3.566 3.924 2.844 2.846L61 12l-8.72-9-2.846 2.843L53 10H15a12 12 0 1 0 0 24h34c4.436 0 9 3.563 9 8a7.977 7.977 0 0 1-8 8H11l4-4-2.946-2.768L3 52l1.584 1.525.02.02L12 61l3-3-4-4h39a11.964 11.964 0 0 0 12-12c0-6.656-6.344-12-13-12z" fill="#1f5bb3"></path></svg>'),
            $position = null
        );

        //removes notices so that it doesn't break our layout. Similar to what other plugins
        //like JetPack do.
        remove_filter( 'admin_notices', 'update_nag', 3 );
        remove_filter( 'network_admin_notices', 'update_nag', 3 );
    }
}