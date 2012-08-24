<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$CI =& get_instance();
	}

	function index(){
		$this->load->model('User_model','user');
		$user = $this->user->get_user();
		if(!$user){
			redirect('/');
		}
		// if($user['active'] == 0){
		// 	$user['activation_url'] = send_activation_email($user);
		// }

		$data = array(
			'account'=>$user
		);
		$this->load->view('profile',array('data'=>$data));
	}	

	function activation(){
		if(!$this->input->get('code')){
			show_404();
		}

		$this->load->model('User_model','user');

		$activation_result = $this->user->activation_email($this->input->get('code',true));
		if($activation_result['error']){
			redirect(base_url().'auth/email/activation/error?code='.$activation_result['code']);
		}else{
			redirect(base_url().'auth/email/activation/success?code='.$activation_result['code']);
		}
	}

}