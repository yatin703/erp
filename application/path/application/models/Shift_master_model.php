<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_master_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);		
		
		
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where('coex_machine_master.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company,$from,$to){
		$this->db->select($table.'.*,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		if($from!='' && $to!=''){
			$this->db->where('shift_start_date>=',$from);
			$this->db->where('shift_start_date<=',$to);
		}

		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		

		//$this->db->where('archive<>','1');
		//$this->db->where('company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}

	
		
}

?>