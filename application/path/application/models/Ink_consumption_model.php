<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ink_consumption_model extends CI_Model {
		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('lacquer_types_master',$table.'.lacquer_type_id=lacquer_types_master.lacquer_type_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('lacquer_types_master.archive<>', '1');
		$this->db->where($table.'.company_id',$company);		
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('lacquer_types_master.lacquer_type');
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('lacquer_types_master',$table.'.lacquer_type_id=lacquer_types_master.lacquer_type_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where('lacquer_types_master.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('lacquer_types_master.lacquer_type');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data,$search){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('lacquer_types_master',$table.'.lacquer_type_id=lacquer_types_master.lacquer_type_id');
		$this->db->where($table.'.archive<>','1');
		$this->db->where('lacquer_types_master.archive<>', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value,'after');
			}
		}
		if(!empty($search)){
			$this->db->where_in('lacquer_types_master.lacquer_type_id',$search);
		}
		$this->db->order_by($table.'.apply_from_date','desc');
		$this->db->order_by('lacquer_types_master.lacquer_type');	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>