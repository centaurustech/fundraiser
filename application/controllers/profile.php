<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$CI =& get_instance();
	}

	function index(){
		$data = array();
		$this->load->view('profile',array('data'=>$data));
	}	

	function test(){
		echo "PROFILE TEST";
	}

}