<?php
/**
 * SmarTicket_Core
 *
 * @author		Beit Hatfutsot
 * @package		includes/classes
 * @version		2.14.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'get_field' ) )
	return;

if ( ! class_exists( 'SmarTicket_Core' ) ) :

class SmarTicket_Core {

	var $settings;

	/**
	* __construct
	*
	* A dummy constructor to ensure is only initialized once
	*
	* @since		2.14.0
	* @param		N/A
	* @return		N/A
	*/
	function __construct() {

		/* Do nothing here */

	}

	/**
	 * initialize
	 *
	 * The real constructor to initialize SmarTicket_Core
	 *
	 * @since		2.14.0
	 * @param		$api (string)
	 * @return		N/A
	 */
	function initialize( $api = '' ) {

		$this->settings = array(

			// api
			'api'				=> $api,

			// transients keys
			'json_key'			=> 'MC-smarticket-json',
			'last_updated_key'	=> 'MC-smarticket-json-updated'

		);

	}

	/**
	 * set
	 *
	 * This function sets a specific setting
	 *
	 * @since		2.14.0
	 * @param		$name (string)
	 * @param		$value (mix)
	 * @return		N/A
	 */
	private function set( $name, $value ) {

		$this->settings[ $name ] = $value;

	}

	/**
	 * get
	 *
	 * This function gets a specific setting
	 *
	 * @since		2.14.0
	 * @param		$name (string)
	 * @return		(mix)
	 */
	private function get( $name ) {

		// return
		return $this->settings[ $name ] ?? false;

	}

	/**
	 * get_json
	 *
	 * This function gets smarticket json object
	 *
	 * @since		2.14.0
	 * @param		N/A
	 * @return		(object)
	 */
	private function get_json() {

		/**
		 * Variables
		 */
		$api = $this->get( 'api' );

		if ( ! $api )
			return false;

		$json = file_get_contents( $api );

		// return
		return json_decode( $json );

	}

	/**
	 * get_data
	 *
	 * This function gets smarticket data
	 *
	 * @since		2.14.0
	 * @param		N/A
	 * @return		(object)
	 */
	function get_data() {

		/**
		 * Variables
		 */
		$json_key			= $this->get( 'json_key' );
		$last_updated_key	= $this->get( 'last_updated_key' );

		if ( ! $json_key || ! $last_updated_key )
			return false;

		$json				= get_transient( $json_key );
		$last_updated		= get_transient( $last_updated_key );

		if ( $json && $json[ 'data' ] && $last_updated && $last_updated <= $json[ 'time' ] )
			// return json from cache
			return $json[ 'data' ];

		// json not valid or not exist in cache
		if ( ! $last_updated )
			set_transient( $last_updated_key, time() );

		$json_data = $this->get_json();
		$data = array( 'time' => time(), 'data' => $json_data );
		set_transient( $json_key, $data );

		// return
		return $json_data;

	}

}

/**
* smarticket
*
* The main function responsible for returning the one true instance
*
* @since		2.14.0
* @param		N/A
* @return		(object)
*/
function smarticket() {

	/**
	 * Variables
	 */
	$api = get_field( 'acf-options_smarticket_api', 'option' );

	// globals
	global $smarticket;

	// initialize
	if( ! isset( $smarticket ) ) {

		$smarticket = new SmarTicket_Core();

		if ( $api ) {
			$smarticket->initialize( $api );
		}

	}

	// return
	return $smarticket;

}

// initialize
smarticket();

endif; // class_exists check