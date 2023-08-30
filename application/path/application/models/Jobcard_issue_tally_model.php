<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobcard_issue_tally_model extends CI_Model {	

	public function select_active_records($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}	

	public function active_record_search($table,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		if($from!='' && $to!=''){
			$this->db->where('issue_date>=',$from);
			$this->db->where('issue_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				if($key=='jobcard_no'){
					$this->db->like($key,$value);
				}else{
					$this->db->where($key,$value);
				}
				
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
		
}

?>