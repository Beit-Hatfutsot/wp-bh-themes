<?php
/**
 * The Template for displaying the landing page header title
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="page-title">

	<h1><?php echo $page_title; ?></h1>
	<div class="hidden-title" data-title="<?php echo esc_html( $page_title ); ?>"></div>

</div><!-- .page-title -->