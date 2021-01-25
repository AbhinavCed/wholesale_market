<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       ced_abhinavyadav@cedcoss.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 * @author     Abhinav <abhinavyadav@cedcoss.com>
 */
class Wholesale_market {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wholesale_market_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WHOLESALE_MARKET_VERSION' ) ) {
			$this->version = WHOLESALE_MARKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wholesale_market';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wholesale_market_Loader. Orchestrates the hooks of the plugin.
	 * - Wholesale_market_i18n. Defines internationalization functionality.
	 * - Wholesale_market_Admin. Defines all hooks for the admin area.
	 * - Wholesale_market_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wholesale_market-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wholesale_market-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wholesale_market-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wholesale_market-public.php';

		$this->loader = new Wholesale_market_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wholesale_market_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wholesale_market_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() { 
		$plugin_admin = new Wholesale_market_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// this is to create a Tab Named ''Whole Sale'' with ID "wholesale" in WooCommerce setting
		$this->loader->add_filter( 'woocommerce_settings_tabs_array', $plugin_admin, 'add_settings_tab_in_woo_setting_page', 50);
	
		// this is to create a Section Named 'General' AND  'Inventory' with ID "wholesale" in WooCommerce setting
		$this->loader->add_action( 'woocommerce_sections_wholesale', $plugin_admin, 'add_sections_in_wholesale_setting_tab' );

		// this hook is to admin.php file to create form in woo setting tabs->section
		$this->loader->add_action( 'woocommerce_settings_wholesale', $plugin_admin, 'output' );

		// this hook is to admin.php in admin file hook to save form in tabs->section
		$this->loader->add_action( 'woocommerce_settings_save_wholesale', $plugin_admin, 'save' );

		// this hook is to create_wholesale_price_field_at_backend_products for simple products
		$this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'create_wholesale_price_field_backend_products' );

		// this hook is to create_minimum_qty_field_backend_products for simple products
		$this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'create_minimum_qty_field_backend_products' );
		
		// this hook is to save the custom field values of simple product i.e wholesale price and minimum quantity by key 'custom_text_field_values' in postmeta table
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_both_custom_field_values' );

		// this hook is to Add a Wholesale Customer column on User listing page with a approve button to make wholesale user.
		$this->loader->add_filter( 'manage_users_columns', $plugin_admin, 'create_new_user_table' );

		// this hook is to create_custom_field_backend_variation_products for Variable Products.
		$this->loader->add_action( 'woocommerce_variation_options_pricing', $plugin_admin, 'create_custom_field_backend_variation_products', 0, 3 );

		// Save a field value for VARIABLE PRODUCT at the backend named Minimum Quantity
		$this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'save_custom_field_minqty_in_variation', 10, 2 );

		// Save a field value for VARIABLE PRODUCT at the backend named Minimum Quantity
		$this->loader->add_filter( 'woocommerce_available_variation', $plugin_admin, 'show_minqty_field_variation_data' );


		// ------- Same as above 2 bt for different field (Wholesale Price) -----------START


			// Save a field value for VARIABLE PRODUCT at the backend named Wholesale Price
			$this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'save_custom_field_wholesale_in_variation', 10, 2 );

			// Display back a field value for VARIABLE PRODUCT at the backend named Wholesale Price
			$this->loader->add_filter( 'woocommerce_available_variation', $plugin_admin, 'show_wholesale_field_variation_data' );


		// ------- Same as above 2 bt for different field (Wholesale Price) -----------END


		// this to to create a checkbox in edit user for all user to make_normal_customer_a_wholesale_customer
		$this->loader->add_filter( 'personal_options', $plugin_admin, 'make_normal_customer_a_wholesale_customer' );

		// this is to add a new role "Wholeseller" in the User admin menu
		$this->loader->add_action('init' , $plugin_admin, 'to_add_custom_role_wholeseller');

		// this is to create_checkbox_on_register_page_request_for_wholeseller
		$this->loader->add_action('woocommerce_register_form' , $plugin_admin, 'create_checkbox_on_register_page_request_for_wholeseller');

		// this is to save_checkbox_on_register_page_request_for_wholeseller
		$this->loader->add_action('woocommerce_created_customer' , $plugin_admin, 'save_checkbox_on_register_page_request_for_wholeseller');

		// this is to show button on the user wp_list_table
		$this->loader->add_filter( 'manage_users_custom_column', $plugin_admin, 'to_show_button_wholeseller', 10, 3 );

		// this to change the role of the user from any role to "wholeseller"
		$this->loader->add_action( 'admin_init', $plugin_admin, 'profile_update_user_role');

		// renders whole sale price at every simple product at shop page When
		$this->loader->add_action( 'woocommerce_after_shop_loop_item_title', $plugin_admin, 'display_wholesale_price_in_shop_page');

		// renders whole sale price at every simple product at single product page
		$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_admin, 'display_wholesale_price_in_single_product_page');
		
		// renders whole sale price at every simple product at variable product page
		$this->loader->add_action('woocommerce_available_variation', $plugin_admin, 'display_wholesale_price_in_shop_page_variable_product', 10, 3 );

		// condition to renders whole sale price at the cart page at product level and for all product ONLY for simple product 
		$this->loader->add_filter('woocommerce_before_calculate_totals', $plugin_admin, 'min_qty_setting_is_achieved', 10, 1 );

		// $this->loader->add_action('admin_notices', $plugin_admin, 'author_admin_notice');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wholesale_market_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wholesale_market_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
