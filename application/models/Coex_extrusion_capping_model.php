<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_capping_model extends CI_Model {
    
    public function select_active_records_lists($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->group_by($table.'.order_no');
		$this->db->order_by('coex_extrusion_capping.capping_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_capping.capping_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}
}