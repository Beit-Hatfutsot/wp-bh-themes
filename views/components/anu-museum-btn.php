<?php
/**
 * The Template for displaying ANU museum button
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/components
 * @since		3.0
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
if ( ! function_exists( 'get_field' ) )
	return;

$btn = get_field( 'acf-exhibition_lp_museum_btn' );

if ( $btn ) {

	$text	= $btn[ 'text' ];

}

if ( ! $text )
	return;

?>

<a class="anu-btn museum-btn anchor" href="#section-visit-info" target="_blank"><?php echo $text; ?></a>