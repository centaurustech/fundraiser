<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends CI_Controller {

	function __construct(){
	 	parent::__construct();
		$this->load->library('facebook/richfacebook');
	}

	function login($data = false){
		redirect($this->richfacebook->getLoginUrl(array('display'=>'popup','scope'=>$this->config->item('facebook_default_scope'),'redirect_uri'=>$this->config->item('facebook_callback'))));
	}

	function callback(){
		if($this->input->get('error')){
			$this->load->view('facebook_callback',array('data'=>array('error'=>true,'action'=>'login','message'=>$this->input->get('error_description'),'get'=>$this->input->get())));		
		}

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

		$avatar = 'https://graph.facebook.com/' . $me['id'] . '/picture?type=large&access_token=' . $this->richfacebook->getAccessToken();

		// $user_data = array(
		// 	'token'=>$eat['access_token']
		// 	,'expires'=>$eat['expires']
		// 	,'name'=>$me['name']
		// 	,'email'=>$me['email']
		// 	,'avatar'=>$avatar
		// );

		//$this->load->model('User_model','user');

		// save user and update session
		//$this->user->set_facebook_session($this->user->save_soc_user('facebook',$me['id'],$data,false));
		$spl_name = explode(' ',$me['name']);

		$data = array(
			'error'=>false
			,'action'=>'login'
			,'token'=>$this->richfacebook->getAccessToken()
			,'avatar'=>$avatar
			,'firstname'=>$me['first_name']
			,'lastname'=>$me['last_name']
			,'email'=>$me['email']
			,'get'=>$this->input->get()
		);
		// $data['liked_charity'] = $this->richfacebook->liked('charity');
		// $data['liked_brand'] = $this->richfacebook->liked('brand');

		$this->load->view('facebook_callback',array("data"=>$data));
	}

	function logout_callback(){
		//$this->load->model('User_model','user');
		//$this->user->unset_facebook_session();
		//$this->richfacebook->clear_temp_session();
		//$user = $this->session->userdata('user');
		$this->session->unset_userdata('user');
		// if(!isset($user['facebook'])){
		// 	$data->data = array('error'=>false,'action'=>'logout','result'=>true);
		// }else{
		// 	$data->data = array('error'=>true,'action'=>'logout','result'=>false);
		// }
		$data->data = array('action'=>'logout');
		$this->load->view('facebook_callback',$data);
	}

	private function register($firstname,$lastname,$email,$password){
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

}