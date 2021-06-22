<?php
/**
 * The Template for displaying pinned buttons
 *
 * @author		Beit Hatfutsot
 * @package		bh/views
 * @since		3.1.11
 * @version		3.1.12
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
if ( ! function_exists( 'get_field' ) )
	return;

$btn				= get_field( 'acf-pinned_buttons_tickets_btn', 'option' );
$whatsapp_number	= get_field( 'acf-pinned_buttons_whatsapp_phone_number', 'option' );

?>

<div class="pinned">

	<?php
		/**
		 * Display the tickets button
		 */
		include( locate_template( 'views/components/anu-tickets-btn.php' ) );
	?>

	<?php
		/**
		 * Display the Whatsapp button
		 */
		include( locate_template( 'views/components/anu-whatsapp-btn.php' ) );
	?>

</div><!-- .pinned -->