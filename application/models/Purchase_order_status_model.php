<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order_status_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,user_master.login_name,property_master.lang_property_name,purchase_order_master_lang.	lang_internal_remarks');
		$this->db->from($table);
		$this->db->join('purchase_order_master_lang',''.$table.'.po_no=purchase_order_master_lang.po_no','LEFT');
		$this->db->join('address_master',''.$table.'.supplier_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.supplier_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.amendment_flag!=', '1');
		$this->db->where(''.$table.'.po_date >=', $from);
		$this->db->where(''.$table.'.po_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like(''.$table.'.'.$key.'', $value,'after');
			}
	    }
	    $this->db->order_by(' '.$table.'.po_date');
		$this->db->order_by(' '.$table.'.po_no');
		$query = $this->db->get();
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

//Tax Header
	
	public function active_grn_records($table,$data,$company){

		$this->db->select('*');
		$this->db->from($table);	
		$this->db->join('grir_purchase_details ',$table.'.delivery_note_no=grir_purchase_details.delivery_note_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
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

		$this->db->select('SUM(qty_received) as supply_qty');
		$this->db->from($table);	
		$this->db->join('grir_purchase_details ',$table.'.delivery_note_no=grir_purchase_details.delivery_note_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}

	public function active_invoice_records($table,$data,$company){

		$this->db->select('ap_invoice.ap_invoice_no,ap_invoice.invoice_date,ap_invoice_details.quantity,ap_invoice_details.net_price');
		$this->db->from($table);	
		$this->db->join('ap_invoice_details ',$table.'.ap_invoice_no=ap_invoice_details.ap_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}


}

?>