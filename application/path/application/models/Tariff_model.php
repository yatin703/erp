<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tariff_model extends CI_Model {



//Used in Main Group Create form for dropdown
	public function select_active_drop_down($table,$company,$language){
		$this->db->select($table.'.*,excise_rates_master_lang.lang_tariff_heading as tariff_heading,excise_rates_master_lang.lang_tariff_descr as tariff_desciption');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('excise_rates_master_lang.language_id',$language);
		$query = $this->db->get();
		return $query->result();
	}

	
	public function select_one_active_record($table,$pkey,$edit,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('excise_rates_master_lang.language_id','1');
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_archive_record($table,$pkey,$edit,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('excise_rates_master_lang.language_id','1');
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('excise_rates_master_lang.language_id','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('cast('.$table.'.erm_id as unsigned)','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id');
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('excise_rates_master_lang.language_id','1');
		$this->db->limit($limit, $start);
		$this->db->order_by('cast('.$table.'.erm_id as unsigned)','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('excise_rates_master_lang',$table.'.erm_id=excise_rates_master_lang.erm_id');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('excise_rates_master_lang.language_id','1');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->order_by('cast('.$table.'.erm_id as unsigned)','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function update_one_active_record($table,$data,$pkey,$edit,$company){
		$this->db->where($pkey, $edit);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);

		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}
	


}

?>