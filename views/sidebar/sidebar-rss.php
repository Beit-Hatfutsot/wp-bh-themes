<?php
/**
 * The Template for displaying the rss link
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/sidebar
 * @since		2.11.0
 * @version		2.11.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="sidebar-rss">
	<a href="<?php bloginfo( 'rss2_url' ); ?>?post_type=post" target="_blank">

		<?php
			/**
			 * Display rss icon
			 */
			get_template_part( 'views/svgs/shape', 'rss' );
		?>

	</a>
</div><!-- .subscribe2-form -->