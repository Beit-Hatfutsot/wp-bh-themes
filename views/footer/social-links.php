<?php
/**
 * Social links
 *
 * Display social links as part of footer
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/footer
 * @version		3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

/**
 * Variables
 */
global $globals;

$bh_sites		= $globals[ 'bh_sites' ];
$current_site	= $globals[ 'current_site' ];

if ( ! $bh_sites || $current_site === false )
	return;

$links			= $bh_sites[ $current_site ][ 'social_links' ];

if ( ! $links )
	return;

?>

<div class="container">
	<div class="social-links row">

		<ul>
			<?php foreach ( $links as $l ) {

				// Get link data
				$icon	= $l[ 'icon' ];
				$link	= $l[ 'link' ];

				if ( ! $icon || ! $link )
					continue;

				?>

				<li>
					<a href="<?php echo $link; ?>" target="_blank">

						<?php
							/**
							 * Display the icon
							 */
							get_template_part( 'views/svgs/shape-anu', substr( $icon, 3 ) );
						?>

					</a>
				</li>

			<?php } ?>
		</ul>

	</div><!-- .social-links -->
</div>