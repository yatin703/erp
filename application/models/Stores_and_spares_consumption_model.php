<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stores_and_spares_consumption_model extends CI_Model {
		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);		
		$this->db->order_by($table.'.from_date','desc');
		//$this->db->order_by($table.'.stores_and_spares_category_id','asc');
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);		
		$this->db->order_by($table.'.from_date','desc');
		//$this->db->order_by($table.'.stores_and_spares_category_id','asc');
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}		
		$this->db->order_by($table.'.from_date','desc');		
		
		$query = $this->db->get();
		return $result=$query->result();
	}


	
	



}

?>