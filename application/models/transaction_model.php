<?php

class Transaction_model extends CI_Model
{

    protected $_name = 'transaction';
    
	function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
	}
    
    function add($data)
    {
        $this->db->insert($this->_name, $data);
        return $this->db->insert_id();
    }
}