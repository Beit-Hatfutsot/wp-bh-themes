<?php
/**
 * The Template for displaying the exhibition landing page pinned buttons
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0.1
 * @version		3.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="pinned">

	<?php
		/**
		 * Display the tickets button
		 */
		get_template_part( 'views/components/anu-tickets-btn' );
	?>

	<?php
		/**
		 * Display the scroll top button
		 */
		get_template_part( 'views/components/anu-scroll-top-btn' );
	?>

</div><!-- .pinned -->