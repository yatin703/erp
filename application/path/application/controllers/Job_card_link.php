<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_card_link extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('job_card_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('artwork_model');
      $this->load->model('article_model');
      $this->load->model('process_model');
      $this->load->model('fiscal_model');
      $this->load->model('sales_order_item_parameterwise_model');

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

  function create(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['job_card']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->uri->segment(3));

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

  function save(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('mp_pos_no','Jobcard No.' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('so_no','New Sales Order No.' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','New Article No.' ,'required|trim|xss_clean');
            
            $this->form_validation->set_rules('comment','Comment' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){


              $data['job_card']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('mp_pos_no'));


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                $this->load->view('Home/footer');

            }
            else{

              $jobcard_no=$this->input->post('mp_pos_no');
              $new_so=$this->input->post('so_no');
              $new_article_no=$this->input->post('article_no');

              $data=array(
                          'sales_ord_no'=>$new_so,
                          'article_no'=>$this->input->post('article_no'),
                          'comment'=>$this->input->post('comment'),
                          'old_so_no'=>$this->input->post('sales_ord_no')
                        );
              $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$this->input->post('mp_pos_no'),$this->session->userdata['logged_in']['company_id']);

              if($result){

                // COEX-----------------------------------------------------

                $con=mysqli_connect('192.168.0.9','root','password','twerp');
                //---Extrusion
                $sql_extrusion="SELECT * FROM `extrusion` WHERE job_card_no='".$jobcard_no."'";
                $result_extrusion=mysqli_query($con,$sql_extrusion);
                if(mysqli_num_rows($result_extrusion)>0){
                  $sql_ext_update="update extrusion set so_no='".$new_so."',psp_psm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_ext_update=mysqli_query($con,$sql_ext_update);

                }


                //---Heading
                $sql_heading="SELECT * FROM `heading` WHERE job_card_no='".$jobcard_no."'";
                $result_heading=mysqli_query($con,$sql_heading);
                if(mysqli_num_rows($result_heading)>0){
                  $sql_hed_update="update heading set so_no='".$new_so."' ,psppsm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_hed_update=mysqli_query($con,$sql_hed_update);

                }

                //---Printing
                $sql_printing="SELECT * FROM `printing` WHERE job_card_no='".$jobcard_no."'";
                $result_printing=mysqli_query($con,$sql_printing);
                if(mysqli_num_rows($result_printing)>0){
                  $sql_pri_update="update printing set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_pri_update=mysqli_query($con,$sql_pri_update);

                }


                //---Labeling
                $sql_labeling="SELECT * FROM `labeling` WHERE job_card_no='".$jobcard_no."'";
                $result_labeling=mysqli_query($con,$sql_labeling);
                if(mysqli_num_rows($result_labeling)>0){
                  $sql_lab_update="update labeling set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_lab_update=mysqli_query($con,$sql_lab_update);

                }


                //---Capping
                $sql_capping="SELECT * FROM `capping` WHERE job_card_no='".$jobcard_no."'";
                $result_capping=mysqli_query($con,$sql_capping);
                if(mysqli_num_rows($result_capping)>0){
                  $sql_cap_update="update capping set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_cap_update=mysqli_query($con,$sql_cap_update);

                }


                //---Foiling
                $sql_foiling="SELECT * FROM `foiling` WHERE job_card_no='".$jobcard_no."'";
                $result_foiling=mysqli_query($con,$sql_foiling);
                if(mysqli_num_rows($result_foiling)>0){
                  $sql_foil_update="update foiling set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE job_card_no='".$jobcard_no."'";

                  $result_foil_update=mysqli_query($con,$sql_foil_update);

                }

                //---AQL---------------------Added on 23 aug-2021--------------

                $sql_aql="SELECT * FROM `aql` WHERE jobcard_no='".$jobcard_no."'";
                $result_aql=mysqli_query($con,$sql_aql);
                if(mysqli_num_rows($result_aql)>0){
                  $sql_aql_update="update aql set order_no='".$new_so."',article_no='".$new_article_no."' WHERE jobcard_no='".$jobcard_no."'";

                  $result_aql_update=mysqli_query($con,$sql_aql_update);

                }

                //---RFD---------------------Added on 23 aug-2021--------------
                $sql_rfd="SELECT * FROM `rfd` WHERE jobcard_no='".$jobcard_no."'";
                $result_rfd=mysqli_query($con,$sql_rfd);
                if(mysqli_num_rows($result_rfd)>0){
                  $sql_rfd_update="update rfd set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE jobcard_no='".$jobcard_no."'";

                  $result_rfd_update=mysqli_query($con,$sql_rfd_update);

                }

                //---RFD---------------------Added on 23 aug-2021--------------
                $sql_rfd_new="SELECT * FROM `rfd_new` WHERE jobcard_no='".$jobcard_no."'";
                $result_rfd_new=mysqli_query($con,$sql_rfd_new);
                if(mysqli_num_rows($result_rfd_new)>0){
                  $sql_rfd_new_update="update rfd_new set so_no='".$new_so."',psppsm_no='".$new_article_no."' WHERE jobcard_no='".$jobcard_no."'";

                  $result_rfd_new_update=mysqli_query($con,$sql_rfd_new_update);

                }


                //SPRINGTUBE Production Update-----------------------------------------

                $table_array=array(
                  "springtube_extrusion_production_details",
                  "springtube_extrusion_qc_master",
                  "springtube_extrusion_scrap_master",
                  "springtube_extrusion_wip_master",
                  "springtube_printing_production_master",
                  "springtube_printing_jobsetup_master",
                  "springtube_printing_inspection_details",
                  "springtube_printing_wip_master_after",
                  "springtube_bodymaking_production_details",
                  "springtube_bodymaking_qc_master",
                  "springtube_bodymaking_scrap_master",
                  "springtube_bodymaking_wip_master",
                  "springtube_aql_rfd_master",
                  "springtube_rfd_master"
                );

                foreach ($table_array as  $table) {

                  $sql="select * from ".$table." where jobcard_no='".$jobcard_no."'";      
                  $query=$this->db->query($sql);
                  $result1=$query->result();
                  if($result1){
                    $sql_update="update ".$table." set order_no='".$new_so."', article_no='".$new_article_no."' WHERE jobcard_no='".$jobcard_no."';";
                    //echo "<br/>";
                    $query2=$this->db->query($sql_update);
                    //$query->result();
                   
                  }
                }

                $data['note']='Save Transaction Completed';

              }


            $data['job_card']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('mp_pos_no'));

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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


  function search(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

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

  

}
