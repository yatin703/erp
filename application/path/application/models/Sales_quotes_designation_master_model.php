<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quotes_designation_master_model extends CI_Model {
		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);		
		
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	



}

?>