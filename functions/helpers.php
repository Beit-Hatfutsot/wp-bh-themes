<?php
/**
 * Helper functions
 *
 * @author		Beit Hatfutsot
 * @package		bh/functions
 * @version		2.12.1
 * @since		2.12.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * BH_debug
 *
 * This function sends print_r output to Firebug Console.log()
 *
 * @source	http://shyammakwana.me/php/send-print_r-firebug-console-log.html
 * @param	$data (Array) Array data to be displayed
 * @return	N/A
 */
function BH_debug( $data ) {

	echo "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";
	$output = explode( "\n", print_r($data, true) );

	foreach ( $output as $line ) {

		if ( trim( $line ) ) {
			$line = addslashes( $line );
			echo "console.log( \"{$line}\" );";
		}

	}

	echo "\r\n//]]>\r\n</script>";

}