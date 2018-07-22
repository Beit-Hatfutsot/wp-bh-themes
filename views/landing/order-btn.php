<?php
/**
 * The Template for displaying order tickets button
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $order_text || ! $order_link )
	return;

?>

<a class="btn event-ticket-net-link" onclick="BH_tickets.ticketnet_purchase_link('<?php echo $order_link; ?>')"><?php echo $order_text; ?></a>