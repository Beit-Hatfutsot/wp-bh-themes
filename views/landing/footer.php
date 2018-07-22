<?php
/**
 * The Template for displaying the landing page footer
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<footer>

	<div class="footer-wrapper" <?php echo $footer_bg ? 'style="background-image: url(\'' . $footer_bg[ 'url' ] . '\');"' : ''; ?>>

		<?php
			/**
			 * Display order tickets button
			 */
			include( locate_template( 'views/landing/order-btn.php' ) );
		?>

	</div>

</footer>