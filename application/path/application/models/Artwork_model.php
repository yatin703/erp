<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Artwork_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->order_by('ad_date','desc');
		$this->db->order_by('ad_id','desc');
		$this->db->order_by('version_no','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_details_record_where($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_artwork_final_version($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$col,$priority,$col2,$priority2,$col3,$priority3){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->order_by($col,$priority);
		$this->db->order_by($col2,$priority2);
		$this->db->order_by($col3,$priority3);
		$this->db->limit(1,0);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_artwork_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(version_no)+1 as version_no,ad_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->order_by('ad_date','desc');
			$this->db->limit($limit, $start);
			$query = $this->db->get();
			return $result=$query->result();
		}


		public function select_one_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function select_one_inactive_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}
		
		public function select_one_active_unapproved_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where($table.'.final_approval_flag<>','1');
			$this->db->where($table.'.pending_flag<>','1');
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function update_one_active_record($table,$data,$pkey,$edit,$pkey2,$edit2,$company){
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}

	public function update_details_record_where($table,$data,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$company){
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($pkey3, $edit3);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}


	public function active_record_search_1($table,$data,$from,$to,$company){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.ad_date >=', $from);
		$this->db->where(''.$table.'.ad_date <=', $to);
		}
		
		$this->db->order_by('ad_date','desc');
		$this->db->order_by('ad_id','desc');
		$this->db->order_by('version_no','desc');
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function active_record_search($table,$data,$search,$from,$to,$company){
		$sql="";
		$sql.= "SELECT * FROM 
					( 	select 
							company_id,
							ad_id,
							version_no,
							ad_date,
							adr_company_id,
							article_no,
							final_approval_flag,
					   		approval_date,
					   		approved_by,
					   		user_id,
					   		archive,
					   		other_info,
					   		artwork_image_nm,
					   		pending_flag 
					   	FROM  artwork_devel_master 
					 	WHERE archive <> 1 AND company_id='$company'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND ad_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND ".$key."='".$value."'";
							}
	   					}
		    $sql.= ") A,
					( select 
						ad_id,
						version_no,
					    max(CASE WHEN artwork_para_id=1 THEN parameter_value END) as sleeve_dia,
						max(CASE WHEN artwork_para_id=2 THEN parameter_value END) as sleeve_length,
						max(CASE WHEN artwork_para_id=7 THEN parameter_value END) as sleeve_color,
						max(CASE WHEN artwork_para_id=8 THEN parameter_value END)as print_upto_neck,
						max(CASE WHEN artwork_para_id=11 THEN parameter_value END)as hot_foil,
						max(CASE WHEN artwork_para_id=12 THEN parameter_value END) as lacquer_type,
						max(CASE WHEN artwork_para_id=17 THEN parameter_value END)as print_type,
						max(CASE WHEN artwork_para_id=5 THEN parameter_value END)as non_lacquer_area
					  FROM  artwork_devel_details
					  WHERE company_id='000020'
					  GROUP BY ad_id,version_no
					) D
				WHERE A.ad_id=D.ad_id
				AND A.version_no=D.version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {
						
							if($key=='sleeve_dia'){
							 $value=rtrim(str_replace("MM","",$value));
							 $sql.=" AND ".$key." = '".$value."'";
							}
							else if($key=='hot_foil'){
								$sql.=" AND LENGTH(hot_foil)>5";
							}
							else{
								$sql.=" AND ".$key." like '".$value."%'";
							}					    
						
						
					}
			    }
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();


	}

	public function active_record_search_new($table,$data,$search,$from,$to,$company){
		$sql="";
		$sql.= "SELECT * FROM 
					( 	select 
							company_id,
							ad_id,
							version_no,
							ad_date,
							adr_company_id,
							article_no,
							final_approval_flag,
					   		approval_date,
					   		approved_by,
					   		user_id,
					   		archive,
					   		other_info,
					   		artwork_image_nm,
					   		pending_flag 
					   	FROM  artwork_devel_master 
					 	WHERE archive <> 1 AND company_id='$company'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND ad_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND ".$key."='".$value."'";
							}
	   					}
		    $sql.= ") A,
					( select 
						ad_id,
						version_no,
					    max(CASE WHEN artwork_para_id=1 THEN parameter_value END) as sleeve_dia,
						max(CASE WHEN artwork_para_id=2 THEN parameter_value END) as sleeve_length,
						max(CASE WHEN artwork_para_id=7 THEN parameter_value END) as sleeve_color,
						max(CASE WHEN artwork_para_id=8 THEN parameter_value END)as print_upto_neck,
						max(CASE WHEN artwork_para_id=11 THEN parameter_value END)as hot_foil,
						max(CASE WHEN artwork_para_id=12 THEN parameter_value END) as lacquer_type,
						max(CASE WHEN artwork_para_id=17 THEN parameter_value END)as print_type,
						max(CASE WHEN artwork_para_id=5 THEN parameter_value END)as non_lacquer_area,
						max(CASE WHEN artwork_para_id=19 THEN parameter_value END)as screen_ink,
						max(CASE WHEN artwork_para_id=20 THEN parameter_value END)as flexo_ink,
						max(CASE WHEN artwork_para_id=21 THEN parameter_value END)as offset_ink,
						max(CASE WHEN artwork_para_id=22 THEN parameter_value END)as special_ink,
						max(CASE WHEN artwork_para_id=23 THEN parameter_value END)as hot_foil_1,
						max(CASE WHEN artwork_para_id=24 THEN parameter_value END)as hot_foil_1_per_tube,
						max(CASE WHEN artwork_para_id=25 THEN parameter_value END)as hot_foil_2,
						max(CASE WHEN artwork_para_id=26 THEN parameter_value END)as hot_foil_2_per_tube,
						max(CASE WHEN artwork_para_id=27 THEN parameter_value END)as lacquer_1,
						max(CASE WHEN artwork_para_id=28 THEN parameter_value END)as lacquer_1_perc,
						max(CASE WHEN artwork_para_id=29 THEN parameter_value END)as lacquer_2,
						max(CASE WHEN artwork_para_id=30 THEN parameter_value END)as lacquer_2_perc
					  FROM  artwork_devel_details
					  WHERE company_id='000020'
					  GROUP BY ad_id,version_no
					) D
				WHERE A.ad_id=D.ad_id
				AND A.version_no=D.version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {
						
							if($key=='sleeve_dia'){
							 $value=rtrim(str_replace("MM","",$value));
							 $sql.=" AND ".$key." = '".$value."'";
							}
							else if($key=='hot_foil'){
								$sql.=" AND LENGTH(hot_foil)>5";
							}
							else{
								$sql.=" AND ".$key." like '".$value."%'";
							}					    
						
						
					}
			    }
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();


	}

	


		

}

?>