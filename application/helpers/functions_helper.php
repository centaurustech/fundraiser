<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function json($data){
	$CI =& get_instance();
	$CI->output->set_header("Content-Type: application/json");
	$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
	$CI->output->set_content_type('application/json');
	$CI->output->set_output(json_encode($data));
	//die();
}

function error_as_json($message,$data=null){
	$result['error'] = true;
	$result['message'] = $message;
	if($data){ $result['data'] = $data; }
	json($result);
}

function result_as_json($message,$data=null){
	$result['error'] = false;
	$result['message'] = $message;
	if($data){ $result['data'] = $data; }
	json($result);
}


// Return action result as array with code, description and boolean value(true - error, false - not error)
function result($id = 0){

	$results = array(
		0=>array(true,'Unknown error')
		,1=>array(false,'Unknown result')

		// auth (1001-1099)
		,1001=>array(true,'Email is not valid')
		,1002=>array(true,'This email is not registered in the system')
		,1003=>array(true,'This combination of email and password not found')
		,1004=>array(true,'Email required')
		,1005=>array(true,'Password required')
			,1006=>array(false,'Account is not activated. Check e-mail or send new mail with an activation code from the profile page')

			,1099=>array(false,'You have successfully logged in')

		// registration (1101-1199)
		,1101=>array(true,'')

		// account activation (1201-1299)
		,1201=>array(true,'Account already activated')
		,1202=>array(true,'Wrong activation code')
		,1203=>array(true,'Activation failed. Please try resend activation code (on profile page)')
		,1204=>array(true,'An error occurred while sending mail, try again later')

			,1298=>array(false,'Activation code was sent to your mailbox')
			,1299=>array(false,'Account activation complete')
	);

	if(!array_key_exists($id, $results)){
		$id = 0;
	}
	
	$result['error'] = $results[$id][0];
	$result['code'] = $id;
	$result['message'] = $results[$id][1];

	return $result;
}

function send_activation_email($user) {
	$CI =& get_instance();
	//error_reporting(E_ALL);
	$CI->load->library('email');
	//v($user['email']);

	//var_dump($this->email);

	$CI->email->from('your@example.com', 'Your Name');
	$CI->email->to($user['email']); 
	$CI->email->subject('Account activation');

	$activation_url = base_url() . "auth/email/activation?code=" . $user['activation_code'];

	$CI->email->message($activation_url);

	return $CI->email->send();
	//return base_url() . "auth/email/activation?code=" . $user['activation_code'];
}


function p($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function v($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}

function pd($data){
	p($data);
	die();
}

function vd($data){
	v($data);
	die();
}