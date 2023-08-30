<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_bodymaking_control_plan_qc_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*, springtube_machine_master.machine_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		//$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->order_by('cp_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*, springtube_machine_master.machine_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->order_by('cp_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}	

	

	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, springtube_machine_master.machine_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, springtube_machine_master.machine_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function active_details_records($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }	 
		$query = $this->db->get();
		return $result=$query->result();
		
	}

	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*, springtube_machine_master.machine_name');
		$this->db->from($table);
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		if($from!='' && $to!=''){
			$this->db->where('inspection_date>=',$from);
			$this->db->where('inspection_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	
		
}

?>