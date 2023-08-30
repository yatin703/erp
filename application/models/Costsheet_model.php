<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Costsheet_model extends CI_Model {

//Search Reuslt()
	public function active_record_search($table,$data,$from,$to,$company,$customer_category){
		$inv_type=array('1','2','3','8','11');
		$this->db->select(''.$table.'.*,address_master.name1,address_master.isdn_local,user_master.login_name,property_master.lang_property_name,ar_invoice_master_lang.lang_cust_po_info');
		$this->db->from($table);
		$this->db->join('ar_invoice_master_lang',''.$table.'.ar_invoice_no=ar_invoice_master_lang.ar_invoice_no','LEFT');
		//$this->db->join('ar_invoice_details',''.$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no','LEFT');
		$this->db->join('address_master',''.$table.'.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('address_details',$table.'.customer_no=address_details.adr_company_id','LEFT');
		$this->db->join('property_master','address_details.property_id=property_master.property_id','LEFT');
		$this->db->join('user_master',''.$table.'.user_id=user_master.user_id','LEFT');

		if(!empty($customer_category)){

		$this->db->join('ar_invoice_details',''.$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no','LEFT');
		$this->db->join('article_name_info','ar_invoice_details.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('address_category_master',''.$table.'.customer_category=address_category_master.adr_category_id','LEFT');
		}
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where('property_master.language_id','1');
		$this->db->where(''.$table.'.archive!=', '1');
		$this->db->where(''.$table.'.cancel_invoice!=', '1');
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);

	    if(!empty($customer_category)){
	    	$this->db->where('article_name_info.adr_category_id',$customer_category);
	    	$this->db->where('article_name_info.company_id',$company);
	    }
		$this->db->where_in(''.$table.'.inv_type', $inv_type);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
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

	public function active_details_records($table,$data,$print,$company,$list_arr){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($print)){
		$this->db->join('lacquer_types_master',''.$table.'.print_type=lacquer_types_master.lacquer_type','LEFT');
		}
		$this->db->where(''.$table.'.company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->where('ar_invoice_details.ref_ord_no<>','');
	    if(!empty($print)){
	    	$this->db->where('lacquer_types_master.printing_group',$print);
	    }
	    
	    if(!empty($list_arr)){
	    	$this->db->where_in(''.$table.'.order_flag', $list_arr,false);
	    }

		$query = $this->db->get();
		return $result=$query->result();
		
	}

//Tax Header
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search_costsheet($table,$data,$from,$to,$length_from,$length_to,$print,$customer_category,$status,$sort_by,$company,$filter_by){
		$this->db->select($table.'.*');
		$this->db->from($table);
		//$this->db->join('address_category_master',$table.'.adr_category_id=address_category_master.adr_category_id','LEFT');
		$this->db->join('address_details',$table.'.customer_id=address_details.adr_company_id','LEFT');
		if(!empty($print)){
		$this->db->join('lacquer_types_master',''.$table.'.print_type=lacquer_types_master.lacquer_type','LEFT');
		}
		if(!empty($customer_category)){
		$this->db->join('article_name_info',''.$table.'.article_no=article_name_info.article_no','LEFT');
		//$this->db->join('address_category_master',''.$table.'.customer_category=address_category_master.adr_category_id','LEFT');
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		
		if(!empty($print)){
	    	$this->db->where('lacquer_types_master.printing_group',$print);
	    }
	    if(!empty($customer_category)){
	    	$this->db->where('article_name_info.adr_category_id',$customer_category);
	    	$this->db->where('article_name_info.company_id',$company);
	    }
	    if(!empty($status)){
	    	$this->db->like(''.$table.'.status', $status);
	    }
	    if(!empty($sort_by)){
	    	$this->db->where(''.$table.'.'.$sort_by.'');
	    }
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		if(!empty($length_from) && !empty($length_to)){
	 		$this->db->where('length>=',$length_from);
	 		$this->db->where('length<=',$length_to);

	 }

		
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if(!empty($filter_by)){
	 			$this->db->order_by('CAST('.$table.'.'.$filter_by.' as unsigned)','asc');
	 		}
		$this->db->order_by(''.$table.'.invoice_date','desc');

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	public function select_contriubution($table,$from,$to,$data){
		$this->db->select('*');
		$this->db->from($table);

		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);

		$this->db->where($table.'.archive<>','1');
		if(!empty($data)){
			foreach($data as $key => $value) {
			$this->db->where($key,$value);
			}
		}
		

		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_by_product($table,$from,$to,$data,$customer_category,$company,$print){
		$this->db->select('ar_invoice_details.article_no, SUM(ar_invoice_details.arid_qty/100) total_qty, sum(IF(for_export=1,(ar_invoice_details.arid_qty/100)*ar_invoice_details.calc_sell_price*(exchange_rate/100),(ar_invoice_details.arid_qty/100)*(ar_invoice_details.selling_price/100))) amount,ar_invoice_details.sleeve_dia,ar_invoice_details.sleeve_length,ar_invoice_details.print_type,ar_invoice_details.layer_no,ar_invoice_details.sleeve_mb_1,article_name_info.adr_category_id');
		$this->db->from($table);
		$this->db->join('ar_invoice_details',''.$table.'.ar_invoice_no=ar_invoice_details.ar_invoice_no','INNER');
		
		$this->db->join('article_name_info','ar_invoice_details.article_no=article_name_info.article_no','LEFT');

		if(!empty($print)){
		$this->db->join('lacquer_types_master','ar_invoice_details.print_type=lacquer_types_master.lacquer_type','LEFT');
		}

		$this->db->where($table.'.company_id','000020');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.cancel_invoice','0');
		$this->db->where('article_name_info.company_id','000020');
		$this->db->where('article_name_info.language_id','1');	


		if(!empty($print)){
	    	$this->db->where('lacquer_types_master.printing_group',$print);
	    }

		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);		

		if(!empty($data)){
			foreach($data as $key => $value) {
			$this->db->where($key,$value);
			}
		}

		if(!empty($customer_category)){
	    	$this->db->where('article_name_info.adr_category_id',$customer_category);
	    	$this->db->where('article_name_info.company_id',$company);
	    }

		$this->db->group_by('ar_invoice_details.article_no');
		$this->db->order_by('total_qty desc');
		

		$query = $this->db->get();

		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function get_ink_cost($table,$company,$data,$from,$to){
		$this->db->select('ink_id,SUM(consumption_value)consumption_value,SUM(consumption_quantity)consumption_quantity,SUM(consumption_value)/SUM(consumption_quantity)avg_cost_per_kg');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->where($key,$value);
			}			
		}		
		$this->db->where(''.$table.'.apply_from_date >=', $from);
		$this->db->where(''.$table.'.apply_to_date <=', $to);

		$this->db->group_by('ink_id');
		$this->db->order_by('ink_id');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function get_consumables_cost($table,$company,$data,$from,$to){
		$this->db->select('consumable_category_id,SUM(consumption_value)consumption_value,SUM(sale_of_tubes) sale_of_tubes,SUM(consumption_value)/SUM(sale_of_tubes) avg_cost_per_tube');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->where($key,$value);
			}			
		}		
		$this->db->where(''.$table.'.apply_from_date >=', $from);
		$this->db->where(''.$table.'.apply_to_date <=', $to);

		$this->db->group_by('consumable_category_id');
		$this->db->order_by('consumable_category_id');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function get_packing_cost($table,$company,$data,$from,$to){
		$this->db->select('packing_category_id,SUM(consumption_value)consumption_value,SUM(sale_of_tubes)sale_of_tubes,SUM(consumption_value)/SUM(sale_of_tubes) avg_cost_per_tube,packing_material');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->where($key,$value);
			}			
		}		
		$this->db->where(''.$table.'.apply_from_date >=', $from);
		$this->db->where(''.$table.'.apply_to_date <=', $to);

		$this->db->group_by('packing_category_id');
		$this->db->order_by('packing_category_id');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function get_stores_and_sapres_cost($table,$company,$data,$from,$to){
		$this->db->select('stores_and_spares_category_id,SUM(consumption_value)consumption_value,SUM(sale_of_tubes)sale_of_tubes,SUM(consumption_value)/SUM(sale_of_tubes)avg_cost_per_tube,stores_and_spares');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->where($key,$value);
			}			
		}		
		$this->db->where(''.$table.'.apply_from_date >=', $from);
		$this->db->where(''.$table.'.apply_to_date <=', $to);

		$this->db->group_by('stores_and_spares_category_id');
		$this->db->order_by('stores_and_spares_category_id');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
		
	}

	public function get_freight_cost($table,$data,$company,$from,$to){

		$this->db->select('customer_no,sleeve_id,AVG(cost_per_tube)avg_cost_per_tube');
		$this->db->from($table);		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where(''.$table.'.apply_from_date >=', $from);
		$this->db->where(''.$table.'.apply_to_date <=', $to);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }
	    $this->db->group_by('customer_no,sleeve_id');
	    $this->db->order_by('sleeve_id');				
		$query = $this->db->get();
		return $result=$query->result();
	
	}

	public function active_record_count_where_pkey($table,$company,$pkey,$edit,$from,$to){
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->where(''.$table.'.invoice_date >=', $from);
		$this->db->where(''.$table.'.invoice_date <=', $to);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
		
	}


	public function select_additional($table,$company,$data,$in,$group_by,$order_by){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

	   $this->db->where_not_in(''.$table.'.work_proc_no', $in);


	    if(!empty($group_by)){
				$this->db->group_by($group_by);
			
	    }

	    if(!empty($order_by)){
				$this->db->order_by('CAST('.$table.'.'.$order_by.' as unsigned)','asc');
			
	    }	    

		$query = $this->db->get();
		return $query->result();
	}



	function get_material_qty($bom_no,$bom_version_no,$qty,$item_group_material){

	$this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('specification_model');	

    $pi=3.14;
    $rejection=5;
    $total_rm_qty=0;

    $data=array('bom_no'=>$bom_no,
                'bom_version_no'=>$bom_version_no
    );
    $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach($data['bom_details'] as $bom_details_row){
      $sleeve_code=$bom_details_row->sleeve_code;
      $shoulder_code=$bom_details_row->shoulder_code;
      $label_code=$bom_details_row->label_code;
      $cap_code=$bom_details_row->cap_code;
      $for_export=$bom_details_row->for_export;
    } 

    if(substr($sleeve_code,0,3)=="SLV"){

      $data['sleeve_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

      foreach($data['sleeve_specs'] as $sleeve_specs){

        $sleeve_specss['spec_id']=$sleeve_specs->spec_id;
        $sleeve_specss['spec_version_no']=$sleeve_specs->spec_version_no;

        $sleeve_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
        foreach($sleeve_specs_master_result as $sleeve_specs_master_result_row){
          $layer_arr=explode("|", $sleeve_specs_master_result_row->dyn_qty_present);
          $layer_no=substr($layer_arr[1],0,1);              

        }

        $sleeve_specs_details_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
        //print_r($sleeve_specs_details_result);
         
        foreach($sleeve_specs_details_result as $sleeve_specs_details_row){
          $dia=$sleeve_specs_details_row->SLEEVE_DIA;
          $length=$sleeve_specs_details_row->SLEEVE_LENGTH+3;
          $sleeve_length=$sleeve_specs_details_row->SLEEVE_LENGTH;
        }

        for($i=1;$i<=$layer_no;$i++){
          //Guage----------------
          $guage=0;         

          $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$i,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');

          //echo $this->db->last_query();
          //echo "<br/>";

          foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
            
            $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
            //echo'</br>';
            $sleeve_weight="";
            $density="";

            if($layer_no==5 && $i==3){
              $density=1.18;
              
            }else{
              $density=0.92;
            }

            $dia1=substr($dia,0,2);

            //$sleeve_weight=((((($dia1*$length*$gauge*$pi*$density)/1000000)*$rejection/100)+(($dia1*$length*$gauge*$pi*$density)/1000000))/1000)*$qty;
            $weight=(($dia1*$length*$gauge*$pi*$density)/1000000);
            $rejection_weight=$weight*(5/100);

            $total_weight=(($weight+$rejection_weight)*$qty)/1000;
                        
            $sleeve_weight=$total_weight/100;
            //echo '</br>';

            $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge_new('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','mat_article_no<>','','layer_no',$i,'item_group_material',$item_group_material,'srd_id','asc','layer_no','asc');

            //echo $this->db->last_query();
           // echo "<br/>";  
                        
              foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                if(!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)){
                  
                  $specification_sleeve_details_row->mat_article_no."-".$specification_sleeve_details_row->mat_info;

                 
                  $rm_qty=round($sleeve_weight*$specification_sleeve_details_row->mat_info,2);

                  //echo '</br>';

                  $total_rm_qty+=$rm_qty;
                }

              }




          } // foreach specsheet_details


        }// Layer for

      }//foreach sleeve_specs

    }//if SLV


            
    return $total_rm_qty;

  }//function get_material



	function get_shoulder_material_qty($bom_no,$bom_version_no,$qty,$item_group_material){

	$this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('specification_model');	

    $pi=3.14;
    $rejection=5;
    $total_rm_qty=0;

    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

    $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach($data['bom_details'] as $bom_details_row){
      $sleeve_code=$bom_details_row->sleeve_code;
      $shoulder_code=$bom_details_row->shoulder_code;
      $label_code=$bom_details_row->label_code;
      $cap_code=$bom_details_row->cap_code;
      $for_export=$bom_details_row->for_export;
    } 

    if(substr($sleeve_code,0,3)=="SLV"){

      $data['sleeve_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

      foreach($data['sleeve_specs'] as $sleeve_specs){

        $sleeve_specss['spec_id']=$sleeve_specs->spec_id;
        $sleeve_specss['spec_version_no']=$sleeve_specs->spec_version_no;


        $sleeve_specs_details_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
        //print_r($sleeve_specs_details_result);
         
        foreach($sleeve_specs_details_result as $sleeve_specs_details_row){
          $dia=$sleeve_specs_details_row->SLEEVE_DIA;
          $length=$sleeve_specs_details_row->SLEEVE_LENGTH+3;
          $sleeve_length=$sleeve_specs_details_row->SLEEVE_LENGTH;
        }
		// Layer for

      }//foreach sleeve_specs

    }//if SLV


    if(!empty($shoulder_code)){
        
        $data['shoulder_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
                  foreach($data['shoulder_specs'] as $shoulder_specs){
                    $shoulder_specss['spec_id']=$shoulder_specs->spec_id;
                    $shoulder_specss['spec_version_no']=$shoulder_specs->spec_version_no;

                    $data=array('sleeve_diameter'=>$dia);
                    $data['sleeve_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],$data);
                    foreach($data['sleeve_details'] as $sleeve_details_row){
                      $sleeve_id=$sleeve_details_row->sleeve_id;
                    }

                    $shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specss);
                      if($shoulder_specs_result){
                        foreach($shoulder_specs_result as $shoulder_specs_row){
                          $shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
                          $shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
                          $shoulder_foil_tag=$shoulder_specs_row->SHOULDER_FOIL_TAG;                                    

                        }
                      }


                    $data=array('shoulder_type'=>$shoulder_type);
                    $data['shoulder_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],$data);
                    
                    foreach($data['shoulder_details'] as $shoulder_details_row){
                      $shoulder_id=$shoulder_details_row->shld_type_id;
                    }


                    $data=array('shoulder_orifice'=>$shoulder_orifice);
                    $data['shoulder_orifice_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],$data);
                    if($data['shoulder_orifice_details']==FALSE){
                      $orifice_id='';
                    }else{
                      foreach($data['shoulder_orifice_details'] as $shoulder_orifice_details_row){
                      $orifice_id=$shoulder_orifice_details_row->orifice_id;
                      }
                    }
                    


                    
                    $data=array('sleeve_id'=>$sleeve_id,
                      'shld_type_id'=>$shoulder_id,
                      'shld_orifice_id'=>$orifice_id);

                    $data['shoulder_weight_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$data);
                    

                    foreach($data['shoulder_weight_details'] as $shoulder_weight_details_row){
                     $shoulder_weight=$this->common_model->read_number($shoulder_weight_details_row->shld_weight,$this->session->userdata['logged_in']['company_id']);
                    }
                    
                    $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','2');
                    
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                      $shoulder_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    } 
                    $shoulder_weight=(($shoulder_weight+(($shoulder_weight/100)*$shoulder_rejection))/1000)*$qty;
                    

                   $shoulder_weight=$shoulder_weight/100;



                    $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge_new('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$shoulder_specs->spec_id,'specification_sheet_details.spec_version_no',$shoulder_specs->spec_version_no,'item_group_id','4','material','1','layer_no','1','item_group_material',$item_group_material,'srd_id','asc','layer_no','asc');

                    //echo $this->db->last_query();
         
                    
                    foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){

                      if(!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)){
                        $specification_shoulder_details_row->mat_article_no." ".rtrim($specification_shoulder_details_row->mat_info,"%");

                        $rm_qty=round($shoulder_weight*$specification_shoulder_details_row->mat_info,2);
                                          

                        $total_rm_qty+=$rm_qty;
                      }
                    }

                  }

                }
            
    return $total_rm_qty;

  }

  	function get_time($sec){

	  	$hours=0;
	  	$min=0;
	  	
		$min=$sec/60;
		$sec=$sec%60;
		$hours=floor($min/60);
		$min=$min%60;

		return $hours.' Hours '.$min.' Minuts '.$sec.' Seconds';  	

  	}


  	public function contribution_print_type_wise($from_date,$to_date){
  		$sql="select A.costsheet_year,A.costsheet_month,A.costsheet_month_no,A.printing_group,
  			sum(A.SCREEN_FLEXO_QTY) as SCREEN_FLEXO_QUANTITY,
  			sum(A.SCREEN_FLEXO_SALE)as SCREEN_FLEXO_SALE_VALUE,  			
  			sum(A.SCREEN_FLEXO_CONTR)as SCREEN_FLEXO_CONTR_VALUE,
  			sum(A.OFFSET_QTY) as OFFSET_QUANTITY,  			
  			sum(A.OFFSET_SALE)as OFFSET_SALE_VALUE,
  			sum(A.OFFSET_CONTR) as OFFSET_CONTR_VALUE,
  			sum(A.LABEL_QTY) as LABEL_QUANTITY,
  			sum(A.LABEL_SALE)as LABEL_SALE_VALUE,
  			sum(A.LABEL_CONTR) as LABEL_CONTR_VALUE,
  			sum(A.SPRING_QTY) as SPRING_QUANTITY,  			
  			sum(A.SPRING_SALE) as SPRING_SALE_VALUE,
  			sum(A.SPRING_CONTR) as SPRING_CONTR_VALUE
  			from (
  			SELECT 
				YEAR(cm.invoice_date) as costsheet_year,
				MONTHNAME(cm.invoice_date) as costsheet_month,
				MONTH(cm.invoice_date) as costsheet_month_no,
				cm.invoice_no,lm.printing_group,
				if(lm.printing_group='SCREEN+FLEXO',dispatch_quantity,0) as SCREEN_FLEXO_QTY,
				if(lm.printing_group='SCREEN+FLEXO',(cm.dispatch_quantity*cm.unit_rate),0) as SCREEN_FLEXO_SALE,
				if(lm.printing_group='SCREEN+FLEXO',total_costing,0) as SCREEN_FLEXO_COST,
				if(lm.printing_group='SCREEN+FLEXO',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0) as SCREEN_FLEXO_CONTR, 

				if(lm.printing_group='OFFSET',dispatch_quantity,0) as OFFSET_QTY,
				if(lm.printing_group='OFFSET',(cm.dispatch_quantity*cm.unit_rate),0) as OFFSET_SALE,
				if(lm.printing_group='OFFSET',total_costing,0) as OFFSET_COST,
				if(lm.printing_group='OFFSET',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0) as OFFSET_CONTR, 

				if(lm.printing_group='LABEL',dispatch_quantity,0) as LABEL_QTY,
				if(lm.printing_group='LABEL',(cm.dispatch_quantity*cm.unit_rate),0) as LABEL_SALE,
				if(lm.printing_group='LABEL',total_costing,0) as LABEL_COST,
				if(lm.printing_group='LABEL',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0) as LABEL_CONTR, 

				if(lm.printing_group='FLEXO+DIGITAL+FLEXO',dispatch_quantity,0) as SPRING_QTY,
				if(lm.printing_group='FLEXO+DIGITAL+FLEXO',(cm.dispatch_quantity*cm.unit_rate),0) as SPRING_SALE,
				if(lm.printing_group='FLEXO+DIGITAL+FLEXO',total_costing,0) as SPRING_COST,
				if(lm.printing_group='FLEXO+DIGITAL+FLEXO',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0) as SPRING_CONTR


				FROM `costsheet_master` as cm 
				INNER JOIN lacquer_types_master as lm 
				ON cm.print_type=lm.lacquer_type 
				where cm.invoice_date BETWEEN '$from_date' AND '$to_date') as A 
				group by A.costsheet_year,A.costsheet_month 
				order by costsheet_year,costsheet_month_no asc";
  		$query=$this->db->query($sql);
			return $result=$query->result();
  	}


  	public function contribution_by_small_dia_with_print_type($month,$year){

  		$from_date = date('Y-m-d', strtotime(''.$month.' 01, '.$year.''));

  		$to_date = date('Y-m-t', strtotime(''.$month.', '.$year.''));


  		$sql="SELECT A.sales_year,A.sales_month,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.SCREEN_FLEXO,0))AS SCREEN_FLEXO_SMALL_DIA,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.SCREEN_FLEXO_VALUE,0))AS SCREEN_FLEXO_SMALL_DIA_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.SCREEN_FLEXO_CONTRIBUTION_VALUE,0))AS SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM',A.OFFSET,0))AS OFFSET_SMALL_DIA,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.OFFSET_VALUE,0))AS OFFSET_SMALL_DIA_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.OFFSET_CONTRIBUTION_VALUE,0))AS OFFSET_SMALL_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM',A.LABEL,0))AS LABEL_SMALL_DIA,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.LABEL_VALUE,0))AS LABEL_SMALL_DIA_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM', A.LABEL_CONTRIBUTION_VALUE,0))AS LABEL_SMALL_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM',A.DIGITAL,0))AS SPRING_SMALL_DIA,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM',A.DIGITAL_VALUE,0))AS SPRING_SMALL_DIA_VALUE,

				SUM(if(A.sleeve_dia='19 MM' OR A.sleeve_dia='22 MM' OR A.sleeve_dia='25 MM' OR A.sleeve_dia='30 MM',A.DIGITAL_CONTRIBUTION_VALUE,0))AS SPRING_SMALL_DIA_CONTRIBUTION_VALUE

				from (SELECT 
                MONTH(costsheet_master.invoice_date) as month_no, 
                YEAR(costsheet_master.invoice_date) as sales_year, 
                LEFT(MONTHNAME(costsheet_master.invoice_date),3) as sales_month,
                costsheet_master.dia as sleeve_dia,

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity,0))AS SCREEN_FLEXO,

                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity,0 ))AS OFFSET,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity,0 ))AS LABEL,


                SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity,0 ))AS DIGITAL,
                

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity*unit_rate,0))AS SCREEN_FLEXO_VALUE,

                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity*unit_rate,0 ))AS OFFSET_VALUE,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity*unit_rate,0 ))AS LABEL_VALUE,


                SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity*unit_rate,0 ))AS DIGITAL_VALUE,

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0))AS SCREEN_FLEXO_CONTRIBUTION_VALUE,


                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS OFFSET_CONTRIBUTION_VALUE,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS LABEL_CONTRIBUTION_VALUE,

                 SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS DIGITAL_CONTRIBUTION_VALUE

                 from costsheet_master
                 where costsheet_master.invoice_date between '$from_date' AND '$to_date'
                 GROUP BY MONTH(costsheet_master.invoice_date),
                 YEAR(costsheet_master.invoice_date),
                 costsheet_master.dia) AS A GROUP BY A.sales_year,A.sales_month";

						$query=$this->db->query($sql);
						return $result=$query->result();


  	}

  	public function contribution_by_big_dia_with_print_type($month,$year){

  		$from_date = date('Y-m-d', strtotime(''.$month.' 01, '.$year.''));

  		$to_date = date('Y-m-t', strtotime(''.$month.', '.$year.''));


  		$sql="SELECT A.sales_year,A.sales_month,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.SCREEN_FLEXO,0))AS SCREEN_FLEXO_BIG_DIA,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.SCREEN_FLEXO_VALUE,0))AS SCREEN_FLEXO_BIG_DIA_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.SCREEN_FLEXO_CONTRIBUTION_VALUE,0))AS SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' ,A.OFFSET,0))AS OFFSET_BIG_DIA,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.OFFSET_VALUE,0))AS OFFSET_BIG_DIA_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.OFFSET_CONTRIBUTION_VALUE,0))AS OFFSET_BIG_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' ,A.LABEL,0))AS LABEL_BIG_DIA,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.LABEL_VALUE,0))AS LABEL_BIG_DIA_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' , A.LABEL_CONTRIBUTION_VALUE,0))AS LABEL_BIG_DIA_CONTRIBUTION_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' ,A.DIGITAL,0))AS SPRING_BIG_DIA,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' ,A.DIGITAL_VALUE,0))AS SPRING_BIG_DIA_VALUE,

				SUM(if(A.sleeve_dia='35 MM' OR A.sleeve_dia='40 MM' OR A.sleeve_dia='50 MM' ,A.DIGITAL_CONTRIBUTION_VALUE,0))AS SPRING_BIG_DIA_CONTRIBUTION_VALUE

				from (SELECT 
                MONTH(costsheet_master.invoice_date) as month_no, 
                YEAR(costsheet_master.invoice_date) as sales_year, 
                LEFT(MONTHNAME(costsheet_master.invoice_date),3) as sales_month,
                costsheet_master.dia as sleeve_dia,

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity,0))AS SCREEN_FLEXO,

                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity,0 ))AS OFFSET,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity,0 ))AS LABEL,


                SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity,0 ))AS DIGITAL,
                

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity*unit_rate,0))AS SCREEN_FLEXO_VALUE,

                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity*unit_rate,0 ))AS OFFSET_VALUE,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity*unit_rate,0 ))AS LABEL_VALUE,


                SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity*unit_rate,0 ))AS DIGITAL_VALUE,

                SUM(if(costsheet_master.print_type='SCREEN' 
                 OR costsheet_master.print_type='FLEXO+SCREEN' 
                 OR costsheet_master.print_type='SCREEN+FLEXO' 
                 OR costsheet_master.print_type='FLEXO' 
                 OR costsheet_master.print_type='SCREEN+UPTO NECK' 
                 OR costsheet_master.print_type='OFFSET SCREEN' 
                 OR costsheet_master.print_type='SCREEN + HOTFOIL' 
                 OR costsheet_master.print_type='Flexo +screen'  
                 OR costsheet_master.print_type='FLEXO SCREEN',costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0))AS SCREEN_FLEXO_CONTRIBUTION_VALUE,


                 SUM(if(costsheet_master.print_type='OFFSET' OR costsheet_master.print_type='PLAIN' , costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS OFFSET_CONTRIBUTION_VALUE,

                 SUM(if(costsheet_master.print_type='LABEL OFFSET' OR costsheet_master.print_type='SCREEN + LABEL' OR costsheet_master.print_type='SCREEN UP TO NECK+LABEL' OR costsheet_master.print_type='LABELING' OR costsheet_master.print_type='LABEL' OR costsheet_master.print_type='OFFSET+LABEL' OR costsheet_master.print_type='LABEL + OFFSET', costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS LABEL_CONTRIBUTION_VALUE,

                 SUM(if(costsheet_master.print_type='FLEXO+DIGITAL+FLEXO' OR costsheet_master.print_type='FLEXO+DIGITAL' OR costsheet_master.print_type='DIGITAL+FLEXO', costsheet_master.dispatch_quantity*unit_rate-costsheet_master.total_costing,0 ))AS DIGITAL_CONTRIBUTION_VALUE

                 from costsheet_master
                 where costsheet_master.invoice_date between '$from_date' AND '$to_date'
                 GROUP BY MONTH(costsheet_master.invoice_date),
                 YEAR(costsheet_master.invoice_date),
                 costsheet_master.dia) AS A GROUP BY A.sales_year,A.sales_month";

						$query=$this->db->query($sql);
						return $result=$query->result();


  	}

  	public function contribution_by_customer($from_date,$to_date){
  		$sql="SELECT 	acm.category_name as customer,
				SUM(dispatch_quantity) as sales_quantity,
				SUM(if(cm.print_type='SCREEN' OR cm.print_type='FLEXO+SCREEN' OR cm.print_type='SCREEN+FLEXO' OR cm.print_type='FLEXO' OR cm.print_type='SCREEN+UPTO NECK' OR cm.print_type='OFFSET SCREEN' OR cm.print_type='SCREEN + HOTFOIL' OR cm.print_type='Flexo +screen'  OR cm.print_type='FLEXO SCREEN',dispatch_quantity,0)) as SCREEN_FLEXO_QUANTITY,
				SUM(if(cm.print_type='SCREEN' OR cm.print_type='FLEXO+SCREEN' OR cm.print_type='SCREEN+FLEXO' OR cm.print_type='FLEXO' OR cm.print_type='SCREEN+UPTO NECK' OR cm.print_type='OFFSET SCREEN' OR cm.print_type='SCREEN + HOTFOIL' OR cm.print_type='Flexo +screen'  OR cm.print_type='FLEXO SCREEN',(cm.dispatch_quantity*cm.unit_rate),0)) as SCREEN_FLEXO_SALE_VALUE,
				SUM(if(cm.print_type='SCREEN' OR cm.print_type='FLEXO+SCREEN' OR cm.print_type='SCREEN+FLEXO' OR cm.print_type='FLEXO' OR cm.print_type='SCREEN+UPTO NECK' OR cm.print_type='OFFSET SCREEN' OR cm.print_type='SCREEN + HOTFOIL' OR cm.print_type='Flexo +screen'  OR cm.print_type='FLEXO SCREEN',total_costing,0)) as SCREEN_FLEXO_COST,
				SUM(if(cm.print_type='SCREEN' OR cm.print_type='FLEXO+SCREEN' OR cm.print_type='SCREEN+FLEXO' OR cm.print_type='FLEXO' OR cm.print_type='SCREEN+UPTO NECK' OR cm.print_type='OFFSET SCREEN' OR cm.print_type='SCREEN + HOTFOIL' OR cm.print_type='Flexo +screen'  OR cm.print_type='FLEXO SCREEN',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0)) as SCREEN_FLEXO_CONTR_VALUE, 

				SUM(if(cm.print_type='OFFSET' OR cm.print_type='PLAIN',dispatch_quantity,0)) as OFFSET_QUANTITY,
				SUM(if(cm.print_type='OFFSET' OR cm.print_type='PLAIN',(cm.dispatch_quantity*cm.unit_rate),0)) as OFFSET_SALE_VALUE,
				SUM(if(cm.print_type='OFFSET' OR cm.print_type='PLAIN',total_costing,0)) as OFFSET_COST,
				SUM(if(cm.print_type='OFFSET' OR cm.print_type='PLAIN',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0)) as OFFSET_CONTR_VALUE, 

				SUM(if(cm.print_type='LABEL OFFSET' OR cm.print_type='SCREEN + LABEL' OR cm.print_type='SCREEN UP TO NECK+LABEL' OR cm.print_type='LABELING' OR cm.print_type='LABEL' OR cm.print_type='OFFSET+LABEL' OR cm.print_type='LABEL + OFFSET',dispatch_quantity,0)) as LABEL_QUANTITY,
				SUM(if(cm.print_type='LABEL OFFSET' OR cm.print_type='SCREEN + LABEL' OR cm.print_type='SCREEN UP TO NECK+LABEL' OR cm.print_type='LABELING' OR cm.print_type='LABEL' OR cm.print_type='OFFSET+LABEL' OR cm.print_type='LABEL + OFFSET',(cm.dispatch_quantity*cm.unit_rate),0)) as LABEL_SALE_VALUE,
				SUM(if(cm.print_type='LABEL OFFSET' OR cm.print_type='SCREEN + LABEL' OR cm.print_type='SCREEN UP TO NECK+LABEL' OR cm.print_type='LABELING' OR cm.print_type='LABEL' OR cm.print_type='OFFSET+LABEL' OR cm.print_type='LABEL + OFFSET',total_costing,0)) as LABEL_COST,
				SUM(if(cm.print_type='LABEL OFFSET' OR cm.print_type='SCREEN + LABEL' OR cm.print_type='SCREEN UP TO NECK+LABEL' OR cm.print_type='LABELING' OR cm.print_type='LABEL' OR cm.print_type='OFFSET+LABEL' OR cm.print_type='LABEL + OFFSET',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0)) as LABEL_CONTR_VALUE, 

				SUM(if(cm.print_type='FLEXO+DIGITAL+FLEXO' OR cm.print_type='DIGITAL+FLEXO' OR cm.print_type='FLEXO+DIGITAL',dispatch_quantity,0)) as SPRING_QUANTITY,
				SUM(if(cm.print_type='FLEXO+DIGITAL+FLEXO' OR cm.print_type='DIGITAL+FLEXO' OR cm.print_type='FLEXO+DIGITAL',(cm.dispatch_quantity*cm.unit_rate),0)) as SPRING_SALE_VALUE,
				SUM(if(cm.print_type='FLEXO+DIGITAL+FLEXO' OR cm.print_type='DIGITAL+FLEXO' OR cm.print_type='FLEXO+DIGITAL',total_costing,0)) as SPRING_COST,
				SUM(if(cm.print_type='FLEXO+DIGITAL+FLEXO' OR cm.print_type='DIGITAL+FLEXO' OR cm.print_type='FLEXO+DIGITAL',(cm.dispatch_quantity*cm.unit_rate)-total_costing,0)) as SPRING_CONTR_VALUE
                
				FROM `costsheet_master` as cm 
				LEFT JOIN address_master as am
				ON cm.customer_id=am.adr_company_id
				LEFT JOIN article_name_info as ani
				ON cm.article_no=ani.article_no
				LEFT JOIN address_category_master as acm
				ON ani.adr_category_id=acm.adr_category_id
				WHERE ani.company_id='000020'
                and cm.invoice_date BETWEEN '$from_date' AND '$to_date'
				group by ani.adr_category_id
        order by sales_quantity desc";
        $query=$this->db->query($sql);
				return $result=$query->result();

  	}



}

?>