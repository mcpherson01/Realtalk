<?php

use HighWayPro\Original\Installation\Installator;
use HighWayPro\Original\Events\Registrator\EventsRegistrator;


/*
Plugin Name: HighWayPro
Plugin URI:   neblabs.com/products/highwaypro
Description:  Ultimate URL Shortener for WordPress by Neblabs
Version:      1.0.2
Author:       Neblabs
Author URI:   https://neblabs.com
Text Domain:  highwaypro-international
Domain Path:  /international
Minimum supported version: 4.6
*/


/***************************************************
****************************************************
**               
**                     ------------------>
**                    |  HIGH->WAY->PRO  |
**                    <------------------
**
**      This is a read-only directory.
**      DO NOT try to edit the contents of this code base as 
**      custom edits will be removed with future updates. If
**      you need to extend the default functionality provided 
**      with the current version of this plugin, please contact
**      support.
**   
**      It is recommended to browse this code base using a 
**      code editor or an IDE with namespace -> filename support.
**      
**      HighWayPro logic is located under the app/ directory.
**
**      All classes are namespaced. Namespaces are mapped 1:1 to file 
**      names and directories, with the exception of the ID. 
**      For example, the namespace:
**      -- HighWayPro\App\Handlers\HighWayProInitializationHandler
**      is mapped to a class with the filename: 
**      -- app/handlers/highWayproinitializationhandler.php
**      
**      All HighWayPro event handlers are registered at: app/events/actions.php
**
**
**      Third Party packages are located under the vendor/ directory and are autoloaded
**      using Composer's autoloader.  
**
*****************************************************
****************************************************/

require_once 'bootstrap.php';

(object) $installator = new Installator;

(object) $eventsRegistrator = new EventsRegistrator;

$eventsRegistrator->registerEvents();