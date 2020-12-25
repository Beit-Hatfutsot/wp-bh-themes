<?php
/**
 * The Template for displaying the exhibition landing page visit info / map
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) || ! get_field( 'acf-options_google_maps_api_key', 'option' ) )
	return;

?>

<div class="map-wrap">

	<div class="acf-map" data-zoom="17">
		<div class="marker" data-lat="<?php echo esc_attr( $map[ 'lat' ] ); ?>" data-lng="<?php echo esc_attr( $map[ 'lng' ] ); ?>"></div>
	</div>

</div>