<?php
/**
 * Response Messages
 * 
 * These messages return something that could be meaningful in a log message or to a user.
*/
$lang = array (

	'not_a_module'									=>	'The payment module provided is not valid.',
	'invalid_input' 								=>	'The input provided is not in the correct format',
	'invalid_date_params'							=>	'Units of time must be called "Year", "Month", or "Day"',
	'not_a_method'									=>	'The method called does not exist',
	'required_params_missing'						=>	'Some required parameters have been omitted.',
	'invalid_xml'									=>  'A response was returned from the gateway, but we cannot parse it as XML.  The string has been included',
	'authentication_failure'						=>  'Application failed to authenticate with the payment gateway.  Cannot proceed.',
	//Payment Methods
	'authorize_payment_success'						=>	'The authorization was successful.',
	'authorize_payment_local_failure'				=>	'The authorization was not sent to the payment gateway because it failed validation.',	
	'authorize_payment_gateway_failure'				=>	'The authorization was declined by the payment gateway.',	
	'oneoff_payment_success'						=>	'The payment was successful.',
	'oneoff_payment_local_failure'					=>	'The payment could not be sent to the payment gateway because it failed local validation.',
	'oneoff_payment_gateway_failure'				=>	'The payment was declined by the payment gateway.',
	'oneoff_payment_button_success'					=>  'The payment button was generated successfully',
	'oneoff_payment_button_local_failure'			=>  'There was a problem generating the payment button',
	'oneoff_payment_button_gateway_failure'			=>  'The payment button could not be generated',
	'reference_payment_success'						=>	'The payment was successful.',
	'reference_payment_local_failure'				=>	'The payment could not be sent to the payment gateway because it failed local validation.',
	'reference_payment_gateway_failure'				=>	'The payment was declined by the payment gateway.',	
	'capture_payment_success'						=>	'The payment capture was successful.',
	'capture_payment_local_failure'					=>	'The payment capture could not be sent to the payment gateway because it failed local validation.',
	'capture_payment_gateway_failure'				=>	'The payment capture was declined by the gateway.',
	'void_payment_success'							=>	'The payment was voided successfully.',
	'void_refund_success'							=>	'The return was voided successfully.',	
	'void_payment_local_failure'					=>	'The void request could not be sent to the payment gateway because it failed local validation.',
	'void_payment_gateway_failure'					=>	'The void request was rejected by the payment gateway.',
	'void_refund_gateway_failure'					=>	'The void return request was rejected by the payment gateway.',	
	'get_transaction_details_success'				=>	'Transaction details returned successfully.',
	'get_transaction_details_local_failure'			=>	'Transaction details were not requested from the payment gateway because local validation failed.',
	'get_transaction_details_gateway_failure'		=>	'Transaction details could not be retrieved by the payment gateway.',
	'change_transaction_status_success'				=>	'Transaction status was changed successfully.',
	'change_transaction_status_local_failure'		=>	'Transaction status could not be requested from the payment gateway because local validation failed.',	
	'change_transaction_status_gateway_failure'		=>	'Transaction status could not retrieved from the payment gateway.',
	'refund_payment_success'						=>	'Refund has been made.',
	'refund_payment_local_failure'					=>	'Refund request could not be sent to the payment gateway because local validation failed.',
	'refund_payment_gateway_failure'				=>	'Refund request was declined by the payment gateway.',	
	'search_transactions_success'					=>	'Transaction information successfully retrieved.',
	'search_transactions_local_failure'				=>	'Transaction search request could not be sent to the payment gateway because local validation failed',
	'search_transactions_gateway_failure'			=>	'Transaction search failed.',	
	'recurring_payment_success'						=>	'Recurring payments successfully initiated.',
	'recurring_payment_local_failure'				=>	'Recurring payment request could not be sent to the payment gateway because local validation failed.',	
	'recurring_payment_gateway_failure'				=>	'Recurring payment was declined by the payment gateway.',		
	'get_recurring_profile_success'					=>	'Recurring profile successfully retrieved.',
	'get_recurring_profile_local_failure'			=>	'Recurring profile could not be retrieved from the payment gateway because local validation failed.',
	'get_recurring_profile_gateway_failure'			=>	'Recurring profile could not be retrieved by the payment gateway.',		
	'suspend_recurring_profile_success'				=>	'Recurring profile successfully suspended.',
	'suspend_recurring_profile_local_failure'		=>	'Recurring profile suspension request could not be sent to the payment gateway because local validation failed.',
	'suspend_recurring_profile_gateway_failure'		=>	'Recurring profile could not be suspended by the payment gateway.',		
	'activate_recurring_profile_success'			=>	'Recurring profile successfully activated.',
	'activate_recurring_profile_local_failure'		=>	'Recurring profile activation request could not be sent to the payment gateway because local validation failed.',
	'activate_recurring_profile_gateway_failure'	=>	'Recurring profile could not be activated by the payment gateway.',		
	'cancel_recurring_profile_success'				=>	'Recurring profile cancelled successfully.',
	'cancel_recurring_profile_local_failure'		=>	'Recurring profile cancellation request could not be sent to the payment gateway because local validation failed.',
	'cancel_recurring_profile_gateway_failure'		=>	'Recurring profile could not be cancelled by the payment gateway.',		
	'recurring_bill_outstanding_success'			=>	'Outstanding bill amount successfully billed.',
	'recurring_bill_outstanding_local_failure'		=>	'Outstanding bill request could not be sent to the payment gateway because local validation failed.',
	'recurring_bill_outstanding_gateway_failure'	=>	'Outstanding bill request was rejected by the payment gateway.',		
	'update_recurring_profile_success'				=>	'Recurring profile updated successfully.',
	'update_recurring_profile_local_failure'		=>	'Recurring profile update request could not be sent to the payment gateway because local validation failed.',
	'update_recurring_profile_gateway_failure'		=>	'Recurring profile update was rejected by the payment gateway.',		
	'token_create_success' 							=>  'Card tokenization successful.',
	'token_create_local_failure'					=>	'Card tokenization could not be attempted because validation failed locally.',
	'token_create_gateway_failure'					=>  'Card tokenization failed at the payment gateway.'
);

return $lang;