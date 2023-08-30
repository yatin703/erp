<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_machine_master_model extends CI_Model {	

	

	public function select_active_records($limit,$start,$table,$company){
		
		$this->db->select('machine_id ,machine_name,machine_capacity,machine_capacity_per_minute,speed,tool_changeover,job_changeover,workprocedure_types_master.lang_description,process_id,coex_machine_master.archive');
		//$this->db->select('*');
		$this->db->from($table);

		$this->db->join('workprocedure_types_master',$table.'.process_id=workprocedure_types_master.work_proc_type_id','LEFT');

		$this->db->where($table.'.archive<>', '1');
		$this->db->where('workprocedure_types_master.archive<>', '1');


		$this->db->where($table.'.company_id',$company);
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('workprocedure_types_master',$table.'.process_id=workprocedure_types_master.work_proc_type_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where('workprocedure_types_master.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$search){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('workprocedure_types_master',$table.'.process_id=workprocedure_types_master.work_proc_type_id');
		$this->db->where($table.'.archive<>','1');
		$this->db->where('workprocedure_types_master.archive<>', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value,'after');
			}
		}
		
			
		$query = $this->db->get();
		return $result=$query->result();
	}
			
}

?>