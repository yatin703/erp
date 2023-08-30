<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_model extends CI_Model {

		public function select_for_currency_drop_down($table){
		$this->db->select('currency_name ');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->group_by('currency_name');
		$query = $this->db->get();
		return $query->result();
		//echo $this->db->last_query();
	}

	public function select_to_currency_drop_down($table,$ignore){
		$this->db->select('currency_name ');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where_not_in($table.'.currency_name', $ignore);
		$this->db->group_by('currency_name');
		$query = $this->db->get();
		return $query->result();
		//echo $this->db->last_query();
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
		echo $this->db->last_query();
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

	public function select_one_active_record($table,$pkey){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>', '1');
		foreach($pkey as $key => $value) {
			$this->db->where($table.'.'.$key,$value);
		}
			$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}

	public function select_one_archive_record($table,$pkey){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive', '1');
		foreach($pkey as $key => $value) {
			$this->db->where($table.'.'.$key,$value);
		}
			$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}
	
	public function active_record_count($table,$pkey){
		$this->db->from($table);
		$this->db->where('archive<>','1');
		foreach($pkey as $key => $value) {
			$this->db->where($key,$value);
		}
		$count = $this->db->count_all_results();
		return $count;
		//echo $this->db->last_query();
	}

	public function update_one_active_record($table,$data,$pkey){
		foreach($pkey as $key => $value) {
			$this->db->where($key,$value);
		}
		$result=$this->db->update($table,$data);
		
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
		//echo $this->db->last_query();
	}


	public function active_record_search($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		$this->db->where($table.'.archive<>','1');
		foreach($data as $key => $value) {
		$this->db->like($table.'.'.$key,$value,'after');
			//$this->db->like($table.'.'.$key,$value,'before');
		}
	
		$query = $this->db->get();

		return $result=$query->result();
		//echo $this->db->last_query(); 
		
	}

	public function select_history_records($table,$pkey){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('country_master_lang',$table.'.country_id=country_master_lang.country_id');
		foreach($pkey as $key => $value) {
			$this->db->where($table.'.'.$key,$value);
		}
		//$this->db->limit($limit, $start);
		$this->db->order_by($table.'.date_created','desc');
		$query = $this->db->get();
		return $result=$query->result();
		echo $this->db->last_query();
	}
	



}

?>