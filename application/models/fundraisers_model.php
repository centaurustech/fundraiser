<?php

class Fundraisers_model extends CI_Model
{

    protected $_name = 'fundraisers'; 
    
	function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
	}
    
    function getFundraisers($where=null, $limit=null, $offset=null){
        $query = $this->db->get_where($this->_name, $where, $limit, $offset);
        return $query->result_array();
    }
    
}