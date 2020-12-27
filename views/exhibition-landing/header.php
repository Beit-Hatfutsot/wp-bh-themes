<?php
/**
 * The Template for displaying the exhibition landing page header
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="menu-hamburger visible-xs">

	<?php
		/**
		 * Display the mobile menu hamburger
		 */
		get_template_part( 'views/svgs/shape', 'anu-menu-hamburger' );
	?>

</div>

<header>

	<?php
		/**
		 * Display the logo
		 */
		get_template_part( 'views/components/anu-logo' );
	?>

	<?php
		/**
		 * Display the header menu
		 */
		include( locate_template( 'views/exhibition-landing/header-menu.php' ) );
	?>

</header>

<div class="hidden-xs">

	<?php
		/**
		 * Display the language switcher
		 */
		include( locate_template( 'views/exhibition-landing/header-language-switcher.php' ) );
	?>

</div>

<div class="mobile-menu-wrap visible-xs">

	<div class="menu-close">

		<?php
			/**
			 * Display the mobile menu close btn
			 */
			get_template_part( 'views/svgs/shape', 'anu-menu-close' );
		?>

	</div>

	<div class="mobile-menu">

		<?php
			/**
			 * Display the header menu
			 */
			include( locate_template( 'views/exhibition-landing/header-menu.php' ) );
		?>

		<?php
			/**
			 * Display the language switcher
			 */
			include( locate_template( 'views/exhibition-landing/header-language-switcher.php' ) );
		?>

	</div>

	<div class="landscape-default">

		<?php _e( 'Please rotate your device!', 'BH' ); ?>

	</div>

</div>