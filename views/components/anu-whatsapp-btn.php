<?php
/**
 * The Template for displaying ANU Whatsapp button
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/components
 * @since		3.1.9
 * @version     3.1.11
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
if ( ! function_exists( 'get_field' ) )
	return;

if ( ! $whatsapp_number ) {

	$whatsapp_number = get_field( 'acf-exhibition_lp_whatsapp_phone_number' );

	if ( ! $whatsapp_number )
		return;

}

?>

<a class="anu-whatsapp" href="https://wa.me/<?php echo $whatsapp_number; ?>" target="_blank">

	<?php
		/**
		 * Display the Whatsapp btn
		 */
		get_template_part( 'views/svgs/shape', 'anu-whatsapp' );
	?>

</a>