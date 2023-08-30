<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_status_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like(''.$table.'.'.$key.'', $value,'after');
			}
	    }

		$this->db->order_by(' '.$table.'.order_no');
		$query = $this->db->get();
		return $result=$query->result();
		echo $this->db->last_query();
	}

	public function active_record_search_new($table,$data,$from,$to,$company,$list_arr,$approval_from_date,$approval_to_date,$cancelled_from_date,$cancelled_to_date){
		$this->db->select(''.$table.'.*,address_master.name1,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if($approval_from_date!='' && $approval_to_date!=''){
			$this->db->where(''.$table.'.approval_date >=', $approval_from_date);
			$this->db->where(''.$table.'.approval_date <=', $approval_to_date);
		}

		if($cancelled_from_date!='' && $cancelled_to_date!=''){
			$this->db->where(''.$table.'.trans_closed_date >=', $cancelled_from_date);
			$this->db->where(''.$table.'.trans_closed_date <=', $cancelled_to_date);
		}

		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($list_arr)){

	    	$this->db->where_in(''.$table.'.order_closed', $list_arr,false);
	    }

		$this->db->order_by(' '.$table.'.order_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function active_details_records($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }	 
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
		
	}

	public function active_details_records_new($table,$data,$company,$customer_category){
		$this->db->select('*');
		$this->db->from($table);
		if($customer_category!=''){
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		}
		$this->db->where(''.$table.'.company_id', $company);

		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if($customer_category!=''){
	    	$this->db->where('article_name_info.company_id', $company);
	    	$this->db->where('article_name_info.language_id','1');
	    	$this->db->where('article_name_info.adr_category_id', $customer_category);
	    }	 
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
		
	}

//Tax Header
	
	public function active_invoice_records($table,$data,$company){

		$this->db->select('*');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice !=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}


	public function sum_supply_qty($table,$data,$company){

		$this->db->select('IFNULL(SUM( arid_qty ),0)  as supply_qty');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice !=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		
	}


	public function active_record_for_excel($table,$data,$from,$to,$company){
		 $this->db->select('order_master.order_no, order_master.order_date, address_master.name1, am.name1 as consignee, order_master.cust_order_no, order_master.cust_order_date, order_details.article_no, article_name_info.lang_article_description, IF(order_details.total_order_quantity=0,0,order_details.total_order_quantity/100)total_order_quantity, IF(ar_invoice_details.arid_qty=0,0,ar_invoice_details.arid_qty/100)arid_qty, order_details.delivery_date, ar_invoice_master.ar_invoice_no, ar_invoice_master.invoice_date, IF(ar_invoice_details.total_price=0,0,ar_invoice_details.total_price/100)total_price, IF(total_price=0,0,total_price/100)total_price, IF(ar_invoice_master.amt_received=0,0,ar_invoice_master.amt_received/100)amt_received');
		 $this->db->from($table);
		 $this->db->join('order_details',''.$table.'.order_no=order_details.order_no','LEFT');
		 $this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		 $this->db->join('address_master am','SUBSTRING_INDEX(order_master.consin_adr_company_id,"|",1)=am.adr_company_id','LEFT');
		 $this->db->join('ar_invoice_details','order_details.order_no=ar_invoice_details.ref_ord_no','LEFT');
		 $this->db->join('ar_invoice_master','ar_invoice_master.ar_invoice_no=ar_invoice_details.ar_invoice_no','LEFT');
		 $this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		 $this->db->join('article_name_info','.order_details.article_no=article_name_info.article_no','LEFT');
		 $this->db->where(''.$table.'.company_id', $company);
		 $this->db->where('article_name_info.company_id', $company);
		 $this->db->where(''.$table.'.archive!=', '1');
		 $this->db->where(''.$table.'.order_date >=', $from);
		 $this->db->where(''.$table.'.order_date <=', $to);
		 if(!empty($data)){
		 	foreach($data as $key => $value) {
		 		$this->db->like(''.$table.'.'.$key.'', $value,'after');
		 	}
	   	 }
	   	 if(!empty($data['article_no'])){
	   	 	$this->db->where('order_details.article_no', $data['article_no']);
	   	 }

		$this->db->order_by(' '.$table.'.order_no');
		$query = $this->db->get();
		return $result=$query->result_array();
		
	}






}

?>