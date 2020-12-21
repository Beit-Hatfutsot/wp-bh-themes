<?php
/**
 * Exhibition Landing page template header
 *
 * @author		Beit Hatfutsot
 * @package		bh
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php
	/**
	 * Display header meta
	 */
	get_template_part( 'views/header/header', 'meta' );
?>

<body <?php body_class(); ?>>

	<?php
		/**
		 * Google Tag Manager
		 */
		get_template_part( 'views/header/scripts/google-tag-manager' );
	?>

	<?php
		/**
		 * Zoom Analytics
		 */
		get_template_part( 'views/header/scripts/zoom-analytics' );
	?>

	<?php
		/**
		 * Display SVG sprite
		 */
		get_template_part( 'views/header/header', 'svg' );
	?>