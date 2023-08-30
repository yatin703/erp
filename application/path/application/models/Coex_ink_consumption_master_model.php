<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_ink_consumption_master_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->order_by('cicm_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

}
?>