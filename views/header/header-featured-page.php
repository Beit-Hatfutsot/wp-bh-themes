<?php
/**
 * The Template for displaying featured page link as part of header
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/header
 * @since		2.6.0
 * @version     3.2.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;

// hide featured page for shop pages
if ( 'shop' == $globals[ 'bh_sites' ][ $globals[ 'current_site' ] ][ 'type' ] )
    return;

$header_elements	= $globals[ 'header_elements' ];
$featured_link		= $header_elements[ 'featured_link' ];

if ( ! $featured_link )
	return;

$current_object_id = get_queried_object_id();

?>

<div class="featured-page">
	<a href="<?php echo $featured_link[ 'url' ]; ?>" target="<?php echo $featured_link[ 'target' ]; ?>" data-title="<?php echo $featured_link[ 'title' ]; ?>"><?php echo $featured_link[ 'title' ]; ?></a>
</div>