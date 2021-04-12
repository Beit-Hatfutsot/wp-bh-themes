<?php
/**
 * The Template for displaying the exhibition landing page banner content
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
$title	= get_field( 'acf-exhibition_lp_banner_title' );

?>

<div class="content-wrap">
	<div class="content">

		<?php
			/**
			 * Display the logo
			 */
			get_template_part( 'views/components/anu-logo' );
		?>

		<h1 class="title"><?php echo $title; ?></h1>

		<div class="buttons">

			<?php
				/**
				 * Display the tickets button
				 */
				$gtm_event = 'banner_anu-ticket-btn_click';
				include( locate_template( 'views/components/anu-tickets-btn.php' ) );
			?>

			<?php
				/**
				 * Display the museum button
				 */
				$gtm_event = 'banner_anu-museum-btn_click';
				include( locate_template( 'views/components/anu-museum-btn.php' ) );
			?>

		</div>

	</div><!-- .content -->
</div><!-- .content-wrap -->