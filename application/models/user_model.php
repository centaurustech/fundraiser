<?php

class User_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
	}

	function validate_auth($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}
		return $this->db->get_where('users',array('email'=>$email,'password'=>md5($password)))->num_rows() == 1;
	}

	function is_user($email=null){
		if(!$email){
			return false;
		}
		return $this->db->get_where('users',array('email'=>$email))->num_rows() == 1;
	}

	function get_user($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}
		$this->db->select(array('email','firstname','lastname','avatar','facebook_access_token','activation_code','active'));
		return $this->db->get_where('users',array('email'=>$email,'password'=>md5($password)))->row_array();
	}

	function get_facebook_user($token=null){
		if(!$token){
			return false;
		}
		$this->db->select(array('email','firstname','lastname','avatar','facebook_access_token','activation_code','active'));
		$result = $this->db->get_where('users',array('facebook_access_token'=>$token));
		return $result->num_rows() > 0 ? $result->row_array() : false;
	}

	function register($fname=null,$lname=null,$email=null,$password=null){
		if(!$fname || !$lname || !$email || !$password){
			return false;
		}

		$this->load->helper('email');
		if(!valid_email($email)){
			return false;
		}

		if($this->db->get_where('users',array('email'=>$email))->num_rows() > 0){
			return false;
		}

		if($this->db->insert('users',array(
			'email'=>$email
			,'firstname'=>$fname
			,'lastname'=>$lname
			,'password'=>md5($password)
			,'activation_code'=>md5($email.microtime())
		))){
			return $this->get_user($email,$password);
		}
		return false;
	}

	function register_facebook($fname=null,$lname=null,$email=null,$token=null,$avatar=''){
		if(!$fname || !$lname || !$email || !$token){
			return false;
		}
		$this->load->helper('email');
		if(!valid_email($email)){
			return false;
		}
		if($this->db->get_where('users',array('email'=>$email))->num_rows() > 0){
			return false;
		}
		if($this->db->get_where('users',array('facebook_access_token'=>$token))->num_rows() > 0){
			return false;
		}
		if($this->db->insert('users',array(
			'email'=>$email
			,'firstname'=>$fname
			,'lastname'=>$lname
			,'facebook_access_token'=>$token
			,'avatar'=>$avatar
			,'activation_code'=>md5($email.microtime())
		))){
			return $this->get_facebook_user($token);
		}
		return false;
	}

	function activation_email($code=null){
		if(!$code){
			return result(0);
		}

		if($this->db->get_where('users',array('activation_code'=>$code))->num_rows() != 1){
			return result(1202);
		}	

		if($this->db->update('users',array('active'=>1),array('activation_code'=>$code,'active'=>0))){
			return result(1299);
		}

		if($this->db->get_where('users',array('activation_code'=>$code,'active'=>'1'))->num_rows() > 0){
			return result(1201);
		}

		return result(1203);
	}

}