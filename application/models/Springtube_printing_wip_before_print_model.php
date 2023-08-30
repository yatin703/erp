<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_wip_before_print_model extends CI_Model {	

	// public function select_active_records($limit,$start,$table,$company){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>','1');
	// 	//$this->db->where($table.'.status','0');
	// 	$this->db->order_by('bprint_wip_id','desc');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }

	// public function select_active_records($limit,$start,$table,$company){
	// 	$this->db->select($table.'.*,springtube_extrusion_wip_master.order_no as from_order_no,springtube_extrusion_wip_master.article_no as from_article_no,springtube_extrusion_wip_master.jobcard_no as from_jobcard_no');
	// 	$this->db->from($table);
	// 	$this->db->join('springtube_extrusion_wip_master',$table.'.details_id=springtube_extrusion_wip_master.details_id');
	// 	$this->db->where($table.'.order_no=springtube_extrusion_wip_master.release_to_order_no');
	// 	$this->db->where($table.'.bprint_wip_meters=springtube_extrusion_wip_master.release_meters');
	// 	$this->db->where($table.'.bprint_wip_date=springtube_extrusion_wip_master.release_date');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>', '1');
	// 	$this->db->where($table.'.status','0');

	// 	$this->db->order_by('bprint_wip_id','desc');
	// 	$this->db->limit($limit, $start);
		
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		//$this->db->where($table.'.status','0');
		$this->db->order_by('bprint_wip_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,springtube_extrusion_wip_master.order_no as from_order_no,springtube_extrusion_wip_master.article_no as from_article_no,springtube_extrusion_wip_master.jobcard_no as from_jobcard_no');
		$this->db->from($table);
		$this->db->join('springtube_extrusion_wip_master',$table.'.ref_wip_id=springtube_extrusion_wip_master.wip_id');
		//$this->db->where($table.'.order_no=springtube_extrusion_wip_master.release_to_order_no');
		//$this->db->where($table.'.bprint_wip_meters=springtube_extrusion_wip_master.release_meters');
		//$this->db->where($table.'.bprint_wip_date=springtube_extrusion_wip_master.release_date');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.status','0');
		$this->db->where($table.'.return_flag', '0');
		$this->db->where('springtube_extrusion_wip_master.archive','0');

		$this->db->order_by('bprint_wip_id','desc');
		$this->db->limit($limit, $start);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
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

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	// public function active_record_search($table,$company,$data,$from,$to){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>', '1');
	// 	//$this->db->where($table.'.status','0');
	// 	if($from!='' && $to!=''){
	// 		$this->db->where('bprint_wip_date>=',$from);
	// 		$this->db->where('bprint_wip_date<=',$to);
	// 	}
	// 	//print_r($data);
	// 	if(!empty($data)){		
	// 		foreach($data as $key => $value) {
	// 			$this->db->where($table.'.'.$key,$value);
	// 		}
	// 	}
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }

	// public function active_record_search($table,$company,$data,$from,$to){
	// 	$this->db->select($table.'.*,springtube_extrusion_wip_master.order_no as from_order_no,springtube_extrusion_wip_master.article_no as from_article_no,springtube_extrusion_wip_master.jobcard_no as from_jobcard_no');
	// 	$this->db->from($table);
	// 	$this->db->join('springtube_extrusion_wip_master',$table.'.details_id=springtube_extrusion_wip_master.details_id');
	// 	$this->db->where($table.'.order_no=springtube_extrusion_wip_master.release_to_order_no');
	// 	$this->db->where($table.'.bprint_wip_meters=springtube_extrusion_wip_master.release_meters');
	// 	$this->db->where($table.'.bprint_wip_date=springtube_extrusion_wip_master.release_date');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>', '1');
	// 	//$this->db->where($table.'.status','0');
	// 	if($from!='' && $to!=''){
	// 		$this->db->where('bprint_wip_date>=',$from);
	// 		$this->db->where('bprint_wip_date<=',$to);
	// 	}
	// 	//print_r($data);
	// 	if(!empty($data)){		
	// 		foreach($data as $key => $value) {
	// 			$this->db->where($key,$value);
	// 		}
	// 	}

	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
	// }

	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,springtube_extrusion_wip_master.order_no as from_order_no,springtube_extrusion_wip_master.article_no as from_article_no,springtube_extrusion_wip_master.jobcard_no as from_jobcard_no');
		$this->db->from($table);
		$this->db->join('springtube_extrusion_wip_master',$table.'.ref_wip_id=springtube_extrusion_wip_master.wip_id');
		//$this->db->where($table.'.order_no=springtube_extrusion_wip_master.release_to_order_no');
		//$this->db->where($table.'.bprint_wip_meters=springtube_extrusion_wip_master.release_meters');
		//$this->db->where($table.'.bprint_wip_date=springtube_extrusion_wip_master.release_date');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.return_flag', '0');
		$this->db->where('springtube_extrusion_wip_master.archive','0');
		if($from!='' && $to!=''){
			$this->db->where('bprint_wip_date>=',$from);
			$this->db->where('bprint_wip_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	

	public function active_record_search_wip($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,springtube_extrusion_wip_master.order_no as from_order_no,springtube_extrusion_wip_master.article_no as from_article_no,springtube_extrusion_wip_master.jobcard_no as from_jobcard_no');
		$this->db->from($table);
		$this->db->join('springtube_extrusion_wip_master',$table.'.ref_wip_id=springtube_extrusion_wip_master.wip_id');
		 
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.return_flag', '0');
		$this->db->where('springtube_extrusion_wip_master.archive','0');
		if($from!='' && $to!=''){
			$this->db->where('bprint_wip_date>=',$from);
			$this->db->where('bprint_wip_date<=',$to);
			$where='(springtube_printing_wip_master_before.release_date="0000-00-00" OR springtube_printing_wip_master_before.release_date>"'.$to.'")';
			$this->db->where($where);
		}

		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	public function select_pending_jobcards($table,$company){
		//$this->db->select($table.'.*');
		//$this->db->from($table);
		//$this->db->join('springtube_printing_production_master','springtube_printing_production_master.jobcard_no='.$table.'.jobcard_no','LEFT');
		//$this->db->where($table.'.order_no=springtube_extrusion_wip_master.release_to_order_no');
		//$this->db->where($table.'.bprint_wip_meters=springtube_extrusion_wip_master.release_meters');
		//$this->db->where($table.'.bprint_wip_date=springtube_extrusion_wip_master.release_date');
		//$this->db->where($table.'.company_id',$company);
		//$this->db->where($table.'.archive<>', '1');
		//$this->db->where('.springtube_printing_production_master.jobcard_no IS NULL');
		//$this->db->where($table.'.status','0');
		//$this->db->where('springtube_extrusion_wip_master.archive','0');

		//$this->db->order_by('bprint_wip_id','desc');
		//$this->db->limit($limit, $start);
		$sql="SELECT springtube_printing_wip_master_before.* FROM `springtube_printing_wip_master_before` LEFT JOIN springtube_printing_production_master ON springtube_printing_production_master.jobcard_no = springtube_printing_wip_master_before.`print_jobcard_no` WHERE springtube_printing_wip_master_before.return_flag=0 AND springtube_printing_wip_master_before.archive=0 AND   springtube_printing_production_master.jobcard_no IS NULL";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();
	}	

	
		
}

?>