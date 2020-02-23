<?php
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonSpeedOptimizationQuery
 */
class WpsolAddonSpeedOptimizationQuery
{
    /**
     * WpsolAddonSpeedOptimizationQuery constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get element from database
     *
     * @param string $page     Url of page
     * @param string $filetype File type
     * @param string $search   Search query
     *
     * @return array|null|object
     */
    public static function getItems($page, $filetype, $search)
    {
        global $wpdb;
        $num_rec_per_page = 10;
        $args = array(
            'search' => $search,
            'filetype' => $filetype,
            'pages' => $page
        );

        $query = 'SELECT * FROM ' . $wpdb->prefix . 'wpsol_minify_file';
        $where = array('1=1');


        if ($args['search']) {
            $where[] = $wpdb->prepare('filename LIKE %s', esc_sql('%' . $args['search'] . '%'));
        }

        if (is_numeric($args['filetype'])) {
            $where[] = $wpdb->prepare('filetype = %d', (int)$args['filetype']);
        } elseif ($args['filetype'] === 'all') {
            $where[] = esc_sql('filetype IN (0,1,2)');
        }


        $sql = $query . ' WHERE ' . implode(' AND ', $where);

        if ($args['pages']) {
            $start_from = ((int)$args['pages'] - 1) * (int)$num_rec_per_page;
            $sql .= esc_sql(' LIMIT ' . $start_from . ',' . (int)$num_rec_per_page);
        }
        //phpcs:ignore WordPress.DB.PreparedSQL -- The multi variables was escaped
        $results = $wpdb->get_results($sql);

        return $results;
    }

    /**
     * Get count element of minify
     *
     * @param string $filetype File type
     * @param string $search   Search query
     *
     * @return integer|null|string
     */
    public static function getTotalItems($filetype, $search)
    {
        global $wpdb;

        $args = array(
            'search' => $search,
            'filetype' => $filetype,
        );

        $total = 0;

        if (is_numeric($args['filetype'])) {
            $where[] = $wpdb->prepare('filetype = %d', (int)$args['filetype']);
        } elseif ($args['filetype'] === 'all') {
            $where[] = esc_sql('filetype IN (0,1,2)');
        }

        if ($args['search']) {
            $where[] = $wpdb->prepare('filename LIKE %s', esc_sql('%' . $args['search'] . '%'));
        }
        $query = 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'wpsol_minify_file WHERE ' . implode(' AND ', $where);
        //phpcs:ignore WordPress.DB.PreparedSQL -- The multi variables was escaped
        $total = $wpdb->get_var($query);

        return $total;
    }

    /**
     * Get state of minify
     *
     * @param integer $id Id of minify to change state
     *
     * @return null|string
     */
    public static function getStateMinify($id)
    {
        global $wpdb;

        return $wpdb->get_var(
            'SELECT minify FROM ' . $wpdb->prefix . 'wpsol_minify_file WHERE id=' . esc_sql($id)
        );
    }

    /**
     * Change minify in database
     *
     * @param integer $ids   Id of minify file
     * @param integer $state State of minify file
     *
     * @return boolean
     */
    public static function changeMinifyFile($ids, $state)
    {
        global $wpdb;

        $query = 'UPDATE ' . $wpdb->prefix . 'wpsol_minify_file SET minify=' . (int)$state;
        $query .= ' WHERE id IN('. implode(',', array_map('intval', $ids)) . ')';
        //phpcs:ignore WordPress.DB.PreparedSQL -- The multi variables was escaped
        $wpdb->query($query);

         return true;
    }
    /**
     * Delete database
     *
     * @return boolean
     */
    public static function deleteMinifyFile()
    {
        global $wpdb;

        $wpdb->query(
            'DELETE FROM ' . $wpdb->prefix . 'wpsol_minify_file WHERE `minify` = 0'
        );

        return true;
    }

    /**
     * Insert minify to database
     *
     * @param array $files Name of minify
     *
     * @return boolean
     */
    public static function insertMinifyFile($files)
    {
        global $wpdb;

        $values = array();

        $countFiles = count($files);
        for ($i = 0; $i < $countFiles; $i++) {
            $values[] = '("' . esc_sql($files[$i]['file']).
                '",' . esc_sql($files[$i]['minify']).
                ',' . esc_sql($files[$i]['type']) . ')';
        }

        $query = 'INSERT IGNORE INTO ' . $wpdb->prefix . 'wpsol_minify_file (filename, minify, filetype ) VALUES ';
        $query .= implode(', ', $values);
        $query .= ' ON DUPLICATE KEY UPDATE  `filename` = VALUES(`filename`) ';

        //phpcs:ignore WordPress.DB.PreparedSQL -- The multi variables was escaped
        $wpdb->query($query);
        return true;
    }
    /**
     * Select exclude files
     *
     * @return array|null|object
     */
    public static function getExcludeFiles()
    {
        global $wpdb;

        $results = $wpdb->get_results(
            'SELECT filename,filetype FROM ' . $wpdb->prefix . 'wpsol_minify_file WHERE minify=1'
        );

        return $results;
    }
}
