<?php
/**
 * Template Name: Landing Thank You Page
 */?>
<?php get_header( 'landing' ); ?>

<div class="landing-wrapper">

<?php

// Get page content
if ( function_exists( 'get_field' ) ) {

	$thank_you_text	= get_field( 'acf-landing_thank_you_text' );
	$footer_bg		= get_field( 'acf-options_landing_footer_background', 'option' );

}

?>

<?php
	/**
	 * Display the header
	 */
	include( locate_template( 'views/landing/header.php' ) );
?>

<?php
	/**
	 * Display thank you text
	 */
	include( locate_template( 'views/landing/thank-you-text.php' ) );
?>

<?php
	/**
	 * Display the footer
	 */
	include( locate_template( 'views/landing/footer.php' ) );
?>

</div><!-- .landing-wrapper -->

<?php get_footer( 'landing' ); ?>