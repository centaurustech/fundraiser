<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {
    
    function __construct() {
		parent::__construct();
        $this->load->library('anet_php_sdk/AuthorizeNetException.php');
		error_reporting(E_ALL);
	} 
    
    public function gift() {
        if ($this->input->post() && $this->validate($this->input->post())) {
            $this->load->model('ad_model','ad');
            if($ad = $this->ad->getAd(array('id' => $this->input->post('ad_id')))){
                if(! $this->input->post('name')) {
                    $_POST['name'] = 'Anonymous';
                }
                $response = $this->processTransaction();
                if(! $response['error']) {
                    $this->load->model('transaction_model','transaction');
                    $transactionData['transaction_id'] = $response['transaction_id'];
                    $transactionData['ad_id']          = $this->input->post('ad_id');
                    $transactionData['amount']         = $this->input->post('amount');
                    $transactionData['name']           = $this->input->post('name');
                    $this->transaction->add($transactionData);
                    
                    $this->load->model('ad_model','ad');
                    $ad['0']['still_need_raise'] += $this->input->post('amount');
                    $this->ad->updated($ad['0']['id'], array('still_need_raise' => $ad['0']['still_need_raise']));
                }
                $this->load->view('transaction', array(
                    'data' => array('title' => 'transaction'), 
                    'transaction' => $response,
                    'ad_id' => $this->input->post('ad_id')
                ));
            } else {
                die('error');
                redirect('/ad', 'refresh');
            }
        } else {
            redirect('/ad', 'refresh');
        }
    }
    
    private function validate($data = null) {
        if (preg_match('/^[0-9]{13,20}$/', $data['card_num'])
            && preg_match('/^(0[1-9])|(1[0-2])\/([0-3][0-9])$/', $data['exp_date'])
            && preg_match('/^[0-9]{3}$/', $data['card_code'])
            && is_numeric($data['amount'])
            && $data['ad_id']) {
            return true;
        } else {
            return false;
        }
    }
    
    private function processTransaction() {
        $this->config->load('transaction');
        $transaction = new AuthorizeNetAIM($this->config->item('authorizenet_api_login_id'), $this->config->item('authorizenet_transaction_key'));
        $transaction->setSandbox($this->config->item('authorizenet_sandbox'));
        $transaction->first_name = $this->input->post('name');
        $transaction->amount     = $this->input->post('amount');
        $transaction->card_num   = $this->input->post('card_num');
        $transaction->exp_date   = $this->input->post('exp_date');
        $transaction->card_code  = $this->input->post('card_code');

        $response = $transaction->authorizeAndCapture();

        if ($response->approved) {
          return array(
              'error' => false, 
              'transaction_id' => $response->transaction_id
          );
        } else {
          return array(
              'error' => true, 
              'response_code' => $response->response_code, 
              'response_reason_code' => $response->response_reason_code, 
              'response_reason_text' => $response->response_reason_text
          );
        }
    }
    
}