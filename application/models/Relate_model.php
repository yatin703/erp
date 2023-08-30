<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Relate_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$language){
		$this->db->select('adr_relate_companies.*,am.name1 as customer,aa.name1 as relate,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('address_master as am','adr_relate_companies.adr_company_id=am.adr_company_id','LEFT');
		$this->db->join('address_master as aa','adr_relate_companies.related_company_id=aa.adr_company_id','LEFT');
		$this->db->join('property_master','property_master.property_id=adr_relate_companies.related_property_id','LEFT');
		$this->db->where('property_master.language_id',$language);
		$this->db->order_by('adr_relate_companies.adr_company_id','asc');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $query->result();
	}
	

	
	
	public function active_record_search($table,$data,$language){
		$this->db->select('adr_relate_companies.*,am.name1 as customer,aa.name1 as relate,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('address_master as am','adr_relate_companies.adr_company_id=am.adr_company_id','LEFT');
		$this->db->join('address_master as aa','adr_relate_companies.related_company_id=aa.adr_company_id','LEFT');
		$this->db->join('property_master','property_master.property_id=adr_relate_companies.related_property_id','LEFT');
		$this->db->where('property_master.language_id',$language);
		foreach($data as $key => $value) {
			$this->db->like('adr_relate_companies.'.$key, $value,'after');
		}
		
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_record($table,$company,$pkey,$edit,$language){
		$this->db->select($table.'.*,am.name1 as customer,aa.name1 as relate,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('address_master as am','adr_relate_companies.adr_company_id=am.adr_company_id','LEFT');
		$this->db->join('address_master as aa','adr_relate_companies.related_company_id=aa.adr_company_id','LEFT');
		$this->db->join('property_master','property_master.property_id=adr_relate_companies.related_property_id','LEFT');
		$this->db->where('property_master.language_id',$language);
		$this->db->where($table.'.company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	

}

?>