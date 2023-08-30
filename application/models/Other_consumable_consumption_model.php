<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_consumable_consumption_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('consumable_category_master',$table.'.consumable_category_id=consumable_category_master.ccm_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('consumable_category_master.consumable_category');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('consumable_category_master',$table.'.consumable_category_id=consumable_category_master.ccm_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('consumable_category_master.consumable_category');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('consumable_category_master',$table.'.consumable_category_id=consumable_category_master.ccm_id');
		$this->db->where($table.'.archive<>','1');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('consumable_category_master.consumable_category');	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>