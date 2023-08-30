<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_jobsetup_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.job_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.jobsetup_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		 
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if($from!=''&& $to!=''){
		$this->db->where($table.'.jobsetup_date>=',$from);
		$this->db->where($table.'.jobsetup_date<=',$to);
		}
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}

	// public function select_no_plates($table,$data){

	// 	$this->db->select("IFNULL(SUM(no_of_plates),0) as flexo");
	// 	$this->db->from($table);				
	// 	if(!empty($data)){
	// 		foreach($data as $key => $value) {
	// 			$this->db->where(''.$table.'.'.$key.'', $value);
	// 		}
	//     }
 //  		$this->db->group_by('dpr_id');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();

	// }
	



}

?>