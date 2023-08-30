<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_category_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,address_category_master.category_name,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_category_master',$table.'.adr_company_id=address_category_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		$this->db->where('property_master.language_id','1');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('address_details.master_property_id','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		$this->db->where('property_master.language_id','1');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('address_details.master_property_id','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_state_country_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey,$edit);
		$this->db->where('language_id','1');
		$query = $this->db->get();
		return $result=$query->result();
	}





	public function archive_record_count($table,$company){
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive','1');
		$this->db->where($table.'.company_id',$company);
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$count = $this->db->count_all_results();
		return $count;
	}


	public function active_record_count($table,$company){
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$count = $this->db->count_all_results();
		return $count;
	}


	public function select_active_property_drop_down($table,$language){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('language_id', $language);
		$this->db->where('master_property_id','1');
		$this->db->where('archive<>', '1');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_active_payment_term_drop_down($table,$language){
		$this->db->select('*');
		$this->db->from($table);
			$this->db->join('payment_condition_master_lang',$table.'.id=payment_condition_master_lang.id','LEFT');
		$this->db->where('payment_condition_master_lang.language_id', $language);
		$this->db->where($table.'.archive<>', '1');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_active_bank_drop_down($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>', '1');
		$query = $this->db->get();
		return $result=$query->result();
	}


	// public function select_max_adr_company_key($table,$company){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where('address_details.payment_condition_id!=','NULL');
	// 	$count = $this->db->count_all_results();
	// 	return $count+1;
	// }

	public function select_max_adr_company_key($table,$company){
		$query = $this->db->query("SELECT MAX(adr_company_id +1) adr_company_id FROM  address_master WHERE company_id =  '000020' AND adr_company_id NOT LIKE  '%99999%' ");
		return $result=$query->result();
	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description,zip_code_master.state_code,zip_code_master.lang_city,,bank_master.bank_name,bank_master.bank_code');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		$this->db->join('bank_master','address_details.bank_id=bank_master.bank_id','LEFT');
		$this->db->where('property_master.language_id','1');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id','1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description,bank_master.bank_name,bank_master.bank_code');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		$this->db->join('bank_master','address_details.bank_id=bank_master.bank_id','LEFT');
		$this->db->where('property_master.language_id','1');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search_by_date($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where(''.$table.'.contact_date >=', $from);
		$this->db->where(''.$table.'.contact_date <=', $to);
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}



	public function active_record_customer_search($table,$data,$company){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_customer_bill_to_address($table,$data,$company){
		$this->db->select($table.'.*,address_details.financial_account_no,address_details.property_id,address_details.payment_condition_id,address_details.bank_id,address_details.account_type,address_details.account_no,property_master.lang_property_name,payment_condition_master_lang.lang_description');
		$this->db->from($table);
		$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('payment_condition_master_lang','address_details.payment_condition_id=payment_condition_master_lang.id','LEFT');
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->where('property_master.language_id','1');
		$this->db->where('address_details.master_property_id','1');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}

	//TO GET CONTRACT PACKER LIST-----------------------------------
	// public function select_contract_packer($table,$company,$pkey,$edit){

	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($pkey,$edit);
	// 	$this->db->where($table.'.company_id',$company);
	// 	$query=$this->db->get();
	// 	return result=$this->db->result();
	// }


}

?>