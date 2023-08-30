<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_rm_mixing_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_rm_mixing.cerm_id desc');
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


	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.mixing_date >=', $from);
		$this->db->where(''.$table.'.mixing_date <=', $to);
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->order_by('coex_extrusion_rm_mixing.cerm_id desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_rm_sum_record($table,$company,$jobcard_no,$material_code){
		$query=$this->db->query("select sum(qty_mixed) as total_mixed from coex_extrusion_rm_mixing_details where jobcard_no='".$jobcard_no."' and material_code='".$material_code."' and archive<>1 and company_id='".$company."'");
		return $result=$query->result();
	}

	public function select_total_rm_sum_record($table,$company,$jobcard_no,$cerm_id){
		$query=$this->db->query("select sum(qty_mixed) as total_mixed from coex_extrusion_rm_mixing_details where jobcard_no='".$jobcard_no."' AND cerm_id='".$cerm_id."'  and archive<>1 and company_id='".$company."'");
		return $result=$query->result();
	}

}
?>