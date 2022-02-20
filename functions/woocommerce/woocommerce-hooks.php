<?php
/**
 * WooCommerce filters and hooks
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/functions
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/****************************************************************************************************************************************************/
/* WooCommerce optimization
/****************************************************************************************************************************************************/

/**
 * @see		BH_remove_woocommerce_generator_tag()
 * @see		BH_woocommerce_manage_scripts_n_styles()
 */
add_action('get_header',			'BH_remove_woocommerce_generator_tag');
add_action('wp_enqueue_scripts',	'BH_woocommerce_manage_scripts_n_styles', 100);

/****************************************************************************************************************************************************/
/* WooCommerce content wrapper customization
/****************************************************************************************************************************************************/

/**
 * @see		BH_woocommerce_wrapper_start()
 * @see		BH_woocommerce_wrapper_end()
 */
remove_action('woocommerce_before_main_content',	'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content',	'woocommerce_breadcrumb', 20);
remove_action('woocommerce_after_main_content',		'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content',		'BH_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content',		'BH_woocommerce_wrapper_end', 10);

/****************************************************************************************************************************************************/
/* WooCommerce breadcrumb
/****************************************************************************************************************************************************/

/**
 * @see		BH_woocommerce_breadcrumb_defaults()
 */
add_filter('woocommerce_breadcrumb_defaults', 'BH_woocommerce_breadcrumb_defaults');

/****************************************************************************************************************************************************/
/* WooCommerce widgets
/****************************************************************************************************************************************************/

/**
 * WooCommerce widgets customization
 * 
 * @see		override_woocommerce_widgets()
 */
add_action('widgets_init', 'override_woocommerce_widgets', 15);

/**
 * WooCommerce widget - Cart
 * 
 * @see		BH_woocommerce_shopping_cart_indicator_fragment()
 */
add_filter('woocommerce_add_to_cart_fragments', 'BH_woocommerce_shopping_cart_indicator_fragment');

/**
 * Remove action wc_track_product_view which handles "woocommerce_recently_viewed" cookie update
 * Update of "woocommerce_recently_viewed" cookie is treated manually via AJAX
 */
remove_action('template_redirect', 'wc_track_product_view', 20);

/****************************************************************************************************************************************************/
/* WooCommerce loop actions & filters
/****************************************************************************************************************************************************/

/**
 * Remove actions:
 * 
 * wc_print_notices
 * woocommerce_result_count
 */
remove_action('woocommerce_before_shop_loop', 'wc_print_notices', 10 );
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/****************************************************************************************************************************************************/
/* WooCommerce product item
/****************************************************************************************************************************************************/

/**
 * @see		BH_loop_add_to_cart_link()
 */
add_filter('woocommerce_loop_add_to_cart_link', 'BH_loop_add_to_cart_link');

/****************************************************************************************************************************************************/
/* WooCommerce shop homepage
/****************************************************************************************************************************************************/

/**
 * @see		BH_shop_home_banners()
 * @see		BH_shop_home_categories_menu()
 * @see		BH_shop_home_featured()
 * @see		BH_shop_home_product_sliders()
 */
add_action('BH_shop_home', 'BH_shop_home_banners', 10);
add_action('BH_shop_home', 'BH_shop_home_categories_menu', 20);
add_action('BH_shop_home', 'BH_shop_home_featured', 30);
add_action('BH_shop_home', 'BH_shop_home_product_sliders', 40);

/****************************************************************************************************************************************************/
/* WooCommerce shop sidebar
/****************************************************************************************************************************************************/

/**
 * @see		BH_shop_products_filter()
 * @see		BH_shop_wswu_banner()
 */
add_action('BH_shop_sidebar', 'BH_shop_products_filter', 10);
add_action('BH_shop_sidebar', 'BH_shop_wswu_banner', 20);

/****************************************************************************************************************************************************/
/* AWPF
/****************************************************************************************************************************************************/

/**
 * @see		BH_awpf_widget_tax_terms_badge()
 * @see		BH_awpf_before_filter_content()
 * @see		BH_awpf_after_filter_content()
 * @see		BH_awpf_after_filter()
 */
add_filter('awpf_widget_tax_terms/badge',	'BH_awpf_widget_tax_terms_badge', 10, 3);
add_action('awpf_before_filter_content',	'BH_awpf_before_filter_content');
add_action('awpf_after_filter_content',		'BH_awpf_after_filter_content');
add_action('awpf_after_category_filter',	'BH_awpf_after_filter');
add_action('awpf_after_price_filter',		'BH_awpf_after_filter');
add_action('awpf_after_taxonomy_filter',	'BH_awpf_after_filter');

/****************************************************************************************************************************************************/
/* WooCommerce single product
/****************************************************************************************************************************************************/

/**
 * @see		BH_shop_show_product_images()
 * @see		woocommerce_template_single_price()
 * @see		BH_shop_single_excerpt()
 * @see		woocommerce_template_single_add_to_cart()
 * @see		BH_shop_single_gift()
 * @see		BH_shop_single_meta()
 * @see		BH_shop_single_shipping()
 * @see		BH_shop_single_experience_banner()
 * @see		BH_shop_single_related_products()
 * @see		BH_EC_product_detail()					// Enhanced Ecommerce - tracking product detail
 */
add_action('BH_shop_before_single_product_meta',	'BH_shop_single_product_images', 10);
add_action('BH_shop_single_product_meta',			'woocommerce_template_single_price', 10);
add_action('BH_shop_single_product_meta',			'BH_shop_single_excerpt', 20);
add_action('BH_shop_single_product_meta',			'BH_shop_single_add_to_cart', 30);
//add_action('BH_shop_single_product_meta',			'BH_shop_single_gift', 40);
add_action('BH_shop_single_product_meta',			'BH_shop_single_content', 50);
add_action('BH_shop_single_product_meta',			'BH_shop_single_meta', 60);
add_action('BH_shop_single_product_meta',           'BH_shop_single_shipping', 70);
add_action('BH_shop_single_product_meta',           'BH_shop_single_return_policy', 80);
add_action('BH_shop_experience',					'BH_shop_single_experience_banner', 10);
add_action('BH_shop_related_products',				'BH_shop_single_related_products', 10);
add_action('BH_after_single_product',				'BH_EC_product_detail', 10);

/****************************************************************************************************************************************************/
/* WooCommerce cart
/****************************************************************************************************************************************************/

/**
 * @see		BH_shipping_options_disclaimer()
 */
//add_action('woocommerce_cart_totals_after_shipping',	'BH_shipping_options_disclaimer');
//add_action('woocommerce_review_order_after_shipping',	'BH_shipping_options_disclaimer');

/****************************************************************************************************************************************************/
/* WooCommerce checkout
/****************************************************************************************************************************************************/

/**
 * @see		BH_checkout_title()
 * @see		BH_checkout_order_pay_title()
 * @see		BH_checkout_order_received_title()
 * @see		BH_review_order_before_payment()
 * @see		BH_change_default_checkout_country()
 * @see		BH_change_default_checkout_state()
 */
add_action('woocommerce_before_checkout_form',			'BH_checkout_title', 0, 1);
add_action('before_woocommerce_pay',					'BH_checkout_order_pay_title');
add_filter('woocommerce_thankyou_order_received_text',	'BH_checkout_order_received_title');
add_action('woocommerce_review_order_before_payment',	'BH_review_order_before_payment');
add_filter('default_checkout_country',					'BH_change_default_checkout_country');
add_filter('default_checkout_state',					'BH_change_default_checkout_state');

/****************************************************************************************************************************************************/
/* WooCommerce orders
/****************************************************************************************************************************************************/

/**
 * @see		BH_shop_order_invoice()
 * @see		BH_shop_order_refund()
 */
add_action('woocommerce_order_status_completed',	'BH_shop_order_invoice', 10, 1);
add_action('woocommerce_refund_created',			'BH_shop_order_refund', 10, 2);

/****************************************************************************************************************************************************/
/* WooCommerce help functions
/****************************************************************************************************************************************************/

/**
 * @see		BH_shop_price_html()
 * @see		BH_shop_sale_price_html()
 * @see		BH_shop_catalog_orderby_options()
 */
add_filter('woocommerce_price_html', 'BH_shop_price_html', 10, 2);
add_filter('woocommerce_sale_price_html', 'BH_shop_sale_price_html', 10, 2);
add_filter('woocommerce_catalog_orderby', 'BH_shop_catalog_orderby_options');