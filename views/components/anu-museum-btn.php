<?php
/**
 * The Template for displaying ANU museum button
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/components
 * @since		3.0
 * @version     3.1.4
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

$data_layer = $gtm_event ? 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"' : '';

?>

<a class="anu-btn museum-btn anchor" href="#section-visit-info" target="_blank" <?php echo $data_layer; ?>><?php echo $text; ?></a>