<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tsz.co.il
 * @since      1.0.0
 *
 * @package    Sfp
 * @subpackage Sfp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sfp
 * @subpackage Sfp/public
 * @author     Tsviel Zaikman <tsviel@tsz.co.il>
 */
class Sfp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
     * @author   Tsviel Zaikman
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sfp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
     * @author   Tsviel Zaikman
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sfp-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'myAjax', array(
            'ajaxurl'  => admin_url( 'admin-ajax.php' )
        ));

    }

    /**
	 * The PHP endpoint for the Ajax Request that is generated after a Form is submitted
	 * @author   Tsviel Zaikman
	 * @since    1.0.0
	 */
	public function save_form_submission() {
        global $wpdb;
        $tableName = $wpdb->prefix . get_option('sfp_db_name');
        $args = $_POST;
        $args['email'] = sanitize_email($args['email']);
        $args['fname'] = sanitize_text_field($args['fname']);
        $args['lname'] = sanitize_text_field($args['lname']);
        $args['phone'] = sanitize_text_field($args['phone']);
        $args['country'] = sanitize_text_field($args['country']);
        $args['date_of_birth'] = sanitize_text_field($args['date_of_birth']);
        $args['tou_agreement'] = boolval($args['tou_agreement']);
        unset($args['action']);
        $wpdb->insert($tableName, $args);
        $response['type'] = 'success';
        echo json_encode($response);
        wp_die();
	}



}
