<?php

/**
 * The class which registers custom meta fields for the custom
 * post type of this plugin.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/admin
 */

/**
 * Registers the custom meta fields.
 *
 */
class Uv_Product_Fields_Meta_Fields {

	public function __construct() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-walker-product-categories.php';
	}

	public function load() {
		add_action( 'add_meta_boxes', array( $this, 'uv_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'uv_save_fields' ) );
	}

	private $screen = array(
		'uv_product_fields',
	);

	private function get_meta_fields() {
		return array(
			array(
				'label' => __( 'Categories', 'uv-product-fields' ),
				'id' => '_uv_product_fields_categories',
				'type' => 'product_categories',
				'class' => 'uv-product-field-categories'
			),
			array(
				'label' => __( 'Type', 'uv-product-fields' ),
				'id' => '_uv_product_fields_type',
				'type' => 'select',
				'options' => array(
					array( 'input', __( 'Text', 'uv-product-fields' ) ),
				),
			),
			array(
				'label' => __( 'Description', 'uv-product-fields' ),
				'id' => '_uv_product_fields_description',
				'type' => 'textarea',
			),
			array(
				'label' => __( 'Minimum Length', 'uv-product-fields' ),
				'id' => '_uv_product_fields_min_length',
				'type' => 'number',
			),
			array(
				'label' => __( 'Maximum Length', 'uv-product-fields' ),
				'id' => '_uv_product_fields_max_length',
				'type' => 'number',
			),
			array(
				'label' => __( 'Price Difference', 'uv-product-fields' ),
				'id' => '_uv_product_fields_price_difference',
				'type' => 'number',
			),
		);
	}

	public function uv_add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'product_fields',
				__( 'Product Field', 'uv-product-fields' ),
				array( $this, 'uv_meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}

	public function uv_meta_box_callback( $post ) {
		wp_nonce_field( 'product_fields_data', 'product_fields_nonce' );
		$this->field_generator( $post );
	}

	private function field_generator( $post ) {
		$output = '';

		foreach ( $this->get_meta_fields() as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';

			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) && isset( $meta_field['default'] ) ) {
				$meta_value = $meta_field['default'];
			}

			switch ( $meta_field['type'] ) {
				case 'select':
					$input = $this->generate_select_field( $meta_field, $meta_value );
					break;
				case 'textarea':
					$input = $this->generate_textarea_field( $meta_field, $meta_value );
					break;
				case 'product_categories':
					$input = $this->generate_product_categories_field( $meta_field, $meta_value );
					break;
				default:
					$input = $this->generate_input_field( $meta_field, $meta_value );
			}

			$class = isset( $meta_field['class'] ) ? $meta_field['class'] : '';
			$output .= $this->format_rows( $label, $input, $class );
		}

		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function uv_save_fields( $post_id ) {
		if ( ! isset( $_POST['product_fields_nonce'] ) ) {
			return $post_id;
		}
		$nonce = $_POST['product_fields_nonce'];
		if ( !wp_verify_nonce( $nonce, 'product_fields_data' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		foreach ( $this->get_meta_fields() as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				$this->sanitize_fields( $meta_field['type'], $meta_field['id'] );
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			} else if ( $meta_field['type'] === 'product_categories' ) {
				update_post_meta( $post_id, $meta_field['id'], array() );
			}
		}
	}

	private function format_rows( $label, $input, $class ) {
		return '<tr class="' . $class . '"><th>' . $label . '</th><td>' . $input . '</td></tr>';
	}

	private function generate_select_field( $meta_field, $meta_value ) {
		$input = sprintf(
			'<select id="%s" name="%s">',
			$meta_field['id'],
			$meta_field['id']
		);

		foreach ( $meta_field['options'] as $option ) {
			$option_value = $option[0];
			$readable_value = $option[1];

			$input .= sprintf(
				'<option %s value="%s">%s</option>',
				$meta_value === $option_value ? 'selected' : '',
				$option_value,
				$readable_value
			);
		}

		$input .= '</select>';

		return $input;
	}

	private function generate_product_categories_field( $meta_field, $meta_value ) {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return '<div class="description">' . __( 'It seems that WooCommerce is not installed. WooCommerce is required for this plugin to work.', 'uv-product-fields' ) . '</div>';
		}
		$waker = new Uv_Walker_Product_Categories( $meta_field['id'] );
		$categories_args = array(
			'selected_cats' => $meta_value,
			'echo' => false,
			'taxonomy' => 'product_cat',
			'walker' => $waker,
		);
		return wp_terms_checklist( 0, $categories_args );
	}

	private function generate_textarea_field( $meta_field, $meta_value ) {
		return sprintf(
			'<textarea style="width: 100%%" id="%s" name="%s" rows="5">%s</textarea>',
			$meta_field['id'],
			$meta_field['id'],
			$meta_value
		);
	}

	private function generate_input_field( $meta_field, $meta_value ) {
		return sprintf(
			'<input %s %s id="%s" name="%s" type="%s" value="%s">',
			$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
			$meta_field['type'] === 'number' ? 'step="any"' : '',
			$meta_field['id'],
			$meta_field['id'],
			$meta_field['type'],
			$meta_value,
		);
	}

	private function sanitize_fields( $field_type, $field_id ) {
		switch ( $field_type ) {
			case 'email':
				$_POST[ $field_id ] = sanitize_email( $_POST[ $field_id ] );
				break;
			case 'text':
				$_POST[ $field_id ] = sanitize_text_field( $_POST[ $field_id ] );
				break;
		}
	}

}
