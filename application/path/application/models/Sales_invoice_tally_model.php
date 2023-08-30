<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_tally_model extends CI_Model {	

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
			$this->db->where('invoice_date>=',$from);
			$this->db->where('invoice_date<=',$to);
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