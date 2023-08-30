
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_book_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company,$list_arr){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info,address_master.country_id,country_master_lang.lang_country_name as country_name,country_master.currency_symbol');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('country_master','address_master.country_id=country_master.country_id','LEFT');
		$this->db->join('country_master_lang','country_master.country_id=country_master_lang.country_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($list_arr)){


	    	$this->db->where_in(''.$table.'.order_closed', $list_arr,false);
	    }


		$this->db->order_by(' '.$table.'.order_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function active_record_search_new($table,$data,$from,$to,$company,$list_arr,$approval_from_date,$approval_to_date,$cancelled_from_date,$cancelled_to_date,$oc_from_date,$oc_to_date){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info,address_master.country_id,country_master_lang.lang_country_name as country_name,country_master.currency_symbol');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('country_master','address_master.country_id=country_master.country_id','LEFT');
		$this->db->join('country_master_lang','country_master.country_id=country_master_lang.country_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if($approval_from_date!='' && $approval_to_date!=''){
			$this->db->where(''.$table.'.approval_date >=', $approval_from_date);
			$this->db->where(''.$table.'.approval_date <=', $approval_to_date);
		}
		if($cancelled_from_date!='' && $cancelled_to_date!=''){
			$this->db->where(''.$table.'.trans_closed_date >=', $cancelled_from_date);
			$this->db->where(''.$table.'.trans_closed_date <=', $cancelled_to_date);
		}
		if($oc_from_date!='' && $oc_to_date!=''){
			$this->db->where(''.$table.'.oc_date >=', $oc_from_date);
			$this->db->where(''.$table.'.oc_date <=', $oc_to_date);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($list_arr)){

	    	$this->db->where_in(''.$table.'.order_closed', $list_arr,false);
	    }

		$this->db->order_by(' '.$table.'.order_no');

		$this->db->order_by(' '.$table.'.order_date' ,'asc');
		//$this->db->order_by(' '.$table.'.order_no' ,'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function active_record_oc($table,$data,$from,$to,$company,$list_arr,$approval_from_date,$approval_to_date,$cancelled_from_date,$cancelled_to_date){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info,address_master.country_id,country_master_lang.lang_country_name as country_name,country_master.currency_symbol,address_master.max_lead_time');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('country_master','address_master.country_id=country_master.country_id','LEFT');
		$this->db->join('country_master_lang','country_master.country_id=country_master_lang.country_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.oc_date', '0000-00-00');
		$this->db->where(''.$table.'.final_approval_flag','1');
		$this->db->where(''.$table.'.for_stock','0');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if($approval_from_date!='' && $approval_to_date!=''){
			$this->db->where(''.$table.'.approval_date >=', $approval_from_date);
			$this->db->where(''.$table.'.approval_date <=', $approval_to_date);
		}
		if($cancelled_from_date!='' && $cancelled_to_date!=''){
			$this->db->where(''.$table.'.trans_closed_date >=', $cancelled_from_date);
			$this->db->where(''.$table.'.trans_closed_date <=', $cancelled_to_date);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($list_arr)){

	    	$this->db->where_in(''.$table.'.order_closed', $list_arr,false);
	    }

		//$this->db->order_by(' '.$table.'.order_no');

		$this->db->order_by(' '.$table.'.approval_date' ,'desc');
		$this->db->order_by(' '.$table.'.order_no' ,'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function active_record_search_for_open_transaction($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		//$this->db->join('country_master','address_master.country_id=country_master.country_id','LEFT');
		//$this->db->join('country_master_lang','country_master.country_id=country_master_lang.country_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    
	    $this->db->order_by(' '.$table.'.order_date','DESC'); 
		$this->db->order_by(' '.$table.'.order_no','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}




	public function active_record_search_index($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	 $this->db->limit($limit, $start);
		$this->db->order_by(' '.$table.'.order_date' ,'desc');
		$this->db->order_by(' '.$table.'.order_no' ,'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function archive_record_search($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,address_master.zip_code,user_master.login_name,property_master.lang_property_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_date >=', $from);
			$this->db->where(''.$table.'.order_date <=', $to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	 $this->db->limit($limit, $start);
		$this->db->order_by(' '.$table.'.order_date' ,'desc');
		$this->db->order_by(' '.$table.'.order_no' ,'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

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
	 //$this->db->order_by('CAST(ord_pos_no)','asc'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}
	// After implimentation of delivery date search By Eknath on 17-July-2020
	public function active_details_records_new($table,$data,$company,$delivery_from_date,$delivery_to_date){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('address_category_master',''.$table.'.customer_category=address_category_master.
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('article_name_info.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				if($key=='adr_category_id'){
					$this->db->where('article_name_info.adr_category_id', $value);
				}else{
					$this->db->where(''.$table.'.'.$key.'', $value);
				}
				
			}
	    }
	    if($delivery_from_date!='' && $delivery_to_date!=''){
			$this->db->where(''.$table.'.delivery_date >=', $delivery_from_date);
			$this->db->where(''.$table.'.delivery_date <=', $delivery_to_date);
		}	
	 //$this->db->order_by('CAST(ord_pos_no)','asc'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

//Tax Header
	
	public function fun_tax_header($from,$to,$company){

		//$this->db->distinct();
		$this->db->select('m.order_no,m.order_date,d.tax_pos_no,td.tax_id,td.tax_code,l.lang_tax_code_desc');
		$this->db->from('order_master m');	
		$this->db->join('order_details d','m.order_no=d.order_no');
		$this->db->join('tax_grid_details td','d.tax_pos_no=td.tax_id');
		$this->db->join('tax_master t','t.tax_code=td.tax_code');
		$this->db->join('tax_master_lang l','t.tax_code=l.tax_code');
		$this->db->where('m.company_id', $company);
		$this->db->where('m.archive !=', '1');
		$this->db->where('m.order_date >=', $from);
		$this->db->where('m.order_date <=', $to);
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
							MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='PRINT TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_PRINT_TYPE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='NECK TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_NECK_TYPE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'SHOULDER_ORIFICE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'SHOULDER_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'SHOULDER_FOIL',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN mat_article_no  END) AS 'SHOULDER_FOIL_TAG',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_DIA',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='STYLE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_STYLE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MOLD FINISH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_MOLD_FINISH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_ORIFICE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'CAP_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN IF(mat_article_no!='',mat_article_no,parameter_value) END) AS 'CAP_FOIL_COLOR',

							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL WIDTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_WIDTH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='SHRINK SLEEVE' THEN IF(mat_article_no!='',mat_article_no,parameter_value) END) AS 'CAP_SHRINK_SLEEVE',
								MAX(CASE WHEN item_group_id =5 AND parameter_name='SHRINK SLEEVE' THEN IF(parameter_value!='',parameter_value,mat_article_no) END) AS 'CAP_SHRINK_SLEEVE_NAME',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='C.FOIL DIST FROM BOT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_DIST_FROM_BOT',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN supplier_no  END) AS 'CAP_MB_SUPPLIER',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_info  END) AS 'CAP_MB_PERC',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='' AND item_group_material_flag='2' THEN mat_article_no  END) AS 'CAP_PP',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='' AND item_group_material_flag='2' THEN mat_info  END) AS 'CAP_PP_PERC',

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
		$this->db->select($table.'.*,address_master.name1 as customer_name,address_master.isdn_local,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.city_code,address_master.name3,zip_code_master.state_code,zip_code_master.lang_city,order_master_lang.lang_addi_info,country_master_lang.lang_country_name as country_name,address_master.dispatch_tolerance');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('country_master','address_master.country_id=country_master.country_id','LEFT');
		$this->db->join('country_master_lang','country_master.country_id=country_master_lang.country_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_record_view($limit,$start,$table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_master.name1 as customer_name,address_master.isdn_local,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.name3,zip_code_master.state_code,zip_code_master.lang_city,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		 $this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_cap_specs_record($table,$company,$data){
		$this->db->select("spec_id,spec_version_no,

							MAX(CASE WHEN item_group_id =5 AND parameter_name='METALIZATION' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_METALIZATION',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_DIA',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='STYLE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_STYLE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MOLD FINISH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_MOLD_FINISH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_ORIFICE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'CAP_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_COLOR',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL WIDTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_WIDTH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='SHRINK SLEEVE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_SHRINK_SLEEVE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='C.FOIL DIST FROM BOT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_DIST_FROM_BOT',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN supplier_no  END) AS 'CAP_MB_SUPPLIER',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_info  END) AS 'CAP_MB_PERC',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='' AND item_group_material_flag='2' THEN mat_article_no  END) AS 'CAP_PP',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='' AND item_group_material_flag='2' THEN mat_info  END) AS 'CAP_PP_PERC',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='SHRINK SLEEVE' THEN mat_article_no  END) AS 'CAP_SHRINK_SLEEVE_CODE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN mat_article_no  END) AS 'CAP_FOIL_CODE',");	

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
		//echo $this->db->last_query();
		return $result=$query->result();

	}


	public function select_sleeve_specs_record($table,$company,$data){
		$this->db->select("spec_id,spec_version_no,
			MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_DIA',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_LENGTH',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=1 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_GUAGE',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=1 THEN mat_article_no END) AS 'SLEEVE_MASTER_BATCH',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=1 THEN mat_info  END) AS 'SLEEVE_MB_PERC',
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
			MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=5 THEN mat_info  END) AS 'SLEEVE_HDPE_PERC_5',

			");	

		$this->db->from($table);
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
        $this->db->group_by('spec_id');
		$query = $this->db->get();
		return $result=$query->result();

	}


		public function select_shoulder_specs_record($table,$company,$data){
		$this->db->select("spec_id,spec_version_no,

							MAX(CASE WHEN item_group_id =4 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_DIA',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='STYLE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_STYLE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SHOULDER_ORIFICE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'SHOULDER_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN supplier_no  END) AS 'SHOULDER_MB_SUPPLIER',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_info  END) AS 'SHOULDER_MB_PERC',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE ONE' THEN mat_article_no  END) AS 'SHOULDER_HDPE_ONE',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE ONE' THEN mat_info  END) AS 'SHOULDER_HDPE_ONE_PERC',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE TWO' THEN mat_article_no  END) AS 'SHOULDER_HDPE_TWO',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='HDPE TWO' THEN mat_info  END) AS 'SHOULDER_HDPE_TWO_PERC',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN mat_article_no  END) AS 'SHOULDER_FOIL_TAG'");	

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

	}


	public function select_label_specs_record($table,$company,$data){

		$this->db->select("spec_id,spec_version_no,
			MAX(CASE WHEN item_group_id =6 AND parameter_name='NON LACQUERING HEIGH' THEN IF (parameter_value!='',parameter_value,relating_master_value) END) AS 'OE',
				MAX(CASE WHEN item_group_id =6 AND parameter_name='NON LABELING HEIGHT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SE',
						MAX(CASE WHEN item_group_id =6 AND parameter_name='LABEL' THEN mat_article_no  END) AS 'LABEL_NAME',
						MAX(CASE WHEN item_group_id =6 AND parameter_name='LACQUER ONE' THEN mat_article_no  END) AS 'LABEL_LACQUER_ONE',
						MAX(CASE WHEN item_group_id =6 AND parameter_name='LACQUER ONE' THEN mat_info  END) AS 'LABEL_LACQUER_ONE_PERC',
						MAX(CASE WHEN item_group_id =6 AND parameter_name='LACQUER TWO' THEN mat_info  END) AS 'LABEL_LACQUER_TWO_PERC',
						MAX(CASE WHEN item_group_id =6 AND parameter_name='LACQUER TWO' THEN mat_article_no  END) AS 'LABEL_LACQUER_TWO'");	

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

	}


	public function active_record_search_tally($table,$data,$from,$to,$company,$list_arr){
		$this->db->select(''.$table.'.*,order_details.*,address_master.name1,address_master.isdn_local,address_master.zip_code,order_master_lang.lang_addi_info,property_master.lang_property_name');
		$this->db->from($table);
		$this->db->join('order_master_lang',''.$table.'.order_no=order_master_lang.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('order_details',''.$table.'.order_no=order_details.order_no','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive!=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.order_modified_date >=', $from);
			$this->db->where(''.$table.'.order_modified_date <=', $to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($list_arr)){

	    	$this->db->where_in(''.$table.'.order_closed', $list_arr,false);
	    }

		$this->db->order_by(' '.$table.'.order_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function select_one_active_record_for_tally_sql($table,$company,$pkey,$edit){
		$this->db->select(''.$table.'.*,order_details.*,address_master.name1,address_master.zip_code,address_master.isdn_local,address_master.party_type');
		$this->db->from($table);		
		$this->db->join('order_details',''.$table.'.order_no=order_details.order_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where($pkey,$edit);
		$this->db->order_by('order_details.ord_pos_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function select_open_orders($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where('order_closed<>','1');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_transaction_open_orders($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where('trans_closed<>','1');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_orders_for_autocomplete($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where('order_date>=','2013-04-01');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_spring_orders_for_autocomplete($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where('order_date>=','2013-04-01');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_open_orders_for_springtube($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where('order_flag','1');
		$this->db->where('trans_closed','0');
		$this->db->where('order_closed<>','1');
		$this->db->where('final_approval_flag','1');
		$this->db->where('hold_flag<>','1');
		$this->db->where('for_stock','0');
		$query = $this->db->get();
		return $result=$query->result();
	}



	// Spring tube open orders for extrusion entry
	public function spring_open_orders_for_extrusion($table,$edit,$company){

		$query=$this->db->query("SELECT distinct pm.sales_ord_no as order_no FROM production_master as pm INNER JOIN order_master as om ON om.order_no=pm.sales_ord_no INNER JOIN reserved_quantity_manu as rm ON rm.sales_order_no=om.order_no WHERE pm.sales_ord_no LIKE '%$edit%' and om.trans_closed=0 and om.order_closed<>1 AND om.final_approval_flag=1 AND om.order_flag=1");
		// $this->db->select('*');
		// $this->db->from($table);
		// if(!empty($data)){
		// 	foreach($data as $key => $value) {
		// 	$this->db->where($key,$value);
		// 	}
		// }
		// $this->db->where('archive<>','1');
		// $this->db->where('company_id',$company);
		// //$this->db->where('order_closed<>','1');
		// $query = $this->db->get();
		 return $result=$query->result();
	}


	public function select_film_specs_record($table,$company,$data){
		$this->db->select("spec_id,spec_version_no,
			MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_DIA',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'SLEEVE_LENGTH',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=1 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_1',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_article_no END) AS 'FILM_LDPE_1',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=1 THEN mat_info  END) AS 'FILM_LDPE_PERC_1',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_article_no END) AS 'FILM_LLDPE_1',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=1 THEN mat_info  END) AS 'FILM_LLDPE_PERC_1',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=2 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_article_no END) AS 'FILM_MASTER_BATCH_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=2 THEN mat_info  END) AS 'FILM_MB_PERC_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_article_no END) AS 'FILM_LLDPE_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=2 THEN mat_info  END) AS 'FILM_LLDPE_PERC_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_article_no END) AS 'FILM_HDPE_2',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=2 THEN mat_info  END) AS 'FILM_HDPE_PERC_2',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=3 THEN mat_article_no END) AS 'FILM_ADMER_3',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=3 THEN mat_info  END) AS 'FILM_ADMER_PERC_3',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=3 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_3',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=4 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_4',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=4 THEN mat_article_no END) AS 'FILM_EVOH_4',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='EVOH' AND layer_no=4 THEN mat_info  END) AS 'FILM_EVOH_PERC_4',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=5 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_5',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=5 THEN mat_article_no END) AS 'FILM_ADMER_5',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='ADMER' AND layer_no=5 THEN mat_info  END) AS 'FILM_ADMER_PERC_5',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=6 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=6 THEN mat_article_no END) AS 'FILM_MASTER_BATCH_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' AND layer_no=6 THEN mat_info  END) AS 'FILM_MB_PERC_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=6 THEN mat_article_no END) AS 'FILM_LLDPE_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=6 THEN mat_info  END) AS 'FILM_LLDPE_PERC_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=6 THEN mat_article_no END) AS 'FILM_HDPE_6',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='HDPE' AND layer_no=6 THEN mat_info  END) AS 'FILM_HDPE_PERC_6',

			MAX(CASE WHEN item_group_id =3 AND parameter_name='GUAGE' AND layer_no=7 THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'FILM_GUAGE_7',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=7 THEN mat_article_no END) AS 'FILM_LDPE_7',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LDPE' AND layer_no=7 THEN mat_info  END) AS 'FILM_LDPE_PERC_7',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=7 THEN mat_article_no END) AS 'FILM_LLDPE_7',
			MAX(CASE WHEN item_group_id =3 AND parameter_name='LLDPE' AND layer_no=7 THEN mat_info  END) AS 'FILM_LLDPE_PERC_7',
			");	

		$this->db->from($table);
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
        $this->db->group_by('spec_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}


		public function pending_sales_order($table,$from_date,$to_date){

			$sql="SELECT  A.sleeve_dia,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT 
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type
					WHERE om.approval_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1'

					AND om.trans_closed<>'1'
					AND om.for_stock<>1
					/*AND od.sleeve_dia<>''*/
					AND od.print_type<>''
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no) AS A 
					GROUP BY A.sleeve_dia";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}


		public function pending_sales_order_monthwise_old($table,$from_date,$to_date){

			$sql="SELECT  A.order_month_no,A.order_month,A.order_year,A.sleeve_dia,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT YEAR(om.approval_date) AS order_year, LEFT(MONTHNAME (om.approval_date),3) AS order_month,MONTH(om.approval_date) as order_month_no,
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type
					WHERE om.approval_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1'
					
					AND om.trans_closed<>'1'
					AND om.for_stock<>1
					AND od.print_type<>''
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no) AS A 
					GROUP BY A.order_month,A.order_year/*,A.sleeve_dia*/
					order by order_year,order_month_no/*,sleeve_dia*/ asc";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}

		public function pending_sales_order_monthwise($table,$from_date,$to_date,$customer_category_id){

			$sql="SELECT  A.order_month_no,A.order_month,A.order_year,A.sleeve_dia,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT YEAR(om.approval_date) AS order_year, LEFT(MONTHNAME (om.approval_date),3) AS order_month,MONTH(om.approval_date) as order_month_no,
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type";
					if(!empty($customer_category_id)){
						$sql.=" LEFT JOIN article_name_info ON od.article_no=article_name_info.article_no";	
					}
					
					$sql.=" WHERE om.approval_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1' ";
					if(!empty($customer_category_id)){
						$sql.="AND article_name_info.company_id='000020'";
						$sql.="AND article_name_info.language_id='1'";
						$sql.="AND article_name_info.adr_category_id=$customer_category_id ";	
					}					
					$sql.=" AND om.trans_closed<>'1'
					AND om.for_stock<>1
					AND od.print_type<>''
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no) AS A 
					GROUP BY A.order_month,A.order_year/*,A.sleeve_dia*/
					order by order_year,order_month_no/*,sleeve_dia*/ asc";

					//echo $sql;
					$query=$this->db->query($sql);
					return $result=$query->result();
		}


		public function pending_sales_order_on_delivery_date($table,$from_date,$to_date,$customer_category_id){

			$sql="SELECT  A.order_month_no,A.order_month,A.order_year,A.sleeve_dia,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT YEAR(od.delivery_date) AS order_year, LEFT(MONTHNAME (od.delivery_date),3) AS order_month,MONTH(od.delivery_date) as order_month_no,
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type";
					if(!empty($customer_category_id)){
						$sql.=" LEFT JOIN article_name_info ON od.article_no=article_name_info.article_no";	
					}
					
					$sql.=" WHERE od.delivery_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1' ";
					if(!empty($customer_category_id)){
						$sql.="AND article_name_info.company_id='000020'";
						$sql.="AND article_name_info.language_id='1'";
						$sql.="AND article_name_info.adr_category_id=$customer_category_id ";	
					}					
					$sql.=" AND om.trans_closed<>'1'
					AND om.for_stock<>1
					AND od.print_type<>''
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no) AS A 
					GROUP BY A.order_month,A.order_year/*,A.sleeve_dia*/
					order by order_year,order_month_no/*,sleeve_dia*/ asc";

					//echo $sql;
					$query=$this->db->query($sql);
					return $result=$query->result();
		}



		public function pending_sales_order_by_customer($table,$from_date,$to_date){

			$sql="SELECT  A.customer,sum(A.SCREEN_FLEXO_PENDING+A.OFFSET_PENDING+A.LABEL_PENDING+A.DIGITAL_PENDING) as PENDING_QUANTITY,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT YEAR(om.approval_date) AS order_year, LEFT(MONTHNAME (om.approval_date),3) AS order_month,MONTH(om.approval_date) as order_month_no,article_name_info.adr_category_id,
					address_category_master.category_name as customer,
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type
					LEFT JOIN article_name_info ON od.article_no=article_name_info.article_no
					LEFT JOIN address_category_master ON article_name_info.adr_category_id=address_category_master.adr_category_id
					WHERE om.approval_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1'
					
					AND om.trans_closed<>'1'
					AND om.for_stock<>1
					AND od.print_type<>''
					AND article_name_info.company_id='000020'
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no,article_name_info.adr_category_id) AS A 
					GROUP BY A.customer/*,A.sleeve_dia*/
					order by PENDING_QUANTITY desc";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}


		public function pending_sales_order_by_customer_with_cap($table,$from_date,$to_date,$cap_code){

			$sql="SELECT A.cap_code,A.customer,A.order_year,A.order_month,A.order_month_no,sum(A.order_received) as order_received,sum(A.order_dispached) as order_dispached,sum(A.order_pending) as order_pending from (SELECT 
					od.cap_code,
					YEAR(om.approval_date) AS order_year, 
					LEFT(MONTHNAME (om.approval_date),3) AS order_month,
					MONTH(om.approval_date) as order_month_no,
					article_name_info.adr_category_id, 
					address_category_master.category_name as customer, 
					om.order_no,
					od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, 
					od.sleeve_dia, 
					od.total_order_quantity /100 AS order_received,
					IFNULL(sum( ar.arid_qty /100 ),0) AS order_dispached, 
					if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100 ),0), 0 ) AS order_pending

					FROM `order_master` AS om INNER JOIN order_details AS od 
					ON om.order_no = od.order_no LEFT JOIN ar_invoice_details AS ar 
					ON om.order_no = ar.ref_ord_no AND od.article_no = ar.article_no /*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/

					LEFT JOIN article_name_info 
					ON od.article_no=article_name_info.article_no 

					LEFT JOIN address_category_master 
					ON article_name_info.adr_category_id=address_category_master.adr_category_id 

					WHERE om.approval_date BETWEEN '$from_date' AND '$to_date' 
					AND om.final_approval_flag = '1' 
					AND om.trans_closed<>'1' 
					AND om.for_stock<>1 
					AND od.print_type<>'' 
					AND article_name_info.company_id='000020'";

					if(!empty($cap_code)){
						$sql.="AND od.cap_code='$cap_code'";	
					}					
					$sql.=" GROUP BY om.order_no,od.article_no
					) AS A
					WHERE A.order_pending<>0 
					GROUP BY A.cap_code
					order by order_pending desc";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}


		public function pending_sales_order_by_customer_group_with_cap($from_date,$to_date,$cap_code){

			$sql="SELECT A.customer,sum(A.order_received) as order_r,sum(A.order_dispached) as order_d,sum(A.order_pending) as order_p,A.dispatch_tolerance as dis_tolerance  from
					(SELECT od.cap_code,address_master.dispatch_tolerance,
					YEAR(om.approval_date) AS order_year, 
					LEFT(MONTHNAME (om.approval_date),3) AS order_month,
					MONTH(om.approval_date) as order_month_no,
					article_name_info.adr_category_id, 
					address_category_master.category_name as customer, 
					om.order_no,
					od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, 
					od.sleeve_dia, 
					od.total_order_quantity /100 AS order_received,
					IFNULL(sum( ar.arid_qty /100 ),0) AS order_dispached, 
					if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100 ),0), 0 ) AS order_pending

					FROM `order_master` AS om INNER JOIN order_details AS od 
					ON om.order_no = od.order_no LEFT JOIN ar_invoice_details AS ar 
					ON om.order_no = ar.ref_ord_no AND od.article_no = ar.article_no 

					LEFT JOIN address_master
					ON om.customer_no=address_master.adr_company_id

					LEFT JOIN article_name_info 
					ON od.article_no=article_name_info.article_no 

					LEFT JOIN address_category_master 
					ON article_name_info.adr_category_id=address_category_master.adr_category_id 

					WHERE om.approval_date BETWEEN '$from_date' AND '$to_date' 
					AND om.final_approval_flag = '1' 
					AND om.trans_closed<>'1' 
					AND om.for_stock<>1 
					AND od.print_type<>'' 
					AND article_name_info.company_id='000020'
					AND od.cap_code='$cap_code' GROUP BY om.order_no,od.article_no)
					As A 
					WHERE A.order_pending<>0 
					Group by A.customer";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}



		public function pending_sales_order_cap_by_customer($table,$from_date,$to_date,$customer){

			$sql="SELECT A.cap_code,A.customer,A.adr_category_id,A.order_year,A.order_month,A.order_month_no,sum(A.order_received) as order_received,sum(A.order_dispached) as order_dispached,sum(A.order_pending) as order_pending from (SELECT 
					od.cap_code,
					YEAR(om.approval_date) AS order_year, 
					LEFT(MONTHNAME (om.approval_date),3) AS order_month,
					MONTH(om.approval_date) as order_month_no,
					article_name_info.adr_category_id, 
					address_category_master.category_name as customer, 
					om.order_no,
					od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, 
					od.sleeve_dia, 
					od.total_order_quantity /100 AS order_received,
					IFNULL(sum( ar.arid_qty /100 ),0) AS order_dispached, 
					if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100 ),0), 0 ) AS order_pending

					FROM `order_master` AS om INNER JOIN order_details AS od 
					ON om.order_no = od.order_no LEFT JOIN ar_invoice_details AS ar 
					ON om.order_no = ar.ref_ord_no AND od.article_no = ar.article_no /*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/

					LEFT JOIN article_name_info 
					ON od.article_no=article_name_info.article_no 

					LEFT JOIN address_category_master 
					ON article_name_info.adr_category_id=address_category_master.adr_category_id 

					WHERE om.approval_date BETWEEN '$from_date' AND '$to_date' 
					AND om.final_approval_flag = '1' 
					AND om.trans_closed<>'1' 
					AND om.for_stock<>1 
					AND od.print_type<>'' 
					AND article_name_info.company_id='000020'";

					if(!empty($customer)){
						$sql.="AND address_category_master.adr_category_id='$customer'";	
					}					
					$sql.=" GROUP BY om.order_no,od.article_no
					) AS A
					WHERE A.order_pending<>0 
					GROUP BY A.customer
					order by order_pending desc";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}

		public function pending_sales_order_cap_by_customer_with_customer($from_date,$to_date,$customer){

			$sql="SELECT A.cap_code,A.cap_code,A.customer,A.adr_category_id,A.order_year,A.order_month,A.order_month_no,sum(A.order_received) as order_r,sum(A.order_dispached) as order_d,sum(A.order_pending) as order_p,A.dispatch_tolerance as dis_tolerance  from
					(SELECT od.cap_code,address_master.dispatch_tolerance,
					YEAR(om.approval_date) AS order_year, 
					LEFT(MONTHNAME (om.approval_date),3) AS order_month,
					MONTH(om.approval_date) as order_month_no,
					article_name_info.adr_category_id, 
					address_category_master.category_name as customer, 
					om.order_no,
					od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, 
					od.sleeve_dia, 
					od.total_order_quantity /100 AS order_received,
					IFNULL(sum( ar.arid_qty /100 ),0) AS order_dispached, 
					if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100 ),0), 0 ) AS order_pending

					FROM `order_master` AS om INNER JOIN order_details AS od 
					ON om.order_no = od.order_no LEFT JOIN ar_invoice_details AS ar 
					ON om.order_no = ar.ref_ord_no AND od.article_no = ar.article_no 

					LEFT JOIN address_master
					ON om.customer_no=address_master.adr_company_id

					LEFT JOIN article_name_info 
					ON od.article_no=article_name_info.article_no 

					LEFT JOIN address_category_master 
					ON article_name_info.adr_category_id=address_category_master.adr_category_id 

					WHERE om.approval_date BETWEEN '$from_date' AND '$to_date' 
					AND om.final_approval_flag = '1' 
					AND om.trans_closed<>'1' 
					AND om.for_stock<>1 
					AND od.print_type<>'' 
					AND article_name_info.company_id='000020'
					AND address_category_master.adr_category_id='$customer' GROUP BY om.order_no,od.article_no)
					As A 
					WHERE A.order_pending<>0 
					Group by A.cap_code";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}


/*		public function pending_sales_order_monthwise($table,$from_date,$to_date){

			$sql="SELECT  A.order_month_no,A.order_month,A.order_year,A.sleeve_dia,sum(A.SCREEN_FLEXO_PENDING) as SCREEN_FLEXO_PENDING_QTY,sum(A.SCREEN_FLEXO_PENDING_VAL) as SCREEN_FLEXO_PENDING_VALUE, sum(A.OFFSET_PENDING) as OFFSET_PENDING_QTY, sum(A.OFFSET_PENDING_VAL) as OFFSET_PENDING_VALUE,sum(A.LABEL_PENDING) as LABEL_PENDING_QTY,sum(A.LABEL_PENDING_VAL) as LABEL_PENDING_VALUE,sum(A.DIGITAL_PENDING) as DIGITAL_PENDING_QTY,sum(A.DIGITAL_PENDING_VAL) as DIGITAL_PENDING_VALUE,sum(A.UNKNOWN_PENDING) as UNKNOWN_PENDING_QTY from (SELECT YEAR(om.order_date) AS order_year, LEFT(MONTHNAME (om.order_date),3) AS order_month,MONTH(om.order_date) as order_month_no,
					om.order_no, od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, 

					if( sum( ar.arid_qty /100 ) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - sum( ar.arid_qty /100 ), 0 ) AS pending,

					if(lm.printing_group='SCREEN+FLEXO', if( IFNULL(sum( ar.arid_qty /100 ),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as SCREEN_FLEXO_PENDING,

					if(lm.printing_group='SCREEN+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as SCREEN_FLEXO_PENDING_VAL,

					if(lm.printing_group='OFFSET', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as OFFSET_PENDING,

					if(lm.printing_group='OFFSET',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as OFFSET_PENDING_VAL,

					if(lm.printing_group='LABEL', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as LABEL_PENDING,

					if(lm.printing_group='LABEL',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as LABEL_PENDING_VAL,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO', if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as DIGITAL_PENDING,

					if(lm.printing_group='FLEXO+DIGITAL+FLEXO',if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))*if( IFNULL(sum( ar.arid_qty / 100),0) < ( od.total_order_quantity / 100 ) , ( od.total_order_quantity / 100 ) - IFNULL(sum( ar.arid_qty / 100),0) , 0 ),0) as DIGITAL_PENDING_VAL,

					if(lm.printing_group IS NULL, if( IFNULL(sum( ar.arid_qty /100),0) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) - IFNULL(sum( ar.arid_qty /100),0), 0 ),0) as UNKNOWN_PENDING

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no------
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type
					WHERE om.order_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1'
					AND om.trans_closed<>'1'
					AND od.print_type<>''
					/*AND am.cancel_invoice <>1-------
					GROUP BY  om.order_no,od.article_no) AS A 
					GROUP BY A.order_month,A.order_year/*,A.sleeve_dia-------
					order by order_year,order_month_no/*,sleeve_dia--------asc";
					$query=$this->db->query($sql);
					return $result=$query->result();
		}
*/

		public function print_type_wise_sales_order($table,$from_date,$to_date){
			$sql="SELECT 
					A.ORDER_MONTH_NO,A.order_month as ORDER_MONTH,
					A.order_year as ORDER_YEAR,
					sum(A.APPROVED_SCREEN_FLEXO_Q) as APPROVED_SCREEN_FLEXO_QTY,
					sum(A.APPROVED_SCREEN_FLEXO_V) as APPROVED_SCREEN_FLEXO_VALUE,
					IF(sum(A.APPROVED_SCREEN_FLEXO_V)<>0,sum(A.APPROVED_SCREEN_FLEXO_V)/sum(A.APPROVED_SCREEN_FLEXO_Q),0) as APPROVED_SCREEN_FLEXO_AVG,
					sum(A.APPROVED_OFFSET_Q) as APPROVED_OFFSET_QTY, 
					sum(A.APPROVED_OFFSET_V) as APPROVED_OFFSET_VALUE,
					IF(sum(A.APPROVED_OFFSET_V)<>0,sum(A.APPROVED_OFFSET_V)/sum(A.APPROVED_OFFSET_Q),0) as APPROVED_OFFSET_AVG,
					sum(A.APPROVED_LABEL_Q) as APPROVED_LABEL_QTY,
					sum(A.APPROVED_LABEL_V) as APPROVED_LABEL_VALUE,
					IF(sum(A.APPROVED_LABEL_V)<>0,sum(A.APPROVED_LABEL_V)/sum(A.APPROVED_LABEL_Q),0) as APPROVED_LABEL_AVG,
					sum(A.APPROVED_DIGITAL_Q) as APPROVED_DIGITAL_QTY,
					sum(A.APPROVED_DIGITAL_V) as APPROVED_DIGITAL_VALUE,
					IF(sum(A.APPROVED_DIGITAL_V)<>0,sum(A.APPROVED_DIGITAL_V)/sum(A.APPROVED_DIGITAL_Q),0) as APPROVED_DIGITAL_AVG,
					sum(A.APPROVED_OTHER_Q) as APPROVED_OTHER_QTY,
					sum(A.APPROVED_OTHER_V) as APPROVED_OTHER_VALUE,
					IF(sum(A.APPROVED_OTHER_V)<>0,sum(A.APPROVED_OTHER_V)/sum(A.APPROVED_OTHER_Q),0) as APPROVED_OTHER_AVG,
					sum(A.APPROVED_ORDER_Q) as APPROVED_ORDER_QTY,
					sum(A.APPROVED_ORDER_V) as APPROVED_ORDER_VALUE,
					IF(sum(A.APPROVED_ORDER_V)<>0,sum(A.APPROVED_ORDER_V)/sum(A.APPROVED_ORDER_Q),0) as APPROVED_ORDER_AVG,
					sum(A.UNAPPROVED_CANCEL_Q) as UNAPPROVED_CANCEL_QTY,
					sum(A.UNAPPROVED_CANCEL_V) as UNAPPROVED_CANCEL_VALUE,
					IF(sum(A.UNAPPROVED_CANCEL_V)<>0,sum(A.UNAPPROVED_CANCEL_V)/sum(A.UNAPPROVED_CANCEL_Q),0) as UNAPPROVED_CANCEL_AVG,
					sum(A.UNAPPROVED_ORDER_Q) as UNAPPROVED_ORDER_QTY,
					sum(A.UNAPPROVED_ORDER_V) as UNAPPROVED_ORDER_VALUE,
					IF(sum(A.UNAPPROVED_ORDER_V)<>0,sum(A.UNAPPROVED_ORDER_V)/sum(A.UNAPPROVED_ORDER_Q),0) as UNAPPROVED_ORDER_AVG
					FROM (
					SELECT 
					YEAR(order_master.order_date) as ORDER_YEAR, 
					MONTH(order_master.order_date) as ORDER_MONTH_NO,
					LEFT(MONTHNAME(order_master.order_date),3) as ORDER_MONTH,
					order_master.order_date,
					order_master.order_no,
					order_details.article_no, 

					SUM(if( order_master.final_approval_flag=1 ,order_details.total_order_quantity/100,0)) AS APPROVED_ORDER_Q,
					SUM(if(order_master.final_approval_flag=1 AND order_master.for_export<>1, (order_details.selling_price/100)*(order_details.total_order_quantity/100),0) )
					+
					SUM(if(order_master.final_approval_flag=1 AND order_master.for_export=1,(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0) ) AS APPROVED_ORDER_V,

					
					SUM(if( order_master.final_approval_flag<>1 AND order_master.cancel_flag=1 ,order_details.total_order_quantity/100,0)) AS UNAPPROVED_CANCEL_Q,

					SUM(if(order_master.final_approval_flag<>1 AND order_master.for_export<>1 AND order_master.cancel_flag=1,(order_details.selling_price/100)*(order_details.total_order_quantity/100),0) )
					+
					SUM(if(order_master.final_approval_flag<>1 AND order_master.for_export=1 AND order_master.cancel_flag=1,(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0) ) AS UNAPPROVED_CANCEL_V,

					SUM(if( order_master.final_approval_flag<>1,order_details.total_order_quantity/100,0)) AS UNAPPROVED_ORDER_Q,

					SUM(if(order_master.final_approval_flag<>1 AND order_master.for_export<>1,(order_details.selling_price/100)*(order_details.total_order_quantity/100),0) )
					+
					SUM(if(order_master.final_approval_flag<>1 AND order_master.for_export=1,(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0) ) AS UNAPPROVED_ORDER_V,



					SUM(if( order_master.final_approval_flag=1 AND order_details.print_type='', (order_details.total_order_quantity/100),0 ) ) AS APPROVED_OTHER_Q, 
					SUM(if(order_master.final_approval_flag=1 AND order_details.print_type='' AND order_master.for_export<>1, (order_details.selling_price/100)*(order_details.total_order_quantity/100),0) )
					+
					SUM(if(order_master.final_approval_flag=1 AND order_details.print_type='' AND order_master.for_export=1,(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0) ) AS APPROVED_OTHER_V,



					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND ( order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_SCREEN_FLEXO_Q, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_SCREEN_FLEXO_V,

					
					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND (order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_OFFSET_Q, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_OFFSET_V,

					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND (order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_LABEL_Q, 

					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_LABEL_V,

					SUM(if( order_master.final_approval_flag=1 AND (order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_DIGITAL_Q, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.for_export<>1 AND(order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.for_export=1 AND(order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_DIGITAL_V,


					sum(order_details.total_order_quantity/100) as TOTAL_Q 

					FROM `order_master` INNER JOIN order_details ON order_master.order_no=order_details.order_no where order_master.order_date between '$from_date' AND '$to_date'
					AND order_master.for_stock<>1
					AND order_master.for_sampling <>1
					AND order_details.article_no NOT LIKE  'DD%'
					AND order_details.article_no NOT LIKE  'CAP%'
					
					 group by order_master.order_no, order_details.article_no order by order_master.order_date asc

					) A GROUP BY A.ORDER_MONTH_NO,A.ORDER_YEAR ORDER BY A.ORDER_YEAR,A.ORDER_MONTH_NO";

					$query=$this->db->query($sql);
					return $result=$query->result();
		}


		public function total_order_received_by_customer($table,$from_date,$to_date,$sleeve_diaaa){
			$sql="SELECT YEAR(order_master.approval_date) as ORDER_YEAR, 
					MONTH(order_master.approval_date) as ORDER_MONTH_NO,
					LEFT(MONTHNAME(order_master.approval_date),3) as ORDER_MONTH,
					sum((order_details.total_order_quantity/100)) as ORDER_QUANTITY,
					article_name_info.adr_category_id,
					address_category_master.category_name as customer,
					order_master.approval_date,
					order_master.order_no,
					order_details.article_no, 

					SUM(if( order_master.final_approval_flag=1 ,order_details.total_order_quantity/100,0)) AS APPROVED_ORDER_QTY,
					SUM(if(order_master.final_approval_flag=1 AND order_master.for_export<>1, (order_details.selling_price/100)*(order_details.total_order_quantity/100),0) )
					+
					SUM(if(order_master.final_approval_flag=1 AND order_master.for_export=1,(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0) ) AS APPROVED_ORDER_VALUE,

					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND ( order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_SCREEN_FLEXO_QTY, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='SCREEN' OR order_details.print_type='FLEXO+SCREEN' OR order_details.print_type='SCREEN+FLEXO' OR order_details.print_type='FLEXO' OR order_details.print_type='SCREEN+UPTO NECK' OR order_details.print_type='OFFSET SCREEN' OR order_details.print_type='SCREEN + HOTFOIL' OR order_details.print_type='Flexo +screen' OR order_details.print_type='FLEXO SCREEN'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_SCREEN_FLEXO_VALUE,

					
					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND (order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_OFFSET_QTY, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='OFFSET' OR order_details.print_type='PLAIN'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_OFFSET_VALUE,

					SUM(if( order_master.final_approval_flag=1 AND order_master.order_flag=0 AND (order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_LABEL_QTY, 

					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export<>1 AND(order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.order_flag=0 AND order_master.for_export=1 AND(order_details.print_type='LABEL OFFSET' OR order_details.print_type='SCREEN + LABEL' OR order_details.print_type='SCREEN UP TO NECK+LABEL' OR order_details.print_type='LABELING' OR order_details.print_type='LABEL' OR order_details.print_type='OFFSET+LABEL' OR order_details.print_type='LABEL + OFFSET'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_LABEL_VALUE,

					SUM(if( order_master.final_approval_flag=1 AND (order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'), (order_details.total_order_quantity/100),0 ) ) AS APPROVED_DIGITAL_QTY, 
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.for_export<>1 AND(order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'), (order_details.selling_price/100)*(order_details.total_order_quantity/100),0
					) )
					+
					SUM(if(
					order_master.final_approval_flag=1 AND order_master.for_export=1 AND(order_details.print_type='FLEXO+DIGITAL+FLEXO' OR order_details.print_type='FLEXO+DIGITAL' OR order_details.print_type='DIGITAL+FLEXO'),(order_details.total_order_quantity/100)*(order_details.calc_sell_price)*(order_master.exchange_rate/100),0
					) ) AS APPROVED_DIGITAL_VALUE


					FROM `order_master` 
					INNER JOIN order_details 
					ON order_master.order_no=order_details.order_no 
					LEFT JOIN address_master
					ON order_master.customer_no=address_master.adr_company_id
					LEFT JOIN article_name_info
					ON order_details.article_no=article_name_info.article_no
					LEFT JOIN address_category_master
					ON article_name_info.adr_category_id=address_category_master.adr_category_id
					where order_master.approval_date between '$from_date' AND '$to_date'
					AND order_master.for_stock<>1";
					
						if(!empty($sleeve_diaaa)){

							$sql.=" AND order_details.sleeve_dia IN ($sleeve_diaaa)";
						}
					
					$sql.=" AND order_master.for_sampling<>1
					AND article_name_info.company_id='000020'
					AND order_details.print_type<>''
					group by article_name_info.adr_category_id
					Order by ORDER_QUANTITY desc";

					$query=$this->db->query($sql);
					return $result=$query->result();
		}


	public function select_one_active_order_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('order_details',''.$table.'.order_no=order_details.order_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function sum_supply_qty($table,$data,$company){

		$this->db->select('IFNULL(SUM( arid_qty ),0)  as supply_qty');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice !=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		
	}


	function get_order_status($order_no){

		$status='';

		$this->load->model('common_model');
		$this->load->model('sales_order_book_model');
		$order_result=$this->sales_order_book_model->select_one_active_order_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);    
			
		foreach ($order_result as $order_row) {		
			
			$total_order_quantity=$this->common_model->read_number($order_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
			$address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$order_row->customer_no);

			foreach ($address_master_result as $address_master_row) {
													
				//Factory Tolerance--------------------	
				$factory_tolerance=30;
				$factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
				$minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

				//Customer Tolerance-------------------			
				$customer_tolerance=0;
				$customer_tolerance=($address_master_row->dispatch_tolerance!=''?$address_master_row->dispatch_tolerance:0);

				if($customer_tolerance!=0){
					$tolerance_qty=($total_order_quantity*$customer_tolerance)/100;
					$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
					$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
				}
				else{
					
					$tolerance_qty=0;
					$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
					$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
					
				}
			}

			// Conditions-----------------
			$pending_qty=0;
			$total_arid_qty=0;
			$supplyqty=0;
			$cancel_qty=0;		

			$invoice=array();
			$invoice['ref_ord_no']=$order_row->order_no;
			$invoice['article_no']=$order_row->article_no;

			$supply_qty_result=$this->sales_order_book_model->sum_supply_qty('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);

			foreach($supply_qty_result as $supply_qty_row){
				$supply_qty=$supply_qty_row->supply_qty;

			}

			 
			$supplyqty=$this->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']);

			if($order_row->trans_closed==1){

				if($supplyqty==0)
				{	$status="Cancel Order";
					$cancel_qty=$total_order_quantity;
				}else if($supplyqty<$minus_factory_dispatch_qty){																
					$status="Manual Closed (Order cancelled from customer end) ".($order_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
					$cancel_qty=$total_order_quantity - $supplyqty;
					$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
				}
				else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
					$status="Manual Closed (Below Tolerance) ".($order_row->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
					$cancel_qty=$total_order_quantity - $supplyqty;
					$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
				}
				elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
					$status="Short Closed ".($order_row->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
					//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
					$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
				}
				else{
					
					//$status="Completed ".($order_row->pr_pos_complete_flag==0 ? "(INV)":"(PR)")." ";
					$status="Completed";
				}
				
			}else{								
				
				if($total_order_quantity<=$supplyqty && $supplyqty<>0){
					//$status="Completed ".($order_row->pr_pos_complete_flag==0 ? "(INV)":"(PR)")." ";
					$status="Completed";
				}
				elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
					$status="Partially Completed ".($order_row->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
					$pending_qty=number_format($total_order_quantity- $supplyqty,0,'.',',');
					$status.=number_format($total_order_quantity- $supplyqty,0,'.',',');
				}
				else{
					
					$status="Pending";
					$pending_qty=number_format($total_order_quantity,0,'.',',');
				}
				
			}
		}

		return $status;

	}

	public function po_check($po_no,$article_no){
		$sql="SELECT count(*) as no,order_master.cust_order_no,order_details.article_no,order_master.order_no
				FROM order_master
				INNER JOIN order_details ON order_master.order_no = order_details.order_no
				WHERE order_master.cust_order_no = '$po_no'
				AND order_details.article_no = '$article_no'";
		$query=$this->db->query($sql);
		return $result=$query->result();
	}

							


}

?>