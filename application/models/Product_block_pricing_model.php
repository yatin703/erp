<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_block_pricing_model extends CI_Model {


	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,product_block_pricing_master.block_name,product_block_pricing_master.block_from,product_block_pricing_master.block_to,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing_master',$table.'.pbpm_id=product_block_pricing_master.pbpm_id','LEFT');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');

		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->group_by($table.'.article_no');
		//$this->db->group_by($table.'.version_no');
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.pg_no','desc');
		$this->db->order_by($table.'.pbpm_id','asc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_inactive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,product_block_pricing_master.block_name,product_block_pricing_master.block_from,product_block_pricing_master.block_to,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing_master',$table.'.pbpm_id=product_block_pricing_master.pbpm_id','LEFT');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->group_by($table.'.article_no');
		//$this->db->group_by($table.'.version_no');
		$this->db->limit($limit, $start);
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	
	public function select_product_block_pricing_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(version_no)+1 as version_no,article_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	

	public function select_distinct_product($table,$company){
		$this->db->select('article_no,version_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->group_by('article_no');
		$this->db->group_by('version_no');
		$query = $this->db->get();
		return $query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,product_block_pricing_master.block_name,product_block_pricing_master.block_from,product_block_pricing_master.block_to,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing_master',$table.'.pbpm_id=product_block_pricing_master.pbpm_id','LEFT');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_distinct_price_grid($table,$edit,$company){
		$this->db->select('pg_no,price_list_name');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->or_like('price_list_name',$edit);
		$this->db->or_like('pg_no',$edit);
		$this->db->group_by('pg_no');
		$this->db->group_by('price_list_name');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_distinct_price_grid_by_customer($table,$edit,$company){
		$this->db->select('pg_no,price_list_name');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('adr_category_id',$edit);
		$this->db->group_by('pg_no');
		$this->db->group_by('price_list_name');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_distinct_price_grid_dropdown($table,$company){
		$this->db->select('pg_no,price_list_name');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->order_by('price_list_name','asc');
		$this->db->group_by('pg_no');
		$this->db->group_by('price_list_name');
		$query = $this->db->get();
		return $query->result();
	}


		

}

?>