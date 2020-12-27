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

<a class="inner-section" id="section-introduction"></a>

<section class="introduction">

	<?php if ( $image ) { ?>

		<img src="<?php echo $image[ 'url' ]; ?>" alt="<?php echo $image[ 'alt' ]; ?>" />

	<?php } ?>

	<div class="content-wrap">

		<h2><?php echo $main_title; ?></h2>
		<div class="sub-title"><?php echo $sub_title; ?></div>
		<div class="content"><?php echo $content; ?></div>

	</div>
</section><!-- .introduction -->