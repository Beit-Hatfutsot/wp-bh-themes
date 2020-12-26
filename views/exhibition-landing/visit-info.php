<?php
/**
 * The Template for displaying the exhibition landing page visit info
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
$title			= get_field( 'acf-exhibition_lp_visit_info_title' );
$opening_hours	= get_field( 'acf-exhibition_lp_visit_info_opening_hours' );
$cost			= get_field( 'acf-exhibition_lp_visit_info_cost' );
$address		= get_field( 'acf-exhibition_lp_visit_info_address' );
$map			= get_field( 'acf-exhibition_lp_visit_info_map' );

if ( ! $opening_hours || ! $cost || ! $address || ! $map )
	return;

?>

<section class="visit-info">

	<div class="btn-wrap">

		<?php
			/**
			 * Display the tickets button
			 */
			get_template_part( 'views/components/anu-tickets-btn' );
		?>

	</div>

	<a id="section-visit-info"></a>

	<?php if ( $title ) { ?>

		<h3><?php echo $title; ?></h3>

	<?php } ?>

	<div class="row">
		<div class="col">

			<?php
				/**
				 * Display the opening hours
				 */
				include( locate_template( 'views/exhibition-landing/visit-info-opening-hours.php' ) );
			?>

		</div>

		<div class="col">

			<?php
				/**
				 * Display the cost
				 */
				include( locate_template( 'views/exhibition-landing/visit-info-cost.php' ) );
			?>

		</div>
	</div>

	<div class="row">
		<div class="col">

			<?php
				/**
				 * Display the address
				 */
				include( locate_template( 'views/exhibition-landing/visit-info-address.php' ) );
			?>

		</div>

		<div class="col">

			<?php
				/**
				 * Display the map
				 */
				include( locate_template( 'views/exhibition-landing/visit-info-map.php' ) );
			?>

		</div>
	</div>

	<?php
		/**
		 * Display Waze link
		 */
		include( locate_template( 'views/exhibition-landing/visit-info-waze.php' ) );
	?>

</section><!-- .visit-info -->