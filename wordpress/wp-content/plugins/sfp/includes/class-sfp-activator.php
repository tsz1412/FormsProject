<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tsz.co.il
 * @since      1.0.0
 *
 * @package    Sfp
 * @subpackage Sfp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sfp
 * @subpackage Sfp/includes
 * @author     Tsviel Zaikman <tsviel@tsz.co.il>
 */
class Sfp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        self::form_submission_table_up();
        if (!get_option('sfp_db_name')) {
            add_option('sfp_db_name', 'form_submissions');
        }
	}

    /**
     * Migration Method to Create Form submissions table
     * @since    1.0.0
     */
    private static function form_submission_table_up(){
        global $wpdb;
        $tableName = $wpdb->prefix . "form_submissions";
        if ($wpdb->get_var("show tables like '" . $tableName . "'") != $tableName) {

            $mytable = 'CREATE TABLE `' . $tableName . '` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `fname` varchar(100) NOT NULL,
                            `lname` varchar(100) NOT NULL,
                            `email` varchar(50) NOT NULL,
                            `phone` varchar(50) NOT NULL,
                            `country` varchar(50) NOT NULL,
                            `date_of_birth` date NOT NULL,
                            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($mytable);
        }
    }



}
