<?php
/**
 * WooCommerce functions
 *
 * @author		Beit Hatfutsot
 * @package		bh/functions/woocommerce
 * @version		3.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_theme_support( 'woocommerce' );

/****************************************************************************************************************************************************/
/* WooCommerce optimization
/****************************************************************************************************************************************************/

/**
 * BH_remove_woocommerce_generator_tag
 * 
 * Remove WooCommerce Generator tag
 *
 * @param	N/A
 * @return	N/A
 */
function BH_remove_woocommerce_generator_tag() {

	remove_action( 'wp_head', 'wc_generator_tag' );

}

/**
 * BH_woocommerce_manage_scripts_n_styles
 * 
 * Optimize WooCommerce scripts and styles
 * Remove WooCommerce scripts and styles from non WooCommerce pages
 *
 * @param	N/A
 * @return	N/A
 */
function BH_woocommerce_manage_scripts_n_styles() {

	if ( is_admin() || ! is_page() )
		return;

	/**
	 * Variables
	 */
	global	$globals,
			$post;

	$globals[ 'shop_page' ] = ( function_exists( 'get_field' ) && get_field( 'acf-shop_page', $post->ID ) ) || 'shop-why-shop-with-us.php' == basename( get_page_template() ) || 'shop-about.php' == basename( get_page_template() ) || is_cart() || is_checkout() || is_account_page();		// is shop page (true/false)

	if ( function_exists( 'is_woocommerce' ) ) {

		// Dequeue scripts and styles
		if ( ! is_woocommerce() && ! $globals[ 'shop_page' ] ) {
			// Woocommerce styles
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'mijireh_css' );

			// Woocommerce-multilingual styles
			wp_dequeue_style( 'wcml_wc' );
			wp_dequeue_style( 'currency-switcher' );
			wp_dequeue_style( 'wpml-wcml-prices' );
			wp_dequeue_style( 'toolset-font-awesome' );
			wp_dequeue_style( 'wpml-wcml' );
			wp_dequeue_style( 'cleditor' );
			wp_dequeue_style( 'wp-pointer' );
			wp_dequeue_style( 'buttons' );

			// Woocommerce scripts
			wp_dequeue_script( 'wc-credit-card-form' );
			wp_dequeue_script( 'chosen' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-payment' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-country-select' );
			wp_dequeue_script( 'wc-address-i18n' );
			wp_dequeue_script( 'jquery-cookie' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-payment-method' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'pusher' );
			wp_dequeue_script( 'page_slurp' );
			wp_dequeue_script( 'simplify-commerce' );
			wp_dequeue_script( 'wc-simplify-commerce' );
			wp_dequeue_script( 'wc-price-slider' );

			// Woocommerce-multilingual styles
			wp_dequeue_script( 'wcml-tm-scripts-prices' );
			wp_dequeue_script( 'wcml-scripts' );
			wp_dequeue_script( 'wcml-tm-scripts' );
			wp_dequeue_script( 'cleditor' );
			wp_dequeue_script( 'suggest' );
			wp_dequeue_script( 'wp-pointer' );
			wp_dequeue_script( 'word-count' );
			wp_dequeue_script( 'editor' );
			wp_dequeue_script( 'quicktags' );
			wp_dequeue_script( 'wpml_tm' );
			wp_dequeue_script( 'wcml-lock-script' );
		}

	}

}

/****************************************************************************************************************************************************/
/* WooCommerce content wrapper customization
/****************************************************************************************************************************************************/

/**
 * BH_woocommerce_wrapper_start
 * 
 * WooCommerce Content Wrapper start
 *
 * @param	N/A
 * @return	N/A
 */
function BH_woocommerce_wrapper_start() {

	echo '<section class="page-content">';

}

/**
 * BH_woocommerce_wrapper_end
 * 
 * WooCommerce Content Wrapper end
 *
 * @param	N/A
 * @return	N/A
 */
function BH_woocommerce_wrapper_end() {

	echo '</section>';

}

/****************************************************************************************************************************************************/
/* WooCommerce breadcrumb
/****************************************************************************************************************************************************/

/**
 * BH_woocommerce_breadcrumb_defaults
 * 
 * WooCommerce breadcrumb manipulation
 *
 * @param	$defaults (array) WooCommerce breadcrumb default attributes
 * @return	(array)
 */
function BH_woocommerce_breadcrumb_defaults( $defaults ) {

	$defaults[ 'home' ]			= __( 'Home', 'BH' );
	$defaults[ 'delimiter' ]	= '<span class="breadcrumb-delimiter bh-sprites"></span>';
	$defaults[ 'wrap_before' ]	= '<nav class="woocommerce-breadcrumb">';
	$defaults[ 'wrap_after' ]	= '</nav>';

	// return
	return $defaults;

}

/****************************************************************************************************************************************************/
/* WooCommerce widgets
/****************************************************************************************************************************************************/

/**
 * override_woocommerce_widgets
 * 
 * @overrides	WC_Widget_Recently_Viewed
 *
 * @param	N/A
 * @return	N/A
 */
function override_woocommerce_widgets() {

	/**
	 * WC_Widget_Recently_Viewed
	 */
	if ( class_exists( 'WC_Widget_Recently_Viewed' ) ) {

		unregister_widget( 'WC_Widget_Recently_Viewed' );

		include_once( 'widgets/woocommerce-recently-viewed.php' );

		register_widget( 'BH_WC_Widget_Recently_Viewed' );

	}

}

/**
 * BH_woocommerce_shopping_cart_indicator_fragment
 * 
 * Ajaxify shopping cart indicator widget
 * Ensure shopping cart indicator update when products are added to the cart via AJAX
 *
 * @param	$fragments (array)
 * @return	(array)
 */
function BH_woocommerce_shopping_cart_indicator_fragment( $fragments ) {

	/**
	 * Variables
	 */
	global $woocommerce;

	ob_start();

	echo '<div class="widget_shopping_cart_indicator">' . ( $woocommerce->cart->cart_contents_count ? '<span>' . $woocommerce->cart->cart_contents_count . '</span>' : '' ) . '</div>';

	$fragments[ 'div.widget_shopping_cart_indicator' ] = ob_get_clean();

	// return
	return $fragments;

}

/**
 * BH_add_viewed_products
 * 
 * Add post ID and all translated post IDs to a given array
 * Used to maintain the "woocommerce_recently_viewed" cookie
 * 
 * @param	$post_id (int) post ID
 * @param	&$viewed_products (&array) recently viewed products array
 * @return	N/A
 */
function BH_add_viewed_products( $post_id, &$viewed_products ) {

	/**
	 * Variables
	 */
	$languages = icl_get_languages( 'skip_missing=1' );

	if ( ! empty( $languages ) ) {

		foreach ( $languages as $l ) {

			$id		= icl_object_id( $post_id, 'product', false, $l[ 'language_code' ] );
			$key	= array_search( $id, $viewed_products );

			if ( $key === false ) {
				// post doesn't exist in array - add a new post ID
				array_unshift( $viewed_products, $id );

				if ( sizeof( $viewed_products ) > 40 )
					array_pop( $viewed_products );
			} else {
				// post exists in array - prepent post ID
				unset( $viewed_products[ $key ] );
				array_unshift( $viewed_products, $id );
			}

		}

	}

}

/**
 * BH_remove_viewed_products
 * 
 * Remove post ID and all translated post IDs from a given array
 * Used to maintain the "woocommerce_recently_viewed" cookie
 * 
 * @param	$post_id (int) post ID
 * @param	&$viewed_products (&array) recently viewed products array
 * @return	N/A
 */
function BH_remove_viewed_products( $post_id, &$viewed_products ) {

	/**
	 * Variables
	 */
	$languages = icl_get_languages( 'skip_missing=1' );

	if ( ! empty( $languages ) ) {
	
		foreach ( $languages as $l ) {

			$id = icl_object_id( $post_id, 'product', false, $l[ 'language_code' ] );

			$key_to_remove = array_search( $id, $viewed_products );

			if ( $key_to_remove !== false ) {
				// post exists in array - remove post ID
				unset( $viewed_products[ $key_to_remove ] );
			}

		}

	}

}

/****************************************************************************************************************************************************/
/* WooCommerce product item
/****************************************************************************************************************************************************/

/**
 * BH_loop_add_to_cart_link
 * 
 * Add to cart link customization
 *
 * @param	N/A
 * @return	N/A
 */
function BH_loop_add_to_cart_link() {

	/**
	 * Variables
	 */
	global $product;

	/**
	 * Enhanced Ecommerce - "add to cart" event tracking
	 * Collect product info and submit it on form submission
	 */
	$p_id		= $product->get_id();
	$p_sku		= esc_js( $product->get_sku() );
	$p_name		= esc_js( $product->get_title() );
	$p_currency	= get_woocommerce_currency();

	/**
	 * Filter product price and currency
	 * Used in case of an AJAX call and active woocommerce wpml
	 */
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && class_exists( 'woocommerce_wpml' ) ) {
		$p_price = number_format( (float)apply_filters( 'wcml_raw_price_amount', $product->get_price() ), 2, '.', '' );
		$p_currency = apply_filters( 'wcml_price_currency', $p_currency );
	} else {
		$p_price = number_format( (float)$product->get_price(), 2, '.', '' );
	}

	$category = '';
	$product_cats = wp_get_post_terms( $p_id, 'product_cat' );
	if ( $product_cats && ! is_wp_error( $product_cats ) ) :
		$single_cat	= array_shift( $product_cats );
		$category	= esc_js( $single_cat->name );
	endif;

	echo sprintf( '<a href="#" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s ajax_add_to_cart" onclick="BH_EC_onUpdateCart(\'' . $p_sku . '\', \'' . $p_name . '\', \'' . $category . '\', \'' . $p_price . '\', \'' . $p_currency . '\', 1, \'add\'); BH_FB_onAddToCart(\'' . $p_sku . '\', \'' . $p_name . '\', \'' . $category . '\', \'' . $p_price . '\', \'' . $p_currency . '\'); return true;"></a>',
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		esc_attr( $product->get_type() )
	);

}

/****************************************************************************************************************************************************/
/* WooCommerce shop homepage
/****************************************************************************************************************************************************/

/**
 * BH_shop_home_banners
 * 
 * Display shop homepage banners
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_home_banners() {

	get_template_part( 'views/woocommerce/archive/home', 'banners' );

}

/**
 * BH_shop_home_categories_menu
 * 
 * Display shop homepage categories menu
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_home_categories_menu() {

	get_template_part( 'views/woocommerce/archive/home', 'categories-menu' );

}

/**
 * BH_shop_home_featured
 * 
 * Display shop homepage featured products
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_home_featured() {

	get_template_part( 'views/woocommerce/archive/home', 'featured' );

}

/**
 * BH_shop_home_product_sliders
 * 
 * Display shop homepage sliders
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_home_product_sliders() {

	get_template_part( 'views/woocommerce/archive/home', 'sliders' );

}

/****************************************************************************************************************************************************/
/* WooCommerce shop sidebar
/****************************************************************************************************************************************************/

/**
 * BH_shop_archive_title
 * 
 * Display archive title (product taxonomy term / search results query string)
 *
 * @param	N/A
 * @return	(string)
 */
function BH_shop_archive_title() {

	ob_start();

	echo get_template_part( 'views/woocommerce/archive/archive', 'title' );

	$output = ob_get_clean();

	// return
	return $output;

}

/**
 * BH_shop_products_filter
 *
 * Display products filter widget area
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_products_filter() {

	get_template_part( 'views/sidebar/sidebar-shop', 'products-filter' );

}

/**
 * BH_shop_wswu_banner
 *
 * Display Why Shop With Us banner
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_wswu_banner() {

	//get_template_part( 'views/sidebar/sidebar-shop', 'wswu-banner' );

}

/****************************************************************************************************************************************************/
/* AWPF
/****************************************************************************************************************************************************/

/**
 * BH_awpf_widget_tax_terms_badge
 *
 * Customize AWPF badge taxonomy filter
 *
 * @param	$output (string) modified value
 * @param	$tax_name (string) taxonomy name
 * @param	$terms (array) array of taxonomy terms - view from $taxonomies attribute
 * @return	(string)
 */
function BH_awpf_widget_tax_terms_badge( $output, $tax_name, $terms ) {

	if ( ! $tax_name || ! $terms || ! function_exists( 'get_field' ) )
		return;

	$output = '';

	foreach ( $terms as $term_id => $term_data ) {
		$name	= get_term_by( 'id', $term_id, $tax_name )->name;
		$image	= get_field( 'acf-product-badge_image', $tax_name . '_' . $term_id );
		$color	= get_field( 'acf-product-badge_color', $tax_name . '_' . $term_id );

		$output .=	'<li class="term-' . $term_id . '"' . ( ! $term_data[0] ? ' style="display: none;"' : '' ) . '>' .
						'<input type="checkbox" name="' . $term_id . '" id="' . $term_id . '" value="' . $term_id . '" />' .
						'<label for="' . $term_id . '">' .
							'<div class="badge-name-wrapper"' . ( $color ? ' style="background-color: ' . $color . '"' : '' ) . '>' .
								( $image ? '<div class="badge-image"><img src="' . $image[ 'url' ] . '" width="' . $image[ 'width' ] . '" height="' . $image[ 'height' ] . '" alt="' . $name . '" /></div>' : '' ) .
								'<div class="badge-name">' . $name . '</div>' .
								'<div class="item-checked-top"></div>' .
								'<div class="item-checked-bottom"></div>' .
								'<div class="item-after"' . ( $color ? ' style="border-top-color: ' . $color . '"' : '' ) . '></div>' .
							'</div>' .
							'<div class="badge-count">(<span class="count">' . $term_data[0] . '</span>)</div>' .
						'</label>' .
					'</li>';
	}

	$output .= '<style>';

	foreach ( $terms as $term_id => $term_data ) {
		$checked_color	= get_field( 'acf-product-badge_checked_color', $tax_name . '_' . $term_id );

		$output .=	'.awpf-tax-filter-badge li.term-' . $term_id . ' .badge-name-wrapper .item-checked-top {border-bottom-color: ' . $checked_color . ';}' .
					'.awpf-tax-filter-badge li.term-' . $term_id . ' .badge-name-wrapper .item-checked-bottom:before,' .
					'.awpf-tax-filter-badge li.term-' . $term_id . ' .badge-name-wrapper .item-checked-bottom:after {background-color: ' . $checked_color . ';}';
	}

	$output .= '</style>';

	// return
	return $output;

}

/**
 * BH_awpf_before_filter_content
 *
 * Add a filter toggle button and open filters wrapper
 * Presented in mobile resolution
 *
 * @param	N/A
 * @return	N/A
 */
function BH_awpf_before_filter_content() {

	echo '<div class="awpf-filters-toggle visible-xs"><h3><span class="inactive">' . __( 'Show product filters', 'BH' ) . '</span><span class="active">' . __( 'Hide product filters', 'BH' ) . '</span></h3></div>';
	echo '<div class="awpf-filters-wrapper">';

}

/**
 * BH_awpf_after_filter_content
 *
 * Close filters wrapper
 * Presented in mobile resolution
 *
 * @param	N/A
 * @return	N/A
 */
function BH_awpf_after_filter_content() {

	echo '</div>';

}

/**
 * BH_awpf_after_filter
 *
 * Add an internal link button after each filter type
 * Presented in mobile resolution
 *
 * @param	N/A
 * @return	N/A
 */
function BH_awpf_after_filter() {

	echo '<div class="goto-products visible-xs">' . __( 'Filter products', 'BH' ) . '</div>';

}

/****************************************************************************************************************************************************/
/* WooCommerce shop archive
/****************************************************************************************************************************************************/

/**
 * BH_shop_tt_banner
 * 
 * Display product taxonomy term banner
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_tt_banner() {

	get_template_part( 'views/woocommerce/archive/taxonomy-term', 'banner' );

}

/****************************************************************************************************************************************************/
/* WooCommerce single product
/****************************************************************************************************************************************************/

/**
 * BH_shop_single_product_images
 * 
 * Section 1
 * Display product gallery
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_product_images() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'images' );

}

/**
 * BH_shop_single_excerpt
 * 
 * Section 1
 * Display product excerpt
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_excerpt() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'excerpt' );

}

/**
 * BH_shop_single_add_to_cart
 * 
 * Section 1
 * Display Add to Cart form
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_add_to_cart() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'add-to-cart' );

}

/**
 * BH_shop_single_gift
 * 
 * Section 1
 * Display product gift form
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_gift() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'gift' );

}

/**
 * BH_shop_single_content
 * 
 * Section 1
 * Display product content
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_content() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'content' );

}

/**
 * BH_shop_single_meta
 * 
 * Section 1
 * Display product meta information
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_meta() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'meta' );

}

/**
 * BH_shop_single_shipping
 * 
 * Section 1
 * Display product shipping info
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_shipping() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'shipping' );

}

/**
 * BH_shop_single_return_policy
 * 
 * Section 1
 * Display product return policy
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_return_policy() {

	get_template_part( 'views/woocommerce/single-product/single-product-section1', 'return-policy' );

}

/**
 * BH_shop_single_experience_banner
 * 
 * Section 2
 * Display experience banner
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_experience_banner() {

	//get_template_part( 'views/woocommerce/single-product/single-product-section2', 'banner' );

}

/**
 * BH_shop_single_related_products
 * 
 * Section 3
 * Display related products
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shop_single_related_products() {

	get_template_part( 'views/woocommerce/single-product/single-product-section3', 'related' );

}

/**
 * BH_EC_product_detail
 * 
 * Enhanced Ecommerce - Measuring a Product Details View
 *
 * @param	N/A
 * @return	N/A
 */
function BH_EC_product_detail() {

	get_template_part( 'views/woocommerce/single-product/ec-product-detail' );

}

/****************************************************************************************************************************************************/
/* WooCommerce cart
/****************************************************************************************************************************************************/

/**
 * BH_shipping_options_disclaimer
 *
 * Add shipping options desclaimer
 *
 * @param	N/A
 * @return	N/A
 */
function BH_shipping_options_disclaimer() {

	echo
		'<tr class="shipping-disclaimer">' .
			'<td colspan="2">' .
				__( '<b>IMPORTANT NOTIFICATION:</b> Due to the Israeli postal office being unable to provide our customers up to date order tracking and delivery within guaranteed time range, until further notice we no longer offer regular shipping. We apologise for any inconvenience to our customers.', 'BH' ) .
			'</td>' .
		'</tr>';

}

/****************************************************************************************************************************************************/
/* WooCommerce checkout
/****************************************************************************************************************************************************/

/**
 * BH_checkout_title
 *
 * Add title in checkout page
 *
 * @param	N/A
 * @return	N/A
 */
function BH_checkout_title() {

	echo '<h2 class="title">' . __( 'Checkout: Please fill your billing address and shipping address', 'BH' ) . '</h2><hr>';

}

/**
 * BH_checkout_order_pay_title
 *
 * Add title in checkout order-pay endpoint
 *
 * @param	N/A
 * @return	N/A
 */
function BH_checkout_order_pay_title() {

	echo '<h2 class="title">' . __( 'Checkout: Please fill your payment details', 'BH' ) . '</h2><hr>';

}

/**
 * BH_checkout_order_received_title
 *
 * Add title in checkout order-received endpoint
 *
 * @param	N/A
 * @return	N/A
 */
function BH_checkout_order_received_title() {

	// return
	return '<h2 class="title">' . __( 'Thank you. Your order has been received', 'BH' ) . '</h2><hr>';

}

/**
 * BH_review_order_before_payment
 *
 * Add title before payment options
 *
 * @param	N/A
 * @return	N/A
 */
function BH_review_order_before_payment() {

	echo '<h3 id="payment_heading">' . __( 'Secured Billing: Please choose your preferred billing method', 'BH' ) . '</h3>';

}

/**
 * BH_change_default_checkout_country
 * 
 * Default checkout country to blank
 *
 * @param	N/A
 * @return	(string)
 */
function BH_change_default_checkout_country() {

	// return
	return '';

}

/**
 * BH_change_default_checkout_state
 * 
 * Default checkout state to blank
 *
 * @param	N/A
 * @return	(string)
 */
function BH_change_default_checkout_state() {

	// return
	return '';

}

/****************************************************************************************************************************************************/
/* WooCommerce orders
/****************************************************************************************************************************************************/

/**
 * BH_shop_order_invoice
 * 
 * Generate an invoice for completed order
 * Use icount API
 *
 * @param	$order_id (int) order ID
 * @return	N/A
 */
function BH_shop_order_invoice( $order_id ) {

	if ( ! function_exists( 'get_field' ) )
		return;

	/**
	 * Variables
	 */
	$order = new WC_Order( $order_id );

	// Get currency code
	$currency				= $order->get_order_currency();
	$currency_code			= '';

	switch ( $currency ) :
		case 'EUR' :		$currency_code = '1';	break;
		case 'USD' :		$currency_code = '2';	break;
		case 'JPY' :		$currency_code = '3';	break;
		case 'GBP' :		$currency_code = '4';	break;
		case 'ILS' :		$currency_code = '5';	break;
		case 'SGD' :		$currency_code = '6';	break;
		case 'CAD' :		$currency_code = '7';	break;
		case 'RUB' :		$currency_code = '8';	break;
		case 'NZD' :		$currency_code = '9';	break;
		case 'AUD' :		$currency_code = '10';	break;
	endswitch;

	// Get current exchange rate
	$wcml_settings			= get_option( '_wcml_settings' );
	$exr					= (float)( 1 / $wcml_settings[ 'currency_options' ][ 'USD' ][ 'rate' ] );
	$exr_str				= ( $exr ) ? sprintf( '%f', $exr ) : '';

	// Get order billing country
	$client_country_code	= get_post_meta( $order_id, '_billing_country', true );
	$countries				= include WC()->plugin_path() . '/i18n/countries.php';
	$client_country			= ( $client_country_code && $countries ) ? $countries[ $client_country_code ] : '';

	// Collect order info
	$compID					= get_field( 'acf-options_icount_company_id',	'option' );
	$user					= get_field( 'acf-options_icount_user',			'option' );
	$pass					= get_field( 'acf-options_icount_password',		'option' );

	$dateissued				= date( 'Ymd', strtotime( $order->order_date ) );
	$ppdateissued			= date( 'Y-m-d', strtotime( $order->order_date ) );

	$clientname				= get_post_meta( $order_id, '_billing_first_name',	true ) . ' ' . get_post_meta( $order_id, '_billing_last_name',	true );
	$client_street			= get_post_meta( $order_id, '_billing_address_1',	true );
	$client_city			= get_post_meta( $order_id, '_billing_city',		true );
	$client_zip				= get_post_meta( $order_id, '_billing_postcode',	true );
	$sendOrig				= get_post_meta( $order_id, '_billing_email',		true );

	$absolutetotalwithvat	= number_format( (float)( $order->get_total() ),													2, '.', '' );
	$totalsum				= ( $currency == 'ILS' ) ? number_format( (float)( $order->get_total() - $order->get_total_tax() ),	2, '.', '' ) : number_format( (float)( $exr * ( $order->get_total() - $order->get_total_tax() ) ),	2, '.', '' );
	$totalvat				= ( $currency == 'ILS' ) ? number_format( (float)( $order->get_total_tax() ),						2, '.', '' ) : number_format( (float)( $exr * ( $order->get_total_tax() ) ),						2, '.', '' );
	$totalwithvat			= ( $currency == 'ILS' ) ? number_format( (float)( $order->get_total() ),							2, '.', '' ) : number_format( (float)( $exr * ( $order->get_total() ) ),							2, '.', '' );
	$totalshipping			= number_format( (float)( $order->get_total_shipping() ),											2, '.', '' );
	$taxexempt				= '1';
	$maampercent			= '18';		// we don't charge for VAT. if we will, we must use a custom field for defining this value

	// Collect order items (including shipping as a separated item)
	$order_items			= $order->get_items();

	$items					= array();
	$desc					= array();	// item name
	$quantity				= array();	// item quantity
	$unitprice				= array();	// item unit price

	if ( $order_items ) {
		foreach ( $order_items as $item ) {
			$desc[]			= $item[ 'name' ];
			$quantity[]		= $item[ 'qty' ];
			$unitprice[]	= $order->get_item_subtotal( $item, false, true );
		}

		// Shipping info
		$desc[]				= $order->get_shipping_method();
		$quantity[]			= '1';
		$unitprice[]		= $totalshipping;
	}

	if ( $desc && $quantity && $unitprice ) {
		for ( $i=0 ; $i<count( $desc ) ; $i++ )
			$items[ 'desc['.$i.']' ]		= $desc[$i];

		for ( $i=0 ; $i<count( $quantity ) ; $i++ )
			$items[ 'quantity['.$i.']']		= $quantity[$i];

		for ( $i=0 ; $i<count( $unitprice ) ; $i++ )
			$items[ 'unitprice['.$i.']']	= $unitprice[$i];
	}

	// Collect payment info
	$payment_method	= get_post_meta( $order_id, '_payment_method', true );
	$payment		= array();

	switch ( $payment_method ) :
		case 'pelecard' :
			$payment[ 'credit' ]			= '1';
			$payment[ 'cc_paymenttype' ]	= '1';
			$payment[ 'cctotal' ]			= $absolutetotalwithvat;
			$payment[ 'ccfirstpayment' ]	= $absolutetotalwithvat;
			$payment[ 'cc_numofpayments' ]	= '1';
			$payment[ 'cc_peraondate' ]		= $dateissued;

			break;
		case 'paypal' :
			$payment[ 'paypal' ]			= '1';
			$payment[ 'pp_sum' ]			= $absolutetotalwithvat;
			$payment[ 'pp_paydate' ]		= $ppdateissued;

			break;
	endswitch;

	$data = array(
		'compID'			=> $compID,
		'user'				=> $user,
		'pass'				=> $pass,
		'dateissued'		=> $dateissued,
		'clientname'		=> $clientname,
		'client_street'		=> $client_street,
		'client_city'		=> $client_city,
		'client_country'	=> $client_country,
		'client_zip'		=> $client_zip,
		'totalsum'			=> $totalsum,
		'totalvat'			=> $totalvat,
		'totalwithvat'		=> $totalwithvat,
		'taxexempt'			=> $taxexempt,
		'maampercent'		=> $maampercent,
		'paid'				=> $totalwithvat,
		'totalpaid'			=> $totalwithvat,
		'docType'			=> 'invrec',
		'currency'			=> $currency_code,
		'rate'				=> $exr_str,
		'sendOrig'			=> $sendOrig,
//		'show_response'		=> '1',
//		'debug'				=> 'yes'
	);

	// Add language indicator
//	if ( $currency != 'ILS' )
		$data[ 'lang' ] = 'en';

	// Add items and payment info into $data
	$data = $data + $items + $payment;

	// Send request
	$url = get_field( 'acf-options_icount_api_url', 'option' );

	$options = array (
		'http' => array (
			'header'	=> "Content-type: application/x-www-form-urlencoded\r\n",
			'method'	=> 'POST',
			'content'	=> http_build_query( $data ),
		)
	);
	$context = stream_context_create( $options );

	$result = file_get_contents( $url, false, $context );

/*	$headers = 'From: nirg@bh.org.il' . "\r\n" .
		'Reply-To: webmaster@example.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	mail( 'nirg@bh.org.il', 'A new invoice for order#' . $order_id, $result, $headers ); */

}

/**
 * BH_shop_order_refund
 * 
 * Enhanced Ecommerce - Measuring Refunds
 *
 * @param	$refund_id (int) refund ID
 * @param	$args (array)
 * @return	N/A
 */
function BH_shop_order_refund( $refund_id, $args ) {

	if ( ! $args || ! function_exists( 'get_field' ) )
		return;

	include( THEME_ROOT . '/includes/UUID.php' );

	/**
	 * Variables
	 */
	$order_id		= $args[ 'order_id' ];
	$refund_amount	= $args[ 'amount' ];
	$line_items		= $args[ 'line_items' ];

	$order			= new WC_Order( $order_id );
	$order_total	= number_format( (float)( $order->get_total() ), 2, '.', '' );
	$order_items	= $order->get_items();

	// Collect Measurement Protocol data
	$url	= 'https://www.google-analytics.com/collect?v=1';
	$data	=
		'&tid=' . get_field( 'acf-options_tracking_code', 'option' ) .
		'&cid=' . UUID::v4() .
		'&t=event' .
		'&ec=' . ( ( $refund_amount == $order_total ) ? 'OrderRefund' : 'OrderPartialRefund' ) .
		'&ea=refund' .
		'&ni=1' .
		'&ti=' . $order_id .
		'&pa=refund';

	if ( $refund_amount != $order_total ) {

		// Order partial refunded
		// Collect items refunded
		$items_refunded = array();

		if ( $line_items ) {
			foreach ( $line_items as $key => $val ) {
				if ( $val['qty'] && $val['qty'] > 0 ) {
					$items_refunded[ $key ]				= array();
					$items_refunded[ $key ][ 'sku' ]	= wc_get_product( $order_items[ $key ][ 'product_id' ] )->sku;
					$items_refunded[ $key ][ 'qty' ]	= $val[ 'qty' ];
				}
			}
		}

		// Add products to $data
		if ( $items_refunded ) {
			$i = 1;
			foreach ( $items_refunded as $item ) {
				$data .=
					'&pr'.$i.'id=' . $item[ 'sku' ] .
					'&pr'.$i.'qt=' . $item[ 'qty' ];
				$i++;
			}
		}

	}

	// Submit Refund event
	BH_background_post( $url . $data );

/*	$headers = 'From: nirg@bh.org.il' . "\r\n" .
		'Reply-To: webmaster@example.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	mail( 'nir@htmline.com', 'A new refund for order#' . $order_id, 'Refund hit: ' . $url . $data, $headers ); */

}

/****************************************************************************************************************************************************/
/* WooCommerce help functions
/****************************************************************************************************************************************************/

/**
 * BH_shop_get_artist_links
 *
 * Generates product artist links seperated by comma
 *
 * @param	$product_id (int) product ID
 * @return	(string)
 */
function BH_shop_get_artist_links( $product_id ) {

	/**
	 * Variables
	 */
	$artists		= wp_get_post_terms( $product_id, 'artist' );
	$artists_html	= '';

	if ( $artists ) {
		$count = 1;
		foreach ( $artists as $artist ) {
			$artists_html .= ( $count++ > 1 ) ? ', ' : '';
			$artists_html .= '<a href="' . get_term_link( $artist ) . '">' . $artist->name . '</a>';
		}
	}

	// return
	return $artists_html;

}

/**
 * BH_shop_price_html
 * 
 * Filter woocommerce_price_html
 *
 * @param	$price (string) HTML representation price
 * @param	$product (object)
 * @return	(string)
 */
function BH_shop_price_html( $price, $product ) {

	/**
	 * Filter product price and currency
	 * Used in case of an AJAX call and active woocommerce wpml
	 */
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && class_exists( 'woocommerce_wpml' ) ) {
		$args = array(
			'currency' => apply_filters( 'wcml_price_currency', get_woocommerce_currency_symbol() ),
		);

		$price = '<span class="amount">' . wc_price( apply_filters( 'wcml_raw_price_amount', $product->get_price() ), $args ) . '</span>';
	}

	// return
	return $price;

}

/**
 * BH_shop_sale_price_html
 * 
 * Filter woocommerce_sale_price_html
 *
 * @param	$price (string) HTML representation price
 * @param	$product (object)
 * @return	(string)
 */
function BH_shop_sale_price_html( $price, $product ) {

	/**
	 * Variables
	 */
	$del = BH_strip_tags_content( $price, '<ins>', true );
	$ins = BH_strip_tags_content( $price, '<del>', true );

	/**
	 * Filter product price and currency
	 * Used in case of an AJAX call and active woocommerce wpml
	 */
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && class_exists( 'woocommerce_wpml' ) ) {
		$args = array(
			'currency' => apply_filters( 'wcml_price_currency', get_woocommerce_currency_symbol() ),
		);

		$del = '<del><span class="amount">' . wc_price( apply_filters( 'wcml_raw_price_amount', $product->get_regular_price() ), $args ) . '</span></del>';
		$ins = '<ins><span class="amount">' . wc_price( apply_filters( 'wcml_raw_price_amount', $product->get_price() ), $args ) . '</span></ins>';
	}

	// return
	return $del . $ins;

}

/**
 * BH_shop_catalog_orderby_options
 * 
 * Reset products catalog ordering options
 *
 * @param	$options (array) catlog order by default options
 * @return	(array)
 */
function BH_shop_catalog_orderby_options( $options ) {

	$options[ 'menu_order' ]	= __( 'Most Popular', 'BH' );
	$options[ 'price' ]			= __( 'Price: Low to High', 'BH' );
	$options[ 'price-desc' ]	= __( 'Price: High to Low', 'BH' );

	if ( isset( $options[ 'popularity' ] ) )
		unset( $options[ 'popularity' ] );

	if ( isset( $options[ 'rating' ] ) )
		unset( $options[ 'rating' ] );

	if ( isset( $options[ 'date' ] ) )
		unset( $options[ 'date' ] );

	// return
	return $options;

}

/**
 * BH_shop_currency_symbol
 *
 * Change default currency symbol for NIS
 *
 * @param	$currency_symbol (string)
 * @param	$currency (string)
 * @return	(string)
 */
function BH_shop_currency_symbol( $currency_symbol, $currency ) {

	$wpml_lang = function_exists('icl_object_id') ? ICL_LANGUAGE_CODE : '';

	if ( 'he' != $wpml_lang ) {

		switch( $currency ) {

			case 'ILS':
				$currency_symbol = 'NIS';
				break;

		}

	}

	// return
	return $currency_symbol;

}

/**
 * BH_shop_currency_position
 *
 * Change default currency position for NIS
 *
 * @param	N/A
 * @return	(string)
 */
function BH_shop_currency_position() {

	$wpml_lang = apply_filters( 'wpml_current_language', NULL );

	if ( 'he' == $wpml_lang ) {
		return 'left_space';
	}
	else {
		return 'right_space';
	}

}

/**
* Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();

	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}

	return ! empty( $free ) ? $free : $rates;
}

add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );