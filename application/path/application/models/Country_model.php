<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Country_model extends CI_Model {

	/*public function select_active_drop_down($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master',".$table.".'country_id=country_master.country_id','LEFT');
		$this->db->where('country_master.archive<>','1');
		$query = $this->db->get();
		return $query->result();
	}
	*/
	public function select_active_drop_down($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>', '1');
		$query = $this->db->get();
		return $query->result();
		echo $this->last_query();
	}


	// public function select_one_active_record($table,$pkey,$edit){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	//$this->db->where('archive<>', '1');
	// 	$this->db->where($pkey, $edit);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function select_one_active_record($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>', '1');	
		$this->db->where('country_master_lang.language_id', '1');		
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_inactive_record($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive', '1');	
		$this->db->where('country_master_lang.language_id', '1');		
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}


	
	public function select_active_records($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.country_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.country_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>','1');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
	
		$query = $this->db->get();
		return $result=$query->result();
	}
	



}

?>