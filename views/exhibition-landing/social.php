<?php
/**
 * The Template for displaying the exhibition landing page social
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
$title		= get_field( 'acf-exhibition_lp_social_title' );
$links		= get_field( 'acf-exhibition_lp_social_links' );

if ( ! $links && ! $phone )
	return;

?>

<section class="social">



</section><!-- .social -->