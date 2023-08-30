<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_planning_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id',$company);
		$this->db->where('archive<>','1');		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}	

	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		if($from!='' && $to!=''){
			$this->db->where('planning_from_date>=',$from);
			$this->db->where('planning_to_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_last_record($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id',$company);
		$this->db->where('archive<>','1');
		$this->db->order_by('sort_order','desc');		
		$this->db->limit('1', '0');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_pending_records($table,$company,$order_by,$sort){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id',$company);
		$this->db->where('archive<>','1');
		$this->db->where('prod_completed<>','1');		
		if($order_by!=''){
			$this->db->order_by($order_by,($sort!=''?$sort:'asc'));	
		}
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
	
		
}

?>