<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Formrights_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('formrights_master.*,mm.module_name,fm.form_name,u.login_name');
		$this->db->from($table);
		$this->db->join('form_master as fm','fm.form_id=formrights_master.form_id','LEFT');
		$this->db->join('module_master as mm','mm.module_id=formrights_master.module_id');
		$this->db->join('user_master as u','u.user_id=formrights_master.user_id');
		$this->db->where('formrights_master.company_id', $company);
		$this->db->where('formrights_master.archive<>', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('formrights_master.*,mm.module_name,fm.form_name,u.login_name');
		$this->db->from($table);
		$this->db->join('form_master as fm','fm.form_id=formrights_master.form_id','LEFT');
		$this->db->join('module_master as mm','mm.module_id=formrights_master.module_id');
		$this->db->join('user_master as u','u.user_id=formrights_master.user_id');
		$this->db->where('formrights_master.company_id', $company);
		$this->db->where('formrights_master.archive', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_active_search_records($table,$company,$data){
		$this->db->select('formrights_master.*,mm.module_name,fm.form_name,u.login_name');
		$this->db->from($table);
		$this->db->join('form_master as fm','fm.form_id=formrights_master.form_id','LEFT');
		$this->db->join('module_master as mm','mm.module_id=formrights_master.module_id');
		$this->db->join('user_master as u','u.user_id=formrights_master.user_id');
		$this->db->where('formrights_master.company_id', $company);
		$this->db->where('formrights_master.archive<>', '1');
		$this->db->where('u.archive<>', '1');
		foreach($data as $key => $value) {
			$this->db->like('formrights_master.'.$key.'', $value);
		}
		$query = $this->db->get();
		return $result=$query->result();
	}

}

?>