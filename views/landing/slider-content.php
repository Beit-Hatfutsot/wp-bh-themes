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
	<h2><?php echo $title; ?></h2>

	<?php
	/**
	 * Display the slider excerpt
	 */
	?>
	<div class="excerpt"><?php echo $excerpt; ?></div>

	<?php
	/**
	 * Display the slider more info
	 */
	?>
	<div class="more-info"><?php echo $more_info; ?></div>

</div><!-- .content -->