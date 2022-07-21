<?php

/**
 * Hooks into addidng the product to the cart
 * and applies the contents passed.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/public
 */

class Uv_Product_Fields_Cart_Display {

	public function load() {
		add_action( 'woocommerce_get_item_data', array( $this, 'uv_display_cart' ), 10, 3 );
	}

	public function uv_display_cart( $item_data, $cart_item ) {
		foreach ( $this->get_fields() as $field ) {
			$item_data = $this->display_field_in_cart( $field, $item_data, $cart_item );
		}
		return $item_data;
	}

	private function get_fields() {
		$args = array(
			'post_type' => 'uv_product_fields',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		);

		return get_posts( $args );
	}

	private function display_field_in_cart( $field, $item_data, $cart_item ) {
		if (
			empty( $cart_item[ 'uv_product_fields' ] ) ||
			empty( $cart_item[ 'uv_product_fields' ][ $field->ID ] )
		) {
			return $item_data;
		}

		$item_data[] = array(
			'key' => $field->post_title,
			'value' => wc_clean( $cart_item[ 'uv_product_fields' ][ $field->ID ][ 'value' ] ),
			'display' => '',
		);

		return $item_data;
	}

}
