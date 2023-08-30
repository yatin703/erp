<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->order_by($table.'.quotation_no','desc');
		 
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		 
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}
	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_category_details.address,address_category_details.city,country_master_lang.lang_country_name,address_category_contact_details.company_email,address_category_details.state,address_category_contact_details.company_contact_no,address_category_contact_details.contact_name,address_category_master.category_name,shoulder_types_master.shoulder_type,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type as cap_types,cap_finish_master.cap_finish as cap_finishes,cap_diameter_master.cap_dia as cap_dias,shoulder_orifice_master.shoulder_orifice as shoulder_ori,cap_orifice_master.cap_orifice as cap_ori');

		$this->db->from($table);
		$this->db->join('address_category_details',$table.'.customer_no=address_category_details.adr_category_id','LEFT');
		$this->db->join('country_master_lang','address_category_details.country=country_master_lang.country_id','LEFT');
		$this->db->join('address_category_contact_details',$table.'.pm_1=address_category_contact_details.address_category_contact_id','LEFT');		
		$this->db->join('address_category_master',$table.'.customer_no=address_category_master.adr_category_id','LEFT');	
		$this->db->join('shoulder_types_master',$table.'.shoulder=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shoulder_orifice=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice=cap_orifice_master.cap_orifice_id','LEFT');

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_category_details.address,address_category_details.city,country_master_lang.lang_country_name,address_category_contact_details.personal_email,address_category_details.state,address_category_contact_details.company_contact_no,address_category_contact_details.contact_name,address_category_master.category_name,shoulder_types_master.shoulder_type,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type as cap_types,cap_finish_master.cap_finish as cap_finishes,cap_diameter_master.cap_dia as cap_dias');
		$this->db->from($table);
		$this->db->join('address_category_details',$table.'.customer_no=address_category_details.adr_category_id','LEFT');
		$this->db->join('country_master_lang','address_category_details.country=country_master_lang.country_id','LEFT');
		$this->db->join('address_category_contact_details',$table.'.pm_1=address_category_contact_details.address_category_contact_id','LEFT');		
		$this->db->join('address_category_master',$table.'.customer_no=address_category_master.adr_category_id','LEFT');	
		$this->db->join('shoulder_types_master',$table.'.shoulder=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia=cap_diameter_master.cap_dia_id','LEFT');
		

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');

		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//	$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('quotation_date>=',$from);
			$this->db->where('quotation_date<=',$to);
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

	 
		
}

?>