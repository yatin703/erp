<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_rfd_model extends CI_Model {	

	public function select_active_records(/*$limit,$start,*/$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.status','0');
		$this->db->where($table.'.rfd_date>','2021-12-29');
		$this->db->order_by('rfd_id','desc');
		//$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($table.'.status','0');
		$this->db->order_by('rfd_id','desc');
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

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//	$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('rfd_date>=',$from);
			$this->db->where('rfd_date<=',$to);
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

	public function rfd_transfer_model($order_no){
		
		$sql="SELECT am.dispatch_tolerance as dispatch_tolerance ,om.order_no,(od.total_order_quantity/100) as order_quantity FROM address_master as am left join order_master as om on am.adr_company_id=om.customer_no left join order_details as od on om.order_no=od.order_no where om.order_no='$order_no'";

		$query=$this->db->query($sql);
		return $result=$query->result();
	}

	// public function select_active_records_groupby($limit,$start,$table,$company){
	// 	$this->db->select('aql_date,jobcard_no,order_no,sum(rfd_qty) rfd_qty');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive<>','1');
	// 	$this->db->where($table.'.status','0');
	// 	$this->db->group_by('order_no');
	// 	$this->db->order_by('aql_id','desc');
	// 	$this->db->limit($limit, $start);
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }
	
		
}

?>