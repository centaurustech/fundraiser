<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay extends CI_Controller {

	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
		$this->load->plugin('authorizeNnt/Authorizenet');
		define("AUTHORIZENET_API_LOGIN_ID",$authLogId);
		define("AUTHORIZENET_TRANSACTION_KEY",$authTranKey);
		define("AUTHORIZENET_SANDBOX",true);
		$METHOD_TO_USE = "AIM";
	}

	function index(){

	}

}