<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.language_id',$this->session->userdata['logged_in']['language_id']);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.language_id',$this->session->userdata['logged_in']['language_id']);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');	
		$this->db->from($table);	
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.language_id',$this->session->userdata['logged_in']['language_id']);
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
		$this->db->where($table.'.language_id',$this->session->userdata['logged_in']['language_id']);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group');
		$this->db->from($table);
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.language_id',$this->session->userdata['logged_in']['language_id']);
		foreach($data as $key => $value) {
			$this->db->where($table.'.'.$key,$value);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	

}

?>