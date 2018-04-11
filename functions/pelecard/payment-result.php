<?php
/**
 * Pelecard iframe 2 response
 *
 * @author 		Beit Hatfutsot
 * @package 	functions/pelecard
 * @version     2.7.3
 */

require_once('../../../../../wp-load.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Untitled Document</title>

	<?php wp_head(); ?>

	<style type="text/css">
		<!--
		html {
			background: none;
		}
		-->
	</style>

</head>

<body>

<?php

	session_start();

	if ( ! isset( $_POST[ 'PelecardTransactionId' ] ) || ! isset( $_SESSION[ 'payment_data' ] ) )
		// return
		return;

	// Validate transaction
	$ConfirmationKey	= $_POST[ 'ConfirmationKey' ];
	$uniqueKey			= $_POST[ 'UserKey' ] ? $_POST[ 'UserKey' ] : $_POST[ 'PelecardTransactionId' ];
	$total				= $_SESSION[ 'payment_data' ][ 'total' ];

	if ( ! BH_pelecard_validate_transaction( $ConfirmationKey, $uniqueKey, $total ) )
		// return
		return;

	// Collect data
	$transaction_result = BH_pelecard_payment_result( $_POST[ 'PelecardTransactionId' ] );

	if ( ! $transaction_result )
		// return
		return;

	if ( $_POST[ 'PelecardStatusCode' ] == '000' ) {

		// Success
		if ( isset( $_SESSION[ 'microfilm-post' ] ) ) {

			// Microfilm payment
			// Add credit card company name
			$_SESSION[ 'payment_data' ][ 'cc_name' ] = $transaction_result[ 'ResultData' ][ 'CardHebrewName' ];

			require( 'microfilm-payment-result.php' );

			// Prepare CFDB
			$posted_data = array();

			foreach ( $_SESSION[ 'microfilm-post' ] as $key => $val ) {

				if ( is_array( $val ) ) {

					// Microfilms data
					for ( $i=0 ; $i<count( $val ) ; $i++ ) {
						if ( is_array( $val[$i] ) ) {
							// Microfilm data
							foreach ( $val[$i] as $microfilm_key => $microfilm_val ) {
								$posted_data[ $microfilm_key . '-' . $i ] = $microfilm_val;
							}
						}
					}

				} else {
					$posted_data[ $key ] = $val;
				}
			}

			$posted_data[ 'total' ]			= $_SESSION[ 'payment_data' ][ 'total' ]/100;
			$posted_data[ 'transactionid' ]	= $_SESSION[ 'payment_data' ][ 'transactionID' ];
			$posted_data[ 'paymentStep' ]	= 'completed';

			$cfdb_form_title = 'LDS Microfilms';

		} else {

			// CF7 payment

			global $additional_posted_data;

			$contact_form	= unserialize( $_SESSION[ 'payment_data' ][ 'contact_form' ] );
			$submission		= unserialize( $_SESSION[ 'payment_data' ][ 'submission' ] );

			// Update instance posted data and additional posted data with transaction info
			$posted_data								= $submission->get_posted_data();
			$posted_data[ 'total' ]						= $_SESSION[ 'payment_data' ][ 'total' ]/100;
			$posted_data[ 'transactionid' ]				= $_SESSION[ 'payment_data' ][ 'transactionID' ];
			$additional_posted_data[ 'paymentStep' ]	= 'completed';

			// Update custom payment instance
			$custom_payment_key							= ( isset( $_SESSION[ 'custom_payment_key' ] ) && $_SESSION[ 'custom_payment_key' ] ) ? $_SESSION[ 'custom_payment_key' ] : ''; 
			$custom_payment								= ( $custom_payment_key ) ? $GLOBALS[ 'customPaymentManager' ]->getCustomPayment( $custom_payment_key ) : '';

			if ( $custom_payment ) {

				$custom_payment->paid( $_SESSION[ 'payment_data' ][ 'transactionID' ] );

				// Update instance posted data with custom payment issuer and customer Emails
				$posted_data[ 'issuer-email' ]		= $_SESSION[ 'payment_data' ][ 'issuer-email' ];
				$posted_data[ 'customer-email' ]	= $_SESSION[ 'payment_data' ][ 'customer-email' ];

			}

			// Build mail messages
			$mail		= $contact_form->prop( 'mail' );
			$mail_2		= $contact_form->prop( 'mail_2' );

			$mail		= BH_build_message( $mail, $posted_data );
			$mail_2		= BH_build_message( $mail_2, $posted_data );

			// Send mail messages
			$result		= WPCF7_Mail::send( $mail, 'mail' );

			if ( $result ) {
				if ( $mail_2 && $mail_2[ 'active' ] ) {
					WPCF7_Mail::send( $mail_2, 'mail_2' );
				}
			}

			$cfdb_form_title = $contact_form->title();

			// Add GTM success indication
			?><script>
				dataLayer.push({
					'event': 'payment-form',
					'conversionValue': <?php echo $posted_data[ 'total' ]; ?>,
					'formName': '<?php echo $cfdb_form_title; ?>'
				});
			</script><?php

		}

		// Document the completed request
		$cfdb_data = (object) array (
			'title'				=> $cfdb_form_title,
			'posted_data'		=> $posted_data,
			'uploaded_files'	=> null
		);
		do_action_ref_array( 'cfdb_submit', array( &$cfdb_data ) );

		// Display payment approval
		echo '<h2>' . __( 'Thank you for your request!', 'BH' ) . '</h2>';
		echo '<p>' . __( 'An invoice for your payment will be sent to your email address shortly.', 'BH' ) . '</p>';

	} else {

		// Error
		echo '<h2>' . __( 'Payment failed', 'BH' ) . '</h2>';

		switch ( $_POST[ 'PelecardStatusCode' ] ) :

			case '006' :
				// Wrong ID or CVV
				echo '<p><strong>' . __( 'Error #', 'BH' ) . '006:</strong> ' . __( 'Wrong ID or CVV.', 'BH' ) . '</p>';
				echo '<p>' . __( 'Please correct the errors and submit the request again.', 'BH' ) . '</p>';

				break;

			case '033' :
			case '039' :
				// Wrong credit card number
				echo '<p><strong>' . __( 'Error #', 'BH' ) . '033/039:</strong> ' . __( 'Wrong credit card number.', 'BH' ) . '</p>';
				echo '<p>' . __( 'Please correct the errors and submit the request again.', 'BH' ) . '</p>';

				break;

			case '101' :
				// Unsupported credit card
				echo '<p><strong>' . __( 'Error #', 'BH' ) . '101:</strong> ' . __( 'Unsupported credit card.', 'BH' ) . '</p>';
				echo '<p>' . __( 'Please submit the request again using a different credit card.', 'BH' ) . '</p>';

				break;

			default :
				// General error
				echo '<p><strong>' . __( 'Error #', 'BH' ) . $_POST[ 'PelecardStatusCode' ] . ':</strong> ' . __( 'General Error.', 'BH' ) . '</p>';

		endswitch;

	}

	// Reset payment and microfilm session data
	$_SESSION[ 'payment_data' ]		= null;
	$_SESSION[ 'microfilm-post' ]	= null;
?>

</body>
</html>
