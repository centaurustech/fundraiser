<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
	}

	function index(){
		show_404();
	}

	function test(){
		echo "AUTH TEST";
	}

	public function logout(){
		$this->session->unset_userdata('user');
		redirect(base_url());
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
			$this->session->set_userdata('user',$validation);
			result_as_json($validation['message'],$validation);
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
				$activation_url = send_activation_email($user);
				result_as_json('Registration complete. Please check email to activate account. ' . $activation_url);
			}else{
				$this->session->unset_userdata('user');
				error_as_json('Registration error, please check all fields.' . json_encode($user));
			}
		}

	}



	function facebook_login($data = false){
		$this->load->library('facebook/richfacebook');
		redirect($this->richfacebook->getLoginUrl(array('display'=>'popup','scope'=>$this->config->item('facebook_default_scope'),'redirect_uri'=>$this->config->item('facebook_callback'))));
	}

	function facebook_callback(){
		$this->load->library('facebook/richfacebook');

		if($this->input->get('error')){
			$data = array('error'=>true,'action'=>'login','message'=>$this->input->get('error_description'));
			//var_dump($data);

			$this->load->view('facebook_callback',array("data"=>$data));	
			exit;	
		}
		//die();

		$eat = $this->richfacebook->getExtendedAccessToken();
		// if extended access token error
		if(false == $eat){
			$this->load->view('facebook_callback',array('data'=>array('error'=>true,'message'=>'An error occurred while receiving long-term access token','action'=>'login','get'=>$this->input->get())));
			exit;
		}

	    $me = $this->richfacebook->api('/me');

		$error = is_array($me) ? $me : json_decode($me, true);
	    if(is_array($error) && isset($error['error'])) {
	    	$this->load->view('facebook_callback',array('data'=>array('error'=>'An error occurred while receiving user data','action'=>'login','get'=>$this->input->get())));
			exit;
	    }

		$avatar = 'https://graph.facebook.com/' . $me['id'] . '/picture?type=small&access_token=' . $this->richfacebook->getAccessToken();

		$data = array(
			'error'=>false
			,'action'=>'login'
			,'facebook_access_token'=>$this->richfacebook->getAccessToken()
			,'avatar'=>$avatar
			,'firstname'=>$me['first_name']
			,'lastname'=>$me['last_name']
			,'email'=>$me['email']
			//,'get'=>$this->input->get()
		);
	
		$this->load->model('User_model','user');
		$user = $this->user->register_facebook($data["firstname"],$data["lastname"],$data["email"],$data['token'],$data['avatar']);
		$this->session->set_userdata('user',$this->user->get_facebook_user($data['token']));

		$data['user'] = $user;

		$this->load->view('facebook_callback',array("data"=>$data));
	}

	function facebook_logout_callback(){
		// $this->session->unset_userdata('user');

		$data->data = array('action'=>'logout');
		$this->load->view('facebook_callback',$data);
	}

	function get_facebook_user_by_token(){
		if(!$this->input->post('access_token')){
			error_as_json('Access token required');
		}
		$this->load->library('facebook/richfacebook');
		$eat = $this->richfacebook->getExtendedAccessToken($this->input->post('access_token'));

		try {
			$me = $this->richfacebook->api('/me');

			if(isset($eat['access_token'])){
				$this->load->model('User_model','user');
				$user = $this->user->get_facebook_user($eat['access_token']);
			}

			if(!$user){
				$user = array(
					'error'=>false
					,'action'=>'login'
					,'facebook_access_token'=>$this->richfacebook->getAccessToken()
					,'avatar'=>'https://graph.facebook.com/' . $me['id'] . '/picture?type=small&access_token=' . $this->richfacebook->getAccessToken()
					,'firstname'=>$me['first_name']
					,'lastname'=>$me['last_name']
					,'email'=>$me['email']
				);
			}

			result_as_json('',$user);
			
		} catch (Exception $e) {
			error_as_json('Access token not valid');
		}
	}

	private function facebook_register($firstname,$lastname,$email,$password){
		$this->load->model('User_model','user');
		$user = $this->user->register($firstname,$lastname,$email,$password);
		if($user){
			$this->session->set_userdata('user',$user);
			$activation_url = send_activation_email($user);
			result_as_json('Registration complete. Please check email to activate account. ' . $activation_url);
		}else{
			$this->session->unset_userdata('user');
			error_as_json('Registration error, please check all fields.' . json_encode($user));
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
		$result = array_merge($result,$user);
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

}