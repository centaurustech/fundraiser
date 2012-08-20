<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();

		error_reporting(E_ALL);
	}

	public function index(){
		$this->load->view('home',array('data'=>$this->get_data()));
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function email(){
		//var_dump($this->uri->segment_array());
		//var_dump($this->input->get());
		$segments = $this->uri->segment_array();
		switch($segments[2]){
			case 'confirm':
				$this->email_confirm();
				break;

			case 'confirmerror':
				echo "EMAIL CONFIRM ERROR<br/>";
				//var_dump($this->input->get('code'));
				break;
		}
	}

	// public function auth(){


	// }



	private function email_confirm(){
		//$this->input->get('code');
		if(!$this->input->get('code')){
			show_404();
		}

		$this->load->model('User_model','user');

		if($this->user->confirm_email($this->input->get('confirmation_code',true))){
			redirect(base_url().'email/confirmsuccess');
		}

		redirect(base_url().'email/confirmerror');
	}

	private function email_confirm_error(){
		
	}


	private function get_data(){
		$this->load->model('User_model','user');
		
		$data['title'] = 'Fundaraiser';

		$sess = $this->session->userdata('user');
		if($sess){
			$data['user']=$sess;
		}

		return $data;
	}

}