<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_model extends CI_Model {


	public function select_active_drop_down_account_head($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>','1');
		$this->db->where('related_flag','4');
		$this->db->order_by('lang_description');
		$query = $this->db->get();
		return $query->result();
	}

 	public function select_active_records($limit,$start,$table,$company){

		$this->db->select($table.'.*,tax_master_lang.lang_tax_code_desc,S.lang_description as sales_accounr_head,P.lang_description as purchase_accounr_head');
		$this->db->from($table);
		$this->db->join('tax_master_lang',$table.'.tax_code=tax_master_lang.tax_code','LEFT');
		$this->db->join('account_head_lang S',$table.'.account_head_id=S.account_head_id','LEFT');
		$this->db->join('account_head_lang P',$table.'.account_head_id_p=P.account_head_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('tax_master_lang.language_id', '1');
		$this->db->where('tax_master_lang.company_id', $company);
		$this->db->order_by($table.'.tax_pos_no');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}
	public function select_one_active_record($table,$company,$pkey,$edit){

		$this->db->select($table.'.*,tax_master_lang.lang_tax_code_desc,S.lang_description as sales_accounr_head,P.lang_description as purchase_accounr_head');
		$this->db->from($table);
		$this->db->join('tax_master_lang',$table.'.tax_code=tax_master_lang.tax_code','LEFT');
		$this->db->join('account_head_lang S',$table.'.account_head_id=S.account_head_id','LEFT');
		$this->db->join('account_head_lang P',$table.'.account_head_id_p=P.account_head_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('tax_master_lang.language_id', '1');
		$this->db->where('tax_master_lang.company_id', $company);
		$this->db->where($table.'.'.$pkey, $edit);
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function select_archive_records($limit,$start,$table,$company){

		$this->db->select($table.'.*,tax_master_lang.lang_tax_code_desc,S.lang_description as sales_accounr_head,P.lang_description as purchase_accounr_head');
		$this->db->from($table);
		$this->db->join('tax_master_lang',$table.'.tax_code=tax_master_lang.tax_code','LEFT');
		$this->db->join('account_head_lang S',$table.'.account_head_id=S.account_head_id','LEFT');
		$this->db->join('account_head_lang P',$table.'.account_head_id_p=P.account_head_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where('tax_master_lang.language_id', '1');
		$this->db->where('tax_master_lang.company_id', $company);
		$this->db->order_by($table.'.tax_pos_no');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();


	}

		public function select_one_inactive_record($table,$company,$pkey,$edit){

		$this->db->select($table.'.*,tax_master_lang.lang_tax_code_desc,S.lang_description as sales_accounr_head,P.lang_description as purchase_accounr_head');
		$this->db->from($table);
		$this->db->join('tax_master_lang',$table.'.tax_code=tax_master_lang.tax_code','LEFT');
		$this->db->join('account_head_lang S',$table.'.account_head_id=S.account_head_id','LEFT');
		$this->db->join('account_head_lang P',$table.'.account_head_id_p=P.account_head_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where('tax_master_lang.language_id', '1');
		$this->db->where('tax_master_lang.company_id', $company);
		$this->db->where($table.'.'.$pkey, $edit);
		$query = $this->db->get();
		return $result=$query->result();

	}


 	public function active_record_search($table,$data,$company){

		$this->db->select('tax_master.*,tax_master_lang.lang_tax_code_desc,S.lang_description as sales_accounr_head,P.lang_description as purchase_accounr_head');
		$this->db->from('tax_master');
		$this->db->join('tax_master_lang','tax_master.tax_code=tax_master_lang.tax_code','LEFT');
		$this->db->join('account_head_lang S','tax_master.account_head_id=S.account_head_id','LEFT');
		$this->db->join('account_head_lang P','tax_master.account_head_id_p=P.account_head_id','LEFT');
		$this->db->where('tax_master.company_id', $company);
		$this->db->where('tax_master.archive<>', '1');
		$this->db->where('tax_master_lang.language_id', '1');
		$this->db->where('tax_master_lang.company_id', $company);
		foreach($data as $key=> $value){

			$this->db->like($key, $value,'after');

		}
		$this->db->order_by('tax_master.tax_pos_no');
		
		$query = $this->db->get();
		return $result=$query->result();

	}


	public function update_tax_history_table($table,$data,$pkey,$edit){
		$this->db->set('old_rate','new_rate',false);
		$this->db->where($pkey, $edit);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}
	
}
?>