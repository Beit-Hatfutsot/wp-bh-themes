<?php
/**
 * The Template for displaying the landing page header
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<header>

	<?php
		/**
		 * Display the logo
		 */
		get_template_part( 'views/components/logo' );
	?>

	<?php
		/**
		 * Display the title
		 */
		include( locate_template( 'views/landing/header-title.php' ) );
	?>

</header>