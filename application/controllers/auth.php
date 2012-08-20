<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
	}

	function index(){
		show_404();
	}

	public function login(){
		if(!$this->input->post()){
			show_404();
		}

		$this->load->helper('functions');

		$validation = $this->validate_login_form();

		if($validation['error']){
			error_as_json($validation['message']);
		}else{
			$this->session->unset_userdata('error');
			$this->session->set_userdata('user',$validation['user']);
			result_as_json($validation['message'],$validation['user']);
		}
	}

	public function register(){

		if(!$this->input->post()){
			show_404();
		}

		$this->load->helper('functions');
		$this->load->helper('email');	


		if(!(boolean)$this->input->post("firstname") || 
			!(boolean)$this->input->post("lastname") || 
			!(boolean)$this->input->post("email") || !valid_email($this->input->post("email")) ||
			!(boolean)$this->input->post("password") || 
			!(boolean)$this->input->post("confirmpassword") || 
			$this->input->post("password") != $this->input->post("confirmpassword") ||
			!(boolean)$this->input->post("agree")
		){
		 	error_as_json('Registration error, please check all fields');
		}else{
			$this->session->unset_userdata('post');
			$this->session->unset_userdata('error');

			$this->load->model('User_model','user');

			$user = $this->user->register($this->input->post("firstname"),$this->input->post("lastname"),$this->input->post("email"),$this->input->post("password"));

			if($user){
				$this->session->set_userdata('user',$user);
				$activation_url = $this->send_activation_email($user);
				result_as_json('Registration complete. Please check email to activate account. ' . $activation_url);
			}else{
				$this->session->unset_userdata('user');
				error_as_json('Registration error, please check all fields.' . json_encode($user));
			}
		}

	}

	function facebook(){
		$segments = $this->uri->segment_array();
		if($this->uri->segment(3) != 'callback'){

		}else{
			// CALLBACK
			//$this->load->library('facebook/richfacebook');

		}

	}



	private function validate_login_form(){
		
		// if have no post data or data not valid
		if(!$this->input->post('email') || !$this->input->post('password') || !$this->validate_auth($this->input->post('email',true),$this->input->post('password',true))){
			return result(1003);
		}
		
		$this->load->model('User_model','user');
		$user = $this->user->get_user($this->input->post('email',true),$this->input->post('password',true));

		if(!$this->activated($this->input->post('email',true))){
			$result = result(1006);
		}else{
			$result = result(1099);
		}
		$result['user'] = $user;

		return $result;
	}

	private function validate_auth($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}

		$this->load->model('User_model','user');

		return $this->user->validate_auth($email,$password);
	}

	private function activated($email=null){
		if(!$email){
			return false;
		}
		$result = $this->db->get_where('users',array('email'=>$email));
		if($result->num_rows() == 1 && $result->row()->active == 1){
			return true;
		}
		return false;
	}

	private function send_activation_email($user) {

		return base_url() . "email/activation?code=" . $user->activation_code;
		
		//$this->load->helper('email');
		// $subject = 'Account Activation';
		// $recipient = $user['email'];
		// $message = $user['activation_code'];
		//return send_email($recipient, $subject, $message);
	}

}