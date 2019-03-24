<?php
/**
 * Footer Trms of Use
 *
 * Display terms of use link and credit as part of footer
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/footer
 * @version		2.12.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
$terms_label	= get_field( 'acf-options_terms_of_use_label', 'option' );
$terms_link		= get_field( 'acf-options_terms_of_use_link', 'option' );

$copyrights		= array();
$copyrights[]	= '&copy; 1996 ' . get_bloginfo( 'name' );

if ( $terms_label && $terms_link ) {
	$copyrights[] = '<a href="' . $terms_link . '" target="_blank">' . $terms_label . '</a>';
}

?>

<div class="copyrights">

	<?php echo implode( ' | ', $copyrights ); ?>

</div>