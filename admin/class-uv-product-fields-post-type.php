<?php

/**
 * The class which registers the custom post type of the plugin.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Product_Fields
 * @subpackage Uv_Product_Fields/admin
 */

/**
 * Registers the custom post type.
 *
 */
class Uv_Product_Fields_Post_Type {

	public function load() {
		add_action( 'init', array( $this, 'uv_register_post_type' ), 0 );
	}

	public function uv_register_post_type() {
		$labels = array(
			'name' => _x( 'Product Fields', 'Post Type General Name', 'uv-product-fields' ),
			'singular_name' => _x( 'Product Field', 'Post Type Singular Name', 'uv-product-fields' ),
			'menu_name' => _x( 'Product Fields', 'Admin Menu text', 'uv-product-fields' ),
			'name_admin_bar' => _x( 'Product Fields', 'Add New on Toolbar', 'uv-product-fields' ),
			'archives' => __( 'Product Field Archives', 'uv-product-fields' ),
			'attributes' => __( 'Product Field Attributes', 'uv-product-fields' ),
			'parent_item_colon' => __( 'Parent Product Field:', 'uv-product-fields' ),
			'all_items' => __( 'All Product Fields', 'uv-product-fields' ),
			'add_new_item' => __( 'Add New Product Field', 'uv-product-fields' ),
			'add_new' => __( 'Add New', 'uv-product-fields' ),
			'new_item' => __( 'New Product Field', 'uv-product-fields' ),
			'edit_item' => __( 'Edit Product Field', 'uv-product-fields' ),
			'update_item' => __( 'Update Product Field', 'uv-product-fields' ),
			'view_item' => __( 'View Product Field', 'uv-product-fields' ),
			'view_items' => __( 'View Product Fields', 'uv-product-fields' ),
			'search_items' => __( 'Search Product Fields', 'uv-product-fields' ),
			'not_found' => __( 'Not found', 'uv-product-fields' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'uv-product-fields' ),
			'featured_image' => __( 'Featured Image', 'uv-product-fields' ),
			'set_featured_image' => __( 'Set featured image', 'uv-product-fields' ),
			'remove_featured_image' => __( 'Remove featured image', 'uv-product-fields' ),
			'use_featured_image' => __( 'Use as featured image', 'uv-product-fields' ),
			'insert_into_item' => __( 'Insert into Product Field', 'uv-product-fields' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Product Field', 'uv-product-fields' ),
			'items_list' => __( 'Product Fields list', 'uv-product-fields' ),
			'items_list_navigation' => __( 'Product Fields list navigation', 'uv-product-fields' ),
			'filter_items_list' => __( 'Filter Product Fields list', 'uv-product-fields' ),
		);
		$args = array(
			'label' => __( 'Product Fields', 'uv-product-fields' ),
			'description' => __( 'Register Custom Product Fields', 'uv-product-fields' ),
			'labels' => $labels,
			'menu_icon' => 'dashicons-edit',
			'supports' => array(
				'title',
				'page-attributes'
			),
			'taxonomies' => array(),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 80,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'can_export' => true,
			'has_archive' => false,
			'hierarchical' => false,
			'exclude_from_search' => false,
			'show_in_rest' => false,
			'publicly_queryable' => false,
			'capability_type' => 'post',
			'rewrite' => false,
		);
		register_post_type( 'uv_product_fields', $args );
	}

}
