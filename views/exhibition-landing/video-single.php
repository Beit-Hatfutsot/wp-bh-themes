<?php
/**
 * The Template for displaying the exhibition landing page single video
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.1.9
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// vars
$main_title	= $video[ 'main_title' ];
$sub_title	= $video[ 'sub_title' ];
$content	= $video[ 'content' ];
$video_id	= $video[ 'video_id' ];

if ( ! $video_id )
	return;

?>

<div id="video-single-<?php echo $index; ?>" class="video-single" data-video="<?php echo $video_id; ?>">

	<div class="video-wrap">
		<iframe src="" frameborder="0" allowfullscreen></iframe>
	</div>

	<div class="content-bg-wrap">

		<div class="content-wrap">
			<h3><?php echo $main_title; ?></h3>
			<div class="sub-title"><?php echo $sub_title; ?></div>
			<div class="content"><?php echo $content; ?></div>
			<div class="more-info more visible-xs"><span><?php _e( 'More', 'BH' ); ?></span></div>
			<div class="more-info less visible-xs" style="display: none;"><span><?php _e( 'Less', 'BH' ); ?></span></div>
		</div>

	</div>

	<?php if ( $total > 1 ) { ?>

		<ul class="list">

			<?php for ($i=1 ; $i<=$total ; $i++) :

				$current = ( $i == $index ) ? 'current' : '';

				?>

				<li id="video-item-<?php echo $i; ?>" class="video-item <?php echo $current; ?>"><?php echo $i; ?></li>

			<?php endfor; ?>

		</ul>

	<?php } ?>

</div><!-- #video-single-<?php echo $index; ?> -->