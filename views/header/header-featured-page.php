<?php
/**
 * The Template for displaying featured page link as part of header
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/header
 * @since		2.6.0
 * @version     3.2.0
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
$featured_page		= $header_elements[ 'featured_page' ];

if ( ! $featured_page )
	return;

$current_object_id = get_queried_object_id();

?>

<div class="featured-page">
	<a href="<?php echo get_permalink( $featured_page->ID ); ?>" data-title="<?php echo $featured_page->post_title; ?>" <?php echo $featured_page->ID == $current_object_id ? 'class="active"' : ''; ?>><?php echo $featured_page->post_title; ?></a>
</div>