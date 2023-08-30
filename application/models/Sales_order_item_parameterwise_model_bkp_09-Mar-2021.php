<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_item_parameterwise_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company,$order_by){
	

		$this->db->select('order_master.*,order_details.*,address_master.name1,address_master.isdn_local,user_master.login_name,order_master_lang.lang_addi_info');
		$this->db->from($table);
		$this->db->join('order_details','order_master.order_no=order_details.order_no','LEFT');
		$this->db->join('address_master','order_master.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('user_master','order_master.user_id=user_master.user_id','LEFT');
		$this->db->join('order_master_lang','order_master.order_no=order_master_lang.order_no','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive<>', '1');
		$this->db->where(''.$table.'.final_approval_flag', '1');
		$this->db->where(''.$table.'.order_closed<>', '1');
		$this->db->where(''.$table.'.trans_closed<>', '1');
		$this->db->where(''.$table.'.created_pr_inv<>', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key, $value,'after');
			}
	    }
	    if($order_by!=''){
	    	$this->db->order_by($order_by,'DESC');
	    }
	    else{
	    	$this->db->order_by(' '.$table.'.order_no');
	    }
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function active_record_search_planning($table,$data,$from,$to,$company,$order_by){
	

		$this->db->select('order_master.*,order_details.*,address_master.name1,address_master.isdn_local,user_master.login_name');
		$this->db->from($table);
		$this->db->join('order_details','order_master.order_no=order_details.order_no','LEFT');
		$this->db->join('address_master','order_master.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('user_master','order_master.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive<>', '1');
		$this->db->where(''.$table.'.order_flag<>', '1');
		//$this->db->where(''.$table.'.final_approval_flag', '1');
		$this->db->where(''.$table.'.order_closed<>', '1');
		$this->db->where(''.$table.'.trans_closed<>', '1');
		$this->db->where(''.$table.'.created_pr_inv<>', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key, $value,'after');
			}
	    }
	    if($order_by!=''){
	    	$this->db->order_by($order_by,'DESC');
	    }
	    else{
	    	$this->db->order_by(' '.$table.'.order_no');
	    }
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}

	public function active_record_search_planning_springtube($table,$data,$from,$to,$company,$order_by){
	

		$this->db->select('order_master.*,order_details.*,address_master.name1,address_master.isdn_local,user_master.login_name');
		$this->db->from($table);
		$this->db->join('order_details','order_master.order_no=order_details.order_no','LEFT');
		$this->db->join('address_master','order_master.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('user_master','order_master.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive<>', '1');
		$this->db->where(''.$table.'.order_flag', '1');
		//$this->db->where(''.$table.'.final_approval_flag', '1');
		$this->db->where(''.$table.'.order_closed<>', '1');
		$this->db->where(''.$table.'.trans_closed<>', '1');
		$this->db->where(''.$table.'.created_pr_inv<>', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key, $value,'after');
			}
	    }
	    if($order_by!=''){
	    	$this->db->order_by($order_by,'DESC');
	    }
	    else{
	    	$this->db->order_by(' '.$table.'.order_no');
	    }
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}
	// After Bom Implementation
	public function active_record_search_new($table,$data,$from,$to,$company,$order_by){
	

		$this->db->select('order_master.* , order_details. *,address_master.name1,address_master.isdn_local,user_master.login_name');
		$this->db->from($table);
		$this->db->join('order_details','order_master.order_no=order_details.order_no','LEFT');
		$this->db->join('address_master','order_master.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('specification_sheet','order_details.spec_id=specification_sheet.spec_id','LEFT');
		$this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no','LEFT');
		//$this->db->join('address_details','order_master.customer_no=address_details.adr_company_id','LEFT');
		//$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master','order_master.user_id=user_master.user_id','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		//$this->db->where('order_details.spec_version_no=specification_sheet.spec_version_no');
		//$this->db->where('property_master.language_id','1');
		//$this->db->where(''.$table.'.archive<>', '1');
		//$this->db->where(''.$table.'.final_approval_flag', '1');
		//$this->db->where(''.$table.'.order_closed<>', '1');
		//$this->db->where(''.$table.'.trans_closed<>', '1');
		//$this->db->where(''.$table.'.created_pr_inv<>', '1');
		$this->db->where(''.$table.'.order_date >=', $from);
		$this->db->where(''.$table.'.order_date <=', $to);
		
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key, $value,'after');
			}
	    }
	    if($order_by!=''){
	    	$this->db->order_by($order_by,'DESC');
	    }
	    else{
	    	$this->db->order_by(' '.$table.'.order_no');
	    }
		
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


	public function select_specs_by_parameter($table,$company,$data,$search){
		$sql= "SELECT * FROM ( SELECT spec_id,spec_version_no,layer_no,							
							MAX(CASE WHEN item_group_id =3 AND parameter_name='DIA' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'sleeve_diameter',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='LENGTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'sleeve_length',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='MASTER BATCH' THEN mat_article_no END) AS 'sleeve_master_batch',
							MAX(CASE WHEN item_group_id =3 AND parameter_name='PRINT TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'sleeve_print_type',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='NECK TYPE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'shoulder_type',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'shoulder_orifice',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'shoulder_master_batch',
							MAX(CASE WHEN item_group_id =4 AND parameter_name='SHOULDER FOIL TAG' THEN IF(parameter_value!='',parameter_value,relating_master_value)  END) AS 'shoulder_foil_tag',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='DIAMETER' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_dia',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MOLD FINISH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_finish',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='ORIFICE' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_orifice',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='MASTER BATCH' THEN mat_article_no  END) AS 'cap_master_batch',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL COLOR' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_foil_color',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='CAP FOIL WIDTH' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_foil_width',
							MAX(CASE WHEN item_group_id =5 AND parameter_name='HEIGHT' THEN IF(parameter_value!='',parameter_value,relating_master_value) END) AS 'cap_height'
							FROM specification_sheet_details WHERE company_id='000020' AND layer_no=1";
					if(!empty($data)){
						foreach($data as $key => $value) {
						$sql.=" AND ".$table.".".$key."='".$value."'";
						}
	   				}
	   		$sql.=" group by spec_id, spec_version_no ) as temp_specification_details
	   				WHERE 1=1";
		
		if(!empty($search)){

			foreach($search as $key => $value) {

				$sql.=" AND ".$key." like '".$value."%'";

				// if($value!='' AND $key!='shoulder_orifice' OR $key!='cap_orifice'){
				// 	$value=$this->only_numbers_from_string($value);
				// 	$sql.=" AND ".$key." like '".$value."%'";
				// }
				// if ($value!='' AND $key=='shoulder_orifice'){
				// 	$sql.=" AND ".$key." like '".$value."%'";
				// }
				// else if ($value!='' AND $key=='cap_orifice'){
				// 	$sql.=" AND ".$key." like '".$value."%'";
				// }
				// else{
				// 	$value=$this->only_numbers_from_string($value);
				// 	$sql.=" AND ".$key." like '".$value."%'";
				// }
			}
	    }
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();
		
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
		$this->db->select($table.'.*,address_master.name1 as customer_name,address_master.isdn_local,user_master.login_name as username,a.login_name as approval_username,address_master.strno,address_master.name2,address_master.street,address_master.name3,zip_code_master.state_code,zip_code_master.lang_city');
		$this->db->from($table);
		$this->db->join('address_master',$table.'.customer_no=address_master.adr_company_id','LEFT');
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

	// Function to return Only Numbers----
	public function only_numbers_from_string($string){
		$arr=str_split($string);
		$num=0;
		$flag=0;
		for($i=0;$i<count($arr);$i++){
			if(ord($arr[$i])>=48 AND ord($arr[$i])<=57){
				$num=$num*10+$arr[$i];
				$flag=1;
			}
		}
		return ($flag==1?$num:$string);
	}


	public function select_packing_box_record($table,$company,$from,$to,$data){
		$this->db->select($table.'.*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where(''.$table.'.height >=', $from);
		$this->db->where(''.$table.'.height <=', $to);
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->order_by(''.$table.'.height');	   
	    $this->db->limit(1,0);	 	
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function get_total_issue_qty($table,$company,$data){
		$this->db->select('qty');
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




}

?>