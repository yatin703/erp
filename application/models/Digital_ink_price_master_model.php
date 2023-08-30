<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Digital_ink_price_master_model extends CI_Model {
		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);		
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('digital_ink_price_master.apply_from_date');
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	



}

?>