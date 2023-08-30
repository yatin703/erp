<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_printing_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.cp_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_qc_control_plan.ceqcp_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_machine_start($table,$company,$data,$group_by,$order_by,$limit,$start){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

	    if(!empty($group_by)){
				$this->db->group_by($group_by);
			
	    }

	    if(!empty($order_by)){
				$this->db->order_by('CAST('.$table.'.'.$order_by.' as unsigned)','desc');
			
	    }	    
	    $this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_runtime_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('coex_machine_master.process_id','3');
		$this->db->order_by($table.'.cmr_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_downtime_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('coex_machine_master.process_id','3');
		$this->db->order_by($table.'.cmd_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where(''.$table.'.extrusion_date >=', $from);
		$this->db->where(''.$table.'.extrusion_date <=', $to);
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

}
?>