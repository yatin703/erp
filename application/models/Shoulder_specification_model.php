<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoulder_specification_model extends CI_Model {

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
		$this->db->where($table.'.dyn_qty_present','SHOULDER|1');
		$this->db->order_by('spec_created_date','desc');
		$this->db->order_by('spec_id','desc');
		$this->db->order_by('spec_version_no','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
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
		$this->db->where($table.'.dyn_qty_present','SHOULDER|1');
		$this->db->order_by('spec_created_date','desc');
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


		public function select_one_active_unapproved_record($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3){
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
			$this->db->where($pkey3,$edit3);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function select_details_record_where($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$orderby,$order){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->order_by($orderby,$order);
		$query = $this->db->get();
		return $query->result();
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

	public function select_specification_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(spec_version_no)+1 as spec_version_no,spec_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_specification_final_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(spec_version_no) as spec_version_no,spec_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$data,$from,$to,$company){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($table.'.dyn_qty_present','CAP|1');
			foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.spec_created_date >=', $from);
		$this->db->where(''.$table.'.spec_created_date <=', $to);
		}
		
		$this->db->order_by('spec_created_date','desc');
		$this->db->order_by('spec_id','desc');
		$this->db->order_by('spec_version_no','desc');
			$query = $this->db->get();
			return $result=$query->result();
		}


		public function select_specification_final_version($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$col,$priority){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->order_by($col,$priority);
		$this->db->limit(1,0);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_details_record_for_jobcard_where($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4,$orderby,$order,$orderby2,$order2){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where($pkey4,$edit4);
		$this->db->order_by($orderby,$order);
		$this->db->order_by($orderby2,$order2);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_details_record_for_jobcard_where_gauge($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4,$pkey5,$edit5,$orderby,$order,$orderby2,$order2){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where($pkey4,$edit4);
		$this->db->where($pkey5,$edit5);
		$this->db->order_by($orderby,$order);
		$this->db->order_by($orderby2,$order2);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_details_record_for_jobcardprint_where_gauge($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4,$pkey5,$edit5,$orderby,$order,$orderby2,$order2){
		$this->db->select('specification_sheet_details.*,GROUP_CONCAT(" ",specification_sheet_details.mat_article_no) as rm,GROUP_CONCAT(" ",specification_sheet_details.mat_info) as rm_per');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->where($pkey4,$edit4);
		$this->db->where($pkey5,$edit5);
		$this->db->where('mat_info<>','');
		$this->db->order_by($orderby,$order);
		$this->db->order_by($orderby2,$order2);
		$this->db->group_by($orderby2);
		$query = $this->db->get();
		return $query->result();
	}



	public function select_cap_one_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where('article_name_info.main_group_id','41');
			$this->db->like($pkey,$edit,'after');
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function select_one_active_record_cap($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->like($pkey,$edit,'after');
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}


		public function select_cap_specification_final_verion_no($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select('max(spec_version_no) as spec_version_no,spec_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$query = $this->db->get();
		return $query->result();
	}

	public function active_record_search_new($table,$data,$search,$from,$to,$company){
		$sql="";
		$sql.= "SELECT * FROM 
					( 	select 
							a.company_id,
							spec_id,
							spec_version_no,
							spec_created_date,
							a.article_no,
							b.lang_article_description as article_name,
							final_approval_flag,
					   		approval_date,
					   		approved_by,
					   		a.user_id,
					   		u.login_name as username,
					   		u1.login_name as approval_username,
					   		a.archive,
					   		a.dyn_qty_present,
					   		a.pending_flag
					   		
					   	FROM  specification_sheet a INNER JOIN article_name_info b on a.article_no=b.article_no
					   	INNER JOIN user_master u on a.user_id=u.user_id
					   	LEFT JOIN user_master u1 on a.user_id=u1.user_id
					 	WHERE dyn_qty_present='SHOULDER|1' AND a.archive <> 1 AND a.company_id='$company' AND b.company_id='$company'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND a.spec_created_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND ".$key."='".$value."'";
							}
	   					}
		    $sql.= ") A,
					( select spec_id,spec_version_no,
							MAX(CASE WHEN item_group_id =4 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_DIA',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='STYLE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_STYLE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='NECK TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_NECK',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_ORIFICE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN mat_article_no END) AS 'SHOULDER_FOIL_TAG',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'SHOULDER_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_info  END) AS 'SHOULDER_MB_PERC',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN supplier_no  END) AS 'SHOULDER_MB_SUPPLIER',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE ONE' THEN mat_article_no  END) AS 'SHOULDER_HDPE_ONE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE ONE' THEN mat_info  END) AS 'SHOULDER_HDPE_ONE_PER',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE TWO' THEN mat_article_no  END) AS 'SHOULDER_HDPE_TWO',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE TWO' THEN mat_info  END) AS 'SHOULDER_HDPE_TWO_PER'
							FROM specification_sheet_details
							WHERE company_id='000020'
					  GROUP BY spec_id,spec_version_no
					) D
				WHERE A.spec_id=D.spec_id
				AND A.spec_version_no=D.spec_version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {						
						$sql.=" AND ".$key." like '".$value."%'";										    
					}
			    }

			   //echo $sql;
       
			$query = $this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
		}

	public function approved_record_search_for_bom($table,$edit,$company){
			$query=$this->db->query("SELECT S.article_no, ANI.lang_article_description,A.main_group_id, ANI.lang_sub_description FROM $table S LEFT JOIN   article A ON S.article_no=A.article_no LEFT JOIN article_name_info ANI ON A.article_no=ANI.article_no  WHERE   S.company_id='$company' AND S.archive <>1 AND S.final_approval_flag=1  AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id  in('46','41') AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.lang_sub_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");		
			//echo $this->db->last_query();
			return $result=$query->result();
	}




}

?>