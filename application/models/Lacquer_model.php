<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Lacquer_model extends CI_Model {

public function select_active_records($limit,$start,$table,$company){

		$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,sleeve_diameter_master.sleeve_diameter');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('article_name_info.company_id',$company);
		$this->db->order_by('sleeve_id,cast(length_from as unsigned)');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function select_archive_records($limit,$start,$table,$company){

	$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,sleeve_diameter_master.sleeve_diameter');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where('article_name_info.company_id',$company);
		$this->db->order_by('sleeve_id,cast(length_from as unsigned)');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function select_active_record_search($table,$data,$company){

	$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,sleeve_diameter_master.sleeve_diameter');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('article_name_info.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->order_by('sleeve_id,cast(length_from as unsigned)');
		$query = $this->db->get();
		return $result=$query->result();

	}

	
	



}

?>