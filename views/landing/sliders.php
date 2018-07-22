<?php
/**
 * The Template for displaying the landing page sliders
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
$slider_count = 1;

foreach ( $sliders as $slider ) {

	// Get slider content
	$images		= $slider[ 'images' ];
	$title		= $slider[ 'title' ];
	$excerpt	= $slider[ 'excerpt' ];
	$more_info	= $slider[ 'more_info' ];

	if ( ! $images || ! $title || ! $excerpt )
		return;

	/**
	 * Display the slider
	 */
	include( locate_template( 'views/landing/slider.php' ) );

	$slider_count++;

}