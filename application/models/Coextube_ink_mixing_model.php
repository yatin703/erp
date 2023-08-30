<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coextube_ink_mixing_model extends CI_Model {

    
    public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function active_details_records($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);

		//$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	  
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description ,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				if($key=='article_name_info.lang_article_description'){
					$this->db->where($key,$value);
				}else{
					$this->db->like($key,$value);
				}
				
			}
		}

		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.main_group_id', '1');
		$this->db->where($table.'.article_group_id', '13');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->where('article_second_subgroup_desc.company_id',$company);
		
		$this->db->where('article_name_info.company_id',$company);
		//$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->order_by('article_name_info.article_no','desc');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search_for_jobsetup($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_1($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if($from!='' && $to!=''){
			$this->db->where('ink_mixing_date>=',$from);
			$this->db->where('ink_mixing_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_one_active_record_2($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function get_pantone_code($pantone_code){
        $resultdata=array();
        $query = $this->db->query("SELECT pantone_code, REGEXP_REPLACE(REPLACE(pantone_code,' ',''), '[^a-zA-Z0-9]+', '') AS `code` FROM coextube_ink_mixing_master WHERE REGEXP_REPLACE(REPLACE(pantone_code,' ',''), '[^a-zA-Z0-9]+', '') LIKE '%$pantone_code%' ");
       
        if (!empty($query)) { 
            $data=array();
            foreach ($query->result_array() as $item) {
                $resultdata[] = array(
                 "pantone_code" => $item['code'],
              );
        
            }
        }
        
      return $resultdata;
    }


    public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);	 
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	 public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->order_by($table.'.dpr_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}






}