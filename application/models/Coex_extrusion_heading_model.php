<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_heading_model extends CI_Model {
    
    public function select_active_records_list($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_heading.ce_heading_id desc');
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
		$this->db->order_by('coex_extrusion_heading.ce_heading_id desc');
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

	public function select_one_active_record_heading($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_records_heading_qc($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_heading_qc.hqc_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_heading_wip($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_heading_wip.hwip_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_heading_scrap($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_heading_scrap.hsr_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record_hold($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record_wip($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	
}