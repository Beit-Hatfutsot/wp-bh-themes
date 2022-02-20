<?php
/**
 * Single Product return policy info
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/woocommerce/single-product
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
    return;

$return_policy = get_field( 'acf-options_product_return_policy', 'option' );

if ( ! $return_policy )
    return;

?>

<div class="single-product-meta-return-policy product-meta-section">

	<?php // title ?>
	<div class="product-meta-section-title"><?php _e('Return Policy', 'BH'); ?></div>

	<?php // content ?>
	<div class="return-policy-info"><?php echo $return_policy; ?></div>

</div>