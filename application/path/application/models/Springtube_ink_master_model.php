<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_ink_master_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->order_by($table.'.dpr_date','desc');
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

	public function select_one_record_for_view($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.company_id', $company);
		//$this->db->where($table.'.archive<>', '1');
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
		$this->db->where($table.'.ink_creation_date>=',$from);
		$this->db->where($table.'.ink_creation_date<=',$to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				if($key=='ink_migration'){
					$this->db->where($key,$value);
				}else{
					$this->db->like($key,$value);
				}
				
			}
		}	

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_no_inks($table,$data){

		$this->db->select("count(ink_id) as inks_count");
		$this->db->from($table);				
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
  		$this->db->group_by('dpr_id');
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function active_record_search_for_jobsetup($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$where='IF( ink_composition =2, mixing_status =1, ink_composition =1 )';	
		$this->db->where($where); 
		if($from!=''&& $to!=''){
			$this->db->where($table.'.ink_creation_date>=',$from);
			$this->db->where($table.'.ink_creation_date<=',$to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>