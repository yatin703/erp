<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capex extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('capex_model');
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='capex';
              include('pagination.php');
             $data['capex']=$this->capex_model->select_active_records($config["per_page"],$this->uri->segment(3),'capex',$this->session->userdata['logged_in']['company_id']);
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

  function create(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('project_name','Project Name' ,'required|trim|xss_clean|strtoupper');

            if($this->form_validation->run()==FALSE){

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','10');
                $no="";
                foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                  foreach($data['account_periods'] as $account_periods_row){
                    $start=date('y', strtotime($account_periods_row->fin_year_start));
                    $end=date('y', strtotime($account_periods_row->fin_year_end));
                  }
                  $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                  $capex_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                  $next_capex_no=$auto_row->curr_val+1;
                }

              $data=array('curr_val'=>$next_capex_no);
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','10',$this->session->userdata['logged_in']['company_id']);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'capex_no'=>$capex_no,
                'capex_date'=>date('Y-m-d'),
                'applicant'=>$this->input->post('applicant'),
                'project_begin_date'=>$this->input->post('project_begin_date'),
                'project_end_date'=>$this->input->post('project_end_date'),
                'project_name'=>$this->input->post('project_name'),
                'project_organization'=>$this->input->post('project_organization'),
                'replacement'=>(!empty($this->input->post('replacement')) ? 1 : 0 ),
                'expansion'=>(!empty($this->input->post('expansion')) ? 1 : 0 ),
                'improvement'=>(!empty($this->input->post('improvement')) ? 1 : 0 ),
                'renewal'=>(!empty($this->input->post('renewal')) ? 1 : 0 ),
                'cost_center'=>$this->input->post('cost_center'),
                'expected_useful_life'=>$this->input->post('expected_useful_life'),
                'capex_amount'=>$this->input->post('capex_amount'),
                'third_party_service_amount'=>$this->input->post('third_party_service_amount'),
                'own_work_amount'=>$this->input->post('own_work_amount'),
                'total_amount'=>$this->input->post('total_amount'),
                'problem'=>$this->input->post('problem'),
                'solution'=>$this->input->post('solution'),
                'advantage'=>$this->input->post('advantage'),
                'risk'=>$this->input->post('risk'),
                'saving'=>$this->input->post('saving'),
                'alternative'=>$this->input->post('alternatives'),
                'impact'=>$this->input->post('impact'),
                'profitability'=>$this->input->post('profitability'),
                'roi'=>$this->input->post('roi'),
                'pay_back_year'=>$this->input->post('pay_back_year'),
                'irr'=>$this->input->post('irr'),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'project_team_members'=>$this->input->post('project_team'),
                'inform_clients'=>(!empty($this->input->post('inform_clients')) ? 1 : 0 ),
                'equipment_qualification'=>(!empty($this->input->post('equipment_qualification')) ? 1 : 0 ),
                'product_validation'=>(!empty($this->input->post('product_validation')) ? 1 : 0 )
                 );

              $result=$this->common_model->save('capex',$data);

              $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

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

    $capex_no=$this->uri->segment(3);
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Purchase'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['capex']=$this->capex_model->select_one_active_record('capex',$this->session->userdata['logged_in']['company_id'],'capex.capex_no',$capex_no);

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



    function modify(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $dataa=array('capex_no'=>$this->uri->segment(3),'user_id'=>$this->session->userdata['logged_in']['user_id']);
            $data['capex']=$this->common_model->select_one_active_record_nonlanguage_without_archives('capex',$this->session->userdata['logged_in']['company_id'],$dataa);

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
      $data['page_name']='Purchase';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            $this->form_validation->set_rules('project_name','Project Name' ,'required|trim|xss_clean');


              if($this->form_validation->run()==FALSE){

                $data['capex']=$this->common_model->select_one_active_record('capex',$this->session->userdata['logged_in']['company_id'],'capex.capex_no',$this->input->post('capex_no'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'revision_date'=>date('Y-m-d'),
                'applicant'=>$this->input->post('applicant'),
                'project_begin_date'=>$this->input->post('project_begin_date'),
                'project_end_date'=>$this->input->post('project_end_date'),
                'project_name'=>$this->input->post('project_name'),
                'project_organization'=>$this->input->post('project_organization'),
                'replacement'=>(!empty($this->input->post('replacement')) ? 1 : 0 ),
                'expansion'=>(!empty($this->input->post('expansion')) ? 1 : 0 ),
                'improvement'=>(!empty($this->input->post('improvement')) ? 1 : 0 ),
                'renewal'=>(!empty($this->input->post('renewal')) ? 1 : 0 ),
                'cost_center'=>$this->input->post('cost_center'),
                'expected_useful_life'=>$this->input->post('expected_useful_life'),
                'capex_amount'=>$this->input->post('capex_amount'),
                'third_party_service_amount'=>$this->input->post('third_party_service_amount'),
                'own_work_amount'=>$this->input->post('own_work_amount'),
                'total_amount'=>$this->input->post('total_amount'),
                'problem'=>$this->input->post('problem'),
                'solution'=>$this->input->post('solution'),
                'advantage'=>$this->input->post('advantage'),
                'risk'=>$this->input->post('risk'),
                'saving'=>$this->input->post('saving'),
                'alternative'=>$this->input->post('alternatives'),
                'impact'=>$this->input->post('impact'),
                'profitability'=>$this->input->post('profitability'),
                'roi'=>$this->input->post('roi'),
                'pay_back_year'=>$this->input->post('pay_back_year'),
                'irr'=>$this->input->post('irr'),
                'project_team_members'=>$this->input->post('project_team'),
                'inform_clients'=>(!empty($this->input->post('inform_clients')) ? 1 : 0 ),
                'equipment_qualification'=>(!empty($this->input->post('equipment_qualification')) ? 1 : 0 ),
                'product_validation'=>(!empty($this->input->post('product_validation')) ? 1 : 0 ),);

                $result=$this->common_model->update_one_active_record('capex',$data,'capex_no',$this->input->post('capex_no'),$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $data['capex']=$this->common_model->select_one_active_record('capex',$this->session->userdata['logged_in']['company_id'],'capex.capex_no',$this->input->post('capex_no'));
                  

                  $data['page_name']='Purchase';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

                  $data['note']='Update Transaction Completed';
                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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

      $data['page_name']='Purchase';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->archive_one_record('capex',$data,'capex_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

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


    function archive_records(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'capex');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='capex';
            include('pagination_archive.php');
            $data['capex']=$this->capex_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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




  function attach(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

              $dataa=array('capex_no'=>$this->uri->segment(3),'user_id'=>$this->session->userdata['logged_in']['user_id']);
              $data['capex']=$this->common_model->select_one_active_record_nonlanguage_without_archives('capex',$this->session->userdata['logged_in']['company_id'],$dataa);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
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
      $data['note']='No Attachment rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

   function attach_update(){
      $data['page_name']='Purchase';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->copy==1){
            
              if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'File', 'required');
              }

              if($this->form_validation->run()==FALSE){
                $dataa=array('capex_no'=>$this->input->post('capex_no'),'user_id'=>$this->session->userdata['logged_in']['user_id']);
                $data['capex']=$this->common_model->select_one_active_record_nonlanguage_without_archives('capex',$this->session->userdata['logged_in']['company_id'],$dataa);
                //$data['error'] = $this->upload->display_errors();
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
                $this->load->view('Home/footer');


              }else{               

                // File Upload----------------------------------  

                $config['upload_path'] = './assets/'.$this->session->userdata['logged_in']['company_id'].'/capex/';
                $config['allowed_types'] = 'pdf|PDF';
                $config['max_size'] = '0';
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);


                if($this->upload->do_upload('userfile')){
                  $data= $this->upload->data();
                  $filename=$data['file_name'];

                  $datas=array('capex_file'=>$filename,'final_approval_flag'=>'1','approved_date'=>date('Y-m-d'));

                  $result=$this->common_model->update_one_active_record('capex',$datas,'capex_no',$this->input->post('capex_no'),$this->session->userdata['logged_in']['company_id']);
                  //echo $this->db->last_query();

                  $data['note']='Update Transaction Completed';
                  }else{
                    $data['error'] = $this->upload->display_errors();
                  }



                $data['page_name']='Purchase';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());


                //$dataa=array('capex_no'=>$this->input->post('capex_no'),'user_id'=>$this->session->userdata['logged_in']['user_id']);
                //$data['capex']=$this->common_model->select_one_active_record_nonlanguage_without_archives('capex',$this->session->userdata['logged_in']['company_id'],$dataa);

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Attachment rights Thanks';
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
      $data['note']='No Copy rights Thanks';
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

