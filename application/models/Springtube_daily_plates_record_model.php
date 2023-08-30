<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_daily_plates_record_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('graphics_plate_making_reasons',$table.'.plate_making_reason=graphics_plate_making_reasons.reason_id','LEFT');
		//$this->db->join('graphics_operator_master',$table.'.operator_id=graphics_operator_master.operator_id','LEFT');
		//$this->db->join('graphics_machine_master',$table.'.machine_id=graphics_machine_master.machine_id','LEFT');
		$this->db->join('graphics_shift_master',$table.'.shift_id=graphics_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('graphics_plate_making_reasons',$table.'.plate_making_reason=graphics_plate_making_reasons.reason_id','LEFT');
		//$this->db->join('graphics_operator_master',$table.'.operator_id=graphics_operator_master.operator_id','LEFT');
		//$this->db->join('graphics_machine_master',$table.'.machine_id=graphics_machine_master.machine_id','LEFT');
		$this->db->join('graphics_shift_master',$table.'.shift_id=graphics_shift_master.shift_id','LEFT');
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
		$this->db->where($table.'.dpr_date>=',$from);
		$this->db->where($table.'.dpr_date<=',$to);
		}
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_no_plates($table,$data){

		$this->db->select("IFNULL(SUM(no_of_plates),0) as flexo");
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
	



}

?>