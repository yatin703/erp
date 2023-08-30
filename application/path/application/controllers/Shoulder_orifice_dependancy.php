<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Shoulder_orifice_dependancy extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('shoulder_orifice_dependancy_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='shoulder_orifice_dependancy';

    include('pagination.php');

    $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    //echo $this->db->last_query();

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


    $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){

  
    $this->form_validation->set_rules('sleeve_id','Sleeve Diameter' ,'required|xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_type_id','Shoulder type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_orifice_id','Shoulder Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_dia_id','Cap Diameter' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_orifice_id','Cap Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_type_id','Cap Type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_finish_id','Cap finish' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_no','Cap No.' ,'xss_clean');
    $this->form_validation->set_rules('shld_weight','Shoulder Weight' ,'xss_clean');
    $this->form_validation->set_rules('cap_height','Cap Height' ,'xss_clean');


    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $max_pkey=0;

          $result=$this->common_model->select_max_pkey_numeric('shoulder_orifice_dependancy','sod_id',$this->session->userdata['logged_in']['company_id']); 
          //echo $this->db->last_query();
          
          foreach($result as $row){

            $max_pkey=$row->sod_id;
          }

          $sod_id=$max_pkey+1;

          $shld_weight=$this->input->post('shld_weight')*100;
          $cap_height=$this->input->post('cap_height')*100;
           
          $data=array( 'company_id'=>$this->session->userdata['logged_in']['company_id'],
                       'sod_id'=>$sod_id,
                       'sleeve_id'=>$this->input->post('sleeve_id'),
                       'shld_type_id'=>$this->input->post('shld_type_id'),
                       'shld_orifice_id'=>$this->input->post('shld_orifice_id'),
                       'cap_dia_id'=>$this->input->post('cap_dia_id'),
                       'cap_orifice_id'=>$this->input->post('cap_orifice_id'),
                       'cap_type_id'=>$this->input->post('cap_type_id'),
                       'cap_finish_id'=>$this->input->post('cap_finish_id'),
                       'cap_no'=>$this->input->post('cap_no'),
                       'shld_weight'=>$shld_weight,
                       'cap_height'=>$cap_height,
                       'archive'=>'0'
                      );


          $result=$this->common_model->save('shoulder_orifice_dependancy',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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
   
    $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->select_one_active_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],'sod_id',$this->uri->segment(3));


    $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);



    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('sleeve_id','Sleeve Diameter' ,'required|xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_type_id','Shoulder type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_orifice_id','Shoulder Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_dia_id','Cap Diameter' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_orifice_id','Cap Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_type_id','Cap Type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_finish_id','Cap finish' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_no','Cap No.' ,'xss_clean');
    $this->form_validation->set_rules('shld_weight','Shoulder Weight' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_height','Cap Height' ,'xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->select_one_active_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],'sod_id',$this->input->post('sod_id'));

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          
          $shld_weight=$this->input->post('shld_weight')*100;
          $cap_height=$this->input->post('cap_height')*100;

          $data=array(
                       'sleeve_id'=>$this->input->post('sleeve_id'),
                       'shld_type_id'=>$this->input->post('shld_type_id'),
                       'shld_orifice_id'=>$this->input->post('shld_orifice_id'),
                       'cap_dia_id'=>$this->input->post('cap_dia_id'),
                       'cap_orifice_id'=>$this->input->post('cap_orifice_id'),
                       'cap_type_id'=>$this->input->post('cap_type_id'),
                       'cap_finish_id'=>$this->input->post('cap_finish_id'),
                       'cap_no'=>$this->input->post('cap_no'),
                       'shld_weight'=>$shld_weight,
                       'cap_height'=>$cap_height                                             
                       );


          $result=$this->common_model->update_one_active_record('shoulder_orifice_dependancy',$data,'sod_id',$this->input->post('sod_id'),$this->session->userdata['logged_in']['company_id']);
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->select_one_active_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],'sod_id',$this->input->post('sod_id'));

            $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);



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
    $result=$this->common_model->update_one_active_record('shoulder_orifice_dependancy',$data,'sod_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['shoulder_orifice_dependancy']=$this->common_model->select_one_inactive_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],'sod_id',$this->uri->segment(3));

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);



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

    $table='shoulder_orifice_dependancy';

    include('pagination_archive.php');

    $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
    

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
    $result=$this->common_model->update_one_active_record('shoulder_orifice_dependancy',$data,'sod_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['shoulder_orifice_dependancy']=$this->common_model->select_one_active_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'] ,'sod_id',$this->uri->segment(3));

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']); 


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

    $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
    $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    $this->form_validation->set_rules('sleeve_id','Sleeve Diameter' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_type_id','Shoulder type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('shld_orifice_id','Shoulder Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_dia_id','Cap Diameter' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_orifice_id','Cap Orifice' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_type_id','Cap Type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_finish_id','Cap finish' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_no','Cap No.' ,'xss_clean');
    $this->form_validation->set_rules('shld_weight','Shoulder Weight' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('cap_height','Cap Height' ,'xss_clean');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
      $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);



      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array( 'sleeve_id'=>$this->input->post('sleeve_id'),
                       'shld_type_id'=>$this->input->post('shld_type_id'),
                       'shld_orifice_id'=>$this->input->post('shld_orifice_id'),
                       'cap_dia_id'=>$this->input->post('cap_dia_id'),
                       'cap_orifice_id'=>$this->input->post('cap_orifice_id'),
                       'cap_type_id'=>$this->input->post('cap_type_id'),
                       'cap_finish_id'=>$this->input->post('cap_finish_id'),
                       'cap_no'=>$this->input->post('cap_no'),
                       'shld_weight'=>$this->input->post('shld_weight'),
                       'cap_height'=>$this->input->post('cap_height')
                      );

    $table='shoulder_orifice_dependancy';
    //include('pagination.php');

          $data['shoulder_orifice_dependancy']=$this->shoulder_orifice_dependancy_model->active_record_search(/*$config["per_page"], $this->uri->segment(3),*/'shoulder_orifice_dependancy',$data,$this->session->userdata['logged_in']['company_id']);

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
