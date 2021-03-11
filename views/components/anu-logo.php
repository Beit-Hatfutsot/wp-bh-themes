<?php
/**
 * The Template for displaying ANU logo
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/views/components
 * @since		3.0
 * @version     3.1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;

$wpml_lang = $globals[ 'wpml_lang' ];

if ( ! $wpml_lang )
	return;

?>

<div class="logo">

	<a href="<?php echo HOME; ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">

		<?php get_template_part( 'views/svgs/shape', 'anu-logo-' . $wpml_lang ); ?>

	</a>

</div>