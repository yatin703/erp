<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_operators extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('springtube_operators_model');
      

		}else{
			redirect('login','refresh');
		}
  }
public function index(){

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='springtube_operator_master';
    include('pagination.php');
    $data['springtube_operator_master']=$this->springtube_operators_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

    $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);    

    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
    $this->load->view('Home/footer');
  }

  public function save(){
    // Eknath--
    $this->form_validation->set_rules('process','Process Name' ,'required|xss_clean');
    $this->form_validation->set_rules('operator','Operator Name' ,'required|xss_clean|strtoupper|is_unique[springtube_operator_master.operator_name]');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);  
      
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
      $this->load->view('Home/footer');
    }
    else{

                     
          $data=array( 'company_id'=>$this->session->userdata['logged_in']['company_id'],
                       'process_id'=>$this->input->post('process'),
                       'operator_name'=>$this->input->post('operator'),                       
                       'archive'=>'0'
                      );


          $result=$this->common_model->save('springtube_operator_master',$data);

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

    $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
     
    $data['springtube_operator_master']=$this->springtube_operators_model->select_one_active_record('springtube_operator_master',$this->session->userdata['logged_in']['company_id'],'springtube_operator_master.operator_id', $this->uri->segment(3));

    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
    $this->load->view('Home/footer');

  }


  public function update(){

    $this->form_validation->set_rules('process','Process Name' ,'required|xss_clean');    
    $this->form_validation->set_rules('operator','Operator Name' ,'required|xss_clean|strtoupper');
   

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
     
      $data['springtube_operator_master']=$this->springtube_operators_model->select_one_active_record('springtube_operator_master',$this->session->userdata['logged_in']['company_id'],'springtube_operator_master.operator_id',$this->input->post('operator_id'));


      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');

    }
    else{

          $data=array(
                       'operator_name'=>$this->input->post('operator'),
                       'process_id'=>$this->input->post('process'),
                                                                     
                      );

          $result=$this->common_model->update_one_active_record('springtube_operator_master',$data,'operator_id',$this->input->post('operator_id'),$this->session->userdata['logged_in']['company_id']);
          //echo $this->db->last_query();
          
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            
            $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
     
            $data['springtube_operator_master']=$this->springtube_operators_model->select_one_active_record('springtube_operator_master',$this->session->userdata['logged_in']['company_id'],'springtube_operator_master.operator_id',$this->input->post('operator_id'));



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
    $result=$this->common_model->update_one_active_record('springtube_operator_master',$data,'operator_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Archive Transaction completed";
      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
     
      $data['springtube_operator_master']=$this->springtube_operators_model->select_one_inactive_record('springtube_operator_master',$this->session->userdata['logged_in']['company_id'],'springtube_operator_master.operator_id', $this->uri->segment(3));

      


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

  function archive_records(){

    $table='springtube_operator_master';

    include('pagination_archive.php');

    $data['springtube_operator_master']=$this->springtube_operators_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
    

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
    $result=$this->common_model->update_one_active_record('springtube_operator_master',$data,'operator_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
     
      $data['springtube_operator_master']=$this->springtube_operators_model->select_one_inactive_record('springtube_operator_master',$this->session->userdata['logged_in']['company_id'],'springtube_operator_master.operator_id', $this->uri->segment(3));


      
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

    $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
        

    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
    $this->load->view('Home/footer');


  }


  public function search_result(){
    // Eknath--
    $this->form_validation->set_rules('process','Process Name' ,'xss_clean');
    $this->form_validation->set_rules('operator','Operator Name' ,'xss_clean');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
      

      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
      $this->load->view('Home/footer');

    }
    else{
          $data=array( 'process_id'=>$this->input->post('process'),
                       'operator_id'=>$this->input->post('operator'),
                      );

          $data=array_filter($data);

          $table='springtube_operator_master';
          //include('pagination.php');

          $data['springtube_operator_master']=$this->springtube_operator_model->active_record_search('springtube_operator_master',$data,$this->session->userdata['logged_in']['company_id']);

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
