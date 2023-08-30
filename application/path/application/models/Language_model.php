<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model {

	public function select_active_drop_down($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$query = $this->db->get();
		return $query->result();
	}

	public function archive_record_count($table){
		$this->db->where('archive','1');
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	



}

?>