<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_production_model extends CI_Model {	

	// public function select_active_records($limit,$start,$table,$company){
	// 	$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
	// 	$this->db->from($table);
	// 	//$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>','1');
	// 	$this->db->order_by('production_id','desc');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id','LEFT');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('production_date','desc');
		$this->db->order_by('shift','desc');

		$query = $this->db->get();
		return $result=$query->result();
	}

	// public function select_archive_records($limit,$start,$table,$company){
	// 	$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
	// 	$this->db->from($table);
	// 	//$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive','1');
	// 	$this->db->order_by('production_id','desc');
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('production_date','desc');
		$this->db->order_by('shift','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}	

	

	
	// public function select_one_active_record($table,$company,$pkey,$edit){
	// 	$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
	// 	$this->db->from($table);
	// 	//$this->db->from($table);
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id');
	// 	$this->db->where($table.'.company_id', $company);
	// 	$this->db->where($table.'.archive<>', '1');
	// 	$this->db->where($pkey,$edit);
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $query->result();
	// }

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
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

	// public function select_one_inactive_record($table,$company,$pkey,$edit){
	// 	$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
	// 	$this->db->from($table);
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id');
	// 	$this->db->where($table.'.company_id', $company);
	// 	$this->db->where($table.'.archive', '1');
	// 	$this->db->where($pkey,$edit);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
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

	// public function active_record_search($table,$company,$data,$from,$to){
	// 	$this->db->select($table.'.*,CASE WHEN (`production_time` BETWEEN  "08:00:00" AND "15:59:59")THEN  "1" WHEN (`production_time` BETWEEN  "16:00:00" AND  "23:59:59") THEN "2" WHEN (`production_time` BETWEEN  "00:00:00" AND  "07:59:59" ) THEN  "3" END AS shift, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
	// 	$this->db->from($table);
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id');
	// 	if($from!='' && $to!=''){
	// 		$this->db->where('production_date>=',$from);
	// 		$this->db->where('production_date<=',$to);
	// 	}
	// 	//print_r($data);
	// 	if(!empty($data)){		
	// 		foreach($data as $key => $value) {
	// 			$this->db->like($key,$value);
	// 		}
	// 	}
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>','1');
	// 	$this->db->order_by($table.'.production_id','desc');
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }
	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*, springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
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
		$this->db->order_by($table.'.production_date','desc');
		$this->db->order_by($table.'.shift','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search_consolidated($table,$company,$data,$from,$to){
		$this->db->select($table.'.production_date,details_id,customer,order_no,article_no,jobcard_no,sum(total_meters_produced) as total_meters_produced,sum(total_qc_hold_meters) as total_qc_hold_meters,sum(total_ok_meters) as total_ok_meters, purging_jobcard,sum(total_purging_weight) as total_purging_weight, setup_jobcard_no,sum(total_setup_meters) as total_setup_meters, sum(qc_check) as qc_check') ;
		$this->db->from($table);
		$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		//$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id');
		//$this->db->join('user_master',$table.'.user_id=user_master.user_id');
		if($from!='' && $to!=''){
			$this->db->where($table.'.production_date>=',$from);
			$this->db->where($table.'.production_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->group_by($table.'.production_date');
		$this->db->group_by('springtube_extrusion_production_details.jobcard_no');
		//$this->db->order_by($table.'.production_id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	function get_job_weight_extrusion($jobcard_no,$company_id){

		$this->db->select('SUM(demand_qty) as total_qty');
		$this->db->from('material_manufacturing');
		$this->db->where('company_id',$company_id);
		$this->db->where('manu_order_no',$jobcard_no);
		$this->db->where('work_proc_no','1');
		$this->db->where('manu_order_no',$jobcard_no);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function select_active_records_by_order($table,$company,$data){
		$this->db->select($table.'.*, springtube_extrusion_production_details.*,springtube_process_master.process_name,springtube_machine_master.machine_name,user_master.login_name');
		$this->db->from($table);
		$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id','LEFT');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		//$this->db->limit($limit, $start);
		$this->db->order_by('production_date','desc');
		$this->db->order_by('shift','desc');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}



	public function setup_purging_search_groupby($table,$company,$data,$from,$to){
		
		$this->db->select('year(production_date)year,MONTH(production_date)month_no,MONTHNAME(production_date) month_name,sleeve_dia,total_microns,sum(springtube_extrusion_production_details.total_waste)total_side_trim_waste,sum(springtube_extrusion_production_details.total_setup_weight)total_setup_weight,sum(springtube_extrusion_production_details.total_purging_weight)total_purging_weight');
		 
		$this->db->from($table);
		$this->db->join('springtube_extrusion_production_details',$table.'.production_id=springtube_extrusion_production_details.production_id');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		
		if($from!='' && $to!=''){
			$this->db->where('production_date>=',$from);
			$this->db->where('production_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->group_by("year(production_date)");
		$this->db->group_by("MONTH(production_date)");
		$this->db->group_by("sleeve_dia");
		$this->db->group_by("total_microns");
		// $this->db->group_by("second_layer_mb");
		// $this->db->group_by("sixth_layer_mb");

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	
	}

	public function extrusion_scrap_search_groupby($table,$company,$data,$from,$to){
		$this->db->select('year(scrap_date)year,MONTHNAME(scrap_date) month,sleeve_dia,total_microns,sum(total_scrap_meters)total_scrap_meters,sum(scrap_weight)total_scrap_weight');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		
		if($from!='' && $to!=''){
			$this->db->where('scrap_date>=',$from);
			$this->db->where('scrap_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->group_by("year(scrap_date)");
		$this->db->group_by("MONTH(scrap_date)");
		$this->db->group_by("sleeve_dia");
		$this->db->group_by("total_microns");
		//$this->db->group_by("second_layer_mb");
		//$this->db->group_by("sixth_layer_mb");

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}	


	
		
}

?>