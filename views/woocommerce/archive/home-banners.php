<?php
/**
 * The Template for displaying shop homepage banners
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/woocommerce/archive
 * @version     3.1.18
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$banners = get_field( 'acf-options-shop_banners', 'option' );

if ( ! $banners )
	return;

?>

<div class="simple-shop-banners-wrapper">
	<div class="slideshow-placeholder">
		<div class="slideshow">
			<div class="cycle-slideshow"
				data-cycle-slides=".slide"
				data-cycle-fx=carousel
				data-cycle-timeout=0
				data-cycle-carousel-visible=1
				data-cycle-auto-height=false
				data-cycle-manual-trump=false
				data-cycle-swipe=true
				data-cycle-log=false
				>

				<?php foreach ( $banners as $banner ) :

					$image					= $banner['image'];
					$link_type				= $banner['link_type'];
					$page_product_link		= $banner['page_product_link'];
					$product_category_link	= $banner['product_category_link'];
					$product_occasion_link	= $banner['product_occasion_link'];
					$product_artist_link	= $banner['product_artist_link'];
					$ext_link				= $banner['external_link'];
					$link					= '';
					$target					= '_self';

					switch ( $link_type ) :

						case 'no' :																								break;
						case 'page' :		$link = $page_product_link		? get_permalink($page_product_link->ID)	: '';		break;
						case 'category' :	$link = $product_category_link	? get_term_link($product_category_link)	: '';		break;
						case 'occasion' :	$link = $product_occasion_link	? get_term_link($product_occasion_link)	: '';		break;
						case 'artist' :		$link = $product_artist_link	? get_term_link($product_artist_link)	: '';		break;
						case 'ext' :		$link = $ext_link				? $ext_link								: '';		$target = '_blank';

					endswitch;

					if ( $image ) :

						echo '<div class="slide">';
							echo ($link) ? '<a href="' . $link . '" target="' . $target . '">' : '';
								echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';
							echo ($link) ? '</a>' : '';
						echo '</div>';

					endif;

				endforeach; ?>

			</div><!-- .cycle-slideshow -->
		</div><!-- .slideshow -->
	</div><!-- .slideshow-placeholder -->
</div><!-- .simple-shop-banners-wrapper -->