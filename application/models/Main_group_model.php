<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_group_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,excise_rates_master_lang.lang_tariff_descr as hsn_desc');
		$this->db->from($table);
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('excise_rates_master_lang','excise_rates_master.erm_id=excise_rates_master_lang.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.main_group_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center');
		$this->db->from($table);
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.main_group_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center');
		$this->db->from($table);
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($table.'.'.$key,$value,'after');
			}
		}

		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('cast('.$table.'.main_group_id as unsigned)');
		$query = $this->db->get();
		return $result=$query->result();
	}


	

}

?>