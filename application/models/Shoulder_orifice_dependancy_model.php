<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoulder_orifice_dependancy_model extends CI_Model {

 	public function select_active_records($limit,$start,$table,$company){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('shoulder_types_master',$table.'.shld_type_id=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shld_orifice_id=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type_id=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->order_by($table.'.sod_id');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}
	public function select_one_active_record($table,$company,$pkey,$edit){

	$this->db->select('*');
	$this->db->from($table);
	$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
	$this->db->join('shoulder_types_master',$table.'.shld_type_id=shoulder_types_master.shld_type_id','LEFT');
	$this->db->join('shoulder_orifice_master',$table.'.shld_orifice_id=shoulder_orifice_master.orifice_id','LEFT');
	$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
	$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
	$this->db->join('cap_types_master',$table.'.cap_type_id=cap_types_master.cap_type_id','LEFT');
	$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
	$this->db->where($table.'.company_id', $company);
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.'.$pkey, $edit);
	$query = $this->db->get();
	return $result=$query->result();

}

	public function select_archive_records($limit,$start,$table,$company){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('shoulder_types_master',$table.'.shld_type_id=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shld_orifice_id=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type_id=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->order_by($table.'.sod_id');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}


 	public function active_record_search(/*$limit,$start,*/$table,$data,$company){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('shoulder_types_master',$table.'.shld_type_id=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shld_orifice_id=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type_id=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		foreach($data as $key=> $value){

			$this->db->like($table.'.'.$key, $value,'after');

		}
		$this->db->order_by($table.'.sod_id');
		//$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}


	public function select_one_active_combination_record($table,$company,$data){

	$this->db->select('*');
	$this->db->from($table);
	$this->db->where('company_id', $company);	
	foreach($data as $key=> $value){
		$this->db->where($key, $value);
	}
	$this->db->where('archive<>', '1');
	$count = $this->db->count_all_results();
	//echo $this->db->last_query();
	return $count;

}
	
}
?>