<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonDatabaseCleanup
 */
class WpsolAddonDatabaseCleanup
{
    /**
     * WpsolAddonDatabaseCleanup constructor.
     */
    public function __construct()
    {
        //Action
        add_action('wpsol_addon_database_cleanup_save_settings', array($this, 'saveDatabaseSettings'));
        add_action(
            'wpsol_addon_optimize_and_clean_duplicate_table',
            array($this, 'optimizeAndCleanDuplicateTable')
        );
        // Cron Schedule
        add_action('wpsol_addon_cleanup_db_chedules', array($this, 'cleanupDatabaseSchedules'));
        add_action('init', array($this, 'wpsolAddonScheduleEvents'));
        add_filter('cron_schedules', array($this, 'wpsolAddonFilterCronSchedules'));

        // Filter
        add_filter('wpsol_addon_check_input_db_cleanup', array($this, 'checkInputDbCleanup'));
        add_filter('wpsol_addon_count_number_db', array($this, 'countNumberDb'), 10, 2);
    }


    /**
     * Save database settings
     *
     * @return void
     */
    public function saveDatabaseSettings()
    {
        check_admin_referer('wpsol_speed_optimization', '_wpsol_nonce');

        $list_db = array();
        if (!empty($_REQUEST['clean'])) {
            $list_db = $_REQUEST['clean'];
        }
        $database_settings = array(
            'db_clean_auto' => ((isset($_REQUEST['db-clean-auto'])) ? 1 : 0),
            'clean_db_each' => (int)$_REQUEST['clean-db-each'],
            'clean_db_each_params' => (int)$_REQUEST['clean-db-each-params'],
            'list_db_clear' => $list_db,
        );
        update_option('wpsol_db_clean_addon', $database_settings);
        //// Reschedule cron events
        $this->wpsolAddonUnscheduleEvents();
        $this->wpsolAddonScheduleEvents();
    }

    /**
     *  Set up schedule_events
     *
     * @return void
     */
    public function wpsolAddonScheduleEvents()
    {
        $config = get_option('wpsol_db_clean_addon');
        $timestamp = wp_next_scheduled('wpsol_addon_cleanup_db_chedules');
        // Expire never
        if (!$config['db_clean_auto']) {
            wp_unschedule_event($timestamp, 'wpsol_addon_cleanup_db_chedules');
            return;
        }
        if (!$timestamp) {
            wp_schedule_event(time(), 'wpsol_addon_cleanup_db_cron', 'wpsol_addon_cleanup_db_chedules');
        }
    }

    /**
     * Unschedule events
     *
     * @return void
     */
    public function wpsolAddonUnscheduleEvents()
    {
        $timestamp = wp_next_scheduled('wpsol_addon_cleanup_db_chedules');
        wp_unschedule_event($timestamp, 'wpsol_addon_cleanup_db_chedules');
    }

    /**
     * Add custom cron schedule
     *
     * @param array $schedules Time schedules
     *
     * @return array
     */
    public function wpsolAddonFilterCronSchedules($schedules)
    {
        $config = get_option('wpsol_db_clean_addon');
        $interval = HOUR_IN_SECONDS;
        if (!empty($config['db_clean_auto']) && $config['clean_db_each'] > 0) {
            // check parameter
            if ($config['clean_db_each_params'] === 0) {
                $interval = $config['clean_db_each'] * DAY_IN_SECONDS;
            } elseif ($config['clean_db_each_params'] === 1) {
                $interval = $config['clean_db_each'] * HOUR_IN_SECONDS;
            } else {
                $interval = $config['clean_db_each'] * MINUTE_IN_SECONDS;
            }
        }
        $schedules['wpsol_addon_cleanup_db_cron'] = array(
            'interval' => $interval,
            'display' => esc_html__('WPSOL ADDON Database Cleanup Interval', 'wp-speed-of-light-addon'),
        );
        return $schedules;
    }

    /**
     *  Schedules clear database
     *
     * @return void
     */
    public function cleanupDatabaseSchedules()
    {
        $config = get_option('wpsol_db_clean_addon');
        require_once(WPSOL_PLUGIN_DIR . 'inc/wpsol-database-cleanup.php');
        if (!empty($config['db_clean_auto']) && !empty($config['list_db_clear'])) {
            foreach ($config['list_db_clear'] as $type) {
                WpsolDatabaseCleanup::cleanupDb($type);
            }
        }
    }

    /**
     * Check selected input
     *
     * @param array $check Check input database to clean up
     *
     * @return mixed
     */
    public function checkInputDbCleanup($check)
    {
        $config = get_option('wpsol_db_clean_addon');

        if (!empty($config['list_db_clear'])) {
            foreach ($config['list_db_clear'] as $type) {
                if ($type === 'revisions') {
                    $check[0] = 'checked = "checked"';
                }
                if ($type === 'drafted') {
                    $check[1] = 'checked = "checked"';
                }
                if ($type === 'trash') {
                    $check[2] = 'checked = "checked"';
                }
                if ($type === 'comments') {
                    $check[3] = 'checked = "checked"';
                }
                if ($type === 'trackbacks') {
                    $check[4] = 'checked = "checked"';
                }
                if ($type === 'transient') {
                    $check[5] = 'checked = "checked"';
                }
                if ($type === 'dup_postmeta') {
                    $check[6] = 'checked = "checked"';
                }
                if ($type === 'dup_commentmeta') {
                    $check[7] = 'checked = "checked"';
                }
                if ($type === 'dup_usermeta') {
                    $check[8] = 'checked = "checked"';
                }
                if ($type === 'dup_termmeta') {
                    $check[9] = 'checked = "checked"';
                }
                if ($type === 'optimize_table') {
                    $check[10] = 'checked = "checked"';
                }
            }
        }
        return ($check);
    }

    /**
     * Count number element which need to cleanup
     *
     * @param integer $return Result return
     * @param string  $type   Type to check sql
     *
     * @return false|integer
     */
    public function countNumberDb($return, $type)
    {
        global $wpdb;
        switch ($type) {
            case 'dup_postmeta':
                $return = $wpdb->query(
                    'SELECT COUNT(meta_id) FROM '.$wpdb->postmeta
                    .' GROUP BY post_id,meta_key HAVING COUNT(meta_id) > 1'
                );
                break;
            case 'dup_commentmeta':
                $return = $wpdb->query(
                    'SELECT COUNT(meta_id) FROM '.$wpdb->commentmeta
                    .' GROUP BY comment_id,meta_key HAVING COUNT(meta_id) > 1'
                );
                break;
            case 'dup_usermeta':
                $return = $wpdb->query(
                    'SELECT COUNT(umeta_id) FROM '.$wpdb->usermeta
                    .' GROUP BY user_id,meta_key HAVING COUNT(umeta_id) > 1'
                );
                break;
            case 'dup_termmeta':
                $return = $wpdb->query(
                    'SELECT COUNT(meta_id) FROM '.$wpdb->termmeta
                    .' GROUP BY term_id,meta_key HAVING COUNT(meta_id) > 1'
                );
                break;
            case 'optimize_table':
                $return = $wpdb->query('SHOW TABLES');
                break;
        }

        return $return;
    }

    /**
     * Optimize table and remove duplicate
     *
     * @param string $type Type to check optimize
     *
     * @return void
     */
    public function optimizeAndCleanDuplicateTable($type)
    {
        global $wpdb;
        switch ($type) {
            case 'dup_postmeta':
                $wpdb->query(
                    'DELETE t1 FROM '.$wpdb->postmeta.' t1, '.$wpdb->postmeta.' t2 '.
                    ' WHERE t1.meta_id > t2.meta_id AND t1.post_id = t2.post_id AND t1.meta_key = t2.meta_key'
                );
                break;
            case 'dup_commentmeta':
                $wpdb->query(
                    'DELETE t1 FROM '.$wpdb->commentmeta.' t1, '.$wpdb->commentmeta.' t2 '.
                    ' WHERE t1.meta_id > t2.meta_id AND t1.comment_id = t2.comment_id '.
                    ' AND t1.meta_key = t2.meta_key'
                );
                break;
            case 'dup_usermeta':
                $wpdb->query(
                    'DELETE t1 FROM '.$wpdb->usermeta.' t1, '.$wpdb->usermeta.' t2 '.
                    ' WHERE t1.umeta_id > t2.umeta_id AND t1.user_id = t2.user_id AND t1.meta_key = t2.meta_key'
                );
                break;
            case 'dup_termmeta':
                $wpdb->query(
                    'DELETE t1 FROM '.$wpdb->termmeta.' t1, '.$wpdb->termmeta.' t2 '.
                    ' WHERE t1.meta_id > t2.meta_id AND t1.term_id = t2.term_id AND t1.meta_key = t2.meta_key'
                );
                break;
            case 'optimize_table':
                $wpdb->query(
                    sprintf('OPTIMIZE TABLE %s', implode(' , ', $wpdb->get_col(' SHOW TABLES')))
                );
                break;
        }
    }
}
