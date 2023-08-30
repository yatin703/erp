<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_purging extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');      
      $this->load->model('springtube_extrusion_purging_model');
    }else{
      redirect('login','refresh');
    }
  }

  function index(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='springtube_extrusion_purging_master';
            include('pagination.php');
            $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data_shift_issue=array('archive'=>0,'process_id'=>1);
            $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 
            //$data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            //$data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);

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
  //Eknath
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new==1){
            
            $this->form_validation->set_rules('ref_jobcard_no','Jobcard No.' ,'required|trim|xss_clean');            
            $this->form_validation->set_rules('reason','Reason' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean|max_length[225]');
			$this->form_validation->set_rules('total_purging_weight','Total Purging weight' ,'required|trim|xss_clean');
            
            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
              
              $this->form_validation->set_rules('article_no_'.$sr_no_value.'','Purging Materials '.$sr_no_value.'' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('quantity_'.$sr_no_value.'','Purging Quantity'.$sr_no_value.'' ,'required|trim|xss_clean|greater_than[0]');              

            }  
            

            if($this->form_validation->run()==FALSE){
              
              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              
              $data=array(                    
                'purging_date'=>date('Y-m-d'),
                'ref_jobcard_no'=>$this->input->post('ref_jobcard_no'),
                'reason'=>$this->input->post('reason'),
				        'total_purging_weight'=>$this->input->post('total_purging_weight'),
                'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'created_date'=>date('Y-m-d H:i:s')                  
              );

              $purging_id=$this->common_model->save_return_pkey('springtube_extrusion_purging_master',$data);
               
              if($purging_id!='' || $purging_id!=0){                    
                    
                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                  $article_arr=explode("//", $this->input->post('article_no_'.$sr_no_value));

                  $data=array(                    
                    'purging_id'=>$purging_id,
                    'article_pos_no'=>$sr_no_value, 
                    'article_no'=>$article_arr[1],
                    'quantity'=>$this->input->post('quantity_'.$sr_no_value),
                    'rel_qty'=>$this->common_model->save_number($this->input->post('quantity_'.$sr_no_value),$this->session->userdata['logged_in']['company_id'])
                              
                  );
                  
                  $result=$this->common_model->save('springtube_extrusion_purging_details',$data);

                }                   

              }

              if($result){
                 $data['note']='Create Transaction Completed';
               }else{
                $data['note']='Create Transaction failed';
               }

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              

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


  


  function modify($purging_id){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_purging_master.purging_id',$purging_id);

            $dataa=array('purging_id'=>$purging_id);
              $table='springtube_extrusion_purging_details';
              $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

            $data_shift_issue=array('archive'=>0,'process_id'=>1);
            $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

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

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('ref_jobcard_no','Jobcard No.' ,'required|trim|xss_clean');            
              $this->form_validation->set_rules('reason','Reason' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean|max_length[225]');
			        $this->form_validation->set_rules('total_purging_weight','Total Purging weight' ,'required|trim|xss_clean');
			  
            
            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
              
              $this->form_validation->set_rules('article_no_'.$sr_no_value.'','Purging Materials '.$sr_no_value.'' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('quantity_'.$sr_no_value.'','Purging Quantity'.$sr_no_value.'' ,'required|trim|xss_clean|greater_than[0]');              

            }              

              if($this->form_validation->run()==FALSE){
                
                $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_purging_master.purging_id',$this->input->post('purging_id'));

                $dataa=array('purging_id'=>$this->input->post('purging_id'));
                  $table='springtube_extrusion_purging_details';
                  $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $data=array(                    
                
                'ref_jobcard_no'=>$this->input->post('ref_jobcard_no'),
                'reason'=>$this->input->post('reason'),
				        'total_purging_weight'=>$this->input->post('total_purging_weight'),
                'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                
                                 
              );

                $result=$this->common_model->update_one_active_record('springtube_extrusion_purging_master',$data,'purging_id',$this->input->post('purging_id'),$this->session->userdata['logged_in']['company_id']);

                // Removing Old Plate details and inserting new
                $result=$this->common_model->delete_one_active_record_noncompany('springtube_extrusion_purging_details','purging_id',$this->input->post('purging_id'));            

                    
                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                  $article_arr=explode("//", $this->input->post('article_no_'.$sr_no_value));
                  //print_r($article_arr);
                  $data=array(                    
                    'purging_id'=>$this->input->post('purging_id'),
                    'article_pos_no'=>$sr_no_value, 
                    'article_no'=>$article_arr[1],
                    'quantity'=>$this->input->post('quantity_'.$sr_no_value),
                    'rel_qty'=>$this->common_model->save_number($this->input->post('quantity_'.$sr_no_value),$this->session->userdata['logged_in']['company_id'])
                              
                  );
                  //print_r($data);
                  
                  $result=$this->common_model->save('springtube_extrusion_purging_details',$data);

                } 

                

                $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_purging_master.purging_id',$this->input->post('purging_id'));

                $dataa=array('purging_id'=>$this->input->post('purging_id'));
                  $table='springtube_extrusion_purging_details';
                  $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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


  function delete($purging_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('springtube_extrusion_purging_master',$data,'purging_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_inactive_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_purging_master.purging_id',$purging_id);

              $dataa=array('purging_id'=>$purging_id);
              $table='springtube_extrusion_purging_details';
              $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());              

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


    function dearchive($purging_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'2');

              $result=$this->common_model->update_one_active_record('springtube_extrusion_purging_master',$data,'purging_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_purging_master.purging_id',$purging_id);

              $dataa=array('purging_id'=>$purging_id);
              $table='springtube_extrusion_purging_details';
              $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());              

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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='springtube_extrusion_purging_master';
            include('pagination.php');
            $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

  function search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);             

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
             
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
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('reason','Reasons' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Created by' ,'trim|xss_clean');
            
                       
            if($this->form_validation->run()==FALSE){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
                
              

              $dataa=array(
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'reason'=>$this->input->post('reason'),
                  'user_id'=>$this->input->post('user_id')
                   
              );

              $search_data=array_filter($dataa);

              $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->active_record_search('springtube_extrusion_purging_master',$search_data,$this->input->post('from_date'),$this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);                 

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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


   function approval($purging_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {

            if($formrights_row->approval==1){

              $jobcard_no='';
              $ref_jobcard_no='';
              $order_no='';
              $article_no='';            
             

              $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'purging_id',$purging_id);
              foreach ($data['springtube_extrusion_purging_master'] as $master_row) {

                $ref_jobcard_no=$master_row->ref_jobcard_no;

              }

              $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $ref_jobcard_no);
              
              foreach($production_master_result as $row) {
                $order_no=$row->sales_ord_no;
                $article_no=$row->article_no;
              }

              


              //PURGING JOBCARD START


              $form_id='5400';

              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id',$form_id);
              $no="";
              foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                foreach($data['account_periods'] as $account_periods_row){
                  $start=date('y', strtotime($account_periods_row->fin_year_start));
                  $end=date('y', strtotime($account_periods_row->fin_year_end));
                }
                $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                $jobcard_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                $next_jobcard_no=$auto_row->curr_val+1;
              }
              $data=array('curr_val'=>$next_jobcard_no);
              
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);
             

              $data['max']=$this->common_model->select_max_pkey_numeric('production_master','manu_order_no',$this->session->userdata['logged_in']['company_id']);
              foreach($data['max'] as $max_value){
                $manu_order_no=$max_value->manu_order_no+1;
              }

              $data=array('manu_order_no'=>$manu_order_no,
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'mp_pos_no'=>$jobcard_no,
                'article_no'=>$article_no,
                'mp_qty'=>0,
                'actual_qty_manufactured'=>0,
                'manu_plan_date'=>date('Y-m-d'),
                'employee_id'=>$this->session->userdata['logged_in']['user_id'],
                'sales_ord_no'=>$order_no,
                'ord_pos_no'=>'1',
                'jobcard_type'=>'5'
               
                );

              $result=$this->common_model->save('production_master',$data);

              $data=array('jobcard_no'=>$jobcard_no,
                          'final_approval_flag'=>'1',
                          'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                          'approved_date'=>date('Y-m-d')
              );

              $result=$this->common_model->update_one_active_record('springtube_extrusion_purging_master',$data,'purging_id',$purging_id,$this->session->userdata['logged_in']['company_id']);

              // Jobcard quantity for material manufacturing--------------

              $dataa=array('purging_id'=>$purging_id);
              $table='springtube_extrusion_purging_details';
              $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);
              //print_r($data['springtube_extrusion_purging_details']);

              foreach ($data['springtube_extrusion_purging_details'] as $details_row) {

                $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
              
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }


                $data=array('manu_order_no'=>$jobcard_no,
                  'article_no'=>$details_row->article_no,
                  'demand_qty'=>$details_row->rel_qty,
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'9',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$details_row->rel_qty*1000,
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'UOM013',
                  'part_pos_no'=>$details_row->article_pos_no ,
                  'layer_no'=>'1');

                $this->common_model->save('material_manufacturing',$data); 

                
              }          
             

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

              $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'purging_id',$purging_id);

              $dataa=array('purging_id'=>$purging_id);
              $table='springtube_extrusion_purging_details';
              $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);

                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

              $data['note']='Approval Transaction completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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

      function view($purging_id){

    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['springtube_extrusion_purging_master']=$this->springtube_extrusion_purging_model->select_one_active_record('springtube_extrusion_purging_master',$this->session->userdata['logged_in']['company_id'],'purging_id',$purging_id);

            $dataa=array('purging_id'=>$purging_id);
            $table='springtube_extrusion_purging_details';
            $data['springtube_extrusion_purging_details']=$this->springtube_extrusion_purging_model->active_details_records($table,$dataa);


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
  

  
}

  
