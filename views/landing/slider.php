<?php
/**
 * The Template for displaying a single landing page slider
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="slider">

	<?php
		/**
		 * Display the slider slideshow
		 */
		include( locate_template( 'views/landing/slider-slideshow.php' ) );
	?>

	<?php
		/**
		 * Display the slider content
		 */
		include( locate_template( 'views/landing/slider-content.php' ) );
	?>

</div><!-- .slider -->