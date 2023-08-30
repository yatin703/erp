<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Packing_box_model extends CI_Model {

public function select_active_records($limit,$start,$table){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function select_archive_records($limit,$start,$table){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_id=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();

	}

	
	



}

?>