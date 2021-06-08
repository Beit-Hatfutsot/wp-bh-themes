<?php
/**
 * The Template for displaying pinned buttons
 *
 * @author		Beit Hatfutsot
 * @package		bh/views
 * @since		3.1.11
 * @version		3.1.11
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
if ( ! function_exists( 'get_field' ) )
	return;

$whatsapp_number = get_field( 'acf-pinned_buttons_whatsapp_phone_number', 'option' );

if ( ! $whatsapp_number )
	return;

?>

<div class="pinned">

	<?php
		/**
		 * Display the Whatsapp button
		 */
		include( locate_template( 'views/components/anu-whatsapp-btn.php' ) );
	?>

</div><!-- .pinned -->