<?php
/**
 * WPML languages switcher button
 *
 * Display the drop down menu switcher button
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/wpml
 * @since		2.6.0
 * @version		2.14.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="languages-switcher-btn">

	<a>

		<?php
			/**
			 * Display the drop down menu switcher button
			 */
			get_template_part( 'views/svgs/shape', 'languages' );
		?>

	</a>

</div>

<div class="languages-switcher-btn hidden">

	<a>

		<?php
			/**
			 * Display the drop down menu switcher button hover state
			 */
			get_template_part( 'views/svgs/shape', 'languages-hover' );
		?>

	</a>

</div>