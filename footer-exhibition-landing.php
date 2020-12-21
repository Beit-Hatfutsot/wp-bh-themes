<?php
/**
 * Exhibition Landing page template footer
 *
 * @author 		Beit Hatfutsot
 * @package 	bh
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_enqueue_script( 'exhibition-landing' );
wp_enqueue_script( 'cycle2' );
wp_enqueue_script( 'cycle2-carousel' );
wp_enqueue_script( 'cycle2-swipe' );
wp_enqueue_script( 'cycle2-ios6fix' );

wp_footer();

?>

</body>
</html>