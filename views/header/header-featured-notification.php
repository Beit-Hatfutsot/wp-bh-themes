<?php
/**
 * The Template for displaying featured notification link as part of header
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/header
 * @version     2.14.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;

$header_elements		= $globals[ 'header_elements' ];
$featured_notification	= $header_elements[ 'featured_notification' ];

if ( ! $featured_notification || ! $featured_notification[ 'text' ] || ! $featured_notification[ 'link' ] )
	return;

?>

<div class="featured-notification">
	<a href="<?php echo $featured_notification[ 'link' ]; ?>"><?php echo $featured_notification[ 'text' ]; ?></a>
</div>