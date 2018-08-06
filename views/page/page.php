<?php
/**
 * The Template for displaying the default page template
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/page
 * @version		2.9.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

/**
 * Variables
 */
global $globals;

$shop_page		= $globals[ 'shop_page' ];
$banners		= get_field( 'acf-content_page_banners' );
$widgets_area	= get_field( 'acf-content_page_template_widgets_area' );

?>

<section class="page-content">

	<?php
		/**
		 * Display page banners
		 */
		include( locate_template( 'views/page/content/banners.php' ) );
	?>

	<?php
		if ( $shop_page ) {

			echo '<div class="container">';
				woocommerce_breadcrumb();
			echo '</div>';

		}
	?>

	<div class="container">
		<div class="row">

			<?php
				if ( ! $shop_page )
					get_template_part( 'views/components/side-menu' );
			?>

			<?php if ( post_password_required( $post->ID ) ) {

				$label				= 'protected-page-' . ( empty( $post->ID ) ? rand() : $post->ID );
				$protected_content	= get_field( 'acf-content_page_password_protected_content' );
				$form				=
					'<form class="password-protected-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">' .
						'<label for="' . $label . '">' . __( "Password:" ) . '</label><br />' .
						'<input name="post_password" id="' . $label . '" type="password" size="20" />' .
						'<input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />' .
					'</form>';

				echo '<div class="col-lg-10 content-wrapper-wide ' . ( ( $shop_page ) ? 'shop-page' : '' ) . '">';
					echo '<div class="protected-content">';
						echo ( $protected_content ) ? $protected_content : '<p>' . __( "This content is password protected. To view it please enter your password below:" ) . '</p>';
					echo '</div>';

					echo $form;
				echo '</div>';

			} else { ?>

				<?php if ( $widgets_area ) { ?>
					<div class="widgets-area-wrapper <?php echo ( $shop_page ) ? 'shop-page' : ''; ?> col-sm-4 col-sm-push-8 col-md-4 col-md-push-8 col-lg-3 col-lg-push-7">
						<?php get_template_part( 'views/page/widgets/widgets' ); ?>
					</div>
				<?php } ?>

				<div class="<?php echo ( $widgets_area ) ? 'content-wrapper col-sm-8 col-sm-pull-4 col-md-8 col-md-pull-4 col-lg-7 col-lg-pull-3' : 'content-wrapper-wide col-lg-10'; ?> <?php echo $shop_page ? 'shop-page' : ''; ?>">
					<?php
						get_template_part( 'views/components/featured-image' );
						get_template_part( 'views/page/content/content' );
					?>
				</div>

				<?php
					/**
					 * Check if a password protected cookie is exist, and delete it
					 * This way we prevent w3 total cache from reloading each page because of this cookie is setup (for the particular session)
					 */
					if ( isset( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] ) ) {
						unset( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] );
						setcookie( 'wp-postpass_' . COOKIEHASH, null, -1, '/' );
					}
				?>

			<?php } ?>

		</div>
	</div>

</section><!-- .page-content -->