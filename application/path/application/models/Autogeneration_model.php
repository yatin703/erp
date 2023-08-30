<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Autogeneration_model extends CI_Model {

	public function select_active_records($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$query = $this->db->get();
		return $result=$query->result();
	}
	
	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('form_master.*,module_master.module_name,fm.form_name as parent');
		$this->db->from($table);
		$this->db->join('module_master','form_master.module_id=module_master.module_id','LEFT');
		$this->db->join('form_master as fm','fm.form_id=form_master.parent_form_id','LEFT');
		$this->db->where('form_master.archive','1');
		$this->db->where('form_master.company_id',$company);
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function active_record_search($table,$data,$company){
		$this->db->select('form_master.*,module_master.module_name,fm.form_name as parent');
		$this->db->from($table);
		$this->db->join('module_master','form_master.module_id=module_master.module_id','LEFT');
		$this->db->join('form_master as fm','fm.form_id=form_master.parent_form_id','LEFT');
		$this->db->where('form_master.archive<>','1');
		$this->db->where('form_master.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like('form_master.'.$key, $value,'after');
		}
		
		$query = $this->db->get();
		return $result=$query->result();
	}

}

?>