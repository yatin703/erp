<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_card_model extends CI_Model {


	public function select_active_batch_records($limit=1,$start=0,$table,$company,$article_no){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('article_no',$article_no);
		$this->db->where('batch_no<>','');
		$this->db->where('sales_purchase_flag','0');
		$this->db->where('remaining_batch_qty<>','0');
		$this->db->where('company_id',$company);
		$this->db->where('date>','2016-06-01');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_batch_records_2($limit=2,$start=1,$table,$company,$article_no){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('article_no',$article_no);
		$this->db->where('batch_no<>','');
		$this->db->where('sales_purchase_flag','0');
		$this->db->where('remaining_batch_qty<>','0');
		$this->db->where('company_id',$company);
		$this->db->where('date>','2016-06-01');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.manu_plan_date','desc');
		$this->db->order_by($table.'.manu_order_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->limit($limit, $start);
		$this->db->order_by($table.'.manu_plan_date','desc');
		$this->db->order_by($table.'.manu_order_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.mp_pos_no',$edit);		
		$query = $this->db->get();
		return $result=$query->result();
	}
	// Select one Nonprinted Jobcard For springtube Printing Production Entry
	public function select_one_active_jobcard_for_printing($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.mp_pos_no',$edit);
		$this->db->where($table.'.jobcard_type', '2');
		$this->db->where($table.'.printing_done', '0');		
		$query = $this->db->get();
		return $result=$query->result();
	}
	// Select one Jobcard with printing done For springtube Printing Inspection Entry
	public function select_one_active_jobcard_for_printing_inspection($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.mp_pos_no',$edit);
		$this->db->where($table.'.jobcard_type', '2');
		$this->db->where($table.'.printing_done', '1');		
		$query = $this->db->get();
		return $result=$query->result();
	}

	
	// public function active_record_search($table,$data,$from,$to,$company){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.archive<>', '1');
	// 	$this->db->where($table.'.company_id',$company);
	// 	if(!empty($from) && !empty($to)){
	// 		$this->db->where(''.$table.'.manu_plan_date >=', $from);
	// 	$this->db->where(''.$table.'.manu_plan_date <=', $to);
	// 	}
	// 	foreach($data as $key => $value) {
	// 		$this->db->where($key,$value);
	// 	}
	// 	$this->db->order_by($table.'.manu_plan_date','desc');
	// 	$this->db->order_by($table.'.manu_order_no','desc');
	// 	$query = $this->db->get();
	// 	return $result=$query->result();
	// }
	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('order_master',$table.'.sales_ord_no=order_master.order_no','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.manu_plan_date >=', $from);
		$this->db->where(''.$table.'.manu_plan_date <=', $to);
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->order_by($table.'.manu_plan_date','desc');
		$this->db->order_by($table.'.manu_order_no','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_manual($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.type_flag', '5');
		$this->db->where($table.'.company_id',$company);
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.date_required >=', $from);
			$this->db->where(''.$table.'.date_required <=', $to);
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->order_by($table.'.created_date','desc');
		
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function jobcard_active_record_search($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND manu_plan_date>='2021-03-31' AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no  ");

		return $result=$query->result();
	}

	public function jobcard_active_record_search_coex($table,$edit,$company){

		$todate = date('Y-m-d');
		$dt=strtotime($todate);
		$fromdate=date("Y-m-d", strtotime("-4 month", $dt));
		//echo $fromdate;
		//echo'<br/>';
		//echo $todate;

		$query=$this->db->query("SELECT * FROM $table WHERE jobcard_type=0 AND  archive<>1 AND company_id =  '$company' AND manu_plan_date>='".$fromdate."' AND manu_plan_date<='".$todate."' AND mp_pos_no LIKE '%$edit%' order by mp_pos_no  ");

		return $result=$query->result();
	}


	public function jobcard_active_record_search_extrusion($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND jobcard_type =1 AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}

	public function open_jobcard_active_record_search_extrusion($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM production_master P INNER JOIN order_master O ON P.sales_ord_no=O.order_no WHERE P.archive<>1 AND P.company_id =  '$company' AND P.jobcard_type =1 AND P.jobcard_status=0 AND  P.mp_pos_no like '%$edit%' AND O.order_closed<>1 AND O.trans_closed<>1 AND O.cancel_flag<>1 order by P.mp_pos_no");

		//echo $this->db->last_query();

		return $result=$query->result();
	}

	public function jobcard_active_record_search_printing($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND jobcard_type =2 AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}

	public function jobcard_active_record_search_printing_for_production($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND printing_done=0 AND jobcard_type =2 AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}

	public function jobcard_active_record_search_printing_inspection($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND printing_done=1 AND jobcard_type =2 AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}
	public function jobcard_active_record_search_printing_inspection_for_production($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND printing_done=1 AND inspection_done=0 AND jobcard_type =2 AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}

	public function jobcard_active_record_search_bodymaking($table,$edit,$company){

		$query=$this->db->query("SELECT * FROM $table WHERE archive<>1 AND company_id =  '$company' AND jobcard_type =3  AND  mp_pos_no LIKE '%$edit%' order by mp_pos_no ");

		return $result=$query->result();
	}

	public function get_value($value){
		if(!is_float($value)){
			$newstring = substr_replace($value, '.', strlen($value)-2, 0);
			return $newstring;
			
		}
		else{
			return $value;
		}
	
	}

	public 	function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {

	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current <= $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}

	public function jobcard_material_summary($table,$data,$company){

		$this->db->select('manu_order_no,article_no,SUM(demand_qty) as demand_qty');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->group_by('manu_order_no,article_no');
				
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	
	}

	public function jobcard_material_summary_new($table,$data,$company,$jobcard_arr){

		$this->db->select('article_no,SUM(demand_qty/100) total_demand_qty,SUM((demand_qty/100)*( calculated_purchase_price/100))amount,(SUM((demand_qty/100)*(calculated_purchase_price /100))/SUM(demand_qty/100)) avg_rate');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->where_in('manu_order_no',$jobcard_arr,FALSE);
	    $this->db->group_by('article_no');
				
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		//$this->db->where_not_in(''.$table.'.work_proc_no', $in);


	
	}
	public function jobcard_additional_material_summary($table,$data,$company,$jobcard_arr,$notin){

		$this->db->select('article_no,SUM(demand_qty/100) total_demand_qty,SUM((demand_qty/100)*( calculated_purchase_price/100))amount,(SUM((demand_qty/100)*(calculated_purchase_price /100))/SUM(demand_qty/100)) avg_rate');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    if(!empty($jobcard_arr)){
	    	$this->db->where_in('manu_order_no',$jobcard_arr,FALSE);
	    }
	    if($notin!=''){
	    	$this->db->where_not_in(''.$table.'.work_proc_no', $notin);
	    }	    
	    $this->db->group_by('article_no');				
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();	
	}

	public function jobcard_material_summary_new_from_reserved_quantity_menu($table,$data,$company,$jobcard_arr,$article_no,$match){

		$this->db->select('article_no,SUM(total_qty/100) total_demand_qty,SUM((total_qty/100)*( calculated_purchase_price/100))amount,(SUM((total_qty/100)*(calculated_purchase_price /100))/SUM(total_qty/100)) avg_rate');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->like($article_no,$match);

	    $this->db->where_in('manu_order_no',$jobcard_arr,FALSE);
	    $this->db->group_by('article_no');
				
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	
	}

	

	public function jobcard_material_total($table,$data,$company){

		$this->db->select('SUM(demand_qty) as demand_qty');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    //$this->db->group_by('manu_order_no,article_no');
				
		$query = $this->db->get();
		return $result=$query->result();
	
	}





	public function get_available_qty($article_no){		
		
		//$arr=explode("//",$article_no);
		if(!empty($article_no)){			
		//$conerp=mysqli_connect('192.168.0.9','root','password','neo3');;

		//$con=mysqli_connect('192.168.0.9','root','password','tw-erp');

		$conerp=mysqli_connect('192.168.0.50','root','password','neo');
		$con=mysqli_connect('192.168.0.9','root','password','tw-erp');

		$item_code=$article_no;
		$from='2019-05-01';
		$to= date("Y-m-d");
		$sql="SELECT A.main_group_id, A.article_group_id, A.sub_sub_grp_id, A.article_no FROM  article A, `article_name_info` ANI  where A.article_no=ANI.article_no and A.archive<>1 and A.company_id='000020' and ANI.company_id='000020' AND A.main_group_id!='' AND A.main_group_id !=  '0' AND A.article_no = '$item_code'";
		
		
		$result=mysqli_query($conerp,$sql);

		while($row=mysqli_fetch_array($result)){
			$article_sub_group=$row['sub_sub_grp_id'];
			$main_group=$row['main_group_id'];
			$article_group=$row['article_group_id'];
			$stock_closing="select item_code,date from stock_athal where item_code='$row[article_no]' and date<'$from' and status<>1 order by inventory_id desc limit 0,1";
			
			$check_closing_record=mysqli_query($con,$stock_closing);
			if(mysqli_num_rows($check_closing_record)==1){
				$total_opening_balance=0;
				$total_opening_balance_value=0;
				$total_stock_purchase_qty=0;
				$total_stock_purchase_value=0;
				$total_stock_return_qty=0;
				$total_stock_material_return_value=0;
				$total_stock_add_qty=0;
				$total_stock_add_value=0;
				$total_stock_available_qty=0;
				$total_stock_available_value=0;
				$total_stock_deduction_qty=0;
				$total_stock_deduction_value=0;
				$total_stock_closing_qty=0;
				$total_stock_closing_value=0;
				$rate=0;
				$n=1;
				$dates=array();
				$dates=$this->dateRange($from,$to);
				$dates_length=count($dates);
				for($i=0;$i<$dates_length;$i++){
					//Closing stock & Value
					$prev_date_closing=mysqli_fetch_array(mysqli_query($con,"select inventory_id,closing_stock,closing_stock_value,avg_rate,main_group,sub_group,second_sub_group,correction_value,correction_sign from stock_athal where item_code='$row[article_no]' and date<'$dates[$i]' and status<>1 order by inventory_id desc limit 0,1"));
														
					// Purchase Addition
					$stock_purchase=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as purchase_qty,sum(calculated_purchase_value) as purchase_value from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(0,2,3,4,7,8,9,10,13,14,19,23,24,30,31,33,36,38)"));
														
					$stock_purchase_qty=$this->get_value($stock_purchase['purchase_qty']);
					$stock_purchase_value=$this->get_value($stock_purchase['purchase_value']);
					if($prev_date_closing['correction_sign']=='+'){
						if($stock_purchase_value!='.'){
							$stock_purchase_value=$stock_purchase_value+$prev_date_closing['correction_value'];
						}
					}else if($prev_date_closing['correction_sign']=='-'){	
							if($stock_purchase_value!='.'){
								$stock_purchase_value=$stock_purchase_value-$prev_date_closing['correction_value'];
						}
					}else{
						$stock_purchase_value=$stock_purchase_value;
					} 
					//Material Return
					$stock_material_return=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as return_qty from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(39)"));
														
					$stock_material_return_qty=$this->get_value($stock_material_return['return_qty']);
					$stock_material_return_value=$stock_material_return_qty*$prev_date_closing['avg_rate'];
														
					//Stock Addition Qty
					$stock_add_qty=$stock_purchase_qty+$stock_material_return_qty;
					$stock_add_value=$stock_purchase_value+$stock_material_return_value;
					if($stock_add_qty==0){
						$stock_add_qty='-';
					}
					//Available Stock
					$stock_available_qty=$prev_date_closing['closing_stock']+$stock_add_qty;
					$stock_available_value=$stock_add_value+$prev_date_closing['closing_stock_value'];
														
					//Stock Deduction
					$stock_deduction=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as deduction_qty from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(1, 5, 6, 15, 18, 20, 25, 26, 29, 32, 34, 35, 37)"));
					
					if($stock_purchase_qty!='.' || $stock_material_return_qty!='.'){
						$rate=$stock_available_value/$stock_available_qty;
						$stock_deduction_qty=$this->get_value($stock_deduction['deduction_qty']);
						$stock_deduction_value=$this->get_value($stock_deduction['deduction_qty'])*$rate;
					}else{
						$stock_deduction_qty=$this->get_value($stock_deduction['deduction_qty']);
						$stock_deduction_value=$this->get_value($stock_deduction['deduction_qty'])*$prev_date_closing['avg_rate'];
					}
					//New rate
					if($stock_available_value!='0'){
							$new_rate=$stock_available_value/$stock_available_qty;
						}else{
							$new_rate=0;
						}
						//Closing STOCK
						$stock_closing_qty=$stock_available_qty-$stock_deduction_qty;
						$stock_closing_value=$stock_closing_qty*$new_rate;
						if($prev_date_closing['closing_stock']!=$stock_closing_qty || $stock_purchase_qty!='.' || $stock_material_return_qty !='.' || $stock_deduction_qty!='.' ){
							$query_select=mysqli_query($con,"select item_code,date from stock_athal where item_code='$row[article_no]' and date='$dates[$i]' and status<>1");
							$my_date = date("Y-m-d H:i:s");
							if(mysqli_num_rows($query_select)>0){
								$sql_update="UPDATE `stock_athal` SET `main_group`='$prev_date_closing[main_group]',`sub_group`='$prev_date_closing[sub_group]',`second_sub_group`='$prev_date_closing[second_sub_group]',`item_code`='$row[article_no]',`date`='$dates[$i]',`opening_stock`='$prev_date_closing[closing_stock]',`opening_value`='$prev_date_closing[closing_stock_value]',`stock_addition`='$stock_add_qty',`stock_addtion_value`='$stock_add_value',`purchase_stock`='$stock_purchase_qty',`purchase_stock_value`='$stock_purchase_value',`material_return_stock`='$stock_material_return_qty',`material_return_stock_value`='$stock_material_return_value',`available_stock`='$stock_available_qty',`available_stock_value`='$stock_available_value',`stock_deduction`='$stock_deduction_qty',`stock_deduction_value`='$stock_deduction_value',`closing_stock`='$stock_closing_qty',`closing_stock_value`='$stock_closing_value',`avg_rate`='$new_rate',`status`='0',time='$my_date' WHERE item_code='$row[article_no]' and date='$dates[$i]' and status<>1";
								mysqli_query($con,$sql_update);
								}else{
									$q='new entry';
									$sql="insert into stock_athal( `main_group`, `sub_group`, `second_sub_group`, `item_code`, `date`, `opening_stock`, `opening_value`, `stock_addition`, `stock_addtion_value`, `purchase_stock`, `purchase_stock_value`, `material_return_stock`, `material_return_stock_value`, `available_stock`, `available_stock_value`, `stock_deduction`, `stock_deduction_value`, `closing_stock`, `closing_stock_value`, `avg_rate`, `status`, `time`)values('$prev_date_closing[main_group]','$prev_date_closing[sub_group]','$prev_date_closing[second_sub_group]','$row[article_no]','$dates[$i]','$prev_date_closing[closing_stock]','$prev_date_closing[closing_stock_value]','$stock_add_qty','$stock_add_value','$stock_purchase_qty','$stock_purchase_value','$stock_material_return_qty','$stock_material_return_value','$stock_available_qty','$stock_available_value','$stock_deduction_qty','$stock_deduction_value','$stock_closing_qty','$stock_closing_value','$new_rate','0','$my_date')";
									mysqli_query($con,$sql);
								}
							}
							if($i==0){
								$total_opening_balance=$prev_date_closing['closing_stock'];
								$total_opening_balance_value=round($prev_date_closing['closing_stock_value'],2);
								}
								if($i==$dates_length-1){
									$last_closing_qty=$stock_closing_qty;
									$last_rate=$new_rate;
								}
								$total_stock_purchase_qty+=$stock_purchase_qty;
								$total_stock_purchase_value+=$stock_purchase_value;
								$total_stock_return_qty+=$stock_material_return_qty;
								$total_stock_material_return_value+=$stock_material_return_value;
								$total_stock_add_qty+=$stock_add_qty;
								$total_stock_add_value+=$stock_add_value;
								$total_stock_available_qty=$total_stock_add_qty+$total_opening_balance;
								$total_stock_available_value=$total_stock_add_value+$total_opening_balance_value;
								$total_stock_deduction_qty+=$stock_deduction_qty;
								$total_stock_deduction_value+=$stock_deduction_value;
								$total_stock_closing_qty=$total_opening_balance+$total_stock_add_qty-$total_stock_deduction_qty;
								$total_stock_closing_value=$total_opening_balance_value+$total_stock_add_value-$total_stock_deduction_value;
								$n++;
						}

						$last_rate=round($last_rate,2);
						return $last_closing_qty.'//'.$last_rate;
						//return array($last_closing_qty,$last_rate);
				}else{
						$sql_insert="INSERT INTO `stock_athal`( `main_group`, `sub_group`, `second_sub_group`,`item_code`, `date`, `opening_stock`, `opening_value`, `stock_addition`, `stock_addtion_value`, `available_stock`,`purchase_stock`,`purchase_stock_value`,  `material_return_stock`, `material_return_stock_value`,`available_stock_value`, `stock_deduction`, `stock_deduction_value`, `closing_stock`, `closing_stock_value`,`correction_value`, `avg_rate`, `status`,`correction_sign`) VALUES ('$main_group','$article_group','$article_sub_group','$row[article_no]','2014-04-01','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','')";
						$insert_query=mysqli_query($con,$sql_insert);
						$stock_closing="select item_code,date from stock_athal where item_code='$row[article_no]' and date<'$from' and status<>1 order by inventory_id desc limit 0,1";
						$check_closing_record=mysqli_query($con,$stock_closing);
						if(mysqli_num_rows($check_closing_record)==1){
							$total_opening_balance=0;
							$total_opening_balance_value=0;
							$total_stock_purchase_qty=0;
							$total_stock_purchase_value=0;
							$total_stock_return_qty=0;
							$total_stock_material_return_value=0;
							$total_stock_add_qty=0;
							$total_stock_add_value=0;
							$total_stock_available_qty=0;
							$total_stock_available_value=0;
							$total_stock_deduction_qty=0;
							$total_stock_deduction_value=0;
							$total_stock_closing_qty=0;
							$total_stock_closing_value=0;
							$rate=0;
							$n=1;
							$dates=array();
							$dates=$this->dateRange($from,$to);
							$dates_length=count($dates);
							for($i=0;$i<$dates_length;$i++){
								//Closing stock & Value
								$prev_date_closing=mysqli_fetch_array(mysqli_query($con,"select inventory_id,closing_stock,closing_stock_value,avg_rate,main_group,sub_group,second_sub_group,correction_value,correction_sign from stock_athal where item_code='$row[article_no]' and date<'$dates[$i]' and status<>1 order by inventory_id desc limit 0,1"));
																				
								// Purchase Addition
								$stock_purchase=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as purchase_qty,sum(calculated_purchase_value) as purchase_value from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(0,2,3,4,7,8,9,10,13,14,19,23,24,30,31,33,36,38)"));
																				
								$stock_purchase_qty=$this->get_value($stock_purchase['purchase_qty']);
								$stock_purchase_value=$this->get_value($stock_purchase['purchase_value']);
								if($prev_date_closing['correction_sign']=='+'){
									if($stock_purchase_value!='.'){
										$stock_purchase_value=$stock_purchase_value+$prev_date_closing['correction_value'];
									}
								}else if($prev_date_closing['correction_sign']=='-'){	
										if($stock_purchase_value!='.'){
											$stock_purchase_value=$stock_purchase_value-$prev_date_closing['correction_value'];
									}
								}else{
									$stock_purchase_value=$stock_purchase_value;
									} 
									//Material Return
									$stock_material_return=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as return_qty from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(39)"));
																				
									$stock_material_return_qty=$this->get_value($stock_material_return['return_qty']);
									$stock_material_return_value=$stock_material_return_qty*$prev_date_closing['avg_rate'];
																				
									//Stock Addition Qty
									$stock_add_qty=$stock_purchase_qty+$stock_material_return_qty;
									$stock_add_value=$stock_purchase_value+$stock_material_return_value;
									if($stock_add_qty==0){
										$stock_add_qty='-';
										}
										//Available Stock
										$stock_available_qty=$prev_date_closing['closing_stock']+$stock_add_qty;
										$stock_available_value=$stock_add_value+$prev_date_closing['closing_stock_value'];
										
										//Stock Deduction
										$stock_deduction=mysqli_fetch_array(mysqli_query($conerp,"select sum(ah_qty) as deduction_qty from article_history where date='$dates[$i]' and article_no='$row[article_no]' and sales_purchase_flag IN(1, 5, 6, 15, 18, 20, 25, 26, 29, 32, 34, 35, 37)"));
																				
										if($stock_purchase_qty!='.' || $stock_material_return_qty!='.'){
											$rate=$stock_available_value/	$stock_available_qty;
											$stock_deduction_qty=$this->get_value($stock_deduction['deduction_qty']);
											$stock_deduction_value=$this->get_value($stock_deduction['deduction_qty'])*$rate;
											}else{
												$stock_deduction_qty=$this->get_value($stock_deduction['deduction_qty']);
												$stock_deduction_value=$this->get_value($stock_deduction['deduction_qty'])*$prev_date_closing['avg_rate'];
											}
											//New rate
											if($stock_available_value!='0'){
												$new_rate=$stock_available_value/$stock_available_qty;
												}else{
													$new_rate=0;
												}
												//Closing STOCK
												$stock_closing_qty=$stock_available_qty-$stock_deduction_qty;
												$stock_closing_value=$stock_closing_qty*$new_rate;
												if($prev_date_closing['closing_stock']!=$stock_closing_qty || $stock_purchase_qty!='.' || $stock_material_return_qty !='.' || $stock_deduction_qty!='.' ){
													$query_select=mysqli_query($con,"select item_code,date from stock where item_code='$row[article_no]' and date='$dates[$i]' and status<>1");
													$my_date = date("Y-m-d H:i:s");
													if(mysqli_num_rows($query_select)>0){
														$sql_update="UPDATE `stock_athal` SET `main_group`='$prev_date_closing[main_group]',`sub_group`='$prev_date_closing[sub_group]',`second_sub_group`='$prev_date_closing[second_sub_group]',`item_code`='$row[article_no]',`date`='$dates[$i]',`opening_stock`='$prev_date_closing[closing_stock]',`opening_value`='$prev_date_closing[closing_stock_value]',`stock_addition`='$stock_add_qty',`stock_addtion_value`='$stock_add_value',`purchase_stock`='$stock_purchase_qty',`purchase_stock_value`='$stock_purchase_value',`material_return_stock`='$stock_material_return_qty',`material_return_stock_value`='$stock_material_return_value',`available_stock`='$stock_available_qty',`available_stock_value`='$stock_available_value',`stock_deduction`='$stock_deduction_qty',`stock_deduction_value`='$stock_deduction_value',`closing_stock`='$stock_closing_qty',`closing_stock_value`='$stock_closing_value',`avg_rate`='$new_rate',`status`='0',time='$my_date' WHERE item_code='$row[article_no]' and date='$dates[$i]' and status<>1";
														mysqli_query($con,$sql_update);
														}else{
															$q='new entry';
															$sql="insert into stock_athal( `main_group`, `sub_group`, `second_sub_group`, `item_code`, `date`, `opening_stock`, `opening_value`, `stock_addition`, `stock_addtion_value`, `purchase_stock`, `purchase_stock_value`, `material_return_stock`, `material_return_stock_value`, `available_stock`, `available_stock_value`, `stock_deduction`, `stock_deduction_value`, `closing_stock`, `closing_stock_value`, `avg_rate`, `status`, `time`)values('$prev_date_closing[main_group]','$prev_date_closing[sub_group]','$prev_date_closing[second_sub_group]','$row[article_no]','$dates[$i]','$prev_date_closing[closing_stock]','$prev_date_closing[closing_stock_value]','$stock_add_qty','$stock_add_value','$stock_purchase_qty','$stock_purchase_value','$stock_material_return_qty','$stock_material_return_value','$stock_available_qty','$stock_available_value','$stock_deduction_qty','$stock_deduction_value','$stock_closing_qty','$stock_closing_value','$new_rate','0','$my_date')";
															mysqli_query($con,$sql);
															}
														}
														if($i==0){
															$total_opening_balance=$prev_date_closing['closing_stock'];
															$total_opening_balance_value=round($prev_date_closing['closing_stock_value'],2);
														}
														if($i==$dates_length-1){
															$last_closing_qty=$stock_closing_qty;
															$last_rate=$new_rate;
															echo $last_closing_qty;
														}
														$total_stock_purchase_qty+=$stock_purchase_qty;
														$total_stock_purchase_value+=$stock_purchase_value;
														$total_stock_return_qty+=$stock_material_return_qty;
														$total_stock_material_return_value+=$stock_material_return_value;
														$total_stock_add_qty+=$stock_add_qty;
														$total_stock_add_value+=$stock_add_value;
														$total_stock_available_qty=$total_stock_add_qty+$total_opening_balance;
														$total_stock_available_value=$total_stock_add_value+$total_opening_balance_value;
														$total_stock_deduction_qty+=$stock_deduction_qty;
														$total_stock_deduction_value+=$stock_deduction_value;
														$total_stock_closing_qty=$total_opening_balance+$total_stock_add_qty-$total_stock_deduction_qty;
														$total_stock_closing_value=$total_opening_balance_value+$total_stock_add_value-$total_stock_deduction_value;
														$n++;
														
														
								}
								$last_rate=round($last_rate,2);
							return $last_closing_qty.'//'.$last_rate;
							//return array($last_closing_qty,$last_rate);
						}
									
				}
	}

			
			
			//include('../fun-article-available-qty.php');
			//$result=get_available_qty($conerp,$arr[1]);
			//echo $arr[1];
			//echo $result[0];
			
		}				
	

	}





}

?>
