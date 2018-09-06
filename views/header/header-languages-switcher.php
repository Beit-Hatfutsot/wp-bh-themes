<?php
/**
 * Header languages switcher
 *
 * Display header languages switcher as part of header elements
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/header
 * @since		2.6.0
 * @version		2.10.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

/**
 * Variables
 */
$switcher_type	= get_field( 'acf-options_switcher_type', 'option' );

?>

<div class="header-element languages-switcher languages-switcher-<?php echo $switcher_type; ?>">

	<?php
		/**
		 * Display the current langauge flag as the switcher button
		 */
		if ( $switcher_type == 'menu' ) {
			get_template_part( 'views/wpml/wpml', 'current-language' );
		}
	?>

	<div class="languages-switcher-content">

		<?php
			/**
			 * Display the WPML languages switcher
			 */
			include( locate_template( 'views/wpml/wpml-languages-switcher.php' ) );
		?>

		<?php
			/**
			 * Display specific translated pages
			 */
			if ( $switcher_type == 'menu' ) {
				get_template_part( 'views/wpml/wpml', 'untranslated-languages-switcher' );
			}
		?>

	</div>

</div>