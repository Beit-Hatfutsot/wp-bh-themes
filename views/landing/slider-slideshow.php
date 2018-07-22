<?php
/**
 * The Template for displaying a single slider slideshow
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="slideshow-placeholder <?php echo $slider_count == 1 ? 'hidden-xs' : ''; ?>">
	<div class="slideshow">
		<div class="slides"
			data-cycle-slides=".slide"
			data-cycle-fx=carousel
			data-cycle-timeout=5000
			data-cycle-carousel-visible=1
			data-cycle-manual-trump=false
			data-cycle-swipe=true
			data-cycle-log=false
			>

			<?php foreach ( $images as $image ) {

				$img = $image[ 'desktop_image' ];

				echo '<div class="slide"><img src="' . $img[ 'url' ] . '" width="' . $img[ 'width' ] . '" height="' . $img[ 'height' ] . '" alt="' . $img[ 'alt' ] . '" /></div>';

			} ?>

		</div><!-- .slides -->
	</div><!-- .slideshow -->

	<?php
		/**
		 * Display order tickets button
		 */
		include( locate_template( 'views/landing/order-btn.php' ) );
	?>
</div><!-- .slideshow-placeholder -->

<?php

	// Display first slider for mobile
	if ( $slider_count == 1 ) { ?>

		<div class="slideshow-placeholder visible-xs">
			<div class="slideshow">
				<div class="slides"
					data-cycle-slides=".slide"
					data-cycle-fx=carousel
					data-cycle-timeout=5000
					data-cycle-carousel-visible=1
					data-cycle-manual-trump=false
					data-cycle-swipe=true
					data-cycle-log=false
					>

					<?php foreach ( $images as $image ) {

						$img = $image[ 'mobile_image' ];

						echo '<div class="slide"><img src="' . $img[ 'url' ] . '" width="' . $img[ 'width' ] . '" height="' . $img[ 'height' ] . '" alt="' . $img[ 'alt' ] . '" /></div>';

					} ?>

				</div><!-- .slides -->
			</div><!-- .slideshow -->

			<?php
				/**
				 * Display order tickets button
				 */
				include( locate_template( 'views/landing/order-btn.php' ) );
			?>
		</div><!-- .slideshow-placeholder -->

	<?php }

?>