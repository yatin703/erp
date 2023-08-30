<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Shoulder_foil_master extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('shoulder_foil_model');
      $this->load->model('article_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='shoulder_foil_master';

    include('pagination_noncompany.php');

    $data['shoulder_foil_master']=$this->shoulder_foil_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  public function create(){
    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

    $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|xss_clean');
    $this->form_validation->set_rules('sleeve_dia','Sleeve Dia','required|xss_clean');
    $this->form_validation->set_rules('no_of_tubes','No of Tubes','required|xss_clean');
    $this->form_validation->set_rules('one_roll_width_in_meter','Foil Width' ,'required|xss_clean');
    $this->form_validation->set_rules('one_roll_length_in_meter','Foil Length' ,'required|xss_clean');
    $this->form_validation->set_rules('one_roll_sqm_area','Area','required|xss_clean');
    $this->form_validation->set_rules('sqm_per_tube','Area/Tube','required|xss_clean');

  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

      $data=array('article_no'=>$this->input->post('shoulder_foil'),
                      'sleeve_id'=>$this->input->post('sleeve_dia'),
                      'no_of_tubes'=>$this->input->post('no_of_tubes'),
                      'one_roll_width_in_meter'=>$this->input->post('one_roll_width_in_meter'),
                      'one_roll_length_in_meter'=>$this->input->post('one_roll_length_in_meter'),
                      'one_roll_sqm_area'=>$this->input->post('one_roll_sqm_area'),
                      'sqm_per_tube'=>$this->input->post('sqm_per_tube'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id']
                    );


          $result=$this->common_model->save('shoulder_foil_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);

            
            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');

             
          }
          else{

            $data['note']='Error in Save Transaction';

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view('Error/error-title',$data);

            $this->load->view('Home/footer');

        }

    }


    
  }




  function modify(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['shoulder_foil_master']=$this->common_model->select_one_active_record_noncompany('shoulder_foil_master','sfm_id',$this->uri->segment(3));

    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|xss_clean');
    $this->form_validation->set_rules('sleeve_dia','Sleeve Dia','required|xss_clean');
    $this->form_validation->set_rules('no_of_tubes','No of Tubes','required|xss_clean');
    $this->form_validation->set_rules('one_roll_width_in_meter','Foil Width' ,'required|xss_clean');
    $this->form_validation->set_rules('one_roll_length_in_meter','Foil Length' ,'required|xss_clean');
    $this->form_validation->set_rules('one_roll_sqm_area','Area','required|xss_clean');
    $this->form_validation->set_rules('sqm_per_tube','Area/Tube','required|xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['shoulder_foil_master']=$this->common_model->select_one_active_record_noncompany('shoulder_foil_master','sfm_id',$this->input->post('sfm_id'));

      $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('article_no'=>$this->input->post('shoulder_foil'),
                      'sleeve_id'=>$this->input->post('sleeve_dia'),
                      'no_of_tubes'=>$this->input->post('no_of_tubes'),
                      'one_roll_width_in_meter'=>$this->input->post('one_roll_width_in_meter'),
                      'one_roll_length_in_meter'=>$this->input->post('one_roll_length_in_meter'),
                      'one_roll_sqm_area'=>$this->input->post('one_roll_sqm_area'),
                      'sqm_per_tube'=>$this->input->post('sqm_per_tube'));


          $result=$this->common_model->update_one_active_record_noncompany('shoulder_foil_master',$data,'sfm_id',$this->input->post('sfm_id'));
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['shoulder_foil_master']=$this->common_model->select_one_active_record_noncompany('shoulder_foil_master','sfm_id',$this->input->post('sfm_id'));

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']);

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

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
    
  }

  public function delete(){

    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record_noncompany('shoulder_foil_master',$data,'sfm_id',$this->uri->segment(3));
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['shoulder_foil_master']=$this->common_model->select_one_active_record_noncompany('shoulder_foil_master','sfm_id',$this->input->post('sfm_id'));

      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

      $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']); 

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  function archive_records(){

    $table='shoulder_foil_master';

    include('pagination_archive_noncompany.php');

    $data['shoulder_foil_master']=$this->shoulder_foil_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record_noncompany('shoulder_foil_master',$data,'sfm_id',$this->uri->segment(3));

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['shoulder_foil_master']=$this->common_model->select_one_inactive_record_noncompany('shoulder_foil_master','sfm_id',$this->input->post('sfm_id'));

      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']); 

      $data['shoulder_foil']=$this->article_model->spec_all_active_record_search('article','106',$this->session->userdata['logged_in']['company_id']); 


      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Dearchive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }



}
