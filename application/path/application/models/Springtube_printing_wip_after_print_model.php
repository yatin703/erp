<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_wip_after_print_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.status','0');
		$this->db->order_by('aprint_wip_id','desc');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($table.'.status','0');
		$this->db->order_by('aprint_wip_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}	

	

	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('aprint_wip_date>=',$from);
			$this->db->where('aprint_wip_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search_wip($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);		 
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		
		if($from!='' && $to!=''){
			$this->db->where('aprint_wip_date>=',$from);
			$this->db->where('aprint_wip_date<=',$to);
			$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
			$this->db->where($where);
		}

		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	
	
		
}

?>