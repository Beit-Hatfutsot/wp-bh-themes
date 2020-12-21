<?php
/**
 * The Template for displaying the exhibition landing page visit info
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
$title			= get_field( 'acf-exhibition_lp_visit_info_title' );
$opening_hours	= get_field( 'acf-exhibition_lp_visit_info_opening_hours' );
$cost			= get_field( 'acf-exhibition_lp_visit_info_cost' );
$address		= get_field( 'acf-exhibition_lp_visit_info_address' );
$map			= get_field( 'acf-exhibition_lp_visit_info_map' );

if ( ! $opening_hours || ! $cost || ! $address || ! $map )
	return;

?>

<section class="visit-info">



</section><!-- .visit-info -->