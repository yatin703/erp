<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_of_material_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,a.lang_article_description as article_description,a.lang_sub_description as article_sub_description,sl.lang_article_description as sleeve,sh.lang_article_description as shoulder, c.lang_article_description as cap,l.lang_article_description as label,user_master.login_name as username,u.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as u',$table.'.approved_by=u.user_id','LEFT');
		$this->db->join('article_name_info as a',$table.'.article_no=a.article_no','LEFT');
		$this->db->join('article_name_info as sl',$table.'.sleeve_code=sl.article_no','LEFT');
		$this->db->join('article_name_info as sh',$table.'.shoulder_code=sh.article_no','LEFT');
		$this->db->join('article_name_info as c',$table.'.cap_code=c.article_no','LEFT');
		$this->db->join('article_name_info as l',$table.'.label_code=l.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('a.company_id',$company);
		$this->db->order_by('bom_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,a.lang_article_description as article_description,a.lang_sub_description as article_sub_description,sl.lang_article_description as sleeve,sh.lang_article_description as shoulder, c.lang_article_description as cap,l.lang_article_description as label,user_master.login_name as username,u.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as u',$table.'.approved_by=u.user_id','LEFT');
		$this->db->join('article_name_info as a',$table.'.article_no=a.article_no','LEFT');
		$this->db->join('article_name_info as sl',$table.'.sleeve_code=sl.article_no','LEFT');
		$this->db->join('article_name_info as sh',$table.'.shoulder_code=sh.article_no','LEFT');
		$this->db->join('article_name_info as c',$table.'.cap_code=c.article_no','LEFT');
		$this->db->join('article_name_info as l',$table.'.label_code=l.article_no','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('a.company_id',$company);
		$this->db->order_by('bom_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,a.lang_article_description as article_description,a.lang_sub_description as article_sub_description,sl.lang_article_description as sleeve,sh.lang_article_description as shoulder, c.lang_article_description as cap,l.lang_article_description as label,user_master.login_name as username,u.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as u',$table.'.approved_by=u.user_id','LEFT');
		$this->db->join('article_name_info as a',$table.'.article_no=a.article_no','LEFT');
		$this->db->join('article_name_info as sl',$table.'.sleeve_code=sl.article_no','LEFT');
		$this->db->join('article_name_info as sh',$table.'.shoulder_code=sh.article_no','LEFT');
		$this->db->join('article_name_info as c',$table.'.cap_code=c.article_no','LEFT');
		$this->db->join('article_name_info as l',$table.'.label_code=l.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('a.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,a.lang_article_description as article_description,a.lang_sub_description as article_sub_description,sl.lang_article_description as sleeve,sh.lang_article_description as shoulder, c.lang_article_description as cap,l.lang_article_description as label,user_master.login_name as username,u.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as u',$table.'.approved_by=u.user_id','LEFT');
		$this->db->join('article_name_info as a',$table.'.article_no=a.article_no','LEFT');
		$this->db->join('article_name_info as sl',$table.'.sleeve_code=sl.article_no','LEFT');
		$this->db->join('article_name_info as sh',$table.'.shoulder_code=sh.article_no','LEFT');
		$this->db->join('article_name_info as c',$table.'.cap_code=c.article_no','LEFT');
		$this->db->join('article_name_info as l',$table.'.label_code=l.article_no','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('a.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_records_search($table,$company,$data,$from,$to,$flag){
		$this->db->select($table.'.*,a.lang_article_description as article_description,a.lang_sub_description as article_sub_description,sl.lang_article_description as sleeve,sh.lang_article_description as shoulder, c.lang_article_description as cap,l.lang_article_description as label,user_master.login_name as username,u.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as u',$table.'.approved_by=u.user_id','LEFT');
		$this->db->join('article_name_info as a',$table.'.article_no=a.article_no','LEFT');
		$this->db->join('article_name_info as sl',$table.'.sleeve_code=sl.article_no','LEFT');
		$this->db->join('article_name_info as sh',$table.'.shoulder_code=sh.article_no','LEFT');
		$this->db->join('article_name_info as c',$table.'.cap_code=c.article_no','LEFT');
		$this->db->join('article_name_info as l',$table.'.label_code=l.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		if($from!=''&& $to!=''){
			$this->db->where($table.'.bom_creation_date>=', $from);
			$this->db->where($table.'.bom_creation_date<=', $to);
		}
		$this->db->where('a.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		if($flag!=''){

			$this->db->where('a.main_group_id','3');
			if($flag=='0'){
				$this->db->where_in('a.article_group_id',array("17","18","220","221"));
			}else{
				$this->db->where_in('a.article_group_id',array("314","315","328","329"));
			}			
		
		}
		
		$this->db->order_by('bom_id','desc');		
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function active_records_search_new($table,$company,$from,$to,$data,$search){
		$sql= "SELECT * FROM ( SELECT $table.*,$table.print_type as sleeve_print_type,sl.dyn_qty_present as layer_no,
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='DIA' THEN IF(sld.parameter_value!='',sld.parameter_value,sld.relating_master_value) END) AS 'SLEEVE_DIAMETER',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='LENGTH' THEN IF(sld.parameter_value!='',sld.parameter_value,sld.relating_master_value) END) AS 'SLEEVE_LENGTH',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='MASTER BATCH' AND sld.layer_no=1  THEN sld.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_1',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='MASTER BATCH' AND sld.layer_no=2 THEN sld.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_2',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='MASTER BATCH' AND sld.layer_no=3 THEN sld.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_3',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='MASTER BATCH' AND sld.layer_no=4 THEN sld.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_4',
				MAX(CASE WHEN sld.item_group_id =3 AND sld.parameter_name='MASTER BATCH' AND sld.layer_no=5 THEN sld.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_5',
				MAX(CASE WHEN shd.item_group_id =4 AND shd.parameter_name='DIAMETER' THEN IF(shd.parameter_value!='',shd.parameter_value,shd.relating_master_value) END) AS 'SHOULDER_DIA',
				MAX(CASE WHEN shd.item_group_id =4 AND shd.parameter_name='STYLE' THEN IF(shd.parameter_value!='',shd.parameter_value,shd.relating_master_value) END) AS 'SHOULDER_TYPE',
				MAX(CASE WHEN shd.item_group_id =4 AND shd.parameter_name='ORIFICE' THEN IF(shd.parameter_value!='',shd.parameter_value,shd.relating_master_value) END) AS 'SHOULDER_ORIFICE',
				MAX(CASE WHEN shd.item_group_id =4 AND shd.parameter_name='MASTER BATCH' THEN shd.mat_article_no  END) AS 'SHOULDER_MASTER_BATCH',
				MAX(CASE WHEN shd.item_group_id =4 AND shd.parameter_name='SHOULDER FOIL TAG' THEN shd.mat_article_no  END) AS 'SHOULDER_FOIL',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='DIAMETER' THEN IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value) END) AS 'CAP_DIA',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='STYLE' THEN IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value) END) AS 'CAP_TYPE',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='MOLD FINISH' THEN IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value) END) AS 'CAP_FINISH',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='ORIFICE' THEN IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value) END) AS 'CAP_ORIFICE',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='MASTER BATCH' THEN cpd.mat_article_no  END) AS 'CAP_MASTER_BATCH',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='CAP FOIL COLOR' THEN  IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value)  END) AS 'CAP_FOIL_COLOR',
				MAX(CASE WHEN cpd.item_group_id =5 AND cpd.parameter_name='CAP FOIL WIDTH' THEN  IF(cpd.parameter_value!='',cpd.parameter_value,cpd.relating_master_value)  END) AS 'CAP_FOIL_WIDTH'

				FROM  $table
				INNER JOIN
				specification_sheet sl ON $table.sleeve_code=sl.article_no
				INNER JOIN specification_sheet_details sld ON sl.spec_id=sld.spec_id
				INNER JOIN specification_sheet sh ON $table.shoulder_code=sh.article_no
				INNER JOIN specification_sheet_details shd ON sh.spec_id=shd.spec_id
				INNER JOIN specification_sheet cp ON $table.cap_code=cp.article_no
				INNER JOIN specification_sheet_details cpd ON cp.spec_id=cpd.spec_id
				WHERE sl.spec_version_no=sld.spec_version_no
				AND $table.company_id='$company'
				AND $table.archive<>1
				AND sl.spec_version_no=sld.spec_version_no
				AND sh.spec_version_no=shd.spec_version_no
				AND cp.spec_version_no=cpd.spec_version_no
				AND sl.company_id='$company'
				AND sl.archive<>1
				AND sh.company_id='$company'
				AND sh.archive<>1
				AND cp.company_id='$company'
				AND cp.archive<>1
				AND sl.spec_created_date>='2018-12-10'
				AND sh.spec_created_date>='2018-12-10'
				AND cp.spec_created_date>='2018-12-10'
				";
				if($from!='' AND $to!=''){
					$sql.=" AND $table.bom_creation_date between '$from' AND '$to'";	
				}
				if(!empty($data)){
					foreach($data as $key => $value) {
					$sql.=" AND $table.".$key."='".$value."'";
					}
   				}
	   	$sql.=" GROUP BY $table.bom_id,$table.bom_version_no,sl.spec_id,sl.spec_version_no,sh.spec_id,sh.spec_version_no,cp.spec_id,cp.spec_version_no ) as temp_bill_of_material WHERE 1=1";		
		if(!empty($search)){

			foreach($search as $key => $value) {
				if($key=='layer_no'){
					$sql.=" AND ".$key." like '%".$value."'";	
				}else{
					$sql.=" AND ".$key."='".$value."'";		
				}		
			}
	    }

	    $sql.=" ORDER BY bom_no DESC,bom_version_no DESC";
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_bom_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(bom_version_no)+1 as bom_version_no,bom_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function bom_gauge_total($bom_id){
        $sql="SELECT bm.bom_no,bm.bom_version_no,bm.article_no,bm.sleeve_code,ss.article_no,sl.article_no,sle.article_no,
        MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_1',
           MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_2',
           MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_3',
           MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_4',
           MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_5',
           MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_6',
           MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_7'
       FROM `bill_of_material` as bm
        LEFT JOIN specification_sheet as ss ON bm.shoulder_code = ss.article_no
        LEFT JOIN specification_sheet as sl ON bm.sleeve_code = sl.article_no
        LEFT JOIN specification_sheet as sle ON bm.sleeve_code = sle.article_no
        LEFT JOIN specification_sheet as sc ON bm.cap_code = sc.article_no
        LEFT JOIN specification_sheet_details as sd ON ss.spec_id = sd.spec_id AND ss.spec_version_no =                      sd.spec_version_no
        LEFT JOIN specification_sheet_details as sdl ON sl.spec_id = sdl.spec_id AND sl.spec_version_no =                    sdl.spec_version_no AND sdl.mat_article_no
        LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no =                sdle.spec_version_no
        LEFT JOIN specification_sheet_details as sdc ON sc.spec_id = sdc.spec_id AND sc.spec_version_no =                    sdc.spec_version_no AND sdl.relating_master_value
        where bm.bom_id='$bom_id' ";
        $query=$this->db->query($sql);
        return $result=$query->result();
    }

}
