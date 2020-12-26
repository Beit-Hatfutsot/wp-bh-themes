<?php
/**
 * The Template for displaying the exhibition landing page social / links
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<ul>

	<?php foreach ( $links as $link ) :

		// vars
		$icon	= $link[ 'icon' ];
		$url	= $link[ 'link' ];

		if ( ! $icon || ! $url )
			continue;

		?>

		<li class="social-link social-link-<?php echo $icon[ 'value' ]; ?> tooltip">
			<a href="<?php echo $url; ?>" target="_blank">

				<?php
					/**
					 * Display the icon
					 */
					get_template_part( 'views/svgs/shape', 'anu-' . $icon[ 'value' ] );
				?>

			</a>

			<span class="tooltiptext"><?php echo $icon[ 'label' ]; ?></span>
		</li>

	<?php endforeach; ?>

</ul>