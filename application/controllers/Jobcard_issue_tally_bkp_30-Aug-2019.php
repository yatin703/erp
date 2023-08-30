<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobcard_issue_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){

      $this->load->model('common_model');
      $this->load->model('jobcard_issue_tally_model');
      $this->load->model('article_model');
      $this->load->model('job_card_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Purchase'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
          foreach ($data['formrights'] as $formrights_row){

            if($formrights_row->view==1){
   
              $table='tally_material_issue_master';
              include('pagination_tally.php');
              $data['tally_material_issue_master']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

            	$this->load->view('Home/header');
            	$this->load->view('Home/nav',$data);
            	$this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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

  public function search(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Purchase'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
          foreach ($data['formrights'] as $formrights_row){

            if($formrights_row->view==1){

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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


  public function search_result(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Purchase'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {

                if($formrights_row->view==1){
    
                  $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
                  $this->form_validation->set_rules('to_date','To Date' ,'xss_clean');
                  $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'xss_clean');
                  $this->form_validation->set_rules('status','Status' ,'xss_clean');
                  $this->form_validation->set_rules('part_no','Article No.' ,'xss_clean');

                    if($this->form_validation->run()==FALSE){

                      
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');

                    }
                    else{

                          $article_no='';
                          if($this->input->post('part_no')!=''){

                            $arr_article=explode("//",$this->input->post('part_no'));
                            $article_no=$arr_article[1];
                          }

                          $data=array(
                            'jobcard_no'=>$this->input->post('jobcard_no'),
                            'status'=>$this->input->post('status'),
                            'part_no'=>$article_no
                                    
                          );

                          $data=array_filter($data);

                          $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$data,$this->input->post('from_date'),$this->input->post('to_date'));
                          
                          $data['page_name']='Purchase';
                          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                          
                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Purchase'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
          foreach ($data['formrights'] as $formrights_row){

            if($formrights_row->modify==1){
   
                $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->uri->segment(3));


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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



    public function update(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Purchase'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {

                if($formrights_row->modify==1){
    
                  $this->form_validation->set_rules('issue_date','Issue Date' ,'required|xss_clean');
                  $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|xss_clean');
                  $this->form_validation->set_rules('part_no','Article No.' ,'required|xss_clean');
                  $this->form_validation->set_rules('qty','Quantity.' ,'required|xss_clean');
                  $this->form_validation->set_rules('status','Status' ,'xss_clean');
                  $this->form_validation->set_rules('remarks','Remarks' ,'xss_clean');

                    if($this->form_validation->run()==FALSE){

                      
                      $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->uri->segment(3));

                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                      $this->load->view('Home/footer');

                    }
                    else{
                          
                          $jobcard_no='';

                          if($this->input->post('jobcard_no')!=''){

                            $arr_jobcard=explode("/",$this->input->post('jobcard_no'));
                            $jobcard_no=$arr_jobcard[0];

                            $data['job_card']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
                            $so_no='';
                            foreach($data['job_card'] as $job_card_row ){
                              $so_no=$job_card_row->sales_ord_no;
                            }

                            $jobcard_no=$jobcard_no.'/'.$so_no.'/'.rand(1000,9999);
                          }

                          $data=array(
                            'issue_date'=>$this->input->post('issue_date'),
                            'jobcard_no'=>$jobcard_no,                            
                            'part_no'=>$this->input->post('part_no'),
                            'qty'=>$this->input->post('qty'),
                            'status'=>$this->input->post('status'),
                            'remarks'=>$this->input->post('remarks')
                                    
                          );

                          
                          $result=$this->common_model->update_one_active_record_noncompany('tally_material_issue_master',$data,'id',$this->input->post('id'));

                          
                            if($result==1){

                              $data['note']='Update Transaction Completed';

                              $data['page_name']='Purchase';
                              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                              
                              $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->input->post('id'));

                              $this->load->view('Home/header');
                              $this->load->view('Home/nav',$data);
                              $this->load->view('Home/subnav');
                              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                              $this->load->view('Home/footer');

                            }else{

                                $data['note']='Error in Update Transaction';
                                
                                $data['page_name']='Purchase';
                                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                                
                                

                                $this->load->view('Home/header');
                                $this->load->view('Home/nav',$data);
                                $this->load->view('Home/subnav');
                                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                                $this->load->view('Error/error-title',$data);
                                $this->load->view('Home/footer');

                            }
                          

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








}
