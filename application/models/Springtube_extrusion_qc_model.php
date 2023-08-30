<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_qc_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.status','0');
		$this->db->order_by('qc_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($table.'.status','0');
		$this->db->order_by('qc_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		//$this->db->where($table.'.status','0');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		//$this->db->where($table.'.status','0');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('qc_date>=',$from);
			$this->db->where('qc_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	//Scrap--------------------------
	public function scrap_active_record_search($table,/*$limit, $start,*/$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.status','0');
		//$this->db->limit($limit, $start);
		if($from!='' && $to!=''){
			$this->db->where('scrap_date>=',$from);
			$this->db->where('scrap_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$this->db->order_by('scrap_date','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search_groupby($table,$company,$data,$from,$to){
		$this->db->select('year(qc_date)year,MONTHNAME(qc_date) month,sleeve_dia,sum(total_qc_hold_meters) total_qc_hold_meters,sum(case when next_process=6 then release_meters end) as wip, sum(case when next_process=11 then release_meters end) as scrap');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('qc_date>=',$from);
			$this->db->where('qc_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		//$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
		//$this->db->where($where);
		$this->db->group_by("year(qc_date)");
		$this->db->group_by("MONTH(qc_date)");
		$this->db->group_by("sleeve_dia");
		// $this->db->group_by("total_microns");
		// $this->db->group_by("second_layer_mb");
		// $this->db->group_by("sixth_layer_mb");

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	
		
}

?>