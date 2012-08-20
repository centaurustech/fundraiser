<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function json($data){
	$CI =& get_instance();
	$CI->output->set_header("Content-Type: application/json");
	$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
	$CI->output->set_content_type('application/json');
	$CI->output->set_output(json_encode($data));
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