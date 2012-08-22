<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
	}


	public function index(){
		$this->load->view('home',array('data'=>$this->get_data()));
	}


	private function get_data(){
		$this->load->model('User_model','user');
		
		$data['title'] = 'Fundaraiser';

		$sess = $this->session->userdata('user');
		
		if($sess && $sess['email'] && $this->user->is_user($sess['email'])){
		 	$data['user']=$sess;
		}else{
		  	//$this->session->unset_userdata('user');
		}

		return $data;
	}

}