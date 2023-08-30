<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Trackmyorder_model extends CI_Model {	 

	public function active_record_search($table,$company,$customer_category,$data,$from,$to){

		$this->db->select('distinct(order_no)order_no,springtube_printing_production_master.article_no,production_date');

		if(!empty($customer_category)){
		$this->db->join('article_name_info','springtube_printing_production_master.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('address_category_master',''.$table.'.customer_category=address_category_master.adr_category_id','LEFT');
		}
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//	$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('production_date>=',$from);
			$this->db->where('production_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}

		
	    if(!empty($customer_category)){
	    	$this->db->where('article_name_info.adr_category_id',$customer_category);
	    	$this->db->where('article_name_info.company_id',$company);
	    }
		//$this->db->group_by('production_date');
		$this->db->group_by('order_no');
		$this->db->group_by('article_no');
		$this->db->order_by('production_date','DESC');
		$this->db->order_by('shift','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
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