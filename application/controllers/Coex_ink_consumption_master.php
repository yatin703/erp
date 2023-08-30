<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_ink_consumption_master extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('Coex_ink_consumption_master_model');
      $this->load->model('artwork_model');
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

            $table='coex_ink_consumption_master';
            include('pagination.php');
            $data['coex_ink_consumption_master']=$this->Coex_ink_consumption_master_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

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


  function delete(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->update_one_active_record('coex_ink_consumption_master',$data,'cicm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $data['coex_ink_consumption_master']=$this->common_model->select_one_active_record('coex_ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'cicm_id',$this->uri->segment(3));
                  

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



  function save(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('product_name_1','Product Name' ,'required|trim|xss_clean|callback_article_check|is_unique[coex_ink_consumption_master.article_no]');
                      

            if($this->form_validation->run()==FALSE){

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              $item_code=explode('//',$this->input->post('product_name_1'));

              if(substr($item_code[1],0,2)=="PS" || substr($item_code[1],0,2)=="SR"){
                        
                  $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','','','ad_id','desc','version_no','desc');

                  $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','','','ad_id','desc','version_no','desc');
                      }else{
                  
                  $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','','','ad_id','desc','version_no','desc');

                  $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','','','ad_id','desc','version_no','desc');
                  
                  }
                     
                  if($data['artwork_final_nonapproved_version_no']==FALSE){
                      $nonapproved_version=0;
                    }else{
                      foreach ($data['artwork_final_nonapproved_version_no'] as $artwork_final_nonapproved_version_no_row){
                        $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
                        }
                      } 

                      
                      
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

                        if($data['artwork_final_version_no']==FALSE){
                          $artwork_no='';
                          $artwork_version_no='';
                        }else{
                          foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                            $artwork_no=$artwork_final_version_no_row->ad_id;
                            $artwork_version_no=$this->input->post('version_no');
                          }     
                      }

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

                    



              $data=array(
                'entry_date'=>date('Y-m-d'),
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'article_no'=>$item_code[1],
                'artwork_no'=>$artwork_no,
                'artwork_version_no'=>$artwork_version_no,
                'flexo_ink_gm_tube'=>$this->input->post('flexo_ink_gm_tube'),
                'screen_ink_gm_tube'=>$this->input->post('screen_ink_gm_tube'),
                'offset_ink_gm_tube'=>$this->input->post('offset_ink_gm_tube'),
                'special_ink_gm_tube'=>$this->input->post('special_ink_gm_tube')
              );

              $result=$this->common_model->save('coex_ink_consumption_master',$data);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

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
}


function modify(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'coex_ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
           
            $data['coex_ink_consumption_master']=$this->common_model->select_one_active_record('coex_ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'cicm_id',$this->uri->segment(3));

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


public function update(){
    $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'coex_ink_consumption_master');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

          $this->form_validation->set_rules('product_name_1','Product Name' ,'required|trim|xss_clean|callback_article_check');
          
          
          if($this->form_validation->run()==FALSE){

          
           
            $data['coex_ink_consumption_master']=$this->common_model->select_one_active_record('coex_ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'cicm_id',$this->input->post('cicm_id'));

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');

          }
          else{

            $item_code=explode('//',$this->input->post('product_name_1'));
            /*
           if(substr($item_code[1],0,2)=="PS" || substr($item_code[1],0,2)=="SR"){
                        
                  $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','','','ad_id','desc','version_no','desc');

                  $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','','','ad_id','desc','version_no','desc');
                      }else{
                  
                  $data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','0','archive<>','1','','','ad_id','desc','version_no','desc');

                  $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1],'final_approval_flag','1','archive<>','1','','','ad_id','desc','version_no','desc');
                  
                  }
                     
                  if($data['artwork_final_nonapproved_version_no']==FALSE){
                      $nonapproved_version=0;
                    }else{
                      foreach ($data['artwork_final_nonapproved_version_no'] as $artwork_final_nonapproved_version_no_row){
                        $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
                        }
                      } 

                      
                      
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

                        if($data['artwork_final_version_no']==FALSE){
                          $artwork_no='';
                          $artwork_version_no='';
                        }else{
                          foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                            $artwork_no=$artwork_final_version_no_row->ad_id;
                            $artwork_version_no=$this->input->post('version_no');
                          }     
                      }

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
              */


              $data=array(
                'entry_date'=>date('Y-m-d'),
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'article_no'=>$item_code[1],
                'artwork_no'=>$this->input->post('artwork_no'),
                'artwork_version_no'=>$this->input->post('version_no'),
                'flexo_ink_gm_tube'=>$this->input->post('flexo_ink_gm_tube'),
                'screen_ink_gm_tube'=>$this->input->post('screen_ink_gm_tube'),
                'offset_ink_gm_tube'=>$this->input->post('offset_ink_gm_tube'),
                'special_ink_gm_tube'=>$this->input->post('special_ink_gm_tube')
              );

              $result=$this->common_model->update_one_active_record('coex_ink_consumption_master',$data,'cicm_id',$this->input->post('cicm_id'),$this->session->userdata['logged_in']['company_id']);
              
              if($result==1){

                  $data['note']='Update Transaction Completed';

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $data['coex_ink_consumption_master']=$this->common_model->select_one_active_record('coex_ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'cicm_id',$this->input->post('cicm_id'));

                  $data['page_name']='Sales';

                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                   $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $this->load->view('Home/header');

                  $this->load->view('Home/nav',$data);

                  $this->load->view('Home/subnav');

                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

                  $this->load->view('Home/footer');


              }
              else{

                $data['note']='Error in Update Transaction';

                $data['page_name']='setup';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');

                $this->load->view('Home/nav',$data);

                $this->load->view('Home/subnav');

                $this->load->view('Error/error-title',$data);

                $this->load->view('Home/footer');

              }

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

   function search(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('article_no','Product Name' ,'trim|xss_clean|callback_article_check');
            if($this->form_validation->run()==FALSE){
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
              $data=array('article_no'=>$item_code[1],'artwork_no'=>$this->input->post('artwork_no'));
              $data = array_filter($data);
              $data['coex_ink_consumption_master']=$this->common_model->active_record_search('coex_ink_consumption_master',$data,$this->session->userdata['logged_in']['company_id']);
             $data['page_name']='Sales';
             $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');


          }
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