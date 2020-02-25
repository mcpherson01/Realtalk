<?php
/**
 * Description of A2W_ServiceController
 *
 * @author Andrey
 * 
 * @autoload: a2w_init
 */

if (!class_exists('A2W_ServiceController')) {

    class A2W_ServiceController {

        private $system_message_update_period = 3600;

        public function __construct() {
            $system_message_last_update = intval(a2w_get_setting('plugin_data_last_update'));
            if (!$system_message_last_update || $system_message_last_update < time()) {
                a2w_set_setting('plugin_data_last_update', time() + $this->system_message_update_period);
                $request_url = A2W_RequestHelper::build_request('sync_plugin_data');
                $request = a2w_remote_get($request_url);
                if (!is_wp_error($request) && intval($request['response']['code']) == 200) {
                    $plugin_data = json_decode($request['body'], true);
                    a2w_set_setting('system_message', $plugin_data['message']);
                    update_option('a2w_all_categories', $plugin_data['categories']);
                }
            }
        }

    }

}
