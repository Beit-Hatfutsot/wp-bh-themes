<?php
/**
 * The Template for displaying ANU tickets button
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

$btn = get_field( 'acf-exhibition_lp_tickets_btn' );

if ( $btn ) {

	$text	= $btn[ 'text' ];
	$link	= $btn[ 'link' ];

}

if ( ! $text || ! $link )
	return;

$data_layer = $gtm_event ? 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"' : '';

?>

<a class="anu-btn tickets-btn" href="<?php echo $link; ?>" target="_blank" <?php echo $data_layer; ?>><?php echo $text; ?></a>