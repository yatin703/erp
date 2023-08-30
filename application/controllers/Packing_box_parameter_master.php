<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Packing_box_parameter_master extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){
      $this->load->model('common_model');
      $this->load->model('packing_box_parameter_model');
      $this->load->model('article_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='packing_box_parameter_master';

    include('pagination_noncompany.php');

    $data['packing_box_parameter_master']=$this->packing_box_parameter_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('packing_box','Packing Box' ,'required|xss_clean');
    $this->form_validation->set_rules('packing_box_type','Packign Box Type','required|xss_clean');
    $this->form_validation->set_rules('packing_box_height','Packing Box Height','required|xss_clean');
    $this->form_validation->set_rules('ply','Ply','xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

      $data=array('article_no'=>$this->input->post('packing_box'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'type'=>$this->input->post('packing_box_type'),
                      'height'=>$this->input->post('packing_box_height'),
                      'ply'=>$this->input->post('ply'));


          $result=$this->common_model->save('packing_box_parameter_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            
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
   
    $data['packing_box_parameter_master']=$this->common_model->select_one_active_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],'pbp_id',$this->uri->segment(3));
    $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('packing_box','Packing Box' ,'required|xss_clean');
    $this->form_validation->set_rules('packing_box_type','Packign Box Type','required|xss_clean');
    $this->form_validation->set_rules('packing_box_height','Packing Box Height','required|xss_clean');
    $this->form_validation->set_rules('ply','Ply','xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['packing_box_parameter_master']=$this->common_model->select_one_active_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],'pbp_id',$this->input->post('pbp_id'));
        $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('article_no'=>$this->input->post('packing_box'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'type'=>$this->input->post('packing_box_type'),
                      'height'=>$this->input->post('packing_box_height'),
                      'ply'=>$this->input->post('ply'));


          $result=$this->common_model->update_one_active_record('packing_box_parameter_master',$data,'pbp_id',$this->input->post('pbp_id'),$this->session->userdata['logged_in']['company_id']);
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['packing_box_parameter_master']=$this->common_model->select_one_active_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],'pbp_id',$this->input->post('pbp_id'));

            $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->common_model->update_one_active_record('packing_box_parameter_master',$data,'pbp_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['packing_box_parameter_master']=$this->common_model->select_one_inactive_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],'pbp_id',$this->uri->segment(3));

       $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);  

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

    $table='packing_box_parameter_master';

    include('pagination_archive.php');

    $data['packing_box_parameter_master']=$this->packing_box_parameter_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->common_model->update_one_active_record('packing_box_parameter_master',$data,'pbp_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['packing_box_parameter_master']=$this->common_model->select_one_active_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],'pbp_id',$this->uri->segment(3));
     
       $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']); 


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

  public function search(){
    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');
  }

   public function search_result(){
    
    $this->form_validation->set_rules('packing_box','Packing Box' ,'xss_clean');
    $this->form_validation->set_rules('packing_box_type','Packign Box Type','xss_clean');
    $this->form_validation->set_rules('packing_box_height','Packing Box Height','xss_clean');
    $this->form_validation->set_rules('ply','Ply','xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

      $data=array('article_no'=>$this->input->post('packing_box'),
                  'type'=>$this->input->post('packing_box_type'),
                  'height'=>$this->input->post('packing_box_height'),
                  'ply'=>$this->input->post('ply')
                );


      
      $data['packing_box_parameter_master']=$this->packing_box_parameter_model->active_record_search('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],$data);

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

      $this->load->view('Home/footer');

          

    }


    
  }



}
