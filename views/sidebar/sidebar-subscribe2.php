<?php
/**
 * The Template for displaying the Subscribe2 subscription form
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/sidebar
 * @since		2.11.0
 * @version		2.11.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<h3><?php _e( 'Subscribe to Blog notifications', 'BH' ); ?></h3>

<div class="subscribe2-form">

	<?php echo do_shortcode( '[subscribe2]' ); ?>

</div><!-- .subscribe2-form -->