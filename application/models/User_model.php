<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,user_level_master.level_code_desc,employee_master.name1,employee_master.name2');
		$this->db->from($table);
		$this->db->join('user_level_master',$table.'.user_level=user_level_master.level_code','LEFT');
		$this->db->join('employee_master',$table.'.employee_id=employee_master.employee_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.user_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,user_level_master.level_code_desc,employee_master.name1,employee_master.name2');
		$this->db->from($table);
		$this->db->join('user_level_master',$table.'.user_level=user_level_master.level_code','LEFT');
		$this->db->join('employee_master',$table.'.employee_id=employee_master.employee_id','LEFT');
		$this->db->where($table.'.archive<>', '0');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.user_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,user_level_master.level_code_desc,employee_master.name1,employee_master.name2');
		$this->db->from($table);
		$this->db->join('user_level_master',$table.'.user_level=user_level_master.level_code','LEFT');
		$this->db->join('employee_master',$table.'.employee_id=employee_master.employee_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($table.'.'.$key,$value,'after');
		}
	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>