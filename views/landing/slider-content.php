<?php
/**
 * The Template for displaying a single slider content
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/landing
 * @since		2.8.0
 * @version		2.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="content">

	<?php
	/**
	 * Display the slider title
	 */
	?>
	<div class="title">

		<h2><?php echo $title; ?></h2>
		<div class="hidden-title" data-title="<?php echo esc_html( $title ); ?>"></div>

	</div><!-- .page-title -->

	<?php
	/**
	 * Display the slider excerpt
	 */
	?>
	<div class="excerpt">
		<?php echo $excerpt; ?>
		<div class="more">
			<div class="more-text"><?php _e( 'more', 'BH' ); ?></div>
			<i class="fa fa-angle-down"></i>
		</div>
	</div>

	<?php
	/**
	 * Display the slider more info
	 */
	?>
	<div class="more-info">
		<?php echo $more_info; ?>
		<div class="less">
			<div class="less-text"><?php _e( 'less', 'BH' ); ?></div>
			<i class="fa fa-angle-up"></i>
		</div>
	</div>

</div><!-- .content -->