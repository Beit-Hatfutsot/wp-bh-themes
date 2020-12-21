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

if ( ! function_exists( 'get_field' ) )
	return;

// vars
$intro_menu_title	= get_field( 'acf-exhibition_lp_introduction_menu_title' );
$video_menu_title	= get_field( 'acf-exhibition_lp_video_menu_title' );
$vinfo_menu_title	= get_field( 'acf-exhibition_lp_visit_info_menu_title' );

?>

<header>

	<?php
		/**
		 * Display the logo
		 */
		get_template_part( 'views/components/logo' );
	?>

</header>