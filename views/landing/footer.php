<?php
/**
 * The Template for displaying the landing page footer
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.13.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<footer>

	<div class="footer-wrapper" <?php echo $footer_bg ? 'style="background-image: url(\'' . $footer_bg[ 'url' ] . '\');"' : ''; ?>>

		<?php if ( $order_target == 'link' && $order_link ) : ?>

			<?php
				/**
				 * Display order tickets button
				 */
				include( locate_template( 'views/landing/order-btn.php' ) );
			?>

		<?php elseif ( $order_target == 'form' && $order_form ) : ?>

			<?php
				/**
				 * Display order tickets form
				 */
				include( locate_template( 'views/landing/order-form.php' ) );
			?>

		<?php endif; ?>

	</div>

</footer>