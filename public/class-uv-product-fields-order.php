<?php

/**
 * Hooks into addidng creating the order and adds
 * the custom meta value to the order.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/public
 */

class Uv_Product_Fields_Order {

	public function load() {
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'uv_add_fields_to_order' ), 10, 4 );
	}

	public function uv_add_fields_to_order( $item, $cart_item_key, $values, $order ) {
		if ( empty( $values[ 'uv_product_fields' ] ) ) {
			return;
		}

		$fields = $values[ 'uv_product_fields' ];
		foreach ( $fields as $field ) {
			$item->add_meta_data( $field[ 'title' ], $field[ 'value' ] );
		}
	}

}
