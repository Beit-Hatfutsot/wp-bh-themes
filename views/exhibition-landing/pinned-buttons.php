<?php
/**
 * The Template for displaying the exhibition landing page pinned buttons
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0.1
 * @version		3.1.9
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="pinned">

	<?php
		/**
		 * Display the tickets button
		 */
		$gtm_event = 'sticky_anu-ticket-btn_click';
		include( locate_template( 'views/components/anu-tickets-btn.php' ) );
	?>

	<?php
		/**
		 * Display the scroll top button
		 */
		get_template_part( 'views/components/anu-scroll-top-btn' );
	?>

	<?php
		/**
		 * Display the Whatsapp button
		 */
		get_template_part( 'views/components/anu-whatsapp-btn' );
	?>

</div><!-- .pinned -->