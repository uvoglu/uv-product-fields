<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/public
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Product_Fields_Public {

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
	 * Register hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function load() {
		$this->load_product_page();
		$this->load_add_to_cart();
		$this->load_display_cart();
		$this->load_create_order();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Load product page content.
	 *
	 * @since    1.0.0
	 */
	private function load_product_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uv-product-fields-product.php';
		$product_page = new Uv_Product_Fields_Product();
		$product_page->load();
	}

	/**
	 * Load add to cart hook.
	 *
	 * @since    1.0.0
	 */
	private function load_add_to_cart() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uv-product-fields-cart-add.php';
		$cart_add = new Uv_Product_Fields_Cart_Add();
		$cart_add->load();
	}

	/**
	 * Load cart display hook.
	 *
	 * @since    1.0.0
	 */
	private function load_display_cart() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uv-product-fields-cart-display.php';
		$cart_display = new Uv_Product_Fields_Cart_Display();
		$cart_display->load();
	}

	/**
	 * Load order creation hook
	 *
	 * @since    1.0.0
	 */
	private function load_create_order() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uv-product-fields-order.php';
		$create_order = new Uv_Product_Fields_Order();
		$create_order->load();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Uv_Product_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Product_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uv-product-fields-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Uv_Product_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Product_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uv-product-fields-public.js', array( 'jquery' ), $this->version, false );

	}

}
