<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_book extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('artwork_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('payment_term_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('fiscal_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('shoulder_specification_model');
      $this->load->model('cap_specification_model');
      $this->load->model('label_specification_model');
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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='order_master';
            include('pagination.php');
            
            $from="2018-04-01";
            $to=date('Y-m-d');
            $search="";
            $data['order_master']=$this->sales_order_book_model->active_record_search_index($config["per_page"],$this->uri->segment(3),'order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
                 
            $data['tax_header']=$this->sales_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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
    	$data['note']='No View rights Thanks';
    	$data['page_name']='home';
    	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
  		$this->load->view('Home/footer');
    }
  }


  function Summary(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='order_master';
            include('pagination.php');
            
            $data['order']=$this->sales_order_book_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            //$data['top_orders']=$this->sales_order_book_model->select_top_customers_orders($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id'],date('Y'),date('n'));
            //$from="2018-04-01";
            //$to=date('Y-m-d');
            //$search="";
            //$data['order_master']=$this->sales_order_book_model->active_record_search_index($config["per_page"],$this->uri->segment(3),'order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
                 
            //$data['tax_header']=$this->sales_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/Summary',$data);
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
      $data['note']='No View rights Thanks';
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
           $data['country']=$this->country_model->select_active_drop_down('country_master');
           $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
           $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');
           $data['payment_term']=$this->customer_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
           $data['freight_type']=$this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang',$this->session->userdata['logged_in']['language_id']);

           
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


    function save(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean');
            $this->form_validation->set_rules('po_no','Customer Purchase Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('po_date','Customer Purchase Order Date' ,'required|trim|xss_clean|max_length[10]');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){
              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('product_name_'.$i.'','Product Name '.$i.'' ,'required|trim|xss_clean|strtoupper|callback_article_check');
              $this->form_validation->set_rules('delivery_date_'.$i.'','Delivery Date '.$i.'' ,'trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('quantity_'.$i.'','Quantity '.$i.'' ,'required|trim|xss_clean|max_length[20]|is_natural_no_zero');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit rate '.$i.'' ,'required|trim|xss_clean|max_length[20]|numeric');
              $this->form_validation->set_rules('amount_'.$i.'','Amount '.$i.'' ,'required|trim|xss_clean|max_length[20]|numeric');
              $this->form_validation->set_rules('tax_grid_'.$i.'','Tax '.$i.'' ,'required|trim|xss_clean');

            }


            if($this->form_validation->run()==FALSE){

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');
            $data['payment_term']=$this->customer_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
           $data['freight_type']=$this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang',$this->session->userdata['logged_in']['language_id']);

            if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);

              }

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              if(!empty($this->input->post('adr_company_id'))){
                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                foreach ($data['customer'] as $customer) {
                  $property=$customer->property_id;
                }
              }


              if(!empty($this->input->post('consin_adr_company_id'))){
                $data['consignee']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->input->post('consin_adr_company_id'));
                foreach ($data['consignee'] as $consignee) {
                  $consignee_property=$consignee->property_id;
                  $consignee=$consignee->adr_company_id."|".$consignee->property_id;
                }
              }else{
                $consignee='';
              }

              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','75');
              $no="";
              foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                foreach($data['account_periods'] as $account_periods_row){
                  $start=date('y', strtotime($account_periods_row->fin_year_start));
                  $end=date('y', strtotime($account_periods_row->fin_year_end));
                }
                $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                $sales_order_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                $next_sales_order_no=$auto_row->curr_val+1;
              }
              $data=array('curr_val'=>$next_sales_order_no);
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','75',$this->session->userdata['logged_in']['company_id']);

              $for_export = (!empty($this->input->post('export'))) ? $this->input->post('export') : 0;
              $for_sampling = (!empty($this->input->post('for_sampling'))) ? $this->input->post('for_sampling') : 0;
              if(!empty($this->input->post('currency'))){
                $country=explode('|',$this->input->post('currency'));
                $currency=explode('|',$this->input->post('exchange_rate'));
              }else{
                $country[1]='';
                $currency[0]='';
                $currency[1]='';
                $currency[2]='';
              }
              
              $data=array(
                'order_no'=>$sales_order_no,
                'order_date'=>date('Y-m-d'),
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'cust_order_no'=>$this->input->post('po_no'),
                'archive'=>'0',
                'customer_no'=>$customer_arr[1],
                'order_type'=>'2',
                'consin_adr_company_id'=>$consignee,
                'cust_order_date'=>$this->common_model->change_date_format($this->input->post('po_date'),$this->session->userdata['logged_in']['company_id']),
                'property_id'=>$property,
                'for_export'=>$for_export,
                'for_sampling'=>$for_sampling,
                'country_id'=>$country[1],
                'currency_id'=>$currency[0],
                'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                'exchange_rate_date'=>$currency[2],
                'payment_condition_id'=>$this->input->post('payment_term'),
                'freight_type_id'=>$this->input->post('freight_type'));

              $result=$this->common_model->save('order_master',$data);


              $data=array(
                'order_no'=>$sales_order_no,
                'language_id'=>$this->session->userdata['logged_in']['language_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'lang_addi_info'=>$this->input->post('comment'));

              $result=$this->common_model->save('order_master_lang',$data);

              if($result){
                  $net_amount=0;
                  $total_quantity=0;
                  $total_amount=0;
                  $total_ttax_amount=0;
                  for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){

                    $amount=$this->input->post('quantity_'.$i.'')*$this->input->post('unit_rate_'.$i.'');
                    $item_code=explode('//',$this->input->post('product_name_'.$i.''));
                    $total_tax_amount=0;
                    $data['tax_grid']=$this->common_model->select_tax_record('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$this->input->post('tax_grid_'.$i.''));
                    if($data['tax_grid']==FALSE){
                        echo "No Record Found";
                      }else{

                        global $total_tax_amount;
                        $a=array();
                        $tax_amount=0;
                        $ta_amount=0;
                        foreach ($data['tax_grid'] as $tax_grid_row){
                          if($tax_grid_row->accu_flag==0 && $tax_grid_row->other_tax_code==''){ 
                            $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
                            foreach ($data['tax'] as $tax_value) {
                               $ta_amount=($amount/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']); 
                              }
                          }else{ 

                            $tax_structure_value=explode("|||",$tax_grid_row->other_tax_code);
                            count($tax_structure_value);
                            $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
                            foreach ($data['tax'] as $tax_value) {
                              foreach ($tax_structure_value as  $value) {
                                if($value=='basic'){}else{}
                               } 
                              $ta_amount=(($amount+$total_tax_amount)/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']);
                            }
                          }
                        array_push($a,$ta_amount);
                        $total_tax_amount +=$ta_amount;
                        }
                        implode("|",$a);
                      }


                      $unit_tax=$total_tax_amount/$this->input->post('quantity_'.$i.'');
                      $calc_sell_price=$unit_tax+$this->input->post('unit_rate_'.$i.'');
                      $total_selling_price=$amount+$total_tax_amount;



                      $bom_final_nonapproved_version_no=$this->artwork_model->select_artwork_final_version('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','bom_creation_date','desc','bom_no','desc','bom_version_no','desc');

                      $bom_final_version_no=$this->artwork_model->select_artwork_final_version('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','bom_creation_date','desc','bom_no','desc','bom_version_no','desc');

                      if($bom_final_nonapproved_version_no==FALSE){
                        $nonapproved_bom_version=0;
                        $specification_no="";
                        $specification_version_no="";
                        }else{
                        foreach($bom_final_nonapproved_version_no as $bom_final_nonapproved_version_no_row){
                         $nonapproved_bom_version=$bom_final_nonapproved_version_no_row->bom_version_no;
                        }
                      }

                      if($bom_final_version_no==FALSE){
                        $approved_bom_version=0;
                        $specification_no="";
                        $specification_version_no="";
                        }else{
                        foreach ($bom_final_version_no as $bom_final_version_no_row){
                          $approved_bom_version=$bom_final_version_no_row->bom_version_no;
                        }     
                      }

                      if($nonapproved_bom_version>$approved_bom_version){
                        $specification_no="";
                        $specification_version_no="";
                          echo '<script language="javascript">alert("Final Bill of material is in Process")</script>';
                        }else{

                          if($bom_final_version_no==FALSE){

                          }else{
                            foreach ($bom_final_version_no as $bom_final_version_no_row){
                              $specification_no=$bom_final_version_no_row->bom_no;
                              $specification_version_no=$bom_final_version_no_row->bom_version_no;
                            }     
                        }

                      }



                      $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                     
                      if($data['artwork_final_nonapproved_version_no']==FALSE){
                        $nonapproved_version=0;
                      }else{
                      foreach ($data['artwork_final_nonapproved_version_no'] as $artwork_final_nonapproved_version_no_row){

                              $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
                        }
                      } 

                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                      
                      if($data['artwork_final_version_no']==FALSE){
                        $artwork_no='';
                        $artwork_version_no='';
                        $approved_version=0;

                      }else{
                        foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                           $artwork_no=$artwork_final_version_no_row->ad_id;
                           $approved_version=$artwork_final_version_no_row->version_no;
                          }
                      }
                      

                      if($nonapproved_version>$approved_version){
                        $artwork_no="";
                        $artwork_version_no="";
                        echo '<script language="javascript">alert("Final Artwork Version is in Process")</script>';
                      }else{

                        if($data['artwork_final_version_no']==FALSE){
                          $artwork_no='';
                          $artwork_version_no='';
                          $approved_version=0;
                        }else{
                          foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                            $artwork_no=$artwork_final_version_no_row->ad_id;
                            $artwork_version_no=$artwork_final_version_no_row->version_no;
                          }     
                      }
                    }


                       //$dataa=array('article_no'=>$item_code[1],
                        //'final_approval_flag'=>'1');
                      //$data['bom_no_result']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$dataa);
                      /*$data['bom_no_result']=$this->artwork_model->select_artwork_final_version('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','bom_creation_date','desc','bom_no','desc','bom_version_no','desc');
                      if($data['bom_no_result']==FALSE){
                        $specification_no='';
                        $specification_version_no='';
                         }else{
                        foreach ($data['bom_no_result'] as $bom_no_row){
                           $specification_no=$bom_no_row->bom_no;
                           $specification_version_no=$bom_no_row->bom_version_no;
                          }
                      }
          

                      /*

                      $data['specification_final_version_no']=$this->specification_model->select_specification_final_version('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','spec_created_date','desc');

                      if($data['specification_final_version_no']==FALSE){
                        $specification_no='';
                        $specification_version_no='';
                        $article_no='';
                        $artwork_version_no='';

                      }else{
                        foreach ($data['specification_final_version_no'] as $specification_final_version_no_row){
                           $specification_no=$specification_final_version_no_row->spec_id;
                           $specification_version_no=$specification_final_version_no_row->spec_version_no;
                           $article_no=$specification_final_version_no_row->ad_id;
                           $artwork_version_no=$specification_final_version_no_row->version_no;
                          }
                      }
                      */

                       

                      $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'order_no'=>$sales_order_no,
                        'ord_pos_no'=>$i,
                        'article_no'=>$item_code[1],
                        'delivery_date'=>$this->input->post('delivery_date_'.$i.''),
                        'total_order_quantity'=>$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'selling_price'=>$this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'total_selling_price'=>$this->common_model->save_number($total_selling_price,$this->session->userdata['logged_in']['company_id']),
                        'tax_pos_no'=>$this->input->post('tax_grid_'.$i.''),
                        'description'=>$item_code[0],
                        'tax_grid_amount'=>implode("|",$a),
                        'total_tax'=>$this->common_model->save_number($total_tax_amount,$this->session->userdata['logged_in']['company_id']),
                        'calc_sell_price'=>$calc_sell_price,
                        'unit_tax'=>$unit_tax,
                        'spec_id'=>$specification_no,
                        'spec_version_no'=>$specification_version_no,
                        'ad_id'=>$artwork_no,
                        'version_no'=>$artwork_version_no);

                       $result=$this->common_model->save('order_details',$data);
                       $net_amount+=$amount;
                       $total_quantity+=$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']);
                       $total_ttax_amount+=$total_tax_amount;

                  }
                  $total_amount=$net_amount+$total_ttax_amount;
                  $data=array('total_value'=>$this->common_model->save_number($net_amount,$this->session->userdata['logged_in']['company_id']),
                    'total_tax'=>$this->common_model->save_number($total_ttax_amount,$this->session->userdata['logged_in']['company_id']),
                    'total_amount'=>$this->common_model->save_number($total_amount,$this->session->userdata['logged_in']['company_id']));
                  $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$sales_order_no,$this->session->userdata['logged_in']['company_id']);
                }

                if(!empty($this->input->post('approval_authority'))){

                  $data=array('pending_flag'=>'1');
                    $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$sales_order_no,$this->session->userdata['logged_in']['company_id']);

                  $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$sales_order_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {
                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'75',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$sales_order_no,
                        );

                      $result=$this->common_model->save('followup',$data);
                  }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');
              $data['note']='Create Transaction Completed';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
              
            }
          }else{
            $data['note']='No New rights Thanks';
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



  function modify(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            $data=array('user_id'=>$this->session->userdata['logged_in']['user_id'],
              'final_approval_flag'=>'0',
              'pending_flag'=>'0',
              'order_no'=>$this->uri->segment(3));
            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$this->uri->segment(3));

            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.master_property_id','1');
            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');
            $data['payment_term']=$this->customer_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
           $data['freight_type']=$this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang',$this->session->userdata['logged_in']['language_id']);



            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function update(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean');
            $this->form_validation->set_rules('po_no','Customer Purchase Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('po_date','Customer Purchase Order Date' ,'required|trim|xss_clean|max_length[10]');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('product_name_'.$i.'','Product Name '.$i.'' ,'required|trim|xss_clean|strtoupper|callback_article_check');
              $this->form_validation->set_rules('quantity_'.$i.'','Quantity '.$i.'' ,'required|trim|xss_clean|max_length[20]|is_natural_no_zero');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit rate '.$i.'' ,'required|trim|xss_clean|max_length[20]|numeric');
              $this->form_validation->set_rules('amount_'.$i.'','Amount '.$i.'' ,'required|trim|xss_clean|max_length[20]|numeric');
              $this->form_validation->set_rules('tax_grid_'.$i.'','Tax '.$i.'' ,'required|trim|xss_clean');

            }


            if($this->form_validation->run()==FALSE){

            $data=array('order_no'=>$this->input->post('order_no'));
            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('order_no'));

            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.master_property_id','1');
            
            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

            $data['payment_term']=$this->customer_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
           $data['freight_type']=$this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang',$this->session->userdata['logged_in']['language_id']);

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

            if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                echo $customer_arr[1];
                $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);

              }

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('adr_company_id'))){
                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                echo $customer_arr[1];
                $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                foreach ($data['customer'] as $customer) {
                  $property=$customer->property_id;
                }
              }


              if(!empty($this->input->post('consin_adr_company_id'))){
                $data['consignee']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->input->post('consin_adr_company_id'));
                foreach ($data['consignee'] as $consignee) {
                  $consignee_property=$consignee->property_id;
                  $consignee=$consignee->adr_company_id."|".$consignee->property_id;
                }
              }else{
                $consignee='';
              }


              $for_export = (!empty($this->input->post('export'))) ? $this->input->post('export') : 0;
              $for_sampling = (!empty($this->input->post('for_sampling'))) ? $this->input->post('for_sampling') : 0;
              if(!empty($this->input->post('currency'))){
                $country=explode('|',$this->input->post('currency'));
                $currency=explode('|',$this->input->post('exchange_rate'));
              }else{
                $country[1]='';
                $currency[0]='';
                $currency[1]='';
                $currency[2]='';
              }
              
              $data=array(
                'order_no'=>$this->input->post('order_no'),
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'cust_order_no'=>$this->input->post('po_no'),
                'archive'=>'0',
                'customer_no'=>$customer_arr[1],
                'order_type'=>'2',
                'consin_adr_company_id'=>$consignee,
                'cust_order_date'=>$this->common_model->change_date_format($this->input->post('po_date'),$this->session->userdata['logged_in']['company_id']),
                'property_id'=>$property,
                'for_export'=>$for_export,
                'for_sampling'=>$for_sampling,
                'country_id'=>$country[1],
                'currency_id'=>$currency[0],
                'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                'exchange_rate_date'=>$currency[2],
                'freight_type_id'=>$this->input->post('freight_type'),
                'payment_condition_id'=>$this->input->post('payment_term'));

              $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);

               $dataa=array(
                'lang_addi_info'=>$this->input->post('comment'),
                'company_id'=>$this->session->userdata['logged_in']['company_id']);

               $result=$this->common_model->update_one_active_record('order_master_lang',$dataa,'order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);

              if($result){
                  $result=$this->common_model->delete_one_active_record('order_details','order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);
                  $net_amount=0;
                  $total_quantity=0;
                  $total_amount=0;
                  $total_ttax_amount=0;
                  for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){

                    $amount=$this->input->post('quantity_'.$i.'')*$this->input->post('unit_rate_'.$i.'');
                    $item_code=explode('//',$this->input->post('product_name_'.$i.''));
                    $total_tax_amount=0;
                    $data['tax_grid']=$this->common_model->select_tax_record('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$this->input->post('tax_grid_'.$i.''));
                    if($data['tax_grid']==FALSE){
                        echo "No Record Found";
                      }else{

                        global $total_tax_amount;
                        $a=array();
                        $tax_amount=0;
                        $ta_amount=0;
                        foreach ($data['tax_grid'] as $tax_grid_row){
                          if($tax_grid_row->accu_flag==0 && $tax_grid_row->other_tax_code==''){ 
                            $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
                            foreach ($data['tax'] as $tax_value) {
                               $ta_amount=($amount/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']); 
                              }
                          }else{ 

                            $tax_structure_value=explode("|||",$tax_grid_row->other_tax_code);
                            count($tax_structure_value);
                            $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
                            foreach ($data['tax'] as $tax_value) {
                              foreach ($tax_structure_value as  $value) {
                                if($value=='basic'){}else{}
                               } 
                              $ta_amount=(($amount+$total_tax_amount)/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']);
                            }
                          }
                        array_push($a,$ta_amount);
                        $total_tax_amount +=$ta_amount;
                        }
                        implode("|",$a);
                      }


                      $unit_tax=$total_tax_amount/$this->input->post('quantity_'.$i.'');
                      $calc_sell_price=$unit_tax+$this->input->post('unit_rate_'.$i.'');
                      $total_selling_price=$amount+$total_tax_amount;

                      $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                     
                      if($data['artwork_final_nonapproved_version_no']==FALSE){
                        $nonapproved_version=0;
                      }else{
                      foreach ($data['artwork_final_nonapproved_version_no'] as $artwork_final_nonapproved_version_no_row){

                              $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
                        }
                      } 

                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                      
                      if($data['artwork_final_version_no']==FALSE){
                        $artwork_no='';
                        $artwork_version_no='';
                        $approved_version=0;

                      }else{
                        foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                           $artwork_no=$artwork_final_version_no_row->ad_id;
                           $approved_version=$artwork_final_version_no_row->version_no;
                          }
                      }
                      

                      if($nonapproved_version>$approved_version){
                        $artwork_no="";
                        $artwork_version_no="";
                        echo '<script language="javascript">';
                        echo 'alert("Final Artwork Version '.$artwork_final_version_no_row->ad_id."_R".$nonapproved_version.' in Process")';
                        echo '</script>';
                      }else{

                        if($data['artwork_final_version_no']==FALSE){
                          $artwork_no='';
                          $artwork_version_no='';
                          $approved_version=0;
                        }else{
                          foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                            $artwork_no=$artwork_final_version_no_row->ad_id;
                            $artwork_version_no=$artwork_final_version_no_row->version_no;
                          }     
                      }
                    }



                       //$dataa=array('article_no'=>$item_code[1],
                        //'final_approval_flag'=>'1');
                      //$data['bom_no_result']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$dataa);
                      $data['bom_no_result']=$this->artwork_model->select_artwork_final_version('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','bom_creation_date','desc','bom_no','desc','bom_version_no','desc');
                      
                      if($data['bom_no_result']==FALSE){
                        $specification_no='';
                        $specification_version_no='';
                         }else{
                        foreach ($data['bom_no_result'] as $bom_no_row){
                           $specification_no=$bom_no_row->bom_no;
                           $specification_version_no=$bom_no_row->bom_version_no;
                          }
                      }
          

                      

                      $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'order_no'=>$this->input->post('order_no'),
                        'ord_pos_no'=>$i,
                        'article_no'=>$item_code[1],
                        'total_order_quantity'=>$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'selling_price'=>$this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'total_selling_price'=>$this->common_model->save_number($total_selling_price,$this->session->userdata['logged_in']['company_id']),
                        'tax_pos_no'=>$this->input->post('tax_grid_'.$i.''),
                        'description'=>$item_code[0],
                        'tax_grid_amount'=>implode("|",$a),
                        'total_tax'=>$this->common_model->save_number($total_tax_amount,$this->session->userdata['logged_in']['company_id']),
                        'calc_sell_price'=>$calc_sell_price,
                        'unit_tax'=>$unit_tax,
                        'spec_id'=>$specification_no,
                        'spec_version_no'=>$specification_version_no,
                        'ad_id'=>$artwork_no,
                        'version_no'=>$artwork_version_no);

                       $result=$this->common_model->save('order_details',$data);

                       $net_amount+=$amount;
                       $total_quantity+=$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']);
                       $total_ttax_amount+=$total_tax_amount;

                  }
                  $total_amount=$net_amount+$total_ttax_amount;
                  $data=array('total_value'=>$this->common_model->save_number($net_amount,$this->session->userdata['logged_in']['company_id']),
                    'total_tax'=>$this->common_model->save_number($total_ttax_amount,$this->session->userdata['logged_in']['company_id']),
                    'total_amount'=>$this->common_model->save_number($total_amount,$this->session->userdata['logged_in']['company_id']));
                  $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);
                }

                if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('order_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'75',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('order_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                $data=array('order_no'=>$this->input->post('order_no'));
                $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
                $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('order_no'));

                $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.master_property_id','1');
                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['tax_grid']=$this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');
                $data['payment_term']=$this->customer_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
                $data['freight_type']=$this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang',$this->session->userdata['logged_in']['language_id']);

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');


                $data['note']='Update Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
              
            }
          }else{
            $data['note']='No New rights Thanks';
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

    function archive_records(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='order_master';
            include('pagination_archive.php');
            
            $from="2018-04-01";
            $to=date('Y-m-d');
            $search="";
            $data['order_master']=$this->sales_order_book_model->archive_record_search($config["per_page"],$this->uri->segment(3),'order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
           
                 
            $data['tax_header']=$this->sales_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
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
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }



  function view(){

    $order_no=$this->uri->segment(3);
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['order_master']=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);

            //echo $this->db->last_query();

            $data['order_details']=$this->sales_order_book_model->active_details_records('order_details',array('order_no'=>$order_no),$this->session->userdata['logged_in']['company_id']);

            //--------Eknath   Specification and Artwork---------------------------------------------------
              $spec_id='';
              $spec_version_no='';
              $ad_id='';
              $version_no='';
              $cap_article_no='';
              foreach ($data['order_details'] as  $row) {
                $spec_id=$row->spec_id;
                $spec_version_no=$row->spec_version_no;
                $ad_id=$row->ad_id;
                $version_no=$row->version_no;


                if(strtoupper(substr($row->article_no,0,4))=='CAPS'){
                  $cap_article_no=$row->article_no;
                }
              }

            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$ad_id,'artwork_devel_master.version_no',$version_no);           


            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_id,'specification_sheet.spec_version_no',$spec_version_no);

            //SPECIFICATION SHEET--------

            if($data['specification']){

              $spec_lang=array();
              $spec_lang['spec_id']=$spec_id;
              $spec_lang['spec_version_no']=$spec_version_no;

              $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);

              //echo $this->db->last_query();
             
              $data['specification_sleeve_details']=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$spec_id,'specification_sheet_details.spec_version_no',$spec_version_no,'item_group_id','3','srd_id','asc');

              $data['specification_shoulder_details']=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$spec_id,'specification_sheet_details.spec_version_no',$spec_version_no,'item_group_id','4','srd_id','asc');

              $data['specification_cap_details']=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$spec_id,'specification_sheet_details.spec_version_no',$spec_version_no,'item_group_id','5','srd_id','asc');
            }
            else{ 
              //BOM DETAILS------------------------

                $bom=array();
                $bom['bom_no']=$spec_id;
                $bom['bom_version_no']=$spec_version_no;

                $data['bill_of_material']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom);

                if($data['bill_of_material']){


                foreach($data['bill_of_material'] as $bill_of_material_row){
                  $bom_no=$bill_of_material_row->bom_no;
                  $bom_version_no=$bill_of_material_row->bom_version_no;
                  $sleeve_code=$bill_of_material_row->sleeve_code;
                  $shoulder_code=$bill_of_material_row->shoulder_code;
                  $cap_code=$bill_of_material_row->cap_code;
                  $label_code=$bill_of_material_row->label_code;
                }


                $data['sleeve_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
                foreach($data['sleeve_code'] as $sleeve_code_row){
                  $sleeve_specs_no=$sleeve_code_row->spec_id;
                  $sleeve_specs_version_no=$sleeve_code_row->spec_version_no;

                  $data['sleeve_specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$sleeve_specs_no,'specification_sheet.spec_version_no',$sleeve_specs_version_no);

                  
                  $data['specification_sleeve_details']=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs_no,'specification_sheet_details.spec_version_no',$sleeve_specs_version_no,'item_group_id','3','srd_id','asc');
                }


                $data['shoulder_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
                foreach($data['shoulder_code'] as $shoulder_code_row){
                  $shoulder_specs_no=$shoulder_code_row->spec_id;
                  $shoulder_specs_version_no=$shoulder_code_row->spec_version_no;

                  $data['shoulder_specification']=$this->shoulder_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$shoulder_specs_no,'specification_sheet.spec_version_no',$shoulder_specs_version_no);

                
                  $data['specification_shoulder_details']=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$shoulder_specs_no,'specification_sheet_details.spec_version_no',$shoulder_specs_version_no,'item_group_id','4','srd_id','asc');
                }


                $data['label_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$label_code);
                if($data['label_code']==FALSE){
                  $data['label_specification']="";
                  $data['specification_label_details']="";
                }else{
                  foreach($data['label_code'] as $label_code_row){

                    $label_specs_no=$label_code_row->spec_id;
                    $label_specs_version_no=$label_code_row->spec_version_no;

                    $data['label_specification']=$this->label_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$label_specs_no,'specification_sheet.spec_version_no',$label_specs_version_no);

                    $data['specification_label_details']=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$label_specs_no,'specification_sheet_details.spec_version_no',$label_specs_version_no,'item_group_id','6','srd_id','asc');
                  }
                }


                $data['cap_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
                foreach($data['cap_code'] as $cap_code_row){

                  $cap_specs_no=$cap_code_row->spec_id;
                  $cap_specs_version_no=$cap_code_row->spec_version_no;

                  $data['cap_specification']=$this->cap_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$cap_specs_no,'specification_sheet.spec_version_no',$cap_specs_version_no);

                  $data['specification_cap_details']=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$cap_specs_no,'specification_sheet_details.spec_version_no',$cap_specs_version_no,'item_group_id','5','srd_id','asc');
                }

                
              


                $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$bom_no.'@@@'.$bom_version_no);
                }
          }

           //---------------------------CAP SPECIFICATIONN IN SALES ORDER VIEW-----------------
              
                if($cap_article_no!=''){
                  
                  $data['cap_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_article_no);
                  foreach($data['cap_code'] as $cap_code_row){

                    $cap_specs_no=$cap_code_row->spec_id;
                    $cap_specs_version_no=$cap_code_row->spec_version_no;

                    $data['cap_specification']=$this->cap_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$cap_specs_no,'specification_sheet.spec_version_no',$cap_specs_version_no);
                    //print_r($data['cap_specification']);

                    $data['specification_cap_details']=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$cap_specs_no,'specification_sheet_details.spec_version_no',$cap_specs_version_no,'item_group_id','5','srd_id','asc');
                  }

                }              

          //------------------------------------------------------
            $this->load->model('tax_grid_model');
            $data['tax_master']=$this->tax_grid_model->select_sales_order_tax_grid($order_no);

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$order_no);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



   

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
      $data=array('address_master.adr_company_id'=>$customer_code[1],
        'address_master.name1'=>$customer_code[0]);
    $data['customer']=$this->customer_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    foreach ($data['customer'] as $customer_row) {

      if ($customer_row->adr_company_id == $customer_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
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
      $data['note']='No View rights Thanks';
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Company Name' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Contract Packer' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('order_no','Sales order' ,'trim|xss_clean');
            $this->form_validation->set_rules('cust_order_no','Customer Po. No' ,'trim|xss_clean');
            $this->form_validation->set_rules('cust_order_date','Customer Po. Date' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Order Type' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_sampling','For Sample' ,'trim|xss_clean');
            $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_closed','Order Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('trans_closed','Transaction Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Creaed By' ,'trim|xss_clean');

            $arr_input=array_filter($this->input->post(),'strlen');
            if(empty($arr_input)){
              $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');

            }
            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }
               $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
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

                  $for_export=$this->input->post('for_export');
                  $for_sampling=$this->input->post('for_sampling');
                  $final_approval_flag=$this->input->post('final_approval_flag');
                  $order_closed=$this->input->post('order_closed');
                  $trans_closed=$this->input->post('trans_closed');
                  
                  $search=array();
                  
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['customer_no']=$arr[1];
                  }
                  if(!empty($this->input->post('consin_adr_company_id'))){
                     $arr=explode('//',$this->input->post('consin_adr_company_id'));
                     $consignee=$arr[1].'|';
                     $search['consin_adr_company_id']=$consignee;
                  }
                  if(!empty($this->input->post('order_no'))){
                     $search['order_no']=$this->input->post('order_no');
                  }
                  if(!empty($this->input->post('cust_order_no'))){
                     $search['cust_order_no']=$this->input->post('cust_order_no');
                  }
                  if(!empty($this->input->post('cust_order_date'))){
                     $search['cust_order_date']=$this->input->post('cust_order_date');
                  }
                  if($for_export!=''){
                      $search['for_export']=$for_export;
                  }
                  if($for_sampling!=''){
                      $search['for_sampling']=$for_sampling;
                  }
                  if($final_approval_flag!=''){
                      $search['final_approval_flag']=$final_approval_flag;
                  }
                  if($order_closed!=''){
                      $search['order_closed']=$order_closed;
                  }
                  if($trans_closed!=''){
                      $search['trans_closed']=$trans_closed;
                  }
                  if(!empty($this->input->post('user_id'))){
                     $search['user_id']=$this->input->post('user_id');
                  }
                  
                               

                $data['order_master']=$this->sales_order_book_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();
                 
                $data['tax_header']=$this->sales_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                 
                 
                if($data['order_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                    $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                    

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                      $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                      
                      $data['error']='No record in search transaction';
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');
                  }
                
            }

          }else{
                  $data['page_name']='home';
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


  function save_job_card(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('job_card_quantity','Job Card Quantity' ,'required|trim|xss_clean|max_length[15]|numeric');
            $this->form_validation->set_rules('spec_id','Specification No' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){

              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed'=>'0');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('order_no'=>$this->input->post('order_no'),
              'article_no'=>$this->input->post('article_no'));

              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-job-card-form',$data);
              $this->load->view('Home/footer');
            }else{


              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1032');

              foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                foreach($data['account_periods'] as $account_periods_row){
                  $start=date('y', strtotime($account_periods_row->fin_year_start));
                  $end=date('y', strtotime($account_periods_row->fin_year_end));
                }

                $jobcard_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$auto_row->curr_val;
                $next_jobcard_no=$auto_row->curr_val+1;
              }
              $data=array('curr_val'=>$next_jobcard_no);
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1032',$this->session->userdata['logged_in']['company_id']);

              $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_no'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
              foreach($data['specification'] as $specification_row){
                $no_of_layer=substr($specification_row->dyn_qty_present,strpos($specification_row->dyn_qty_present,"|")+1,1);
              }

              $data['max']=$this->common_model->select_max_pkey_numeric('production_master','manu_order_no',$this->session->userdata['logged_in']['company_id']);
              foreach($data['max'] as $max_value){
                $manu_order_no=$max_value->manu_order_no+1;
              }

              $data=array('manu_order_no'=>$manu_order_no,
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'mp_pos_no'=>$jobcard_no,
                'article_no'=>$this->input->post('article_no'),
                'mp_qty'=>$this->common_model->save_number($this->input->post('order_qty'),$this->session->userdata['logged_in']['company_id']),
                'actual_qty_manufactured'=>$this->common_model->save_number($this->input->post('job_card_quantity'),$this->session->userdata['logged_in']['company_id']),
                'manu_plan_date'=>date('Y-m-d'),
                'employee_id'=>$this->session->userdata['logged_in']['user_id'],
                'sales_ord_no'=>$this->input->post('order_no'),
                'ord_pos_no'=>$this->input->post('ord_pos_no')
                );

              $result=$this->common_model->save('production_master',$data);


               $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','3','parameter_name','DIA','srd_id','asc','layer_no','asc');
                foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                  $dia=rtrim($specification_sleeve_details_row->relating_master_value," MM");
                }

                $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','3','parameter_name','LENGTH','srd_id','asc','layer_no','asc');

                foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){

                  $length=rtrim($specification_sleeve_details_row->parameter_value,"MM");
                  $length=$length+3;
                }

                $pi=3.14159;
                $density=0.92;
                $rejection=5;



            for($i=1;$i<=$no_of_layer;$i++){

              $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','3','layer_no',$i,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
              foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                
              }
                $sleeve_weight=((((($dia*$length*$gauge*$pi*$density)/1000000)*$rejection/100)+(($dia*$length*$gauge*$pi*$density)/1000000))/1000)*$this->input->post('job_card_quantity');
                $sleeve_weight=$sleeve_weight/100;

              $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','3','material','1','layer_no',$i,'srd_id','asc','layer_no','asc');
              
              
              foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                if(!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)){
                  echo $specification_sleeve_details_row->mat_article_no." ".rtrim($specification_sleeve_details_row->mat_info,"%");
                  echo $rm_qty=round($sleeve_weight*rtrim($specification_sleeve_details_row->mat_info,"%"),2);
                  echo "<br/>";

                  $data=array('manu_order_no'=>$jobcard_no,
                    'article_no'=>$specification_sleeve_details_row->mat_article_no,
                    'demand_qty'=>$this->common_model->save_number($rm_qty,$this->session->userdata['logged_in']['company_id']),
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'work_proc_no'=>'1',
                    'from_job_card'=>'1',
                    'rel_demand_qty'=>$this->common_model->save_number($rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                    'flag_uom_type'=>'1',
                    'rel_uom_id'=>'UOM013');
                  $this->common_model->save('material_manufacturing',$data);                  


                }

              }

            }

            $data=array('sleeve_diameter'=>$dia);
            $data['sleeve_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],$data);
            foreach($data['sleeve_details'] as $sleeve_details_row){
              $sleeve_id=$sleeve_details_row->sleeve_id;
            }

            $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','4','parameter_name','NECK TYPE','srd_id','asc','layer_no','asc');
            foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){
              $shoulder=$specification_shoulder_details_row->relating_master_value;
            }
             

            $data=array('shoulder_type'=>$shoulder);
            $data['shoulder_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],$data);
            foreach($data['shoulder_details'] as $shoulder_details_row){
              $shoulder_id=$shoulder_details_row->shld_type_id;
            }


            $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','4','parameter_name','ORIFICE','srd_id','asc','layer_no','asc');
            foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){
              $shoulder_orifice=$specification_shoulder_details_row->relating_master_value;
            }

            $data=array('shoulder_orifice'=>$shoulder_orifice);
            $data['shoulder_orifice_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],$data);
            foreach($data['shoulder_orifice_details'] as $shoulder_orifice_details_row){
              $orifice_id=$shoulder_orifice_details_row->orifice_id;
            }

            $data=array('sleeve_id'=>$sleeve_id,
              'shld_type_id'=>$shoulder_id,
              'shld_orifice_id'=>$orifice_id);

            $data['shoulder_weight_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$data);
            foreach($data['shoulder_weight_details'] as $shoulder_weight_details_row){
              $shoulder_weight=$shoulder_weight_details_row->shld_weight;
            }

            $shoulder_rejection=20; 
            $shoulder_weight=(($shoulder_weight+(($shoulder_weight/100)*$shoulder_rejection))/1000);


            $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','4','material','1','layer_no','1','srd_id','asc','layer_no','asc');
              
              
              foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){

                if(!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)){
                  echo $specification_shoulder_details_row->mat_article_no." ".rtrim($specification_shoulder_details_row->mat_info,"%");
                  echo $rm_qty=round($shoulder_weight*rtrim($specification_shoulder_details_row->mat_info,"%"),2);
                   echo "<br/>";

                  $data=array('manu_order_no'=>$jobcard_no,
                    'article_no'=>$specification_shoulder_details_row->mat_article_no,
                    'demand_qty'=>$this->common_model->save_number($rm_qty,$this->session->userdata['logged_in']['company_id']),
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'work_proc_no'=>'1',
                    'from_job_card'=>'1',
                    'rel_demand_qty'=>$this->common_model->save_number($rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                    'flag_uom_type'=>'1',
                    'rel_uom_id'=>'UOM013');
                  $this->common_model->save('material_manufacturing',$data);                  


                }

              }



              /*$data['specification_shoulder_details']=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_id'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','4','srd_id','asc');

              $data['specification_cap_details']=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_id'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','5','srd_id','asc');
              */

              

              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());


              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed'=>'0');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('order_no'=>$this->input->post('order_no'),
              'article_no'=>$this->input->post('article_no'));



              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');
              $data['note']='Create Transaction Completed';

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-job-card-form',$data);
              $this->load->view('Home/footer');
              
              
            }
          }else{
            $data['note']='No New rights Thanks';
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


    public function customer_supplier_check($str){
      
      if($str!=''){

        $customer_supplier_code=explode('//',$str);
        if(!empty($customer_supplier_code[1])){
          $data['customer_supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_supplier_code[0]);
          foreach ($data['customer_supplier'] as $customer_supplier_row){

            if ($customer_supplier_row->adr_company_id == $customer_supplier_code[1]){
              return TRUE;
            }else{
              $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
              return FALSE;
            }

          } 
        }else{
            $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
            return FALSE;
        } 


      }
      
  }

   public function article_check($str){
      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'lang_article_description',$item_code[0]);
      //echo $this->db->last_query();

      foreach ($data['item'] as $item_row) {
        if ($item_row->article_no == $item_code[1]){
          return TRUE;
        }else{
          $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
          return FALSE;
          }
        } 
      }else{
          $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
          return FALSE;
        }
      } 
    }

  function job_card(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->uri->segment(3),
              'trans_closed'=>'0',
              'order_closed'=>'0');

            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);

            $dataa=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4),
              );



            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-job-card-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function show_open_transactions(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $table='order_master';

            $from="2017-07-01";
            $to=date('Y-m-d');
            $search['user_id']=$this->session->userdata['logged_in']['user_id'];
            $search['trans_closed']='0';


            $data['order_master']=$this->sales_order_book_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
           

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/open-transactions',$data);
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
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function close_transactions(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            if($data['module']!=FALSE){
                foreach ($data['module'] as $module_row) {
                  if($module_row->module_name==='Sales'){
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

                      foreach ($data['formrights'] as $formrights_row) {
                        if($formrights_row->modify==1){

                          if(count($this->input->post('order_no[]'))=='0' OR empty($this->input->post('order_no[]'))){
                              
                              $this->form_validation->set_rules('order_no[]',"Order no", "required|trim|xss_clean|");
                              $this->form_validation->run();
                          }
                          else{

                              $flag=0;
                              $order_no_arr=$this->input->post('order_no[]');
                             // echo count($order_no_arr);
                              for($i=0;$i<count($order_no_arr);$i++){

                                   $pkey=$order_no_arr[$i];
                                   if($pkey!=''){

                                      $data=array('trans_closed'=>'1');
                                        $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$pkey,$this->session->userdata['logged_in']['company_id']);
                                      if( $result==1){
                                        $flag=1;
                                        $data['note']='Transaction Closed';
                                         header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());


                                      }
                                   }
                              }

                          }

                        }


                        if($formrights_row->view==1){                          

                          $data['page_name']='Sales';
                          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

                          $from="2017-07-01";
                          $to=date('Y-m-d');
                          $search['user_id']=$this->session->userdata['logged_in']['user_id'];
                          $search['trans_closed']='0';

                          $data['order_master']=$this->sales_order_book_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                          //echo $this->db->last_query();
                         

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          //$this->load->view('Loading/loading');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/open-transactions',$data);
                          $this->load->view('Home/footer');
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
              }
              else{
                $data['note']='No View rights Thanks';
                $data['page_name']='home';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Error/error-title',$data);
                $this->load->view('Home/footer');
              }


  }

 
  public function export_to_excel(){

    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    if(empty($this->input->get('from_date')) && empty($this->input->get('to_date'))){
      echo 'From Date and To date Should not Blank';
    }
    else{

          $from=$this->common_model->change_date_format($this->input->get('from_date'),$this->session->userdata['logged_in']['company_id']);
          $to=$this->common_model->change_date_format($this->input->get('to_date'),$this->session->userdata['logged_in']['company_id']);
          $customer_no='';
          $consin_adr_company_id='';
          $order_no=$this->input->get('order_no');
          $for_export=$this->input->get('for_export');
          $for_sampling=$this->input->get('for_sampling');
          $final_approval_flag=$this->input->get('final_approval_flag');
          $order_closed=$this->input->get('order_closed');
          $trans_closed=$this->input->get('trans_closed');
          $cust_order_no=$this->input->get('cust_order_no');
          $cust_order_date=$this->input->get('cust_order_date');
          $user_id=$this->input->get('user_id');

          if(!empty($this->input->get('adr_company_id'))){
             $arr=explode('//',$this->input->get('adr_company_id'));
             $customer_no=$arr[1];
          }
          if(!empty($this->input->get('consin_adr_company_id'))){
             $arr=explode('//',$this->input->get('consin_adr_company_id'));
             $consignee=$arr[1].'|';
             $consin_adr_company_id=$consignee;
          }
                     
          $data=array(
          'customer_no'=>$customer_no,  
          'consin_adr_company_id'=>$consin_adr_company_id,
          'order_no'=>$order_no,
          'for_export'=>$for_export,
          'for_sampling'=>$for_sampling,
          'final_approval_flag'=>$final_approval_flag,
          'order_closed'=>$order_closed,
          'trans_closed'=>$trans_closed,
          'cust_order_no'=>$cust_order_no,
          'cust_order_date'=>$cust_order_date,
          'user_id'=>$user_id
          );

          $data_array = array_filter($data); 

          $data['order_master']=$this->sales_order_book_model->active_record_search('order_master',$data_array,$from,$to,$this->session->userdata['logged_in']['company_id']);           
          $data['tax_header']=$this->sales_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

          // echo $this->db->last_query();
          //  echo'<pre>';
          //  print_r($data['tax_header']);
          //  echo'</pre>';
          $header_row_styleArray = array(
          'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => 'FFFFFF'),
          'size'  => 14,
          'name'  => 'Calibri',
        ),
        
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        ),

        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      );

       $merge_cell_alignment = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      );

      // Hyperlink formating
      $link_style_array = [
        'font'  => [
          'color' => ['rgb' => '0000FF'],
          'underline' => 'single'
        ]

      ];



      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);

      // $ObjPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      // $ObjPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->getStartColor()->setARGB('1caf9a');
      // $ObjPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($header_row_styleArray);
      //   $ObjPHPExcel->getActiveSheet()->getColumnDimension(0)->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); //Auto width column
      // $ObjPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); //Auto width column
     
      $ObjPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); // Row height
      $ObjPHPExcel->getActiveSheet()->freezePane('A2'); // Freeze Pane
      //Write row in excel START------
      
      // Header Row Generation------------
      $header_row=1;
      $header_columns=array('Sr No.','Order No.','Order Date','Bill To','Bill To GSTIN','Ship To','Ship To GSTIN','PO No. / PO. Date','Currency','Exchange Rate','Article Code','Article Name','Delivery Date','Spec','Artwork','Layer','Dia','Length','Print Type','Shoulder Type','Shoulder Orifice','Cap Dia','Cap Type','Cap Finish','Cap Orifice','Quantity','Unit rate','Net Amount','Total Tax');

      for($header_column_index=0;$header_column_index<count($header_columns);$header_column_index++){

         $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($header_column_index,$header_row,$header_columns[$header_column_index]);
      }

      
      // Tax Header Generation -------------------------------------------------------------      
       foreach ($data['tax_header'] as $trow){
         $key=$trow->lang_tax_code_desc;
         $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($header_column_index++,$header_row,$key);        
       }

       // Header Row Generation After Tax-------------

       $header_columns1=array('Gross Amount','Created By','Approved By','Approval Date','Order Type','Is Sample','Order Status','Comments');
      for($i=0;$i<count($header_columns1);$i++){
         $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($header_column_index++,$header_row,$header_columns1[$i]);
      }
      // Data in Excel---------------------------------

      $sr_no=1;
      
      $excel_sheet_row = 2;
      foreach ($data['order_master'] as $key => $order_master_row) {
        $row_column_index=0;
        // SHIP TO DETAILS----------------------------
        $ship_to='';
        $ship_to_gst='';
        if($order_master_row->consin_adr_company_id!=''){
          $arr=explode("|",$order_master_row->consin_adr_company_id);
          $consignee=$arr[0];
          $result_consignee=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
          foreach ($result_consignee as $row_consignee){
            $ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
            $ship_to_gst=$row_consignee->isdn_local;
          }
        }
        else{
          $ship_to=$order_master_row->name1." (".strtoupper($order_master_row->lang_property_name).")";
        }
        // CURRENCY DETAILS-------------------------------
        $currency=($order_master_row->currency_id!='' ? $order_master_row->currency_id:'');
        $exchange_rate=($order_master_row->exchange_rate!='0' ?number_format($this->common_model->read_number($order_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');

        $row_arr=array();
        $article_no='';
        if(!empty($this->input->get('article_no'))){
          $arr=explode("//",$this->input->get('article_no'));
          $article_no=$arr[1];
          
        }
        $details_array=array('order_no'=>$order_master_row->order_no,
                            'article_no'=>$article_no
                            );
        $details_data=array_filter($details_array);
        
        $data['order_details']=$this->sales_order_book_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);

        $detail_count=count($data['order_details']);
        $merge_row_counter=($detail_count > 1?$detail_count-1:0);

        // $ObjPHPExcel->getActiveSheet()->getStyle('A'.($row).':A'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('B'.($row).':B'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('C'.($row).':C'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('D'.($row).':D'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('E'.($row).':E'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('F'.($row).':F'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('G'.($row).':G'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('H'.($row).':H'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('I'.($row).':I'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('J'.($row).':J'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);
        // $ObjPHPExcel->getActiveSheet()->getStyle('K'.($row).':K'.($row+$merge_row_counter))->applyFromArray($merge_cell_alignment);

        $ObjPHPExcel->getActiveSheet()->mergeCells('A'.($excel_sheet_row).':A'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('B'.($excel_sheet_row).':B'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('C'.($excel_sheet_row).':C'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('D'.($excel_sheet_row).':D'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('E'.($excel_sheet_row).':E'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('F'.($excel_sheet_row).':F'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('G'.($excel_sheet_row).':G'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('H'.($excel_sheet_row).':H'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('I'.($excel_sheet_row).':I'.($excel_sheet_row+$merge_row_counter));
        $ObjPHPExcel->getActiveSheet()->mergeCells('J'.($excel_sheet_row).':J'.($excel_sheet_row+$merge_row_counter));
        //$ObjPHPExcel->getActiveSheet()->mergeCells('K'.($row).':K'.($row+$merge_row_counter));

        
       // $ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$row, $i++);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $sr_no);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $order_master_row->order_no);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, date('d-M-Y', strtotime($order_master_row->order_date)));
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $order_master_row->name1." (".strtoupper($order_master_row->lang_property_name).")");
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $order_master_row->isdn_local);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $ship_to);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $ship_to_gst);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $order_master_row->cust_order_no.' / '.$this->common_model->view_date($order_master_row->cust_order_date,$this->session->userdata['logged_in']['company_id']));
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $currency);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, $exchange_rate);

        
        // Details for each-------------------
        $r=0;
        foreach ($data['order_details']as $key => $order_details_row){
          
          // Article Name--------------------
          $article_name=$this->common_model->get_article_name($order_details_row->article_no,$this->session->userdata['logged_in']['company_id']);
          // Specification Details------------          
          $dia='';  
          $length='';
          $print_type_artwork='';
          $print_type_bom='';
          $layer_no='';
          $shoulder_type='';
          $shoulder_orifice='';
          $shoulder_foil='';
          $cap_dia='';
          $cap_type='';
          $cap_finish='';
          $cap_orifice='';

          //ARTWORK DEATILS--------

          if(!empty($order_details_row->ad_id)){
            $artwork['ad_id']=$order_details_row->ad_id;
            $artwork['version_no']=$order_details_row->version_no;
            $search='';
            $from='';
            $to='';
            $artwork_result=$this->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
            foreach ($artwork_result as $artwork_row) {
              $print_type_artwork=$artwork_row->print_type;
            }

          }

          $artwork['ad_id']=$order_details_row->ad_id;
          $artwork['version_no']=$order_details_row->version_no;

          // SLEEVE DETAILS------------

          if(!empty($order_details_row->spec_id)){

            // If Exist in Specification master--------- 

            $specs['spec_id']=$order_details_row->spec_id;
            $specs['spec_version_no']=$order_details_row->spec_version_no;

            $specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
            if($specs_master_result){
                foreach($specs_master_result as $specs_master_result_row){
                  $layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
                  $layer_no=substr($layer_arr[1],0,1);              

                }
              $specs_details_result=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
              if($specs_details_result){
                foreach($specs_details_result as $specs_details_row){
                  $dia=$specs_details_row->SLEEVE_DIA;
                  $length=$specs_details_row->SLEEVE_LENGTH;
                  $shoulder_type=$specs_details_row->SHOULDER_NECK_TYPE;
                  $shoulder_orifice=$specs_details_row->SHOULDER_ORIFICE;
                  $shoulder_foil=$specs_details_row->SHOULDER_FOIL_TAG;
                  $cap_dia=$specs_details_row->CAP_DIA;
                  $cap_type=$specs_details_row->CAP_STYLE;
                  $cap_finish=$specs_details_row->CAP_MOLD_FINISH;
                  $cap_orifice=$specs_details_row->CAP_ORIFICE;                   

                }
              } 

              }else{

                // Else in BOM DEATILS-------

                $bom_data['bom_no']=$order_details_row->spec_id;
                $bom_data['bom_version_no']=$order_details_row->spec_version_no;

                $bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
                if($bom_result){

                  foreach($bom_result as $bom_result_row){                    
                    $sleeve_code=$bom_result_row->sleeve_code;
                    $shoulder_code=$bom_result_row->shoulder_code;
                    $cap_code=$bom_result_row->cap_code;
                    $label_code=$bom_result_row->label_code;
                    $print_type_bom=$bom_result_row->print_type;
                  }

                  $sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

                  foreach($sleeve_code_result as $sleeve_code_row){                   
                    $sleeve_spec_id=$sleeve_code_row->spec_id;
                    $sleeve_spec_version=$sleeve_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$sleeve_spec_id;
                  $specs['spec_version_no']=$sleeve_spec_version;

                $specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
                if($specs_master_result){
                    foreach($specs_master_result as $specs_master_result_row){
                      $layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
                      $layer_no=substr($layer_arr[1],0,1);              

                    }
                  $specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                  if($specs_result){
                    foreach($specs_result as $specs_row){
                      $dia=$specs_row->SLEEVE_DIA;
                      $length=$specs_row->SLEEVE_LENGTH;                

                    }
                  }
                    
                  //SHOULDER----------

                  $shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

                    foreach($shoulder_code_result as $shoulder_code_row){                   
                      $shoulder_spec_id=$shoulder_code_row->spec_id;
                      $shoulder_spec_version=$shoulder_code_row->spec_version_no;
                    }

                    $shoulder_specs['spec_id']=$shoulder_spec_id;
                    $shoulder_specs['spec_version_no']=$shoulder_spec_version;

                  $shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
                  if($shoulder_specs_result){
                    foreach($shoulder_specs_result as $shoulder_specs_row){
                      $shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
                      $shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
                      $shoulder_foil_tag=$shoulder_specs_row->SHOULDER_FOIL_TAG;                

                    }
                  }

                  //CAP------------

                    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
                    
                    $cap_spec_id='';
                    $cap_spec_version='';

                    foreach($cap_code_result as $cap_code_row){                   
                      $cap_spec_id=$cap_code_row->spec_id;
                      $cap_spec_version=$cap_code_row->spec_version_no;
                    }

                  $cap_specs['spec_id']=$cap_spec_id;
                  $cap_specs['spec_version_no']=$cap_spec_version;

                  $cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
                  if($cap_specs_result){
                    foreach($cap_specs_result as $cap_specs_row){
                      $cap_dia=$cap_specs_row->CAP_DIA;
                      $cap_type=$cap_specs_row->CAP_STYLE;
                      $cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
                      $cap_orifice=$cap_specs_row->CAP_ORIFICE;             

                    }
                  }


                }//SPECS MASTER

              }//BOM RESULT

            }//ELSE

          }//SPECS DETAILS    

       
          // Net Amount-----------------------------
           if($order_master_row->for_export==1){

            $net_amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_details_row->calc_sell_price;

          }else{

            $net_amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
          }

          //---NEW STATUS ADDED ON DEMAND OF PRAJAKTA----------------------------------------------
              // Tolerance-----------------
              $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$order_master_row->customer_no);

              foreach ($address_master_result as $address_master_row) {

                $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);                  
                //Factory Tolerance-------  
                $factory_tolerance=30;
                $factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
                $minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

                //Customer Tolerance-------   
                //$customer_tolerance=10;
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
              $total_arid_qty=0;
              $supplyqty=0;
              $cancel_qty=0;
              $search_arr=array('ref_ord_no'=>$order_details_row->order_no,
                        'article_no'=>$order_details_row->article_no);
              
              $ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

              foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
                $total_arid_qty+=$ar_invoice_details_row->arid_qty;
              }

              $supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);

              if($order_master_row->trans_closed==1){
                if($supplyqty==0)
                { $status="Cancel Order";
                  $cancel_qty=$total_order_quantity;
                }else if($supplyqty<$minus_factory_dispatch_qty){                               
                  $status="Manual Closed (Order cancelled from customer end) ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                  $cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
                  $status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
                }
                else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){                               
                  $status="Manual Closed (Below Tolerance) ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                  $cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
                  $status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
                }
                elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
                  $status="Short Closed ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                  //$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
                  $status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
                }
                else{
                  
                  $status="Completed ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                }
                
              }else{
                
                
                if($total_order_quantity<=$supplyqty && $supplyqty<>0){
                  $status="Completed ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                  //$status="Completed (INV)";
                }
                elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
                  $status="Partially Completed ".($order_details_row->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
                  //$status="Partially Completed (INV)";
                  $status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
                }
                else{
                  
                  $status="Pending";
                }
                
              }


            //---------------------------------------------------------------------------------------
            




          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $order_details_row->article_no);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $article_name);
           $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $this->common_model->view_date(($order_details_row->delivery_date!='0000-00-00'?$order_details_row->delivery_date:""),$this->session->userdata['logged_in']['company_id']));

           $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, ($order_details_row->spec_id!=''?$order_details_row->spec_id.'_R'.$order_details_row->spec_version_no:''));
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, ($order_details_row->ad_id!=''?$order_details_row->ad_id.'_R'.$order_details_row->version_no:''));

          // Specification Details------------------- 
           $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $layer_no);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $dia);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $length);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, ($print_type_artwork==''?$print_type_bom:$print_type_artwork));
          
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $shoulder_type);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $shoulder_orifice);
          
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $cap_dia);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $cap_type);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $cap_finish);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $cap_orifice);
          

          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']));
      
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']));
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $net_amount);
          $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row, $this->common_model->read_number($order_details_row->total_tax,$this->session->userdata['logged_in']['company_id']));


          //Tax Column Generation-------------------------------------

          $arr=explode("|",$order_details_row->tax_grid_amount);
          $edit=$order_details_row->tax_pos_no;
          $data['tax_grid_details']=$this->sales_order_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

          // echo'<pre>';
          // print_r($data['tax_header']);
          // echo'</pre>';

          // echo'<pre>';
          // print_r($data['tax_grid_details']);
          // echo'</pre>';

          $i=0;
          foreach ($data['tax_header'] as $key=>$trow){

            $j=0;
            foreach ($data['tax_grid_details'] as $drow){

              if($drow->tax_code==$trow->tax_code){
                //$value=($arr[$j]!=''?$arr[$j]:0); 
                $value=$arr[$j]; 
                $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index,$excel_sheet_row, $value);
                //$total_array[$i]+=$value;                
                break;
              }

              $j++;

            }          

            $i++;

            $row_column_index++;

            }

          //------------------------------------------------------------------
            //Eknath
          if($r==0){
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);            
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
           
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,$this->common_model->read_number($order_master_row->total_amount,$this->session->userdata['logged_in']['company_id']));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,strtoupper($this->common_model->get_user_name($order_master_row->user_id,$this->session->userdata['logged_in']['company_id'])));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,($order_master_row->approved_by!='' ?strtoupper($this->common_model->get_user_name($order_master_row->approved_by,$this->session->userdata['logged_in']['company_id'])):''));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));

            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,$this->common_model->view_date($order_master_row->approval_date,$this->session->userdata['logged_in']['company_id']));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,($order_master_row->for_export==1 ? "EXPORT":"LOCAL"));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,($order_master_row->for_sampling==1 ? "SAMPLE":""));
            
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));          

            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,$status);

            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++,$excel_sheet_row,$order_master_row->lang_addi_info);
            $start = PHPExcel_Cell::stringFromColumnIndex($row_column_index);
            $ObjPHPExcel->getActiveSheet()->mergeCells($start.($excel_sheet_row).':'.$start.($excel_sheet_row+$merge_row_counter));
            
          } 

          //detail Reocords column index Defined.---------------

          ($merge_row_counter>0?$row_column_index=10:$row_column_index=0);

          $excel_sheet_row++;

          $r++;

        }// Deatil foreach

        
        $sr_no++;

      }// Master Foreach



      $file_name='Sales_Order_Book_report_'.date('Y-m-d-H:i:s').'.xlsx';
      $ObjPHPExcel->getActiveSheet()->setTitle('Sales Data');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      header('Cache-Control: max-age=0');

      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer->save('php://output');
      exit;

      }



  }


}