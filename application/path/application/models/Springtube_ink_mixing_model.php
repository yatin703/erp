<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_ink_mixing_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('springtube_ink_master.archive<>', '1');
		$this->db->where('springtube_ink_master.company_id',$company);
		//$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('springtube_ink_master.archive<>', '1');
		$this->db->where('springtube_ink_master.company_id',$company);
		//$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');		
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('springtube_ink_master.archive<>', '1');
		$this->db->where('springtube_ink_master.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');		 
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where('springtube_ink_master.archive<>', '1');
		$this->db->where('springtube_ink_master.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_details_records($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');
		//$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	  
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}


	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('springtube_ink_master',$table.'.ink_id=springtube_ink_master.ink_id','LEFT');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('springtube_ink_master.archive<>', '1');
		$this->db->where('springtube_ink_master.company_id',$company);
		if($from!=''&& $to!=''){
		$this->db->where($table.'.ink_mixing_date>=',$from);
		$this->db->where($table.'.ink_mixing_date<=',$to);
		}
		foreach($data as $key => $value) {
			$this->db->like('springtube_ink_master.'.$key,$value);
		}	
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}


}

?>