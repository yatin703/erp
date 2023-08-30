<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Packing_material_consumption_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('packing_category_master',$table.'.packing_category_id=packing_category_master.pcm_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->order_by($table.'.apply_from_date','desc');
		//$this->db->order_by('packing_category_master.packing_category');
		$this->db->order_by('pmcm_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('packing_category_master',$table.'.packing_category_id=packing_category_master.pcm_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.from_date');
		$this->db->order_by('packing_category_master.packing_category');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('packing_category_master',$table.'.packing_category_id=packing_category_master.pcm_id');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('packing_category_master.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->order_by($table.'.from_date');
		$this->db->order_by('packing_category_master.packing_category');	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>