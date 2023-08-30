<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sleeve_length_model extends CI_Model {

	public function select_length_active_record($table,$company,$sleeve_dia,$sleeve_length){
		$this->db->select('*,count(*) as no');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('dia',$sleeve_dia);
		$this->db->where('length_from<=',$sleeve_length);
		$this->db->where('length_to>=',$sleeve_length);
		$query = $this->db->get();
		//echo $this->db->last_query();

		return $result=$query->result();
	}

	

	
}
?>