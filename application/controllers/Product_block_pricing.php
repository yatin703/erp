<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_block_pricing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('product_block_pricing_model');
      $this->load->model('country_model');

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='product_block_pricing';
            include('pagination-twelve.php');

            $data['articles']=$this->product_block_pricing_model->select_distinct_product($table,$this->session->userdata['logged_in']['company_id']);
            $data['product_block_pricing']=$this->product_block_pricing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  function view(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));
            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
            
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            //$this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');

            $this->form_validation->set_rules('price_list_name','Price List Name' ,'required|trim|xss_clean|is_unique[product_block_pricing.price_list_name]');
            $this->form_validation->set_rules('customer_category','Customer' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('currency','Currency' ,'required|trim|xss_clean');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);
              $this->form_validation->set_rules('price_1_'.$i.'','Ex-Works Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_2_'.$i.'','Freight Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_1_'.$i.'','Other Cost Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_1_'.$i.'','Mark Up Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit Rate Price '.$i.'' ,'required|trim|xss_clean');
            }

            if($this->form_validation->run()==FALSE){

            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
                  $item_code=explode('//',$this->input->post('article_no'));
                  if(!empty($this->input->post('currency'))){
                    $country=explode('|',$this->input->post('currency'));
                   // $currency=explode('|',$this->input->post('exchange_rate'));
                  }else{
                    $country[1]='';
                    $country[0]='';
                    //$currency[1]='';
                    //$currency[2]='';
                  }



                $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','57');
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
                $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','57',$this->session->userdata['logged_in']['company_id']);

                  for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'pg_no'=>$sales_order_no,
                        'price_list_name'=>$this->input->post('price_list_name'),
                        'adr_category_id'=>$this->input->post('customer_category'),
                        //'article_no'=>$item_code[1],
                        //'version_no'=>$this->input->post('version_no'),
                        'pbpm_id'=>$this->input->post('pbpm_id_'.$i.''),
                        'country_id'=>$country[1],
                        'currency_id'=>$country[0],
                        //'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                        //'exchange_rate_date'=>$currency[2],
                        'price_1'=>$this->common_model->save_number($this->input->post('price_1_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_2'=>$this->common_model->save_number($this->input->post('price_2_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_3'=>$this->common_model->save_number($this->input->post('price_3_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_4'=>$this->common_model->save_number($this->input->post('price_4_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'unit_price'=>$this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'user_id'=>$this->session->userdata['logged_in']['user_id']);

                    $result=$this->common_model->save('product_block_pricing',$data);

                  }
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_block_pricing');

                  $data['note']='Create Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $data['country']=$this->country_model->select_active_drop_down('country_master');
                  $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

                  $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

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



  function archive_records(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'customer');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            
            $table='product_block_pricing';
            include('pagination_product_pricing.php');
            $data['product_block_pricing']=$this->product_block_pricing_model->select_inactive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
            $dataa=array('pg_no'=>$this->uri->segment(3));
            $data['product_block_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

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
      $data['page_name']='Sales';
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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'customer');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){


            //$this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
            $this->form_validation->set_rules('price_list_name','Price List Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('customer_category','Customer' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('currency','Currency' ,'required|trim|xss_clean');
            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              
              $this->form_validation->set_rules('price_1_'.$i.'','Ex-Works Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_2_'.$i.'','Freight Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_1_'.$i.'','Other Cost Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('price_1_'.$i.'','Mark Up Price '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('unit_rate_'.$i.'','Unit Rate Price '.$i.'' ,'required|trim|xss_clean');
            }


              if($this->form_validation->run()==FALSE){

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

                $dataa=array('pg_no'=>$this->input->post('pg_no'));
                $data['product_block_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                //$item_code=explode('//',$this->input->post('article_no'));
                  if(!empty($this->input->post('currency'))){
                    $country=explode('|',$this->input->post('currency'));
                    //$currency=explode('|',$this->input->post('exchange_rate'));
                  }else{
                    $country[1]='';
                    $country[0]='';
                    //$currency[1]='';
                    //$currency[2]='';
                  }
                  for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'price_list_name'=>$this->input->post('price_list_name'),
                        'adr_category_id'=>$this->input->post('customer_category'),
                        //'article_no'=>$item_code[1],
                        //'version_no'=>$this->input->post('version_no'),
                        'pbpm_id'=>$this->input->post('pbpm_id_'.$i.''),
                        'country_id'=>$country[1],
                        'currency_id'=>$country[0],
                       // 'exchange_rate'=>$this->common_model->save_number($currency[1],$this->session->userdata['logged_in']['company_id']),
                        //'exchange_rate_date'=>$currency[2],
                        'price_1'=>$this->common_model->save_number($this->input->post('price_1_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_2'=>$this->common_model->save_number($this->input->post('price_2_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_3'=>$this->common_model->save_number($this->input->post('price_3_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'price_4'=>$this->common_model->save_number($this->input->post('price_4_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'unit_price'=>$this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']),
                        'user_id'=>$this->session->userdata['logged_in']['user_id']);

                    $result=$this->common_model->update_one_active_record('product_block_pricing',$data,'pbp_id',$this->input->post('pbp_id_'.$i.''),$this->session->userdata['logged_in']['company_id']);

                  }
                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'customer');

                 $data['country']=$this->country_model->select_active_drop_down('country_master');
                 $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

                 $dataa=array('pg_no'=>$this->input->post('pg_no'));
                 $data['product_block_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
                 $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
              }
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


  function delete(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->update_one_active_record('product_block_pricing',$data,'pg_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

                  $data['country']=$this->country_model->select_active_drop_down('country_master');
                 $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
                 $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

                  $dataa=array('pg_no'=>$this->uri->segment(3));
                  $data['product_block_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data['note']='Archive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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


    function dearchive(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'customer');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
                 $data=array('archive'=>'2');
                 $result=$this->common_model->update_one_active_record('product_block_pricing',$data,'pg_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);


                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

                  $data['country']=$this->country_model->select_active_drop_down('country_master');
                  $data['product_block_pricing']=$this->common_model->select_one_inactive_record('product_block_pricing',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

                  $dataa=array('pg_no'=>$this->uri->segment(3));
                  $data['product_block_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
                  $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');


                  $data['note']='Dearchive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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
    }else{
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['product_block_pricing_master']=$this->common_model->select_one_active_record('product_block_pricing_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

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


  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $this->form_validation->set_rules('price_list_name','Price List Name' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

                $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                //$item_code=explode('//',$this->input->post('article_no'));
                $data=array('product_block_pricing.price_list_name'=>$this->input->post('price_list_name'),
                  'product_block_pricing.adr_category_id'=>$this->input->post('customer_category'));

                $data = array_filter($data);
                  $data['product_block_pricing']=$this->product_block_pricing_model->active_record_search('product_block_pricing',$data,$this->session->userdata['logged_in']['company_id']);
                 
                if($data['product_block_pricing']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');

                    $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_block_pricing');
                     $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                      $data['note']='No record in search transaction';
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
      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1]);
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
  

}