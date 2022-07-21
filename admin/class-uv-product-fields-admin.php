<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/admin
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Product_Fields_Admin {

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
	 * Register hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function load() {
		$this->load_post_type();
		$this->load_meta_box();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Load custom post type.
	 *
	 * @since    1.0.0
	 */
	private function load_post_type() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uv-product-fields-post-type.php';
		$post_type = new Uv_Product_Fields_Post_Type();
		$post_type->load();
	}

	/**
	 * Load custom fields for custom post type.
	 *
	 * @since    1.0.0
	 */
	private function load_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uv-product-fields-meta-fields.php';
		$meta_fields = new Uv_Product_Fields_Meta_Fields();
		$meta_fields->load();
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
		 * defined in Uv_Product_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Product_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uv-product-fields-admin.css', array(), $this->version, 'all' );

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
		 * defined in Uv_Product_Fields_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Product_Fields_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uv-product-fields-admin.js', array( 'jquery' ), $this->version, false );

	}

}
