<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_tally_model extends CI_Model {	

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
			//$this->db->where('transaction_date>=',$from);//order_date
			//$this->db->where('transaction_date<=',$to);
			$this->db->where('order_date>=',$from);//order_date
			$this->db->where('order_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by('order_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
		
}

?>