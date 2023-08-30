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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'job_card');

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

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            
            $data=array('manu_order_no'=>$this->uri->segment(3),
              'completed_flag'=>'0');
            $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'work_proc_no');


            $dataa=array('manu_order_no'=>$this->uri->segment(3),
              'completed_flag'=>'1');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
              
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

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            foreach($this->input->post('mm_id') as $mm_id => $mm_id_value){
              $this->form_validation->set_rules('quantity_'.$mm_id_value.'','Quantity '.$mm_id_value.'' ,'required|trim|xss_clean|max_length[15]|less_than_equal_to['.$this->input->post('available_qty_'.$mm_id_value.'').']');
              
            }

            
            if($this->form_validation->run()==FALSE){

              $data=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'0');
              $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'work_proc_no');

              $dataa=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'1');
              $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
                
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
                $available_qty_a=$this->input->post('available_qty_'.$mm_id_value.'');
                $available_qty=round($available_qty_a,2)*100;
                $quantity_a=$this->input->post('quantity_'.$mm_id_value.'');
                $quantity=round($quantity_a,2)*100;
                $calculated_purchase_price_a=$this->input->post('calculated_purchase_price_'.$mm_id_value.'');
                $calculated_purchase_price=round($calculated_purchase_price_a,2)*100;
                $amt_manual_a=$calculated_purchase_price_a*$quantity_a;
                $amt_manual=round($amt_manual_a,2)*100;
                $avlqty=0;
                $avlqty_a=0;
                $avlqty_a=$available_qty_a-$quantity_a;
                $avlqty=round($avlqty_a,2)*100;

                // Export to Excel For Tally-------------
                $export_array=array();
                $export_array[$i][0]=$article_no;
                $export_array[$i][1]=$$quantity;
                //----------------------------------------
                $type_flag=($this->input->post('from_job_card_'.$mm_id_value.'')==0 ? '4': '2');

                $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');
                if($result_pos_no){
                  foreach($result_pos_no as $result_pos_no_row){
                    $pos_no=$result_pos_no_row->pos_no;
                    $pos_no=$pos_no+1;
                  }
                }

                

                if(!empty($this->input->post('delivery_purchase_no_1_'.$mm_id_value.''))){

                  if($quantity<$this->input->post('remaining_batch_qty_1_'.$mm_id_value.'')){
                    $remaining_batch_qty=$this->input->post('remaining_batch_qty_1_'.$mm_id_value.'')-$quantity;

                    $update_batch_1_details=array('remaining_batch_qty'=>$remaining_batch_qty);

                    $result_update_material_manufacturing_batch_1=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_1_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_1_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_1_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                    if($result_update_material_manufacturing_batch_1){

                      $update_batch_1_detailss=array('batch_no'=>$this->input->post('batch_no_1_'.$mm_id_value.''));

                      $result_update_material_manufacturing_batch_1=$this->common_model->update_one_active_record_where('article_history',$update_batch_1_details,'delivery_purchase_no',$pos_no,'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                      if($result_update_material_manufacturing_batch_1){
                        echo "Batch No is Updated";
                      }
                    }
                  }else{
                    if(!empty($this->input->post('delivery_purchase_no_2_'.$mm_id_value.''))){

                      $total_grn_qty=$this->input->post('delivery_purchase_no_1_'.$mm_id_value.'')+$this->input->post('delivery_purchase_no_2_'.$mm_id_value.'');
                      if($total_grn_qty>$quantity){

                        $remaining_batch_qty=$total_grn_qty-$quantity;
                        $update_batch_1_details=array('remaining_batch_qty'=>'0');

                        $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_1_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_1_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_1_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                        if($result_update_material_manufacturing_batch_2){

                          $update_batch_2_details=array('remaining_batch_qty'=>$remaining_batch_qty);

                           $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where_where('article_history',$update_batch_2_details,'delivery_purchase_no',$this->input->post('delivery_purchase_no_2_'.$mm_id_value.''),'batch_no',$this->input->post('batch_no_2_'.$mm_id_value.''),'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);

                           $update_batch_3_details=array('batch_no'=>$this->input->post('batch_no_1_'.$mm_id_value.'').",".$this->input->post('batch_no_2_'.$mm_id_value.''),
                            'remaining_batch_qty'=>$this->input->post('delivery_purchase_no_1_'.$mm_id_value.'').",".$this->input->post('delivery_purchase_no_2_'.$mm_id_value.''));

                           $result_update_material_manufacturing_batch_2=$this->common_model->update_one_active_record_where('article_history',$update_batch_3_details,'delivery_purchase_no',$pos_no,'article_no',$article_no,$this->session->userdata['logged_in']['company_id']);
                           if($result_update_material_manufacturing_batch_2){
                            
                              echo "Batch No is Updated";

                            }
                         }

                      }
                    }
                  }

                }
                

                $sales_order_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('jobcard_no'));
                if($sales_order_result){
                  foreach($sales_order_result as $sales_order_result_row){
                    $sales_order_no=$sales_order_result_row->sales_ord_no;
                  }
                }


                $material_manufacturing_data=array(
                'completed_flag'=>'1',
                'calculated_purchase_price'=>$calculated_purchase_price);

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
                  'grn'=>'');

                $result_reserved_quantity_manu=$this->common_model->save('reserved_quantity_manu',$data);
                if($result_reserved_quantity_manu){

                    $result_pos_no=$this->common_model->select_max_pkey_noncompany('article_history','art_pos_no');
                    if($result_pos_no){
                      foreach($result_pos_no as $result_pos_no_row){
                        $art_pos_no=$result_pos_no_row->art_pos_no;
                        $art_pos_no=$art_pos_no+1;
                      }
                    }

                    $time=date('H:i:s');
                    $current_time=date('Y-m-d H:i:s');

                    $data=array('article_no'=>$article_no,
                      'art_pos_no'=>$art_pos_no,
                      'sales_purchase_flag'=>'37',
                      'delivery_purchase_no'=>$pos_no,
                      'ah_qty'=>$quantity,
                      'date'=>date('Y-m-d'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'stock_place_id'=>'1',
                      'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'ah_time'=>$time,
                      'plant_id'=>'3',
                      'changed_at'=>$current_time);

                    $result_article_history=$this->common_model->save('article_history',$data);

                    if($result_article_history){
                      $data_article_history=array('article_no'=>$article_no,'adss_date'=>date('Y-m-d'));
                      $result_article_daily_stock_status=$this->common_model->select_active_records_where('article_daily_stock_status',$this->session->userdata['logged_in']['company_id'],$data_article_history);
                      if($result_article_daily_stock_status){

                        $update_data_article_daily_stock_status=array('quantity'=>$avlqty);

                        $update_result_article_daily_stock_status=$this->common_model->update_one_active_record_where('article_daily_stock_status',$update_data_article_daily_stock_status,'article_no',$article_no,'adss_date',date('Y-m-d'),$this->session->userdata['logged_in']['company_id']);

                        $update_data_article_daily_stock_status=array('stock_on_hand'=>$avlqty);

                        $update_result_article_daily_stock_status=$this->common_model->update_one_active_record_where('article_inventory',$update_data_article_daily_stock_status,'article_no',$article_no,'stock_take_date',date('Y-m-d'),$this->session->userdata['logged_in']['company_id']);
        

                      }else{

                        $data_article_daily_stock_status=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'adss_date'=>date('Y-m-d'),
                          'article_no'=>$article_no,
                          'quantity'=>$avlqty,
                          'quantity_rel'=>'0',
                          'calculated_purchase_price'=>'0',
                          'calculated_purchase_value'=>'0');
                        $result_article_daily_stock_status=$this->common_model->save('article_daily_stock_status',$data_article_daily_stock_status);

                        if($result_article_daily_stock_status){

                          $data_article_inventory=array(
                            'article_no'=>$article_no,
                            'stock_place_id'=>'1',
                            'stock_on_hand'=>$avlqty,
                            'company_id'=>$this->session->userdata['logged_in']['company_id'],
                            'stock_take_qty'=>'0',
                            'stock_take_date'=>date('Y-m-d'));

                          $result_data_article_inventory=$this->common_model->save('article_inventory',$data_article_inventory);


                        }

                      }
                    }
                  }
                $i++;}

                $flag=0;
                if($this->excel_jobcard($export_array,$this->input->post('jobcard_no'))){
                  $flag=1;
                }
                else{
                  $flag=0;
                }

              echo $flag;
              $data['note']='Save Transaction Completed';
              $data=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'0');
              $data['job_card']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'work_proc_no');

              $dataa=array('manu_order_no'=>$this->input->post('jobcard_no'),
              'completed_flag'=>'1');
              $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$dataa,'work_proc_no');
              $data['note']='Save Transaction Completed';
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
                
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

  function create(){

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
            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            
            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              
              $this->form_validation->set_rules('document_no_'.$sr_no_value.'','Document No.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('date_required_'.$sr_no_value.'','Date.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('product_name_'.$sr_no_value.'','Product.'.$sr_no_value.'' ,'required|trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('availabel_quantity_'.$sr_no_value.'','Availabel Quantity.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              $this->form_validation->set_rules('issue_quantity_'.$sr_no_value.'','Issue Quantity.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]|less_than_equal_to['.$this->input->post('availabel_quantity_'.$sr_no_value.'').']');
              $this->form_validation->set_rules('calculated_purchase_price_'.$sr_no_value.'','Rate.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              $this->form_validation->set_rules('amt_manual_'.$sr_no_value.'','Amount.'.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              
            }

            
            if($this->form_validation->run()==FALSE){              

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                $this->load->view('Home/footer');

            }else{

              $current_date=date('Y-m-d');

              foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
                $arr=explode("//",$this->input->post('product_name_'.$sr_no_value.''));
                $article_no=$arr[1];
                $availabel_quantity_a=$this->input->post('availabel_quantity_'.$sr_no_value.'');
                $available_qty=round($availabel_quantity_a,2)*100;
                $issue_quantity_a=$this->input->post('issue_quantity_'.$sr_no_value.'');
                $issue_quantity=round($issue_quantity_a,2)*100;
                $calculated_purchase_price_a=$this->input->post('calculated_purchase_price_'.$sr_no_value.'');
                $calculated_purchase_price=round($calculated_purchase_price_a,2)*100;
                $amt_manual_a=$calculated_purchase_price_a*$issue_quantity_a;
                $amt_manual=round($amt_manual_a,2)*100;
                $avlqty=0;
                $avlqty_a=0;
                $avlqty_a=$availabel_quantity_a-$issue_quantity_a;
                echo $avlqty=round($avlqty_a,2)*100;              
                $type_flag='5';

                $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');
                if($result_pos_no){
                  foreach($result_pos_no as $result_pos_no_row){
                    $pos_no=$result_pos_no_row->pos_no;
                    $pos_no=$pos_no+1;
                  }
                }
                $manual_mat_issue='manual_mat_issue_'.$pos_no;


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
                  'document_no'=>'',
                  'calculated_purchase_price'=>$calculated_purchase_price,
                  'voucher_no'=>'',
                  'plant_id'=>'3',
                  'created_annexure'=>'0',
                  'grn'=>'');

                $result_reserved_quantity_manu=$this->common_model->save('reserved_quantity_manu',$data);
                if($result_reserved_quantity_manu){

                    $result_pos_no=$this->common_model->select_max_pkey_noncompany('article_history','art_pos_no');
                    if($result_pos_no){
                      foreach($result_pos_no as $result_pos_no_row){
                        $art_pos_no=$result_pos_no_row->art_pos_no;
                        $art_pos_no=$art_pos_no+1;
                      }
                    }

                    $time=date('H:i:s');
                    $current_time=date('Y-m-d H:i:s');

                    $data=array('article_no'=>$article_no,
                      'art_pos_no'=>$art_pos_no,
                      'sales_purchase_flag'=>'37',
                      'delivery_purchase_no'=>$pos_no,
                      'ah_qty'=>$issue_quantity,
                      'date'=>date('Y-m-d'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'stock_place_id'=>'1',
                      'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'ah_time'=>$time,
                      'plant_id'=>'3',
                      'changed_at'=>$current_time);

                    $result_article_history=$this->common_model->save('article_history',$data);

                    if($result_article_history){

                      $data_article_history=array('article_no'=>$article_no,'adss_date'=>date('Y-m-d'));
                      $result_article_daily_stock_status=$this->common_model->select_active_records_where('article_daily_stock_status',$this->session->userdata['logged_in']['company_id'],$data_article_history);
                      if($result_article_daily_stock_status){

                        $update_data_article_daily_stock_status=array('quantity'=>$avlqty);

                        $update_result_article_daily_stock_status=$this->common_model->update_one_active_record_where('article_daily_stock_status',$update_data_article_daily_stock_status,'article_no',$article_no,'adss_date',date('Y-m-d'),$this->session->userdata['logged_in']['company_id']);

                        $update_data_article_daily_stock_status=array('stock_on_hand'=>$avlqty);

                        $update_result_article_daily_stock_status=$this->common_model->update_one_active_record_where('article_inventory',$update_data_article_daily_stock_status,'article_no',$article_no,'stock_take_date',date('Y-m-d'),$this->session->userdata['logged_in']['company_id']);
        

                      }else{

                        $data_article_daily_stock_status=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'adss_date'=>date('Y-m-d'),
                          'article_no'=>$article_no,
                          'quantity'=>$avlqty,
                          'quantity_rel'=>'0',
                          'calculated_purchase_price'=>'0',
                          'calculated_purchase_value'=>'0');
                        $result_article_daily_stock_status=$this->common_model->save('article_daily_stock_status',$data_article_daily_stock_status);

                        if($result_article_daily_stock_status){

                          $data_article_inventory=array(
                            'article_no'=>$article_no,
                            'stock_place_id'=>'1',
                            'stock_on_hand'=>$avlqty,
                            'company_id'=>$this->session->userdata['logged_in']['company_id'],
                            'stock_take_qty'=>'0',
                            'stock_take_date'=>date('Y-m-d'));

                          $result_data_article_inventory=$this->common_model->save('article_inventory',$data_article_inventory);


                        }

                      }
                    }
                  }
                }//FOREACH

              $data['note']='Save Transaction Completed';
              $table='production_master';
              include('pagination.php');
              $data['job_card']=$this->job_card_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
                
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'job_card');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

             $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
           
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

                    if($this->form_validation->run()==FALSE)
                      {

                        
                        $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

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
                                                'employee_id'=>$this->input->post('user_id')
                                              );
                          
                          $data1=array_filter($master_array);                      
                          $data['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from,$to,$this->session->userdata['logged_in']['company_id']);
                          //echo $this->db->last_query();

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
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

public function excel_jobcard($export_array,$jobcard_no){
  // Export to Excel File--------

    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

      $directoryName="/root/";
      $file_name='Jobcard_'.$jobcard_no.'_'.date('Y-m-d-H:i:s').'.xlsx';
      
      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);
      $ObjPHPExcel->getActiveSheet()->SetCellValue('A1',$jobcard_no);
      
      $row=2;
      $a=0;

      for($k=0;$k<count($export_array);$k++){
        $ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$export_array[$a][0]);
        $ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$export_array[$a][1]);
        $row++;
      }
       

        $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
        $writer->save($directoryName.'/'.$file_name);
        exit;

    //---------------------------

}


}