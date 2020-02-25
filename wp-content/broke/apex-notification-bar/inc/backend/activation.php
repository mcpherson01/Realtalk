<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Necessary Table Creation on activation
 */
if ( is_multisite() ) {
global $wpdb;
$current_blog = $wpdb->blogid;
// Get all blogs in the network and activate plugin on each one
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );

        $table_name = $wpdb->prefix . 'apex_notification_bar';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name 
            (
            nb_id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(nb_id),
            edn_bar_name TEXT,
            edn_position VARCHAR(50),
            edn_visibility VARCHAR(50),
            edn_show_duration VARCHAR(255),
            edn_hide_duration VARCHAR(255),
            edn_close_button VARCHAR(50),
            edn_date TEXT,
            edn_bar LONGTEXT,
            nb_created datetime,
            nb_modified datetime
            ) $charset_collate;";

        /**
         * Create a new table for Subscriber 
         **/           
       $table_name_subs = $wpdb->prefix . 'apexnb_subscriber';

     $sqll = "CREATE TABLE IF NOT EXISTS $table_name_subs (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          email tinytext NOT NULL,
         date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           active_code int,
         UNIQUE KEY id (id)
           ) $charset_collate;";


        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        dbDelta( $sqll );


        restore_current_blog();
    }

}else{
         global $wpdb;
         $table_name = $wpdb->prefix . 'apex_notification_bar';
         $charset_collate = $wpdb->get_charset_collate();
         $sql = "CREATE TABLE IF NOT EXISTS $table_name 
                                    (
                                    nb_id INT NOT NULL AUTO_INCREMENT, 
                                    PRIMARY KEY(nb_id),
                                    edn_bar_name TEXT,
                                    edn_position VARCHAR(50),
                                    edn_visibility VARCHAR(50),
                                    edn_show_duration VARCHAR(255),
                                    edn_hide_duration VARCHAR(255),
                                    edn_close_button VARCHAR(50),
                                    edn_date TEXT,
                                    edn_bar LONGTEXT,
                                    nb_created datetime,
                                    nb_modified datetime
                                    ) $charset_collate;";

/**
 * Create a new table for Subscriber 
 **/           
$table_name_subs = $wpdb->prefix . 'apexnb_subscriber';

$sqll = "CREATE TABLE IF NOT EXISTS $table_name_subs (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      email tinytext NOT NULL,
     date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
       active_code int,
     UNIQUE KEY id (id)
       ) $charset_collate;";


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
dbDelta( $sqll );
}
