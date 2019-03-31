<?php
/**
 * The Template for displaying order tickets button
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.13.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php if ( $order_target == 'link' ) : ?>

	<a class="btn event-ticket-net-link" onclick="BH_tickets.ticketnet_purchase_link('<?php echo $order_link; ?>')"><?php echo $order_text; ?></a>

<?php elseif ( $order_target == 'form' ) : ?>

	<a class="btn event-form"><?php echo $order_text; ?></a>

<?php endif; ?>