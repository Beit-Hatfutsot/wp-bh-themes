<?php
/**
 * Main - Slider event elements builder
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/main/slider
 * @version     2.7.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;
global $categories, $is_categories_empty, $is_events_empty;

/**
 * Set $categories - array of categories term_id
 *
 * This array will hold arrays of event DOM elements related to each category
 * Used for two purposes:
 * 1. Display categories filter - display only categories which include at least one future event
 * 2. Filter events based on a JSON encoded information
 */
$args = array(
	'taxonomy'	=> 'event_category',
	'orderby'	=> 'term_order'
);
$category_terms = get_terms( $args );

$categories = array();
$is_categories_empty	= true;	// indicates there is no category includes at least 1 future event
$is_events_empty		= true;	// indicates there is no events to show

// Set $categories[0] for all events
$categories[0] = array();

if ( $category_terms ) {

	foreach ( $category_terms as $category_term ) {
		// Set empty array to each category as default
		$categories[ $category_term->term_id ] = array();
	}

}

// Check if ACF exists
if ( ! function_exists( 'get_field' ) )
	// return
	return;

// Fill in $categories array
foreach ( $globals[ 'events' ] as $e ) {

	if ( $e[ 'type' ] == 'event' ) {

		// event
		$event = $e[ 'event' ];

		$image = get_field( 'acf-event_slider_image', $event->ID );

		if ( $image ) {

			$event_categories	= wp_get_post_terms( $event->ID, 'event_category' );
			$singular_name		= ( $event_categories ) ? get_field( 'acf-event_category_singular_name', 'event_category_' . $event_categories[0]->term_id ) : '';
			$description		= get_field( 'acf-event_description',		$event->ID );
			$series				= get_field( 'acf-event_series_of_events',	$event->ID );

			$event_element =
				"<div class='event-item event-item-" . $event->ID . "' style='display: none;'>" .
					"<a href='" . get_permalink( $event->ID ) . "'>" .
						"<img src='" . $image[ 'sizes' ][ 'thumbnail' ] . "' alt='" . ( ( $image[ 'alt' ] ) ? $image[ 'alt' ] : '' ) . "' />" .
						"<div class='event-meta'>" .
							
							// Event type
							BH_get_event_type( $event->ID ) .
							
							// Event date
							BH_get_event_date( $event->ID ) .
							
							// Event title and description
							"<h3>" . get_the_title( $event->ID ) . "</h3>" .

						"</div>" .
					"</a>" .
				"</div>";

			// Include event as part of "all events" array
			$categories[0][] = $event_element;

			// include event as part of its categories arrays
			if ( $event_categories ) {

				foreach ( $event_categories as $event_category ) {
					$categories[ $event_category->term_id ][] = $event_element;
				}

				$is_categories_empty = false;	// at least 1 category includes at least 1 future event

			}

			$is_events_empty = false;	// at least 1 event to show

		}

	}
	else {

		// custom
		$event_element =
			"<div class='event-item custom-event-item' style='display: none;'>" .
				"<a href='" . $e[ 'event' ][ 'link' ] . "' " . ( $e[ 'event' ][ 'target' ] == 'blank' ? "target='_blank'" : "" ) . ">" .
					"<img src='" . $e[ 'event' ][ 'image' ][ 'sizes' ][ 'thumbnail' ] . "' alt='" . ( ( $e[ 'event' ][ 'image' ][ 'alt' ] ) ? $e[ 'event' ][ 'image' ][ 'alt' ] : '' ) . "' />" .
					"<div class='event-meta'>" .

						// Event sub title
						"<div class='event-type'>" . $e[ 'event' ][ 'sub_title' ] . "</div>" .

						// Event date
						"<div class='event-date'>" . $e[ 'event' ][ 'date' ] . "</div>" .

						// Event title
						"<h3>" . $e[ 'event' ][ 'title' ] . "</h3>" .
					"</div>" .
				"</a>" .
			"</div>";

		// Include event as part of "all events" array
		$categories[0][] = $event_element;

		$is_events_empty = false;	// at least 1 event to show

	}

}