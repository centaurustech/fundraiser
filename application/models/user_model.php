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

	function get_user($email=null,$password=null){
		if(!$email || !$password){
			return false;
		}
		return $this->db->get_where('users',array('email'=>$email,'password'=>md5($password)))->row();
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

	function confirm_email($code=null){
		if(!$code){
			return false;
		}

		$this->db->update('users',array('active'=>1),array('activation_code'=>$code,'active'=>'0'));

		return $this->db->affected_rows() == 1;
	}

}