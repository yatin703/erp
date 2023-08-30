<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order_book_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('address_master',''.$table.'.supplier_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.supplier_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.amendment_flag!=', '1');
		$this->db->where(''.$table.'.po_date >=', $from);
		$this->db->where(''.$table.'.po_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

		$this->db->order_by(' '.$table.'.po_no');
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}

	public function active_record_search_index($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('address_master',''.$table.'.supplier_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.supplier_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.amendment_flag!=', '1');
		$this->db->where(''.$table.'.po_date >=', $from);
		$this->db->where(''.$table.'.po_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->limit($limit, $start);
	    $this->db->order_by(' '.$table.'.po_date','desc');
		$this->db->order_by(' '.$table.'.po_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
		echo $this->db->last_query();
	}

	public function active_details_records($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }	
	 $this->db->order_by('CAST(pur_pos_no as unsigned)','asc'); 
		$query = $this->db->get();
		return $result=$query->result();
		echo $this->db->last_query();
		
	}

//Tax Header
	
	public function fun_tax_header($from,$to,$company){

		//$this->db->distinct();
		$this->db->select('m.po_no,m.po_date,d.tax_pos_no,td.tax_id,td.tax_code,l.lang_tax_code_desc');
		$this->db->from('purchase_order_master m');	
		$this->db->join('purchase_order_details d','m.po_no=d.po_no');
		$this->db->join('tax_grid_details td','d.tax_pos_no=td.tax_id');
		$this->db->join('tax_master t','t.tax_code=td.tax_code');
		$this->db->join('tax_master_lang l','t.tax_code=l.tax_code');
		$this->db->where('m.company_id', $company);
		$this->db->where('m.archive !=', '1');
		$this->db->where('m.po_date >=', $from);
		$this->db->where('m.po_date <=', $to);
		$this->db->group_by('td.tax_code');
		$this->db->order_by('td.priority');
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}


	public function select_tax($table,$company,$pkey,$edit,$order_by){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		//$this->db->where('archive<>', '1');
		$this->db->where($pkey,$edit);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query->result();
	}	


	public function select_specs_record($table,$company,$data){
		$this->db->select("spec_id,spec_version_no,layer_no,
							MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_DIA',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_LENGTH',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' THEN mat_article_no END) AS 'SLEEVE MASTER BATCH',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='PRINT TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_PRINT_TYPE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='NECK TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER NECK TYPE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'SHOULDER ORIFICE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'SHOULDER MASTER BATCH',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'SHOULDER FOIL TAG',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MOLD FINISH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP MOLD FINISH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP ORIFICE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'CAP MASTER BATCH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP FOIL COLOR',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL WIDTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP FOIL WIDTH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='HEIGHT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP HEIGHT'
							");
		$this->db->from($table);
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.layer_no', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
        $this->db->group_by('spec_id');
		$query = $this->db->get();
		return $result=$query->result();
		//echo $this->db->last_query();
	}


	public function select_active_records($limit,$start,$table,$company){
		$query=$this->db->query("SELECT YEAR(order_date) as year, MONTH (order_date) as month,count(*) as order_count,
				sum(if(for_export=0,1,0)) as Local,sum(if(for_export=0,total_amount,0)) as local_value,
				sum(if(for_export=0 AND for_sampling=1,1,0)) as Local_sample,sum(if(for_export=0 AND for_sampling=1,total_amount,0)) as Local_sample_value,

				sum(if(for_export=1,1,0)) as Export,sum(if(for_export=1,total_amount,0)) as export_value, 
				sum(if(for_export=1 AND for_sampling=1,1,0)) as Export_sample,sum(if(for_export=1 AND for_sampling=1,total_amount,0)) as Export_sample_value 
				FROM `order_master`  where final_approval_flag='1' group By YEAR(order_date), MONTH(order_date) order by order_date desc limit 0,10");
		return $result=$query->result();
	}


	public function select_top_customers_orders($limit,$start,$table,$company,$year,$month){
		$start=(empty($start) ? $start=0 : $start);
		$query=$this->db->query("SELECT sum(order_details.total_order_quantity) as quantity,YEAR(order_master.order_date) as year, Month(order_master.order_date) as month,MONTHNAME (order_master.order_date) as month_name,order_master.customer_no,address_master.name1 as customer_name,count(*) as total_order,
		sum(if(order_master.for_export=0,1,0)) as local,sum(if(order_master.for_export=0,order_master.total_amount,0)) as local_value,
		sum(if(order_master.for_export=0 AND order_master.for_sampling=1,1,0)) as local_sample,sum(if(order_master.for_export=0 AND order_master.for_sampling=1,order_master.total_amount,0)) as local_sample_value,

		sum(if(order_master.for_export=1,1,0)) as export,sum(if(order_master.for_export=1,total_amount,0)) as export_value, 
		sum(if(order_master.for_export=1 AND order_master.for_sampling=1,1,0)) as export_sample,sum(if(order_master.for_export=1 AND order_master.for_sampling=1,order_master.total_amount,0)) as export_sample_value 
		FROM `order_master`  JOIN address_master ON address_master.adr_company_id=order_master.customer_no JOIN order_details ON order_details.order_no=order_master.order_no where order_master.final_approval_flag='1' AND  YEAR(order_master.order_date)='$year' AND Month(order_master.order_date)='$month' group By YEAR(order_master.order_date), MONTH(order_master.order_date),order_master.customer_no order by year desc, Month desc, local_value desc,export_value desc limit $start,$limit");

		return $result=$query->result();

	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_master.name1 as supplier_name,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.name3,address_master.isdn_local,address_master.email,zip_code_master.state_code,zip_code_master.lang_city');
		$this->db->from($table);
		$this->db->join('address_master',$table.'.supplier_no=address_master.adr_company_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}




}

?>