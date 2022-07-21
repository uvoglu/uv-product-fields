=== WooCoommerce Custom Product Fields ===
Contributors: uvoglu
Tags: woocommerce
Requires at least: 6.0.0
Tested up to: 6.0.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add custom fields to WooCommerce product pages, which allow to customize an order. Pricing can be modified if the field is set.

== Description ==

Add custom fields to WooCommerce product pages, which allow to customize an order. Pricing can be modified if the field is set.

To add the fields to a product, assign the product a product-category and make sure this category is checked in the custom field's categories selection.

Currently, text input-fields are supported. Other fields might be added in the future.
The price can optionally be changed by a fixed value, in case the custom field is set. Fields can also be validated by simple HTML5 input tags by defining a minimum and maximum length. Note that currently no server-side validation is done.

== Installation ==

1. Upload `uv-product-fields.zip` using the plugins-page in WordPress or upload the un-zipped folder to `/wp-content/plugins/uv-product-fields`.
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.0.2 =
* Disable Stripe Express Checkout Button (Apple Pay, Google Pay) on product page, as custom fields would not be applied.

= 1.0.1 =
* Minor fixes and improvements.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==
