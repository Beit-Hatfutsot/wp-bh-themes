<?php
/**
 * The Template for displaying ANU tickets button
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/components
 * @since		3.0
 * @version     3.1.12
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
if ( ! function_exists( 'get_field' ) )
	return;

if ( ! $btn ) {

	$btn		= get_field( 'acf-exhibition_lp_tickets_btn' );

	if ( ! $btn )
		return;

}

$text		= $btn[ 'text' ];
$link		= $btn[ 'link' ];
$data_layer	= $gtm_event ? 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"' : '';

if ( ! $text || ! $link )
	return;

?>

<a class="anu-btn tickets-btn" href="<?php echo $link; ?>" target="_blank" <?php echo $data_layer; ?>><?php echo $text; ?></a>

    <?php

        /**
         * Display the scroll top button
         */

        // adding scripts from landig page for the scrollTop button will scroll smoothlly up the page
       
      

         get_template_part( 'views/components/anu-scroll-top-btn' );
    ?>anu