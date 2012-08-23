<?php

class Ad_model extends CI_Model
{

    protected $_name = 'ad';
    
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
    
    function getAd($option = null) {
        $this->db->select('ad.*, fundraisers.name');
        $this->db->from($this->_name);
        $this->db->join("fundraisers", "fundraisers.id = {$this->_name}.id_fundraiser", 'left');
        
        if ($option) {
            if (isset($option['id']) && $option['id']) {
                $this->db->where("{$this->_name}.id", $option['id']); 
            }
            if (isset($option['user_id']) && $option['user_id']) {
                $this->db->where("{$this->_name}.user_id", $option['user_id']); 
            }
            if (isset($option['published']) && $option['published']) {
                $this->db->where("{$this->_name}.published", $option['published']); 
            }
        }
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function delete($id, $userId) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $userId);
        $this->db->delete($this->_name); 
    }
    
    function updated($id, $userId, $data) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $userId);
        $this->db->update($this->_name, $data); 
    }

}