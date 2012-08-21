<?php

require_once "facebook.php";

/**
 * extended Facebook class with some necessary methods
 */
class Richfacebook extends Facebook
{
	/* prefix chars in Codeigniter session  */
	private $_session_prefix = 'facebook';

	/* Codeigniter class instance */
	private $_CI;

	/**
	 * construct Richfacebook object
	 */
	public function __construct() {
		$this->_CI = &get_instance();
		parent::__construct(array('appId' => $this->_CI->config->item('facebook_app_id'), 'secret' => $this->_CI->config->item('facebook_secret')));
	}

	/**
	 * Get long-term access token
	 * @param string $currentAccessToken 
	 * @return array(access_token,exapire) if ok, else return false
	 */
	// public function getExtendedAccessToken1($currentAccessToken = NULL){

	// 	$_REQUEST = $this->_CI->input->get(NULL,TRUE) ? array_merge($this->_CI->input->get(NULL,TRUE),$_REQUEST) : $_REQUEST;

	// 	if($currentAccessToken !== NULL){
	// 		$this->setAccessToken($currentAccessToken);
	// 	}

	// 	$url = "https://graph.facebook.com/oauth/access_token";
	// 	$params = array(
	// 		"client_id"=>$this->getAppId()
	// 		,"client_secret"=>$this->getAppSecret()
	// 		,"grant_type"=>"fb_exchange_token"
	// 		,"fb_exchange_token"=>$this->getAccessToken()
	// 	);

	// 	try {
	// 		$response = $this->makeRequest($url,$params);
	// 	} catch (Exception $e) {
	//     	return false;
	// 	}

	// 	// $error = json_decode($response, true);
	//  //    if(is_array($error) && isset($error['error'])) {
	//  //    	$this->throwAPIException($error);
	//  //    	return false;
	//  //    }

	// 	parse_str($response, $response_params);
	// 	if($response_params['access_token']){
	// 		$this->setAccessToken($response_params['access_token']);
	// 		return $response_params;
	// 	}

	// 	return false;
	// }

	public function getExtendedAccessToken($accessToken = NULL){

		$_REQUEST = $this->_CI->input->get(NULL,TRUE) ? array_merge($this->_CI->input->get(NULL,TRUE),$_REQUEST) : $_REQUEST;

		if($accessToken !== NULL){
			$this->setAccessToken($accessToken);
		}

	    try {
	        // need to circumvent json_decode by calling _oauthRequest
	          // directly, since response isn't JSON format.
	        $access_token_response =
	            $this->_oauthRequest(
	                $this->getUrl('graph', '/oauth/access_token'), array(
	                    'client_id' => $this->getAppId(),
	                    'client_secret' => $this->getAppSecret(),
	                    'grant_type'=>'fb_exchange_token',
	                    'fb_exchange_token'=>$this->getAccessToken()
	                )
	            );
	    } catch (FacebookApiException $e) {
	      // most likely that user very recently revoked authorization.
	      // In any event, we don't have an access token, so say so.
	      return false;
	    }

	    if (empty($access_token_response)) {
	      return false;
	    }

	    $response_params = array();
	    parse_str($access_token_response, $response_params);
	    if (!isset($response_params['access_token'])) {
	      return false;
	    }
	    $this->setAccessToken($response_params['access_token']);
	    return $response_params;
	}


	/**
	 * Remove all CI-session keys with a specific prefix 
	 */
	public function clear_temp_session(){
		foreach ($this->_CI->session->userdata as $key => $value) {
			if(strpos($key,$this->_session_prefix . '_') === 0){
				$this->_CI->session->unset_userdata($key);
			}
		}
	}


	public function getLogoutUrl($params=array()) {
		return $this->getUrl(
			'www',
			'logout.php',
			array_merge(array(
				'next' => $this->getCurrentUrl().'?logoutfrmfb=logout',
				'access_token' => $this->getAccessToken(),
			), $params)
		);
	}

	// /**
	//  * Insert/update CI session item with a specific prefix
	//  * @param string $item_name - name of session item without prefix
	//  * @param any $value - value to be inserted/updated
	//  */
	// public function set_item($item_name,$value = NULL){
	// 	$this->_CI->session->set_userdata($this->_session_prefix . '_' . $item_name,$value);
	// }

	// /**
	//  * Return session item by name
	//  * @param string $item_name - session item name without prefix
	//  * @return any
	//  */
	// public function get_item($item_name){
	// 	return $this->_CI->session->userdata($this->_session_prefix . '_' . $item_name);
	// }

	/**
	 * Check for data, not only for the variables
	 * @param $val 
	 * @return boolean
	 */
	private function _empty($val) { return empty($val); }



	function send($message = ''){
		$this->_CI->load->model('Charity_model','charity');
		$this->_CI->load->model('Brand_model','brand');
		$this->_CI->load->model('Template_model','post_template');
		$this->_CI->load->model('User_model','user');

		// result data array
		$result = array();
		$result['error'] = false;

		// get user
		$user = $this->_CI->session->userdata('user');
		
		// if there is no user session || facebook status not logged in 
		if(!$user || !isset($user['user_id']) || !isset($user['facebook'])){
			// return error 
			$result['message'] = 'Not all required facebook data is received';
			$result['error'] = true;
			return $result;
		}
		
		// try to update FB status
		$params = array(
			'message' => $message
			,'access_token'=>$user['facebook']['token']
		);
		try {
			// result OK
			$post = $this->api('/me/feed','POST',$params);
		} catch (Exception $e) {
			// return error
			$error = $e->getResult();
			$result['error'] = true;
			$result['message'] =  $error['error']['message'];
			return $result;
		}
		
		// collect data for this post
		$result['id'] = $user['facebook']['id'];
		$result['post_id'] = $post['id'];
		$result['likes'] = 0;
		$result['comments'] = 0;

		$params = array(
			'access_token'=>$user['facebook']['token']
		);

		// $_charity = $this->api('/'.$this->_CI->charity->get_charity($this->_CI->session->userdata('charity'))->facebook);
		// $_charity_liked_data = $this->api('/me/likes/'.$_charity['id'],'GET',$params);
		// $result['liked_charity'] = (count($_charity_liked_data['data']) > 0) ? 1 : 0;

		// $_brand = $this->api('/'.$this->_CI->brand->get_brand($this->_CI->session->userdata('brand'))->facebook);
		// $_brand_liked_data = $this->api('/me/likes/'.$_brand['id'],'GET',$params);
		// $result['liked_brand'] = (count($_brand_liked_data['data']) > 0) ? 1 : 0;

		return $result;
	}

	public function makeRequest($url, $params, $ch=null) {
		if (!$ch) {
			$ch = curl_init();
		}

		$opts = self::$CURL_OPTS;
		if ($this->getFileUploadSupport()) {
		$opts[CURLOPT_POSTFIELDS] = $params;
		} else {
		$opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
		}
		$opts[CURLOPT_URL] = $url;

		// disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
		// for 2 seconds if the server does not support this header.
		if (isset($opts[CURLOPT_HTTPHEADER])) {
		$existing_headers = $opts[CURLOPT_HTTPHEADER];
		$existing_headers[] = 'Expect:';
		$opts[CURLOPT_HTTPHEADER] = $existing_headers;
		} else {
		$opts[CURLOPT_HTTPHEADER] = array('Expect:');
		}

		curl_setopt_array($ch, $opts);
		$result = curl_exec($ch);

		if (curl_errno($ch) == 60) { // CURLE_SSL_CACERT
		self::errorLog('Invalid or no certificate authority found, '.
		'using bundled information');
		curl_setopt($ch, CURLOPT_CAINFO,
		dirname(__FILE__) . '/fb_ca_chain_bundle.crt');
		$result = curl_exec($ch);
		}

		if ($result === false) {
			// $e = new FacebookApiException(array(
			// 'error_code' => curl_errno($ch),
			// 'error' => array(
			// 'message' => curl_error($ch),
			// 'type' => 'CurlException',
			// ),
			// ));
			// curl_close($ch);
			// throw $e;
		}
		curl_close($ch);
		return $result;
	}

	function liked($object = ''){
		if($this->_CI->input->post('object')){
			$object = $this->_CI->input->post('object');
		}

		if($object != 'brand' && $object != 'charity'){
			return false;
		}


		$user = $this->_CI->session->userdata('user');

		if(!isset($user['facebook']['token'])){
			return false;
		}

		$this->_CI->load->model(ucfirst($object).'_model',$object);

		//$object_facebook = $this->api('/'. $this->_CI->{$object}->{'get_'.$object}($this->_CI->session->userdata($object))->facebook);

		$object_facebook = false;

		if($object == 'brand' && $this->_CI->session->userdata('brand')){
			$this->_CI->load->model('Brand_model','brand');
			$object_facebook = $this->api('/'.$this->_CI->brand->get_brand($this->_CI->session->userdata('brand'))->facebook);
		}else if($object == 'charity' && $this->_CI->session->userdata('charity')){
			$this->_CI->load->model('Charity_model','charity');
			$object_facebook = $this->api('/'.$this->_CI->charity->get_charity($this->_CI->session->userdata('charity'))->facebook);
		}

		if($object_facebook == false || isset($object_facebook['error'])){
			return false;
		}

		$params['access_token'] = $user['facebook']['token'];

		$result = $this->_CI->db->get_where('likes',array('user_id'=>$user['user_id'],'id'=>$user['facebook']['id'],'object_type'=>$object,'object_id'=>$this->_CI->session->userdata($object)));

		//return  $result->row();
		//return array('user_id'=>$user['user_id'],'id'=>$user['facebook']['id'],'object_type'=>$object,'object_id'=>$this->_CI->session->userdata($object));

		if($result->num_rows() == 0){
			return false;
		}else{
			$action_id = $result->row()->action_id;
			//return $action_id;
			if($action_id){
				try {	
					$liked_data = $this->api("/".$action_id,'GET',$params);
					//return $liked_data;
				} catch (Exception $e) {
					//return $e;
					return false;
				}

				if(!$liked_data || isset($liked_data['error'])){
					return false;
				}else if($liked_data && isset($liked_data['from']['id']) && $liked_data['from']['id'] == $user['facebook']['id']){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

	}

}