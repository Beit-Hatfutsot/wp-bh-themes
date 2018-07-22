<?php
/**
 * Template Name: Landing Page
 */?>
<?php get_header( 'landing' ); ?>

<div class="landing-wrapper">

<?php

// Get page content
if ( function_exists( 'get_field' ) ) {

	$sliders		= get_field( 'acf-options_landing_sliders', 'option' );
	$page_title		= get_field( 'acf-options_landing_title', 'option' );
	$footer_bg		= get_field( 'acf-options_landing_footer_background', 'option' );
	$order_text		= get_field( 'acf-options_landing_order_tickets_text', 'option' );
	$order_link		= get_field( 'acf-landing_order_tickets_link' );

}

if ( ! $sliders || ! $page_title || ! $order_text || ! $order_link )
	return;

?>

<?php
	/**
	 * Display the header
	 */
	include( locate_template( 'views/landing/header.php' ) );
?>

<?php
	/**
	 * Display the sliders
	 */
	include( locate_template( 'views/landing/sliders.php' ) );
?>

<?php
	/**
	 * Display the footer
	 */
	include( locate_template( 'views/landing/footer.php' ) );
?>

</div><!-- .landing-wrapper -->

<?php get_footer( 'landing' ); ?>