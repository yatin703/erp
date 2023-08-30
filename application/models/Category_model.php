<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {



//Used in Main Group Create form for dropdown
	public function select_active_drop_down($table,$company,$language){
		$this->db->select($table.'.*,article_category_master_lang.lang_category_name');
		$this->db->from($table);
		$this->db->join('article_category_master_lang',$table.'.category_id=article_category_master_lang.category_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_category_master_lang.language_id',$language);
		$query = $this->db->get();
		return $query->result();
	}

	
	



}

?>