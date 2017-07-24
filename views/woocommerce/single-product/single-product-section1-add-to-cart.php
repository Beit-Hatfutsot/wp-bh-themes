<?php
/**
 * Single Product Add to Cart
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/woocommerce/single-product
 * @version     2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

// Enhanced Ecommerce - "add to cart" event tracking
// collect product info and submit it on form submission
$p_id		= $product->get_id();
$p_sku		= esc_js( $product->get_sku() );
$p_name		= esc_js( $product->get_title() );
$p_price	= number_format((float)$product->get_price(), 2, '.', '');
$p_currency	= get_woocommerce_currency();

$category = '';
$product_cats = wp_get_post_terms($p_id, 'product_cat');
if ( $product_cats && ! is_wp_error ($product_cats) ) {
	$single_cat	= array_shift($product_cats);
	$category	= esc_js( $single_cat->name );
}

?>

<div id="single-product-add-to-cart" class="product-meta-section clearfix">

	<div id="qty-select" data-content="1">
		<span><?php _e('QTY', 'BH'); ?></span>
		<ul>
			<?php for ($i=1 ; $i<=10 ; $i++) { ?>
				<li <?php echo $i==1 ? 'class="current"' : ''; ?>><?php echo $i; ?></li>
			<?php } ?>
		</ul>
	</div>

	<div class="add-to-cart">
		<?php
			echo sprintf( '<a href="#" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s ajax_add_to_cart" onclick="BH_EC_onUpdateCart(\'' . $p_sku . '\', \'' . $p_name . '\', \'' . $category . '\', \'' . $p_price . '\', \'' . $p_currency . '\', this.getAttribute(\'data-quantity\'), \'add\'); BH_FB_onAddToCart(\'' . $p_sku . '\', \'' . $p_name . '\', \'' . $category . '\', \'' . $p_price . '\', \'' . $p_currency . '\'); return true;">%s</a>',
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				esc_attr( $product->get_type() ),
				__('Add to cart', 'BH')
			);
		?>
	</div>

</div>