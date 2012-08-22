<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		error_reporting(E_ALL);
	}

	public function index(){
		$this->load->view('home',array('data'=>$this->get_data()));
	}

	public function email(){
		$segments = $this->uri->segment_array();
		switch($segments[2]){
			case 'activation':
				if(array_key_exists(3,$segments)){
					switch($segments[3]){


						case 'success': // email activatio complete
							$result = result($this->input->get('code'));
							echo $result['message'];
							break;
						case 'error': // email activation error
							$result = result($this->input->get('code'));
							echo $result['message'];
							break;
						case 'resend': // resend account activation code to email
							echo $this->input->get('message');
							break;
					}
				}else{		
					if(!$this->input->get('code')){
						show_404();
					}

					$this->load->model('User_model','user');

					$activation_result = $this->user->activation_email($this->input->get('code',true));
					if($activation_result['error']){
						redirect(base_url().'email/activation/error?code='.$activation_result['code']);
					}else{
						redirect(base_url().'email/activation/success?code='.$activation_result['code']);
					}
				}

				break;
			default:

				show_404();
		}
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