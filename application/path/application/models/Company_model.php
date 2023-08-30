<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('company_master.*,country_master_lang.lang_country_name as country_name');
		$this->db->from($table);
		$this->db->join('country_master_lang','company_master.country_code=country_master_lang.country_id','LEFT');
		$this->db->where('company_master.company_id',$company);
		$this->db->where('company_master.archive<>','1');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $query->result();
	}

}

?>