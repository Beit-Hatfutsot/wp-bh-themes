<?php
/**
 * Contact Form 7 hooks
 *
 * @author		Beit Hatfutsot
 * @package		bh/functions/forms
 * @version		2.7.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Variables
 */
$additional_posted_data	= array();		// Additional posted data to be store before saving to DB
$custom_payment			= null;			// Holds the relevant custom payment instance in case we are handling custom payment form

/**
 * BH_form_class_attr
 *
 * This function adds specific class to CF7 forms
 *
 * @param	$class (string)	CF7 class
 * @return	(string)
 */
function BH_form_class_attr( $class ) {

	// return
	return $class . ' bh-form';

}
add_filter( 'wpcf7_form_class_attr', 'BH_form_class_attr', 10, 1 );

/************************************************** Custom tags **************************************************/

/**
 * BH_add_custom_form_tags
 *
 * This function adds custom tags
 *
 * @param	N/A
 * @return	N/A
 */
function BH_add_custom_form_tags() {

	/**
	 * Variables
	 */
	$custom_tags = array( 'country', 'state', 'province' );

	foreach ( $custom_tags as $t ) {
		wpcf7_add_form_tag( array( $t, $t.'*' ), 'BH_custom_' . $t . '_form_tag_handler', array( 'name-attr' => true ) );
		add_filter( 'wpcf7_validate_' . $t . '*', 'BH_custom_tag_validation_filter', 10, 2 );
	}

}
add_action( 'wpcf7_init', 'BH_add_custom_form_tags' );

/**
 * BH_custom_tag_validation_filter
 *
 * This function validates required custom tags
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	$name = $tag->name;

	if ( ! isset( $_POST[ $name ] ) || empty( $_POST[ $name ] ) && '0' !== $_POST[ $name ] ) {

		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );

	}

	// return
	return $result;

}

/************************************************** Custom tag: country **************************************************/

/**
 * BH_custom_country_form_tag_handler
 *
 * This function adds the country custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_country_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	$type = $tag->type;
	$name = $tag->name;

	$output	= '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output	.= '<select name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-select inputfield' . ( ($type == 'country*') ? ' wpcf7-validates-as-required' : '' ) . '"' . ( ( $type == 'country*' ) ? ' aria-required="true" ' : '' ) . 'onchange="document.getElementById("' . $name . '").value=this.value;"><option value="">---</option>';
	$output	.= file_get_contents( 'wp-content/themes/bh/views/components/country-list.html' );
	$output	.= '</select></span>';

	// return
	return $output;

}

/************************************************** Custom tag: state **************************************************/

/**
 * BH_custom_state_form_tag_handler
 *
 * This function adds the state custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_state_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	$type = $tag->type;
	$name = $tag->name;

	$output	= '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output	.= '<select name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-select inputfield' . ( ( $type == 'state*' ) ? ' wpcf7-validates-as-required' : '' ) . '"' . ( ( $type == 'state*' ) ? ' aria-required="true" ' : '' ) . 'onchange="document.getElementById( "' . $name . '" ).value=this.value;"><option value="">---</option>';
	$output	.= file_get_contents( 'wp-content/themes/bh/views/components/state-list.html' );
	$output	.= '</select></span>';

	// return
	return $output;

}

/************************************************** Custom tag: province **************************************************/

/**
 * BH_custom_province_form_tag_handler
 *
 * This function adds the province custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_province_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	$type = $tag->type;
	$name = $tag->name;

	$output	= '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output	.= '<select name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-select inputfield' . ( ( $type == 'province*' ) ? ' wpcf7-validates-as-required' : '' ) . '"' . ( ( $type == 'province*' ) ? ' aria-required="true" ' : '' ) . 'onchange="document.getElementById( "' . $name . '" ).value=this.value;"><option value="">---</option>';
	$output	.= file_get_contents( 'wp-content/themes/bh/views/components/province-list.html' );
	$output	.= '</select></span>';

	// return
	return $output;

}

/************************************************** Custom tag: payment **************************************************/

/**
 * BH_add_custom_payment_form_tag
 *
 * This function adds the payment custom tag
 *
 * @param	N/A
 * @return	N/A
 */
function BH_add_custom_payment_form_tag() {

	wpcf7_add_form_tag( 'payment', 'BH_custom_payment_form_tag_handler', array( 'name-attr' => false ) );
	add_filter( 'wpcf7_validate_payment', 'BH_custom_payment_tag_validation_filter', 10, 2 );

}
add_action( 'wpcf7_init', 'BH_add_custom_payment_form_tag' );

/**
 * BH_custom_payment_form_tag_handler
 *
 * This function adds the payment custom tag
 *
 * Can be defined with 2 different forms:
 * [payment custom {en/he}]				/ for custom payment form
 * [payment {gen/com} {en/he} {total}]	/ for genealogy/communities forms
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_payment_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$type					= $tag->type;
	$transactionID_prefix	= $tag->options[0];		// custom/gen/com
	$lang					= $tag->options[1];		// en/he
	$price					= ( $transactionID_prefix == 'custom' && isset( $custom_payment ) ) ? $custom_payment->data[ 'total' ] : $tag->options[2];

	if ( ! ( 'payment' == $type && $transactionID_prefix && $lang && $price ) )
		// return
		return '';

	// Generate transaction ID
	$prefix = ( $transactionID_prefix == 'custom' && isset( $custom_payment ) ) ? substr( $custom_payment->data[ 'transactionKey' ], 0, 3 ) : $transactionID_prefix;
	$transactionID = BH_generate_transactionID( $prefix );

	// Store payment data for further processing via Pelecard iframe
	session_start();

	$_SESSION[ 'payment_data' ] = array(
		'goodUrl'			=> TEMPLATE . '/functions/pelecard/payment-result.php',
		'errorUrl'			=> TEMPLATE . '/functions/pelecard/payment-result.php',
		'total'				=> $price * 100,
		'currency'			=> '1',
		'transactionID'		=> $transactionID
	);

	$pelecard_iframe = BH_pelecard_iframe( $lang );

	if ( $pelecard_iframe ) {

		// Display Pelecard iframe
		?>
		<script>
			jQuery(function($) {
				var payment_form =
					'<script>' +
						'$(document).ajaxSuccess(function(event, xhr, settings) {' +
							// parse xhr responseText
							'var response = JSON.parse(xhr.responseText);' +

							'if (typeof response.paymentStep == "undefined" || response.paymentStep != "processing")' +
								'return;' +

							// hide contact form 7 form
							'$(".bh-form").fadeOut();' +

							// expose payment form
							'$("#payment-form").fadeIn();' +
						'});' +
					'</scr'+'ipt>' +

					'<div id="payment-form" style="display: none;">' +
						'<iframe id="frame" name="pelecard_frame" frameborder="0" scrolling="no" src="' + '<?php echo $pelecard_iframe; ?>' + '" style="width:100%; height:694px;"></iframe>' +
					'</div>';

				// move payment form after contact form 7 form
				$('.bh-form').after(payment_form);
			});
		</script>

	<?php }

}

/**
 * BH_custom_payment_tag_validation_filter
 *
 * This function validates the payment custom tag
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_payment_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$type					= $tag->type;
	$transactionID_prefix	= $tag->options[0];		// custom/gen/com
	$lang					= $tag->options[1];		// en/he
	$price					= ( $transactionID_prefix == 'custom' && isset( $custom_payment ) ) ? $custom_payment->data[ 'total' ] : $tag->options[2];

	if ( 'payment' == $type && $transactionID_prefix && $lang && $price ) {
		add_action( 'wpcf7_before_send_mail', 'BH_make_payment', 5, 3 );
	}

	// return
	return $result;

}

/**
 * BH_make_payment
 * 
 * This function is called as part of payment custom tag validation process
 * Called after a successful form validation and before contact form 7 mail submission
 * Handles 'processing' stage (before pelecard iframe payment submission)
 *
 * @param	$contact_form (obj) contact form object
 * @param	&$abort (bool) submission abort indication
 * @param	$submission (obj) submission object
 * @return	N/A
 */
function BH_make_payment( $contact_form, &$abort, $submission ) {

	/**
	 * Variables
	 */
	global $additional_posted_data, $custom_payment;

	// Update posted data with payment step as 'processing'
	$additional_posted_data[ 'paymentStep' ] = 'processing';

	session_start();

	if ( isset( $_SESSION[ 'payment_data' ] ) ) {

		// Store custom payment issuer and customer Emails
		if ( isset( $custom_payment ) ) {
			$_SESSION[ 'payment_data' ][ 'issuer-email' ]	= $custom_payment->data[ 'issuerEmail' ];
			$_SESSION[ 'payment_data' ][ 'customer-email' ]	= $custom_payment->data[ 'customerEmail' ];
		}

		// Store serialized WPCF7_ContactForm and WPCF7_Submission objects
		$_SESSION[ 'payment_data' ][ 'contact_form' ]	= serialize( $contact_form );
		$_SESSION[ 'payment_data' ][ 'submission' ]		= serialize( $submission );

	}

	// Abort mail submission by contact form 7
	$abort = true;

	$submission->set_response( $contact_form->message( 'mail_sent_ok' ) );

	add_filter( 'wpcf7_ajax_json_echo', 'BH_kill_form' );

}

/**
 * BH_kill_form
 * 
 * This function is called as part of payment custom tag validation process
 * Updates $items with paymentStep as processing in order to hide Contact Form 7 form and expose the payment form
 *
 * @param	$items (array)
 * @return	(array)
 */
function BH_kill_form( $items ) {

	$items[ 'paymentStep' ] = 'processing';

	// return
	return $items;

}

/************************************************** Custom payment **************************************************/

/**
 * BH_add_custom_payment_form_tags
 *
 * This function adds custom tags for the custom payment form
 *
 * @param	N/A
 * @return	N/A
 */
function BH_add_custom_payment_form_tags() {

	/**
	 * Variables
	 */
	$custom_tags = array( 'paymentkey', 'transactionkey', 'total' );

	foreach ( $custom_tags as $t ) {
		wpcf7_add_form_tag( array( $t, $t.'*' ), 'BH_custom_' . $t . '_form_tag_handler', array( 'name-attr' => true ) );
		add_filter( 'wpcf7_validate_' . $t, 'BH_custom_' . $t . '_tag_validation_filter', 10, 2 );
		add_filter( 'wpcf7_validate_' . $t . '*', 'BH_custom_' . $t . '_tag_validation_filter', 10, 2 );
	}

}
add_action( 'wpcf7_init', 'BH_add_custom_payment_form_tags' );

/************************************************** Custom tag: paymentkey **************************************************/

/**
 * BH_custom_paymentkey_form_tag_handler
 *
 * This function adds the paymentkey custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_paymentkey_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name	= $tag->name;
	$key	= $_GET[ 'key' ];

	if ( ! isset( $key ) || empty( $key ) && '0' !== $key )
		// return
		return '';

	$custom_payment	= $GLOBALS[ 'customPaymentManager' ]->getCustomPayment( $key );

	if ( ! $custom_payment ) {
		die( 'The payment does not exist or has been outdated.' );
	}

	if ( $custom_payment->data[ 'paid' ] ) {
		die( 'This payment has been received. Thank you.' );
	}

	$payment_key = $custom_payment ? $custom_payment->data[ 'paymentKey' ] : 'Wrong Key';

	// Store custom payment key for further processing after payment has completed
	session_start();

	$_SESSION[ 'custom_payment_key' ] = $custom_payment ? $custom_payment->data[ 'paymentKey' ] : '';

	$output = '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output .= '<input type="hidden" readonly="true" value="' . $payment_key . '" name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-text inputfield wpcf7-validates-as-required" aria-required="true" onchange="document.getElementById("paymentkey").value=this.value;" /></span>';

	// return
	return $output;

}

/**
 * BH_custom_paymentkey_tag_validation_filter
 *
 * This function validates the paymentkey custom tag
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_paymentkey_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name			= $tag->name;
	$payment_key	= $_POST[ $name ];

	$custom_payment	= $GLOBALS[ 'customPaymentManager' ]->getCustomPayment( $payment_key );

	if ( ! isset( $payment_key ) || empty( $payment_key ) && '0' !== $payment_key ) {

		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );

	}
	elseif ( ! $custom_payment || $custom_payment->data[ 'paymentKey' ] !== $payment_key || $custom_payment->data[ 'paid' ] ) {

		$result->invalidate( $tag, 'wrong key' );

	}

	// return
	return $result;

}

/************************************************** Custom tag: transactionkey **************************************************/

/**
 * BH_custom_transactionkey_form_tag_handler
 *
 * This function adds the transactionkey custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_transactionkey_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name				= $tag->name;
	$transaction_key	= $custom_payment ? $custom_payment->data[ 'transactionKey' ] : '';

	$output = '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output .= '<input readonly="true" value="' . $transaction_key . '" name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-text inputfield wpcf7-validates-as-required" aria-required="true" onchange="document.getElementById("' . $name . '").value=this.value;" /></span>';

	// return
	return $output;

}

/**
 * BH_custom_transactionkey_tag_validation_filter
 *
 * This function validates the transactionkey custom tag
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_transactionkey_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name				= $tag->name;
	$transaction_key	= $_POST[ $name ];

	if ( ! isset( $transaction_key ) || empty( $transaction_key ) && '0' !== $transaction_key ) {

		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );

	}
	elseif ( ! $custom_payment || $custom_payment->data[ 'transactionKey' ] !== $transaction_key ) {

		$result->invalidate( $tag, get_transactionkey_error() );

	}

	// return
	return $result;

}

/************************************************** Custom tag: total **************************************************/

/**
 * BH_custom_total_form_tag_handler
 *
 * This function adds the total custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_total_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name	= $tag->name;
	$total	= $custom_payment ? $custom_payment->data[ 'total' ] : '';

	$output	= '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output	.= '<input readonly="true" value="' . $total . '" name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-text inputfield wpcf7-validates-as-required" aria-required="true" onchange="document.getElementById("' . $name . '").value=this.value;" /></span>';

	// return
	return $output;

}

/**
 * BH_custom_total_tag_validation_filter
 *
 * This function validates the total custom tag
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_total_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	global $custom_payment;

	$name	= $tag->name;
	$total	= $_POST[ $name ];

	if ( ! isset( $total ) || empty( $total ) && '0' !== $total ) {

		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );

	}
	elseif ( ! $custom_payment || $custom_payment->data[ 'total' ] !== $total ) {

		$result->invalidate( $tag, get_total_error() );

	}

	// return
	return $result;

}

/************************************************** Custom tag: event **************************************************/

/**
 * BH_add_custom_event_form_tag
 *
 * This function adds the event custom tag
 *
 * @param	N/A
 * @return	N/A
 */
function BH_add_custom_event_form_tag() {

	wpcf7_add_form_tag( array( 'event', 'event*' ), 'BH_custom_event_form_tag_handler', array( 'name-attr' => true ) );
	add_filter( 'wpcf7_validate_event*', 'BH_custom_event_tag_validation_filter', 10, 2 );

}
add_action( 'wpcf7_init', 'BH_add_custom_event_form_tag' );

/**
 * BH_custom_event_form_tag_handler
 *
 * This function adds the event custom tag
 *
 * @param	$tag (obj) custom tag object
 * @return	(string) HTML markup
 */
function BH_custom_event_form_tag_handler( $tag ) {

	/**
	 * Variables
	 */
	$type	= $tag->type;
	$name	= $tag->name;

	// Query event marked for display in form
	$args = array(
		'post_type'         => 'event',
		'posts_per_page'    => -1,
		'no_found_rows'		=> true,
		'orderby'           => 'title',
		'order'             => 'ASC',
		'meta_query'        => array(
			'relation' => 'AND',
			array(
				'key' => 'acf-event_registration_form',
				'value' => true
			),
			array(
				'key'		=> 'acf-event_end_date',
				'value'		=> date_i18n('Ymd'),
				'type'		=> 'DATE',
				'compare'	=> '>='
			)
		)
	);
	$events_query = new WP_Query($args);

	$output = '<span class="wpcf7-form-control-wrap ' . $name . '">';
	$output .= '<select name="' . $name . '" id="' . $name . '" class="wpcf7-form-control wpcf7-select inputfield' . ( ($type == 'event*') ? ' wpcf7-validates-as-required' : '' ) . '"' . ( ($type == 'event*') ? ' aria-required="true"' : '' ) . 'onchange="document.getElementById("' . $name . '").value=this.value;"><option value="">---</option>';

	global $post;

	if ( $events_query->have_posts() ) : while( $events_query->have_posts() ) : $events_query->the_post();

		$id		= $post->ID;
		$title	= $post->post_title;

		if ( isset( $_GET[ 'event_id' ] ) && $id == $_GET[ 'event_id' ] ) {
			$output .= '<option value="' . $title . '" selected>' . $title . '</option>';
		}
		else {
			$output .= '<option value="' . $title . '">' . $title . '</option>';
		}
		
	endwhile; endif; wp_reset_postdata();

	$output .= '</select></span>';

	// return
	return $output;

}

/**
 * BH_custom_event_tag_validation_filter
 *
 * This function validates the event custom tag
 *
 * @param	$result (obj) custom tag result object
 * @param	$tag (obj) custom tag object
 * @return	(obj) custom tag result
 */
function BH_custom_event_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	$name	= $tag->name;

	if ( ! isset( $_POST[ $name ] ) || empty( $_POST[ $name ] ) && '0' !== $_POST[ $name ] ) {

		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );

	}

	// return
	return $result;

}

/************************************************** tag: file **************************************************/

add_filter( 'wpcf7_validate_file', 'BH_file_tag_validation_filter', 11, 2 );
add_filter( 'wpcf7_validate_file*', 'BH_file_tag_validation_filter', 11, 2 );

/**
 * BH_file_tag_validation_filter
 *
 * This function validates the file tag
 *
 * @param	$result (obj) tag result object
 * @param	$tag (obj) tag object
 * @return	(obj) tag result
 */
function BH_file_tag_validation_filter( $result, $tag ) {

	/**
	 * Variables
	 */
	$name	= $tag->name;
	$gedcom	= $tag->get_option( 'gedcom' );

	if ( $result->is_valid() && $gedcom ) {
		add_action( 'wpcf7_before_send_mail', 'BH_save_file', 10, 3 );
	}
	
	// return
	return $result;

}

/**
 * BH_save_file
 * 
 * This function generates a zip file contains an uploaded gedcom file and save it in a dedicated folder
 *
 * @param	$contact_form (obj) contact form object
 * @param	&$abort (bool) submission abort indication
 * @param	$submission (obj) submission object
 * @return	N/A
 */
function BH_save_file( $contact_form, &$abort, $submission ) {

	/**
	 * Variables
	 */
	$uploaded_files	= $submission->uploaded_files();

	// Open log file for writing
	$log = fopen( THEME_ROOT . '/functions/forms/save_file_log.txt', 'a+' );

	if ( $log ) {
		fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Info] Save file process initialized' . PHP_EOL );
	}

	if ( ! $uploaded_files ) {
		if ( $log ) {
			fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Error] No uploaded files detected' . PHP_EOL );
		}

		// return
		return;
	}

	$upload_dir				= wp_upload_dir();
	$folder					= 'gedcom';
	$first_uploaded_file	= reset( $uploaded_files );
	$zip_filename			= time() . substr( $first_uploaded_file, strrpos( $first_uploaded_file, '/' ) + 1 ) . '.zip';
	$zip_path				= $upload_dir[ 'path' ] . '/' . $folder . '/' . $zip_filename;

	// Create the archive based on the first uploaded file name
	$zip = new ZipArchive();
	$res = $zip->open( $zip_path, ZIPARCHIVE::CREATE );

	if ( $res === true ) {

		if ( $log ) {
			fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Info] Zip file created successfully: ' . $zip_path . PHP_EOL );
		}

		// Add uploaded file to zip file
		foreach ( $uploaded_files as $file ) {

			$path	= $file;
			$name	= substr( $path, strrpos( $path, '/' ) + 1 );
			$res	= $zip->addFile( $path, $name );

			if ( $log ) {
				if ( $res ) {
					fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Info] File added to zip successfully: ' . $file . PHP_EOL );
				}
				else {
					fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Error] Failed to add file to zip: ' . $file . PHP_EOL );
				}
			}

		}

		// Close and save zip file
		$res = $zip->close();

		if ( $log ) {
			if ( $res ) {
				fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Info] Zip file closed successfully' . PHP_EOL );
			}
			else {
				fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Error] Failed to close zip file: ' . $file . PHP_EOL );
			}
		}

		if ( $res ) {
			@chmod( $zip_path, 0664 );
		}

		// Abort mail submission by contact form 7 in order to manually send it with gedcom url
		$abort = true;

		$submission->set_response( $contact_form->message( 'mail_sent_ok' ) );

		// Manually send mail with gedcom url
		$posted_data					= $submission->get_posted_data();
		$posted_data[ 'gedcom-url' ]	= ( $res ) ? $upload_dir[ 'url' ] . '/' . $folder . '/' . $zip_filename : 'Error creating file (gedcom file cannot be added)';

	}
	else {

		if ( $log ) {
			fwrite( $log, date( 'Y-m-d H:i:s' ) . ' [Error] Failed to create zip file: ' . $zip_path . PHP_EOL );
		}

		// Abort mail submission by contact form 7 in order to manually send it
		$abort = true;

		// Manually send mail with gedcom url
		$posted_data					= $submission->get_posted_data();
		$posted_data[ 'gedcom-url' ]	= 'Error creating file (' . $res . ')';

	}

	$mail	= $contact_form->prop( 'mail' );
	$mail_2	= $contact_form->prop( 'mail_2' );

	$mail	= BH_build_message( $mail, $posted_data );
	$mail_2	= BH_build_message( $mail_2, $posted_data );

	// Send mail messages
	$result = WPCF7_Mail::send( $mail, 'mail' );

	if ( $result ) {
		if ( $mail_2 && $mail_2[ 'active' ] ) {
			WPCF7_Mail::send( $mail_2, 'mail_2' );
		}
	}

	// Document the completed request
	$cfdb_data = (object) array (
		'title'				=> $contact_form->title(),
		'posted_data'		=> $posted_data,
		'uploaded_files'	=> $uploaded_files
	);
	do_action_ref_array( 'cfdb_submit', array( &$cfdb_data ) );

	if ( $log ) {
		fclose( $log );
	}

}

/************************************************** CFDB **************************************************/

/**
 * BH_set_cfdb_posted_data
 *
 * This function filters CFDB form data before saving to DB
 *
 * @param	$formData (obj) form data object
 * @return	(obj)
 */
function BH_set_cfdb_posted_data( $formData ) {

	/**
	 * Variables
	 */
	global $additional_posted_data;

	// Add $additional_posted_data to formData->posted_data
	if ( $formData && $additional_posted_data ) {

		foreach ( $additional_posted_data as $key => $val ) {
			$formData->posted_data[ $key ] = $val;
		}

	}

	// return
	return $formData;

}
add_filter( 'cfdb_form_data', 'BH_set_cfdb_posted_data' );

/************************************************** tag: tel **************************************************/

/**
 * BH_validate_phone
 *
 * This function validates the tel tag
 *
 * @param	$result (obj) tag result object
 * @param	$tag (obj) tag object
 * @return	(obj) tag result
 */
function BH_validate_phone( $result, $tel ) {

	// return
	return ! ( strlen( $tel ) < 9 );

}
add_filter( 'wpcf7_is_tel', 'BH_validate_phone', 11, 2 );