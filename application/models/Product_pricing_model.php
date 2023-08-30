<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_pricing_model extends CI_Model {


	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,product_block_pricing.price_list_name,product_block_pricing.pg_no,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing',$table.'.pg_no=product_block_pricing.pg_no','INNER');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');

		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->group_by($table.'.pp_id');
		//$this->db->group_by($table.'.version_no');
		$this->db->limit($limit, $start);
		$this->db->order_by('product_pricing.pp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_inactive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,product_block_pricing.price_list_name,product_block_pricing.pg_no,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing',$table.'.pg_no=product_block_pricing.pg_no','INNER');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');

		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->group_by($table.'.pp_id');
		//$this->db->group_by($table.'.version_no');
		$this->db->limit($limit, $start);
		$this->db->order_by('product_pricing.pp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,product_block_pricing.price_list_name,product_block_pricing.pg_no,address_category_master.category_name');
		$this->db->from($table);
		$this->db->join('product_block_pricing',$table.'.pg_no=product_block_pricing.pg_no','INNER');
		$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->group_by($table.'.pp_id');
		
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function get_price_grid_name($pg_no,$company){
			$this->db->select("*");
			$this->db->from('product_block_pricing');
			$this->db->where('company_id',$company);
			$this->db->where('pg_no',$pg_no);
			$query = $this->db->get();
			$result=$query->result();
			if($result){

				foreach($result as $row){

					return $row->price_list_name;
				
				}
			}
			else{
				return '';
			}
	}

}
?>