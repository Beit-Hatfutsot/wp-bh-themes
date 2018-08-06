<?php
/**
 * The Template for displaying page banners (shop style)
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/page/content
 * @since		2.9.0
 * @version		2.9.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
$banner_index	= 1;

if ( ! $banners )
	return;

?>

<div class="shop-banners-wrapper page-banners visible-lg visible-md">
	<div class="shop-banners">

		<?php foreach ( $banners as $banner ) {

			$image	= $banner[ 'image' ];
			$link	= $banner[ 'link' ];
			$target	= $banner[ 'target' ];

			if ( $image ) {

				echo '<div class="shop-banner shop-banner-' . $banner_index . '">';
					echo ( $link ) ? '<a href="' . $link . '" target="_' . $target . '">' : '';
						echo '<img src="' . $image[ 'url' ] . '" alt="' . $image[ 'alt' ] . '" />';
					echo ( $link ) ? '</a>' : '';
				echo '</div>';

			}

			$banner_index++;

		} ?>

	</div><!-- .shop-banners -->
</div><!-- .shop-banners-wrapper -->