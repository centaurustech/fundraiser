<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->helper(array('url','html'));
		error_reporting(E_ALL);
	} 
    
    public function index(){
        $this->load->model('ad_model','ad');
        $data = $this->ad->getAd();
        echo link_tag('css/ad.css');
        $this->load->view('ad',array('data' => array('title' => 'Fundraisers'), 'ad' => $data));
    }
    
    /**
     * Create ad
     */
    public function create(){
        if($this->session->userdata('user')){
            $this->load->model('fundraisers_model','fundraisers');
            $this->load->model('ad_model','ad');
            if ($this->input->post()){
                if ($this->validate($this->input->post())) {
                    $data = $this->input->post();
                    $userData = $this->session->userdata('user');
                    $data['user_id'] = $userData->id;
                    $this->ad->add($data);
                    redirect('/', 'refresh');
                }
            }
            $data['fundraisers'] = $this->fundraisers->getFundraisers();
            $data['data']['title'] = 'Create ad';
            echo link_tag('css/jquery-ui-1.8.23.custom.css');
            echo link_tag('css/ad.css');
            $this->load->view('header', array('data' => array('title' => 'create add')));
            $this->load->view('templates/create-ad', $data);
        } else {
            redirect('/ad', 'refresh');
        }
    }
    
    public function show($id = null){
        if ($id) {
            $this->load->model('ad_model','ad');
            $data = $this->ad->getAd(array('id' => $id));
            $this->load->view('show-ad',array('data' => array('title' => 'Show'), 'ad' => $data));
        } else {
            redirect('/ad', 'refresh');
        }
    }

    public function edit($id){
        
    }
    
    public function delete($id){
        
    }
    
    /**
     * validate post data
     * 
     * @param array $data
     * @return bool 
     */
    private function validate($data) {
        if ($data["id_fundraiser"]
            && $data["need_raise"] && is_numeric($data["need_raise"])
            && $data["total_cost"] && is_numeric($data["total_cost"])
            && $data["still_need_raise"] && is_numeric($data["still_need_raise"])
            && $data["date"] && $data["date"] >= date('Y-m-d')
            && $data["description"]
            && $data["meaning"]) {
            return true;
        } else {
            die('ERROR');
        }
    }
    
}