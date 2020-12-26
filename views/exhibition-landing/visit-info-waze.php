<?php
/**
 * The Template for displaying the exhibition landing page visit info / waze
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="waze-wrap visible-xs">

	<a href="https://www.waze.com/ul?ll=<?php echo $map[ 'lat' ]; ?>%2C<?php echo $map[ 'lng' ]; ?>&navigate=yes" target="_blank">

		<span><?php _e( 'Navigate with', 'BH' ); ?></span>

		<?php
			/**
			 * Display the Waze icon
			 */
			get_template_part( 'views/svgs/shape', 'anu-waze' );
		?>

	</a>

</div>