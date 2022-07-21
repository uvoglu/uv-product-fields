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

class Uv_Product_Fields_Cart_Add {

	public function load() {
		add_action( 'woocommerce_add_cart_item_data', array( $this, 'uv_add_to_cart' ), 10, 3 );
		add_action( 'woocommerce_before_calculate_totals', array( $this, 'uv_calculate_price' ), 99 );
	}

	public function uv_add_to_cart( $cart_item_data, $product_id, $variation_id ) {
		foreach ( $this->get_fields() as $field ) {
			$cart_item_data = $this->add_field_to_cart( $field, $cart_item_data );
		}
		return $cart_item_data;
	}

	public function uv_calculate_price( $cart_object ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		foreach ( $cart_object->get_cart() as $cart_item ) {
			if ( isset( $cart_item[ 'uv_product_fields' ] ) ) {
				$item_data = $cart_item[ 'data' ];
				$current_price = $item_data->get_price();
				$modified_price = $current_price;

				$product_fields = $cart_item[ 'uv_product_fields' ];
				foreach ( $product_fields as $product_field ) {
					if ( isset( $product_field[ 'price_difference' ] ) ) {
						$price_difference = $product_field[ 'price_difference' ];
						$modified_price += $price_difference;
					}
				}

				$item_data->set_price( $modified_price );
			}
		}

	}

	private function get_fields() {
		$args = array(
			'post_type' => 'uv_product_fields',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		);

		return get_posts( $args );
	}

	private function add_field_to_cart( $field, $cart_item_data ) {
		$post_field_name = 'uv_product_field_' . $field->ID;
		$field_input = filter_input( INPUT_POST, $post_field_name );
		$field_price_difference = $this->get_field_price_difference( $field->ID );

		if ( empty( $field_input ) ) {
			return $cart_item_data;
		}

		if ( ! isset( $cart_item_data[ 'uv_product_fields' ] ) ) {
			$cart_item_data[ 'uv_product_fields' ] = array();
		}

		$cart_item_data[ 'uv_product_fields' ][ $field->ID ] = array(
			'name' => $field->post_name,
			'title' => $field->post_title,
			'value' => $field_input,
			'price_difference' => $field_price_difference
		);

		return $cart_item_data;
	}

	private function get_field_price_difference( $field_id ) {
		$price_difference = get_post_meta( $field_id, '_uv_product_fields_price_difference', true );
		return floatval( $price_difference );
	}

}
