<?php
/**
 * The Template for displaying the exhibition landing page header menu
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

$museum_menu_item = get_field( 'acf-exhibition_lp_museum_menu_item' );

?>

<ul class="menu">

	<li class="tickets-btn">

		<?php
			/**
			 * Display the tickets button
			 */
			get_template_part( 'views/components/anu-tickets-btn' );
		?>

	</li>

	<?php

		foreach ( $menu_items as $item ) {
			if ( $item[ 'label' ] ) {
				echo '<li class="anchor"><a href="#' . $item[ 'id' ] . '">' . $item[ 'label' ] . '</a></li>';
			}
		}

		if ( $museum_menu_item ) {

			$text	= $museum_menu_item[ 'text' ];
			$link	= $museum_menu_item[ 'link' ];

			echo '<li><a href="' . $link . '" target="_blank">' . $text . '</a></li>';

		}

	?>

</ul>