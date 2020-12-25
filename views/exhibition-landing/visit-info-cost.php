<?php
/**
 * The Template for displaying the exhibition landing page visit info / cost
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
$title			= $cost[ 'title' ];
$info			= $cost[ 'info' ];
$extra_content	= $cost[ 'extra_content' ];

if ( ! $title || ! $info )
	return;

?>

<div class="title">

	<?php
		/**
		 * Display the icon
		 */
		get_template_part( 'views/svgs/shape', 'anu-pay' );
	?>

	<h4><?php echo $title; ?></h4>

</div>

<div class="info">

	<table>

		<?php foreach ( $info as $i ) {

			// vars
			$label	= $i[ 'title' ];
			$value	= $i[ 'content' ];

			if ( ! $label || ! $value )
				continue;

			?>

			<tr>
				<td class="label"><?php echo $label; ?></td>
				<td class="value"><?php echo $value; ?></td>
			</tr>

		<?php } ?>

	</table>

	<?php if ( $extra_content ) { ?>

		<div class="extra-content"><?php echo $extra_content; ?></div>

	<?php } ?>

</div>