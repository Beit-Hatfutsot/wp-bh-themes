<?php
/**
 * The Template for displaying the exhibition landing page header menu
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.1.9
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

// vars
$menu_items = array(
	array(
		'id'		=> 'section-introduction',
		'label'		=> get_field( 'acf-exhibition_lp_introduction_menu_title' ),
	),
	array(
		'id'		=> 'section-video',
		'label'		=> get_field( 'acf-exhibition_lp_video_menu_title' ),
	),
	array(
		'id'		=> 'section-visit-info',
		'label'		=> get_field( 'acf-exhibition_lp_visit_info_menu_title' ),
	),
);

$museum_menu_item	= get_field( 'acf-exhibition_lp_museum_menu_item' );
$museum_btn			= get_field( 'acf-exhibition_lp_museum_btn' );

?>

<ul class="menu">

	<li class="tickets-btn">

		<?php
			/**
			 * Display the tickets button
			 */
			$gtm_event = 'header-menu_anu-ticket-btn_click';
			include( locate_template( 'views/components/anu-tickets-btn.php' ) );
		?>

	</li>

	<?php

		foreach ( $menu_items as $item ) {
			if ( $item[ 'label' ] ) {

				$gtm_event	= 'header-menu_' . $item[ 'id' ] . '_click';
				$data_layer	= 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"';

				echo '<li class="anchor"><a href="#' . $item[ 'id' ] . '" ' . $data_layer . '>' . $item[ 'label' ] . '</a></li>';

			}
		}

		if ( $museum_menu_item ) {

			$text		= $museum_menu_item[ 'text' ];
			$link		= $museum_menu_item[ 'link' ];
			$gtm_event	= 'header-menu_museum-menu-item-1_click';
			$data_layer	= 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"';

			echo '<li><a href="' . $link . '" target="_blank" ' . $data_layer . '>' . $text . '</a></li>';

		}

		if ( $museum_btn ) {

			$text		= $museum_btn[ 'text' ];
			$link		= $museum_btn[ 'link' ];

			if ( $link ) {

				$gtm_event	= 'header-menu_museum-menu-item-2_click';
				$data_layer	= 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"';

				echo '<li><a href="' . $link . '" target="_blank" ' . $data_layer . '>' . $text . '</a></li>';

			}

		}

	?>

</ul>