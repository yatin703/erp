<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$language){
		$this->db->select('property_master.*,master_property_master.lang_master_property_descr');
		$this->db->from($table);
		$this->db->join('master_property_master','property_master.master_property_id=master_property_master.master_property_id','LEFT');
		$this->db->where('property_master.archive<>','1');
		$this->db->where('master_property_master.language_id',$language);
		$this->db->where('property_master.language_id',$language);
		$this->db->order_by('property_master.property_id','desc');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function select_archive_records($limit,$start,$table,$language){
		$this->db->select('property_master.*,master_property_master.lang_master_property_descr');
		$this->db->from($table);
		$this->db->join('master_property_master','property_master.master_property_id=master_property_master.master_property_id','LEFT');
		$this->db->where('property_master.archive','1');
		$this->db->where('master_property_master.language_id',$language);
		$this->db->where('property_master.language_id',$language);
		$this->db->order_by('property_master.property_id','desc');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function active_record_search($table,$data,$language){
		$this->db->select('property_master.*,master_property_master.lang_master_property_descr');
		$this->db->from($table);
		$this->db->join('master_property_master','property_master.master_property_id=master_property_master.master_property_id','LEFT');
		$this->db->where('property_master.archive<>','1');
		$this->db->where('master_property_master.language_id',$language);
		$this->db->where('property_master.language_id',$language);
		foreach($data as $key => $value) {
			$this->db->like('property_master.'.$key, $value);
		}
		
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_active_drop_down_master_property($table,$language){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.".language_id",$language);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record_noncompany_withlanguage($table,$pkey,$edit,$language){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>', '1');
		$this->db->where('language_id', $language);
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_archive_record_noncompany_withlanguage($table,$pkey,$edit,$language){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive', '1');
		$this->db->where('language_id', $language);
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_one_active_record_noncompany_withlanguage($table,$data,$pkey,$edit,$language){
		$this->db->where($pkey, $edit);
		$this->db->where('language_id', $language);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}

}

?>