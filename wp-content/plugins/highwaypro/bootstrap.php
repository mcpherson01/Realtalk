<?php

use HighWayPro\Original\Autoloading\Autoloader;
use HighWayPro\Original\Environment\Env;


require 'original/environment/env.php';

Env::set(__FILE__);

require Env::directory().'original/autoloading/autoloader.php';
require Env::directory().'vendor/autoload.php';

Autoloader::register();