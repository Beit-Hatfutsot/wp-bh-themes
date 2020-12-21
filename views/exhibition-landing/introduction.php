<?php
/**
 * The Template for displaying the exhibition landing page introduction
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
$main_title		= get_field( 'acf-exhibition_lp_introduction_main_title' );
$sub_title		= get_field( 'acf-exhibition_lp_introduction_sub_title' );
$content		= get_field( 'acf-exhibition_lp_introduction_content' );
$image			= get_field( 'acf-exhibition_lp_introduction_image' );

if ( ! $main_title && ! $sub_title && ! $content )
	return;

?>

<section class="introduction">



</section><!-- .introduction -->