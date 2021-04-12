<?php
/**
 * The Template for displaying the exhibition landing page social
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.1.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

// vars
$title		= get_field( 'acf-exhibition_lp_social_title' );
$links		= get_field( 'acf-exhibition_lp_social_links' );
$phone		= get_field( 'acf-exhibition_lp_phone' );

if ( ! $links && ! $phone )
	return;

?>

<section class="social">

	<?php if ( $title && $links ) { ?>

		<div class="row">
			<div class="col">

				<h4><?php echo $title; ?></h4>

			</div>

			<div class="col">

				<?php
					/**
					 * Display the links
					 */
					include( locate_template( 'views/exhibition-landing/social-links.php' ) );
				?>

			</div>
		</div>

	<?php } elseif ( $title ) { ?>

		<h4><?php echo $title; ?></h4>

	<?php } elseif ( $links ) { ?>

		<?php
			/**
			 * Display the links
			 */
			include( locate_template( 'views/exhibition-landing/social-links.php' ) );
		?>

	<?php } ?>

	<?php

		$gtm_event	= 'contact_phone_click';
		$data_layer	= 'onclick="dataLayer.push({\'event\': \'' . $gtm_event . '\', \'eventAction\': \'click\'});"';

		echo '<div class="phone"><a href="tel:' . $phone . '" ' . $data_layer . '>' . $phone . '</a></div>';

	?>

</section><!-- .social -->