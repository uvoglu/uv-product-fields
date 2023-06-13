<?php

/**
 * Displays fields on product page.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/public
 */

class Uv_Product_Fields_Product {

	public function load() {
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'uv_add_product_fields' ), 10 );
		add_filter( 'wc_stripe_hide_payment_request_on_product_page', array( $this, 'uv_hide_express_checkout' ), 10, 2 );
	}

	public function uv_add_product_fields() {
		global $product;

		$category_ids = $product->get_category_ids();
		$fields = $this->get_fields_for_categories( $category_ids );

		$this->render_product_fields( $fields );
	}

	public function uv_hide_express_checkout( $initial_value, $post ) {
		$categories = get_the_terms( $post->ID, 'product_cat' );

		if ( ! is_iterable( $categories ) ) {
			return $initial_value;
		}

		$category_ids = array();
		foreach ( $categories as $category ) {
			$category_ids[] = $category->term_id;
		}

		return ! empty( $this->get_fields_for_categories( $category_ids ) );
	}

	private function get_fields_for_categories( $category_ids ) {
		$meta_query = array(
			'relation' => 'OR',
		);

		foreach ( $category_ids as $category_id ) {
			$meta_query[] = array(
				'key' => '_uv_product_fields_categories',
				'value' => serialize( strval( $category_id ) ),
				'compare' => 'LIKE',
			);
		}

		$args = array(
			'post_type' => 'uv_product_fields',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => $meta_query,
		);

		return get_posts( $args );
	}

	private function render_product_fields( $fields ) {
		$output = <<<EOT
		<div class="uv-product-fields">
			<table class="variations" cellspacing="0", role="presentation">
				<tbody>
		EOT;

		foreach ( $fields as $field ) {
			$field_type = get_post_meta( $field->ID, '_uv_product_fields_type', true );
			switch ( $field_type ) {
				case 'input':
					$output .= $this->render_product_input_field( $field );
					$output .= "\n";
					break;
			}
		}

		$output .= <<<EOT
				</tbody>
			</table>
		</div>
		EOT;

		echo $output;
	}

	private function render_product_input_field( $field ) {
		$id = $field->ID;

		$title = $field->post_title;
		$name = 'uv_product_field_' . $field->ID;

		$description = get_post_meta( $id, '_uv_product_fields_description', true );
		$price_difference = get_post_meta( $id, '_uv_product_fields_price_difference', true );
		$min_length = get_post_meta( $id, '_uv_product_fields_min_length', true );
		$max_length = get_post_meta( $id, '_uv_product_fields_max_length', true );

		$title_components = array( $title );
		$price_difference = floatval( $price_difference );
		if ( isset( $price_difference ) && ! empty( $price_difference ) ) {
			$title_components[] = '<span class="uv-product-fields-price-difference">(' . wc_price( $price_difference ) . ')</span>';
		}

		$title_label = implode( ' ', $title_components );

		$output = <<<EOT
			<tr>
				<th class="label">
					<label for="$name">$title_label</label>
				</th>
				<td class="value">
					<input
						type="text"
						name="$name"
						id="$name"
						minlength="$min_length"
						maxlength="$max_length"
					/>
				</td>
			</tr>
		EOT;

		if ( ! empty( $description ) ) {
			$output .= <<<EOT
				<tr class="uv-product-field-description">
					<th colspan="2">$description</th>
				</tr>
			EOT;
		}

		return $output;
	}

}
