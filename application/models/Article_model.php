<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_nam.company_id',$company);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,tally_stock_items_master.igst,tally_stock_items_master.cgst,tally_stock_items_master.utgst,uom_master.lang_uom_short as uom,uom_master.uom_id as uom_id,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('tally_stock_items_master',$table.'.article_no=tally_stock_items_master.part_no','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		//$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom,uom_master.uom_id as uom_id,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('excise_rates_master',$table.'.excise_rate_id=excise_rates_master.erm_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		//$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$company,$from,$to){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		foreach($data as $key => $value) {
			if($key=='article_name_info.lang_article_description')
			{$this->db->like($key,$value);}
			else{ $this->db->where($key,$value);}
		}
		if($from!='' && $to!=''){

			$this->db->where($table.'.article_date>=', $from);
			$this->db->where($table.'.article_date<=', $to);
			$where='left(created_date,10) between "'.$from.'" AND "'.$to.'"';
			$this->db->or_where($where);
		}
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


//Sales Order Create form
	public function finish_good_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN ('3','41','43','47','27','34')
								AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%'  )  ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}

	public function finish_good_active_record_search_springtube($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='3'AND A.article_group_id in('314','315','328','329','353') AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}

	public function finish_good_active_record_search_coextube($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='3'AND A.article_group_id in('314','315','328','329') AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}

	//Purchase Order Create form Raw material has to add and remove on 1st day of Month	

	public function mannual_issue_active_record_search($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('1','8','6','13','9','26','43','25','23','39','16','20','21','26','24','49') AND A.article_group_id NOT IN('6','7','8','9','12','14','15','16','186','213','304') AND  ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%') ORDER BY ANI.lang_article_description");

		//echo $this->db->last_query();
		return $result=$query->result();


	}
	public function mannual_issue_active_record_search_open($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('1','5','6','7','8','13','9','26','43','25','23','39','16','20','21','26','24','49','41','47','42','46')   AND  ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%') ORDER BY ANI.lang_article_description");

		//echo $this->db->last_query();
		return $result=$query->result();


	}

	public function purchase_good_active_record_search($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('1','8','6','13','7','5','9','41','47','26','43','25','23','39','16','20','21','26','24','49') AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%' OR ANI.lang_sub_description like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();

	}


	public function packing_good_active_record_search($table,$edit,$company){
		
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('9')
								AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();

	}

	public function raw_material_active_record_search($table,$edit,$company){
		
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('1')
								AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();

	}
	public function raw_material_search_for_tally($table,$edit,$company){
		
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id IN('1','41')
								AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();

	}


	public function spec_active_record_search($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' 
								AND ANI.company_id =  '$company' AND A.article_group_id='$edit' AND A.spec_item_flag='1' ORDER BY ANI.lang_article_description");

		return $result=$query->result();

	}

	public function spec_all_active_record_search($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.article_group_id='$edit' ORDER BY A.temporary_article DESC, ANI.lang_article_description");
	//echo $this->db->last_query();
	return $result=$query->result();

	}

	public function spec_all_active_record_search_foil($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.sub_sub_grp_id='265' ORDER BY A.temporary_article DESC, ANI.lang_article_description");
	//echo $this->db->last_query();
	return $result=$query->result();

	}

	public function spec_all_active_record_search_cap_foil($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.sub_sub_grp_id='266' ORDER BY A.temporary_article DESC, ANI.lang_article_description");
	//echo $this->db->last_query();
	return $result=$query->result();

	}

	public function spec_all_active_record_search_cold_foil($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.sub_sub_grp_id='234' ORDER BY A.temporary_article DESC, ANI.lang_article_description");
	//echo $this->db->last_query();
	return $result=$query->result();

	}

	public function spec_all_active_record_search_uvblocker($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.article_group_id='$edit' AND  A.sub_sub_group_id='250' ORDER BY ANI.lang_article_description");
	return $result=$query->result();

	}

	public function spec_all_active_record_search_purging($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND A.article_group_id in(186,7) ORDER BY ANI.lang_article_description");
	return $result=$query->result();

	}

	public function select_all_cold_foils(){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '000020' AND ANI.company_id =  '000020' AND A.main_group_id='1' AND A.article_group_id='304' AND A.sub_sub_grp_id='234' ORDER BY ANI.lang_article_description");
	return $result=$query->result();

	}


	public function update_one_active_record_where($table,$data,$pkeys,$company){
		if(!empty($pkeys)){
			foreach ($pkeys as $key => $value) {
				$this->db->where($key, $value);
			}
			$this->db->where('company_id', $company);
			$result=$this->db->update($table,$data);
			if($result){
				return $falg=1;
			}else{
				return $falg=0;
			}
		}else{
			return $falg=0;
		}
	}


	public function select_article_supplier($table,$pkey,$edit){
		$this->db->select($table.'.*,alternative_supplier_lang.lang_info,address_master.adr_company_id,address_master.name1,address_master.name3');
		$this->db->from($table);
		$this->db->join('alternative_supplier_lang',$table.'.article_no=alternative_supplier_lang.article_no','LEFT');
		
		$this->db->join('address_master',$table.'.supplier_no=address_master.adr_company_id','LEFT');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$this->session->userdata['logged_in']['company_id']);
		$this->db->where('alternative_supplier_lang.company_id',$this->session->userdata['logged_in']['company_id']);
		$this->db->where('alternative_supplier_lang.language_id',$this->session->userdata['logged_in']['language_id']);
		$this->db->where($table.'.supplier_no=alternative_supplier_lang.supplier_no');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	public function select_article_customer($table,$pkey,$edit){
		$this->db->select($table.'.*,address_master.adr_company_id,address_master.name1,address_master.name3');
		$this->db->from($table);
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$this->session->userdata['logged_in']['company_id']);
		$this->db->where('address_master.archive<>','1');
		$this->db->where('address_master.company_id',$this->session->userdata['logged_in']['company_id']);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function waste_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='12' AND A.article_group_id='202' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}

	public function spring_film_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='42' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}
	public function sleeve_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='45' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}
	public function shoulder_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='46' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}
	public function cap_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='47' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}
	public function label_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='44' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}

	public function paper_film_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id,ANI.lang_sub_description FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.article_group_id ='340' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%') ORDER BY ANI.lang_article_description");

		return $result=$query->result();
	}



	public function active_record_search_tally($table,$data,$company,$from,$to){
		$this->db->select($table.'.*,article_group_desc.lang_article_group_desc as sub_group,article_group_desc.lang_short_desc as sub_group_short_id,article_main_group.lang_main_group_desc as main_group,article_main_group.lang_short_desc as main_group_short_id,article_second_subgroup_desc.lang_article_second_subgroup_desc as second_sub_group,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,uom_master.lang_uom_short as uom');
		$this->db->from($table);
		$this->db->join('uom_master',$table.'.uom=uom_master.uom_id','LEFT');
		$this->db->join('article_second_subgroup_desc',$table.'.sub_sub_grp_id=article_second_subgroup_desc.sub_sub_grp_id','LEFT');
		$this->db->join('article_group_desc',$table.'.article_group_id=article_group_desc.article_group_id','LEFT');
		$this->db->join('article_main_group',$table.'.main_group_id=article_main_group.main_group_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		
		//$this->db->where($table.'.article_modified_date>=', $from);
		//$this->db->where($table.'.article_modified_date<=', $to);
		$this->db->where($table.'.article_date>=', $from);
		$this->db->where($table.'.article_date<=', $to);

		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		//$this->db->where('article_second_subgroup_desc.company_id',$company);
		$this->db->order_by('article_name_info.article_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function springtube_printing_ink_lacquer($table,$data,$company){
		
		$this->db->select('article.article_no,article_name_info.lang_article_description,article.main_group_id,article_name_info.lang_sub_description');
		$this->db->from($table);
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->where($table.'.main_group_id', '1');
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$this->db->where_in($table.'.article_group_id',['13','14','304']);
		//$this->db->where_in($table.'.sub_sub_grp_id',['5','7','8','9','230']);
		$this->db->order_by('article_name_info.lang_article_description','asc');
		//echo $this->db->last_query();
		$query = $this->db->get();
		return $result=$query->result();

	}
	// Glue is added on 17-Nov-2020 on Atul's call for glue....
	public function select_only_printing_ink_lacquer($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND A.main_group_id ='1' AND A.article_group_id in(13,14,304) AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%')  ORDER BY ANI.lang_article_description");
	return $result=$query->result();

	}

	public function select_any_article($table,$edit,$company){
	$query=$this->db->query("SELECT ANI.article_no,ANI.lang_article_description,ANI.lang_sub_description FROM article A,article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '$company' AND ANI.company_id =  '$company' AND ( ANI.lang_article_description LIKE '%$edit%' OR ANI.article_no like  '%$edit%')  ORDER BY ANI.lang_article_description");
	return $result=$query->result();

	}

	public function get_inv_name($main_group,$sub_group,$second_sub_group,$article_description){
        $resultdata=array();
        $query = $this->db->query("SELECT lang_article_description, REGEXP_REPLACE(REPLACE(lang_article_description,' ',''), '[^a-zA-Z0-9]+', '') AS `article_name` FROM article_name_info WHERE main_group_id = '$main_group' and article_group_id='$sub_group' and sub_sub_grp_id='$second_sub_group' and REGEXP_REPLACE(REPLACE(lang_article_description,' ',''), '[^a-zA-Z0-9]+', '') LIKE '%$article_description%' ");
       
        if (!empty($query)) { 
            $data=array();
            foreach ($query->result_array() as $item) {
                $resultdata[] = array(
                 "article_description" => $item['article_name'],
              );
        
            }
        }
        
      return $resultdata;
    }

}

?>