<?php
/**
 * Functions
 *
 * @author		Beit Hatfutsot
 * @package		bh
 * @version		2.14.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// helpers
require_once( 'functions/helpers.php' );

// theme params
require_once( 'functions/config.php' );

// theme support
require_once( 'functions/theme.php' );

// classes
// smarticket
// require_once( 'includes/classes/class-smarticket-core.php' );

// wpml
require_once( 'functions/wpml.php' );

// scripts & styles registration
require_once( 'functions/scripts-n-styles.php' );

// admin header section
require_once( 'functions/admin/header.php' );	// should be outside is_admin() because of the login screen

if ( is_admin() ) {
	require_once( 'functions/admin/footer.php' );
}

// post types
require_once( 'functions/post-types.php' );
require_once( 'functions/taxonomies.php' );

// transients
// require_once('functions/transients.php');

// sidebars
require_once( 'functions/sidebars.php' );

// widgets
require_once( 'functions/widgets.php' );

// menus
require_once( 'functions/menus.php' );

// template
require_once( 'functions/template.php' );

// other
require_once( 'functions/utils.php' );

// shortcodes
require_once( 'functions/shortcodes.php' );

// ACF field groups
require_once( 'functions/acf/acf-configuration.php' );

if ( ! defined( 'USE_LOCAL_ACF_CONFIGURATION' ) || ! USE_LOCAL_ACF_CONFIGURATION ) {
	require_once( 'functions/acf/acf-field-groups.php' );
}

// woocommerce
require_once( 'functions/woocommerce/classes/class-bh-wc-admin-taxonomies.php' );
require_once( 'functions/woocommerce/woocommerce-functions.php' );
require_once( 'functions/woocommerce/woocommerce-hooks.php' );
require_once( 'functions/woocommerce/google-product-feed.php' );

// api
require_once( 'functions/api/api-functions.php' );
require_once( 'functions/api/api-hooks.php' );

// events
require_once( 'functions/events.php' );

// Yoast breadcrumbs
// require_once( 'functions/yoast-breadcrumbs.php' );

// Pelecard
require_once( 'functions/pelecard/pelecard-api.php' );

// Forms
require_once( 'functions/forms.php' );

// Donations
require_once( 'functions/donations.php' );

// Contact Form 7 hooks
if ( is_cf7_installed() ) {
	require_once( 'functions/forms/wpcf7-hooks.php' );
}