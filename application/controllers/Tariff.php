<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Tariff extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('tariff_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='excise_rates_master';

    include('pagination.php');

    $data['excise_rates_master']=$this->tariff_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    
    $this->form_validation->set_rules('cetsh_no','Tariff No' ,'required|xss_clean|is_unique[excise_rates_master.cetsh_no]');
    $this->form_validation->set_rules('lang_tariff_heading','Tariff Heading' ,'required|xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_tariff_descr','Tariff Description' ,'xss_clean|max_length[200]|strtoupper');
    
  

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
          $result=$this->common_model->select_max_pkey_numeric('excise_rates_master','erm_id',$this->session->userdata['logged_in']['company_id']); 
          
          foreach($result as $row){

            $max_pkey=$row->erm_id;
          }

          $erm_id=$max_pkey+1;

           
          $data=array('erm_id'=>$erm_id,
                       'cetsh_no'=>$this->input->post('cetsh_no'),                       
                       'archive'=>'0',
                       'company_id'=>$this->session->userdata['logged_in']['company_id']                       
                       );

          $result=$this->common_model->save('excise_rates_master',$data);
          if($result==1){

              $data=array('erm_id'=>$erm_id,
                         'lang_tariff_heading'=>$this->input->post('lang_tariff_heading'),                       
                         'lang_tariff_descr'=>$this->input->post('lang_tariff_descr'),  
                         'company_id'=>$this->session->userdata['logged_in']['company_id'],
                         'language_id'=>$this->session->userdata['logged_in']['language_id']                      
                         );


              $result=$this->common_model->save('excise_rates_master_lang',$data);

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

          }else{

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
   
    $data['excise_rates_master']=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('cetsh_no','Tariff No' ,'required|xss_clean');
    $this->form_validation->set_rules('lang_tariff_heading','Tariff Heading' ,'required|xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_tariff_descr','Tariff Description' ,'xss_clean|max_length[200]|strtoupper');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['excise_rates_master']=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$this->input->post('erm_id'),$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

           $table='excise_rates_master';
           $pkey='erm_id';
           $edit=$this->input->post('erm_id');

           $data=array(
                       'cetsh_no'=>$this->input->post('cetsh_no'),                       
                       );

          $result=$this->tariff_model->update_one_active_record($table,$data,$pkey,$edit,$this->session->userdata['logged_in']['company_id']);

          if($result==1){

             $table='excise_rates_master_lang';
             $pkey='erm_id';
             $edit=$this->input->post('erm_id');

             $data=array(
                         'lang_tariff_heading'=>$this->input->post('lang_tariff_heading'), 
                          'lang_tariff_descr'=>$this->input->post('lang_tariff_descr')                     
                         );

            $result=$this->tariff_model->update_one_active_record($table,$data,$pkey,$edit,$this->session->userdata['logged_in']['company_id']);
            
            if( $result==1){

            $data['note']='Update Transaction Completed';

            $data['excise_rates_master']=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$this->input->post('erm_id'),$this->session->userdata['logged_in']['company_id']);

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

       }else{

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
    $result=$this->tariff_model->update_one_active_record('excise_rates_master',$data,'erm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['excise_rates_master']=$this->tariff_model->select_one_archive_record('excise_rates_master','excise_rates_master.erm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);  

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

    $table='excise_rates_master';

    include('pagination_archive.php');

    $data['excise_rates_master']=$this->tariff_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->tariff_model->update_one_active_record('excise_rates_master',$data,'erm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";
     
      $data['excise_rates_master']=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']); 


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

    $this->form_validation->set_rules('cetsh_no','Tariff No' ,'xss_clean');
    $this->form_validation->set_rules('lang_tariff_heading','Tariff Heading' ,'xss_clean|max_length[50]|strtoupper');
    $this->form_validation->set_rules('lang_tariff_descr','Tariff Description' ,'xss_clean|max_length[200]|strtoupper');
    

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
          $data=array( 'excise_rates_master.cetsh_no'=>$this->input->post('cetsh_no'),
                       'excise_rates_master_lang.lang_tariff_heading'=>$this->input->post('lang_tariff_heading'),
                       'excise_rates_master_lang.lang_tariff_descr'=>$this->input->post('lang_tariff_descr'),
                       
                       );

         
          $data['excise_rates_master']=$this->tariff_model->active_record_search('excise_rates_master',$data,$this->session->userdata['logged_in']['company_id']);

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
