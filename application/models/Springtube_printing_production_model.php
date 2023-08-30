<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_production_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('production_date,shift,user_id');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->group_by('production_date,shift');
		$this->db->order_by('production_date','desc');
		$this->db->order_by('shift','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('production_date,shift');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->group_by('production_date,shift');
		$this->db->order_by('production_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	public function select_active_shiftwise_master_records($table,$data,$company){
		$this->db->select($table.'.*,springtube_machine_master.machine_name,user_master.login_name,springtube_printing_jobtype_master.job_type,springtube_shift_issues_master.shift_issue,production_master.inspection_done,springtube_printing_jobsetup_master.jobcard_no as job_setup');
		$this->db->from($table);		
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
		$this->db->join('springtube_shift_issues_master',$table.'.shift_issues=springtube_shift_issues_master.shift_issue_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('production_master',$table.'.jobcard_no=production_master.mp_pos_no','LEFT');
		$this->db->join('springtube_printing_jobsetup_master',$table.'.jobcard_no=springtube_printing_jobsetup_master.jobcard_no','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				if($key=='springtube_printing_jobsetup_master.jobcard_no'){
					$this->db->where('springtube_printing_jobsetup_master.jobcard_no '.$value);
				}else{
					$this->db->where($key, $value);
				}
				
			}
	    }
	    $this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where('production_master.archive','0');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}
	public function select_inactive_shiftwise_master_records($table,$data,$company){
		$this->db->select($table.'.*,springtube_machine_master.machine_name,user_master.login_name,springtube_printing_jobtype_master.job_type,springtube_shift_issues_master.shift_issue');
		$this->db->from($table);		
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
		$this->db->join('springtube_shift_issues_master',$table.'.shift_issues=springtube_shift_issues_master.shift_issue_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	// public function select_archive_records($limit,$start,$table,$company){
	// 	$this->db->select($table.'.*,springtube_machine_master.machine_name,user_master.login_name,springtube_printing_jobtype_master.job_type,SUM(counter) as total_counter');
	// 	$this->db->from($table);
	// 	$this->db->join('springtube_printing_production_details',$table.'.production_id=springtube_printing_production_details.production_id','LEFT');
	// 	$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
	// 	$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
	// 	$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
	// 	$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive','1');
	// 	$this->db->order_by('production_id','desc');
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }	

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,springtube_machine_master.machine_name,user_master.login_name,springtube_printing_jobtype_master.job_type as job_type_desc,springtube_shift_issues_master.shift_issue');
		$this->db->from($table);
		//$this->db->join('springtube_printing_production_details',$table.'.production_id=springtube_printing_production_details.production_id','LEFT');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
		$this->db->join('springtube_shift_issues_master',$table.'.shift_issues=springtube_shift_issues_master.shift_issue_id','LEFT');
		
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,springtube_machine_master.machine_name,user_master.login_name,springtube_printing_jobtype_master.job_type,springtube_shift_issues_master.shift_issue');
		$this->db->from($table);
		//$this->db->join('springtube_printing_production_details',$table.'.production_id=springtube_printing_production_details.production_id','LEFT');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
		$this->db->join('springtube_shift_issues_master',$table.'.shift_issues=springtube_shift_issues_master.shift_issue_id','LEFT');
 		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
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
		$this->db->where($table.'.archive', '0');
		$this->db->order_by($table.'.details_id');  
			 
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

	public function select_total_counter($table,$data){
		$this->db->select('SUM(counter) as total_counter');
		$this->db->from($table);
		$this->db->join('springtube_printing_production_details',$table.'.production_id=springtube_printing_production_details.production_id','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    } 
	    $this->db->where($table.'.company_id','000020');
		$this->db->where($table.'.archive<>', '1'); 
		$this->db->where('springtube_printing_production_details.archive', '0');  
			 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

// 	public function details_counter_sum($table,$data){
// 		$this->db->select('SUM(counter) as total_counter');
// 		$this->db->from($table);		
// 		if(!empty($data)){
// 			foreach($data as $key => $value) {
// 				$this->db->where(''.$table.'.'.$key.'', $value);
// 			}
// 	    }    
			 
// 		$query = $this->db->get();
// 		//echo $this->db->last_query();
// 		return $result=$query->result();
		
// 	}

	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,springtube_machine_master.machine_name,springtube_printing_jobtype_master.job_type,springtube_shift_issues_master.shift_issue');
		$this->db->from($table);
		//$this->db->join('springtube_printing_production_details',$table.'.production_id=springtube_printing_production_details.production_id','LEFT');
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('springtube_machine_master',$table.'.machine_id=springtube_machine_master.machine_id','LEFT');
		$this->db->join('springtube_printing_jobtype_master',$table.'.job_type=springtube_printing_jobtype_master.id','LEFT');
		$this->db->join('springtube_shift_issues_master',$table.'.shift_issues=springtube_shift_issues_master.shift_issue_id','LEFT');

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
		$this->db->order_by($table.'.production_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_active_records_search_shiftwise($table,$company,$data,$from,$to){
		$this->db->select('production_date,shift,user_id');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		if($from!='' && $to!=''){
			$this->db->where('production_date>=',$from);
			$this->db->where('production_date<=',$to);
		}
		 
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$this->db->group_by('production_date,shift');
		$this->db->order_by('production_date','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_top_one_active_record($table,$company,$data,$order_by,$seq){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}		
		$this->db->order_by($order_by,$seq);
		$this->db->order_by('shift','desc');
		$this->db->limit(1,0);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_active_color_for_dropdown($table,$company){
		$this->db->select('distinct(laminate_color) as laminate_color');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');		
		$this->db->order_by('laminate_color');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_active_printtype_for_dropdown($table,$company){
		$this->db->select('distinct(print_type) as print_type');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');		
		$this->db->order_by('print_type');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	
		
}

?>