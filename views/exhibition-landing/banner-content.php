<?php
/**
 * The Template for displaying the exhibition landing page banner content
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

		<div class="title"><?php echo $title; ?></div>

		<div class="buttons">

			<?php
				/**
				 * Display the tickets button
				 */
				get_template_part( 'views/components/anu-tickets-btn' );
			?>

			<?php
				/**
				 * Display the museum button
				 */
				get_template_part( 'views/components/anu-museum-btn' );
			?>

		</div>

	</div><!-- .content -->
</div><!-- .content-wrap -->