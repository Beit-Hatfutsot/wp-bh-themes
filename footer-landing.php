<?php
/**
 * Landing page template footer
 *
 * @author 		Beit Hatfutsot
 * @package 	bh
 * @since		2.8.0
 * @version		2.13.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Globals
global $globals;

wp_enqueue_script( 'landing' );
wp_enqueue_script( 'ticketnet' );
wp_enqueue_script( 'cycle2' );
wp_enqueue_script( 'cycle2-carousel' );
wp_enqueue_script( 'cycle2-swipe' );
wp_enqueue_script( 'cycle2-ios6fix' );

wp_footer();

if ( function_exists( 'get_field' ) && $footer_scripts = get_field( 'acf-landing_footer_scripts' ) ) {
	echo $footer_scripts;
}

?>

</body>
</html>