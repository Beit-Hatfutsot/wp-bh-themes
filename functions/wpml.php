<?php
/**
 * WPML functions
 *
 * @author		Beit Hatfutsot
 * @package		bh/functions
 * @version		2.12.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
global $globals;

$globals[ 'wpml_lang' ] = function_exists( 'icl_object_id' ) ? ICL_LANGUAGE_CODE : '';

/**
 * Load theme text domain
 */
load_theme_textdomain( 'BH', get_template_directory() . '/languages' );

/**
 * WPML - disable scripts & styles
 */
define( 'ICL_DONT_LOAD_NAVIGATION_CSS',			true );
define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS',	true );
define( 'ICL_DONT_LOAD_LANGUAGES_JS',			true );

/**
 * BH_wpml_menu_theme_locations
 *
 * This function generates menu theme locations per each predefined WPML language
 *
 * @param	N/A
 * @return	(array)
 */
function BH_wpml_menu_theme_locations() {

	if ( ! function_exists( 'icl_get_languages' ) )
		return;

	global $sitepress;

	$languages		= icl_get_languages( 'skip_missing=0&orderby=custom' );
	$default_lang	= $sitepress->get_default_language();
	$locations		= array();

	if ( ! empty( $languages ) ) {

		foreach ( $languages as $l ) {

			if ( $l[ 'language_code' ] == $default_lang )
				continue;

			$locations[ 'main-menu-' . $l[ 'language_code' ] ]		= __( 'Main Menu - ' . $l[ 'native_name' ] );
			$locations[ 'education-menu-' . $l[ 'language_code' ] ]	= __( 'Education Menu - ' . $l[ 'native_name' ] );
			$locations[ 'shop-menu-' . $l[ 'language_code' ] ]		= __( 'Shop Menu - ' . $l[ 'native_name' ] );

		}

	}

	// return
	return $locations;

}

/**
 * BH_footer_menu_languages_list
 *
 * This function generates the languages list items for the footer menu
 *
 * @param	N/A
 * @return	(string)
 */
function BH_footer_menu_languages_list() {

	if ( ! function_exists( 'icl_get_languages' ) )
		return;

	global $globals;

	$languages	= icl_get_languages( 'skip_missing=0&orderby=custom' );
	$output		= '';

	if ( ! empty( $languages ) ) {

		foreach ( $languages as $l ) {

			if ( ( is_woocommerce() || $globals[ 'shop_page' ] ) && $l[ 'language_code' ] == 'ru' )
				continue;

			$output .= '<li><a ' . ( ! $l[ 'active' ] ? 'href="' . $l[ 'url' ] . '"' : 'style="cursor: default;"' ) . '><span>' . $l[ 'native_name' ] . '</span></a></li>';

		}

	}

	// return
	return $output;

}