<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sleeve_specification_model extends CI_Model {

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
		$this->db->like($table.'.dyn_qty_present','SLEEVE|');
		$this->db->where($table.'.spec_created_date>','2018-12-10');
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
		$this->db->like($table.'.dyn_qty_present','SLEEVE|');
		$this->db->where($table.'.spec_created_date>','2018-12-10');
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
		//$query1 = $this->db->query("optimize table specification_sheet_details");
		//$query1->result();
		//echo $this->db->last_query();

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
					 	WHERE a.dyn_qty_present like 'SLEEVE%' AND a.archive <> 1 AND a.company_id='$company' AND b.company_id='$company' AND a.spec_created_date>='2018-10-17'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND a.spec_created_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND a.".$key."='".$value."'";
							}
	   					}
		$sql.= ") A,
					( select spec_id,spec_version_no,
						MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_DIA',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_LENGTH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=1 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=1 THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=1 THEN mat_info  END) AS 'SLEEVE_MB_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' THEN supplier_no  END) AS 'SLEEVE_MB_SUPPLIER',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_article_no END) AS 'SLEEVE_LDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_info  END) AS 'SLEEVE_LDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_article_no END) AS 'SLEEVE_LLDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_info  END) AS 'SLEEVE_LLDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=1 THEN mat_article_no END) AS 'SLEEVE_HDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=1 THEN mat_info  END) AS 'SLEEVE_HDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=2 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_info  END) AS 'SLEEVE_MB_PERC_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=2 THEN mat_article_no END) AS 'SLEEVE_LDPE_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=2 THEN mat_info  END) AS 'SLEEVE_LDPE_PERC_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_article_no END) AS 'SLEEVE_LLDPE_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_info  END) AS 'SLEEVE_LLDPE_PERC_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_article_no END) AS 'SLEEVE_HDPE_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_info  END) AS 'SLEEVE_HDPE_PERC_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=2 THEN mat_article_no END) AS 'SLEEVE_ADMER_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=2 THEN mat_info  END) AS 'SLEEVE_ADMER_PERC_2',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=3 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=3 THEN mat_article_no END) AS 'SLEEVE_EVOH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=3 THEN mat_info  END) AS 'SLEEVE_EVOH_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=3 THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=3 THEN mat_info  END) AS 'SLEEVE_MB_PERC_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=3 THEN mat_article_no END) AS 'SLEEVE_LDPE_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=3 THEN mat_info  END) AS 'SLEEVE_LDPE_PERC_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=3 THEN mat_article_no END) AS 'SLEEVE_LLDPE_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=3 THEN mat_info  END) AS 'SLEEVE_LLDPE_PERC_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=3 THEN mat_article_no END) AS 'SLEEVE_HDPE_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=3 THEN mat_info  END) AS 'SLEEVE_HDPE_PERC_3',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=4 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE_4',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=4 THEN mat_article_no END) AS 'SLEEVE_ADMER_4',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=4 THEN mat_info  END) AS 'SLEEVE_ADMER_PERC_4',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=5 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=5 THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=5 THEN mat_info  END) AS 'SLEEVE_MB_PERC_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=5 THEN mat_article_no END) AS 'SLEEVE_LDPE_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=5 THEN mat_info  END) AS 'SLEEVE_LDPE_PERC_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=5 THEN mat_article_no END) AS 'SLEEVE_LLDPE_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=5 THEN mat_info  END) AS 'SLEEVE_LLDPE_PERC_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=5 THEN mat_article_no END) AS 'SLEEVE_HDPE_5',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=5 THEN mat_info  END) AS 'SLEEVE_HDPE_PERC_5'
						FROM specification_sheet_details
						WHERE company_id='000020'
					  GROUP BY spec_id,spec_version_no
					) D
				WHERE A.spec_id=D.spec_id
				AND A.spec_version_no=D.spec_version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {						
							
								$sql.=" AND ".$key."= '".$value."'";
												    
						
						
					}
			    }

			   //echo $sql;
       
			$query = $this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
		}


	public function approved_record_search_for_bom($table,$edit,$company){
			$query=$this->db->query("SELECT S.article_no, ANI.lang_article_description,A.main_group_id,A.article_group_id,ANI.lang_sub_description FROM $table S LEFT JOIN   article A ON S.article_no=A.article_no LEFT JOIN article_name_info ANI ON A.article_no=ANI.article_no  WHERE S.company_id='$company' AND S.archive <>1 AND S.final_approval_flag=1  AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN ('45','42')  AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.lang_sub_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");		
			
			return $result=$query->result();
	}


	public function select_film_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->like($table.'.dyn_qty_present','FILM|7');
		$this->db->where($table.'.spec_created_date>','2018-12-10');
		$this->db->order_by('spec_created_date','desc');
		$this->db->order_by('spec_id','desc');
		$this->db->order_by('spec_version_no','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


		public function active_record_search_for_spring_film($table,$data,$search,$from,$to,$company){
		//$query1 = $this->db->query("optimize table specification_sheet_details");
		//$query1->result();
		//echo $this->db->last_query();

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
					 	WHERE a.dyn_qty_present like 'FILM%' AND a.archive <> 1 AND a.company_id='$company' AND b.company_id='$company' AND a.spec_created_date>='2019-09-01'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND a.spec_created_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND a.".$key."='".$value."'";
							}
	   					}
		$sql.= ") A,
					( select spec_id,spec_version_no,

						MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_DIA',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_LENGTH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=1 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_1_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_article_no END) AS 'LAYER_1_LDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_info  END) AS 'LAYER_1_LDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_article_no END) AS 'LAYER_1_LLDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_info  END) AS 'LAYER_1_LLDPE_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=2 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_2_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_article_no END) AS 'LAYER_2_MASTER_BATCH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_info  END) AS 'LAYER_2_MB_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=2 THEN mat_article_no END) AS 'LAYER_2_LDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=2 THEN mat_info  END) AS 'LAYER_2_LDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_article_no END) AS 'LAYER_2_LLDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_info  END) AS 'LAYER_2_LLDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_article_no END) AS 'LAYER_2_HDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_info  END) AS 'LAYER_2_HDPE_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=3 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_3_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=3 THEN mat_article_no END) AS 'LAYER_3_ADMER',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=3 THEN mat_info  END) AS 'LAYER_3_ADMER_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=4 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_4_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=4 THEN mat_article_no END) AS 'LAYER_4_EVOH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=4 THEN mat_info  END) AS 'LAYER_3_EVOH_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=5 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_5_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=5 THEN mat_article_no END) AS 'LAYER_5_ADMER',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=5 THEN mat_info  END) AS 'LAYER_5_ADMER_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=6 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_6_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=6 THEN mat_article_no END) AS 'LAYER_6_MASTER_BATCH',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=6 THEN mat_info  END) AS 'LAYER_6_MB_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=6 THEN mat_article_no END) AS 'LAYER_6_LDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=6 THEN mat_info  END) AS 'LAYER_6_LDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=6 THEN mat_article_no END) AS 'LAYER_6_LLDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=6 THEN mat_info  END) AS 'LAYER_6_LLDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=6 THEN mat_article_no END) AS 'LAYER_6_HDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=6 THEN mat_info  END) AS 'LAYER_6_HDPE_PERC',

						MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=7 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'LAYER_7_GUAGE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=7 THEN mat_article_no END) AS 'LAYER_7_LDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=7 THEN mat_info  END) AS 'LAYER_7_LDPE_PERC',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=7 THEN mat_article_no END) AS 'LAYER_7_LLDPE',
						MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=7 THEN mat_info  END) AS 'LAYER_7_LLDPE_PERC'					
						
						
						FROM specification_sheet_details
						WHERE company_id='000020'
					  GROUP BY spec_id,spec_version_no
					) D
				WHERE A.spec_id=D.spec_id
				AND A.spec_version_no=D.spec_version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {						
							
								$sql.=" AND ".$key."= '".$value."'";
												    
						
						
					}
			    }

			   //echo $sql;
       
			$query = $this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
		}


}

?>