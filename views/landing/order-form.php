<?php
/**
 * The Template for displaying order tickets form
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.13.0
 * @version		2.13.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( $order_target != 'form' || ! $order_form )
	return;

?>

<?php echo $order_form; ?>