<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Uom extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('uom_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='uom_master';

    include('pagination_noncompany.php');

    $data['uom']=$this->uom_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['language_id']);

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

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('uom_id','UOM Id' ,'required|xss_clean|strtoupper|is_unique[uom_master.uom_id]');
    $this->form_validation->set_rules('lang_uom_desc','Description' ,'required|xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_uom_short','Short Id' ,'xss_clean|max_length[200]|strtoupper');
    
  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $max_pkey=0;
          $result=$this->common_model->select_max_pkey_noncompany('uom_master','uom_id'); 
          
          foreach($result as $row){

            $max_pkey=$row->uom_id;
          }

          $uom_id=$max_pkey+1;

           
          $data=array('uom_id'=>$uom_id,
                       'lang_uom_desc'=>$this->input->post('lang_uom_desc'),
                       'lang_uom_short'=>$this->input->post('lang_uom_short'),
                       'archive'=>'0',
                       'language_id'=>$this->session->userdata['logged_in']['language_id']
                       );

          $result=$this->common_model->save('uom_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

             redirect('/'.$this->router->fetch_class());
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
   
    $data['uom']=$this->uom_model->select_one_active_record('uom_master','uom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('uom_id','UOM Id' ,'required|xss_clean|strtoupper');
    $this->form_validation->set_rules('lang_uom_desc','Description' ,'required|xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_uom_short','Short Id' ,'xss_clean|max_length[200]|strtoupper');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['uom']=$this->uom_model->select_one_active_record('uom_master','uom_id',$this->input->post('uom_id'),$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

           $data=array(
                       'lang_uom_desc'=>$this->input->post('lang_uom_desc'),
                       'lang_uom_short'=>$this->input->post('lang_uom_short'),
                       
                       );


          $result=$this->uom_model->update_one_active_record('uom_master',$data,'uom_id',$this->input->post('uom_id'),$this->session->userdata['logged_in']['language_id']);
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            $data['uom']=$this->uom_model->select_one_active_record('uom_master','uom_id',$this->input->post('uom_id'),$this->session->userdata['logged_in']['language_id']);

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
    $result=$this->uom_model->update_one_active_record('uom_master',$data,'uom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['uom']=$this->uom_model->select_one_active_record('uom_master','uom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);  

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

    $table='uom_master';

    include('pagination_archive_noncompany.php');

    $data['uom']=$this->uom_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['language_id']);

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
    $result=$this->uom_model->update_one_active_record('uom_master',$data,'uom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";
     
      $data['uom']=$this->uom_model->select_one_active_record('uom_master','uom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']); 


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

  public function search(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    $this->form_validation->set_rules('uom_id','UOM Id' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('lang_uom_desc','Description' ,'xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_uom_short','Short Id' ,'xss_clean|max_length[200]|strtoupper');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array( 'uom_id'=>$this->input->post('uom_id'),
                       'lang_uom_desc'=>$this->input->post('lang_uom_desc'),
                       'lang_uom_short'=>$this->input->post('lang_uom_short'),
                       
                       );

          $data['uom']=$this->uom_model->active_record_search('uom_master',$data,$this->session->userdata['logged_in']['language_id']);

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
