<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_followup_model extends CI_Model {

	public function select_followup_received_records($table,$company,$pkey,$edit,$status,$flag,$pkey2,$edit2){
		$this->db->select($table.'.*,t.login_name as to_user,f.login_name as from_user');
		$this->db->from($table);
		$this->db->join('user_master as t',$table.'.user_id=t.user_id','LEFT');
		$this->db->join('user_master as f',$table.'.contact_person_id=f.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($status, $flag);
		$this->db->order_by($table.'.followup_date','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_followup_received_records_for_so($table,$company,$pkey,$edit,$status,$flag,$pkey2,$edit2,$pkey3,$edit3){
		$this->db->select($table.'.*,t.login_name as to_user,f.login_name as from_user');
		$this->db->from($table);
		$this->db->join('user_master as t',$table.'.user_id=t.user_id','LEFT');
		$this->db->join('user_master as f',$table.'.contact_person_id=f.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($pkey3, $edit3);
		$this->db->where($status, $flag);
		$this->db->order_by($table.'.followup_date','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_followup_rejected_records($table,$company,$data,$order_by){
		$this->db->select($table.'.*,t.login_name as to_user,f.login_name as from_user');
		$this->db->from($table);
		$this->db->join('user_master as t',$table.'.user_id=t.user_id','LEFT');
		$this->db->join('user_master as f',$table.'.contact_person_id=f.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		
		foreach($order_by as $key => $value) {
			$this->db->order_by($key,$value);
		}
		$this->db->limit(1,0);

		$query = $this->db->get();
		return $result=$query->result();
	}

}
?>