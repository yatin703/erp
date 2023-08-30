<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order_book extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('purchase_order_book_model');
      $this->load->model('country_model');
      $this->load->model('supplier_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('state_model');
      $this->load->model('payment_term_model');
      $this->load->library('numbertowords');

    }else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Purchase'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $table='purchase_order_master';
            include('pagination.php');

            $from="2017-07-01";
            $to=date('Y-m-d');
            $search="";
            $table='purchase_order_master';
                        
            $data['purchase_order_master']=$this->purchase_order_book_model->active_record_search_index($config["per_page"],$this->uri->segment(3),$table,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);

            $data['tax_header']=$this->purchase_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
            
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
   
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
           $data['country']=$this->country_model->select_active_drop_down('country_master');
           $data['tax_grid']=$this->tax_grid_model->select_purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
           $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','82');
           $data['freight_type']=$this->common_model->select_one_details_record_noncompany('freight_type_master_lang','archive','<>1');
           $data['warehouse']=$this->common_model->select_one_details_record('warehouse_design_lang',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
           
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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('adr_company_id','Supplier' ,'required|trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('so_no','Sales Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('warehouse_id','Warehouse' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('freight_type_id','Freight' ,'required|trim|xss_clean');

            if($this->input->post('import')==1){
              $this->form_validation->set_rules('currency','Currency' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('exchange_rate','Exchange Rate' ,'required|trim|xss_clean');
            }

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){
              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('product_name_'.$i.'','Product Name '.$i.'' ,'required|trim|xss_clean|strtoupper|callback_article_check');
              $this->form_validation->set_rules('quantity_'.$i.'','Quantity '.$i.'' ,'required|trim|xss_clean|max_length[15]|is_natural_no_zero');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit rate '.$i.'' ,'required|trim|xss_clean|max_length[15]|numeric');
              $this->form_validation->set_rules('amount_'.$i.'','Amount '.$i.'' ,'required|trim|xss_clean|max_length[15]|numeric');
              $this->form_validation->set_rules('tax_grid_'.$i.'','Tax '.$i.'' ,'required|trim|xss_clean');

            }


            if($this->form_validation->run()==FALSE){

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','82');
            $data['freight_type']=$this->common_model->select_one_details_record_noncompany('freight_type_master_lang','archive','<>1');
            $data['warehouse']=$this->common_model->select_one_details_record('warehouse_design_lang',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              if(!empty($this->input->post('adr_company_id'))){
                $supplier_arr=explode('//',$this->input->post('adr_company_id'));
                $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$supplier_arr[1]);
                foreach ($data['supplier'] as $supplier) {
                  $property=$supplier->property_id;
                  $payment_conditions=$supplier->payment_condition_id;

                  $data['payment_conditions']=$this->common_model->select_one_active_record_noncompany('payment_condition_master','id',$payment_conditions);
                  if($data['payment_conditions']==FALSE){
                    $net_days='';
                  }else{
                    foreach($data['payment_conditions'] as $payment_conditions_row){
                      $net_days=$payment_conditions_row->net_days;
                    }
                  }
                  
                }
              }

              if($this->input->post('import')==1){
                $form_id='1239';
              }else{
                $form_id='82';
              }

              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id',$form_id);

              foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                foreach($data['account_periods'] as $account_periods_row){
                  $start=date('y', strtotime($account_periods_row->fin_year_start));
                  $end=date('y', strtotime($account_periods_row->fin_year_end));
                }
                $curr_val=str_pad($auto_row->curr_val,4,0,STR_PAD_LEFT);
                $purchase_order_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$curr_val;
                $next_purchase_order_no=$auto_row->curr_val+1;
              }

              $data=array('curr_val'=>$next_purchase_order_no);
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','82',$this->session->userdata['logged_in']['company_id']);

              $for_import = (!empty($this->input->post('import'))) ? $this->input->post('import') : 0;
              
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
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'po_no'=>$purchase_order_no,
                'po_date'=>date('Y-m-d'),
                'supplier_no'=>$supplier_arr[1],
                'payment_conditions'=>$payment_conditions,
                'net_days'=>$net_days,
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'po_req_no'=>$this->input->post('po_req_no'),
                'freight_type_id'=>$this->input->post('freight_type_id'),
                'archive'=>'0',
                'exciseable'=>'2',
                'for_import'=>$for_import,
                'property_id'=>$property,
                'country_id'=>$country[1],
                'currency_id'=>$currency[0],
                'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                'exchange_rate_date'=>$currency[2],
                'so_no'=>$this->input->post('so_no'),
                'warehouse_id'=>$this->input->post('warehouse_id'));

              $result=$this->common_model->save('purchase_order_master',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'po_no'=>$purchase_order_no,
                'lang_internal_remarks'=>$this->input->post('comment'),
                'language_id'=>$this->session->userdata['logged_in']['language_id']);
              $result=$this->common_model->save('purchase_order_master_lang',$data);

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

                      $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'po_no'=>$purchase_order_no,
                        'pur_pos_no'=>$i,
                        'article_no'=>$item_code[1],
                        'po_qty'=>$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_per_unit'=>$this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'net_price'=>$this->common_model->save_number($amount,$this->session->userdata['logged_in']['company_id']),
                        'gross_price'=>$this->common_model->save_number($total_selling_price,$this->session->userdata['logged_in']['company_id']),
                        'total_tax'=>$this->common_model->save_number($total_tax_amount,$this->session->userdata['logged_in']['company_id']),
                        'tax_pos_no'=>$this->input->post('tax_grid_'.$i.''),
                        'tax_grid_amount'=>implode("|",$a),
                        
                        'calc_sell_price'=>$calc_sell_price,
                        'unit_tax'=>$unit_tax);

                       $result=$this->common_model->save('purchase_order_details',$data);
                       $net_amount+=$amount;
                       $total_quantity+=$this->common_model->save_number($this->input->post('quantity_'.$i.''),$this->session->userdata['logged_in']['company_id']);
                       $total_ttax_amount+=$total_tax_amount;

                  }
                  $total_amount=$net_amount+$total_ttax_amount;
                  $data=array('total_without_tax'=>$this->common_model->save_number($net_amount,$this->session->userdata['logged_in']['company_id']),
                    'tax'=>$this->common_model->save_number($total_ttax_amount,$this->session->userdata['logged_in']['company_id']),
                    'total_with_tax'=>$this->common_model->save_number($total_amount,$this->session->userdata['logged_in']['company_id']));
                  $result=$this->common_model->update_one_active_record('purchase_order_master',$data,'po_no',$purchase_order_no,$this->session->userdata['logged_in']['company_id']);
                }

                if(!empty($this->input->post('approval_authority'))){

                  $data=array('pending_flag'=>'1');
                    $result=$this->common_model->update_one_active_record('purchase_order_master',$data,'po_no',$purchase_order_no,$this->session->userdata['logged_in']['company_id']);

                  $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$purchase_order_no);
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
                        'form_id'=>'82',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$purchase_order_no,
                        );

                      $result=$this->common_model->save('followup',$data);
                  }

              $data['page_name']='Purchase';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');
              $data['note']='Create Transaction Completed';

              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['tax_grid']=$this->tax_grid_model->select_purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','82');
              $data['freight_type']=$this->common_model->select_one_details_record_noncompany('freight_type_master_lang','archive','<>1');
              $data['warehouse']=$this->common_model->select_one_details_record('warehouse_design_lang',$this->session->userdata['logged_in']['company_id'],'archive<>','1');    

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


  public function supplier_check($str){
    if(!empty($str)){
      $supplier_code=explode('//',$str);
      if(!empty($supplier_code[1])){
        $data=array('address_master.adr_company_id'=>$supplier_code[1],
          'address_master.name1'=>$supplier_code[0]);
      $data['supplier']=$this->supplier_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      foreach ($data['supplier'] as $supplier_row) {

        if ($supplier_row->adr_company_id == $supplier_code[1]){
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


  function view(){

    $po_no=$this->uri->segment(3);
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['purchase_order_master']=$this->purchase_order_book_model->select_one_active_record('purchase_order_master',$this->session->userdata['logged_in']['company_id'],'purchase_order_master.po_no',$po_no);

            $data['purchase_order_details']=$this->purchase_order_book_model->active_details_records('purchase_order_details',array('po_no'=>$po_no),$this->session->userdata['logged_in']['company_id']);

            $this->load->model('tax_grid_model');
            $data['tax_master']=$this->tax_grid_model->select_purchase_order_tax_grid($po_no);

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['form']=$this->common_model->select_one_active_record('form_master',$this->session->userdata['logged_in']['company_id'],'file_name','purchase_order_book');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$po_no);



            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No View rights Thanks';
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



  function modify(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Purchase'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            $data=array('user_id'=>$this->session->userdata['logged_in']['user_id'],
              'final_approval_flag'=>'0',
              'pending_flag'=>'0',
              'po_no'=>$this->uri->segment(3));
            $data['purchase_order_master']=$this->purchase_order_book_model->active_details_records('purchase_order_master',$data,$this->session->userdata['logged_in']['company_id']);

            $data['purchase_order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('purchase_order_details',$this->session->userdata['logged_in']['company_id'],array('po_no'=>$this->uri->segment(3)),$this->uri->segment(3));

            $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','2');
            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','82');
            $data['freight_type']=$this->common_model->select_one_details_record_noncompany('freight_type_master_lang','archive','<>1');
            $data['warehouse']=$this->common_model->select_one_details_record('warehouse_design_lang',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

            $data['page_name']='Purchase';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');
              
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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            $this->form_validation->set_rules('adr_company_id','Supplier' ,'required|trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('so_no','Sales Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('warehouse_id','Warehouse' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('freight_type_id','Freight' ,'required|trim|xss_clean');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('product_name_'.$i.'','Product Name '.$i.'' ,'required|trim|xss_clean|strtoupper|callback_article_check');
              $this->form_validation->set_rules('quantity_'.$i.'','Quantity '.$i.'' ,'required|trim|xss_clean|max_length[15]|is_natural_no_zero');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit rate '.$i.'' ,'required|trim|xss_clean|max_length[15]|numeric');
              $this->form_validation->set_rules('amount_'.$i.'','Amount '.$i.'' ,'required|trim|xss_clean|max_length[15]|numeric');
              $this->form_validation->set_rules('tax_grid_'.$i.'','Tax '.$i.'' ,'required|trim|xss_clean');

            }


            if($this->form_validation->run()==FALSE){

            $data=array('po_no'=>$this->input->post('po_no'));
            $data['purchase_order']=$this->purchase_order_book_model->active_details_records('purchase_order_master',$data,$this->session->userdata['logged_in']['company_id']);

            $data['purchase_order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('purchase_order_details',$this->session->userdata['logged_in']['company_id'],'po_no',$this->input->post('po_no'));

            $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','2');

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['tax_grid']=$this->tax_grid_model->select_purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);

            $data['page_name']='Purchase';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{


              if(!empty($this->input->post('adr_company_id'))){
                $supplier_arr=explode('//',$this->input->post('adr_company_id'));
                $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$supplier_arr[1]);
                foreach ($data['supplier'] as $supplier) {
                  $property=$supplier->property_id;
                  $payment_conditions=$supplier->payment_condition_id;

                  $data['payment_conditions']=$this->common_model->select_one_active_record_noncompany('payment_condition_master','id',$payment_conditions);
                  if($data['payment_conditions']==FALSE){
                    $net_days='';
                  }else{
                    foreach($data['payment_conditions'] as $payment_conditions_row){
                      $net_days=$payment_conditions_row->net_days;
                    }
                  }
                  
                }
              }

              $for_import = (!empty($this->input->post('for_import'))) ? $this->input->post('for_import') : 0;

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
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'po_no'=>$this->input->post('po_no'),
                'supplier_no'=>$supplier_arr[1],
                'payment_conditions'=>$payment_conditions,
                'net_days'=>$net_days,
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'po_req_no'=>$this->input->post('po_req_no'),
                'freight_type_id'=>$this->input->post('freight_type_id'),
                'archive'=>'2',
                'exciseable'=>'2',
                'for_import'=>$for_import,
                'property_id'=>$property,
                'country_id'=>$country[1],
                'currency_id'=>$currency[0],
                'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                'exchange_rate_date'=>$currency[2],
                'so_no'=>$this->input->post('so_no'),
                'warehouse_id'=>$this->input->post('warehouse_id'));

              $result=$this->common_model->update_one_active_record('purchase_order_master',$data,'po_no',$this->input->post('po_no'),$this->session->userdata['logged_in']['company_id']);

              $dataa=array(
                'lang_internal_remarks'=>$this->input->post('comment'));

               $result=$this->common_model->update_one_active_record('purchase_order_master_lang',$dataa,'po_no',$this->input->post('po_no'),$this->session->userdata['logged_in']['company_id']);

              if($result){
                  $result=$this->common_model->delete_one_active_record('purchase_order_details','po_no',$this->input->post('po_no'),$this->session->userdata['logged_in']['company_id']);
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

                      $data['specification_final_version_no']=$this->specification_model->select_specification_final_version('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','spec_created_date','desc');

                      foreach ($data['specification_final_version_no'] as $specification_final_version_no_row){
                           $specification_no=$specification_final_version_no_row->spec_id;
                           $specification_version_no=$specification_final_version_no_row->spec_version_no;
                           $article_no=$specification_final_version_no_row->ad_id;
                           $artwork_version_no=$specification_final_version_no_row->version_no;
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
                        'ad_id'=>$article_no,
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

                $data=array('order_no'=>$this->input->post('order_no'));
                $data['order']=$this->Purchase_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
                $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('order_no'));

                $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');
                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['tax_grid']=$this->tax_grid_model->select_Purchase_tax_active_drop_down('tax_grid_master',$this->session->userdata['logged_in']['company_id']);

                $data['page_name']='Purchase';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'Purchase_order_book');

                $data['note']='Update Transaction Completed';

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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


  function search(){
   
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           

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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('supplier_no','Supplier Name' ,'trim|xss_clean|max_length[150]|callback_supplier_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('po_no','Purchase order' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_import','Order Type' ,'trim|xss_clean');
            $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('po_grir_completed','Order Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('inv_created_flag','Transaction Status' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  $for_import=$this->input->post('for_import');
                  $final_approval_flag=$this->input->post('final_approval_flag');
                  $po_grir_completed=$this->input->post('po_grir_completed');
                  $inv_created_flag=$this->input->post('inv_created_flag');
                  
                  $search=array();
                  
                  if(!empty($this->input->post('supplier_no'))){
                     $arr=explode('//',$this->input->post('supplier_no'));
                     $search['supplier_no']=$arr[1];
                  }                  
                  if(!empty($this->input->post('po_no'))){
                     $search['po_no']=$this->input->post('po_no');
                  }
                  if($for_import!=''){
                      $search['for_import']=$for_import;
                  }                 
                  if($final_approval_flag!=''){
                      $search['final_approval_flag']=$final_approval_flag;
                  }
                  if($po_grir_completed!=''){
                      $search['po_grir_completed']=$po_grir_completed;
                  }
                  if($inv_created_flag!=''){
                      $search['inv_created_flag']=$inv_created_flag;
                  }
                  
                               

                 $data['purchase_order_master']=$this->purchase_order_book_model->active_record_search('purchase_order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                // echo $this->db->last_query();
                 
                $data['tax_header']=$this->purchase_order_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                
                 
                if($data['purchase_order_master']!=FALSE){
                    $data['page_name']='Purchase';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Purchase';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');
                      
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

  function show_open_transactions(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $table='purchase_order_master';

            $from="2018-02-01";
            $to=date('Y-m-d');
            $search['user_id']=$this->session->userdata['logged_in']['user_id'];
            $search['inv_created_flag']='0';


            $data['purchase_order_master']=$this->purchase_order_book_model->active_record_search('purchase_order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
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
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            if($data['module']!=FALSE){
                foreach ($data['module'] as $module_row) {
                  if($module_row->module_name==='Purchase'){
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

                      foreach ($data['formrights'] as $formrights_row) {
                        if($formrights_row->modify==1){

                          if(count($this->input->post('po_no[]'))=='0' OR empty($this->input->post('po_no[]'))){
                              
                              $this->form_validation->set_rules('po_no[]',"PO no", "required|trim|xss_clean|");
                              $this->form_validation->run();
                          }
                          else{

                              $flag=0;
                              $order_no_arr=$this->input->post('po_no[]');
                             // echo count($order_no_arr);
                              for($i=0;$i<count($order_no_arr);$i++){

                                   $pkey=$order_no_arr[$i];
                                   if($pkey!=''){

                                      $data=array('inv_created_flag'=>'1');
                                        $result=$this->common_model->update_one_active_record('purchase_order_master',$data,'po_no',$pkey,$this->session->userdata['logged_in']['company_id']);
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

                          $data['page_name']='Purchase';
                          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

                          $from="2018-02-01";
                          $to=date('Y-m-d');
                          $search['user_id']=$this->session->userdata['logged_in']['user_id'];
                          $search['inv_created_flag']='0';

                          $data['purchase_order_master']=$this->purchase_order_book_model->active_record_search('purchase_order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
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
 
  

}