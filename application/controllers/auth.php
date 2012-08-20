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
		
		if($validation['error'] == true){
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
				result_as_json('Registration complete. Please check email to activate account.' . json_encode($user));
			}else{
				$this->session->unset_userdata('user');
				error_as_json('Registration error, please check all fields.' . json_encode($user));
			}
		}

	}

	// public function email_confirm(){
		
	// }

	private function validate_login_form(){
		$result['error'] = false;
		$result['message'] = 'Authorization is successful';

		// if have no post data or data not valid
		if(!$this->input->post('email') || !$this->input->post('password') || !$this->validate_auth($this->input->post('email',true),$this->input->post('password',true))){
			$result['error'] = true;
			$result['message'] = 'This combination of email and password not found';
			$result['user'] = null;
		}else{
			$result['user'] = $this->get_user($this->input->post('email',true),$this->input->post('password',true));
		}
		return $result;
	}

	private function validate_auth($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}

		$this->load->model('User_model','user');

		return $this->user->validate_auth($email,$password);
	}

	private function get_user($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}
		$this->load->model('User_model','user');
		return $this->user->get_user($email,$password);
	}

	private function send_activation_email($user) {
		$this->load->helper('email');
		
		var_dump($user);

		$subject = 'Account Activation';
		$recipient = $user['email'];
		$message = $user['activation_code'];

		return send_email($recipient, $subject, $message);
	}

}