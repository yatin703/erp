<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_invoice_book_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,ap_invoice_lang.lang_remarks');
		$this->db->from($table);
		$this->db->join('ap_invoice_lang',''.$table.'.ap_invoice_no=ap_invoice_lang.ap_invoice_no','LEFT');
		$this->db->join('address_master',''.$table.'.adr_company_id=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.property_id','2');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

		$this->db->order_by(' '.$table.'.ap_invoice_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}


	public function active_record_search_index($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,ap_invoice_lang.lang_remarks');
		$this->db->from($table);
		$this->db->join('ap_invoice_lang',''.$table.'.ap_invoice_no=ap_invoice_lang.ap_invoice_no','LEFT');
		$this->db->join('address_master',''.$table.'.adr_company_id=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.property_id','2');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	 $this->db->limit($limit, $start);
		$this->db->order_by(' '.$table.'.invoice_date' ,'desc');
		$this->db->order_by(' '.$table.'.ap_invoice_no' ,'desc');
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
		
	}

//Tax Header
	
	public function fun_tax_header($from,$to,$company){

		//$this->db->distinct();
		$this->db->select('m.ap_invoice_no,m.invoice_date,d.tax_pos_no,td.tax_id,td.tax_code,l.lang_tax_code_desc');
		$this->db->from('ap_invoice m');	
		$this->db->join('ap_invoice_details d','m.ap_invoice_no=d.ap_invoice_no');
		$this->db->join('tax_grid_details td','d.tax_pos_no=td.tax_id');
		$this->db->join('tax_master t','t.tax_code=td.tax_code');
		$this->db->join('tax_master_lang l','t.tax_code=l.tax_code');
		$this->db->where('m.company_id', $company);
		$this->db->where('m.archive !=', '1');
		$this->db->where('m.invoice_date >=', $from);
		$this->db->where('m.invoice_date <=', $to);
		$this->db->group_by('td.tax_code');
		$this->db->order_by('td.priority');
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}


	public function select_tax($table,$company,$pkey,$edit,$order_by){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		//$this->db->where('archive<>', '1');
		$this->db->where($pkey,$edit);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query->result();
	}	

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_master.name1 as customer_name,address_master.isdn_local,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.name3,zip_code_master.state_code,zip_code_master.lang_city,ap_invoice_lang.lang_remarks');
		$this->db->from($table);
		$this->db->join('ap_invoice_lang',''.$table.'.ap_invoice_no=ap_invoice_lang.ap_invoice_no','LEFT');
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->where($table.'.archive<>', '1');

		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


}

?>