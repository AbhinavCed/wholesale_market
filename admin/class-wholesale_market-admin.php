<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ced_abhinavyadav@cedcoss.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/admin
 * @author     Abhinav <abhinavyadav@cedcoss.com>
 */
class Wholesale_market_Admin {

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
		$this->version     = $version;
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
		 * defined in Wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wholesale_market-admin.css', array(), $this->version, 'all' );
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
		 * defined in Wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		*/

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wholesale_market-admin.js', array( 'jquery' ), $this->version, false );
	}
	

	/**
	 * add_settings_tab
	 * this is to create a Tab Named ''Whole Sale'' with ID "wholesale" in WooCommerce setting
	 *
	 * @param  mixed $settings_tabs
	 * @return void
	*/
	public static function add_settings_tab_in_woo_setting_page( $settings_tabs ) { 
		$settings_tabs['wholesale'] = __( 'Wholesale Market', 'woocommerce-settings-tab-demo' );
		return $settings_tabs;
	}

		
	/**
	 * add_sections_in_wholesale_setting_tab
	 * this is to create a Section Named 'General' AND  Inventory' with ID "wholesale" in WooCommerce setting
	 *
	 * @return void
	*/
	public function add_sections_in_wholesale_setting_tab() { 
		global $current_section;
		$sections = array( 
			'' => __( 'General' ), 
			'inventory' => __( 'Inventory' ) 
		);
		
		if ( empty( $sections ) || 1 === sizeof( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';
		$array_keys = array_keys( $sections );
		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . admin_url( 'admin.php?page=wc-settings&tab=wholesale&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}
		echo '</ul><br class="clear" />';
	}


	/**
	 * get_settings
	 * this is the function that is called by the output()..!
	*/
	public function get_settings( $current_section = '' ) { 
		if ( 'inventory' == $current_section ) {
			$settings = array(
					
				array(
					'name' => __( 'Inventory Setting' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'g_title_inventory',
				),
					
				array(
					'type'     => 'checkbox',
					'id'       => 'i_checkbox_minimum_qty',
					'name'     => __( 'Minimum Quantity' ),
					'desc'     => __( 'Enable to apply minimum quantity for wholesale price' ),
					'default'  => 'no',
				),
					
				array(
					'title'    => __( 'Display Wholesale Price to?' ),
					'id'       => 'i_radio_min_qty',
					'type'     => 'radio',
					'desc_tip' => __( 'This option is important as it will affect for which products the minimum quantity apply.'),
					'options'  => array(
						'yes' => __( 'Set Minimum Quantity On Product Level.'),
						'no'  => __( 'Set Minimum Quantity for All The Products.'),
					),
				),

				array(
					'type'     => 'number',
					'id'       => 'g_no_to_set_quantity_display',
					'name'     => __( 'Set Quantity.' ),
					'desc' => __( 'The Minimum Quantity You Want to Set.' ),
					'value' => get_option('g_no_to_set_quantity_display'),
					'custom_attributes' => array( 'min' => '0'),
				),

				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_group2_options'
				),		
			);	
		} else {
			$settings = array(
					
				array(
					'name' => __( 'General Setting'),
					'type' => 'title',
					'desc' => '',
					'id'   => 'g_title_general',
				),

				array(
					'type'     => 'checkbox',
					'id'       => 'g_checkbox_wholesale_price',
					'name'     => __( 'Wholesale Price Setting'),
					'desc'     => __( 'Enable/Disable for Wholesale price setting'),
					'default'  => 'no',
				),

				array(
					'title'    => __( 'Display Wholesale Price to?' ),
					'id'       => 'g_radio_dislpay_price_to',
					'type'     => 'radio',
					'desc_tip' => __( 'This option is important as it will affect to whom wholesale prices will shoiw.'),
					'options'  => array(
						'yes' => __( 'Display Wholesale Price to All Customers'),
						'no'  => __( 'Display Wholesale Price to Only Wholesale Customers'),
					),
				),
					
				array(
					'type'     => 'text',
					'id'       => 'g_text_message_to_display',
					'name'     => __( 'Message To Display.' ),
					'desc_tip' => __( 'Message You Want to Display With the Wholesale Price'),
					'desc' => __( 'The Message You Want to Display With the Wholesale Price.' ),
				),
				
				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_important_options'
				),	
			);
		}
		return apply_filters( 'woocommerce_get_settings_wholesale', $settings, $current_section );		
	}
	

	/**
	 * output
	 * this function is calling above function to display
	 * To output these settings under the right section, we’ll need a function to output them.
	 * The WooCommerce settings API will give us a lift here: WC_Admin_Settings::output_fields( $settings )
	 *
	 * @return void
	*/
	public function output() { 
		global $current_section;
				
		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );
	}
	

	/**
	 * save
	 * we’ll need to save our settings based on which section is being saved,
	 * so that we can properly retrieve them for use elsewhere in our plugin.
	 * WooCommerce has a helper for this as well: WC_Admin_Settings::save_fields( $settings );
	 *
	 * @return void
	*/
	public function save() { 
		global $current_section;
				
		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::save_fields( $settings );
	}

	
	/**
	 * create_wholesale_price_field_backend_products
	 * this created a field for simple product at the backend named Wholesale price
	 *
	 * @return void
	*/
	function create_wholesale_price_field_backend_products() {
		$get_g_checkbox_wholesale_price = get_option('g_checkbox_wholesale_price');

		$get_id = get_the_ID();
		$result = get_post_meta($get_id, 'custom_text_field_values', false);

		foreach ($result as $key => $value) {

			if ($get_g_checkbox_wholesale_price == 'yes') {
			}
		}
		{
			$args = array(
			'id' => 'custom_text_field_wholesale_price',
			'label' => __( '<b> Wholesale Price (₹) </b>' ),
			'desc_tip' => true,
			'value' => isset($value['wholesale_price']) ? $value['wholesale_price'] : '' ,
			'description' => 'Enter Wholesale Price'
			);
			woocommerce_wp_text_input( $args );
		}
	}

	
	/**
	 * create_minimum_qty_field_backend_products
	 * this creates a field for simple product at the backend named Minimum Quantity
	 *
	 * @return void
	*/
	function create_minimum_qty_field_backend_products() { 
		$get_i_radio_min_qty        = get_option('i_radio_min_qty');
		$get_i_checkbox_minimum_qty = get_option('i_checkbox_minimum_qty');

		$get_id = get_the_ID();
		$result = get_post_meta($get_id, 'custom_text_field_values', false);
		
		foreach ($result as $key => $value) {

			if ($get_i_radio_min_qty == 'yes' && $get_i_checkbox_minimum_qty == 'yes') 
			{
				$args = array(
				'id' => 'custom_text_field_mimimum_qty',
				'label' => __( '<b> Minimum Quantity </b>' ),
				'type' => 'number',
				'custom_attributes' => array('min' => '0'),
				'desc_tip' => true,
				'value' => isset($value['minimum_qty']) ? $value['minimum_qty'] : '',
				'description' => 'Enter Minimum Quantity'
				);
				woocommerce_wp_text_input( $args );
			}
		}
	}

	
	/**
	 * save_both_custom_field_values
	 * this function save the custom field values of simple product i.e wholesale price and minimum quantity
	 * by key 'custom_text_field_values' in postmeta table
	 *
	 * @param  mixed $post_id
	 * @return void
	*/
	function save_both_custom_field_values( $post_id ) { 
		$product = wc_get_product( $post_id );
		
		$wholesale_price = isset( $_POST['custom_text_field_wholesale_price'] ) ? $_POST['custom_text_field_wholesale_price'] : '';
		$minimum_qty     = isset( $_POST['custom_text_field_mimimum_qty'] ) ? $_POST['custom_text_field_mimimum_qty'] : '';

		global $post;
		$post_id = $post->ID;
		$regular_price = get_post_meta($post_id, '_regular_price', true);
		$sale_price = get_post_meta($post_id, '_sale_price', true);
		
		if($regular_price > $sale_price && $regular_price > $wholesale_price)
		{
			$value = array('wholesale_price' => $wholesale_price, 'minimum_qty' => $minimum_qty);
			$product->update_meta_data( 'custom_text_field_values', $value );
			$product->save();
		}
	}
	

	/**
	 * new_modify_user_table
	 * Add a Wholesale Customer column on User listing page with a approve button to make wholesale user.
	 *
	 * @param  mixed $column
	 * @return void
	*/
	function create_new_user_table( $column ) { 
		$column['wholesale_customer'] = 'Is Wholesale Customer';
		return $column;
	}

		
	/**
	 * create_custom_field_backend_variation_products
	 * Create a field for VARIABLE PRODUCT at the backend named wholesale and minimum quantity
	 *
	 * @param  mixed $loop
	 * @param  mixed $variation_data
	 * @param  mixed $variation
	 * @return void
	*/
	function create_custom_field_backend_variation_products( $loop, $variation_data, $variation ) { 
		$args1 = array(
		'id' => 'custom_field_wholesale_in_variation[' . $loop . ']',
		'label' => __( '<b> Wholesale Price (₹) </b>' ),
		'value' => get_post_meta( $variation->ID, 'custom_field_wholesale_in_variation', true ),
		'description' => 'Enter Wholesale Price'
		);
		woocommerce_wp_text_input( $args1 );

		$args2 = array(
		'id' => 'custom_field_minqty_in_variation[' . $loop . ']',
		'label' => __( '<b> Minimum Quantitiy </b>' ),
		'value' => get_post_meta( $variation->ID, 'custom_field_minqty_in_variation', true ),
		'description' => 'Enter Minimum Quantitiy'
		);
		woocommerce_wp_text_input( $args2 );
	}

	
	/**
	 * save_custom_field_minqty_in_variation
	 * Save a field value for VARIABLE PRODUCT at the backend named Minimum Quantity
	 *
	 * @param  mixed $variation_id
	 * @param  mixed $i
	 * @return void
	 */
	function save_custom_field_minqty_in_variation( $variation_id, $i ) 
	{ 
		$custom_field = $_POST['custom_field_minqty_in_variation'][$i];
		if ( isset( $custom_field ) ) 
		{
			update_post_meta( $variation_id, 'custom_field_minqty_in_variation', esc_attr( $custom_field ) );
		}
	}

		
	/**
	 * show_add_minqty_field_variation_data
	 * Display back a field value for VARIABLE PRODUCT at the backend named Minimum Quantity
	 *
	 * @param  mixed $variations
	 * @return void
	 */
	function show_minqty_field_variation_data( $variations ) { 
		$variations['custom_field'] = '<div class="woocommerce_custom_field">Custom Field: <span>' . get_post_meta( $variations[ 'variation_id' ], 'custom_field_minqty_in_variation', true ) . '</span></div>';
		return $variations;
	}



	// ------- Same as above 2 bt for different field (Wholesale Price) -----------

		/**
		 * save_custom_field_wholesale_in_variation
		 * Save a field value for VARIABLE PRODUCT at the backend named Wholesale Price
		 *
		 * @param  mixed $variation_id
		 * @param  mixed $i
		 * @return void
		*/
		function save_custom_field_wholesale_in_variation( $variation_id, $i ) 
		{ 
			$custom_field = $_POST['custom_field_wholesale_in_variation'][$i];
			if ( isset( $custom_field ) ) 
			{
				update_post_meta( $variation_id, 'custom_field_wholesale_in_variation', esc_attr( $custom_field ) );
			}
		}

		/**
		 * show_add_wholesale_field_variation_data
		 * Display back a field value for VARIABLE PRODUCT at the backend named Wholesale Price
		 *
		 * @param  mixed $variations
		 * @return void
		*/
		function show_wholesale_field_variation_data( $variations ) 
		{ 
			$variations['custom_field'] = '<div class="woocommerce_custom_field">Custom Field: <span>' . get_post_meta( $variations[ 'variation_id' ], 'custom_field_wholesale_in_variation', true ) . '</span></div>';
			return $variations;
		}

	// ------- Same as above 2 bt for different field (Wholesale Price) -----------

	
	/**
	 * make_normal_customer_a_wholesale_customer
	 * this to to create a checkbox in edit user for all user to make_normal_customer_a_wholesale_customer
	 *
	 * @return void
	*/
	function make_normal_customer_a_wholesale_customer() {
		?>
			<tr class="user-syntax-highlighting-wrap">
				<th scope="row"><?php _e( 'Make User Wholeseller' ); ?></th>
				<td>
					<label for="change_user_role_to_wholeseller">
						<input name="change_user_role_to_wholeseller" type="checkbox" id="change_user_role_to_wholeseller"
							value="normal_user_to_wholeseller" />
						<?php _e( 'Enabling this will make any normal customer a wholesale customer' ); ?>
					</label>
				</td>
			</tr>
		<?php
	}

	
	/**
	 * to_add_custom_role_wholeseller
	 * this is to add a new role "Wholeseller" in the User admin menu
	 *
	 * @return void
	*/
	function to_add_custom_role_wholeseller() {
		$result = add_role( 'wholeseller', (
			'Wholeseller' ),
			array(
			'read' => true, // true allows this capability
			'edit_posts' => true, // Allows user to edit their own posts
			'edit_pages' => true, // Allows user to edit pages
			'create_posts' => true, // Allows user to create new posts
			'manage_categories' => true, // Allows user to manage post categories
			'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
		));
	}

	
	/**
	 * create_checkbox_on_register_page_request_for_wholeseller
	 * this is to create_checkbox_on_register_page_request_for_wholeseller
	 *
	 * @return void
	*/
	function create_checkbox_on_register_page_request_for_wholeseller() {
		?>
			<p class="form-row">
				<label class="make_me_wholeseller">
					<input class="make_me_wholeseller" name="make_me_wholeseller" type="checkbox" id="make_me_wholeseller"
						value="yes" /> <span><?php esc_html_e('Want To Be a Wholeseller'); ?></span>
				</label>
			</p>
		<?php
	}
	

	/**
	 * save_checkbox_on_register_page_request_for_wholeseller
	 * this is to save_checkbox_on_register_page_request_for_wholeseller
	 *
	 * @param  mixed $user_id
	 * @return void
	*/
	function save_checkbox_on_register_page_request_for_wholeseller( $user_id ) 
	{
		$get_value = $_POST['make_me_wholeseller'];
		if ( isset( $get_value ) ) 
		{
			update_user_meta( $user_id, 'save_checkbok_value_registerpage', esc_attr( $get_value ) );
		}
	}

	
	/**
	 * bbloomer_add_new_user_column_content
	 * this is to show button on the user wp_list_table under Is Wholesale Customer column
	 *
	 * @param  mixed $value
	 * @param  mixed $column_name
	 * @param  mixed $user_id
	 * @return void
	*/
	function to_show_button_wholeseller( $value, $column_name, $user_id ) { 
		$get_value = get_user_meta( $user_id, 'save_checkbok_value_registerpage', true);

		if ($column_name == 'wholesale_customer' && $get_value == 'yes') {
			if ( $column_name == 'wholesale_customer' ) {
			return '<form method="POST"> <input type="submit" name="submit_the_button" id="submit_the_button" value="Make Wholeseller"> 
			<input type="hidden" name="user_id" value="' . $user_id . '"> </form>';
			}
		} else {
			return '--';
		}		
	}

	
	/**
	 * profile_update_user_role
	 * this to change the role of the user from any role to "wholeseller"
	 *
	 * @return void
	*/
	function profile_update_user_role() { 
		if (isset($_REQUEST['submit_the_button'])) {
			$user_id = $_REQUEST['user_id'];

			$var = new WP_User( $user_id );

			// pick a past user Role and remove it then use add role to add new role but with set role remove is not needed.
			// $var->remove_role($var); 
			
			$var->set_role('wholeseller'); //Set a new user-role for user->ID
			update_user_meta( $user_id, 'save_checkbok_value_registerpage', '');
		}
	}

	
	/**
	 * display_wholesale_price
	 * renders whole sale price at evry simple product at shop page When
	 * 1 it is simple product
	 * 2 when "Wholesale Price Setting" check box AND display to all customer radio is Checked('yes)
	 * IN else 
	 * 3 when "Wholesale Price Setting" check box AND display to all customer radio is Checked('no')
	 * 4 user logged in
	 * 5 customer has to be a wholeseller
	 *
	 * @return void
	*/
	function display_wholesale_price_in_shop_page() {
		$get_i_radio_min_qty = get_option('i_radio_min_qty');
		$_get_radio_price    = get_option('g_radio_dislpay_price_to');
		
		if ($get_i_radio_min_qty == 'yes' && $_get_radio_price == 'yes') {
			global $product;
			$id    = $product->get_id();
			$items = $product->get_type();

			if ( is_user_logged_in() ) {
				if ( $items == 'simple') {
					$result = get_post_meta($id, 'custom_text_field_values', true);
					$show   = isset($result['wholesale_price']) ? $result['wholesale_price'] : '';
					echo '<div class="product-meta">Wholesale Price: ' . $show . '</div>';
				}
			}
		} else {
			$_get_radio_price = get_option('g_radio_dislpay_price_to'); // getting the value of the radio button 
			$user             = wp_get_current_user(); 		// getting & setting the current user 
			$roles            = ( array ) $user->roles; 	// obtaining the role

			foreach ($roles as $value) {
				if ( is_user_logged_in() ) { 		// check if there is a logged in user 
					if ( $_get_radio_price == 'no' ) {
						if ( $value == 'wholeseller') {
							global $product;
							$id    = $product->get_id();
							$items = $product->get_type();

							if ( $items == 'simple') {
								$result = get_post_meta($id, 'custom_text_field_values', true);
								$show   = isset($result['wholesale_price']) ? $result['wholesale_price'] : '';
								echo '<div class="product-meta">Wholesale Price: ' . $show . '</div>';
							}
						}
					}
				}
			}
		}
	}
	
	
	/**
	 * display_wholesale_price_in_single_product_page
	 * renders whole sale price at every simple product at single product page
	 *
	 * @return void
	*/
	function display_wholesale_price_in_single_product_page() {
		$get_i_radio_min_qty = get_option('i_radio_min_qty');
		$_get_radio_price    = get_option('g_radio_dislpay_price_to');
		
		if ($get_i_radio_min_qty == 'yes' && $_get_radio_price == 'yes') {
			global $product;
			$id    = $product->get_id();
			$items = $product->get_type();

			if ( is_user_logged_in() ) {
				if ( $items == 'simple') {
					$result = get_post_meta($id, 'custom_text_field_values', true);
					$show   = isset($result['wholesale_price']) ? $result['wholesale_price'] : '';
					echo '<div class="product-meta">Wholesale Price: ' . $show . '</div>';
				}
			}
		} else {
			$_get_radio_price = get_option('g_radio_dislpay_price_to'); // getting the value of the radio button 
			$user             = wp_get_current_user(); 		// getting & setting the current user 
			$roles            = ( array ) $user->roles; 	// obtaining the role

			foreach ($roles as $value) {
				if ( is_user_logged_in() ) { 		// check if there is a logged in user 
					if ( $_get_radio_price == 'no' ) {
						if ( $value == 'wholeseller') {
							global $product;
							$id    = $product->get_id();
							$items = $product->get_type();

							if ( $items == 'simple') {
								$result = get_post_meta($id, 'custom_text_field_values', true);
								$show   = isset($result['wholesale_price']) ? $result['wholesale_price'] : '';
								echo '<div class="product-meta">Wholesale Price: ' . $show . '</div>';
							}
						}
					}
				}
			}
		}
	}

	
	/**
	 * display_wholesale_price_in_shop_page_variable_product
	 * renders whole sale price at every variable product at shop page
	 *
	 * @param  mixed $description
	 * @param  mixed $product
	 * @param  mixed $variation
	 * @return void
	*/
	function display_wholesale_price_in_shop_page_variable_product( $description, $product, $variation) {
		$user_id                        = get_current_user_id();
		$get_g_checkbox_wholesale_price = get_option('g_checkbox_wholesale_price', false);
		
		if ($get_g_checkbox_wholesale_price == 'yes') {
			$_get_radio_price = get_option('g_radio_dislpay_price_to');
			if ($_get_radio_price == 'no') {
				$user = wp_get_current_user();
				if ( in_array( 'wholeseller', (array) $user->roles ) ) {
					if (is_user_logged_in()) {
						global $product;
						$id           = $product->get_id();
						$product_type = $product->get_type();
						if ($product_type == 'variable') {
							$description['price_html'] = '<div style="color:red";>Wholesale Price:-' . get_post_meta($description['variation_id'], 'custom_field_wholesale_in_variation', true);
						}
					}
				}
			} else {
				$_get_radio_price = get_option('g_radio_dislpay_price_to');
				if ($_get_radio_price == 'yes') {
					global $product;
					$id  = $product->get_id();
					$res = $product->get_type();
					if ($res == 'variable') {
						$description['price_html'] = '<div style="color:green" >Wholesale Price:-' . get_post_meta($description['variation_id'], 'custom_field_wholesale_in_variation', true);
					}
				}
			}
		}
		return $description;
	}
	


	// function min_qty_setting_is_achieved( $cart_data )
	// {
	// 	foreach($cart_data->get_cart() as $key => $value)
	// 	{		
	// 		$get_minimum_qty_checkbox = get_option('i_checkbox_minimum_qty');
	// 		$get_min_qty_radio = get_option('i_radio_min_qty');

	// 		if($get_minimum_qty_checkbox == 'yes' && $get_min_qty_radio == 'yes')
	// 		{
	// 			$get_id = $value['data']->get_id();
	// 			$get_quantity = $value['quantity'];

	// 			$db_val = get_post_meta($get_id, 'custom_text_field_values', true);
	// 			$whole_price = isset($db_val['wholesale_price']) ? $db_val['wholesale_price'] : '';
	// 			$minimum_qty = isset($db_val['minimum_qty']) ? $db_val['minimum_qty'] : '';

	// 			if($get_quantity >= $minimum_qty)
	// 			{
	// 				$value['data']->set_price($whole_price);
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$get_quantity_db = get_option('g_no_to_set_quantity_display');

	// 			$get_id = $value['data']->get_id();
	// 			$get_quantity = $value['quantity'];

	// 			$db_val = get_post_meta($get_id, 'custom_text_field_values', true);
	// 			$whole_price = $db_val['wholesale_price'];

	// 			if($get_quantity >= $get_quantity_db)
	// 			{
	// 				$value['data']->set_price($whole_price);
	// 			}
	// 		}
	// 		return $cart_data;
	// 	}
	// }

	// // 
	// function min_qty_setting_is_achieved_variable_product($cart)
	// {
	// 	foreach($cart->get_cart() as $key => $value)
	// 	{
	// 		$get_minimum_qty_checkbox = get_option('i_checkbox_minimum_qty');
	// 		$get_min_qty_radio = get_option('i_radio_min_qty');

	// 		if($get_minimum_qty_checkbox == 'yes' && $get_min_qty_radio == 'yes')
	// 		{
	// 			$get_id = $value['data']->get_id();
	// 			$get_quantity = $value['quantity'];
				
	// 			$a=$value['data']->get_regular_price();
	// 			print_r($a);

	// 			$db_val = get_post_meta($get_id, 'custom_field_wholesale_in_variation', true);
	// 			$whole_price = isset($db_val) ? $db_val : '';
			
	// 			$db_val_qty = get_post_meta($get_id, 'custom_field_minqty_in_variation', true);
	// 			$minimum_qty = isset($db_val_qty) ? $db_val_qty : '';
				
	// 			if($get_quantity >= $minimum_qty)
	// 			{
	// 				$value['data']->set_price($whole_price);
	// 			}
	// 			else
	// 			{
	// 				$value['data']->set_price($get_price);
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$get_quantity_db_all_product = get_option('g_no_to_set_quantity_display');
			
	// 			$get_id = $value['data']->get_id();
	// 			$get_quantity = $value['quantity'];

	// 			$db_val = get_post_meta($get_id, 'custom_field_wholesale_in_variation', true);
	// 			$whole_price = isset($db_val) ? $db_val : '';

	// 			if($get_quantity >= $get_quantity_db_all_product)
	// 			{
	// 				$value['data']->set_price($whole_price);
	// 			}
	// 		}
	// 		return $cart;
	// 	}
	// }


	

	/**
	 * min_qty_setting_is_achieved
	 * condition to renders whole sale price at the cart page at product level and for all product
	 * ONLY for simple product 
	 *
	 * @param  mixed $cart_data
	 * @return void
	*/
	public function min_qty_setting_is_achieved( $cart_data ) 
	{
		foreach ($cart_data->get_cart() as $cart => $data) {
			$prod_type = $data['data']->get_type();

			$get_minimum_qty_checkbox = get_option('i_checkbox_minimum_qty');
			$get_min_qty_radio        = get_option('i_radio_min_qty');

			if ($prod_type == 'simple') {	
				if ($get_minimum_qty_checkbox=='yes' && $get_min_qty_radio=='no') {
					$cart_quantity = $data['quantity'];
					$product_id    = $data['product_id'];
					
					$minimun_wholesale_quantity = get_option('g_no_to_set_quantity_display');
					$apply_wholesale_price      = get_post_meta($product_id, 'custom_text_field_values' , true);

					$whole_price = isset($apply_wholesale_price['wholesale_price']) ? $apply_wholesale_price['wholesale_price'] : '';
					
					if ($cart_quantity >= $minimun_wholesale_quantity) {
						$data['data']->set_price($whole_price);
					}
				} else {
					$product_id            = $data['product_id'];
					$cart_quantity         = $data['quantity'];
					$apply_wholesale_price = get_post_meta($product_id, 'custom_text_field_values' , true);
				
					$whole_price = isset($apply_wholesale_price['wholesale_price']) ? $apply_wholesale_price['wholesale_price'] : '';
					$minimum_qty = isset($apply_wholesale_price['minimum_qty']) ? $apply_wholesale_price['minimum_qty'] : '';
					
					if ($cart_quantity >= $minimum_qty) {
						$data['data']->set_price($whole_price);
					}
				}
			
			} elseif ($prod_type=='variation') {
				if ($get_minimum_qty_checkbox=='yes' && $get_min_qty_radio=='no') {
					$cart_quantity = $data['quantity'];
					$product_id    = $data['variation_id'];
					
					$minimun_wholesale_quantity = get_option('g_no_to_set_quantity_display');
					$apply_wholesale_price      = get_post_meta($product_id, 'custom_field_wholesale_in_variation' , true);
					$whole_price                = isset($apply_wholesale_price) ? $apply_wholesale_price : '';
					
					if ($cart_quantity >= $minimun_wholesale_quantity) {
						$data['data']->set_price($whole_price);
					}
				} else {
					$product_id    = $data['variation_id'];
					$cart_quantity = $data['quantity'];

					$db_val      = get_post_meta($product_id, 'custom_field_wholesale_in_variation', true);
					$whole_price = isset($db_val) ? $db_val : '';
				
					$db_val_qty  = get_post_meta($product_id, 'custom_field_minqty_in_variation', true);
					$minimum_qty = isset($db_val_qty) ? $db_val_qty : '';
					
					if ($cart_quantity >= $minimum_qty) {
						$data['data']->set_price($whole_price);
					}
				}
			}
		}
		return $cart_data;
	}


	// function author_admin_notice()
	// {
	// 	global $pagenow;
	// 	if ( $pagenow == 'index.php' ) 
	// 	{
	// 		$user = wp_get_current_user();
	// 		if ( in_array( 'author', (array) $user->roles ) ) 
	// 		{
	// 			echo '<div class="notice notice-info is-dismissible">
	// 			<p>Click on <a href="edit.php">Posts</a> to start writing.</p>
	// 			</div>';
	// 		}
	// 	}
	// }
}
