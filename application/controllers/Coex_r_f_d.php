<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_r_f_d extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_r_f_d_model');
      $this->load->model('fiscal_model');
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
             $table='coex_r_f_d';
             $data['coex_rfd']=$this->coex_r_f_d_model->select_active_records_pending($table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-pending',$data);
              $this->load->view('Home/footer');
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


  function released(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
             $table='coex_r_f_d';
             include('pagination_coex_r_f_d.php');
             $data['coex_rfd']=$this->coex_r_f_d_model->select_active_records_released($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-released',$data);
              $this->load->view('Home/footer');
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


/*  function create(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $table='coex_r_f_d';

            $data['coex_r_f_d']=$this->coex_r_f_d_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'coex_r_f_d.rfd_id',$this->uri->segment(3));

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
*/
/*  function save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('aql_date','AQL Date' ,'required|trim|xss_clean|max_length[10]');
            //$this->form_validation->set_rules('oc_date','OC Date' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean');        
            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('product','Product' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('rfd','RFD Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('release_qty','Release RFD Qty' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
                $data['coex_r_f_d']=$this->coex_r_f_d_model->select_one_active_record('coex_r_f_d',$this->session->userdata['logged_in']['company_id'],'coex_r_f_d.rfd_id',$this->input->post('release_rfd_id'));
      
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
            $this->load->view('Home/footer');
            }else{
                
                $data_rfd=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'release_rfd_id'   => $this->input->post('release_rfd_id'),
                  'aql_date'         => $this->input->post('aql_date'),
                  'oc_date'          => $this->input->post('oc_date'),
                  'customer'         => $this->input->post('customer'),
                  'article_no'       => $this->input->post('article_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'product'          => $this->input->post('product'),
                  'print_type'       => $this->input->post('print_type'),
                  'rfd'              => $this->input->post('rfd'),
                  'inspector_name'   => $this->input->post('inspector_name'),
                  'remark'           => $this->input->post('remark'),
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],                  
                  'flag'             => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d')         
                );        
                $result=$this->common_model->save('coex_r_f_d',$data_rfd);
                
                $data_ce=array(
                    'flag'=> '1',
                    'release_qty'=> $this->input->post('release_qty'),
                    'release_date'=>date('Y-m-d'),
                    'release_user_id'=> $this->session->userdata['logged_in']['user_id']
                );
              $result=$this->common_model->update_one_active_record('coex_r_f_d',$data_ce,'rfd_id',$this->input->post('release_rfd_id'),$this->session->userdata['logged_in']['company_id']);

              $data['coex_r_f_d']=$this->coex_r_f_d_model->select_one_active_record('coex_r_f_d',$this->session->userdata['logged_in']['company_id'],'coex_r_f_d.rfd_id',$this->input->post('release_rfd_id'));
        
              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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
      $data['note']='No Creat rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
}*/


function search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');           
                       
            if($this->form_validation->run()==FALSE){

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-search',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();
        
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('rfd_flag')!=''){                
                $data_search['rfd_flag']=$this->input->post('rfd_flag');
              }
                           

              $data['coex_rfd']=$this->coex_r_f_d_model->active_record_rfd_search('coex_r_f_d',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 

              //echo $this->db->last_query();

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);     

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-search',$data);
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


  function report(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
             $table='coex_r_f_d';
             $data['coex_rfd']=$this->coex_r_f_d_model->select_active_records_report($table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-report',$data);
              $this->load->view('Home/footer');
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

  function save_rfd(){
    
    $data_ar_invoice=$this->coex_r_f_d_model->select_active_records_rfd();
      
      $ref_ord_no='';
      $arid_qty='';
      $rfd_qty='';
      $rfd_order_no='';
      $invoice_date='';

      if($data_ar_invoice==TRUE){

        foreach($data_ar_invoice as $ar_invoice){
          $ref_ord_no   = $ar_invoice->ref_ord_no; 
          $arid_qty     = $ar_invoice->arid_qty/100; 
          $invoice_date = $ar_invoice->invoice_date; 

          $data_sum_rfd=$this->coex_r_f_d_model->select_active_records_sum_rfd($ref_ord_no);

            if($data_sum_rfd==TRUE){
              foreach($data_sum_rfd as $sum_rfd){
                $rfd_qty        = $sum_rfd->sum_rfd; 
                $rfd_order_no   = $sum_rfd->order_no;
                $rfd_aql_date   = $sum_rfd->aql_date;
                $rfd_article_no = $sum_rfd->article_no;
                $rfd_jobcard_no = $sum_rfd->jobcard_no;  
              }
              
              if($ref_ord_no == $rfd_order_no){

                if($rfd_qty>$arid_qty){
                  $total_qty   = $rfd_qty - $arid_qty;

                  $update_rfd_flag=array(
                      'rfd_flag'     => '1',
                      'release_date' => date('Y-m-d'),
                    );
                          
                  $result=$this->common_model->update_one_active_record('coex_r_f_d',$update_rfd_flag,'order_no',$rfd_order_no,$this->session->userdata['logged_in']['company_id']);

                  $data_rfd=array(
                    'company_id'       => $this->session->userdata['logged_in']['company_id'],
                    'aql_date'         => $rfd_aql_date,
                    'order_no'         => $rfd_order_no,
                    'article_no'       => $rfd_article_no,
                    'jobcard_no'       => $rfd_jobcard_no,
                    'rfd'              => $total_qty,
                    'archive'          => '0',
                    'rfd_flag'         => '0',
                    'created_date'     => date('Y-m-d')         
                  );

                  $result=$this->common_model->save('coex_r_f_d',$data_rfd);

                  $result=$this->coex_r_f_d_model->update_two_active_record($ref_ord_no);
                  //echo $this->db->last_query();

                }
               
              }
            }
        }
      }

  }












}


