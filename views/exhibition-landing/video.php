<?php
/**
 * The Template for displaying the exhibition landing page video
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
$videos		= get_field( 'acf-exhibition_lp_video_videos' );

if ( ! $videos )
	return;

?>

<section class="video">



</section><!-- .video -->