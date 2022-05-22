<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tsz.co.il
 * @since      1.0.0
 *
 * @package    Sfp
 * @subpackage Sfp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sfp
 * @subpackage Sfp/admin
 * @author     Tsviel Zaikman <tsviel@tsz.co.il>
 */
class Sfp_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sfp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sfp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sfp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sfp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sfp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sfp-admin.js', array( 'jquery' ), $this->version, false );

	}
    public function form_submissions_menu_page()
    {
        add_menu_page(
            __('Form Submissions', $this->plugin_name),
            __('Submissions', $this->plugin_name),
            'edit_posts',
            $this->plugin_name,
            array($this, 'render_form_submissions_menu_list'),
            'dashicons-feedback',
            '26.1'
        );
    }

    public function form_submissions_settings_page()
    {
        //add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        add_submenu_page(
            $this->plugin_name,
            $this->plugin_name.' Settings',
            'Settings',
            'administrator',
            $this->plugin_name.'-settings',
            array( $this, 'displayPluginAdminSettings' )
        );
    }

    public function displayPluginAdminSettings() {
        // set this var to be used in the settings-display view
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        if(isset($_GET['error_message'])){
            add_action('admin_notices', array($this,'pluginNameSettingsMessages'));
            do_action( 'admin_notices', $_GET['error_message'] );
        }
        require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
    }

    /**
     * Renders the list of revenues menu page using the "licenses_list.php" partial.
     */
    public function render_form_submissions_menu_list() {
        // Used in the "Product" drop-down list in view
        $products = get_posts(
            array(
                'orderby'           => 'post_title',
                'order'             => 'ASC',
                'post_type'         => 'wplm_product',

                'post_status'       => 'publish',
                'nopaging'          => true,
                'suppress_filters'  => true
            )
        );
        $list_table = new Form_Submissions_Table( $this->plugin_name );
        $list_table->prepare_items();

        require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sfp-form-submissions-display.php';

    }
    public function sfp_display_general_account() {
        echo '<p>These settings apply to all Plugin Name functionality.</p>';
    }

    public function sfp_render_settings_field($args) {
        if($args['wp_data'] == 'option'){
            $wp_data_value = get_option($args['name']);
        } elseif($args['wp_data'] == 'post_meta'){
            $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
        }

        switch ($args['type']) {

            case 'input':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                if($args['subtype'] != 'checkbox'){
                    $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
                    $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
                    $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
                    $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
                    $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
                    if(isset($args['disabled'])){
                        // hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    } else {
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    }
                    /*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/

                } else {
                    $checked = ($value) ? 'checked' : '';
                    echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
                }
                break;
            default:
                break;
        }
    }

    public function registerAndBuildFields() {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */
        add_settings_section(
        // ID used to identify this section and with which to register options
            'sfp_general_section',
            // Title to be displayed on the administration page
            '',
            // Callback used to render the description of the section
            array( $this, 'sfp_display_general_account' ),
            // Page on which to add this section of options
            'sfp_general_settings'
        );
        unset($args);
        $args = array (
            'type'      => 'input',
            'subtype'   => 'text',
            'id'    => 'sfp_db_name',
            'name'      => 'sfp_db_name',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option'
        );
        add_settings_field(
            'sfp_db_name',
            'Database Name',
            array( $this, 'sfp_render_settings_field' ),
            'sfp_general_settings',
            'sfp_general_section',
            $args
        );


        register_setting(
            'sfp_general_settings',
            'sfp_db_name'
        );

    }

    /**
     * The PHP endpoint for the Ajax Request that is generated after a Form is submitted
     * @author   Tsviel Zaikman
     * @since    1.0.0
     */
    public function form_submission_db_change($old_value, $value, $option) {
        if( $old_value !== $value ){
            global $wpdb;
            $OldTableName = $wpdb->prefix . $old_value;
            $NewTableName = $wpdb->prefix . $value;
//            $wpdb->query("DROP TABLE IF EXISTS ".$OldTableName );
            $sql = "DROP TABLE IF EXISTS ".$OldTableName;
            $wpdb->query($sql);

            if ($wpdb->get_var("show tables like '" . $NewTableName . "'") != $NewTableName) {

                $mytable = 'CREATE TABLE `' . $NewTableName . '` (
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
}
