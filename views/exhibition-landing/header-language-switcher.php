<?php
/**
 * The Template for displaying the exhibition landing page header language switcher
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/exhibition-landing
 * @since		3.0
 * @version		3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'icl_get_languages' ) )
	return;

// vars
$languages	= icl_get_languages( 'skip_missing=1&orderby=custom' );

if ( empty( $languages ) )
	return;

?>

<ul class="language-switcher">

	<?php foreach ( $languages as $l ) {

		if ( $l[ 'active' ] )
			continue;

		?>

		<li>
			<a href="<?php echo $l[ 'url' ]; ?>">
				<span class="language-name hidden-xs"><?php echo mb_substr( $l[ 'native_name' ], 0, 2 ); ?></span>
				<span class="language-name visible-xs"><?php echo $l[ 'native_name' ]; ?></span>
			</a>
		</li>

	<?php } ?>

</ul>