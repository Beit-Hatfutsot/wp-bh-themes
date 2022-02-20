<?php
/**
 * Footer shop experience
 *
 * Display shop experience banner as part of footer
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/footer
 * @version		3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;

if ( 'shop' != $globals[ 'bh_sites' ][ $globals[ 'current_site' ] ][ 'type' ] || ! function_exists( 'get_field' ) )
	return;

$title	= get_field( 'acf-options_experience_title', 'option' );
$text	= get_field( 'acf-options_experience_text', 'option' );

if ( ! $text )
	return;

?>

<div class="container">
	<div class="footer-experience row">
		<div class="col-sm-12">

			<?php if ( $title ) { ?>

				<h2><?php echo $title; ?></h2>

			<?php } ?>

			<div class="text"><?php echo $text; ?></div>

		</div>
	</div><!-- .footer-experience -->
</div>