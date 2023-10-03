<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_card extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('job_card_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('artwork_model');
      $this->load->model('article_model');
      $this->load->model('process_model');
      $this->load->model('fiscal_model');
      $this->load->model('sales_order_item_parameterwise_model');
      $this->load->model('springtube_extrusion_production_model');
      $this->load->model('springtube_extrusion_wip_model'); 
      $this->load->model('jobcard_issue_tally_model');
		}else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Sales'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='production_master';
            include('pagination.php');
            $data['job_card']=$this->job_card_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
		  	
    		}
    	}
  	}
    else{
    	$data['note']='No rights Thanks';
    	$data['page_name']='home';
    	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
  		$this->load->view('Home/footer');
    }
  }


  function issue_jobcard(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            // $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->uri->segment(3));

            
            $data=array('manu_order_no'=>$this->uri->segment(3),
              'completed_flag'=>'0',
              'archive'=>'0');
            $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');


            //$dataa=array('manu_order_no'=>$this->uri->segment(3),
            //  'completed_flag'=>'1');
            //$data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');
           //$dataa=array('manu_order_no'=>$this->uri->segment(3));
           $data['job_card_issued']=$this->common_model->select_one_details_record('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$this->uri->segment(3));

           //print_r($data['job_card_issued']);
            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/issue_jobcard',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function save_issue_jobcard(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){


                $top_box_flag = (!empty($this->input->post('top_box_flag'))) ? $this->input->post('top_box_flag') : 0;
                $bottom_box_flag = (!empty($this->input->post('bottom_box_flag'))) ? $this->input->post('bottom_box_flag') : 0;

                $production_master_data=array(
                'top_box_flag'=>$top_box_flag,
                'bottom_box_flag'=>$bottom_box_flag);


                $result_update_production_master=$this->common_model->update_one_active_record('production_master',$production_master_data,'mp_pos_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

                $data['job_card_issued']=$this->common_model->select_one_details_record('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$this->input->post('jobcard_no'));



            if($this->input->post('mm_id')==TRUE){

              foreach($this->input->post('mm_id') as $mm_id => $mm_id_value){
              //$this->form_validation->set_rules('quantity_'.$mm_id_value.'','Quantity '.$mm_id_value.'' ,'required|trim|xss_clean|max_length[15]|less_than_equal_to['.$this->input->post('available_qty_'.$mm_id_value.'').']');
              $this->form_validation->set_rules('quantity_'.$mm_id_value.'','Quantity '.$mm_id_value.'' ,'required|trim|xss_clean');
              
              }
            }

            
            if($this->form_validation->run()==FALSE){

              $data=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'0');
              $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');



              $dataa=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'1');


                $data['job_card_issued']=$this->common_model->select_one_details_record('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$this->input->post('jobcard_no'));

              //echo $this->db->last_query();

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/issue_jobcard',$data);
                $this->load->view('Home/footer');

            }else{

              $current_date=date('Y-m-d');
              $i=0;
              foreach($this->input->post('mm_id') as $mm_id => $mm_id_value){

                $article_no=$this->input->post('article_no_'.$mm_id_value.'');
                //$available_qty_a=$this->input->post('available_qty_'.$mm_id_value.'');
                //$available_qty=round($available_qty_a,2)*100;
                $quantity_a=$this->input->post('quantity_'.$mm_id_value.'');
                $quantity=round($quantity_a,2)*100;
                //$calculated_purchase_price_a=$this->input->post('calculated_purchase_price_'.$mm_id_value.'');
                //$calculated_purchase_price=round($calculated_purchase_price_a,2)*100;
                //$amt_manual_a=$calculated_purchase_price_a*$quantity_a;
                //$amt_manual=round($amt_manual_a,2)*100;
                $avlqty='0';
                //$avlqty_a=0;
               // $avlqty_a=$available_qty_a-$quantity_a;
               // $avlqty=round($avlqty_a,2)*100;
                $calculated_purchase_price='0';
                $amt_manual='0';


                $quantity_decimal=($quantity!=0?$quantity/100:0);

              // Job card material issued is Export to Excel For Tally-------------Eknath 07-March-2019

                

                $export_array[$i][0]=$article_no;
                $export_array[$i][1]=$quantity_decimal;
                $i++;
                
                //----------------------------------------




                $type_flag=($this->input->post('from_job_card_'.$mm_id_value.'')==0 ? '4': '2');

                $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');
                if($result_pos_no){
                  foreach($result_pos_no as $result_pos_no_row){
                    $pos_no=$result_pos_no_row->pos_no;
                    $pos_no=$pos_no+1;
                  }
                }

              // Batch Updation Logic----Pravin------------------------

                // if(!empty($this->input->post('delivery_purchase_no_1_'.$mm_id_value.''))){

                //   if($quantity<$this->input->post('remaining_batch_qty_1_'.$mm_id_value.'')){
                //     $remaining_batch_qty=$this->input->post('remaining_batch_qty_1_'.$mm_id_value.'')-$quantity;

                //     $update_batch_1_details=array('remaining_batch_qty'=>$remaining_batch_qty);

                //     $result_update_material_manufacturing_batch_1=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_1_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_1_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_1_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                //     if($result_update_material_manufacturing_batch_1){

                //       $update_batch_1_detailss=array('batch_no'=>$this->input->post('batch_no_1_'.$mm_id_value.''));

                //       $result_update_material_manufacturing_batch_1=$this->common_model->update_one_active_record_where('article_history',$update_batch_1_details,'delivery_purchase_no',$pos_no,'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                //       //echo $this->db->last_query();
                //       if($result_update_material_manufacturing_batch_1){
                //         echo "Batch No is Updated";
                //       }
                //     }
                //   }else{
                //     if(!empty($this->input->post('delivery_purchase_no_2_'.$mm_id_value.''))){

                //       $total_grn_qty=$this->input->post('delivery_purchase_no_1_'.$mm_id_value.'')+$this->input->post('delivery_purchase_no_2_'.$mm_id_value.'');
                //       if($total_grn_qty>$quantity){

                //         $remaining_batch_qty=$total_grn_qty-$quantity;
                //         $update_batch_1_details=array('remaining_batch_qty'=>'0');

                //         $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_1_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_1_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_1_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                //         if($result_update_material_manufacturing_batch_2){

                //           $update_batch_2_details=array('remaining_batch_qty'=>$remaining_batch_qty);

                //            $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_2_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_2_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_2_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);

                //            $update_batch_3_details=array('batch_no'=>$this->input->post('batch_no_1_'.$mm_id_value.'').",".$this->input->post('batch_no_2_'.$mm_id_value.''),
                //             'remaining_batch_qty'=>$this->input->post('delivery_purchase_no_1_'.$mm_id_value.'').",".$this->input->post('delivery_purchase_no_2_'.$mm_id_value.''));

                //            $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where('article_history',$update_batch_3_details,'delivery_purchase_no',$pos_no,'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                //            if($result_update_material_manufacturing_batch_2){
                            
                //               echo "Batch No is Updated";

                //             }
                //          }

                //       }
                //     }
                //   }

                // }
            //-------------------------------------------------------------------    
                

                $sales_order_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('jobcard_no'));
                if($sales_order_result){
                  foreach($sales_order_result as $sales_order_result_row){
                    $sales_order_no=$sales_order_result_row->sales_ord_no;
                  }
                }

                $top_box_flag = (!empty($this->input->post('top_box_flag'))) ? $this->input->post('top_box_flag') : 0;
                $bottom_box_flag = (!empty($this->input->post('bottom_box_flag'))) ? $this->input->post('bottom_box_flag') : 0;

                $production_master_data=array(
                'top_box_flag'=>$top_box_flag,
                'bottom_box_flag'=>$bottom_box_flag);


                $result_update_production_master=$this->common_model->update_one_active_record('production_master',$production_master_data,'mp_pos_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();


                $material_manufacturing_data=array(
                'completed_flag'=>'1',
                'calculated_purchase_price'=>$calculated_purchase_price,

              );

                $result_update_material_manufacturing=$this->common_model->update_one_active_record_where('material_manufacturing',$material_manufacturing_data,'manu_order_no',$this->input->post('jobcard_no'),'mm_id',$mm_id_value,$this->session->userdata['logged_in']['company_id']);

                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'sales_order_no'=>$sales_order_no,
                  'qty'=>$quantity,
                  'date_required'=>date('Y-m-d'),
                  'article_no'=>$article_no,
                  'pos_no'=>$pos_no,
                  'type_flag'=>$type_flag,
                  'total_qty'=>$quantity,
                  'rel_uom_id'=>'0',
                  'qty_rel'=>'0',
                  'amt_manual'=>$amt_manual,
                  'document_no'=>'',
                  'calculated_purchase_price'=>$calculated_purchase_price,
                  'voucher_no'=>'',
                  'plant_id'=>'3',
                  'created_annexure'=>'0',
                  'grn'=>'',
                  'ref_mm_id'=>$mm_id_value,
                  'user_id'=>$this->session->userdata['logged_in']['user_id']);

                $ref_pos_no=$this->common_model->save_return_pkey('reserved_quantity_manu',$data);
                //if($ref_pos_no){

                  //Jobcard to tally_material_issue_master sql intigration 9th April 2019---

                    $jobcard_tally=$this->input->post('jobcard_no').'/'.$sales_order_no.'/'.$pos_no;
                    $data_tally=array('issue_date'=>date('Y-m-d'),
                               'jobcard_no'=>$jobcard_tally,
                               'part_no'=>$article_no,
                               'qty'=>$quantity_decimal,
                               'transaction_date'=>date('Y-m-d'),
                               'ref_pos_no'=>$ref_pos_no
                              );

                    $result_tally_material_issue_master=$this->common_model->save('tally_material_issue_master',$data_tally);
                    
                  //---------------------------------------------------------
                   
                  //}             


                }
                


              $data['note']='Save Transaction Completed';
              $data=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'0');
              $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

              //--Eknath Saving Template  of Issue Material-----
                // echo'<pre>';
                // print_r($export_array);
                // echo'</pre>';
               
                   // $flag='';
                   // $flag= $this->excel_jobcard($export_array,$this->input->post('jobcard_no'));
                   // if($flag==1){
                   //    $data['note']='Excel Tamplate Generated';
                   // }else{
                   //    $data['note']='Error in Excel Tempalate';
                   // }

                //-------------------------------------------------- 
              
              // $dataa=array('manu_order_no'=>$this->input->post('jobcard_no'),
              // 'completed_flag'=>'1');
              // $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');
              
              $data['job_card_issued']=$this->common_model->select_one_details_record('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$this->input->post('jobcard_no'));

              $data['note']='Save Transaction Completed';
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/issue_jobcard',$data);
                $this->load->view('Home/footer');


            }

            
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function mannual_issue(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){            

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/mannual-issue-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }



  function save_mannual_issue(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            
            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              $this->form_validation->set_rules('process_'.$sr_no_value.'','Process '.$sr_no_value.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('document_no_'.$sr_no_value.'','Document No.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('date_required_'.$sr_no_value.'','Date.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('product_name_'.$sr_no_value.'','Product.'.$sr_no_value.'' ,'required|trim|xss_clean|callback_article_check');
              //$this->form_validation->set_rules('availabel_quantity_'.$sr_no_value.'','Availabel Quantity.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              $this->form_validation->set_rules('issue_quantity_'.$sr_no_value.'','Issue Quantity.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]|greater_than[0]');
              //$this->form_validation->set_rules('calculated_purchase_price_'.$sr_no_value.'','Rate.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              //$this->form_validation->set_rules('amt_manual_'.$sr_no_value.'','Amount.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              
            }

            
            if($this->form_validation->run()==FALSE){              

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/mannual-issue-form',$data);
                $this->load->view('Home/footer');

            }else{

              $current_date=date('Y-m-d');

              foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
                $arr=explode("//",$this->input->post('product_name_'.$sr_no_value.''));
                $article_no=$arr[1];
                //$availabel_quantity_a=$this->input->post('availabel_quantity_'.$sr_no_value.'');
               // $available_qty=round($availabel_quantity_a,2)*100;
                $issue_quantity_a=$this->input->post('issue_quantity_'.$sr_no_value.'');
                $issue_quantity=round($issue_quantity_a,2)*100;

                //$quantity_decimal=($quantity!=0?$quantity/100:0);


                //$calculated_purchase_price_a=$this->input->post('calculated_purchase_price_'.$sr_no_value.'');
                //$calculated_purchase_price=round($calculated_purchase_price_a,2)*100;
                $calculated_purchase_price=0;
                //$amt_manual_a=$calculated_purchase_price_a*$issue_quantity_a;
                //$amt_manual=round($amt_manual_a,2)*100;
                $amt_manual=0;
                $avlqty=0;
                $avlqty_a=0;
                //$avlqty_a=$availabel_quantity_a-$issue_quantity_a;
                // $avlqty=round($avlqty_a,2)*100;              
                $type_flag='5';

                $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');
                if($result_pos_no){
                  foreach($result_pos_no as $result_pos_no_row){
                    $pos_no=$result_pos_no_row->pos_no;
                    $pos_no=$pos_no+1;
                  }
                }

                $process=($this->input->post('process_'.$sr_no_value.'')==1?"spring":"coex");

                $manual_mat_issue='manual_mat_issue_'.$process.'_'.$pos_no;


                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'manu_order_no'=>$manual_mat_issue,
                  'sales_order_no'=>'',
                  'qty'=>$issue_quantity,
                  'date_required'=>date('Y-m-d'),
                  'article_no'=>$article_no,
                  'pos_no'=>$pos_no,
                  'type_flag'=>$type_flag,
                  'total_qty'=>$issue_quantity,
                  'rel_uom_id'=>'0',
                  'qty_rel'=>'0',
                  'amt_manual'=>$amt_manual,
                  'document_no'=>$this->input->post('document_no_'.$sr_no_value.''),
                  'calculated_purchase_price'=>$calculated_purchase_price,
                  'voucher_no'=>'',
                  'plant_id'=>'3',
                  'created_annexure'=>'0',
                  'grn'=>$this->input->post('process_'.$sr_no_value.''),
                  'ref_mm_id'=>'',
                  'user_id'=>$this->session->userdata['logged_in']['user_id']);

                $ref_pos_no=$this->common_model->save_return_pkey('reserved_quantity_manu',$data);
                //if($ref_pos_no){

            //Mannual Jobcard to tally_material_issue_master sql intigration 9th April 2019---

                  $mannual_jobcard_no_tally=$manual_mat_issue.'/'.date('Y-m-d h:i');
                  $data_tally=array('issue_date'=>date('Y-m-d'),
                             'jobcard_no'=>$mannual_jobcard_no_tally,
                             'part_no'=>$article_no,
                             'qty'=>$issue_quantity_a,
                             'transaction_date'=>date('Y-m-d'),
                             'ref_pos_no'=>$ref_pos_no
                            );

                  $result_tally_material_issue_master=$this->common_model->save('tally_material_issue_master',$data_tally);
                  
                //---------------------------------------------------------



                    

                     
                  //}
                }//FOREACH

              $data['note']='Save Transaction Completed';
              $table='production_master';
              include('pagination.php');
              $data['job_card']=$this->job_card_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                $this->load->view('Home/footer');


            }


            
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  public function article_check($str){
      if($str!=''){
        $article=explode('//',$str);
        if(!empty($article[1])){
          $data['article']=$this->common_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_no',$article[1]);
          foreach ($data['article'] as $article_row) {

            if ($article_row->article_no == $article[1]){
            return TRUE;
            }else{
            $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
            return FALSE;
            }
          } 

        }else{
          $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
          return FALSE;
        } 

      }
     
  }

  function search(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_jobcard_type_master']=$this->common_model->select_active_drop_down('springtube_jobcard_type_master',$this->session->userdata['logged_in']['company_id']);
           
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


 function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Sales'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {
                if($formrights_row->view==1){

                    $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
                    $this->form_validation->set_rules('sales_ord_no','So No.' ,'trim|xss_clean');
                    $this->form_validation->set_rules('mp_pos_no','Jobcard No.' ,'trim|xss_clean');
                    $this->form_validation->set_rules('employee_id','Created By' ,'trim|xss_clean');
                    $this->form_validation->set_rules('jobcard_type','JObcard Type' ,'trim|xss_clean');

                    if($this->form_validation->run()==FALSE)
                      {

                        $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);  
                        $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                        $data['springtube_jobcard_type_master']=$this->common_model->select_active_drop_down('springtube_jobcard_type_master',$this->session->userdata['logged_in']['company_id']);
           

                        $this->load->view('Home/header');
                        $this->load->view('Home/nav',$data);
                        $this->load->view('Home/subnav');
                        $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                        $this->load->view('Home/footer');

                      }else{

                        $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                        $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);  

                          if(!empty($this->input->post('article_no'))){
                            $article_no_arr=explode('//',$this->input->post('article_no'));
                            $article_no=$article_no_arr[1];
                          }else{
                            $article_no='';
                          }

                         
                          $master_array= array('article_no' => $article_no,
                                                'sales_ord_no'=>$this->input->post('sales_ord_no'),
                                                'mp_pos_no'=>$this->input->post('mp_pos_no'),
                                                'employee_id'=>$this->input->post('user_id'),
                                                'order_master.order_flag'=>$this->input->post('order_flag'),
                                                'jobcard_type'=>$this->input->post('jobcard_type')

                                              );
                          
                          $data1=array_filter($master_array);                      
                          $data['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from,$to,$this->session->userdata['logged_in']['company_id']);
                          //echo $this->db->last_query();

                          $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                          $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                          $data['springtube_jobcard_type_master']=$this->common_model->select_active_drop_down('springtube_jobcard_type_master',$this->session->userdata['logged_in']['company_id']);

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                          $this->load->view('Home/footer');


                      }


                }
                else{
                  $data['note']='No rights Thanks';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Error/error-title',$data);
                  $this->load->view('Home/footer');
                }
             }


          } 

        }


    }else{
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }  



  }


  function close_jobcard(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $order_no='';
            $article_no='';
            $jobcard_type='0';
            $total_meters=0;
            $plan_cost_per_meter=0;
            $production_cost_per_meter=0;

            $total_setup_cost=0;
            $total_purging_cost=0;


            $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $this->uri->segment(3));
            foreach($production_master_result as $production_master_row) {
              $order_no=$production_master_row->sales_ord_no;
              $article_no=$production_master_row->article_no;
              $jobcard_type=$production_master_row->jobcard_type;
              $total_meters=$production_master_row->total_meters;
            }            

            // FOR EXTRUSION JOBCARDS ----------
            $production_ok_meters=0;
            $sum_extrusion_amount=0;
            $total_extrusion_cost=0;
            
            $error_1=array();
            $note_1=array();

            $extrusion_tally_cost_error=0;
            $setup_tally_cost_error=0;
            $purging_tally_cost_error=0;

            $printing_tally_cost_error=0;


            // SPRING EXTRUSION JOBCARD COST
            if($jobcard_type=='1'){

              // TOTAL OK METERS--------------------------------

              // $data=array('jobcard_no'=>$this->uri->segment(3),'status'=>0,'archive'=>0);
              // $springtube_extrusion_wip_master_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data);
              // //echo $this->db->last_query();

              // foreach ($springtube_extrusion_wip_master_result as  $springtube_extrusion_wip_master_row) {
              //   $production_ok_meters+=$springtube_extrusion_wip_master_row->total_ok_meters;
                
              // }

              $in_arr=array(1,7);
              $data_search=array('jobcard_no'=>$this->uri->segment(3),'archive'=>0);
              $springtube_extrusion_wip_master_result=$this->springtube_extrusion_wip_model->active_record_search_in('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,'','','','',$in_arr); 
              
              //echo $this->db->last_query(); 

               foreach ($springtube_extrusion_wip_master_result as  $springtube_extrusion_wip_master_row) {
                $production_ok_meters+=$springtube_extrusion_wip_master_row->total_ok_meters;
                
              }

              //echo $production_ok_meters;
              //exit;

              $material_manu_data=array('manu_order_no'=>$this->uri->segment(3),'archive'=>0);              

              $material_manufacturing_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$material_manu_data);

             //echo $this->db->last_query();

              foreach ($material_manufacturing_result as $material_manufacturing_row) {

                $calculated_purchase_price=0; 
                $qty=0;               
                $data_reserved=array(
                'manu_order_no'=>$material_manufacturing_row->manu_order_no,
                'article_no'=>$material_manufacturing_row->article_no,
                'ref_mm_id'=>$material_manufacturing_row->mm_id);
                
                $reserved_quantity_manu_result=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved);  

                foreach ($reserved_quantity_manu_result as  $reserved_quantity_manu_row) {
                  
                  $qty=$this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
                
                  $calculated_purchase_price=$this->common_model->read_number($reserved_quantity_manu_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }  

                if($calculated_purchase_price==0 || $calculated_purchase_price==''){

                    $extrusion_tally_cost_error=1;

                    array_push($error_1,'For Extrusion Jobcard '.$this->uri->segment(3).', material issued cost need to check from Tally');
                    break;

                }
                else{
                    
                  $sum_extrusion_amount+=$qty*$calculated_purchase_price;

                }                          
                

              }

              echo $extrusion_tally_cost_error;

              //echo $sum_amount;
              if($sum_extrusion_amount!=0 && $extrusion_tally_cost_error==0 ){

                //echo $sum_extrusion_amount;
                //echo '<br/>';
                //echo $production_ok_meters;
                $plan_cost_per_meter=$sum_extrusion_amount/$total_meters;
                $production_cost_per_meter=$sum_extrusion_amount/$production_ok_meters;              
              
                $data=array('extrusion_job_cost_per_meter'=>round($plan_cost_per_meter,2),'extrusion_prod_cost_per_meter'=>round($production_cost_per_meter,2));
                $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);


                array_push($note_1,'Extrusion Jobcard '.$this->uri->segment(3).' Cost Saved succesfully');

                //SETUP AND PURGING JOBCARD -----

                $setup_jobcard_no='';
                $purging_jobcard='';
                

                $data=array('jobcard_no'=>$this->uri->segment(3),'archive'=>0);
                $spring_extrusion_production_details_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$data);
                //echo $this->db->last_query();
                
                foreach ($spring_extrusion_production_details_result as  $spring_extrusion_production_details_row) {
                  $setup_jobcard_no=$spring_extrusion_production_details_row->setup_jobcard_no;
                  $purging_jobcard=$spring_extrusion_production_details_row->purging_jobcard;

                  $setup_prod_cost_per_meter=0;

                  if($setup_jobcard_no!=''){

                    $setup_amount=0;                               

                    $material_manu_setup_data=array('manu_order_no'=>$setup_jobcard_no,'work_proc_no'=>1,'archive'=>0);              

                    $material_manufacturing_setup_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$material_manu_setup_data);
                   
                    foreach ($material_manufacturing_setup_result as $material_manufacturing_setup_row) {
                      

                      $data_reserved_1=array('manu_order_no'=>$material_manufacturing_setup_row->manu_order_no,
                        'article_no'=>$material_manufacturing_setup_row->article_no,
                        'ref_mm_id'=>$material_manufacturing_setup_row->mm_id);
                      
                      $reserved_quantity_manu_result_1=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved_1); 
                      //echo $this->db->last_query(); 

                      //print_r($reserved_quantity_manu_result);
                      $setup_rate=0;
                      $setup_qty=0; 
                      foreach ($reserved_quantity_manu_result_1 as  $reserved_quantity_manu_row) {
                        
                        $setup_qty=$this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
                      
                        $setup_rate=$this->common_model->read_number($reserved_quantity_manu_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                        //echo'</br>';
                      }

                      if($setup_rate=='0' || $setup_rate==''){
                      //if($setup_rate=='0'){

                        $setup_tally_cost_error=1;
                        //echo 'Balnk';
                        //echo $reserved_quantity_manu_row->pos_no;


                        array_push($error_1,'For Setup Jobcard '.$setup_jobcard_no.', material issued cost need to check from Tally');
                        break;

                      }else{

                        $setup_amount+=$setup_qty*$setup_rate;

                      }
                      

                    }
                    if($setup_amount!=0 && $setup_tally_cost_error==0 ){
                      //$plan_cost_per_meter=$setup_amount/$total_meters;
                      $setup_prod_cost_per_meter=$setup_amount/$production_ok_meters;

                      $total_setup_cost+=$setup_prod_cost_per_meter;
                    
                      $data=array('jobcard_status'=>'1','setup_prod_cost_per_meter'=>round($setup_prod_cost_per_meter,2));

                      $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$setup_jobcard_no,$this->session->userdata['logged_in']['company_id']);

                      //$data['note']='Setup cost saved successfully.';
                      array_push($note_1, 'Setup Jobcard '.$setup_jobcard_no.' Cost Saved succesfully');


                    }else{

                        //$data['error']='Setup Jobcard material is not issued yet hence sestup cost is 0';
                      array_push($error_1,'Setup Jobcard '.$setup_jobcard_no.' material  cost need to check from tally');
                    }
             
                  }//Setup Jobcard
                    // Purging Jobcard Calculations
                   $purging_prod_cost_per_meter=0;
                  if($purging_jobcard!=''){

                    $purging_amount=0;                  

                    $material_manu_purging_data=array('manu_order_no'=>$purging_jobcard,
                      'archive'=>0);              

                    $material_manufacturing_purging_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$material_manu_purging_data);
                   
                    foreach ($material_manufacturing_purging_result as $material_manufacturing_purging_row) {

                      $purging_rate=0;
                      $purging_qty=0;

                      $data_reserved=array(
                      'manu_order_no'=>$material_manufacturing_purging_row->manu_order_no,
                      'article_no'=>$material_manufacturing_purging_row->article_no,
                      'ref_mm_id'=>$material_manufacturing_purging_row->mm_id);
                      
                      $reserved_quantity_manu_result=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved);  

                      foreach ($reserved_quantity_manu_result as  $reserved_quantity_manu_row) {
                        
                        $purging_qty=$this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
                      
                        $purging_rate=$this->common_model->read_number($reserved_quantity_manu_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                      }

                      if($purging_rate==0 || $purging_rate==''){

                        $purging_tally_cost_error=1;

                        array_push($error_1,'For Purging Jobcard '.$purging_jobcard.', material issued cost need to check from Tally');
                        break;

                      }else{

                        $purging_amount+=$purging_qty*$purging_rate;

                      }
                      

                    }


                    if($purging_amount!=0 && $purging_tally_cost_error==0){
                      //$plan_cost_per_meter=$setup_amount/$total_meters;
                      $purging_prod_cost_per_meter=$purging_amount/$production_ok_meters;
                      $total_purging_cost+=$purging_prod_cost_per_meter;      
                    
                      $data=array('jobcard_status'=>'1','purging_prod_cost_per_meter'=>round($purging_prod_cost_per_meter,2));
                      $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$purging_jobcard,$this->session->userdata['logged_in']['company_id']);

                      //$data['note']='Purging cost saved successfully.';
                      array_push($note_1,'Purging Jobcard '.$purging_jobcard.' Cost Saved succesfully');

                    }else{

                     // $data['error']='Purging Jobcard material is not issued yet hence purging cost is 0';
                      array_push($error_1,'Purging Jobcard '.$purging_jobcard.' material issued cost need to check from Tally');

                    }
             
                  }//Purging  Jobcard



                }// Foreach 

              //$data['note']='Extrusion Jobcard closed successfully';

              }else{

                //echo 'out';
                //$data['error']='Extrusion Jobcard material is not issued hence cost is 0';
                array_push($error_1,'Extrusion Jobcard '.$this->uri->segment(3).' material cost need to check from Tally');
              }


             // print_r($note_1);
             // print_r($error_1);

              if(empty($error_1)){
                 
                $data_prd=array('jobcard_status'=>'1','extrusion_job_cost_per_meter'=>round($plan_cost_per_meter,2),'extrusion_prod_cost_per_meter'=>round($production_cost_per_meter,2));

                $result=$this->common_model->update_one_active_record('production_master',$data_prd,'mp_pos_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $total_extrusion_cost=round($total_purging_cost,2)+round($total_setup_cost,2)+round($production_cost_per_meter,2);

                $data_wip=array('wip_cost_per_meter'=>$total_extrusion_cost);

                $result=$this->common_model->update_one_active_record_where('springtube_extrusion_wip_master',$data_wip,'jobcard_no',$this->uri->segment(3),'archive','0',$this->session->userdata['logged_in']['company_id']);


                array_push($note_1,'Extrusion jobcard '.$this->uri->segment(3).' is closed successfully!.');


              }else{

                array_push($error_1,'Extrusion Jobcard '.$this->uri->segment(3).' could not closed due to errors');                          

              }

            }

            // Printing JOBCARS Close--------------------
            if($jobcard_type=='2'){

              $data_wip=array('jobcard_no'=>$this->uri->segment(3),'archive'=>0);
              $springtube_printing_wip_master_after_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_wip);
              $production_ok_qty=0;
              foreach ($springtube_printing_wip_master_after_result as  $springtube_printing_wip_master_after_row) {
                $production_ok_qty+=$springtube_printing_wip_master_after_row->aprint_wip_qty;
                
              }

              $sum_printing_amount=0;
              // $material_manu_data=array('manu_order_no'=>$this->uri->segment(3),
              //                           'work_proc_no'=>3);   

              $material_manu_print_data=array('manu_order_no'=>$this->uri->segment(3),
                                        'archive'=>0);            

              $material_manufacturing_printing_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$material_manu_print_data);
             
              foreach ($material_manufacturing_printing_result as $material_manufacturing_row) {

                $calculated_purchase_price=0; 
                $qty=0; 

                $data_reserved=array(
                'manu_order_no'=>$material_manufacturing_row->manu_order_no,
                'article_no'=>$material_manufacturing_row->article_no,
                'ref_mm_id'=>$material_manufacturing_row->mm_id);
                
                $reserved_quantity_manu_result=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved);  

                foreach ($reserved_quantity_manu_result as  $reserved_quantity_manu_row) {
                  
                  $qty=$this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
                
                  $calculated_purchase_price=$this->common_model->read_number($reserved_quantity_manu_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }
                
                if($calculated_purchase_price==0 || $calculated_purchase_price==''){

                  $printing_tally_cost_error=1;

                  array_push($error_1,'For Printing Jobcard '.$this->uri->segment(3).', material issued cost need to check from Tally');
                  break;

                }else{

                  $sum_printing_amount+=$qty*$calculated_purchase_price;
                }

                

              }

              if($sum_printing_amount>0 && $printing_tally_cost_error==0 ){

                echo $printing_cost_per_qty=round(($sum_printing_amount/$production_ok_qty),2);
                
                $data_prd1=array('jobcard_status'=>'1','printing_cost_per_qty'=>round($printing_cost_per_qty,2));

                $result=$this->common_model->update_one_active_record('production_master',$data_prd1,'mp_pos_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data_wip1=array('aprint_wip_cost_per_qty'=>$printing_cost_per_qty);

                $result=$this->common_model->update_one_active_record_where('springtube_printing_wip_master_after',$data_wip1,'jobcard_no',$this->uri->segment(3),'archive','0',$this->session->userdata['logged_in']['company_id']);

                array_push($note_1,'Printing Jobcard '.$this->uri->segment(3).' Cost Saved succesfully');

              }else{
                array_push($error_1,'Printing Jobcard '.$this->uri->segment(3).' material issued cost need to check from Tally');
              }
              

            }// JOBcard Type  2


           
            
            $data['note_1']=$note_1;
            $data['error_1']=$error_1;

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/close-jobcard-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }  


//--Eknath--
public function excel_jobcard($multi_array,$jobcard_no){
  // echo'<pre>';
  // print_r($multi_array);
  // echo'</pre>';
  // echo $jobcard_no;
  // Export to Excel File--------

     require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
     require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

      $directoryName="/var/www/html/erp/jobcards";
      $file_name=$jobcard_no.'_'.date('d-m-Y his').'.xls';
      
      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);
      $ObjPHPExcel->getActiveSheet()->SetCellValue('A1',$jobcard_no);
      
      $row=2;
      $a=0;
      
      for($k=0;$k<count($multi_array);$k++){
        $ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$row,date('d-m-Y'));
         $ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$multi_array[$k][0]);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$multi_array[$k][1]);
         $row++;
      }

      //$writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel5');
      $writer->save($directoryName.'/'.$file_name);
        
  return 1;

}


    function delete(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                      
 
                
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class()); 

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_jobcard_type_master']=$this->common_model->select_active_drop_down('springtube_jobcard_type_master',$this->session->userdata['logged_in']['company_id']);                 

              $data['note']='Archive Transaction completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{
                $data['note']='No Archive rights Thanks';
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Error/error-title',$data);
                $this->load->view('Home/footer');
            }
          }
        }
      }
    }else{
        $data['note']='No Archive rights Thanks';
        $data['page_name']='home';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');
      }
    }



  function delete_material($mm_id){

     $mm_id;
    $manu_order_no='';
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

            $material_manufacturing_result=$this->common_model->select_one_active_record('material_manufacturing',$this->session->userdata['logged_in']['company_id'],'mm_id',$mm_id);
            foreach ($material_manufacturing_result as  $material_manufacturing_row) {
              $manu_order_no=$material_manufacturing_row->manu_order_no;
            }

            $data_archive=array('archive'=>1);

            $result=$this->common_model->update_one_active_record('material_manufacturing',$data_archive,'mm_id', $mm_id, $this->session->userdata['logged_in']['company_id']);

            
            $data=array('manu_order_no'=>$manu_order_no,
                        'completed_flag'=>'0',
                        'archive'=>'0'
            );
            $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');


            //$dataa=array('manu_order_no'=>$this->uri->segment(3),
            //  'completed_flag'=>'1');
            //$data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');
           //$dataa=array('manu_order_no'=>$this->uri->segment(3));
           $data['job_card_issued']=$this->common_model->select_one_details_record('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$manu_order_no);

           //print_r($data['job_card_issued']);
            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/issue_jobcard',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

    function search_manual(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $from=date('Y-m-d');
              $to=date('Y-m-d');

              $data['reserved_quantity_manu']=$this->job_card_model->active_record_search_manual('reserved_quantity_manu',$search=array(),$from,$to,$this->session->userdata['logged_in']['company_id']);
               
           
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-manual',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records-manual',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


   function search_result_manual(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Sales'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {
                if($formrights_row->view==1){

                    $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');                     
                    $this->form_validation->set_rules('employee_id','Created By' ,'trim|xss_clean');
                    $this->form_validation->set_rules('process','Process' ,'trim|xss_clean');

                    if($this->form_validation->run()==FALSE)
                      {

                        $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);  
                        $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                        

                        $this->load->view('Home/header');
                        $this->load->view('Home/nav',$data);
                        $this->load->view('Home/subnav');
                        $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                        $this->load->view(ucwords($this->router->fetch_class()).'/search-form-manual',$data);
                        $this->load->view('Home/footer');

                      }else{


                        $search=array();

                        $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                        $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);  

                          if(!empty($this->input->post('article_no'))){
                            $article_no_arr=explode('//',$this->input->post('article_no'));
                            $article_no=$article_no_arr[1];
                            $search['article_no']=$article_no;
                          }else{
                            $article_no='';
                          }

                          if(!empty($this->input->post('user_id'))){
                            $search['user_id']=$this->input->post('user_id');
                          }

                          if($this->input->post('process')!=''){
                            $search['grn']=$this->input->post('process');
                          }
                         
                          // $master_array= array(
                          //   'article_no' => $article_no,                                               
                          //   'employee_id'=>$this->input->post('user_id'),
                          //   'process'=>$this->input->post('process')       

                          // );
                          
                          //$data1=array_filter($master_array);                      
                          $data['reserved_quantity_manu']=$this->job_card_model->active_record_search_manual('reserved_quantity_manu',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                          //echo $this->db->last_query();

                          $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                          $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                           

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/search-form-manual',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-records-manual',$data);
                          $this->load->view('Home/footer');


                      }


                }
                else{
                  $data['note']='No rights Thanks';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Error/error-title',$data);
                  $this->load->view('Home/footer');
                }
             }


          } 

        }


    }else{
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }  



  }






}