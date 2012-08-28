<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad extends CI_Controller {
    
    function __construct(){
		parent::__construct();
        $this->load->helper(array('url','html'));
        echo link_tag('css/ad.css');
		error_reporting(E_ALL);
	} 
    
    /**
     * list all ads
     */
    public function index(){
        $this->load->model('ad_model','ad');
        $data = $this->ad->getAd(array('published' => '1'));
        $this->load->view('ad',array('data' => array('title' => 'Fundraisers'), 'ad' => $data));
    }
    
    /**
     * list user ads
     */
    public function userAd(){
        if ($this->session->userdata('user')) {
            $this->load->model('ad_model','ad');
            $userData = $this->session->userdata('user');
            if ($userData['active']) {
                $data = $this->ad->getAd(array('user_id' => $userData['id']));
            } else {
                redirect('/profile');
            }
            $this->load->view('ad',array('data' => array('title' => 'Fundraisers'), 'ad' => $data));
        }
    }
    
    /**
     * Create ad
     * 
     * if $publisher = false save ad but not publish else save and published
     * @param bool $published
     */
    public function create($published = false){
        if($this->session->userdata('user')){
            $userData = $this->session->userdata('user');
            if (! $userData['active']) {
                redirect('/profile');
            }
            $this->load->model('fundraisers_model','fundraisers');
            $this->load->model('ad_model','ad');
            if ($this->input->post()){
                if ($this->validate($this->input->post(), $published)) {
                    $data = $this->input->post();
                    if ($published) {
                        $data['published'] = '1';
                    }
                    $data['user_id'] = $userData['id'];
                    $this->ad->add($data);
                    redirect('/ad/userAd');
                }
            }
            $data['fundraisers'] = $this->fundraisers->getFundraisers();
            $data['data']['title'] = 'Create ad';
            echo link_tag('css/jquery-ui-1.8.23.custom.css');
            //$this->load->view('header', array('data' => array('title' => 'create add')));
            $this->load->view('templates/create-ad', $data);
            //$this->load->view('footer',$data);
        } else {
            redirect('/ad', 'refresh');
        }
    }
    
    /**
     * Displays the selected ad
     * 
     * @param integer $id 
     */
    public function show($id = null){
        if ($id) {
            $this->load->model('ad_model','ad');
            $data = $this->ad->getAd(array('id' => $id));
            if (! $data) {
                redirect('/ad/userAd', 'refresh');
            }
            $transaction = $this->session->userdata('transaction');
            $this->session->unset_userdata('transaction');
            $this->load->view('show-ad',array(
                'data' => array('title' => 'Show'), 
                'ad' => $data,
                'transaction' => $transaction
            ));
        } else {
            redirect('/ad', 'refresh');
        }
    }
    
    /**
     *edit ad
     * 
     * if $publisher = false save ad but not publish else save and published
     * 
     * @param integer $id
     * @param bool $published 
     */
    public function edit($id = null, $published = false){
        if($this->session->userdata('user') && $id){
            $userData = $this->session->userdata('user');
            if (! $userData['active']) {
                redirect('/profile');
            }
            $this->load->model('fundraisers_model','fundraisers');
            $this->load->model('ad_model','ad');
            if ($this->input->post()){
                if ($this->validate($this->input->post(), $published)) {
                    $data = $this->input->post();
                    if ($published) {
                        $data['published'] = '1';
                    } else {
                        $data['published'] = '0';
                    }
                    $userId = $userData['id'];
                    $this->ad->updated($id, $data, $userId);
                    redirect('/ad/userAd');
                }
            }
            $data['fundraisers'] = $this->fundraisers->getFundraisers();
            $data['ad'] = $this->ad->getAd(array('id' => $id, 'user_id' => $userData['id']));
            if (! $data['ad']) {
                redirect('/ad/userAd');
            }
            foreach ($data['ad'] as $values) {
                foreach($values as $key => $value) {
                    $data['ad'][$key] = htmlspecialchars($value);
                }
            }
            echo link_tag('css/jquery-ui-1.8.23.custom.css');
            $data['data']['title'] = 'create add';
            $this->load->view('templates/create-ad', $data);
        } else {
            redirect('/ad');
        }
    }
    
    /**
     *delete ad
     * 
     * @param integer $id 
     */
    public function delete($id){
        if($this->session->userdata('user')){
            $userData = $this->session->userdata('user');
            if (! $userData['active']) {
                redirect('/profile');
            }
            $this->load->model('ad_model','ad');
            $userId = $userData['id'];
            $this->ad->delete($id, $userId);
            redirect('/ad/userAd');
        }
    }
    
    /**
     * validate post data
     * 
     * @param array $data
     * @return bool 
     */
    private function validate($data, $published = false) {
        if ($data["need_raise"] && is_numeric($data["need_raise"])
            && $data["total_cost"] && is_numeric($data["total_cost"])
            && $data["still_need_raise"] && is_numeric($data["still_need_raise"])){
            $response = true;
        } else {
            $response = false;
        }
        if ($published){
            if ($data["id_fundraiser"]
                && $data["date"] && $data["date"] >= date('Y-m-d')
                && $data["description"]
                && $data["meaning"]
                && $response) {
                $response = true;
            } else {
                $response = false;
            }
        }
        return $response;
    }
    
}