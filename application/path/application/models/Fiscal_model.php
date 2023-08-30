<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Fiscal_model extends CI_Model {

	
	public function select_active_drop_down($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status<>','1');
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record($table,$pkey,$edit,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey, $edit);
		$this->db->where($table.'.company_id', $company);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.status<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.accounting_year','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.status', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.accounting_year','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.status<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function update_one_active_record_noncompany($table,$data,$pkey,$edit,$company){
		$this->db->where($pkey, $edit);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);

		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}

	public function active_record_count($table,$company){
		$this->db->where('status<>','1');
		$this->db->where('company_id',$company);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}

	public function archive_record_count($table,$company){
		$this->db->where('status','1');
		$this->db->where('company_id',$company);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}

	public function select_current_financial_year($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status<>', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('finyear_close_opt', '0');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}

	
}

?>