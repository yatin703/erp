<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_bodymaking_production_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		//$this->db->join('springtube_bodymaking_production_details',$table.'.production_id=springtube_bodymaking_production_details.production_id');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->order_by('production_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		//$this->db->join('springtube_bodymaking_production_details',$table.'.production_id=springtube_bodymaking_production_details.production_id');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->order_by('production_id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}	

	

	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		//$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id', $company);
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
	    $this->db->where($table.'.company_id','000020');
		$this->db->where($table.'.archive<>', '1');
		$this->db->order_by('job_pos_no');	 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function inactive_details_records($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->where($table.'.company_id','000020');
		$this->db->where($table.'.archive', '1');	 
		$query = $this->db->get();
		return $result=$query->result();
		
	}

	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		if($from!='' && $to!=''){
			$this->db->where('production_date>=',$from);
			$this->db->where('production_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->order_by($table.'.production_id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	
		
}

?>