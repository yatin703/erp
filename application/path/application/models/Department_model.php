<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

	
	public function select_active_drop_down($table,$language_id){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('language_id',$language_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record($table,$pkey,$edit,$language_id){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey, $edit);
		$this->db->where($table.'.language_id', $language_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}

	public function select_active_records($limit,$start,$table,$language_id){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.language_id',$language_id);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.department_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$language_id){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.language_id',$language_id);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.department_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$language_id){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.language_id',$language_id);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function update_one_active_record_noncompany($table,$data,$pkey,$edit,$language_id){
		$this->db->where($pkey, $edit);
		$this->db->where('language_id', $language_id);
		$result=$this->db->update($table,$data);

		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}
	
}

?>