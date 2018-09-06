<?php
/**
 * WPML languages switcher
 *
 * Display dynamic WPML languages switcher
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/wpml
 * @since		2.6.0
 * @version		2.10.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'icl_get_languages' ) )
	return;

/**
 * Variables
 */
global $globals;
$languages = icl_get_languages( 'skip_missing=0&orderby=custom' );

if ( empty( $languages ) )
	return;

?>

<ul class="wpml-languages-switcher">

	<?php foreach ( $languages as $l ) {

		if ( ( is_woocommerce() || $globals[ 'shop_page' ] ) && $l[ 'language_code' ] == 'ru' )
			continue;

		?>

		<li <?php echo $l[ 'active' ] ? 'class="active"' : ''; ?>>
			<a <?php echo ! $l[ 'active' ] ? 'href="' . $l[ 'url' ] . '"' : ''; ?>>
				<div class="flag">

					<?php
						/**
						 * Display the language flag
						 */
						get_template_part( 'views/svgs/shape', 'flag-' . $l[ 'language_code' ] );
					?>
					
				</div>

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