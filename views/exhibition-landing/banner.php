<?php
/**
 * The Template for displaying the exhibition landing page banner
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

// vars
$slides	= get_field( 'acf-exhibition_lp_banner_slides' );

if ( ! $slides )
	return;

?>

<section class="banner">

	<div class="slideshow-placeholder hidden-xs">
		<div class="slideshow">
			<div class="cycle-slideshow"
				data-cycle-slides=".slide"
				data-cycle-fx=carousel
				data-cycle-timeout=0
				data-cycle-carousel-visible=1
				data-cycle-auto-height=false
				data-cycle-manual-trump=false
				data-cycle-swipe=true
				data-cycle-pager="#cycle-pager-desktop"
				data-cycle-pager-template="<span></span>"
				data-cycle-log=false
				>

				<?php foreach ( $slides as $slide ) {

					$img			= $slide[ 'desktop_image' ];
					$description	= $slide[ 'description' ];

					echo
						'<div class="slide">' .
							'<img src="' . $img[ 'url' ] . '" width="' . $img[ 'width' ] . '" height="' . $img[ 'height' ] . '" alt="' . $img[ 'alt' ] . '" />' .
							'<div class="description">' . $description . '</div>' .
						'</div>';

				} ?>

				<div id="cycle-pager-desktop" class="cycle-pager"></div>
			</div><!-- .cycle-slideshow -->
		</div><!-- .slideshow -->
	</div><!-- .slideshow-placeholder -->

	<div class="slideshow-placeholder visible-xs">
		<div class="slideshow">
			<div class="cycle-slideshow"
				data-cycle-slides=".slide"
				data-cycle-fx=carousel
				data-cycle-timeout=0
				data-cycle-carousel-visible=1
				data-cycle-auto-height=false
				data-cycle-manual-trump=false
				data-cycle-swipe=true
				data-cycle-pager="#cycle-pager-mobile"
				data-cycle-pager-template="<span></span>"
				data-cycle-log=false
				>

				<?php foreach ( $slides as $slide ) {

					$img			= $slide[ 'mobile_image' ];
					$description	= $slide[ 'description' ];

					echo
						'<div class="slide">' .
							'<div style="background: url(\'' . $img[ 'url' ] . '\') 50% 0 no-repeat;"></div>' .
							'<div class="description">' . $description . '</div>' .
						'</div>';

				} ?>

				<div id="cycle-pager-mobile" class="cycle-pager"></div>
			</div><!-- .cycle-slideshow -->
		</div><!-- .slideshow -->
	</div><!-- .slideshow-placeholder -->

	<?php
		/**
		 * Display banner overlay content
		 */
		include( locate_template( 'views/exhibition-landing/banner-content.php' ) );
	?>

</section><!-- .banner -->