<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_film_stock_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,springtube_process_master.process_name');
		$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id','LEFT');		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,springtube_process_master.process_name');
		$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id','LEFT');			
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');	
		$this->db->from($table);	
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		$this->db->last_query();
		return $result=$query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');	
		$this->db->from($table);	
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		$this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,springtube_process_master.process_name');
		$this->db->from($table);
		$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id','LEFT');	
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->where($table.'.'.$key,$value);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	

}

?>