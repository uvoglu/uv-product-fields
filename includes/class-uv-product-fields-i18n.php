<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/includes
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Product_Fields_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'uv-product-fields',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Register hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function load() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}

}
