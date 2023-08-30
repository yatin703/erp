
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_customer_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*,address_category_master.category_name,country_master_lang.lang_country_name');
		$this->db->from($table);
		//$this->db->join('zip_code_master',$table.'.state=zip_code_master.zip_code','LEFT');

		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		$this->db->join('country_master_lang',$table.'.country=country_master_lang.country_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','0');
		$this->db->order_by($table.'.address_category_details_id','desc');
		//$this->db->where('zip_code_master.language_id','1');
		//$this->db->where('zip_code_master.archive','0');
		//$this->db->where('country_master_lang.language_id','1');

		 
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*,zip_code_master.lang_city,country_master_lang.lang_country_name');
		$this->db->from($table);
		$this->db->join('zip_code_master',$table.'.state=zip_code_master.zip_code','LEFT');
		$this->db->join('country_master_lang',$table.'.country=country_master_lang.country_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','0');
		$this->db->where('zip_code_master.language_id','1');
		$this->db->where('zip_code_master.archive','0');
		$this->db->where('country_master_lang.language_id','1');
	}
	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*,address_category_master.category_name,country_master_lang.lang_country_name');
		$this->db->from($table);
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		//$this->db->join('zip_code_master',$table.'.state=zip_code_master.zip_code','LEFT');
		$this->db->join('country_master_lang',$table.'.country=country_master_lang.country_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','0');
		//$this->db->where('zip_code_master.language_id','1');
		//$this->db->where('zip_code_master.archive','0');
		//$this->db->where('country_master_lang.language_id','1');
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
		$this->db->select('*,address_category_master.category_name,country_master_lang.lang_country_name');
		$this->db->from($table);

		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		//$this->db->join('zip_code_master',$table.'.state=zip_code_master.zip_code','LEFT');
		$this->db->join('country_master_lang',$table.'.country=country_master_lang.country_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','0');
		//$this->db->where('zip_code_master.language_id','1');
		//$this->db->where('zip_code_master.archive','0');
		//$this->db->where('country_master_lang.language_id','1');
		if($from!='' && $to!=''){
			$this->db->where('creation_date>=',$from);
			$this->db->where('creation_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->like($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	public function get_client_name($data){
		$this->db->select('*');
		$this->db->from('address_category_contact_details');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$query = $this->db->get();
		$result=$query->result();

		if($result){

				foreach($result as $row){

					return $row->contact_name;
				
				}
			}
			else{
				return '';
			}
		
	}

	 
		
}

?>