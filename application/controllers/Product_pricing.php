<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_pricing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('product_pricing_model');
      $this->load->model('product_block_pricing_model');
      
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
            $table='product_pricing';
            include('pagination.php');

            $data['product_pricing']=$this->product_pricing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dat=array('pp_id'=>$this->uri->segment(3));
            $data['product_pricing']=$this->product_pricing_model->active_record_search('product_pricing',$dat,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            //$data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['product_block_pricing']=$this->common_model->select_one_active_record('product_block_pricing',$this->session->userdata['logged_in']['company_id'],'archive<>','1');
            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
            $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
      
           // echo $this->db->last_query();
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view('Loading/loading');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check|is_unique[product_pricing.article_no]');
            $this->form_validation->set_rules('customer_category','Customer' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pg_no','Price List' ,'required|trim|xss_clean|callback_price_list_check');
                        

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
              $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
                  $item_code=explode('//',$this->input->post('article_no'));
                  //$pg_no=explode('//',$this->input->post('pg_no'));

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'article_no'=>$item_code[1],
                        'adr_category_id'=>$this->input->post('customer_category'),
                        'product_pricing_date'=>date('Y-m-d'),
                        'pg_no'=>$this->input->post('pg_no'));

                    $result=$this->common_model->save('product_pricing',$data);

                  
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Product_pricing');

                  $data['note']='Create Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                  $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
                  
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            
            $table='product_pricing';
            include('pagination.php');
            $data['product_pricing']=$this->product_pricing_model->select_inactive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $dataa=array('pp_id'=>$this->uri->segment(3));
            $data['product_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
            
            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
            $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('customer_category','Customer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('pg_no','Price List' ,'required|trim|xss_clean|callback_price_list_check');
            if($this->form_validation->run()==FALSE){

                $dataa=array('pp_id'=>$this->input->post('pp_id'));

                $data['product_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
                $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $item_code=explode('//',$this->input->post('article_no'));
                //$pg_no=explode('//',$this->input->post('pg_no'));

                $data=array('article_no'=>$item_code[1],
                        'adr_category_id'=>$this->input->post('customer_category'),
                        'pg_no'=>$this->input->post('pg_no'));

                $result=$this->common_model->update_one_active_record('product_pricing',$data,'pp_id',$this->input->post('pp_id'),$this->session->userdata['logged_in']['company_id']);

                $data['page_name']='Sales';
                
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

                 $dataa=array('pp_id'=>$this->input->post('pp_id'));

                 $data['product_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);

                 $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
                 $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
                 
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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->update_one_active_record('product_pricing',$data,'pp_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

                  $dataa=array('pp_id'=>$this->uri->segment(3));
                  $data['product_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);
                  $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
                  $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
                 $data=array('archive'=>'2');
                 $result=$this->common_model->update_one_active_record('product_pricing',$data,'pp_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);


                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

                  $dataa=array('pp_id'=>$this->uri->segment(3));
                  $data['product_pricing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_pricing',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
                  $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
                  
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
            $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $this->form_validation->set_rules('article_no','Product Name' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('pg_no','Price Grid' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

                $data['customer_category']=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'export_flag','1');
                
                $data['pg_no']=$this->product_block_pricing_model->select_distinct_price_grid_dropdown('product_block_pricing',$this->session->userdata['logged_in']['company_id']);
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                if(!empty($this->input->post('article_no'))){
                  $item_code=explode('//',$this->input->post('article_no'));
                }else{
                  $item_code[1]="";
                }

                /*if(!empty($this->input->post('pg_no'))){
                  $pg_no=explode('//',$this->input->post('pg_no'));
                }else{
                  $pg_no[1]="";
                }*/
                
                $data=array('product_pricing.article_no'=>$item_code[1],
                  'product_pricing.pg_no'=>$this->input->post('pg_no'),
                  'adr_category_id'=>$this->input->post('customer_category'));

                $data = array_filter($data);
                  $data['product_pricing']=$this->product_pricing_model->active_record_search('product_pricing',$data,$this->session->userdata['logged_in']['company_id']);
                 
                if($data['product_pricing']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'product_pricing');
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

    public function price_list_check($str){
      
      

        $data=array('pg_no'=>$str,'adr_category_id'=>$this->input->post('customer_category'));
        
        $data['pg_no']=$this->common_model->select_one_active_record_nonlanguage_without_archives('product_block_pricing',$this->session->userdata['logged_in']['company_id'],$data);
      //echo $this->db->last_query();
      if($data['pg_no']==FALSE){
         $this->form_validation->set_message('price_list_check', 'The {field} is not belongs to this customer');
         return FALSE;
      }else{
      foreach ($data['pg_no'] as $pg_no_row) {
        
        if ($pg_no_row->pg_no == $str && $pg_no_row->adr_category_id==$this->input->post('customer_category')){
          return TRUE;
        }else{
          $this->form_validation->set_message('price_list_check', 'The {field} is not belongs to this customer');
          return FALSE;
          }
        } 
      }
      
    }
  

}