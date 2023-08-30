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

                          $search=array();
                          $article_no='';
                          if($this->input->post('part_no')!=''){

                            $arr_article=explode("//",$this->input->post('part_no'));
                            $article_no=$arr_article[1];
                            $search['part_no']=$article_no;
                          }

                          // $data=array(
                          //   'jobcard_no'=>$this->input->post('jobcard_no'),
                          //   'status'=>$this->input->post('status'),
                          //   'part_no'=>$article_no
                                    
                          // );



                          if($this->input->post('jobcard_no')!=''){
                            $search['jobcard_no']=$this->input->post('jobcard_no');
                          }
                          if($this->input->post('status')!='--'){
                              $search['status']=$this->input->post('status');
                          }

                          //print_r($search);

                          //$data=array_filter($data);

                          $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,$this->input->post('from_date'),$this->input->post('to_date'));

                          //echo $this->db->last_query();
                          
                          $data['page_name']='Purchase';
                          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                          
                          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
                          
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
    
                  $this->form_validation->set_rules('issue_date','Issue Date' ,'required|xss_clean|callback_issue_date_check');
                  $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|xss_clean');
                  $this->form_validation->set_rules('part_no','Article No.' ,'required|xss_clean|callback_article_check');
                  $this->form_validation->set_rules('qty','Quantity.' ,'required|xss_clean');
                  $this->form_validation->set_rules('status','Status' ,'xss_clean');
                  $this->form_validation->set_rules('remarks','Remarks' ,'xss_clean');

                  if($this->form_validation->run()==FALSE){

                      
                      $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->input->post('id'));

                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                      $this->load->view('Home/footer');

                    }
                    else{
                          
                          $jobcard_no=''; 
                          $so_no='';
                          $pos_no=''; 
                          $mm_id='';
                          $tally_qty=$this->input->post('qty');
                          $issue_qty=''; 
                          $part_no='';
                          $part_no_arr=explode("//", $this->input->post('part_no'));

                          if(count($part_no_arr)==2){
                            $part_no=$part_no_arr[1];
                          }
                          
                          $article_no='';                       

                          if(!empty($this->input->post('jobcard_no')) && $this->input->post('jobcard_no')!=''){                        

                            $arr_jobcard=explode("/",$this->input->post('jobcard_no'));
                            
                            $count=count($arr_jobcard);


                            if($count==3) {

                              $jobcard_no=$arr_jobcard[0];
                              $so_no=$arr_jobcard[1];
                              $pos_no=$arr_jobcard[2];                             


                              $data_tally=array(
                              'issue_date'=>$this->input->post('issue_date'),
                              'part_no'=>$part_no,
                              'qty'=>$this->input->post('qty'),
                              'status'=>$this->input->post('status'),
                              'remarks'=>$this->input->post('remarks')
                              );
                          
                              $result_tally=$this->common_model->update_one_active_record_noncompany('tally_material_issue_master',$data_tally,'id',$this->input->post('id'));
                              //$result_tally=1;

                              if($result_tally && $pos_no!=''){

                                $data_reserved=array('pos_no'=>$pos_no);
                                $reserved_quantity_manu_result=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved);

                                foreach ($reserved_quantity_manu_result as  $reserved_quantity_manu_row) {
                                  $mm_id=$reserved_quantity_manu_row->ref_mm_id;
                                  $issue_qty=$this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
                                  $article_no=$reserved_quantity_manu_row->article_no;
                                }

                                if($pos_no!='' && $mm_id!='' && ($tally_qty!=$issue_qty || $part_no!=$article_no)  ){

                                  $erp_qty=0;
                                  $erp_qty=$this->common_model->save_number($tally_qty,$this->session->userdata['logged_in']['company_id']);

                                  $data_reserved_update=array('qty'=>$erp_qty,
                                    'total_qty'=>$erp_qty,'article_no'=>$part_no,'date_required'=>$this->input->post('issue_date'));

                                  $result_reserved_update=$this->common_model->update_one_active_record('reserved_quantity_manu',$data_reserved_update,'pos_no',$pos_no,$this->session->userdata['logged_in']['company_id']);

                                  $rel_demand_qty=$erp_qty*1000;

                                  $data_material_update=array('demand_qty'=>$erp_qty,'rel_demand_qty'=>$rel_demand_qty,'article_no'=>$part_no);

                                  $result_material_update=$this->common_model->update_one_active_record('material_manufacturing',$data_material_update,'mm_id',$mm_id,$this->session->userdata['logged_in']['company_id']);

                                }
                                else{
                                 $data['error']='Qty and Part no is Same';
                                }

                              }
                                              
                            }else{

                              $data_tally=array(
                              'issue_date'=>$this->input->post('issue_date'),
                              'part_no'=>$part_no,
                              'qty'=>$this->input->post('qty'),
                              'status'=>$this->input->post('status'),
                              'remarks'=>$this->input->post('remarks')
                              );
                          
                              $result_tally=$this->common_model->update_one_active_record_noncompany('tally_material_issue_master',$data_tally,'id',$this->input->post('id'));

                            }

                            



                            //$data['job_card']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
                            //$so_no='';
                            //foreach($data['job_card'] as $job_card_row ){
                              //$so_no=$job_card_row->sales_ord_no;
                            //}

                            //$jobcard_no=$jobcard_no.'/'.$so_no.'/'.rand(1000,9999);


                          

                          // $data=array(
                          //   'issue_date'=>$this->input->post('issue_date'),
                          //   'jobcard_no'=>$jobcard_no,                            
                          //   'part_no'=>$this->input->post('part_no'),
                          //   'qty'=>$this->input->post('qty'),
                          //   'status'=>$this->input->post('status'),
                          //   'remarks'=>$this->input->post('remarks')
                                    
                          // );

                          
                          // $result=$this->common_model->update_one_active_record_noncompany('tally_material_issue_master',$data,'id',$this->input->post('id'));

                        }  

                          //$result=1;
                            if($result_tally==1){

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

    function delete(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Purchase'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
          foreach ($data['formrights'] as $formrights_row){

            if($formrights_row->delete==1){
   
                $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->uri->segment(3));


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/delete-form',$data);
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


  public function delete_save(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Purchase'){


             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {

                if($formrights_row->delete==1){
                  
                          
                  $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->input->post('id'));                  

                    
                foreach ($data['tally_material_issue_master'] as  $row) {

                  $data_archived=array(
                    'id'=>$row->id,
                    'issue_date'=>$row->issue_date,
                    'jobcard_no'=>$row->jobcard_no,                            
                    'part_no'=>$row->part_no,
                    'qty'=>$row->qty,
                    'status'=>$row->status,
                    'remarks'=>$row->remarks,
                    'transaction_date'=>$row->transaction_date                            
                  );
                } 

                $result=$this->common_model->save('tally_material_issue_master_archived_records',$data_archived);       
                  
                $result=$this->common_model->delete_one_active_record_noncompany('tally_material_issue_master','id',$this->input->post('id'));

                  
                    if($result==1){

                      $data['note']='Delete Transaction Completed';

                      $data['page_name']='Purchase';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      

                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                      $this->load->view('Error/error-title',$data);                    
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


  public function issue_date_check($str){
    $new_issue_date=$this->input->post('issue_date');
    $old_issue_date='';

    $data['tally_material_issue_master']=$this->common_model->select_one_details_record_noncompany('tally_material_issue_master','id',$this->input->post('id')); 
    foreach ($data['tally_material_issue_master']as  $tally_material_issue_master_row) {
        $old_issue_date=$tally_material_issue_master_row->issue_date;
    }
    

    if($new_issue_date<$old_issue_date){
      $this->form_validation->set_message('issue_date_check', 'The {field} must be greater than old issue date ');
      return FALSE;
    }else{
      return TRUE;
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
