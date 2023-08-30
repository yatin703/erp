<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_wip_scrap_model extends CI_Model {

public function select_active_records_wip($limit,$start,$table,$company){
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.scrap_qty<>','0');
	$this->db->order_by($table.'.wip_scrap_id','desc');
	$this->db->limit($limit, $start);
	$query = $this->db->get();
	return $result=$query->result();
}

public function select_one_active_record_wip_scrap($table,$company,$pkey,$edit){
	$this->db->select('*');
	$this->db->from($table);
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.archive<>','1');
	$this->db->where($pkey,$edit);
	$query = $this->db->get();
	return $query->result();
}


public function active_record_search_in($table,$company,$data,$from,$to,$release_from,$release_to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		$this->db->where($table.'.scrap_qty<>','0');
		$this->db->order_by($table.'.wip_scrap_id desc');
		$this->db->where($table.'.status','0');
		
	    if($from!='' && $to!=''){
			$this->db->where('created_date>=',$from);
			$this->db->where('created_date<=',$to);
		}

		$query = $this->db->get();
		return $result=$query->result();
	}

}