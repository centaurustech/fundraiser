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
		return $this->db->get_where('users',array('email'=>$email,'password != '=>''))->num_rows() == 1;
	}

	function get_user($email=null,$password=null){
		if($email || $password){
			$this->db->select(array('id','password','email','firstname','lastname','avatar','facebook_access_token','activation_code','active'));
			return $this->db->get_where('users',array('email'=>$email,'password'=>md5($password)))->row_array();
		}else{
			if($this->session->userdata('user')){
				$user = $this->session->userdata('user');
				$fresh_user = $this->db->get_where('users',array('email'=>$user['email']))->row_array();
				if($fresh_user['password']){
					$fresh_user['password'] = true;
				}else{
					$fresh_user['password'] = false;
				}
				//$this->session->set_userdata('user',$fresh_user);
				return $fresh_user;
			}
			return false;
		}
	}

	function get_facebook_user($token=null){
		if(!$token){
			return false;
		}
		$this->db->select(array('password','email','firstname','lastname','avatar','facebook_access_token','activation_code','active'));
		$result = $this->db->get_where('users',array('facebook_access_token'=>$token));
		if($result->num_rows() > 0){
			$user = $result->row_array();
			if($user['password']){
				$user['password'] = true;
			}else{
				$user['password'] = false;
			}
			//$this->session->set_userdata('user',$user);
			return $user;
		}else{
			return false;
		}
	}

	function register($fname=null,$lname=null,$email=null,$password=null){
		if(!$fname || !$lname || !$email || !$password){
			return false;
		}

		$this->load->helper('email');
		if(!valid_email($email)){
			return false;
		}

		$result = $this->db->get_where('users',array('email'=>$email));
		if($result->num_rows() > 0){
			if($result->row()->password == "" && $result->row()->facebook_access_token != ""){
				// update FB account with new password
				if($this->db->update('users',array('password'=>md5($password)),array('email'=>$email))){
					return $this->get_user($email,$password);
				}
				return false;
			}else{
				// error. email already registered
				return false;
			}
		}


		// if($this->db->get_where('users',array('email'=>$email,'password'=>'','facebook_access_token != '=>''))->num_rows() > 0){
		// 	return false;
		// }

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

	function email_activation($code=null){
		if(!$code){
			return result(0);
		}

		$result = $this->db->get_where('users',array('activation_code'=>$code));

		if($result->num_rows() == 1){

			$row = $result->row();

			if($row->active == 1){
				return result(1201); // already activated
			}else{
				$this->db->update('users',array('active'=>1),array('activation_code'=>$code,'active'=>0)); // activate
				if($this->db->affected_rows() > 0){
					return result(1299); // activate complete
				}else{
					return result(1203); // activate failed
				}
			}

		}
		return result(1202);
	}

}