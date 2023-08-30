<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_book_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company,$in_arr){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,ar_invoice_master_lang.lang_cust_po_info');
		$this->db->from($table);
		$this->db->join('ar_invoice_master_lang',''.$table.'.ar_invoice_no=ar_invoice_master_lang.ar_invoice_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.cancel_invoice!=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($in_arr)){
	    	$this->db->where_in($table.'.inv_type',$in_arr);
	    }

		$this->db->order_by(' '.$table.'.ar_invoice_no');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}


	public function active_record_search_index($limit,$start,$table,$data,$from,$to,$company){
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,ar_invoice_master_lang.lang_cust_po_info');
		$this->db->from($table);
		$this->db->join('ar_invoice_master_lang',''.$table.'.ar_invoice_no=ar_invoice_master_lang.ar_invoice_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.cancel_invoice!=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	 $this->db->limit($limit, $start);
		$this->db->order_by(' '.$table.'.invoice_date' ,'desc');
		$this->db->order_by(' '.$table.'.ar_invoice_no' ,'desc');
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
		$query = $this->db->get();
		return $result=$query->result();
		
	}
	public function sum_supply_qty($table,$data,$company){

		$this->db->select('IFNULL(SUM(arid_qty),0)  as supply_qty');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice =', '0');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		
	}

	public function active_records_search_costsheet($table,$data,$from,$to,$company){

		//$this->db->select('ar_invoice_details.ref_ord_no,ar_invoice_details.article_no,ar_invoice_master.ar_invoice_no,ar_invoice_master.customer_no');
		$this->db->select('*');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice !=', '1');
		if($from!='' && $to!=''){
			$this->db->where(''.$table.'.invoice_date >=', $from);
			$this->db->where(''.$table.'.invoice_date <=', $to);
		}
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		
	}


	public function active_records_search_distinct_so_costsheet($table,$data,$from,$to,$company){

		//$this->db->select('ar_invoice_details.ref_ord_no,ar_invoice_details.article_no,ar_invoice_master.ar_invoice_no,ar_invoice_master.customer_no');
		$this->db->select('distinct(ref_ord_no)');
		$this->db->from($table);	
		$this->db->join('ar_invoice_details ',$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive !=', '1');
		$this->db->where($table.'.cancel_invoice !=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where ($key, $value);
			}
	    }
		$query = $this->db->get();
		return $result=$query->result();
		
	}

//Tax Header
	
	public function fun_tax_header($from,$to,$company){

		//$this->db->distinct();
		$this->db->select('m.ar_invoice_no,m.invoice_date,d.tax_pos_no,td.tax_id,td.tax_code,l.lang_tax_code_desc');
		$this->db->from('ar_invoice_master m');	
		$this->db->join('ar_invoice_details d','m.ar_invoice_no=d.ar_invoice_no');
		$this->db->join('tax_grid_details td','d.tax_pos_no=td.tax_id');
		$this->db->join('tax_master t','t.tax_code=td.tax_code');
		$this->db->join('tax_master_lang l','t.tax_code=l.tax_code');
		$this->db->where('m.company_id', $company);
		$this->db->where('m.archive !=', '1');
		$this->db->where('m.cancel_invoice!=', '1');
		$this->db->where('m.invoice_date >=', $from);
		$this->db->where('m.invoice_date <=', $to);
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
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'SHOULDER_FOIL_TAG',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_DIA',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='STYLE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_STYLE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MOLD FINISH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_MOLD_FINISH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_ORIFICE',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'CAP_MASTER_BATCH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_COLOR',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL WIDTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_WIDTH',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='HEIGHT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_HEIGHT',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='C.FOIL DIST FROM BOT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'CAP_FOIL_DIST_FROM_BOT',

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
		$query=$this->db->query("SELECT YEAR(invoice_date) as year, MONTH (invoice_date) as month,count(*) as order_count,
				sum(if(for_export=0,1,0)) as Local,sum(if(for_export=0,total_amount,0)) as local_value,
				sum(if(for_export=0 AND for_sampling=1,1,0)) as Local_sample,sum(if(for_export=0 AND for_sampling=1,total_amount,0)) as Local_sample_value,

				sum(if(for_export=1,1,0)) as Export,sum(if(for_export=1,total_amount,0)) as export_value, 
				sum(if(for_export=1 AND for_sampling=1,1,0)) as Export_sample,sum(if(for_export=1 AND for_sampling=1,total_amount,0)) as Export_sample_value 
				FROM `ar_invoice_master`  where final_approval_flag='1' group By YEAR(invoice_date), MONTH(invoice_date) order by invoice_date desc limit 0,10");
		return $result=$query->result();
	}


	public function select_top_customers_orders($limit,$start,$table,$company,$year,$month){
		$start=(empty($start) ? $start=0 : $start);
		$query=$this->db->query("SELECT sum(order_details.total_order_quantity) as quantity,YEAR(ar_invoice_master.invoice_date) as year, Month(ar_invoice_master.invoice_date) as month,MONTHNAME (ar_invoice_master.invoice_date) as month_name,ar_invoice_master.customer_no,address_master.name1 as customer_name,count(*) as total_order,
		sum(if(ar_invoice_master.for_export=0,1,0)) as local,sum(if(ar_invoice_master.for_export=0,ar_invoice_master.total_amount,0)) as local_value,
		sum(if(ar_invoice_master.for_export=0 AND ar_invoice_master.for_sampling=1,1,0)) as local_sample,sum(if(ar_invoice_master.for_export=0 AND ar_invoice_master.for_sampling=1,ar_invoice_master.total_amount,0)) as local_sample_value,

		sum(if(ar_invoice_master.for_export=1,1,0)) as export,sum(if(ar_invoice_master.for_export=1,total_amount,0)) as export_value, 
		sum(if(ar_invoice_master.for_export=1 AND ar_invoice_master.for_sampling=1,1,0)) as export_sample,sum(if(ar_invoice_master.for_export=1 AND ar_invoice_master.for_sampling=1,ar_invoice_master.total_amount,0)) as export_sample_value 
		FROM `ar_invoice_master`  JOIN address_master ON address_master.adr_company_id=ar_invoice_master.customer_no JOIN order_details ON order_details.ar_invoice_no=ar_invoice_master.ar_invoice_no where ar_invoice_master.final_approval_flag='1' AND  YEAR(ar_invoice_master.invoice_date)='$year' AND Month(ar_invoice_master.invoice_date)='$month' group By YEAR(ar_invoice_master.invoice_date), MONTH(ar_invoice_master.invoice_date),ar_invoice_master.customer_no order by year desc, Month desc, local_value desc,export_value desc limit $start,$limit");

		return $result=$query->result();

	}


	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_master.name1 as customer_name,address_master.isdn_local,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.name3,zip_code_master.state_code,zip_code_master.lang_city,ar_invoice_master_lang.lang_cust_po_info');
		$this->db->from($table);
		$this->db->join('ar_invoice_master_lang',''.$table.'.ar_invoice_no=ar_invoice_master_lang.ar_invoice_no','LEFT');
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('zip_code_master','address_master.zip_code=zip_code_master.zip_code','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where(''.$table.'.cancel_invoice!=', '1');
		$this->db->where('zip_code_master.archive<>', '1');
		$this->db->where('zip_code_master.language_id', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_dia_wise_sales($table,$from_date,$to_date,$sleeve_diaaa,$inv_typee){
		$sql="SELECT * FROM (
				SELECT ar_invoice_master.invoice_date as sort, 
				MONTH(ar_invoice_master.invoice_date) as month_no, 
				YEAR( ar_invoice_master.invoice_date ) as sales_year, 
				LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

				SUM(if(ar_invoice_details.order_flag=0 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty /100,0) )AS COEX_SMALL_DIA,

				SUM(if(ar_invoice_details.order_flag=0 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty /100,0 ))AS COEX_BIG_DIA, 

				SUM(if(ar_invoice_details.order_flag=1 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty /100,0) )AS SPRING_SMALL_DIA, 

				SUM(if(ar_invoice_details.order_flag=1 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty /100,0 ))AS SPRING_BIG_DIA,

				SUM( IF( (ar_invoice_master.for_export<>1 AND ar_invoice_details.order_flag=0) AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( (ar_invoice_master.for_export=1 AND ar_invoice_details.order_flag=0) AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) ) AS COEX_SMALL_DIA_VALUE, 

				SUM( IF( (ar_invoice_master.for_export<>1 AND ar_invoice_details.order_flag=0) AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( (ar_invoice_master.for_export=1 AND ar_invoice_details.order_flag=0) AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) ) AS COEX_BIG_DIA_VALUE,

				SUM( IF( (ar_invoice_master.for_export<>1 AND ar_invoice_details.order_flag=1) AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( (ar_invoice_master.for_export=1 AND ar_invoice_details.order_flag=1) AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) ) AS SPRING_SMALL_DIA_VALUE,

				SUM( IF( (ar_invoice_master.for_export<>1 AND ar_invoice_details.order_flag=1) AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( (ar_invoice_master.for_export=1 AND ar_invoice_details.order_flag=1) AND(ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) ) AS SPRING_BIG_DIA_VALUE

				FROM ar_invoice_master INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no WHERE ar_invoice_master.archive <>1 AND ar_invoice_master.cancel_invoice <>1 AND ar_invoice_details.sleeve_dia<>'' AND ar_invoice_details.print_type<>'' 
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%' 

					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date' AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					$sql.="GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
	}
	
/*
	
	public function select_dia_wise_coex_sales_record($table,$from_date,$to_date,$sleeve_diaaa,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

					SUM(if(ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty /100,0) )AS SMALL_DIA,

					SUM(if(ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.arid_qty /100,0 ))AS BIG_DIA,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SMALL_DIA_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS BIG_DIA_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.order_flag=0
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					$sql.="GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc

					) var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
	}


	public function select_dia_wise_spring_sales_record($table,$from_date,$to_date,$sleeve_diaaa,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

					SUM(if(ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty /100,0) )AS SMALL_DIA,

					SUM(if(ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.arid_qty /100,0 ))AS BIG_DIA,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SMALL_DIA_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS BIG_DIA_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					 
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.order_flag=1
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}


					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					$sql.="GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc

					) var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
	}
*/

	/*public function select_print_type_wise_sales_old($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category)){
						$sql.=" INNER JOIN address_master ON ar_invoice_master.customer_no=address_master.adr_company_id";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category)){
						$sql.=" AND address_master.adr_category_id=$customer_category";
					}

					$sql.=" 
					GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}
*/	


	public function select_dia_wise_saless($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category_id,$inv_typee){
		$sql="SELECT * FROM (SELECT 
					ar_invoice_details.sleeve_dia as dia,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category_id)){
						$sql.=" INNER JOIN article_name_info ON ar_invoice_details.article_no=article_name_info.article_no";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category_id)){
						$sql.=" AND article_name_info.company_id='000020'";
						$sql.=" AND article_name_info.language_id='1'";
						$sql.=" AND article_name_info.adr_category_id=$customer_category_id";
					}

					$sql.=" 
					GROUP BY ar_invoice_details.sleeve_dia
										
					ORDER BY 
					ar_invoice_details.sleeve_dia asc) 
					var1 order by dia asc";

					$query=$this->db->query($sql);
					//echo $this->db->last_query();
					return $result=$query->result();
					
	}

	public function select_print_type_wise_sales($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category_id,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category_id)){
						$sql.=" INNER JOIN article_name_info ON ar_invoice_details.article_no=article_name_info.article_no";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category_id)){
						$sql.=" AND article_name_info.company_id='000020'";
						$sql.=" AND article_name_info.language_id='1'";
						$sql.=" AND article_name_info.adr_category_id=$customer_category_id";
					}

					$sql.=" 
					GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					//echo $this->db->last_query();
					return $result=$query->result();
					
	}


	public function select_domestic_export_wise_sales($table,$from_date,$to_date,$sleeve_diaaa,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_master.for_export<>1, ar_invoice_details.arid_qty /100,0) )AS domestic_qty,

					SUM(if(ar_invoice_master.for_export=1 , ar_invoice_details.arid_qty /100,0 ))AS export_qty,

					SUM( IF( ar_invoice_master.for_export<>1, ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )  AS domestic_value,

					SUM( IF( ar_invoice_master.for_export=1, (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS export_value

					
										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category)){
						$sql.=" INNER JOIN address_master ON ar_invoice_master.customer_no=address_master.adr_company_id";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category)){
						$sql.=" AND address_master.adr_category_id=$customer_category";
					}

					$sql.=" 
					GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}


	public function select_print_type_wise_diawise_sales($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 
					ar_invoice_details.sleeve_dia as sleeve_dia,
					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category)){
						$sql.=" INNER JOIN address_master ON ar_invoice_master.customer_no=address_master.adr_company_id";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category)){
						$sql.=" AND address_master.adr_category_id=$customer_category";
					}

					$sql.=" 
					GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date),
					ar_invoice_details.sleeve_dia
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sleeve_dia asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}

	/*
	public function select_print_type_wise_coex_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' , ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category)){
						$sql.=" INNER JOIN address_master ON ar_invoice_master.customer_no=address_master.adr_company_id";
					}
						$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.order_flag=0
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category)){
						$sql.=" AND address_master.adr_category_id=$customer_category";
					}

					$sql.=" GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}


	public function select_print_type_wise_spring_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category,$inv_typee){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0) )AS FLEXO_DIGITAL_FLEXO,

					SUM(if(ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO', ar_invoice_details.arid_qty /100,0 ))AS FLEXO_DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS FLEXO_DIGITAL_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS FLEXO_DIGITAL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
					if(!empty($customer_category)){
						$sql.=" INNER JOIN address_master ON ar_invoice_master.customer_no=address_master.adr_company_id";
					}
					$sql.="	WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.order_flag=1

					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					if(!empty($customer_in)){
						$sql.="AND ar_invoice_master.customer_no IN ($customer_in)";
					}

					if(!empty($sleeve_diaaa)){
						$sql.="AND ar_invoice_details.sleeve_dia IN ($sleeve_diaaa)";
					}

					if(!empty($for_export)){
						$sql.=" AND ar_invoice_master.for_export=$for_export";
					}

					if(!empty($customer_category)){
						$sql.=" AND address_master.adr_category_id=$customer_category";
					}

					$sql.=" GROUP BY 
					MONTH( ar_invoice_master.invoice_date ), 
					YEAR( ar_invoice_master.invoice_date)
										
					ORDER BY 
					ar_invoice_master.invoice_date desc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();

	}*/


//USED IN REPORT (TOP CUSTOMER)
	public function select_top_customer($table,$company,$from_date,$to_date,$sleeve_diaaa,$inv_typee){
		
		$this->db->select("MONTH(ar_invoice_master.invoice_date) as month_no,
						YEAR( ar_invoice_master.invoice_date ) as sales_year, 
						MONTHNAME( ar_invoice_master.invoice_date) as sales_month,address_master.name1 as customer_name,
						sum((ar_invoice_details.arid_qty/100)) as sale_quantity,
						article_name_info.adr_category_id,
						address_category_master.category_name as customer,
						address_category_master.adr_category_id as customer_no,
						ar_invoice_master.for_export as export,

						SUM( IF( ar_invoice_master.for_export=1, ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1, (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value,

						SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', (ar_invoice_details.arid_qty /100),0) )AS SCREEN_FLEXO,

						SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , (ar_invoice_details.arid_qty /100),0 ))AS OFFSET,

						SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', (ar_invoice_details.arid_qty /100),0 ))AS LABEL,

						SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL',(ar_invoice_details.arid_qty /100),0) )AS DIGITAL,


						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )  AS SCREEN_FLEXO_VALUE,


						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE,

						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE");
						$this->db->from($table);
						$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
						$this->db->join('ar_invoice_details','ar_invoice_details.ar_invoice_no=ar_invoice_master.ar_invoice_no','LEFT');
						$this->db->join('article_name_info','ar_invoice_details.article_no=article_name_info.article_no','LEFT');
						$this->db->join('address_category_master','article_name_info.adr_category_id=address_category_master.adr_category_id','LEFT');
						$this->db->where($table.'.archive<>', '1');
						$this->db->where(''.$table.'.cancel_invoice<>', '1');
						$this->db->where('ar_invoice_details.article_no<>', 'OTH-FRL-000-0001');
						$this->db->not_like('ar_invoice_details.article_no', 'SRM-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SRP-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SSRM-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SSRP-000-');
						$this->db->where('ar_invoice_details.print_type<>', '');
						$this->db->where('ar_invoice_details.sleeve_dia<>', '');
						$this->db->where('article_name_info.company_id',$company);
						$this->db->where($table.'.company_id',$company);
						$this->db->where(''.$table.'.invoice_date >=', $from_date);
						$this->db->where(''.$table.'.invoice_date <=', $to_date);
						if(!empty($inv_typee)){
							$this->db->where_in(''.$table.'.inv_type',$inv_typee,FALSE);
						}else{
							$inv_typee=array(1,2,8,11,3);
							$this->db->where_in(''.$table.'.inv_type',$inv_typee);
						}

						if(!empty($sleeve_diaaa)){

							$this->db->where_in('ar_invoice_details.sleeve_dia',$sleeve_diaaa,FALSE);
							//$this->db->group_by('ar_invoice_details.sleeve_dia');
						}
						
						$this->db->group_by('article_name_info.adr_category_id');
						//$this->db->group_by('ar_invoice_details.sleeve_dia');
						$this->db->order_by('sale_quantity desc');
						$query = $this->db->get();
						return $result=$query->result();
						

			}


			public function select_top_customer_diawise($table,$company,$from_date,$to_date,$adr_category_id,$inv_typee,$sleeve_diaaa){
		
		$this->db->select("MONTH(ar_invoice_master.invoice_date) as month_no,
						YEAR( ar_invoice_master.invoice_date ) as sales_year, 
						MONTHNAME( ar_invoice_master.invoice_date) as sales_month,address_master.name1 as customer_name,
						sum((ar_invoice_details.arid_qty/100)) as sale_quantity,
						article_name_info.adr_category_id,
						address_category_master.category_name as customer,
						ar_invoice_master.for_export as export,
						ar_invoice_details.sleeve_dia as sleeve_dia,

						SUM( IF( ar_invoice_master.for_export=1, ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1, (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value,

						SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', (ar_invoice_details.arid_qty /100),0) )AS SCREEN_FLEXO,

						SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , (ar_invoice_details.arid_qty /100),0 ))AS OFFSET,

						SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', (ar_invoice_details.arid_qty /100),0 ))AS LABEL,

						SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL',(ar_invoice_details.arid_qty /100),0) )AS DIGITAL,


						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )  AS SCREEN_FLEXO_VALUE,


						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE,

						SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE");
						$this->db->from($table);
						$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
						$this->db->join('ar_invoice_details','ar_invoice_details.ar_invoice_no=ar_invoice_master.ar_invoice_no','LEFT');
						$this->db->join('article_name_info','ar_invoice_details.article_no=article_name_info.article_no','LEFT');
						$this->db->join('address_category_master','article_name_info.adr_category_id=address_category_master.adr_category_id','LEFT');
						$this->db->where($table.'.archive<>', '1');
						$this->db->where(''.$table.'.cancel_invoice<>', '1');
						$this->db->where('ar_invoice_details.article_no<>', 'OTH-FRL-000-0001');
						$this->db->not_like('ar_invoice_details.article_no', 'SRM-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SRP-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SSRM-000-');
						$this->db->not_like('ar_invoice_details.article_no', 'SSRP-000-');
						$this->db->where('ar_invoice_details.print_type<>', '');
						$this->db->where('ar_invoice_details.sleeve_dia<>', '');
						$this->db->where('article_name_info.company_id',$company);
						$this->db->where($table.'.company_id',$company);
						$this->db->where(''.$table.'.invoice_date >=', $from_date);
						$this->db->where(''.$table.'.invoice_date <=', $to_date);
						$this->db->where('address_category_master.adr_category_id',$adr_category_id);

						if(!empty($inv_typee)){
							$this->db->where_in(''.$table.'.inv_type',$inv_typee,FALSE);
						}else{
							$inv_typee=array(1,2,8,11,3);
							$this->db->where_in(''.$table.'.inv_type',$inv_typee);
						}

						if(!empty($sleeve_diaaa)){

							$this->db->where_in('ar_invoice_details.sleeve_dia',$sleeve_diaaa,FALSE);
							//$this->db->group_by('ar_invoice_details.sleeve_dia');
						}
						
						$this->db->group_by('article_name_info.adr_category_id,ar_invoice_details.sleeve_dia');
						//$this->db->group_by('');
						$this->db->order_by('sleeve_dia asc');
						//$this->db->order_by('article_name_info.adr_category_id asc');
						//echo $this->db->last_query();
						$query = $this->db->get();
						return $result=$query->result();
						

			}


//USED in REPORT SALES 5 Year Monthwise
	public function sales_five_year_apr_march_monthwise($table,$from_date,$to_date){
		$sql="SELECT * from (SELECT  /*
					ar_invoice_master.invoice_date as sort,*/
					MONTH(ar_invoice_master.invoice_date) as month_no,
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 
					
					YEAR( ar_invoice_master.invoice_date) as sales_year,
					/*
					ar_invoice_master.invoice_date,*/
					SUM( if( ar_invoice_master.invoice_date between '2015-04-01' AND '2016-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_fifteen_sixteen,


					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2015-04-01' AND '2016-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2015-04-01' AND '2016-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_fifteen_sixteen,


					SUM( if( ar_invoice_master.invoice_date between '2016-04-01' AND '2017-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_sixteen_seventeen,

					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2016-04-01' AND '2017-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2016-04-01' AND '2017-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_sixteen_seventeen,

					SUM( if( ar_invoice_master.invoice_date between '2017-04-01' AND '2018-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_seventeen_eighteen,

					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2017-04-01' AND '2018-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2017-04-01' AND '2018-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_seventeen_eighteen,

					SUM( if( ar_invoice_master.invoice_date between '2018-04-01' AND '2019-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_eighteen_nineteen,

					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2018-04-01' AND '2019-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2018-04-01' AND '2019-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_eighteen_nineteen,

					SUM( if( ar_invoice_master.invoice_date between '2019-04-01' AND '2020-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_nineteen_twenty,

					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2019-04-01' AND '2020-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2019-04-01' AND '2020-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_nineteen_twenty,

					SUM( if( ar_invoice_master.invoice_date between '2020-04-01' AND '2021-03-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity_twenty_twentyone,

					SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '2020-04-01' AND '2021-03-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '2020-04-01' AND '2021-03-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value_twenty_twentyone

					
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no

					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.order_flag IN(0,1)

					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'";

					if(!empty($inv_typee)){
						$sql.="AND ar_invoice_master.inv_type IN ($inv_typee)";
					}else{
						$sql.="AND ar_invoice_master.inv_type IN (1,2,3,8,11)";
					}

					$sql.=" GROUP BY 
					MONTH(ar_invoice_master.invoice_date)) A LEFT JOIN month_sorting ON A.month_no=month_sorting.month_no order by month_sorting.sr_no";

					$query=$this->db->query($sql);
					return $result=$query->result();
	}


	public function sales_five_year_jan_dec_monthwise($table,$from_date,$to_date){

		$sql="SELECT * from (SELECT  
					MONTH(ar_invoice_master.invoice_date) as month_no,
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month,";

					for($i=16;$i<=21;$i++){
						$sql.="SUM( if( ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', (ar_invoice_details.arid_qty /100),0) ) AS quantity$i,

							SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )  AS value$i,

							ROUND((SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', ar_invoice_details.calc_sell_price*(ar_invoice_master.exchange_rate/100)*(ar_invoice_details.arid_qty/100), 0 ) )+SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', (ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100), 0 ) )) / (SUM( if( ar_invoice_master.invoice_date between '20$i-01-01' AND '20$i-12-31', (ar_invoice_details.arid_qty /100),0) )),2) AS avg$i,";
						
					}
					$sql.="YEAR( ar_invoice_master.invoice_date) as sales_year
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_details.order_flag IN(0,1)
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND '$to_date'
					AND ar_invoice_master.inv_type IN (1,2,3,8,11)
					GROUP BY MONTH( ar_invoice_master.invoice_date)) A 
					LEFT JOIN month_sorting ON A.month_no=month_sorting.sr_no order by month_sorting.sr_no";

					$query=$this->db->query($sql);
					return $result=$query->result();
	}




	public function sales_five_year_print_type_wise($table,$from_date,$to_date){
		$sql="SELECT * FROM (SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='Flexo +screen' OR ar_invoice_details.print_type='SCREEN + HOTFOIL'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='Flexo +screen' OR ar_invoice_details.print_type='SCREEN + HOTFOIL'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'
					AND ar_invoice_master.inv_type IN (1,2,3,8,11)
					GROUP BY YEAR( ar_invoice_master.invoice_date)
					ORDER BY ar_invoice_master.invoice_date asc) 
					var1 order by sort asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}


	public function sales_five_year_print_type_apr_mar_wise($table,$from_date,$to_date){
		$sql="SELECT ar_invoice_master.invoice_date as sort,
					MONTH(ar_invoice_master.invoice_date) as month_no,
					YEAR( ar_invoice_master.invoice_date ) as sales_year, 
					LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, 

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='SCREEN + HOTFOIL' OR ar_invoice_details.print_type='Flexo +screen'  OR ar_invoice_details.print_type='FLEXO SCREEN', ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='FLEXO+SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='Flexo +screen' OR ar_invoice_details.print_type='SCREEN + HOTFOIL'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' OR ar_invoice_details.print_type='Flexo +screen' OR ar_invoice_details.print_type='SCREEN + HOTFOIL'  OR ar_invoice_details.print_type='FLEXO SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL' OR ar_invoice_details.print_type='LABEL + OFFSET'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					LEFT JOIN month_sorting ON MONTH(ar_invoice_master.invoice_date)=month_sorting.month_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date'
					AND ar_invoice_master.inv_type IN (1,2,3,8,11)
					GROUP BY YEAR( ar_invoice_master.invoice_date) order by month_sorting.sr_no ";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}





	public function sales_summary($table,$from_date,$to_date,$customer_in,$sleeve_diaaa,$for_export,$customer_category){
		$sql="SELECT ar_invoice_details.sleeve_dia ,

					SUM(if(ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN' , ar_invoice_details.arid_qty /100,0) )AS SCREEN_FLEXO,

					SUM(if(ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN' , ar_invoice_details.arid_qty /100,0 ))AS OFFSET,

					SUM(if(ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL', ar_invoice_details.arid_qty /100,0 ))AS LABEL,

					SUM(if(ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO', ar_invoice_details.arid_qty /100,0 ))AS DIGITAL,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='SCREEN' OR ar_invoice_details.print_type='SCREEN+FLEXO' OR ar_invoice_details.print_type='FLEXO' OR ar_invoice_details.print_type='SCREEN+UPTO NECK' OR ar_invoice_details.print_type='OFFSET SCREEN'), ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SCREEN_FLEXO_VALUE,


					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='OFFSET' OR ar_invoice_details.print_type='PLAIN'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS OFFSET_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='LABEL OFFSET' OR ar_invoice_details.print_type='SCREEN + LABEL' OR ar_invoice_details.print_type='SCREEN UP TO NECK+LABEL' OR ar_invoice_details.print_type='LABELING' OR ar_invoice_details.print_type='LABEL' OR ar_invoice_details.print_type='OFFSET+LABEL'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS LABEL_VALUE,

					SUM( IF( ar_invoice_master.for_export<>1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO'), ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND (ar_invoice_details.print_type='DIGITAL+FLEXO' OR ar_invoice_details.print_type='FLEXO+DIGITAL' OR ar_invoice_details.print_type='FLEXO+DIGITAL+FLEXO'), (ar_invoice_details.arid_qty/100)*(ar_invoice_master.exchange_rate/100)*ar_invoice_details.calc_sell_price, 0 ) )  AS DIGITAL_VALUE

										
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_master.inv_type IN (1,2,8,11) 
					AND ar_invoice_details.print_type<>''
					AND ar_invoice_details.article_no NOT LIKE '%OTH-FRL-000%'
					AND ar_invoice_details.article_no NOT LIKE '%SRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SRP-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRM-000-%'
					AND ar_invoice_details.article_no NOT LIKE '%SSRP-000-%'
					AND ar_invoice_details.order_flag IN(0,1)
					AND ar_invoice_master.invoice_date between '$from_date'
					AND '$to_date' GROUP BY 
					ar_invoice_details.sleeve_dia
										
					ORDER BY 
					ar_invoice_details.sleeve_dia asc";

					$query=$this->db->query($sql);
					return $result=$query->result();
					//$this->db->last_query();
	}


function sales_total_order_dispathed_count($from_date,$to_date){
	$sql="SELECT COUNT(A.Orders_dispatchedd) as Orders_dispatched  from (SELECT  
			distinct(ar_invoice_details.ref_ord_no)
			 AS Orders_dispatchedd
			FROM  `ar_invoice_master` 
			INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
			WHERE ar_invoice_master.invoice_date
			BETWEEN  '$from_date'
			AND  '$to_date'
			AND ar_invoice_master.cancel_invoice<>1
			AND ar_invoice_details.ref_ord_no<>''
			AND ar_invoice_master.inv_type IN(1,2,3,11,8))  A";
	$query=$this->db->query($sql);
	return $result=$query->result();
}


function sales_total_order_completed_count($from_date,$to_date){
	$sql="select count(B.STATUS) as order_completed  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		) A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='COMPLETED'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}


function sales_total_order_short_completed_count($from_date,$to_date){
	$sql="select count(B.STATUS) as order_short_completed  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		) A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='SHORT CLOSED'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}

function sales_open_order_count($from_date,$to_date){
	$sql="select count(B.STATUS) as open_order  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		) A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='OPEN ORDER'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}

function sales_total_order_completed_volume($from_date,$to_date){
	$sql="select count(B.STATUS) as order_completed,(sum(B.dispatch_qty)/100) as full_dispatch_volume  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (

		SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		)A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='COMPLETED'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}

function sales_total_open_order_dispatch_volume($from_date,$to_date){
	$sql="select (sum(B.dispatch_qty)/100) as open_order_dispatch_volume  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (

		SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		)A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='OPEN ORDER'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}

function sales_total_short_completed_volume($from_date,$to_date){
	$sql="select B.dispatch_qty/100 as short_dispatch_volume,B.order_qty/100 as order_volume,sum((B.order_qty/100- B.dispatch_qty/100)) as short_tubes  from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (SELECT distinct(ar.ref_ord_no), ar.article_no, ar.arid_qty
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		)A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='SHORT CLOSED'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}




function sales_total_order_completed_net($from_date,$to_date){
	$sql="select count(B.STATUS) as order_completed,(sum(B.dispatch_qty)/100) as full_dispatch_volume, 
	(sum(B.sales_value)) as sales_values from (SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, A.sales_value,od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
		STATUS , om.trans_closed, om.order_closed
		FROM (

		SELECT ar.ref_ord_no, ar.article_no, ar.arid_qty/100, SUM( IF( am.for_export<>1, ar.arid_qty/100*ar.selling_price/100, 0 ) )+SUM( IF( am.for_export=1, (ar.arid_qty/100)*(am.exchange_rate/100)*ar.calc_sell_price, 0 ) )  AS sales_value
		FROM  `ar_invoice_master` am
		INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
		LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		WHERE ar.ref_ord_no <>  ''
		AND am.invoice_date
		BETWEEN  '$from_date'
		AND  '$to_date'
		AND am.cancel_invoice <>1
		AND am.inv_type IN(1,2,3,11,8)
		group by ar.ref_ord_no,ar.article_no
		)A
		INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
		AND ar.article_no = A.article_no
		LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
		LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
		AND ar.article_no = od.article_no
		GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='COMPLETED'";
		$query=$this->db->query($sql);
		return $result=$query->result();
}

	function sales_total_order_short_completed_net($from_date,$to_date){
		$sql="select sum(B.order_qty/100) as order_volume,sum(B.dispatch_qty/100) as dispatch_volume,
		sum((B.order_qty/100- B.dispatch_qty/100)) as short_tubes,sum((B.order_qty/100- B.dispatch_qty/100)*B.unit_price) as short_tubes_sales
		from (SELECT A.ref_ord_no, A.article_no,A.arid_qty,A.unit_price, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) >= od.total_order_quantity,  'COMPLETED',  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),'SHORT CLOSED','OPEN ORDER')) AS 
			STATUS , om.trans_closed, om.order_closed
			FROM (SELECT distinct(ar.ref_ord_no), ar.article_no,ar.arid_qty,
		IF( am.for_export<>1, ar.selling_price/100,(am.exchange_rate/100)*(ar.calc_sell_price) ) as unit_price
			FROM  `ar_invoice_master` am
			INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
			LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
			LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
			AND ar.article_no = od.article_no
			WHERE ar.ref_ord_no <>  ''
			AND am.invoice_date
			BETWEEN  '$from_date'
			AND  '$to_date'
			AND am.cancel_invoice <>1
			AND am.inv_type IN(1,2,3,11,8)
			group by ar.ref_ord_no,ar.article_no
			)A
			INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
			AND ar.article_no = A.article_no
			LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
			LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
			AND ar.article_no = od.article_no
			GROUP BY A.ref_ord_no, A.article_no) B where B.STATUS ='SHORT CLOSED'";
			$query=$this->db->query($sql);
			return $result=$query->result();
	}


	public function select_top_product_by_costsheet($table,$company,$from_date,$to_date,$sleeve_diaaa,$print,$customer_category,$data){
		
		$this->db->select("dia,print_type,customer_id,costsheet_master.article_no,article_name_info.adr_category_id,
			sum(`dispatch_quantity`) as dispatch_quantity,
			sum(dispatch_quantity*unit_rate)as net_amount,
			sum(dispatch_quantity*unit_rate)/sum(`dispatch_quantity`)as avg_price,
			sum(total_costing)as total_costing,
			sum(total_costing)/sum(`dispatch_quantity`) as avg_cost,
			sum(dispatch_quantity*unit_rate)-sum(total_costing) as total_contribution,
			(sum(dispatch_quantity*unit_rate)-sum(total_costing))/sum(`dispatch_quantity`) as avg_contribution");
		$this->db->from($table);
		$this->db->join('article_name_info','costsheet_master.article_no=article_name_info.article_no','LEFT');
		$this->db->join('address_category_master','article_name_info.adr_category_id=address_category_master.adr_category_id','LEFT');
		if(!empty($print)){
		$this->db->join('lacquer_types_master',''.$table.'.print_type=lacquer_types_master.lacquer_type','LEFT');
		}
		$this->db->where($table.'.archive<>', '1');
		$this->db->where('article_name_info.company_id',$company);
		if($from_date!='' && $to_date!=''){
			$this->db->where($table.'.invoice_date >=', $from_date);
			$this->db->where($table.'.invoice_date <=', $to_date);
		}
		if(!empty($sleeve_diaaa)){
			$this->db->where_in('dia',$sleeve_diaaa,FALSE);
		}
		if(!empty($print)){
	    	$this->db->where('lacquer_types_master.printing_group',$print);
	    }
	    if(!empty($data)){
	    	foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}	
	    }

	    if(!empty($customer_category)){
	    	$this->db->where('article_name_info.adr_category_id',$customer_category);
	    	$this->db->where('article_name_info.company_id',$company);
	    }		
		 
		$this->db->not_like('article_name_info.article_no', 'SRM-000');
		$this->db->not_like('article_name_info.article_no', 'SRP-000');
		$this->db->not_like('article_name_info.article_no', 'SSRM-000');
		$this->db->not_like('article_name_info.article_no', 'SSRP-000');
		$this->db->group_by('adr_category_id,article_no');
		
		$this->db->order_by('sum(dispatch_quantity)','DESC');
		//echo $this->db->last_query();
		$query = $this->db->get();
		return $result=$query->result();
						

	}

	function sales_avg_dia($from_date,$to_date,$customer_category){
		$sql="SELECT sleeve_diameter_master.sleeve_diameter as sleeve_diameter, sales.sleeve_dia, sales.qty,(
			sales.sleeve_dia * sales.qty) dia_volume FROM sleeve_diameter_master
			LEFT JOIN (
				SELECT sleeve_dia, SUM( arid_qty /100 ) qty
				FROM ar_invoice_master
				INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no";
				if(!empty($customer_category)){
					$sql.=" INNER JOIN article_name_info ON ar_invoice_details.article_no = article_name_info.article_no";
				}
				
				$sql.=" WHERE ar_invoice_master.company_id = '000020'
				AND ar_invoice_master.archive <>1
				AND ar_invoice_master.cancel_invoice =0";
				if(!empty($customer_category)){
					$sql.=" AND article_name_info.adr_category_id = $customer_category
							AND article_name_info.company_id = '000020'
							AND article_name_info.language_id =1";
				}
				if(!empty($from_date) && !empty($to_date)){
					$sql.=" AND ar_invoice_master.invoice_date	BETWEEN '".$from_date."' AND  '".$to_date."'";
				}
				
				$sql.="  GROUP BY sleeve_dia
			) sales ON sleeve_diameter_master.sleeve_diameter = sales.sleeve_dia
			WHERE sleeve_diameter_master.company_id = '000020'
			AND sleeve_diameter_master.archive = 0
			ORDER BY sleeve_diameter";
			//echo $sql;
			$query=$this->db->query($sql);
			return $result=$query->result();
	}

}

?>