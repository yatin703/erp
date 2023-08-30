<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_production_consolidated_report_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.manu_plan_date','desc');
		$this->db->order_by($table.'.manu_order_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	// public function select_archive_records($limit,$start,$table,$company){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.archive', '1');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->limit($limit, $start);
	// 	$this->db->order_by($table.'.manu_plan_date','desc');
	// 	$this->db->order_by($table.'.manu_order_no','desc');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }	
	 
	// public function active_record_search($table,$data,$from,$to,$company){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->join('order_master',$table.'.sales_ord_no=order_master.order_no','LEFT');
	// 	$this->db->where($table.'.archive<>', '1');
	// 	$this->db->where($table.'.company_id',$company);
	// 	if(!empty($from) && !empty($to)){
	// 		$this->db->where(''.$table.'.manu_plan_date >=', $from);
	// 		$this->db->where(''.$table.'.manu_plan_date <=', $to);
	// 	}
	// 	foreach($data as $key => $value) {
	// 		$this->db->where($key,$value);
	// 	}
	// 	$this->db->order_by($table.'.manu_plan_date','desc');
	// 	$this->db->order_by($table.'.manu_order_no','desc');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }

	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.order_flag','1');
		$this->db->where($table.'.final_approval_flag','1');
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->order_by($table.'.order_date','desc');
		//$this->db->order_by($table.'.manu_order_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


}
