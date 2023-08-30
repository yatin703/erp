<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Combination_model extends CI_Model {

	public function select_shoulder_active_record($table,$company,$pkey,$edit){
		$this->db->select('distinct(shoulder_orifice_dependancy.shld_type_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,shoulder_types_master.shoulder_type');
		$this->db->from($table);
		$this->db->join('shoulder_types_master',$table.'.shld_type_id=shoulder_types_master.shld_type_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_sleeve_dia_active_record($table,$company,$pkey,$edit){
		$this->db->select('distinct(shoulder_orifice_dependancy.sleeve_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,sleeve_diameter_master.sleeve_diameter');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_shoulder_orifice_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select('distinct(shoulder_orifice_dependancy.shld_orifice_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,shoulder_orifice_master.shoulder_orifice');
		$this->db->from($table);
		$this->db->join('shoulder_orifice_master',$table.'.shld_orifice_id=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where('shoulder_orifice_dependancy.shld_orifice_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_cap_type_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_type_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_types_master.cap_type');
		$this->db->from($table);
		$this->db->join('cap_types_master',$table.'.cap_type_id=cap_types_master.cap_type_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where('shoulder_orifice_dependancy.cap_type_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_cap_finish_active_record($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_finish_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_finish_master.cap_finish');
		$this->db->from($table);
		$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where('shoulder_orifice_dependancy.cap_finish_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_cap_dia_active_record($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4,$pkey5,$edit5){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_dia_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_diameter_master.cap_dia');
		$this->db->from($table);
		$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where($pkey4,$edit4);
		$this->db->where('shoulder_orifice_dependancy.cap_dia_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_cap_orifice_active_record($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4,$pkey5,$edit5,$pkey6,$edit6){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_dia_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_orifice_master.cap_orifice');
		$this->db->from($table);
		$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where($pkey4,$edit4);
		$this->db->where($pkey5,$edit5);
		$this->db->where('shoulder_orifice_dependancy.cap_orifice_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}



	public function select_spec_cap_finish_active_record($table,$company,$pkey,$edit){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_finish_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_finish_master.cap_finish');
		$this->db->from($table);
		$this->db->join('cap_finish_master',$table.'.cap_finish_id=cap_finish_master.cap_finish_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where('shoulder_orifice_dependancy.cap_finish_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_spec_cap_dia_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_dia_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_diameter_master.cap_dia');
		$this->db->from($table);
		$this->db->join('cap_diameter_master',$table.'.cap_dia_id=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where('shoulder_orifice_dependancy.cap_dia_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_spec_cap_orifice_active_record($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3){
		$this->db->select('distinct(shoulder_orifice_dependancy.cap_orifice_id),shoulder_orifice_dependancy.archive,shoulder_orifice_dependancy.company_id,cap_orifice_master.cap_orifice');
		$this->db->from($table);
		$this->db->join('cap_orifice_master',$table.'.cap_orifice_id=cap_orifice_master.cap_orifice_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where('shoulder_orifice_dependancy.cap_orifice_id<>','');
		$query = $this->db->get();
		return $result=$query->result();
	}

	
}
?>