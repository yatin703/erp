<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_head_model extends CI_Model {

//Used in Main Group Create form for dropdown
	public function select_active_drop_down($table,$company,$language,$pkey,$edit){
		$this->db->select($table.'.*,account_groups_master.lang_acc_grp_name as account_group');
		$this->db->from($table);
		$this->db->join('account_groups_master',$table.'.acc_grp_id=account_groups_master.acc_grp_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.language_id',$language);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	
	



}

?>