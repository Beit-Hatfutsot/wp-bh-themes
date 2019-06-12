<?php
/**
 * WPML untranslated languages switcher
 *
 * Display specific translated pages
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/wpml
 * @since		2.6.0
 * @version		2.14.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

/**
 * Variables
 */
$untranslated_title	= get_field( 'acf-options_switcher_untranslated_title', 'option' );
$languages			= get_field( 'acf-options_untranslated_languages', 'option' );
$current_permalink	= get_permalink( get_queried_object() );

if ( ! $languages )
	return;

if ( $untranslated_title ) { ?>

	<div class="untranslated-title"><?php echo $untranslated_title; ?></div>

<?php } ?>

<ul class="wpml-untranslated-languages-switcher">

	<?php foreach ( $languages as $l ) {

		$title	= $l[ 'title' ];
		$page	= $l[ 'page' ];

		if ( ! $title || ! $page )
			continue;

		?>

		<li <?php echo $current_permalink == $page[ 'url' ] ? 'class="active"' : ''; ?>>
			<a <?php echo $current_permalink != $page[ 'url' ] ? 'href="' . $page[ 'url' ] . '" target="' . $page[ 'target' ] . '"' : ''; ?>>

				<div class="page-title"><?php echo $title; ?></div>

			</a>
		</li>

	<?php } ?>

</ul>