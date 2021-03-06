<?php
/**
 * WPML languages switcher
 *
 * Display dynamic WPML languages switcher
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/wpml
 * @since		2.6.0
 * @version		2.14.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'icl_get_languages' ) || ! function_exists( 'get_field' ) )
	return;

/**
 * Variables
 */
global $globals;

$main_title	= get_field( 'acf-options_switcher_main_title', 'option' );
$languages	= icl_get_languages( 'skip_missing=0&orderby=custom' );

if ( empty( $languages ) )
	return;

if ( $switcher_type == 'menu' && $main_title ) { ?>

	<div class="main-title"><?php echo $main_title; ?></div>

<?php } ?>

<ul class="wpml-languages-switcher">

	<?php foreach ( $languages as $l ) {

		if ( ( is_woocommerce() || $globals[ 'shop_page' ] ) && $l[ 'language_code' ] == 'ru' )
			continue;

		?>

		<li <?php echo $l[ 'active' ] ? 'class="active"' : ''; ?>>
			<a <?php echo ! $l[ 'active' ] ? 'href="' . $l[ 'url' ] . '"' : ''; ?>>

				<?php
					if ( $switcher_type == 'menu' ) { ?>
						<div class="language-name"><?php echo $l[ 'native_name' ]; ?></div>
					<?php } else { ?>
						<div class="language-name" data-title="<?php echo mb_substr( $l[ 'native_name' ], 0, 2 ); ?>"><?php echo mb_substr( $l[ 'native_name' ], 0, 2 ); ?></div>
					<?php }
				?>

			</a>
		</li>

	<?php } ?>

</ul>