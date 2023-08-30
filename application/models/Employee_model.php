<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_model extends CI_Model {

	public function select_max_pkey($table,$pkey,$company){
		$this->db->select('MAX('.$pkey.') as '.$pkey);
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$query = $this->db->get();
		return $query->result();
		
	}




}
?>