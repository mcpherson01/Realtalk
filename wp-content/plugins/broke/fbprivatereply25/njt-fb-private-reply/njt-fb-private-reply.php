<?php
/*
 * Plugin Name: NinjaTeam Facebook Private Reply
 * Plugin URI: http://ninjateam.org
 * Description: Transform Facebooks comments into sales
 * Version: 2.5
 * Author: NinjaTeam
 * Author URI: http://ninjateam.org
 */

define('NJT_FB_PR_FILE', __FILE__);

define('NJT_FB_PR_DIR', realpath(plugin_dir_path(NJT_FB_PR_FILE)));
define('NJT_FB_PR_URL', plugins_url('', NJT_FB_PR_FILE));
define('NJT_FB_PR_I18N', 'njt_fb_pr');

require_once NJT_FB_PR_DIR . '/src/Facebook/autoload.php';

/*
 * Support functions
 */
require_once NJT_FB_PR_DIR . '/src/functions.php';

/*
 * Models
 */
require_once NJT_FB_PR_DIR . '/src/Page.class.php';
require_once NJT_FB_PR_DIR . '/src/Post.class.php';
require_once NJT_FB_PR_DIR . '/src/Admin.class.php';
require_once NJT_FB_PR_DIR . '/src/History.class.php';

require_once NJT_FB_PR_DIR . '/src/NjtFbPrView.class.php';
require_once NJT_FB_PR_DIR . '/src/NjtFbPrApi.class.php';
require_once NJT_FB_PR_DIR . '/init.php';

$njt_fb_pr_api = new NjtFbPrApi();

NjtFbPr::instance();
