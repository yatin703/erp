<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Second_sub_group_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$array=array('ATHAL 2 LEASEHOLD IMPROVEMENTS',
						'BUILDING AND LEASEHOLD',
						'BUSINESS PROMOTION',
						'CAP',
						'CAPITAL ITEM',
						'CLEANING AND GENERAL MATERIAL',
						'COMPUTER PARTS',
						'CONSUMABLE',
						'CONSUMABLE SPRING TUBE',
						'DEVELOPMENT EXPENSE',
						'DEVELOPMENT INCOME',
						'EQUIPMENT',
						'FINISHED GOODS',
						'FURNITURE',
						'HVAC SYSTEM',
						'LABEL',
						'LAMINATE FILM',
						'MACHINES',
						'MOULDS, TOOLS, AND DIES',
						'OFFICE EQUIPMENT',
						'OTHER CHARGES',
						'PACKING MATERIAL',
						'PLANT AND MACHINERY',
						'POWER AND FUEL',
						'PROJECT FLEXO',
						'PROJECT SPRING TUBE',
						'RAW MATERIAL',
						'SALE OF TOOLING',
						'SHOULDER',
						'STORES AND SPARES',
						'STORES AND SPARES - IMPORT',
						'WASTE AND SCRAP',
					);
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id,excise_rates_master_lang.lang_tariff_descr as hsn_desc');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('excise_rates_master_lang','excise_rates_master.erm_id=excise_rates_master_lang.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->where_in('article_main_group.lang_main_group_desc',$array);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.sub_sub_grp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.sub_sub_grp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}


	//used in  Item Master Create form
	public function select_active_drop_down($table,$company,$language){
		$this->db->select($table.'.*,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.language_id',$language);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_records_where($table,$data,$company){
		$this->db->select($table.'.*,account_head_lang.lang_description as account_head,article_category_master_lang.lang_category_name as category,excise_rates_master.cetsh_no as tariff_no,cost_centre_lang.lang_description as cost_center,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_second_subgroup_desc.lang_short_desc as second_sub_group_short_id');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('account_head_lang',$table.'.account_head_id=account_head_lang.account_head_id','LEFT');
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->join('cost_centre_lang',$table.'.cost_centre_id=cost_centre_lang.cost_centre_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_second_subgroup_desc.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}		
		$this->db->order_by($table.'.sub_sub_grp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

}

?>